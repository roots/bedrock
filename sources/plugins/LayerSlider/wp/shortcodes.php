<?php


function layerslider($id = 0, $filters = '') {
	echo LS_Shortcode::handleShortcode(array('id' => $id, 'filters' => $filters));
}

class LS_Shortcode {

	// List of already included sliders on page.
	// Using to identify duplicates and give them
	// a unique slider ID to avoid issues with caching.
	public static $slidersOnPage = array();

	private function __construct() {}


	/**
	 * Registers the LayerSlider shortcode.
	 *
	 * @since 5.3.3
	 * @access public
	 * @return void
	 */

	public static function registerShortcode() {
		if(!shortcode_exists('layerslider')) {
			add_shortcode('layerslider', array(__CLASS__, 'handleShortcode'));
		}
	}




	/**
	 * Handles the shortcode workflow to display the
	 * appropriate content.
	 *
	 * @since 5.3.3
	 * @access public
	 * @param array $atts Shortcode attributes
	 * @return bool True on successful validation, false otherwise
	 */

	public static function handleShortcode($atts = array()) {

		if(self::validateFilters($atts)) {

			$output = '';
			$item = self::validateShortcode($atts);

			// Show error messages (if any)
			if( ! empty( $item['error'] ) ) {

				// Bail out early if the visitor has no permission to see error messages
				if( ! current_user_can(get_option('layerslider_custom_capability', 'manage_options')) ) {
					return '';
				}

				$output .= $item['error'];
			}


			if( $item['data'] ) {

				// Print cached markup
				if( is_string($item['data']) ) {
					$output .= $item['data'];

				// Otherwise continue processing the shortcode
				} else {
					$output .= self::processShortcode( $item['data'] );
				}
			}

			return $output;
		}
	}




	/**
	 * Validates the provided shortcode filters (if any).
	 *
	 * @since 5.3.3
	 * @access public
	 * @param array $atts Shortcode attributes
	 * @return bool True on successful validation, false otherwise
	 */

	public static function validateFilters($atts = array()) {

		// Bail out early and pass the validation
		// if there aren't filters provided
		if(empty($atts['filters'])) {
			return true;
		}

		// Gather data needed for filters
		$pages = explode(',', $atts['filters']);
		$currSlug = basename(get_permalink());
		$currPageID = (string) get_the_ID();

		foreach($pages as $page) {

			if(($page == 'homepage' && is_front_page())
				|| $currPageID == $page
				|| $currSlug == $page
				|| in_category($page)
			) {
				return true;
			}
		}

		// No filters matched,
		// return false
		return false;
	}



	/**
	 * Validates the shortcode parameters and checks
	 * the references slider.
	 *
	 * @since 5.3.3
	 * @access public
	 * @param array $atts Shortcode attributes
	 * @return bool True on successful validation, false otherwise
	 */

