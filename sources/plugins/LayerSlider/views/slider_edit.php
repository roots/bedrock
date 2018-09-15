<?php

	if(!defined('LS_ROOT_FILE')) {
		header('HTTP/1.0 403 Forbidden');
		exit;
	}

	// Attempt to avoid memory limit issues
	@ini_set( 'memory_limit', '256M' );

	// Get the IF of the slider
	$id = (int) $_GET['id'];

	// Get slider
	$sliderItem = LS_Sliders::find($id);
	$slider = $sliderItem['data'];


	// Get screen options
	$lsScreenOptions = get_option('ls-screen-options', '0');
	$lsScreenOptions = ($lsScreenOptions == 0) ? array() : $lsScreenOptions;
	$lsScreenOptions = is_array($lsScreenOptions) ? $lsScreenOptions : unserialize($lsScreenOptions);

	// Defaults
	if(!isset($lsScreenOptions['showTooltips'])) {
		$lsScreenOptions['showTooltips'] = 'true';
	}

	// Get phpQuery
	if( ! defined('LS_phpQuery') ) {
		libxml_use_internal_errors(true);
		include LS_ROOT_PATH.'/helpers/phpQuery.php';
	}

	// Get defaults
	include LS_ROOT_PATH . '/config/defaults.php';
	include LS_ROOT_PATH . '/helpers/admin.ui.tools.php';

	// Run filters
	if(has_filter('layerslider_override_defaults')) {
		$newDefaults = apply_filters('layerslider_override_defaults', $lsDefaults);
		if(!empty($newDefaults) && is_array($newDefaults)) {
			$lsDefaults = $newDefaults;
			unset($newDefaults);
		}
	}

	// Show tab
	$settingsTabClass = isset($_GET['showsettings']) ? 'active' : '';
	$slidesTabClass = !isset($_GET['showsettings']) ? 'active' : '';

	// Fixes
	if(!isset($slider['layers'][0]['properties'])) {
		$slider['layers'][0]['properties'] = array();
	}

	// Get google fonts
	$googleFonts = get_option('ls-google-fonts', array() );

	// Get post types
	$postTypes = LS_Posts::getPostTypes();
	$postCategories = get_categories();
	$postTags = get_tags();
	$postTaxonomies = get_taxonomies(array('_builtin' => false), 'objects');
?>
<div id="ls-screen-options" class="metabox-prefs hidden">
	<div id="screen-options-wrap" class="hidden">
		<form id="ls-screen-options-form" method="post">
			<h5><?php _e('Show on screen', 'LayerSlider') ?></h5>
			<label>
				<input type="checkbox" name="showTooltips"<?php echo $lsScreenOptions['showTooltips'] == 'true' ? ' checked="checked"' : ''?>> Tooltips
			</label>
		</form>
	</div>
	<div id="screen-options-link-wrap" class="hide-if-no-js screen-meta-toggle">
		<button type="button" id="show-settings-link" class="button show-settings" aria-controls="screen-options-wrap" aria-expanded="false"><?php _e('Screen Options', 'LayerSlider') ?></button>
	</div>
</div>

<!-- Load templates -->
<?php
include LS_ROOT_PATH . '/templates/tmpl-share-sheet.php';
include LS_ROOT_PATH . '/templates/tmpl-layer-item.php';
include LS_ROOT_PATH . '/templates/tmpl-static-layer-item.php';
include LS_ROOT_PATH . '/templates/tmpl-layer.php';
include LS_ROOT_PATH . '/templates/tmpl-transition-window.php';

?>

<!-- Load slide template -->
<script type="text/html" id="ls-slide-template">
	<?php include LS_ROOT_PATH . '/templates/tmpl-slide.php'; ?>
</script>

