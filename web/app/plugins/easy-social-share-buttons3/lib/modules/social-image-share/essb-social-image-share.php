<?php

class ESSBSocialImageShare {
	private static $instance = null;
	
	public static function get_instance() {
	
		if (null == self::$instance) {
			self::$instance = new self ();
		}
	
		return self::$instance;
	
	} // end get_instance;
	
	function __construct() {
		add_action ( 'wp_enqueue_scripts', array (&$this, 'enqueue_scripts' ) );
		add_action ( 'wp_footer', array (&$this, 'include_social_image_share' ) );
		add_action ( 'essb_js_buffer_head', array($this, 'generate_settings'));
		
		add_filter( 'body_class', array($this, 'essbis_class_names'));
		add_filter( 'the_content', array($this, 'essbis_content_filter'));
		add_filter( 'the_excerpt', array($this, 'essbis_content_filter'));
	}
	
	public function essbis_class_names( $classes ) {
		// add 'class-name' to the $classes array
		if ($this->can_run()) {
			$classes[] = 'essbis_site';
		}
		// return the $classes array
		return $classes;
	}
	
	public function can_run() {
		// deactivate on mobile when included
		if (essb_is_mobile() && ! essb_option_bool_value('sis_on_mobile')) {
			return false;
		}
		
		// deactivate at all via settings
		if (essb_is_plugin_deactivated_on() || essb_is_module_deactivated_on('sis')) {
			return false;
		}
		
		if (is_feed()) {
			return false;
		}
		
		return true;
	}
	
	public function essbis_content_filter($content) {
		if (!$this->can_run()) { return $content; }
		
		$attributes = ' data-essbisPostContainer=""';
		$attributes.= ' data-essbisPostUrl="' . get_permalink() . '"';
		$attributes.= ' data-essbisPostTitle="' . wp_strip_all_tags( get_the_title(), true ) . '"';
		$attributes.= ' data-essbisHoverContainer=""';
		
		$post_container = '<input type="hidden" value=""' . $attributes . '>';
		
		return $post_container . $content;
	}
	
	public function enqueue_scripts() {
		if (!$this->can_run()) { return; }
		
		essb_resource_builder()->add_static_resource_footer(ESSB3_PLUGIN_URL . '/lib/modules/social-image-share/assets/css/easy-social-image-share.min.css', 'essb-social-image-share', 'css');
		wp_enqueue_script ( 'jquery' );
		wp_enqueue_script ( 'essb-social-image-share', ESSB3_PLUGIN_URL . '/lib/modules/social-image-share/assets/js/easy-social-image-share.min.js', array ('jquery' ), false, true );
	}
	
	public function include_social_image_share() {
		if (!$this->can_run()) { return; }	
	}
	
	public function get_settings() {
		$settings = array(
				'imageSelector'      => '.essbis-hover-container img',
				'minImageHeight'     => 100,
				'minImageWidth'      => 100,
				'hoverPanelPosition' => 'middle-middle',
				'theme' 			=> 'flat',
				'orientation'       => 'horizontal',
				'showOnHome'         => '1',
				'showOnSingle'      => '1',
				'showOnPage'         => '1',
				'showOnBlog'         => '1',
				'showOnLightbox' => '1'
		);
		return $settings;
	}
	
	public function generate_settings($buffer) {
		global $post;
		
		$default_setup = $this->get_settings();
		
		if (essb_option_value('sis_selector') != '') {
			$default_setup['imageSelector'] = essb_option_value('sis_selector');
		}
		if (essb_option_value('sis_minWidth') != '') {
			$default_setup['minImageWidth'] = intval(essb_option_value('sis_minWidth'));
		}
		if (essb_option_value('sis_minHeight') != '') {
			$default_setup['minImageHeight'] = intval(essb_option_value('sis_minHeight'));
		}

		if (essb_option_value('sis_minWidthMobile') != '') {
			$default_setup['minImageWidthMobile'] = intval(essb_option_value('sis_minWidthMobile'));
		}
		if (essb_option_value('sis_minHeightMobile') != '') {
			$default_setup['minImageHeightMobile'] = intval(essb_option_value('sis_minHeightMobile'));
		}
		
		if (essb_option_bool_value('sis_always_visible')) {
			$default_setup['alwaysVisible'] = true;
		}
		else{
			$default_setup['alwaysVisible'] = false;
		}
		
		if (essb_option_bool_value('sis_on_mobile_click')) {
			$default_setup['mobileOnClick'] = true;
		}
		else {
			$default_setup['mobileOnClick'] = false;
		}
		
		$sis_networks = essb_option_value('sis_networks');
		$sis_network_order = essb_option_value('sis_network_order');
		
		$result_list = "";
		
		foreach ($sis_network_order as $network) {
			if (is_array($sis_networks)) {
				if (in_array($network, $sis_networks)) {
					if ($result_list != '') {
						$result_list .= ',';
					}
						
					$result_list .= $network;
				}
			}
		}
		
		if ($result_list == '') { $result_list = 'pinterest'; }
		$default_setup['networks'] = $result_list;
		
		$button_position = essb_option_value('sis_position');
		if ($button_position != '') {
			$default_setup['hoverPanelPosition'] = $button_position;
		}
		
		$button_orientation = essb_option_value('sis_orientation');
		if ($button_orientation != '') {
			$default_setup['orientation'] = $button_orientation;
		}
		
		if (essb_option_value('sis_style') != '') {
			$default_setup['theme'] = essb_option_value('sis_style');
		}
		if (essb_options_value('sis_mobile_style') != '') {
			$default_setup['theme_mobile'] = essb_option_value('sis_mobile_style');
		}
		
		
		$setup = array();
		$setup["modules"] = array();
		$setup["modules"]["settings"] = array();
		$setup["modules"]["settings"]["moduleHoverActive"] = 1;
		$setup["modules"]["settings"]["activeModules"] = array("settings", "buttons", "hover");
		$setup["modules"]["buttons"] = array();
		$setup["modules"]["buttons"]["pinterestImageDescription"] = array("titleAttribute", "altAttribute", "postTitle", "mediaLibraryDescription");
		$setup["modules"]["buttons"]["networks"] = $result_list;
		$setup["modules"]["hover"] = $default_setup;
		$setup['twitteruser'] = essb_option_value('twitteruser');
		$setup['fbapp'] = essb_option_value('sis_facebookapp');
		$setup['dontshow'] = essb_option_value('sis_dontshow');
		$setup["buttonSets"] = array();
		$setup["themes"] = array();	

		if (isset($post)) {
			$post_essb_post_share_message = get_post_meta($post->ID, 'essb_post_share_message', true);
			$post_essb_post_share_url = get_post_meta($post->ID, 'essb_post_share_url', true);
			$essb_post_share_text = get_post_meta($post->ID, 'essb_post_share_text', true);
			if ($post_essb_post_share_url != '') {
				$setup['custom_url'] = $post_essb_post_share_url;
			}
			if ($post_essb_post_share_message != '') {
				$setup['custom_text'] = $post_essb_post_share_message;
			}
			if ($essb_post_share_text != '') {
				$setup['custom_description'] = $essb_post_share_text;
 			}
		}
		
		
		$output = 'var essbis_settings = '.json_encode($setup).';';
		
		return $buffer.$output;
	}
}