	public static function validateShortcode($atts = array()) {

		$error = false;
		$data = false;

		// Has ID attribute
		if(!empty($atts['id'])) {

			// Attempt to retrieve the pre-generated markup
			// set via the Transients API
			if(get_option('ls_use_cache', true)) {
				if($markup = get_transient('ls-slider-data-'.intval($atts['id']))) {
					$markup['id'] = intval($atts['id']);
					$markup['_cached'] = true;
					$data = $markup;
				}
			}

			// Slider exists and isn't deleted
			if( $slider = LS_Sliders::find($atts['id']) ) {
				$data =  $slider;
			}

			// ERROR: No slider with ID was found
			if( empty($slider) ) {
				$error = self::generateErrorMarkup(
					__('The slider cannot be found', 'LayerSlider'),
					null
				);

			// ERROR: The slider is not published
			} elseif( (int)$slider['flag_hidden'] ) {
				$error = self::generateErrorMarkup(
					__('Unpublished slider', 'LayerSlider'),
					__("The slider you've inserted here is yet to be published, thus it won't be displayed to your visitors. You can publish it by enabling the appropriate option in ", "LayerSlider").'<a href="'.admin_url('admin.php?page=layerslider&action=edit&id='.(int)$slider['id'].'&showsettings=1#publish').'" target="_blank">'.__("Slider Settings -> Publish", 'LayerSlider').'</a>.',
					'dashicons-hidden'
				);

			// ERROR: The slider was removed
			} elseif( (int)$slider['flag_deleted'] ) {
				$error = self::generateErrorMarkup(
					__('Removed slider', 'LayerSlider'),
					__("The slider you've inserted here was removed in the meantime, thus it won't be displayed to your visitors. This slider is still recoverable on the admin interface. You can enable listing removed sliders with the Screen Options -> Removed sliders option, then choose the Restore option for the corresponding item to reinstate this slider, or just click ", "LayerSlider") . "<a href=".admin_url('admin.php') . wp_nonce_url('?page=layerslider&action=restore&id='.$slider['id'].'&ref='.urlencode(get_permalink()), 'restore_'.$slider['id']).">here</a>.",
					'dashicons-trash'
				);

			// ERROR: Scheduled sliders
			} else {

				$tz = date_default_timezone_get();
				$siteTz = get_option('timezone_string', 'UTC');
				$siteTz = $siteTz ? $siteTz : 'UTC';
				date_default_timezone_set( $siteTz );

				if( ! empty($slider['schedule_start']) && (int) $slider['schedule_start'] > time() ) {
					$error = self::generateErrorMarkup(
						__('This slider is scheduled to display on '. date_i18n(get_option('date_format').' @ '.get_option('time_format'), (int) $slider['schedule_start']), 'LayerSlider'),
						'', 'dashicons-calendar-alt', 'scheduled'
					);
				} elseif( ! empty($slider['schedule_end']) && (int) $slider['schedule_end'] < time() ) {
					$error = self::generateErrorMarkup(
						__('This slider was scheduled to hide on '. date_i18n(get_option('date_format').' @ '.get_option('time_format'), (int) $slider['schedule_end']), 'LayerSlider'),
						__('Due to scheduling, this slider is no longer visible to your visitors. If you wish to reinstate this slider, just remove the schedule in ', 'LayerSlider').'<a href="'.admin_url('admin.php?page=layerslider&action=edit&id='.(int)$slider['id'].'&showsettings=1#publish').'" target="_blank">'.__('Slider Settings -> Publish', 'LayerSlider').'</a>.',
						'dashicons-no-alt', 'dead'
					);
				}

				date_default_timezone_set( $tz );
			}

		// ERROR: No slider ID was provided
		} else {
			$error = self::generateErrorMarkup();
		}

		return array(
			'error' => $error,
			'data' => $data
		);
	}





	public static function processShortcode($slider) {

		// Slider ID
		$sID = 'layerslider_'.$slider['id'];

		// Include init code in the footer?
		$condsc = get_option('ls_conditional_script_loading', false) ? true : false;
		$footer = get_option('ls_include_at_footer', false) ? true : false;
		$footer = $condsc ? true : $footer;

		// Check if the returned data is a string,
		// indicating that it's a pre-generated
		// slider markup retrieved via Transients
		if(!empty($slider['_cached'])) { $output = $slider;}
		else {
			$output = self::generateSliderMarkup($slider);
			set_transient('ls-slider-data-'.$slider['id'], $output, HOUR_IN_SECONDS * 6);
		}

		// Replace slider ID to avoid issues with enabled caching when
		// adding the same slider to a page in multiple times
		if(array_key_exists($slider['id'], self::$slidersOnPage)) {
			$sliderCount = ++self::$slidersOnPage[ $slider['id'] ];
			$output['init'] = str_replace($sID, $sID.'_'.$sliderCount, $output['init']);
			$output['container'] = str_replace($sID, $sID.'_'.$sliderCount, $output['container']);

		} else {

			// Add current slider ID to identify duplicates later on
			// and give them a unique slider ID to avoid issues with caching.
			self::$slidersOnPage[ $slider['id'] ] = 1;
		}

		// Unify the whole markup after any potential string replacement
		$output['markup'] = $output['container'].$output['markup'];

		// Filter to override the printed HTML markup
		if(has_filter('layerslider_slider_markup')) {
			$output['markup'] = apply_filters('layerslider_slider_markup', $output['markup']);
		}

		if($footer) {
			$GLOBALS['lsSliderInit'][] = $output['init'];
			return $output['markup'];
		} else {
			return $output['init'].$output['markup'];
		}
	}