<!-- Slider JSON data source -->
<?php

	if( ! isset($slider['properties']['status']) ) {
		$slider['properties']['status'] = true;
	}

	// COMPAT: If old and non-fullwidth slider
	if( ! isset($slider['properties']['slideBGSize']) && ! isset($slider['properties']['new']) ) {
		if( empty( $slider['properties']['forceresponsive'] ) ) {
			$slider['properties']['slideBGSize'] = 'auto';
		}
	}

	$slider['properties']['schedule_start'] = '';
	$slider['properties']['schedule_end'] = '';

	if( ! empty( $sliderItem['schedule_start'] ) ) {
		$slider['properties']['schedule_start'] = (int) $sliderItem['schedule_start'];
	}

	if( ! empty( $sliderItem['schedule_end'] ) ) {
		$slider['properties']['schedule_end'] = (int) $sliderItem['schedule_end'];
	}

	// Get yourLogo
	if( ! empty($slider['properties']['yourlogoId']) ) {
		$slider['properties']['yourlogo'] = apply_filters('ls_get_image', $slider['properties']['yourlogoId'], $slider['properties']['yourlogo']);
		$slider['properties']['yourlogoThumb'] = apply_filters('ls_get_thumbnail', $slider['properties']['yourlogoId'], $slider['properties']['yourlogo']);
	}


	$slider['properties']['cbinit'] = !empty($slider['properties']['cbinit']) ? stripslashes($slider['properties']['cbinit']) : $lsDefaults['slider']['cbInit']['value'];
	$slider['properties']['cbstart'] = !empty($slider['properties']['cbstart']) ? stripslashes($slider['properties']['cbstart']) : $lsDefaults['slider']['cbStart']['value'];
	$slider['properties']['cbstop'] = !empty($slider['properties']['cbstop']) ? stripslashes($slider['properties']['cbstop']) : $lsDefaults['slider']['cbStop']['value'];
	$slider['properties']['cbpause'] = !empty($slider['properties']['cbpause']) ? stripslashes($slider['properties']['cbpause']) : $lsDefaults['slider']['cbPause']['value'];
	$slider['properties']['cbanimstart'] = !empty($slider['properties']['cbanimstart']) ? stripslashes($slider['properties']['cbanimstart']) : $lsDefaults['slider']['cbAnimStart']['value'];
	$slider['properties']['cbanimstop'] = !empty($slider['properties']['cbanimstop']) ? stripslashes($slider['properties']['cbanimstop']) : $lsDefaults['slider']['cbAnimStop']['value'];
	$slider['properties']['cbprev'] = !empty($slider['properties']['cbprev']) ? stripslashes($slider['properties']['cbprev']) : $lsDefaults['slider']['cbPrev']['value'];
	$slider['properties']['cbnext'] = !empty($slider['properties']['cbnext']) ? stripslashes($slider['properties']['cbnext']) : $lsDefaults['slider']['cbNext']['value'];


	if( empty($slider['properties']['new']) && empty($slider['properties']['type']) ) {
		if( !empty($slider['properties']['forceresponsive']) ) {
			$slider['properties']['type'] = 'fullwidth';

			if( strpos($slider['properties']['width'], '%') !== false ) {

				if( ! empty($slider['properties']['responsiveunder']) ) {
					$slider['properties']['width'] = $slider['properties']['responsiveunder'];

				} elseif( ! empty($slider['properties']['sublayercontainer']) ) {
					$slider['properties']['width'] = $slider['properties']['sublayercontainer'];

				// Falling back to 1000px when no layerContainer value was specified
				} else {
					$slider['properties']['width'] = 1000;
				}
			}

		} elseif( empty($slider['properties']['responsive']) ) {
			$slider['properties']['type'] = 'fixedsize';
		} else {
			$slider['properties']['type'] = 'responsive';
		}
	}

	if( ! empty($slider['properties']['sublayercontainer']) ) {
		unset($slider['properties']['sublayercontainer']);
	}

	if( ! empty( $slider['properties']['width'] ) ) {
		$slider['properties']['width'] = (int) $slider['properties']['width'];
	}

	if( ! empty( $slider['properties']['width'] ) ) {
		$slider['properties']['height'] = (int) $slider['properties']['height'];
	}

	if( ! empty( $slider['properties']['pauseonhover'] ) ) {
		$slider['properties']['pauseonhover'] = 'enabled';
	}

	if( empty($slider['properties']['sliderVersion'] ) && empty($slider['properties']['circletimer'] ) ) {
		$slider['properties']['circletimer'] = false;
	}

	// Convert old checkbox values
	foreach($slider['properties'] as $optionKey => $optionValue) {
		switch($optionValue) {
			case 'on':
				$slider['properties'][$optionKey] = true;
				break;

			case 'off':
				$slider['properties'][$optionKey] = false;
				break;
		}
	}

	foreach($slider['layers'] as $slideKey => $slideVal) {

		// Get slide background
		if( ! empty($slideVal['properties']['backgroundId']) ) {
			$slideVal['properties']['background'] = apply_filters('ls_get_image', $slideVal['properties']['backgroundId'], $slideVal['properties']['background']);
			$slideVal['properties']['backgroundThumb'] = apply_filters('ls_get_thumbnail', $slideVal['properties']['backgroundId'], $slideVal['properties']['background']);
		}

		// Get slide thumbnail
		if( ! empty($slideVal['properties']['thumbnailId']) ) {
			$slideVal['properties']['thumbnail'] = apply_filters('ls_get_image', $slideVal['properties']['thumbnailId'], $slideVal['properties']['thumbnail']);
			$slideVal['properties']['thumbnailThumb'] = apply_filters('ls_get_thumbnail', $slideVal['properties']['thumbnailId'], $slideVal['properties']['thumbnail']);
		}


		$slider['layers'][$slideKey] = $slideVal;

		if(!empty($slideVal['sublayers']) && is_array($slideVal['sublayers'])) {

			// v6.0: Reverse layers list
			$slideVal['sublayers'] = array_reverse($slideVal['sublayers']);

			foreach($slideVal['sublayers'] as $layerKey => $layerVal) {

				if( ! empty($layerVal['imageId']) ) {
					$layerVal['image'] = apply_filters('ls_get_image', $layerVal['imageId'], $layerVal['image']);
					$layerVal['imageThumb'] = apply_filters('ls_get_thumbnail', $layerVal['imageId'], $layerVal['image']);
				}

				if( ! empty($layerVal['posterId']) ) {
					$layerVal['poster'] = apply_filters('ls_get_image', $layerVal['posterId'], $layerVal['poster']);
					$layerVal['posterThumb'] = apply_filters('ls_get_thumbnail', $layerVal['posterId'], $layerVal['poster']);
				}

				// Ensure that magic quotes will not mess with JSON data
				if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
					$layerVal['styles'] = stripslashes($layerVal['styles']);
					$layerVal['transition'] = stripslashes($layerVal['transition']);
				}

				// Parse embedded JSON data
				$layerVal['styles'] = !empty($layerVal['styles']) ? (object) json_decode(stripslashes($layerVal['styles']), true) : new stdClass;
				$layerVal['transition'] = !empty($layerVal['transition']) ? (object) json_decode(stripslashes($layerVal['transition']), true) : new stdClass;
				$layerVal['html'] = !empty($layerVal['html']) ? stripslashes($layerVal['html']) : '';

				// Add 'top', 'left' and 'wordwrap' to the styles object
				if(isset($layerVal['top'])) { $layerVal['styles']->top = $layerVal['top']; unset($layerVal['top']); }
				if(isset($layerVal['left'])) { $layerVal['styles']->left = $layerVal['left']; unset($layerVal['left']); }
				if(isset($layerVal['wordwrap'])) { $layerVal['styles']->wordwrap = $layerVal['wordwrap']; unset($layerVal['wordwrap']); }

				if( ! empty( $layerVal['transition']->showuntil ) ) {

					$layerVal['transition']->startatout = 'transitioninend + '.$layerVal['transition']->showuntil;
					$layerVal['transition']->startatouttiming = 'transitioninend';
					$layerVal['transition']->startatoutvalue = $layerVal['transition']->showuntil;
					unset($layerVal['transition']->showuntil);
				}

				if( ! empty( $layerVal['transition']->parallaxlevel ) ) {
					$layerVal['transition']->parallax = true;
				}

				// Custom attributes
				$layerVal['innerAttributes'] = !empty($layerVal['innerAttributes']) ?  (object) $layerVal['innerAttributes'] : new stdClass;
				$layerVal['outerAttributes'] = !empty($layerVal['outerAttributes']) ?  (object) $layerVal['outerAttributes'] : new stdClass;

				$slider['layers'][$slideKey]['sublayers'][$layerKey] = $layerVal;
			}
		} else {
			$slider['layers'][$slideKey]['sublayers'] = array();
		}
	}

	if( ! empty( $slider['callbacks'] ) ) {
		foreach( $slider['callbacks'] as $key => $callback ) {
			$slider['callbacks'][$key] = stripslashes($callback);
		}
	}

	// Slider version
	$slider['properties']['sliderVersion'] = LS_PLUGIN_VERSION;
?>

<!-- Get slider data from DB -->
<script type="text/javascript">
	window.lsSliderData = <?php echo json_encode($slider) ?>;
</script>



<form method="post" id="ls-slider-form" novalidate="novalidate" autocomplete="off">

	<input type="hidden" name="slider_id" value="<?php echo $id ?>">
	<input type="hidden" name="action" value="ls_save_slider">
	<?php wp_nonce_field('ls-save-slider-' . $id); ?>

	<div class="wrap">

		<!-- Title -->
		<h2>
			<?php _e('Editing slider:', 'LayerSlider') ?>
			<?php $sliderName = !empty($slider['properties']['title']) ? $slider['properties']['title'] : 'Unnamed'; ?>
			<?php echo apply_filters('ls_slider_title', $sliderName, 30) ?>
			<a href="?page=layerslider" class="add-new-h2"><?php _e('Back to the list', 'LayerSlider') ?></a>
		</h2>

		<!-- Version number -->
		<?php include LS_ROOT_PATH . '/templates/tmpl-beta-feedback.php'; ?>

		<!-- Main menu bar -->
		<div id="ls-main-nav-bar">
			<a href="#" class="settings <?php echo $settingsTabClass ?>">
				<i class="dashicons dashicons-admin-tools"></i>
				<?php _e('Slider Settings', 'LayerSlider') ?>
			</a>
			<a href="#" class="layers <?php echo $slidesTabClass ?>">
				<i class="dashicons dashicons-images-alt"></i>
				<?php _e('Slides', 'LayerSlider') ?>
			</a>
			<a href="#" class="callbacks">
				<i class="dashicons dashicons-redo"></i>
				<?php _e('Event Callbacks', 'LayerSlider') ?>
			</a>
			<a href="https://support.kreaturamedia.com/faq/4/layerslider-for-wordpress/" target="_blank" class="faq right unselectable">
				<i class="dashicons dashicons-sos"></i>
				<?php _e('FAQ', 'LayerSlider') ?>
			</a>
			<a href="https://support.kreaturamedia.com/docs/layersliderwp/documentation.html" target="_blank" class="support right unselectable">
				<i class="dashicons dashicons-editor-help"></i>
				<?php _e('Documentation', 'LayerSlider') ?>
			</a>
			<span class="right help"><?php _e('Need help? Try these: ', 'LayerSlider') ?></span>
			<a href="#" class="clear unselectable"></a>
		</div>

	</div>

	<!-- Post options -->
	<?php include LS_ROOT_PATH . '/templates/tmpl-post-options.php'; ?>

	<!-- Pages -->
	<div id="ls-pages">

		<!-- Slider Settings -->
		<div class="ls-page ls-settings ls-slider-settings <?php echo $settingsTabClass ?>">
			<?php include LS_ROOT_PATH . '/templates/tmpl-slider-settings.php'; ?>
		</div>

		<!-- Slides -->
		<div class="ls-page <?php echo $slidesTabClass ?>">

			<!-- Slide tabs -->
			<div id="ls-layer-tabs">
				<?php
					foreach($slider['layers'] as $key => $layer) :
					$active = empty($key) ? 'active' : '';
					$name = !empty($layer['properties']['title']) ? $layer['properties']['title'] : 'Slide #'.($key+1);
					$bgImage = !empty($layer['properties']['background']) ? $layer['properties']['background'] : null;
					$bgImageId = !empty($layer['properties']['backgroundId']) ? $layer['properties']['backgroundId'] : null;
					$image = apply_filters('ls_get_image', $bgImageId, $bgImage, true);
				?>
				<a href="#" class="<?php echo $active ?>" data-help="<div style='background-image: url(<?php echo $image?>);'></div>" data-help-class="ls-slide-preview-tooltip popover-light ls-popup" data-help-delay="1" data-help-transition="false">
					<span><?php echo $name ?></span>
					<span class="dashicons dashicons-dismiss"></span>
				</a>
				<?php endforeach; ?>
				<a href="#"  title="<?php _e('Add new slide', 'LayerSlider') ?>" class="unsortable" id="ls-add-layer"><i class="dashicons dashicons-plus"></i></a>
				<div class="unsortable clear"></div>
			</div>

			<!-- Slides -->
			<div id="ls-layers" class="clearfix">
				<?php include LS_ROOT_PATH . '/templates/tmpl-slide.php'; ?>
			</div>
		</div>

		<!-- Event Callbacks -->
		<div class="ls-page ls-callback-page">

			<div class="ls-notification-info">
				<i class="dashicons dashicons-info"> </i>
				<?php _e('Please read our <a href="https://support.kreaturamedia.com/docs/layersliderwp/documentation.html#layerslider-api" target="_blank">online documentation</a> before start using the API. LayerSlider 6 introduced an entirely new API model with different events and methods.', 'LayerSlider') ?>
			</div>


			<div class="ls-callback-separator">Init Events</div>

			<div class="ls-box ls-callback-box">
				<h3 class="header">
					sliderWillLoad
					<figure><span>|</span> <?php _e('Fires before parsing user settings and rendering the UI.', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea name="sliderWillLoad" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
				</div>
			</div>

			<div class="ls-box ls-callback-box">
				<h3 class="header">
					sliderDidLoad
					<figure><span>|</span> <?php _e('Fires when the slider is fully initialized and its DOM nodes become accessible.', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea name="sliderDidLoad" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
				</div>
			</div>

			<div class="ls-callback-separator">Resize Events</div>


			<div class="ls-box ls-callback-box side">
				<h3 class="header">
					sliderWillResize
					<figure><span>|</span> <?php _e('Fires before the slider renders resize events.', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea name="sliderWillResize" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
				</div>
			</div>

			<div class="ls-box ls-callback-box">
				<h3 class="header">
					sliderDidResize
					<figure><span>|</span> <?php _e('Fires after the slider has rendered resize events.', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea name="sliderDidResize" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
				</div>
			</div>

			<div class="ls-callback-separator">Slideshow Events</div>


			<div class="ls-box ls-callback-box">
				<h3 class="header">
					slideshowStateDidChange
					<figure><span>|</span> <?php _e('Fires upon every slideshow state change, which may not influence the playing status.', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea name="slideshowStateDidChange" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
				</div>
			</div>

			<div class="ls-box ls-callback-box">
				<h3 class="header">
					slideshowDidPause
					<figure><span>|</span> <?php _e('Fires when the slideshow pauses from playing status.', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea name="slideshowDidPause" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
				</div>
			</div>

			<div class="ls-box ls-callback-box side">
				<h3 class="header">
					slideshowDidResume
					<figure><span>|</span> <?php _e('Fires when the slideshow resumes from paused status.', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea name="slideshowDidResume" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
				</div>
			</div>


			<div class="ls-callback-separator">Slide Change Event</div>


			<div class="ls-box ls-callback-box">
				<h3 class="header">
					slideChangeWillStart
					<figure><span>|</span> <?php _e('Signals when the slider wants to change slides, and is your last chance to divert it or intervene in any way.', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea name="slideChangeWillStart" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
				</div>
			</div>

			<div class="ls-box ls-callback-box">
				<h3 class="header">
					slideChangeDidStart
					<figure><span>|</span> <?php _e('Fires when the slider has started a slide change.', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea name="slideChangeDidStart" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
				</div>
			</div>

			<div class="ls-box ls-callback-box">
				<h3 class="header">
					slideChangeWillComplete
					<figure><span>|</span> <?php _e('Fires before completing a slide change.', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea name="slideChangeWillComplete" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
				</div>
			</div>

			<div class="ls-box ls-callback-box">
				<h3 class="header">
					slideChangeDidComplete
					<figure><span>|</span> <?php _e('Fires after a slide change has completed and the slide indexes have been updated. ', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea name="slideChangeDidComplete" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
				</div>
			</div>


			<div class="ls-callback-separator">Slide Timeline Events</div>

			<div class="ls-box ls-callback-box">
				<h3 class="header">
					slideTimelineDidCreate
					<figure><span>|</span> <?php _e("Fires when the current slide's animation timeline (e.g. your layers) becomes accessible for interfacing.", 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea name="slideTimelineDidCreate" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
				</div>
			</div>


			<div class="ls-box ls-callback-box">
				<h3 class="header">
					slideTimelineDidUpdate
					<figure><span>|</span> <?php _e("Fires rapidly (at each frame) throughout the entire slide while playing, including reverse playback.", 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea name="slideTimelineDidUpdate" cols="20" rows="5" class="ls-codemirror">function( event, timeline ) {

}</textarea>
				</div>
			</div>


			<div class="ls-box ls-callback-box">
				<h3 class="header">
					slideTimelineDidStart
					<figure><span>|</span> <?php _e("Fires when the current slide's animation timeline (e.g. your layers) has started playing.", 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea name="slideTimelineDidStart" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
				</div>
			</div>

			<div class="ls-box ls-callback-box">
				<h3 class="header">
					slideTimelineDidComplete
					<figure><span>|</span> <?php _e("Fires when the current slide's animation timeline (e.g. layer transitions) has completed.", 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea name="slideTimelineDidComplete" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
				</div>
			</div>

			<div class="ls-box ls-callback-box">
				<h3 class="header">
					slideTimelineDidReverseComplete
					<figure><span>|</span> <?php _e('Fires when all reversed animations have reached the beginning of the current slide.', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea name="slideTimelineDidReverseComplete" cols="20" rows="5" class="ls-codemirror">function( event, slider ) {

}</textarea>
				</div>
			</div>


			<div class="ls-callback-separator">Destroy Events</div>


			<div class="ls-box ls-callback-box">
				<h3 class="header">
					sliderDidDestroy
					<figure><span>|</span> <?php _e('Fires when the slider destructor has finished and it is safe to remove the slider from the DOM.', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea name="sliderDidDestroy" data-event-data="false" cols="20" rows="5" class="ls-codemirror">function( event ) {

}</textarea>
				</div>
			</div>

			<div class="ls-box ls-callback-box">
				<h3 class="header">
					sliderDidRemove
					<figure><span>|</span> <?php _e('Fires when the slider has been removed from the DOM when using the <i>destroy</i> API method.', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea name="sliderDidRemove" data-event-data="false" cols="20" rows="5" class="ls-codemirror">function( event ) {

}</textarea>
				</div>
			</div>


			<div class="ls-callback-separator">Old API Events</div>
			<div class="ls-notification-info">
				<i class="dashicons dashicons-info"> </i>
				<?php _e('The events below were used in version 5 and earlier. These events are no longer in use, they cannot be edited. They are shown only to offer you a way of viewing and porting them to the new API.', 'LayerSlider') ?>
			</div>

			<div class="ls-box ls-callback-box">
				<h3 class="header">
					cbInit
					<figure><span>|</span> <?php _e('Fires when LayerSlider has loaded.', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea readonly name="cbinit" cols="20" rows="5" class="ls-codemirror"><?php echo $slider['properties']['cbinit'] ?></textarea>
				</div>
			</div>

			<div class="ls-box ls-callback-box">
				<h3 class="header">
					cbStart
					<figure><span>|</span> <?php _e('Calling when the slideshow has started.', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea readonly name="cbstart" cols="20" rows="5" class="ls-codemirror"><?php echo $slider['properties']['cbstart'] ?></textarea>
				</div>
			</div>

			<div class="ls-box ls-callback-box side">
				<h3 class="header">
					cbStop
					<figure><span>|</span> <?php _e('Calling when the slideshow is stopped by the user.', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea readonly name="cbstop" cols="20" rows="5" class="ls-codemirror"><?php echo $slider['properties']['cbstop'] ?></textarea>
				</div>
			</div>

			<div class="ls-box ls-callback-box">
				<h3 class="header">
					cbPause
					<figure><span>|</span> <?php _e('Fireing when the slideshow is temporary on hold (e.g.: "Pause on hover" feature).', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea readonly name="cbpause" cols="20" rows="5" class="ls-codemirror"><?php echo $slider['properties']['cbpause'] ?></textarea>
				</div>
			</div>

			<div class="ls-box ls-callback-box">
				<h3 class="header">
					cbAnimStart
					<figure><span>|</span> <?php _e('Calling when the slider commencing slide change (animation start).', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea readonly name="cbanimstart" cols="20" rows="5" class="ls-codemirror"><?php echo $slider['properties']['cbanimstart'] ?></textarea>
				</div>
			</div>

			<div class="ls-box ls-callback-box side">
				<h3 class="header">
					cbAnimStop
					<figure><span>|</span> <?php _e('Fireing when the slider finished a slide change (animation end).', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea readonly name="cbanimstop" cols="20" rows="5" class="ls-codemirror"><?php echo $slider['properties']['cbanimstop'] ?></textarea>
				</div>
			</div>

			<div class="ls-box ls-callback-box">
				<h3 class="header">
					cbPrev
					<figure><span>|</span> <?php _e('Calling when the slider will change to the previous slide by the user.', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea readonly name="cbprev" cols="20" rows="5" class="ls-codemirror"><?php echo $slider['properties']['cbprev'] ?></textarea>
				</div>
			</div>

			<div class="ls-box ls-callback-box">
				<h3 class="header">
					cbNext
					<figure><span>|</span> <?php _e('Calling when the slider will change to the next slide by the user.', 'LayerSlider') ?></figure>
				</h3>
				<div>
					<textarea readonly name="cbnext" cols="20" rows="5" class="ls-codemirror"><?php echo $slider['properties']['cbnext'] ?></textarea>
				</div>
			</div>

		</div>
	</div>

	<div class="ls-publish">
		<button type="submit" class="button button-primary button-hero"><?php _e('Save changes', 'LayerSlider') ?></button>
		<div class="ls-save-shortcode">
			<p><span><?php _e('Use shortcode:', 'LayerSlider') ?></span><br><span>[layerslider id="<?php echo !empty($slider['properties']['slug']) ? $slider['properties']['slug'] : $id ?>"]</span></p>
			<p><span><?php _e('Use PHP function:', 'LayerSlider') ?></span><br><span>&lt;?php layerslider(<?php echo !empty($slider['properties']['slug']) ? "'{$slider['properties']['slug']}'" : $id ?>) ?&gt;</span></p>
		</div>
	</div>
</form>


<script type="text/javascript">

	// Plugin path
	var pluginPath = '<?php echo LS_ROOT_URL ?>/static/';

	// Transition images
	var lsTrImgPath = '<?php echo LS_ROOT_URL ?>/static/admin/img/';

	// New Media Library
	<?php if(function_exists( 'wp_enqueue_media' )) { ?>
	var newMediaUploader = true;
	<?php } else { ?>
	var newMediaUploader = false;
	<?php } ?>

	// Screen options
	var lsScreenOptions = <?php echo json_encode($lsScreenOptions) ?>;
</script>