	public static function generateSliderMarkup($slider = null) {

		// Bail out early if no params received
		if(!$slider) { return array('init' => '', 'container' => '', 'markup' => ''); }

		// Slider and markup data
		$id = $slider['id'];
		$sliderID = 'layerslider_'.$id;
		$slides = $slider['data'];

		// Store generated output
		$lsInit = array(); $lsContainer = array(); $lsMarkup = array();

		// Include slider file
		if(is_array($slides)) {

			// Get phpQuery
			if( ! defined('LS_phpQuery') ) {
				libxml_use_internal_errors(true);
				include LS_ROOT_PATH.'/helpers/phpQuery.php';
			}

			include LS_ROOT_PATH.'/config/defaults.php';
			include LS_ROOT_PATH.'/includes/slider_markup_init.php';
			include LS_ROOT_PATH.'/includes/slider_markup_html.php';

			// Admin notice when using premium features on non-activated sites
			if( ! empty( $GLOBALS['lsPremiumNotice'] ) ) {
				array_unshift($lsContainer, self::generateErrorMarkup(
					__('Premium features is available for preview purposes only.', 'LayerSlider'),
					__("We've detected that you're using premium features in this slider, but you have not yet activated your site. Premium features is only available for activated sites. ", 'LayerSlider').'<a href="https://support.kreaturamedia.com/docs/layersliderwp/documentation.html#activation" target="_blank">'.__('Click here to learn more', 'LayerSlider').'</a>.',
					'dashicons-star-filled', 'info'
				));
			}



			$lsInit = implode('', $lsInit);
			$lsContainer = implode('', $lsContainer);
			$lsMarkup = implode('', $lsMarkup);
		}

		// Concatenate output
		if( get_option('ls_concatenate_output', false) ) {
			$lsInit = trim(preg_replace('/\s+/u', ' ', $lsInit));
			$lsContainer = trim(preg_replace('/\s+/u', ' ', $lsContainer));
			$lsMarkup = trim(preg_replace('/\s+/u', ' ', $lsMarkup));
		}

		// Bug fix in v5.4.0: Use self closing tag for <source>
		$lsMarkup = str_replace('></source>', ' />', $lsMarkup);

		// Return formatted data
		return array(
			'init' => $lsInit,
			'container' => $lsContainer,
			'markup' => $lsMarkup
		);
	}


	public static function generateErrorMarkup( $title = null, $description = null, $logo = 'dashicons-warning', $customClass = '' ) {

		if( ! $title ) {
			$title = __('LayerSlider encountered a problem while it tried to show your slider.', 'LayerSlider');
		}

		if( is_null($description) ) {
			$description = __("Please make sure that you've used the right shortcode or method to insert the slider, and check if the corresponding slider exists and it wasn't deleted previously.", "LayerSlider");
		}

		if( $description ) {
			$description .= '<br><br>';
		}

		$logo = $logo ? '<i class="lswp-notification-logo dashicons '.$logo.'"></i>' : '';
		$notice = __('Only you and other administrators can see this to take appropriate actions if necessary.', 'LayerSlider');

		$classes = array('error', 'info', 'scheduled', 'dead');
		if( ! empty($customClass) && ! in_array($customClass, $classes) ) {
			$customClass = '';
		}


		return '<div class="clearfix lswp-notification '.$customClass.'">
					'.$logo.'
					<strong>'.$title.'</strong>
					<span>'.$description.'</span>
					<small>
						<i class="dashicons dashicons-lock"></i>
						'.$notice.'
					</small>
				</div>';
	}
}