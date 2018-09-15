<?php

$lsDefaults = array(

	'slider' => array(

		'sliderVersion' => array(
			'value' => '',
			'keys' => 'sliderVersion',
			'props' => array(
				'forceoutput' => true
			)
		),

		'status' => array(
			'value' => true,
			'name' => __('Status', 'LayerSlider'),
			'keys' => 'status',
			'desc' => __('Unpublished sliders will not be visible for your visitors until you re-enable this option. This also applies to scheduled sliders, thus leaving this option enabled is recommended in most cases.', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'scheduleStart' => array(
			'value' => '',
			'name' => __('Schedule From', 'LayerSlider'),
			'keys' => 'schedule_start',
			'desc' => __("<ul>
	<li>Scheduled sliders will only be visible to your visitors between the time period you set here.</li>
	<li>We're using international date and time format to avoid ambiguity.</li>
	<li>You can also use relative formats described <a href=\"http://php.net/manual/en/datetime.formats.relative.php\" target=\"_blank\">here</a>. For example: <br> <i>tomorrow noon</i>, <i>monday 9am</i> or <i>+1 month</i></li>
	<li>Clear the text field above and left it empty if you want to cancel the schedule.</li>
</ul>

<span>IMPORTANT:</span>
<ul>
	<li>You will still need to set the slider status as published,</li>
	<li>and insert the slider to the target page with one of the methods described in the <a href=\"https://support.kreaturamedia.com/docs/layersliderwp/documentation.html#publish-shortcode\" target=\"_blank\">documentation</a>.</li>
</ul>", 'LayerSlider'),
			'attrs' => array(
				'placeholder' => __('No schedule', 'LayerSlider')
			),
			'props' => array(
				'meta' => true
			)
		),


		'scheduleEnd' => array(
			'value' => '',
			'name' => __('Schedule Until', 'LayerSlider'),
			'keys' => 'schedule_end',
			'desc' => '',
			'attrs' => array(
				'placeholder' => __('No schedule', 'LayerSlider')
			),
			'props' => array(
				'meta' => true
			)
		),


		// ============= //
		// |   Layout  | //
		// ============= //


		// responsive | fullwidth | fullsize | fixedsize
		'type' => array(
			'value' => 'responsive',
			'name' => __('Slider type', 'LayerSlider'),
			'keys' => 'type',
			'desc' => '',
			'attrs' => array(
				'type' => 'hidden'
			)

		),

		// The width of a new slider.
		'width' => array(
			'value' => 1280,
			'name' => __('Canvas width', 'LayerSlider'),
			'keys' => 'width',
			'desc' => __('The width of the slider canvas in pixels.', 'LayerSlider'),
			'attrs' => array(
				'type' => 'text',
				'placeholder' => 1280
			),
			'props' => array(
				'meta' => true
			)
		),

		// The height of a new slider.
		'height' => array(
			'value' => 720,
			'name' => __('Canvas height', 'LayerSlider'),
			'keys' => 'height',
			'desc' => __('The height of the slider canvas in pixels.', 'LayerSlider'),
			'attrs' => array(
				'type' => 'text',
				'placeholder' => 720
			),
			'props' => array(
				'meta' => true
			)
		),


		// The maximum width that the slider can get in responsive mode.
		'maxWidth' => array(
			'value' => '',
			'name' => __('Max-width', 'LayerSlider'),
			'keys' => 'maxwidth',
			'desc' => __('The maximum width your slider can take in pixels when responsive mode is enabled.', 'LayerSlider'),
			'attrs' => array(
				'type' => 'number',
				'min' => 0,
				'placeholder' => '100%'
			),
			'props' => array(
				'meta' => true
			)
		),


		// Turn on responsiveness under a given width of the slider.
		// Depends on: enabled fullWidth option. Defaults to: 0
		'responsiveUnder' => array(
			'value' => '',
			'name' => __('Responsive under', 'LayerSlider'),
			'keys' => array('responsiveunder', 'responsiveUnder'),
			'desc' => __('Turns on responsive mode in a full-width slider under the specified value in pixels. Can only be used with full-width mode.', 'LayerSlider'),
			'advanced' => true,
			'attrs' => array(
				'type' => 'number',
				'min' => 0,
				'placeholder' => __('Canvas width', 'LayerSlider')
			)
		),

		'layersContrainer' => array(
			'value' => '',
			'keys' => array('sublayercontainer', 'layersContainer')
		),


		'fullSizeMode' => array(
			'value' => 'normal',
			'name' => __('Mode', 'LayerSlider'),
			'keys' => 'fullSizeMode',
			'desc' => __('Select the sizing behavior of your full size sliders (e.g. hero scene).', 'LayerSlider'),
			'options' => array(
				'normal' => __('Normal', 'LayerSlider'),
				'hero' => __('Hero scene', 'LayerSlider'),
				'fitheight' => __('Fit to parent height', 'LayerSlider')
			),
			'attrs' => array(
				'min' => 0
			)
		),

		'allowFullscreen' => array(
			'value' => true,
			'name' => __('Allow fullscreen mode', 'LayerSlider'),
			'keys' => 'allowFullscreen',
			'desc' => __('Visitors can enter OS native full-screen mode when double clicking on the slider.', 'LayerSlider')
		),

		'maxRatio' => array(
			'value' => '',
			'name' => __('Maximum responsive ratio', 'LayerSlider'),
			'keys' => 'maxRatio',
			'desc' => __('The slider will not enlarge your layers above the target ratio. The value 1 will keep your layers in their initial size, without any upscaling.', 'LayerSlider'),
			'advanced' => true
		),

		'fitScreenWidth' => array(
			'value' => true,
			'name' => __('Fit to screen width', 'LayerSlider'),
			'keys' => 'fitScreenWidth',
			'desc' => __('The slider will always have the same width as the viewport, even if a theme uses a boxed layout, except if you choose the "Fit to parent height" full size mode.', 'LayerSlider'),
			'advanced' => true
		),

		'preventSliderClip' => array(
			'value' => true,
			'name' => __('Prevent slider clipping', 'LayerSlider'),
			'keys' => 'preventSliderClip',
			'desc' => __('Ensures that the theme cannot clip parts of the slider when used in a boxed layout.', 'LayerSlider'),
			'advanced' => true
		),


		'insertMethod' => array(
			'value' => 'prependTo',
			'name' => __('Move the slider by', 'LayerSlider'),
			'keys' => 'insertMethod',
			'desc' => __('Move your slider to a the different part of the page by providing a jQuery DOM manipulation method & selector for the target destination.', 'LayerSlider'),
			'options' => array(
				'prependTo' => 'prepending to',
				'appendTo' => 'appending to',
				'insertBefore' => 'inserting before',
				'insertAfter' => 'inserting after'
			)
		),

		'insertSelector' => array(
			'value' => '',
			'keys' => 'insertSelector',
			'attrs' => array(
				'placeholder' => 'Enter selector'
			)
		),

		'clipSlideTransition' => array(
			'value' => 'disabled',
			'name' => __('Clip slide transition', 'LayerSlider'),
			'keys' => 'clipSlideTransition',
			'desc' => __('Choose on which axis (if any) you want to clip the overflowing content (i.e. that breaks outside of the slider bounds).', 'LayerSlider'),
			'advanced' => true,
			'options' => array(
				'disabled' => __('Do not hide', 'LayerSlider'),
				'enabled' => __('Hide on both axis', 'LayerSlider'),
				'x' => __('X Axis', 'LayerSlider'),
				'y' => __('Y Axis', 'LayerSlider')
			)
		),


		'slideBGSize' => array(
			'value' => 'cover',
			'name' => __('Background size', 'LayerSlider'),
			'keys' => 'slideBGSize',
			'desc' => __('This will be used as a default on all slides, unless you choose the explicitly override it on a per slide basis.', 'LayerSlider'),
			'options' => array(
				'auto' => __('Auto', 'LayerSlider'),
				'cover' => __('Cover', 'LayerSlider'),
				'contain' => __('Contain', 'LayerSlider'),
				'100% 100%' => __('Stretch', 'LayerSlider')
			)
		),

		'slideBGPosition' => array(
			'value' => '50% 50%',
			'name' => __('Background position', 'LayerSlider'),
			'keys' => 'slideBGPosition',
			'desc' => __('This will be used as a default on all slides, unless you choose the explicitly override it on a per slide basis.', 'LayerSlider'),
			'options' => array(
				'0% 0%' => __('left top', 'LayerSlider'),
				'0% 50%' => __('left center', 'LayerSlider'),
				'0% 100%' => __('left bottom', 'LayerSlider'),
				'50% 0%' => __('center top', 'LayerSlider'),
				'50% 50%' => __('center center', 'LayerSlider'),
				'50% 100%' => __('center bottom', 'LayerSlider'),
				'100% 0%' => __('right top', 'LayerSlider'),
				'100% 50%' => __('right center', 'LayerSlider'),
				'100% 100%' => __('right bottom', 'LayerSlider')
			)
		),


		'parallaxSensitivity' => array(
			'value' => 10,
			'name' => __('Parallax sensitivity', 'LayerSlider'),
			'keys' => 'parallaxSensitivity',
			'desc' => __('Increase or decrease the sensitivity of parallax content when moving your mouse cursor or tilting your mobile device.', 'LayerSlider')
		),


		'parallaxCenterLayers' => array(
			'value' => 'center',
			'name' => __('Parallax center layers', 'LayerSlider'),
			'keys' => 'parallaxCenterLayers',
			'desc' => __('Choose a center point for parallax content where all layers will be aligned perfectly according to their original position.', 'LayerSlider'),
			'options' => array(
				'center' => __('At center of the viewport', 'LayerSlider'),
				'top' => __('At the top of the viewport', 'LayerSlider')
			)
		),

		'parallaxCenterDegree' => array(
			'value' => 40,
			'name' => __('Parallax center degree', 'LayerSlider'),
			'keys' => 'parallaxCenterDegree',
			'desc' => __('Provide a comfortable holding position (in degrees) for mobile devices, which should be the center point for parallax content where all layers will align perfectly.', 'LayerSlider')
		),

		'parallaxScrollReverse' => array(
			'value' => false,
			'name' => 'Reverse scroll direction',
			'keys' => 'parallaxScrollReverse',
			'desc' => __('Your parallax layers will move to the opposite direction when scrolling the page.', 'LayerSlider')
		),


		// ================= //
		// |    Mobile    | //
		// ================= //

		'optimizeForMobile' => array(
			'value' => true,
			'name' => __('Optimize for mobile', 'LayerSlider'),
			'keys' => 'optimizeForMobile',
			'advanced' => true,
			'desc' => __('Enable optimizations on mobile devices to avoid performance issues (e.g. fewer tiles in slide transitions, reducing performance-heavy effects with very similar results, etc).', 'LayerSlider')
		),


		// Hides the slider on mobile devices.
		// Defaults to: false
		'hideOnMobile' => array(
			'value' => false,
			'name' => __('Hide on mobile', 'LayerSlider'),
			'keys' => array('hideonmobile', 'hideOnMobile'),
			'desc' => __('Hides the slider on mobile devices, including tablets.', 'LayerSlider')
		),


		// Hides the slider under the given value of browser width in pixels.
		// Defaults to: 0
		'hideUnder' => array(
			'value' => '',
			'name' => __('Hide under', 'LayerSlider'),
			'keys' => array('hideunder', 'hideUnder'),
			'desc' => __('Hides the slider when the viewport width goes under the specified value.', 'LayerSlider'),
			'attrs' => array(
				'type' => 'number',
				'min' => -1
			)
		),

		// Hides the slider over the given value of browser width in pixel.
		// Defaults to: 100000
		'hideOver' => array(
			'value' => '',
			'name' => __('Hide over', 'LayerSlider'),
			'keys' => array('hideover', 'hideOver'),
			'desc' => __('Hides the slider when the viewport becomes wider than the specified value.', 'LayerSlider'),
			'attrs' => array(
				'type' => 'number',
				'min' => -1
			)
		),

		'slideOnSwipe' => array(
			'value' => true,
			'name' => __('Enable swipe support', 'LayerSlider'),
			'keys' => 'slideOnSwipe',
			'advanced' => true,
			'desc' => __('You can change slides by swiping to a horizontal direction on mobile devices. ', 'LayerSlider')
		),

		// ================ //
		// |   Slideshow  | //
		// ================ //

		// Automatically start slideshow.
		'autoStart' => array(
			'value' => true,
			'name' => __('Auto-start slideshow', 'LayerSlider'),
			'keys' => array('autostart', 'autoStart'),
			'desc' => __('Slideshow will automatically start after page load.', 'LayerSlider')
		),

		'startInViewport' => array(
			'value' => true,
			'name' => __('Start only in viewport', 'LayerSlider'),
			'keys' => array('startinviewport', 'startInViewport'),
			'desc' => __('The slider will not start until it becomes visible.', 'LayerSlider')
		),

		'pauseLayers' => array(
			'value' => false,
			'name' => __('Pause layers', 'LayerSlider'),
			'keys' => 'pauseLayers',
			'desc' => __('If you enable this option, layer transitions will not start playing until the slideshow is in a paused state.', 'LayerSlider'),
			'advanced' => true
		),

		'pauseOnHover' => array(
			'value' => 'enabled',
			'name' => __('Pause on hover', 'LayerSlider'),
			'keys' => array('pauseonhover', 'pauseOnHover'),
			'options' => array(
				'disabled' => __('Do nothing', 'LayerSlider'),
				'enabled' => __('Pause slideshow', 'LayerSlider'),
				'layers' => __('Pause slideshow and layer transitions', 'LayerSlider'),
				'looplayers' => __('Pause slideshow and layer transitions, including loops', 'LayerSlider')
			),
			'desc' => __('Decide what should happen when you move your mouse cursor over the slider.', 'LayerSlider')
		),

		// The starting slide of a slider. Non-index value, starts with 1.
		'firstSlide' => array(
			'value' => 1,
			'name' => __('Start with slide', 'LayerSlider'),
			'keys' => array('firstlayer', 'firstSlide'),
			'desc' => __('The slider will start with the specified slide. You can use the value "random".', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '["random"]')
		),

		// Use global shortcuts to control the slider.
		'keybNavigation' => array(
			'value' => true,
			'name' => __('Keyboard navigation', 'LayerSlider'),
			'keys' => array('keybnav', 'keybNav'),
			'desc' => __('You can navigate through slides with the left and right arrow keys.', 'LayerSlider')
		),

		// Accepts touch gestures if enabled.
		'touchNavigation' => array(
			'value' => true,
			'name' => __('Touch navigation', 'LayerSlider'),
			'keys' => array('touchnav', 'touchNav'),
			'desc' => __('Gesture-based navigation when swiping on touch-enabled devices.', 'LayerSlider')
		),

		'playByScroll' => array(
			'value' => false,
			'name' => __('Enable', 'LayerSlider'),
			'keys' => 'playByScroll',
			'desc' => __('Play the slider by scrolling your mouse wheel.', 'LayerSlider'),
			'premium' => true
		),


		'playByScrollSpeed' => array(
			'value' => 1,
			'name' => __('Speed', 'LayerSlider'),
			'keys' => 'playByScrollSpeed',
			'desc' => __('Set the playing speed of Play by Scroll.', 'LayerSlider'),
			'premium' => true
		),

		// Number of loops taking by the slideshow.
		// Depends on: shuffle. Defaults to: 0 => infinite
		'loops' => array(
			'value' => 0,
			'name' => __('Cycles', 'LayerSlider'),
			'keys' => array('loops', 'cycles'),
			'desc' => __('Number of cycles if slideshow is enabled.', 'LayerSlider'),
			'attrs' => array(
				'type' => 'number',
				'min' => 0
			)
		),

		// The slideshow will always stop at the given number of
		// loops, even when the user restarts slideshow.
		// Depends on: loop. Defaults to: true
		'forceLoopNumber' => array(
			'value' => true,
			'name' => __('Force number of cycles', 'LayerSlider'),
			'keys' => array('forceloopnum', 'forceCycles'),
			'advanced' => true,
			'desc' => __('The slider will always stop at the given number of cycles, even if the slideshow restarts.', 'LayerSlider')
		),

		// The slideshow will change slides in random order.
		'shuffle' => array(
			'value' => false,
			'name' => __('Shuffle mode', 'LayerSlider'),
			'keys' => array('randomslideshow', 'shuffleSlideshow'),
			'desc' => __('Slideshow will proceed in random order. This feature does not work with looping.', 'LayerSlider')
		),

		// Whether slideshow should goind backwards or not
		// when you switch to a previous slide.
		'twoWaySlideshow' => array(
			'value' => false,
			'name' => __('Two way slideshow', 'LayerSlider'),
			'keys' => array('twowayslideshow', 'twoWaySlideshow'),
			'advanced' => true,
			'desc' => __('Slideshow can go backwards if someone switches to a previous slide.', 'LayerSlider')
		),

		'forceLayersOutDuration' => array(
			'value' => 750,
			'name' => __('Forced animation duration', 'LayerSlider'),
			'keys' => 'forceLayersOutDuration',
			'advanced' => true,
			'desc' => __('The animation speed in milliseconds when the slider forces remaining layers out of scene before swapping slides.', 'LayerSlider'),
			'attrs' => array(
				'min' => 0
			)
		),

		// ================= //
		// |   Appearance  | //
		// ================= //

		// The default skin.
		'skin' => array(
			'value' => 'v6',
			'name' => __('Skin', 'LayerSlider'),
			'keys' => 'skin',
			'desc' => __("The skin used for this slider. The 'noskin' skin is a border- and buttonless skin. Your custom skins will appear in the list when you create their folders.", "LayerSlider")
		),


		'sliderFadeInDuration' => array(
			'value' => 350,
			'name' => __('Initial fade duration', 'LayerSlider'),
			'keys' => array('sliderfadeinduration', 'sliderFadeInDuration'),
			'advanced' => true,
			'desc' => __('Change the duration of the initial fade animation when the page loads. Enter 0 to disable fading.', 'LayerSlider'),
			'attrs' => array(
				'min' => 0
			)
		),

		// Some CSS values you can append on each slide individually
		// to make some adjustments if needed.
		'sliderStyle' => array(
			'value' => 'margin-bottom: 0px;',
			'name' => __('Slider CSS', 'LayerSlider'),
			'keys' => array('sliderstyle', 'sliderStyle'),
			'desc' => __('You can enter custom CSS to change some style properties on the slider wrapper element. More complex CSS should be applied with the Custom Styles Editor.', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),


		// Global background color on all slides.
		'globalBGColor' => array(
			'value' => '',
			'name' => __('Background color', 'LayerSlider'),
			'keys' => array('backgroundcolor', 'globalBGColor'),
			'desc' => __('Global background color of the slider. Slides with non-transparent background will cover this one. You can use all CSS methods such as HEX or RGB(A) values.', 'LayerSlider')
		),

		// Global background image on all slides.
		'globalBGImage' => array(
			'value' => '',
			'name' => __('Background image', 'LayerSlider'),
			'keys' => array('backgroundimage', 'globalBGImage'),
			'desc' => __('Global background image of the slider. Slides with non-transparent backgrounds will cover it. This image will not scale in responsive mode.', 'LayerSlider')
		),

		// Global background image repeat
		'globalBGRepeat' => array(
			'value' => 'no-repeat',
			'name' => __('Background repeat', 'LayerSlider'),
			'keys' => 'globalBGRepeat',
			'desc' => __('Global background image repeat.', 'LayerSlider'),
			'options' => array(
				'no-repeat' => __('No-repeat', 'LayerSlider'),
				'repeat' => __('Repeat', 'LayerSlider'),
				'repeat-x' => __('Repeat-x', 'LayerSlider'),
				'repeat-y' => __('Repeat-y', 'LayerSlider')
			)
		),

		// Global background image behavior
		'globalBGAttachment' => array(
			'value' => 'scroll',
			'name' => __('Background behavior', 'LayerSlider'),
			'keys' => 'globalBGAttachment',
			'desc' => __('Choose between a scrollable or fixed global background image.', 'LayerSlider'),
			'options' => array(
				'scroll' => __('Scroll', 'LayerSlider'),
				'fixed' => __('Fixed', 'LayerSlider')
			)
		),

		// Global background image position
		'globalBGPosition' => array(
			'value' => '50% 50%',
			'name' => __('Background position', 'LayerSlider'),
			'keys' => 'globalBGPosition',
			'desc' => __('Global background image position of the slider. The first value is the horizontal position and the second value is the vertical.', 'LayerSlider')
		),

		// Global background image size
		'globalBGSize' => array(
			'value' => 'auto',
			'name' => __('Background size', 'LayerSlider'),
			'keys' => 'globalBGSize',
			'desc' => __('Global background size of the slider. You can set the size in pixels, percentages, or constants: auto | cover | contain ', 'LayerSlider'),
			'attrs' => array('data-options' => '[{
				"name": "auto",
				"value": "auto"
			}, {
				"name": "cover",
				"value": "cover"

			},{
				"name": "contain",
				"value": "contain"
			}, {
				"name": "stretch",
				"value": "100% 100%"
			}]')
		),



		// ================= //
		// |   Navigation  | //
		// ================= //

		// Show the next and previous buttons.
		'navPrevNextButtons' => array(
			'value' => true,
			'name' => __('Show Prev & Next buttons', 'LayerSlider'),
			'keys' => array('navprevnext', 'navPrevNext'),
			'desc' => __('Disabling this option will hide the Prev and Next buttons.', 'LayerSlider')
		),

		// Show the next and previous buttons
		// only when hovering over the slider.
		'hoverPrevNextButtons' => array(
			'value' => true,
			'name' => __('Show Prev & Next buttons on hover', 'LayerSlider'),
			'keys' => array('hoverprevnext', 'hoverPrevNext'),
			'desc' => __('Show the buttons only when someone moves the mouse cursor over the slider. This option depends on the previous setting.', 'LayerSlider')
		),

		// Show the start and stop buttons
		'navStartStopButtons' => array(
			'value' => true,
			'name' => __('Show Start & Stop buttons', 'LayerSlider'),
			'keys' => array('navstartstop', 'navStartStop'),
			'desc' => __('Disabling this option will hide the Start & Stop buttons.', 'LayerSlider')
		),

		// Show the slide buttons or thumbnails.
		'navSlideButtons' => array(
			'value' => true,
			'name' => __('Show slide navigation buttons', 'LayerSlider'),
			'keys' => array('navbuttons', 'navButtons'),
			'desc' => __('Disabling this option will hide slide navigation buttons or thumbnails.', 'LayerSlider')
		),

		// Show the slider buttons or thumbnails
		// ony when hovering over the slider.
		'hoverSlideButtons' => array(
			'value' => false,
			'name' => __('Slide navigation on hover', 'LayerSlider'),
			'keys' => array('hoverbottomnav', 'hoverBottomNav'),
			'desc' => __('Slide navigation buttons (including thumbnails) will be shown on mouse hover only.', 'LayerSlider')
		),

		// Show bar timer
		'barTimer' => array(
			'value' => false,
			'name' => __('Show bar timer', 'LayerSlider'),
			'keys' => array('bartimer', 'showBarTimer'),
			'desc' => __('Show the bar timer to indicate slideshow progression.', 'LayerSlider')
		),

		// Show circle timer. Requires CSS3 capable browser.
		// This setting will overrule the 'barTimer' option.
		'circleTimer' => array(
			'value' => true,
			'name' => __('Show circle timer', 'LayerSlider'),
			'keys' => array('circletimer', 'showCircleTimer'),
			'desc' => __('Use circle timer to indicate slideshow progression.', 'LayerSlider')
		),

		'slideBarTimer' => array(
			'value' => false,
			'name' => __('Show slidebar timer', 'LayerSlider'),
			'keys' => array('slidebartimer', 'showSlideBarTimer'),
			'desc' => __('You can grab the slidebar timer playhead and seek the whole slide real-time like a movie.', 'LayerSlider')
		),

		// ========================== //
		// |  Thumbnail navigation  | //
		// ========================== //

		// Use thumbnails for slide buttons
		// Depends on: navSlideButtons.
		// Possible values: 'disabled', 'hover', 'always'
		'thumbnailNavigation' => array(
			'value' => 'hover',
			'name' => __('Thumbnail navigation', 'LayerSlider'),
			'keys' => array('thumb_nav', 'thumbnailNavigation'),
			'desc' => __('Use thumbnail navigation instead of slide bullet buttons.', 'LayerSlider'),
			'options' => array(
				'disabled' => __('Disabled', 'LayerSlider'),
				'hover' => __('Hover', 'LayerSlider'),
				'always' => __('Always', 'LayerSlider')
			)
		),

		// The width of the thumbnail area in percents.
		'thumbnailAreaWidth' => array(
			'value' => '60%',
			'name' => __('Thumbnail container width', 'LayerSlider'),
			'keys' => array('thumb_container_width', 'tnContainerWidth'),
			'desc' => __('The width of the thumbnail area.', 'LayerSlider')
		),

		// Thumbnails' width in pixels.
		'thumbnailWidth' => array(
			'value' => 100,
			'name' => __('Thumbnail width', 'LayerSlider'),
			'keys' => array('thumb_width', 'tnWidth'),
			'desc' => __('The width of thumbnails in the navigation area.', 'LayerSlider'),
			'attrs' => array(
				'min' => 0
			)
		),

		// Thumbnails' height in pixels.
		'thumbnailHeight' => array(
			'value' => 60,
			'name' => __('Thumbnail height', 'LayerSlider'),
			'keys' => array('thumb_height', 'tnHeight'),
			'desc' => __('The height of thumbnails in the navigation area.', 'LayerSlider'),
			'attrs' => array(
				'min' => 0
			)
		),


		// The opacity of the active thumbnail in percents.
		'thumbnailActiveOpacity' => array(
			'value' => 35,
			'name' => __('Active thumbnail opacity', 'LayerSlider'),
			'keys' => array('thumb_active_opacity', 'tnActiveOpacity'),
			'desc' => __("Opacity in percentage of the active slide's thumbnail.", "LayerSlider"),
			'attrs' => array(
				'min' => 0,
				'max' => 100
			)
		),

		// The opacity of inactive thumbnails in percents.
		'thumbnailInactiveOpacity' => array(
			'value' => 100,
			'name' => __('Inactive thumbnail opacity', 'LayerSlider'),
			'keys' => array('thumb_inactive_opacity', 'tnInactiveOpacity'),
			'desc' => __('Opacity in percentage of inactive slide thumbnails.', 'LayerSlider'),
			'attrs' => array(
				'min' => 0,
				'max' => 100
			)
		),

		// ============ //
		// |  Videos  | //
		// ============ //

		// Automatically starts vidoes on the given slide.
		'autoPlayVideos' => array(
			'value' => true,
			'name' => __('Automatically play videos', 'LayerSlider'),
			'keys' => array('autoplayvideos', 'autoPlayVideos'),
			'desc' => __('Videos will be automatically started on the active slide.', 'LayerSlider')
		),

		// Automatically pauses the slideshow when a video is playing.
		// Auto means it only pauses the slideshow while the video is playing.
		// Possible values: 'auto', 'enabled', 'disabled'
		'autoPauseSlideshow' => array(
			'value' => 'auto',
			'name' => __('Pause slideshow', 'LayerSlider'),
			'keys' => array('autopauseslideshow', 'autoPauseSlideshow'),
			'desc' => __('The slideshow can temporally be paused while videos are playing. You can choose to permanently stop the pause until manual restarting.', 'LayerSlider'),
			'options' => array(
				'auto' => __('While playing', 'LayerSlider'),
				'enabled' => __('Permanently', 'LayerSlider'),
				'disabled' => __('No action', 'LayerSlider')
			)
		),

		// The preview image quality of a YouTube video.
		// Some videos doesn't have HD preview images and
		// you may have to lower the quality settings.
		// Possible values:
			// 'maxresdefault.jpg',
			// 'hqdefault.jpg',
			// 'mqdefault.jpg',
			// 'default.jpg'
		'youtubePreviewQuality' => array(
			'value' => 'maxresdefault.jpg',
			'name' => __('Youtube preview', 'LayerSlider'),
			'keys' => array('youtubepreview', 'youtubePreview'),
			'desc' => __('The automatically fetched preview image quaility for YouTube videos when you do not set your own. Please note, some videos do not have HD previews, and you may need to choose a lower quaility.', 'LayerSlider'),
			'options' => array(
				'maxresdefault.jpg' => __('Maximum quality', 'LayerSlider'),
				'hqdefault.jpg' => __('High quality', 'LayerSlider'),
				'mqdefault.jpg' => __('Medium quality', 'LayerSlider'),
				'default.jpg' => __('Default quality', 'LayerSlider')
			)
		),

		// ========== //
		// |  Misc  | //
		// ========== //


		// Ignores the host/domain names in URLS by converting the to
		// relative format. Useful when you move your site.
		// Prevents linking content from 3rd party servers.
		'relativeURLs' => array(
			'value' => false,
			'name' => __('Use relative URLs', 'LayerSlider'),
			'keys' => 'relativeurls',
			'desc' => __('Use relative URLs for local images. This setting could be important when moving your WP installation.', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'allowRestartOnResize' => array(
			'value' => false,
			'name' => __('Allow restarting slides on resize', 'LayerSlider'),
			'keys' => 'allowRestartOnResize',
			'desc' => __('Certain transformation and transition options cannot be updated on the fly when the browser size or device orientation changes. By keeping this option enabled, the slider will automatically detect such situations and will restart the current slider to preserve its appearance.', 'LayerSlider'),
			'advanced' => true
		),

		'useSrcset' => array(
			'value' => true,
			'name' => __('Use srcset attribute', 'LayerSlider'),
			'keys' => 'useSrcset',
			'desc' => __('The srcset attribute allows loading dynamically scaled images based on screen resolution. It can save bandwidth and allow using retina-ready images on high resolution devices. In some rare edge cases, this option might cause blurry images.', 'LayerSlider')
		),


		// ============== //
		// |  YourLogo  | //
		// ============== //

		// Places a fixed image on the top of the slider.
		'yourLogoImage' => array(
			'value' => '',
			'name' => __('YourLogo', 'LayerSlider'),
			'keys' => array('yourlogo', 'yourLogo'),
			'desc' => __('A fixed image layer can be shown above the slider that remains still during slide progression. Can be used to display logos or watermarks.', 'LayerSlider')
		),

		// Custom CSS style settings for the YourLogo image.
		// Depends on: yourLogoImage
		'yourLogoStyle' => array(
			'value' => 'left: -10px; top: -10px;',
			'name' => __('YourLogo style', 'LayerSlider'),
			'keys' => array('yourlogostyle', 'yourLogoStyle'),
			'desc' => __('CSS properties to control the image placement and appearance.', 'LayerSlider')
		),

		// Linking the YourLogo image to a given URL.
		// Depends on: yourLogoImage
		'yourLogoLink' => array(
			'value' => '',
			'name' => __('YourLogo link', 'LayerSlider'),
			'keys' => array('yourlogolink', 'yourLogoLink'),
			'desc' => __('Enter an URL to link the YourLogo image.', 'LayerSlider')
		),

		// Link target for yourLogoLink.
		// Depends on: yourLogoLink
		'yourLogoTarget' => array(
			'value' => '_self',
			'name' => __('Link target', 'LayerSlider'),
			'keys' => array('yourlogotarget', 'yourLogoTarget'),
			'desc' => '',
			'options' => array(
				'_self' => __('Open on the same page', 'LayerSlider'),
				'_blank' => __('Open on new page', 'LayerSlider'),
				'_parent' => __('Open in parent frame', 'LayerSlider'),
				'_top' => __('Open in main frame', 'LayerSlider')
			),
		),

		// Post options
		'postType' => array(
			'value' => '',
			'keys' => 'post_type',
			'props' => array(
				'meta' => true
			)
		),

		'postOrderBy' => array(
			'value' => 'date',
			'keys' => 'post_orderby',
			'options' => array(
				'date' => __('Date Created', 'LayerSlider'),
				'modified' => __('Last Modified', 'LayerSlider'),
				'ID' => __('Post ID', 'LayerSlider'),
				'title' => __('Post Title', 'LayerSlider'),
				'comment_count' => __('Number of Comments', 'LayerSlider'),
				'rand' => __('Random', 'LayerSlider')
			),
			'props' => array(
				'meta' => true
			)
		),

		'postOrder' => array(
			'value' => 'DESC',
			'keys' => 'post_order',
			'options' => array(
				'ASC' => __('Ascending', 'LayerSlider'),
				'DESC' => __('Descending', 'LayerSlider')
			),
			'props' => array(
				'meta' => true
			)
		),

		'postCategories' => array(
			'value' => '',
			'keys' => 'post_categories',
			'props' => array(
				'meta' => true
			)
		),

		'postTags' => array(
			'value' => '',
			'keys' => 'post_tags',
			'props' => array(
				'meta' => true
			)
		),

		'postTaxonomy' => array(
			'value' => '',
			'keys' => 'post_taxonomy',
			'props' => array(
				'meta' => true
			)
		),

		'postTaxTerms' => array(
			'value' => '',
			'keys' => 'post_tax_terms',
			'props' => array(
				'meta' => true
			)
		),

		// Old and obsolete API
		'cbInit' => array(
			'value' => "function(element) {\r\n\r\n}",
			'keys' => array('cbinit','cbInit'),
			'props' => array(
				'meta' => true
			)
		),

		'cbStart' => array(
			'value' => "function(data) {\r\n\r\n}",
			'keys' => array('cbstart','cbStart'),
			'props' => array(
				'meta' => true
			)
		),

		'cbStop' => array(
			'value' => "function(data) {\r\n\r\n}",
			'keys' => array('cbstop','cbStop'),
			'props' => array(
				'meta' => true
			)
		),

		'cbPause' => array(
			'value' => "function(data) {\r\n\r\n}",
			'keys' => array('cbpause','cbPause'),
			'props' => array(
				'meta' => true
			)
		),

		'cbAnimStart' => array(
			'value' => "function(data) {\r\n\r\n}",
			'keys' => array('cbanimstart','cbAnimStart'),
			'props' => array(
				'meta' => true
			)
		),

		'cbAnimStop' => array(
			'value' => "function(data) {\r\n\r\n}",
			'keys' => array('cbanimstop','cbAnimStop'),
			'props' => array(
				'meta' => true
			)
		),

		'cbPrev' => array(
			'value' => "function(data) {\r\n\r\n}",
			'keys' => array('cbprev','cbPrev'),
			'props' => array(
				'meta' => true
			)
		),

		'cbNext' => array(
			'value' => "function(data) {\r\n\r\n}",
			'keys' => array('cbnext','cbNext'),
			'props' => array(
				'meta' => true
			)
		),
	),

	'slides' => array(

		// The background image of slides
		// Defaults to: void
		'image' => array (
			'value' => '',
			'name' => __('Set a slide image', 'LayerSlider'),
			'keys' => 'background',
			'tooltip' => __('The slide image/background. Click on the image to open the WordPress Media Library to choose or upload an image.', 'LayerSlider'),
			'props' => array( 'meta' => true )
		),

		'imageId' => array (
			'value' => '',
			'keys' => 'backgroundId',
			'props' => array( 'meta' => true )
		),

		'imageSize' => array(
			'value' => 'inherit',
			'name' => __('Size', 'LayerSlider'),
			'keys' => 'bgsize',
			'tooltip' => __('Global background size of the slider. You can set the size in pixel or percent or constants: auto | cover | contain | stretch ', 'LayerSlider'),
			'options' => array(
				'inherit' => __('Inherit', 'LayerSlider'),
				'auto' => __('Auto', 'LayerSlider'),
				'cover' => __('Cover', 'LayerSlider'),
				'contain' => __('Contain', 'LayerSlider'),
				'100% 100%' => __('Stretch', 'LayerSlider')
			)
		),

		'imagePosition' => array(
			'value' => 'inherit',
			'name' => __('Position', 'LayerSlider'),
			'keys' => 'bgposition',
			'tooltip' => __('Global background image position of the slider. The first value is the horizontal position and the second value is the vertical.', 'LayerSlider'),
			'options' => array(
				'inherit' => __('Inherit', 'LayerSlider'),
				'0% 0%' => __('left top', 'LayerSlider'),
				'0% 50%' => __('left center', 'LayerSlider'),
				'0% 100%' => __('left bottom', 'LayerSlider'),
				'50% 0%' => __('center top', 'LayerSlider'),
				'50% 50%' => __('center center', 'LayerSlider'),
				'50% 100%' => __('center bottom', 'LayerSlider'),
				'100% 0%' => __('right top', 'LayerSlider'),
				'100% 50%' => __('right center', 'LayerSlider'),
				'100% 100%' => __('right bottom', 'LayerSlider')
			)
		),

		'imageColor' => array(
			'value' => '',
			'name' => __('Color', 'LayerSlider'),
			'keys' => 'bgcolor',
			'tooltip' => __('Global background size of the slider. You can set the size in pixel or percent or constants: auto | cover | contain ', 'LayerSlider')
		),

		'thumbnail' => array (
			'value' => '',
			'name' => __('Set a slide thumbnail', 'LayerSlider'),
			'keys' => 'thumbnail',
			'tooltip' => __('The thumbnail image of this slide. Click on the image to open the WordPress Media Library to choose or upload an image. If you leave this field empty, the slide image will be used.', 'LayerSlider'),
			'props' => array( 'meta' => true )
		),

		'thumbnailId' => array (
			'value' => '',
			'keys' => 'thumbnailId',
			'props' => array( 'meta' => true )
		),

		// Default slide delay in millisecs.
		// Defaults to: 4000 (ms) => 4secs
		'delay' => array(
			'value' => '',
			'name' => __('Duration', 'LayerSlider'),
			'keys' => array('slidedelay', 'duration'),
			'tooltip' => __("Here you can set the time interval between slide changes, this slide will stay visible for the time specified here. This value is in millisecs, so the value 1000 means 1 second. Please don't use 0 or very low values.", "LayerSlider"),
			'attrs' => array(
				'type' => 'number',
				'min' => 0,
				'step' => 500,
				'placeholder' => 'auto'
			)
		),

		'2dTransitions' => array(
			'value' => '',
			'keys' => array('2d_transitions', 'transition2d')
		),

		'3dTransitions' => array(
			'value' => '',
			'keys' => array('3d_transitions', 'transition3d')
		),

		'custom2dTransitions' => array(
			'value' => '',
			'keys' => array('custom_2d_transitions', 'customtransition2d')
		),

		'custom3dTransitions' => array(
			'value' => '',
			'keys' => array('custom_3d_transitions', 'customtransition3d')
		),

		'transitionDuration' => array(
			'value' => '',
			'name' => __('Duration', 'LayerSlider'),
			'keys' => 'transitionduration',
			'tooltip' => __("We've made our pre-defined slide transitions with special care to fit in most use cases. However, if you would like to increase or decrease the speed of these transitions, you can override their timing here by providing your own transition length in milliseconds. (1 second = 1000 milliseconds)", "LayerSlider"),
			'attrs' => array(
				'type' => 'number',
				'min' => 0,
				'step' => 500,
				'placeholder' => __( 'custom duration', 'LayerSlider' )
			)

		),

		'timeshift' => array(
			'value' => 0,
			'name' => __('Time Shift', 'LayerSlider'),
			'keys' => 'timeshift',
			'tooltip' => __("You can shift the starting point of the slide animation timeline, so layers can animate in an earlier or later time after a slide change. This value is in milliseconds. A second is 1000 milliseconds.", 'LayerSlider'),
			'attrs' => array(
				'step' => 50
			)
		),

		'linkUrl' => array(
			'value' => '',
			'name' => __('Enter URL', 'LayerSlider'),
			'keys' => array('layer_link', 'linkUrl'),
			'tooltip' => __('If you want to link the whole slide, enter the URL of your link here.', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)

		),

		'linkTarget' => array(
			'value' => '_self',
			'name' => __('Link Target', 'LayerSlider'),
			'keys' => array('layer_link_target', 'linkTarget'),
			'options' => array(
				'_self' => __('Open on the same page', 'LayerSlider'),
				'_blank' => __('Open on new page', 'LayerSlider'),
				'_parent' => __('Open in parent frame', 'LayerSlider'),
				'_top' => __('Open in main frame', 'LayerSlider'),
				'ls-scroll' => __('Scroll to element (Enter selector)', 'LayerSlider')
			),
			'props' => array(
				'meta' => true
			)

		),

		'ID' => array(
			'value' => '',
			'name' => __('#ID', 'LayerSlider'),
			'keys' => 'id',
			'tooltip' => __('You can apply an ID attribute on the HTML element of this slide to work with it in your custom CSS or Javascript code.', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'deeplink' => array(
			'value' => '',
			'name' => __('Deeplink', 'LayerSlider'),
			'keys' => 'deeplink',
			'tooltip' => __('You can specify a slide alias name which you can use in your URLs with a hash mark, so LayerSlider will start with the correspondig slide.', 'LayerSlider')
		),

		'postContent' => array(
			'value' => null,
			'keys' => 'post_content',
			'props' => array(
				'meta' => true
			)
		),


		'postOffset' => array(
			'value' => '',
			'keys' => 'post_offset',
			'props' => array(
				'meta' => true
			)
		),

		'skipSlide' => array(
			'value' => false,
			'name' => __('Hidden', 'LayerSlider'),
			'keys' => 'skip',
			'tooltip' => __("If you don't want to use this slide in your front-page, but you want to keep it, you can hide it with this switch.", 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),


		'overflow' => array(
			'value' => false,
			'name' => __('Overflow layers', 'LayerSlider'),
			'keys' => 'overflow',
			'tooltip' => __('By default the slider clips content outside of its bounds. Enable this option to allow overflowing content.', 'LayerSlider')
		),

		// Ken Burns effect
		'kenBurnsZoom' => array(
			'value' => 'disabled',
			'name' => __('Zoom', 'LayerSlider'),
			'keys' => 'kenburnszoom',
			'options' => array(
				'disabled' => __('Disabled', 'LayerSlider'),
				'in' => __('Zoom In', 'LayerSlider'),
				'out' => __('Zoom Out', 'LayerSlider'),
			)
		),

		'kenBurnsRotate' => array(
			'value' => '',
			'name' => __('Rotate', 'LayerSlider'),
			'keys' => 'kenburnsrotate',
			'tooltip' => __('The amount of rotation (if any) in degrees in the Ken Burns effect. Negative values are allowed for counterclockwise rotation.', 'LayerSlider'),

		),

		'kenBurnsScale' => array(
			'value' => 1.2,
			'name' => __('Scale', 'LayerSlider'),
			'keys' => 'kenburnsscale',
			'tooltip' => __('Increase or decrease the size of the slide background image in the Ken Burns effect. The default value is 1, the value 2 will double the image, while 0.5 results half the size. Negative values will flip the image.', 'LayerSlider'),
			'attrs' => array(
				'type' => 'number',
				'step' => 0.1
			),
			'props' => array(
				'output' => true
			)
		),


		// Parallax
		'parallaxType' => array(
			'value' => '2d',
			'name' => __('Type', 'LayerSlider'),
			'keys' => 'parallaxtype',
			'tooltip' => __('The default value for parallax layers on this slide, which they will inherit, unless you set it otherwise on the affected layers.', 'LayerSlider'),
			'options' => array(
				'2d' => __('2D', 'LayerSlider'),
				'3d' => __('3D', 'LayerSlider')
 			)
		),

		'parallaxEvent' => array(
			'value' => 'cursor',
			'name' => __('Event', 'LayerSlider'),
			'keys' => 'parallaxevent',
			'tooltip' => __('You can trigger the parallax effect by either scrolling the page, or by moving your mouse cursor / tilting your mobile device. This is the default value on this slide, which parallax layers will inherit, unless you set it otherwise directly on them.', 'LayerSlider'),
			'options' => array(
				'cursor' => __('Cursor or Tilt', 'LayerSlider'),
				'scroll' => __('Scroll', 'LayerSlider')
 			)
		),

		'parallaxAxis' => array(
			'value' => 'both',
			'name' => __('Axes', 'LayerSlider'),
			'keys' => 'parallaxaxis',
			'tooltip' => __('Choose on which axes parallax layers should move. This is the default value on this slide, which parallax layers will inherit, unless you set it otherwise directly on them.', 'LayerSlider'),
			'options' => array(
				'none' => __('None', 'LayerSlider'),
				'both' => __('Both axes', 'LayerSlider'),
				'x' => __('Horizontal only', 'LayerSlider'),
				'y' => __('Vertical only', 'LayerSlider')
			)
		),


		'parallaxTransformOrigin' => array(
			'value' => '50% 50% 0',
			'name' => __('Transform Origin', 'LayerSlider'),
			'keys' => 'parallaxtransformorigin',
			'tooltip' => __('Sets a point on canvas from which transformations are calculated. For example, a layer may rotate around its center axis or a completely custom point, such as one of its corners. The three values represent the X, Y and Z axes in 3D space. Apart from the pixel and percentage values, you can also use the following constants: top, right, bottom, left, center.', 'LayerSlider')
		),

		'parallaxDurationMove' => array(
			'value' => 1500,
			'name' => __('Move duration', 'LayerSlider'),
			'keys' => 'parallaxdurationmove',
			'tooltip' => __('Controls the speed of animating layers when you move your mouse cursor or tilt your mobile device. This is the default value on this slide, which parallax layers will inherit, unless you set it otherwise directly on them.', 'LayerSlider'),
			'attrs' => array(
				'type' => 'number',
				'step' => 100,
				'min' => 0
			)
		),

		'parallaxDurationLeave' => array(
			'value' => 1200,
			'name' => __('Leave duration', 'LayerSlider'),
			'keys' => 'parallaxdurationleave',
			'tooltip' => __('Controls how quickly your layers revert to their original position when you move your mouse cursor outside of a parallax slider. This value is in milliseconds. 1 second = 1000 milliseconds. This is the default value on this slide, which parallax layers will inherit, unless you set it otherwise directly on them.', 'LayerSlider'),
			'attrs' => array(
				'type' => 'number',
				'step' => 100,
				'min' => 0
			)
		),

		'parallaxDistance' => array(
			'value' => 10,
			'name' => __('Distance', 'LayerSlider'),
			'keys' => 'parallaxdistance',
			'tooltip' => __('Increase or decrease the amount of layer movement when moving your mouse cursor or tilting on a mobile device. This is the default value on this slide, which parallax layers will inherit, unless you set it otherwise directly on them.', 'LayerSlider'),
			'attrs' => array(
				'type' => 'number',
				'step' => 1
			)

		),

		'parallaxRotate' => array(
			'value' => 10,
			'name' => __('Rotation', 'LayerSlider'),
			'keys' => 'parallaxrotate',
			'tooltip' => __('Increase or decrease the amount of layer rotation in the 3D space when moving your mouse cursor or tilting on a mobile device. This is the default value on this slide, which parallax layers will inherit, unless you set it otherwise directly on them.', 'LayerSlider'),
			'attrs' => array(
				'type' => 'number',
				'step' => 1
			)
		),

		'parallaxPerspective' => array(
			'value' => 500,
			'name' => __('Perspective', 'LayerSlider'),
			'keys' => 'parallaxtransformperspective',
			'tooltip' => __('Changes the perspective of layers in the 3D space. This is the default value on this slide, which parallax layers will inherit, unless you set it otherwise directly on them.', 'LayerSlider'),
			'attrs' => array(
				'type' => 'number',
				'step' => 100
			)
		),

		// 'filterFrom' => array(
		// 	'value' => '',
		// 	'name' => __('Filter From', 'LayerSlider'),
		// 	'keys' => 'filterfrom',
		// 	'tooltip' => __('Filters provide effects like blurring or color shifting your layers. Click into the text field to see a selection of filters you can use. Although clicking on the pre-defined options will reset the text field, you can apply multiple filters simply by providing a space separated list of all the filters you would like to use.', 'LayerSlider'),
		// 	'advanced' => true,
		// 	'attrs' => array(
		// 		'data-options' => '[{
		// 			"name": "Blur",
		// 			"value": "blur(5px)"
		// 		}, {
		// 			"name": "Brightness",
		// 			"value": "brightness(40%)"
		// 		}, {
		// 			"name": "Contrast",
		// 			"value": "contrast(200%)"
		// 		}, {
		// 			"name": "Grayscale",
		// 			"value": "grayscale(50%)"
		// 		}, {
		// 			"name": "Hue-rotate",
		// 			"value": "hue-rotate(90deg)"
		// 		}, {
		// 			"name": "Invert",
		// 			"value": "invert(75%)"
		// 		}, {

		// 			"name": "Saturate",
		// 			"value": "saturate(30%)"
		// 		}, {
		// 			"name": "Sepia",
		// 			"value": "sepia(60%)"
		// 		}]'
		// 	)
		// ),

		// 'filterTo' => array(
		// 	'value' => '',
		// 	'name' => __('Filter To', 'LayerSlider'),
		// 	'keys' => 'filterto',
		// 	'tooltip' => __('Filters provide effects like blurring or color shifting your layers. Click into the text field to see a selection of filters you can use. Although clicking on the pre-defined options will reset the text field, you can apply multiple filters simply by providing a space separated list of all the filters you would like to use.', 'LayerSlider'),
		// 	'advanced' => true,
		// 	'attrs' => array(
		// 		'data-options' => '[{
		// 			"name": "Blur",
		// 			"value": "blur(5px)"
		// 		}, {
		// 			"name": "Brightness",
		// 			"value": "brightness(40%)"
		// 		}, {
		// 			"name": "Contrast",
		// 			"value": "contrast(200%)"
		// 		}, {
		// 			"name": "Grayscale",
		// 			"value": "grayscale(50%)"
		// 		}, {
		// 			"name": "Hue-rotate",
		// 			"value": "hue-rotate(90deg)"
		// 		}, {
		// 			"name": "Invert",
		// 			"value": "invert(75%)"
		// 		}, {

		// 			"name": "Saturate",
		// 			"value": "saturate(30%)"
		// 		}, {
		// 			"name": "Sepia",
		// 			"value": "sepia(60%)"
		// 		}]'
		// 	)
		// )
	),

	'layers' => array(

		// ======================= //
		// |  Content  | //
		// ======================= //

		'type' => array(
			'value' => '',
			'keys' => 'type',
			'props' => array(
				'meta' => true
			)
		),

		'hide_on_desktop' => array(
			'value' => false,
			'keys' => 'hide_on_desktop',
			'props' => array(
				'meta' => true
			)
		),

		'hide_on_tablet' => array(
			'value' => false,
			'keys' => 'hide_on_tablet',
			'props' => array(
				'meta' => true
			)
		),

		'hide_on_phone' => array(
			'value' => false,
			'keys' => 'hide_on_phone',
			'props' => array(
				'meta' => true
			)
		),

		'media' => array(
			'value' => '',
			'keys' => 'media',
			'props' => array(
				'meta' => true
			)
		),

		'image' => array(
			'value' => '',
			'keys' => 'image',
			'props' => array(
				'meta' => true
			)
		),

		'imageId' => array(
			'value' => '',
			'keys' => 'imageId',
			'props' => array( 'meta' => true )
		),

		'html' => array(
			'value' => '',
			'keys' => 'html',
			'props' => array(
				'meta' => true
			)
		),

		'mediaAutoPlay' => array(
			'value' => 'inherit',
			'name' => __('Autoplay', 'LayerSlider'),
			'keys' => 'autoplay',
			'options' => array(
				'inherit' => __('Inherit', 'LayerSlider'),
				'enabled' => __('Enabled', 'LayerSlider'),
				'disabled' => __('Disabled', 'LayerSlider')
			)
		),

		'mediaInfo' => array(
			'value' => true,
			'name' => __('Show Info', 'LayerSlider'),
			'keys' => 'showinfo'
		),

		'mediaControls' => array(
			'value' => true,
			'name' => __('Controls', 'LayerSlider'),
			'keys' => 'controls'
		),


		'mediaPoster' => array(
			'value' => '',
			'keys' => 'poster',
		),


		'mediaFillMode' => array(
			'value' => 'cover',
			'name' => __('Fill mode', 'LayerSlider'),
			'keys' => 'fillmode',
			'options' => array(
				'contain'  => __('Contain', 'LayerSlider'),
				'cover'  => __('Cover', 'LayerSlider')
			)
		),


		'mediaVolume' => array(
			'value' => '',
			'name' => __('Volume', 'LayerSlider'),
			'keys' => 'volume',
			'attrs' => array(
				'type' => 'number',
				'min' => 0,
				'max' => 100,
				'placeholder' => 'auto'
			)
		),

		'mediaBackgroundVideo' => array(
			'value' => false,
			'name' => __('Use this video as slide background', 'LayerSlider'),
			'keys' => 'backgroundvideo',
			'tooltip' => __('Forces this layer to act like the slide background by covering the whole slider and ignoring some transitions. Please make sure to provide your own poster image with the option above, so the slider can display it immediately on page load.', 'LayerSlider')
		),

		'mediaOverlay' => array(
			'value' => 'disabled',
			'name' => __('Choose an overlay image:', 'LayerSlider'),
			'keys' => 'overlay',
			'tooltip' => __('Cover your videos with an overlay image to have dotted or striped effects on them.', 'LayerSlider')
		),


		'postTextLength' => array(
			'value' => '',
			'keys' => 'post_text_length',
			'props' => array(
				'meta' => true
			)
		),


		// ======================= //
		// |  Animation options  | //
		// ======================= //
		'transition' => array( 'value' => '', 'keys' => 'transition', 'props' => array( 'meta' => true )),

		'transitionIn' => array(
			'value' => true,
			'keys' => 'transitionin'
		),

		'transitionInOffsetX' => array(
			'value' => '0',
			'name' => __('OffsetX', 'LayerSlider'),
			'keys' => 'offsetxin',
			'tooltip' => __("Shifts the layer starting position from its original on the horizontal axis with the given number of pixels. Use negative values for the opposite direction. Percentage values are relative to the width of this layer. The values 'left' or 'right' position the layer out the staging area, so it enters the scene from either side when animating to its destination location.", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Enter the stage from left",
				"value": "left"
			}, {
				"name": "Enter the stage from right",
				"value": "right"
			}, {
				"name": "100% layer width",
				"value": "100lw"
			}, {
				"name": "-100% layer width",
				"value": "-100lw"
			}, {
				"name": "50% slider width",
				"value": "50sw"
			}, {
				"name": "-50% slider width",
				"value": "-50sw"
			}, {
				"name": "Random",
				"value": "random(-100,100)"
			}]')
		),

		'transitionInOffsetY' => array(
			'value' => '0',
			'name' => __('OffsetY', 'LayerSlider'),
			'keys' => 'offsetyin',
			'tooltip' => __("Shifts the layer starting position from its original on the vertical axis with the given number of pixels. Use negative values for the opposite direction. Percentage values are relative to the height of this layer. The values 'top' or 'bottom' position the layer out the staging area, so it enters the scene from either vertical side when animating to its destination location.", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Enter the stage from top",
				"value": "top"
			}, {
				"name": "Enter the stage from bottom",
				"value": "bottom"
			}, {
				"name": "100% layer height",
				"value": "100lh"
			}, {
				"name": "-100% layer height",
				"value": "-100lh"
			}, {
				"name": "50% slider height",
				"value": "50sh"
			}, {
				"name": "-50% slider height",
				"value": "-50sh"
			}, {
				"name": "Random",
				"value": "random(-100,100)"
			}]')
		),

		// Duration of the transition in millisecs when a layer animates in.
		// Original: durationin
		// Defaults to: 1000 (ms) => 1sec
		'transitionInDuration' => array(
			'value' => 1000,
			'name' => __('Duration', 'LayerSlider'),
			'keys' => 'durationin',
			'tooltip' => __('The length of the transition in milliseconds when the layer enters the scene. A second equals to 1000 milliseconds.', 'LayerSlider'),
			'attrs' => array( 'min' => 0, 'step' => 50 )
		),

		// Delay before the transition in millisecs when a layer animates in.
		// Original: delayin
		// Defaults to: 0 (ms)
		'transitionInDelay' => array(
			'value' => 0,
			'name' => __('Start at', 'LayerSlider'),
			'keys' => 'delayin',
			'tooltip' => __('Delays the transition with the given amount of milliseconds before the layer enters the scene. A second equals to 1000 milliseconds.', 'LayerSlider'),
			'attrs' => array( 'min' => 0, 'step' => 50 )
		),

		// Easing of the transition when a layer animates in.
		// Original: easingin
		// Defaults to: 'easeInOutQuint'
		'transitionInEasing' => array(
			'value' => 'easeInOutQuint',
			'name' => __('Easing', 'LayerSlider'),
			'keys' => 'easingin',
			'tooltip' => __("The timing function of the animation. With this function you can manipulate the movement of the animated object. Please click on the link next to this select field to open easings.net for more information and real-time examples.", "LayerSlider")
		),

		'transitionInFade' => array(
			'value' => true,
			'name' => __('Fade', 'LayerSlider'),
			'keys' => 'fadein',
			'tooltip' => __('Fade the layer during the transition.', 'LayerSlider'),
		),

		// Initial rotation degrees when a layer animates in.
		// Original: rotatein
		// Defaults to: 0 (deg)
		'transitionInRotate' => array(
			'value' => 0,
			'name' => __('Rotate', 'LayerSlider'),
			'keys' => 'rotatein',
			'tooltip' => __('Rotates the layer by the given number of degrees. Negative values are allowed for counterclockwise rotation.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'transitionInRotateX' => array(
			'value' => 0,
			'name' => __('RotateX', 'LayerSlider'),
			'keys' => 'rotatexin',
			'tooltip' => __('Rotates the layer along the X (horizontal) axis by the given number of degrees. Negative values are allowed for reverse direction.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'transitionInRotateY' => array(
			'value' => 0,
			'name' => __('RotateY', 'LayerSlider'),
			'keys' => 'rotateyin',
			'tooltip' => __('Rotates the layer along the Y (vertical) axis by the given number of degrees. Negative values are allowed for reverse direction.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'transitionInSkewX' => array(
			'value' => 0,
			'name' => __('SkewX', 'LayerSlider'),
			'keys' => 'skewxin',
			'tooltip' => __('Skews the layer along the X (horizontal) by the given number of degrees. Negative values are allowed for reverse direction.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'transitionInSkewY' => array(
			'value' => 0,
			'name' => __('SkewY', 'LayerSlider'),
			'keys' => 'skewyin',
			'tooltip' => __('Skews the layer along the Y (vertical) by the given number of degrees. Negative values are allowed for reverse direction.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'transitionInScaleX' => array(
			'value' => 1,
			'name' => __('ScaleX', 'LayerSlider'),
			'keys' => 'scalexin',
			'tooltip' => __("Scales the layer along the X (horizontal) axis by the specified vector. Use the value 1 for the original size. The value 2 will double, while 0.5 shrinks the layer compared to its original size.", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(2,4)"
			}]')
		),

		'transitionInScaleY' => array(
			'value' => 1,
			'name' => __('ScaleY', 'LayerSlider'),
			'keys' => 'scaleyin',
			'tooltip' => __("Scales the layer along the Y (vertical) axis by the specified vector. Use the value 1 for the original size. The value 2 will double, while 0.5 shrinks the layer compared to its original size.", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(2,4)"
			}]')
		),

		'transitionInTransformOrigin' => array(
			'value' => '50% 50% 0',
			'name' => __('Transform Origin', 'LayerSlider'),
			'keys' => 'transformoriginin',
			'tooltip' => __('Sets a point on canvas from which transformations are calculated. For example, a layer may rotate around its center axis or a completely custom point, such as one of its corners. The three values represent the X, Y and Z axes in 3D space. Apart from the pixel and percentage values, you can also use the following constants: top, right, bottom, left, center, slidercenter, slidermiddle, slidertop, sliderright, sliderbottom, sliderleft.', 'LayerSlider'),
		),

		'transitionInClip' => array(
			'value' => '',
			'name' => __('Mask', 'LayerSlider'),
			'keys' => 'clipin',
			'tooltip' => __("Clips (cuts off) the sides of the layer by the given amount specified in pixels or percentages. The 4 value in order: top, right, bottom and the left side of the layer.", "LayerSlider"),
			'attrs' => array('data-options' => '[{
				"name": "From top",
				"value": "0 0 100% 0"
			}, {
				"name": "From right",
				"value": "0 0 0 100%"
			}, {
				"name": "From bottom",
				"value": "100% 0 0 0"
			}, {
				"name": "From left",
				"value": "0 100% 0 0"
			}]')
		),

		'transitionInBGColor' => array(
			'value' => '',
			'name' => __('Background', 'LayerSlider'),
			'keys' => 'bgcolorin',
			'tooltip' => __("The background color of your layer. You can use color names, hexadecimal, RGB or RGBA values as well as the 'transparent' keyword. Example: #FFF", 'LayerSlider'),
		),

		'transitionInColor' => array(
			'value' => '',
			'name' => __('Color', 'LayerSlider'),
			'keys' => 'colorin',
			'tooltip' => __("The color of your text. You can use color names, hexadecimal, RGB or RGBA values. Example: #333", 'LayerSlider'),
		),

		'transitionInRadius' => array(
			'value' => '',
			'name' => __('Rounded Corners', 'LayerSlider'),
			'keys' => 'radiusin',
			'tooltip' => __('If you want rounded corners, you can set its radius here in pixels. Example: 5px', 'LayerSlider'),
		),

		'transitionInWidth' => array(
			'value' => '',
			'name' => __('Width', 'LayerSlider'),
			'keys' => 'widthin',
			'tooltip' => __('The initial width of this layer from which it will be animated to its proper size during the transition.', 'LayerSlider'),
		),

		'transitionInHeight' => array(
			'value' => '',
			'name' => __('Height', 'LayerSlider'),
			'keys' => 'heightin',
			'tooltip' => __('The initial height of this layer from which it will be animated to its proper size during the transition.', 'LayerSlider'),
		),

		'transitionInFilter' => array(
			'value' => '',
			'name' => __('Filter', 'LayerSlider'),
			'keys' => 'filterin',
			'tooltip' => __('Filters provide effects like blurring or color shifting your layers. Click into the text field to see a selection of filters you can use. Although clicking on the pre-defined options will reset the text field, you can apply multiple filters simply by providing a space separated list of all the filters you would like to use. Click on the "Filter" link for more information.', 'LayerSlider'),
			'premium' => true,
			'attrs' => array(
				'data-options' => '[{
					"name": "Blur",
					"value": "blur(5px)"
				}, {
					"name": "Brightness",
					"value": "brightness(40%)"
				}, {
					"name": "Contrast",
					"value": "contrast(200%)"
				}, {
					"name": "Grayscale",
					"value": "grayscale(50%)"
				}, {
					"name": "Hue-rotate",
					"value": "hue-rotate(90deg)"
				}, {
					"name": "Invert",
					"value": "invert(75%)"
				}, {
					"name": "Saturate",
					"value": "saturate(30%)"
				}, {
					"name": "Sepia",
					"value": "sepia(60%)"
				}]'
			)
		),

		'transitionInPerspective' => array(
			'value' => '500',
			'name' => __('Perspective', 'LayerSlider'),
			'keys' => 'transformperspectivein',
			'tooltip' => __('Changes the perspective of this layer in the 3D space.', 'LayerSlider')
		),

		// ======

		'transitionOut' => array(
			'value' => true,
			'keys' => 'transitionout'
		),

		'transitionOutOffsetX' => array(
			'value' => 0,
			'name' => __('OffsetX', 'LayerSlider'),
			'keys' => 'offsetxout',
			'tooltip' => __("Shifts the layer from its original position on the horizontal axis with the given number of pixels. Use negative values for the opposite direction. Percentage values are relative to the width of this layer. The values 'left' or 'right' animate the layer out the staging area, so it can leave the scene on either side.", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Leave the stage on left",
				"value": "left"
			}, {
				"name": "Leave the stage on right",
				"value": "right"
			}, {
				"name": "100% layer width",
				"value": "100lw"
			}, {
				"name": "-100% layer width",
				"value": "-100lw"
			}, {
				"name": "50% slider width",
				"value": "50sw"
			}, {
				"name": "-50% slider width",
				"value": "-50sw"
			}, {
				"name": "Random",
				"value": "random(-100,100)"
			}]')
		),

		'transitionOutOffsetY' => array(
			'value' => 0,
			'name' => __('OffsetY', 'LayerSlider'),
			'keys' => 'offsetyout',
			'tooltip' => __("Shifts the layer from its original position on the vertical axis with the given number of pixels. Use negative values for the opposite direction. Percentage values are relative to the height of this layer. The values 'top' or 'bottom' animate the layer out the staging area, so it can leave the scene on either vertical side.", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Leave the stage on top",
				"value": "top"
			}, {
				"name": "Leave the stage on bottom",
				"value": "bottom"
			}, {
				"name": "100% layer height",
				"value": "100lh"
			}, {
				"name": "-100% layer height",
				"value": "-100lh"
			}, {
				"name": "50% slider height",
				"value": "50sh"
			}, {
				"name": "-50% slider height",
				"value": "-50sh"
			}, {
				"name": "Random",
				"value": "random(-100,100)"
			}]')
		),

		// Duration of the transition in millisecs when a layer animates out.
		// Original: durationout
		// Defaults to: 1000 (ms) => 1sec
		'transitionOutDuration' => array(
			'value' => 1000,
			'name' => __('Duration', 'LayerSlider'),
			'keys' => 'durationout',
			'tooltip' => __('The length of the transition in milliseconds when the layer leaves the slide. A second equals to 1000 milliseconds.', 'LayerSlider'),
			'attrs' => array( 'min' => 0, 'step' => 50 )
		),

		'showUntil' => array(
			'value' => '0',
			'keys' => 'showuntil'
		),

		'transitionOutStartAt' => array(
			'value' => 'slidechangeonly',
			'name' => __('Start at', 'LayerSlider'),
			'keys' => 'startatout',
			'tooltip' => __('You can set the starting time of this transition. Use one of the pre-defined options to use relative timing, which can be shifted with custom operations.', 'LayerSlider'),
			'attrs' => array( 'type' => 'hidden' )
		),


		'transitionOutStartAtTiming' => array(
			'value' => 'slidechangeonly',
			'keys' => 'startatouttiming',
			'props' => array( 'meta' => true ),
			'options' => array(
				'slidechangeonly' => __('Slide change starts (ignoring modifier)', 'LayerSlider'),
				'transitioninend' => __('Opening Transition completes', 'LayerSlider'),
				'textinstart' => __('Opening Text Transition starts', 'LayerSlider'),
				'textinend' => __('Opening Text Transition completes', 'LayerSlider'),
				'allinend' => __('Opening and Opening Text Transition complete', 'LayerSlider'),
				'loopstart' => __('Loop starts', 'LayerSlider'),
				'loopend' => __('Loop completes', 'LayerSlider'),
				'transitioninandloopend' => __('Opening and Loop Transitions complete', 'LayerSlider'),
				'textinandloopend' => __('Opening Text and Loop Transitions complete', 'LayerSlider'),
				'allinandloopend' => __('Opening, Opening Text and Loop Transitions complete', 'LayerSlider'),
				'textoutstart' => __('Ending Text Transition starts', 'LayerSlider'),
				'textoutend' => __('Ending Text Transition completes', 'LayerSlider'),
				'textoutandloopend' => __('Ending Text and Loop Transitions complete', 'LayerSlider')
			)
		),

		'transitionOutStartAtOperator' => array(
			'value' => '+',
			'keys' => 'startatoutoperator',
			'props' => array( 'meta' => true ),
			'options' => array('+', '-', '/', '*')
		),

		'transitionOutStartAtValue' => array(
			'value' => 0,
			'keys' => 'startatoutvalue',
			'props' => array( 'meta' => true )
		),

		// Easing of the transition when a layer animates out.
		// Original: easingout
		// Defaults to: 'easeInOutQuint'
		'transitionOutEasing' => array(
			'value' => 'easeInOutQuint',
			'name' => __('Easing', 'LayerSlider'),
			'keys' => 'easingout',
			'tooltip' => __("The timing function of the animation. With this function you can manipulate the movement of the animated object. Please click on the link next to this select field to open easings.net for more information and real-time examples.", "LayerSlider")
		),

		'transitionOutFade' => array(
			'value' => true,
			'name' => __('Fade', 'LayerSlider'),
			'keys' => 'fadeout',
			'tooltip' => __('Fade the layer during the transition.', 'LayerSlider'),
		),


		// Initial rotation degrees when a layer animates out.
		// Original: rotateout
		// Defaults to: 0 (deg)
		'transitionOutRotate' => array(
			'value' => 0,
			'name' => __('Rotate', 'LayerSlider'),
			'keys' => 'rotateout',
			'tooltip' => __('Rotates the layer by the given number of degrees. Negative values are allowed for counterclockwise rotation.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'transitionOutRotateX' => array(
			'value' => 0,
			'name' => __('RotateX', 'LayerSlider'),
			'keys' => 'rotatexout',
			'tooltip' => __('Rotates the layer along the X (horizontal) axis by the given number of degrees. Negative values are allowed for reverse direction.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'transitionOutRotateY' => array(
			'value' => 0,
			'name' => __('RotateY', 'LayerSlider'),
			'keys' => 'rotateyout',
			'tooltip' => __('Rotates the layer along the Y (vertical) axis by the given number of degrees. Negative values are allowed for reverse direction.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'transitionOutSkewX' => array(
			'value' => 0,
			'name' => __('SkewX', 'LayerSlider'),
			'keys' => 'skewxout',
			'tooltip' => __('Skews the layer along the X (horizontal) axis by the given number of degrees. Negative values are allowed for reverse direction.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'transitionOutSkewY' => array(
			'value' => 0,
			'name' => __('SkewY', 'LayerSlider'),
			'keys' => 'skewyout',
			'tooltip' => __('Skews the layer along the Y (vertical) axis by the given number of degrees. Negative values are allowed for reverse direction.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'transitionOutScaleX' => array(
			'value' => 1,
			'name' => __('ScaleX', 'LayerSlider'),
			'keys' => 'scalexout',
			'tooltip' => __("Scales the layer along the X (horizontal) axis by the specified vector. Use the value 1 for the original size. The value 2 will double, while 0.5 shrinks the layer compared to its original size.", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(2,4)"
			}]')
		),

		'transitionOutScaleY' => array(
			'value' => 1,
			'name' => __('ScaleY', 'LayerSlider'),
			'keys' => 'scaleyout',
			'tooltip' => __("Scales the layer along the Y (vertical) axis by the specified vector. Use the value 1 for the original size. The value 2 will double, while 0.5 shrinks the layer compared to its original size.", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(2,4)"
			}]')
		),

		'transitionOutTransformOrigin' => array(
			'value' => '50% 50% 0',
			'name' => __('Transform Origin', 'LayerSlider'),
			'keys' => 'transformoriginout',
			'tooltip' => __('Sets a point on canvas from which transformations are calculated. For example, a layer may rotate around its center axis or a completely custom point, such as one of its corners. The three values represent the X, Y and Z axes in 3D space. Apart from the pixel and percentage values, you can also use the following constants: top, right, bottom, left, center, slidercenter, slidermiddle, slidertop, sliderright, sliderbottom, sliderleft.', 'LayerSlider'),
		),

		'transitionOutClip' => array(
			'value' => '',
			'name' => __('Mask', 'LayerSlider'),
			'keys' => 'clipout',
			'tooltip' => __("Clips (cuts off) the sides of the layer by the given amount specified in pixels or percentages. The 4 value in order: top, right, bottom and the left side of the layer.", "LayerSlider"),
			'attrs' => array('data-options' => '[{
				"name": "From top",
				"value": "0 0 100% 0"
			}, {
				"name": "From right",
				"value": "0 0 0 100%"
			}, {
				"name": "From bottom",
				"value": "100% 0 0 0"
			}, {
				"name": "From left",
				"value": "0 100% 0 0"
			}]')
		),

		'transitionOutFilter' => array(
			'value' => '',
			'name' => __('Filter', 'LayerSlider'),
			'keys' => 'filterout',
			'tooltip' => __('Filters provide effects like blurring or color shifting your layers. Click into the text field to see a selection of filters you can use. Although clicking on the pre-defined options will reset the text field, you can apply multiple filters simply by providing a space separated list of all the filters you would like to use. Click on the "Filter" link for more information.', 'LayerSlider'),
			'premium' => true,
			'attrs' => array(
				'data-options' => '[{
					"name": "Blur",
					"value": "blur(5px)"
				}, {
					"name": "Brightness",
					"value": "brightness(40%)"
				}, {
					"name": "Contrast",
					"value": "contrast(200%)"
				}, {
					"name": "Grayscale",
					"value": "grayscale(50%)"
				}, {
					"name": "Hue-rotate",
					"value": "hue-rotate(90deg)"
				}, {
					"name": "Invert",
					"value": "invert(75%)"
				}, {
					"name": "Saturate",
					"value": "saturate(30%)"
				}, {
					"name": "Sepia",
					"value": "sepia(60%)"
				}]'
			)
		),

		'transitionOutPerspective' => array(
			'value' => '500',
			'name' => __('Perspective', 'LayerSlider'),
			'keys' => 'transformperspectiveout',
			'tooltip' => __('Changes the perspective of this layer in the 3D space.', 'LayerSlider')
		),

		// -----

		'skipLayer' => array(
			'value' => false,
			'name' => __('Hidden', 'LayerSlider'),
			'keys' => 'skip',
			'tooltip' => __("If you don't want to use this layer, but you want to keep it, you can hide it with this switch.", "LayerSlider"),
			'props' => array(
				'meta' => true
			)
		),

		'transitionOutBGColor' => array(
			'value' => '',
			'name' => __('Background', 'LayerSlider'),
			'keys' => 'bgcolorout',
			'tooltip' => __('Animates the background toward the color you specify here when the layer leaves the slider canvas.', 'LayerSlider'),
		),

		'transitionOutColor' => array(
			'value' => '',
			'name' => __('Color', 'LayerSlider'),
			'keys' => 'colorout',
			'tooltip' => __('Animates the text color toward the color you specify here when the layer leaves the slider canvas.', 'LayerSlider'),
		),

		'transitionOutRadius' => array(
			'value' => '',
			'name' => __('Rounded Corners', 'LayerSlider'),
			'keys' => 'radiusout',
			'tooltip' => __('Animates rounded corners toward the value you specify here when the layer leaves the slider canvas.', 'LayerSlider'),
		),

		'transitionOutWidth' => array(
			'value' => '',
			'name' => __('Width', 'LayerSlider'),
			'keys' => 'widthout',
			'tooltip' => __('Animates the layer width toward the value you specify here when the layer leaves the slider canvas.', 'LayerSlider'),
		),

		'transitionOutHeight' => array(
			'value' => '',
			'name' => __('Height', 'LayerSlider'),
			'keys' => 'heightout',
			'tooltip' => __('Animates the layer height toward the value you specify here when the layer leaves the slider canvas.', 'LayerSlider'),
		),


		// == Compatibility ==
		'transitionInType' => array(
			'value' => 'auto',
			'keys' => 'slidedirection'
		),
		'transitionOutType' => array(
			'value' => 'auto',
			'keys' => 'slideoutdirection'
		),

		'transitionOutDelay' => array(
			'value' => 0,
			'keys' => 'delayout'
		),

		'transitionInScale' => array(
			'value' => '1.0',
			'keys' => 'scalein'
		),

		'transitionOutScale' => array(
			'value' => '1.0',
			'keys' => 'scaleout'
		),



		// Text Animation IN
		// -----------------

		'textTransitionIn' => array(
			'value' => false,
			'keys' => 'texttransitionin'
		),

		'textTypeIn' => array(
			'value' => 'chars_asc',
			'name' => __('Animate', 'LayerSlider'),
			'keys' => 'texttypein',
			'tooltip' => __('Select how your text should be split and animated.', 'LayerSlider'),
			'options' => array(
				'lines_asc'  => __('by lines ascending', 'LayerSlider'),
				'lines_desc' => __('by lines descending', 'LayerSlider'),
				'lines_rand' => __('by lines random', 'LayerSlider'),
				'lines_center' => __('by lines center to edge', 'LayerSlider'),
				'lines_edge' => __('by lines edge to center', 'LayerSlider'),
				'words_asc'  => __('by words ascending', 'LayerSlider'),
				'words_desc' => __('by words descending', 'LayerSlider'),
				'words_rand' => __('by words random', 'LayerSlider'),
				'words_center' => __('by words center to edge', 'LayerSlider'),
				'words_edge' => __('by words edge to center', 'LayerSlider'),
				'chars_asc'  => __('by chars ascending', 'LayerSlider'),
				'chars_desc' => __('by chars descending', 'LayerSlider'),
				'chars_rand' => __('by chars random', 'LayerSlider'),
				'chars_center' => __('by chars center to edge', 'LayerSlider'),
				'chars_edge' => __('by chars edge to center', 'LayerSlider')
			),
			'props' => array(
				'output' => true
			)
		),

		'textShiftIn' => array(
			'value' => 50,
			'name' => __('Shift In', 'LayerSlider'),
			'tooltip' => __('Delays the transition of each text nodes relative to each other. A second equals to 1000 milliseconds.', 'LayerSlider'),
			'keys'  => 'textshiftin',
			'attrs' => array('type' => 'number')
		),

		'textOffsetXIn' => array(
			'value' => 0,
			'name' => __('OffsetX', 'LayerSlider'),
			'tooltip' => __("Shifts the starting position of text nodes from their original on the horizontal axis with the given number of pixels. Use negative values for the opposite direction. Percentage values are relative to the width of this layer. The values 'left' or 'right' position text nodes out the staging area, so they enter the scene from either side when animating to their destination location. By listing multiple values separated with a | character, the slider will use different transition variations on each text node by cycling between the provided values.", "LayerSlider"),
			'keys'  => 'textoffsetxin',
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Enter the stage from left",
				"value": "left"
			}, {
				"name": "Enter the stage from right",
				"value": "right"
			}, {
				"name": "100% layer width",
				"value": "100lw"
			}, {
				"name": "-100% layer width",
				"value": "-100lw"
			}, {
				"name": "50% slider width",
				"value": "50sw"
			}, {
				"name": "-50% slider width",
				"value": "-50sw"
			}, {
				"name": "Cycle between values",
				"value": "50|-50"
			}, {
				"name": "Random",
				"value": "random(-100,100)"
			}]')
		),

		'textOffsetYIn' => array(
			'value' => 0,
			'name' => __('OffsetY', 'LayerSlider'),
			'tooltip' => __("Shifts the starting position of text nodes from their original on the vertical axis with the given number of pixels. Use negative values for the opposite direction. Percentage values are relative to the width of this layer. The values 'top' or 'bottom' position text nodes out the staging area, so they enter the scene from either vertical side when animating to their destination location. By listing multiple values separated with a | character, the slider will use different transition variations on each text node by cycling between the provided values.", "LayerSlider"),
			'keys'  => 'textoffsetyin',
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Enter the stage from top",
				"value": "top"
			}, {
				"name": "Enter the stage from bottom",
				"value": "bottom"
			}, {
				"name": "100% layer height",
				"value": "100lh"
			}, {
				"name": "-100% layer height",
				"value": "-100lh"
			}, {
				"name": "50% slider height",
				"value": "50sh"
			}, {
				"name": "-50% slider height",
				"value": "-50sh"
			}, {
				"name": "Cycle between values",
				"value": "50|-50"
			}, {
				"name": "Random",
				"value": "random(-100,100)"
			}]')
		),

		'textDurationIn' => array(
			'value' => 1000,
			'name' => __('Duration', 'LayerSlider'),
			'tooltip' => __('The transition length in milliseconds of the individual text fragments. A second equals to 1000 milliseconds.', 'LayerSlider'),
			'keys'  => 'textdurationin',
			'attrs' => array( 'min' => 0, 'step' => 50 )
		),

		'textEasingIn' => array(
			'value' => 'easeInOutQuint',
			'name' => __('Easing', 'LayerSlider'),
			'tooltip' => __("The timing function of the animation. With this function you can manipulate the movement of animated text fragments. Please click on the link next to this select field to open easings.net for more information and real-time examples.", "LayerSlider"),
			'keys'  => 'texteasingin',
		),

		'textFadeIn' => array(
			'value' => true,
			'name' => __('Fade', 'LayerSlider'),
			'tooltip' => __('Fade the text fragments during their transition.', 'LayerSlider'),
			'keys'  => 'textfadein'
		),

		'textStartAtIn' => array(
			'value' => 'transitioninend',
			'name' => __('StartAt', 'LayerSlider'),
			'tooltip' => __('You can set the starting time of this transition. Use one of the pre-defined options to use relative timing, which can be shifted with custom operations.', 'LayerSlider'),
			'keys'  => 'textstartatin',
			'attrs' => array('type' => 'hidden')
		),

		'textStartAtInTiming' => array(
			'value' => 'transitioninend',
			'keys'  => 'textstartatintiming',
			'props' => array( 'meta' => true ),
			'options' => array(
				'transitioninstart' => __('Opening Transition starts', 'LayerSlider'),
				'transitioninend' => __('Opening Transition completes', 'LayerSlider'),
				'loopstart' => __('Loop starts', 'LayerSlider'),
				'loopend' => __('Loop completes', 'LayerSlider'),
				'transitioninandloopend' => __('Opening and Loop Transitions complete', 'LayerSlider')
			)
		),

		'textStartAtInOperator' => array(
			'value' => '+',
			'keys'  => 'textstartatinoperator',
			'props' => array( 'meta' => true ),
			'options' => array('+', '-', '/', '*')
		),

		'textStartAtInValue' => array(
			'value' => 0,
			'keys'  => 'textstartatinvalue',
			'props' => array( 'meta' => true )
		),



		'textRotateIn' => array(
			'value' => 0,
			'name' => __('Rotate', 'LayerSlider'),
			'tooltip' => __('Rotates text fragments clockwise by the given number of degrees. Negative values are allowed for counterclockwise rotation. By listing multiple values separated with a | character, the slider will use different transition variations on each text node by cycling between the provided values.', 'LayerSlider'),
			'keys'  => 'textrotatein',
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Cycle between values",
				"value": "30|-30"
			}, {
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'textRotateXIn' => array(
			'value' => 0,
			'name' => __('RotateX', 'LayerSlider'),
			'tooltip' => __('Rotates text fragments along the X (horizontal) axis by the given number of degrees. Negative values are allowed for reverse direction. By listing multiple values separated with a | character, the slider will use different transition variations on each text node by cycling between the provided values.', 'LayerSlider'),
			'keys'  => 'textrotatexin',
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Cycle between values",
				"value": "30|-30"
			}, {
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'textRotateYIn' => array(
			'value' => 0,
			'name' => __('RotateY', 'LayerSlider'),
			'tooltip' => __('Rotates text fragments along the Y (vertical) axis by the given number of degrees. Negative values are allowed for reverse direction. By listing multiple values separated with a | character, the slider will use different transition variations on each text node by cycling between the provided values.', 'LayerSlider'),
			'keys'  => 'textrotateyin',
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Cycle between values",
				"value": "30|-30"
			}, {
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'textScaleXIn' => array(
			'value' => 1,
			'name' => __('ScaleX', 'LayerSlider'),
			'keys'  => 'textscalexin',
			'tooltip' => __("Scales text fragments along the X (horizontal) axis by the specified vector. Use the value 1 for the original size. The value 2 will double, while 0.5 shrinks text fragments compared to their original size. By listing multiple values separated with a | character, the slider will use different transition variations on each text node by cycling between the provided values.", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Cycle between values",
				"value": "30|-30"
			}, {
				"name": "Random",
				"value": "random(2,4)"
			}]')
		),

		'textScaleYIn' => array(
			'value' => 1,
			'name' => __('ScaleY', 'LayerSlider'),
			'keys'  => 'textscaleyin',
			'tooltip' => __("Scales text fragments along the Y (vertical) axis by the specified vector. Use the value 1 for the original size. The value 2 will double, while 0.5 shrinks text fragments compared to their original size. By listing multiple values separated with a | character, the slider will use different transition variations on each text node by cycling between the provided values.", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Cycle between values",
				"value": "30|-30"
			}, {
				"name": "Random",
				"value": "random(2,4)"
			}]')
		),

		'textSkewXIn' => array(
			'value' => 0,
			'name' => __('SkewX', 'LayerSlider'),
			'tooltip' => __('Skews text fragments along the X (horizontal) axis by the given number of degrees. Negative values are allowed for reverse direction. By listing multiple values separated with a | character, the slider will use different transition variations on each text node by cycling between the provided values.', 'LayerSlider'),
			'keys'  => 'textskewxin',
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Cycle between values",
				"value": "30|-30"
			}, {
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'textSkewYIn' => array(
			'value' => 0,
			'name' => __('SkewY', 'LayerSlider'),
			'tooltip' => __('Skews text fragments along the Y (vertical) axis by the given number of degrees. Negative values are allowed for reverse direction. By listing multiple values separated with a | character, the slider will use different transition variations on each text node by cycling between the provided values.', 'LayerSlider'),
			'keys'  => 'textskewyin',
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Cycle between values",
				"value": "30|-30"
			}, {
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),



		'textTransformOriginIn' => array(
			'value' => '50% 50% 0',
			'name' => __('Transform Origin', 'LayerSlider'),
			'tooltip' => __('Sets a point on canvas from which transformations are calculated. For example, a layer may rotate around its center axis or a completely custom point, such as one of its corners. The three values represent the X, Y and Z axes in 3D space. Apart from the pixel and percentage values, you can also use the following constants: top, right, bottom, left, center, slidercenter, slidermiddle, slidertop, sliderright, sliderbottom, sliderleft.', 'LayerSlider'),
			'keys'  => 'texttransformoriginin',
			'attrs' => array('data-options' => '[{
				"name": "Cycle between values",
				"value": "50% 50% 0|100% 100% 0"
			}]')
		),

		'textPerspectiveIn' => array(
			'value' => '500',
			'name' => __('Perspective', 'LayerSlider'),
			'keys' => 'texttransformperspectivein',
			'tooltip' => __('Changes the perspective of this layer in the 3D space.', 'LayerSlider')
		),




		// Text Animation OUT
		// -----------------

		'textTransitionOut' => array(
			'value' => false,
			'keys' => 'texttransitionout'
		),

		'textTypeOut' => array(
			'value' => 'chars_desc',
			'name' => __('Animate', 'LayerSlider'),
			'keys' => 'texttypeout',
			'tooltip' => __('Select how your text should be split and animated.', 'LayerSlider'),
			'options' => array(
				'lines_asc'  => __('by lines ascending', 'LayerSlider'),
				'lines_desc' => __('by lines descending', 'LayerSlider'),
				'lines_rand' => __('by lines random', 'LayerSlider'),
				'lines_center' => __('by lines center to edge', 'LayerSlider'),
				'lines_edge' => __('by lines edge to center', 'LayerSlider'),
				'words_asc'  => __('by words ascending', 'LayerSlider'),
				'words_desc' => __('by words descending', 'LayerSlider'),
				'words_rand' => __('by words random', 'LayerSlider'),
				'words_center' => __('by words center to edge', 'LayerSlider'),
				'words_edge' => __('by words edge to center', 'LayerSlider'),
				'chars_asc'  => __('by chars ascending', 'LayerSlider'),
				'chars_desc' => __('by chars descending', 'LayerSlider'),
				'chars_rand' => __('by chars random', 'LayerSlider'),
				'chars_center' => __('by chars center to edge', 'LayerSlider'),
				'chars_edge' => __('by chars edge to center', 'LayerSlider')
			),
			'props' => array(
				'output' => true
			)
		),

		'textShiftOut' => array(
			'value' => '',
			'name' => __('Shift Out', 'LayerSlider'),
			'tooltip' => __('Delays the transition of each text nodes relative to each other. A second equals to 1000 milliseconds.', 'LayerSlider'),
			'keys'  => 'textshiftout',
			'attrs' => array('type' => 'number')
		),

		'textOffsetXOut' => array(
			'value' => 0,
			'name' => __('OffsetX', 'LayerSlider'),
			'tooltip' => __("Shifts the ending position of text nodes from their original on the horizontal axis with the given number of pixels. Use negative values for the opposite direction. Percentage values are relative to the width of this layer. The values 'left' or 'right' position text nodes out the staging area, so they leave the scene from either side when animating to their destination location. By listing multiple values separated with a | character, the slider will use different transition variations on each text node by cycling between the provided values.", "LayerSlider"),
			'keys'  => 'textoffsetxout',
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Leave the stage on left",
				"value": "left"
			}, {
				"name": "Leave the stage on right",
				"value": "right"
			}, {
				"name": "100% layer width",
				"value": "100lw"
			}, {
				"name": "-100% layer width",
				"value": "-100lw"
			}, {
				"name": "50% slider width",
				"value": "50sw"
			}, {
				"name": "-50% slider width",
				"value": "-50sw"
			}, {
				"name": "Cycle between values",
				"value": "50|-50"
			}, {
				"name": "Random",
				"value": "random(-100,100)"
			}]')
		),

		'textOffsetYOut' => array(
			'value' => 0,
			'name' => __('OffsetY', 'LayerSlider'),
			'tooltip' => __("Shifts the ending position of text nodes from their original on the vertical axis with the given number of pixels. Use negative values for the opposite direction. Percentage values are relative to the width of this layer. The values 'top' or 'bottom' position text nodes out the staging area, so they leave the scene from either vertical side when animating to their destination location. By listing multiple values separated with a | character, the slider will use different transition variations on each text node by cycling between the provided values.", "LayerSlider"),
			'keys'  => 'textoffsetyout',
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Leave the stage on top",
				"value": "top"
			}, {
				"name": "Leave the stage on bottom",
				"value": "bottom"
			}, {
				"name": "100% layer height",
				"value": "100lh"
			}, {
				"name": "-100% layer height",
				"value": "-100lh"
			}, {
				"name": "50% slider height",
				"value": "50sh"
			}, {
				"name": "-50% slider height",
				"value": "-50sh"
			}, {
				"name": "Cycle between values",
				"value": "50|-50"
			}, {
				"name": "Random",
				"value": "random(-100,100)"
			}]')
		),

		'textDurationOut' => array(
			'value' => 1000,
			'name' => __('Duration', 'LayerSlider'),
			'tooltip' => __('The transition length in milliseconds of the individual text fragments. A second equals to 1000 milliseconds.', 'LayerSlider'),
			'keys'  => 'textdurationout',
			'attrs' => array( 'min' => 0, 'step' => 50 )
		),

		'textEasingOut' => array(
			'value' => 'easeInOutQuint',
			'name' => __('Easing', 'LayerSlider'),
			'tooltip' => __("The timing function of the animation. With this function you can manipulate the movement of animated text fragments. Please click on the link next to this select field to open easings.net for more information and real-time examples.", "LayerSlider"),
			'keys'  => 'texteasingout',
			'attrs' => array('type' => 'hidden')
		),

		'textFadeOut' => array(
			'value' => true,
			'name' => __('Fade', 'LayerSlider'),
			'tooltip' => __('Fade the text fragments during their transition.', 'LayerSlider'),
			'keys'  => 'textfadeout'
		),

		'textStartAtOut' => array(
			'value' => 'allinandloopend',
			'name' => __('StartAt', 'LayerSlider'),
			'tooltip' => __('You can set the starting time of this transition. Use one of the pre-defined options to use relative timing, which can be shifted with custom operations.', 'LayerSlider'),
			'keys'  => 'textstartatout',
			'attrs' => array('type' => 'hidden')
		),

		'textStartAtOutTiming' => array(
			'value' => 'allinandloopend',
			'keys'  => 'textstartatouttiming',
			'props' => array( 'meta' => true ),
			'options' => array(
				'transitioninend' => __('Opening Transition completes', 'LayerSlider'),
				'textinstart' => __('Opening Text Transition starts', 'LayerSlider'),
				'textinend' => __('Opening Text Transition completes', 'LayerSlider'),
				'allinend' => __('Opening and Opening Text Transition complete', 'LayerSlider'),
				'loopstart' => __('Loop starts', 'LayerSlider'),
				'loopend' => __('Loop completes',  'LayerSlider'),
				'transitioninandloopend' => __('Opening and Loop Transitions complete', 'LayerSlider'),
				'textinandloopend' => __('Opening Text and Loop Transitions complete', 'LayerSlider'),
				'allinandloopend' => __('Opening, Opening Text and Loop Transitions complete', 'LayerSlider')
			)
		),

		'textStartAtOutOperator' => array(
			'value' => '+',
			'keys'  => 'textstartatoutoperator',
			'props' => array( 'meta' => true ),
			'options' => array('+', '-', '/', '*')
		),

		'textStartAtOutValue' => array(
			'value' => 0,
			'keys'  => 'textstartatoutvalue',
			'props' => array( 'meta' => true )
		),

		'textRotateOut' => array(
			'value' => 0,
			'name' => __('Rotate', 'LayerSlider'),
			'tooltip' => __('Rotates text fragments clockwise by the given number of degrees. Negative values are allowed for counterclockwise rotation. By listing multiple values separated with a | character, the slider will use different transition variations on each text node by cycling between the provided values.', 'LayerSlider'),
			'keys'  => 'textrotateout',
			'attrs' => array('type' => 'text', 'data-options' => '[{
			"name": "Cycle between values",
				"value": "30|-30"
			}, {
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'textRotateXOut' => array(
			'value' => 0,
			'name' => __('RotateX', 'LayerSlider'),
			'tooltip' => __('Rotates text fragments along the X (horizontal) axis by the given number of degrees. Negative values are allowed for reverse direction. By listing multiple values separated with a | character, the slider will use different transition variations on each text node by cycling between the provided values.', 'LayerSlider'),
			'keys'  => 'textrotatexout',
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Cycle between values",
				"value": "30|-30"
			}, {
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'textRotateYOut' => array(
			'value' => 0,
			'name' => __('RotateY', 'LayerSlider'),
			'tooltip' => __('Rotates text fragments along the Y (vertical) axis by the given number of degrees. Negative values are allowed for reverse direction. By listing multiple values separated with a | character, the slider will use different transition variations on each text node by cycling between the provided values.', 'LayerSlider'),
			'keys'  => 'textrotateyout',
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Cycle between values",
				"value": "30|-30"
			}, {
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'textScaleXOut' => array(
			'value' => 1,
			'name' => __('ScaleX', 'LayerSlider'),
			'keys'  => 'textscalexout',
			'tooltip' => __("Scales text fragments along the X (horizontal) axis by the specified vector. Use the value 1 for the original size. The value 2 will double, while 0.5 shrinks text fragments compared to their original size. By listing multiple values separated with a | character, the slider will use different transition variations on each text node by cycling between the provided values.", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Cycle between values",
				"value": "30|-30"
			}, {
				"name": "Random",
				"value": "random(2,4)"
			}]')
		),

		'textScaleYOut' => array(
			'value' => 1,
			'name' => __('ScaleY', 'LayerSlider'),
			'keys'  => 'textscaleyout',
			'tooltip' => __("Scales text fragments along the Y (vertical) axis by the specified vector. Use the value 1 for the original size. The value 2 will double, while 0.5 shrinks text fragments compared to their original size. By listing multiple values separated with a | character, the slider will use different transition variations on each text node by cycling between the provided values.", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Cycle between values",
				"value": "30|-30"
			}, {
				"name": "Random",
				"value": "random(2,4)"
			}]')
		),

		'textSkewXOut' => array(
			'value' => 0,
			'name' => __('SkewX', 'LayerSlider'),
			'tooltip' => __('Skews text fragments along the X (horizontal) axis by the given number of degrees. Negative values are allowed for reverse direction. By listing multiple values separated with a | character, the slider will use different transition variations on each text node by cycling between the provided values.', 'LayerSlider'),
			'keys'  => 'textskewxout',
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Cycle between values",
				"value": "30|-30"
			}, {
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'textSkewYOut' => array(
			'value' => 0,
			'name' => __('SkewY', 'LayerSlider'),
			'tooltip' => __('Skews text fragments along the Y (vertical) axis by the given number of degrees. Negative values are allowed for reverse direction. By listing multiple values separated with a | character, the slider will use different transition variations on each text node by cycling between the provided values.', 'LayerSlider'),
			'keys'  => 'textskewyout',
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Cycle between values",
				"value": "30|-30"
			}, {
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),



		'textTransformOriginOut' => array(
			'value' => '50% 50% 0',
			'name' => __('Transform Origin', 'LayerSlider'),
			'tooltip' => __('Sets a point on canvas from which transformations are calculated. For example, a layer may rotate around its center axis or a completely custom point, such as one of its corners. The three values represent the X, Y and Z axes in 3D space. Apart from the pixel and percentage values, you can also use the following constants: top, right, bottom, left, center, slidercenter, slidermiddle, slidertop, sliderright, sliderbottom, sliderleft.', 'LayerSlider'),
			'keys'  => 'texttransformoriginout',
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Cycle between values",
				"value": "50% 50% 0|100% 100% 0"
			}]')
		),


		'textPerspectiveOut' => array(
			'value' => '500',
			'name' => __('Perspective', 'LayerSlider'),
			'keys' => 'texttransformperspectiveout',
			'tooltip' => __('Changes the perspective of this layer in the 3D space.', 'LayerSlider')
		),







		// ======


		// LOOP

		'loop' => array(
			'value' => false,
			'keys' => 'loop'
		),

		'loopOffsetX' => array(
			'value' => 0,
			'name' => __('OffsetX', 'LayerSlider'),
			'keys' => 'loopoffsetx',
			'tooltip' => __("Shifts the layer starting position from its original on the horizontal axis with the given number of pixels. Use negative values for the opposite direction. Percentage values are relative to the width of this layer. The values 'left' or 'right' position the layer out the staging area, so it can leave and re-enter the scene from either side during the transition.", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Move out of stage on left",
				"value": "left"
			}, {
				"name": "Move out of stage on right",
				"value": "right"
			}, {
				"name": "100% layer width",
				"value": "100lw"
			}, {
				"name": "-100% layer width",
				"value": "-100lw"
			}, {
				"name": "50% slider width",
				"value": "50sw"
			}, {
				"name": "-50% slider width",
				"value": "-50sw"
			}, {
				"name": "Random",
				"value": "random(-100,100)"
			}]')
		),

		'loopOffsetY' => array(
			'value' => 0,
			'name' => __('OffsetY', 'LayerSlider'),
			'keys' => 'loopoffsety',
			'tooltip' => __("Shifts the layer starting position from its original on the vertical axis with the given number of pixels. Use negative values for the opposite direction. Percentage values are relative to the height of this layer. The values 'top' or 'bottom' position the layer out the staging area, so it can leave and re-enter the scene from either vertical side during the transition.", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Move out of stage on top",
				"value": "top"
			}, {
				"name": "Move out of stage on bottom",
				"value": "bottom"
			}, {
				"name": "100% layer height",
				"value": "100lh"
			}, {
				"name": "-100% layer height",
				"value": "-100lh"
			}, {
				"name": "50% slider height",
				"value": "50sh"
			}, {
				"name": "-50% slider height",
				"value": "-50sh"
			}, {
				"name": "Random",
				"value": "random(-100,100)"
			}]')
		),

		'loopDuration' => array(
			'value' => 1000,
			'name' => __('Duration', 'LayerSlider'),
			'keys' => 'loopduration',
			'tooltip' => __('The length of the transition in milliseconds. A second is equal to 1000 milliseconds.', 'LayerSlider'),
			'attrs' => array('min' => 0, 'step' => 100 )
		),

		'loopStartAt' => array(
			'value' => 'allinend',
			'name' => __('Start at', 'LayerSlider'),
			'keys' => 'loopstartat',
			'tooltip' => __('You can set the starting time of this transition. Use one of the pre-defined options to use relative timing, which can be shifted with custom operations.', 'LayerSlider'),
			'attrs' => array('type' => 'hidden', 'step' => 100 ),
		),

		'loopStartAtTiming' => array(
			'value' => 'allinend',
			'keys'  => 'loopstartattiming',
			'props' => array( 'meta' => true ),
			'options' => array(
				'transitioninstart' => __('Opening Transition starts', 'LayerSlider'),
				'transitioninend' => __('Opening Transition completes', 'LayerSlider'),
				'textinstart' => __('Opening Text Transition starts', 'LayerSlider'),
				'textinend' => __('Opening Text Transition completes', 'LayerSlider'),
				'allinend' => __('Opening and Opening Text Transition complete', 'LayerSlider')
			)
		),

		'loopStartAtOperator' => array(
			'value' => '+',
			'keys'  => 'loopstartatoperator',
			'props' => array( 'meta' => true ),
			'options' => array('+', '-', '/', '*')
		),

		'loopStartAtValue' => array(
			'value' => 0,
			'keys'  => 'loopstartatvalue',
			'props' => array( 'meta' => true )
		),

		'loopEasing' => array(
			'value' => 'linear',
			'name' => __('Easing', 'LayerSlider'),
			'keys' => 'loopeasing',
			'tooltip' => __("The timing function of the animation to manipualte the layer's movement. Click on the link next to this field to open easings.net for examples and more information", "LayerSlider")
		),

		'loopOpacity' => array(
			'value' => 1,
			'name' => __('Opacity', 'LayerSlider'),
			'keys' => 'loopopacity',
			'tooltip' => __('Fades the layer. You can use values between 1 and 0 to set the layer fully opaque or transparent respectively. For example, the value 0.5 will make the layer semi-transparent.', 'LayerSlider'),
			'attrs' => array( 'min' => 0, 'max' => 1, 'step' => 0.01 )
		),

		'loopRotate' => array(
			'value' => 0,
			'name' => __('Rotate', 'LayerSlider'),
			'keys' => 'looprotate',
			'tooltip' => __('Rotates the layer by the given number of degrees. Negative values are allowed for counterclockwise rotation.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'loopRotateX' => array(
			'value' => 0,
			'name' => __('RotateX', 'LayerSlider'),
			'keys' => 'looprotatex',
			'tooltip' => __('Rotates the layer along the X (horizontal) axis by the given number of degrees. Negative values are allowed for reverse direction.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'loopRotateY' => array(
			'value' => 0,
			'name' => __('RotateY', 'LayerSlider'),
			'keys' => 'looprotatey',
			'tooltip' => __('Rotates the layer along the Y (vertical) axis by the given number of degrees. Negative values are allowed for reverse direction.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'loopSkewX' => array(
			'value' => 0,
			'name' => __('SkewX', 'LayerSlider'),
			'keys' => 'loopskewx',
			'tooltip' => __('Skews the layer along the X (horizontal) axis by the given number of degrees. Negative values are allowed for reverse direction.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'loopSkewY' => array(
			'value' => 0,
			'name' => __('SkewY', 'LayerSlider'),
			'keys' => 'loopskewy',
			'tooltip' => __('Skews the layer along the Y (vertical) axis by the given number of degrees. Negative values are allowed for reverse direction.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'loopScaleX' => array(
			'value' => 1,
			'name' => __('ScaleX', 'LayerSlider'),
			'keys' => 'loopscalex',
			'tooltip' => __("Scales the layer along the X (horizontal) axis by the specified vector. Use the value 1 for the original size. The value 2 will double, while 0.5 shrinks the layer compared to its original size.", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(2,4)"
			}]')
		),

		'loopScaleY' => array(
			'value' => 1,
			'name' => __('ScaleY', 'LayerSlider'),
			'keys' => 'loopscaley',
			'tooltip' => __("Scales the layer along the X (horizontal) axis by the specified vector. Use the value 1 for the original size. The value 2 will double, while 0.5 shrinks the layer compared to its original size.", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(2,4)"
			}]')
		),

		'loopTransformOrigin' => array(
			'value' => '50% 50% 0',
			'name' => __('Transform Origin', 'LayerSlider'),
			'keys' => 'looptransformorigin',
			'tooltip' => __('Sets a point on canvas from which transformations are calculated. For example, a layer may rotate around its center axis or a completely custom point, such as one of its corners. The three values represent the X, Y and Z axes in 3D space. Apart from the pixel and percentage values, you can also use the following constants: top, right, bottom, left, center, slidercenter, slidermiddle, slidertop, sliderright, sliderbottom, sliderleft.', 'LayerSlider')
		),

		'loopClip' => array(
			'value' => '',
			'name' => __('Mask', 'LayerSlider'),
			'keys' => 'loopclip',
			'tooltip' => __('Clips (cuts off) the sides of the layer by the given amount specified in pixels or percentages. The 4 value in order: top, right, bottom and the left side of the layer.', 'LayerSlider'),
			'attrs' => array('data-options' => '[{
				"name": "From top",
				"value": "0 0 100% 0"
			}, {
				"name": "From right",
				"value": "0 0 0 100%"
			}, {
				"name": "From bottom",
				"value": "100% 0 0 0"
			}, {
				"name": "From left",
				"value": "0 100% 0 0"
			}]')
		),

		'loopCount' => array(
			'value' => 1,
			'name' => __('Count', 'LayerSlider'),
			'keys' => 'loopcount',
			'tooltip' => __('The number of times repeating the Loop transition. The count includes the reverse part of the transitions when you use the Yoyo feature. Use the value -1 to repeat infinitely or zero to disable looping.', 'LayerSlider'),
			'attrs' => array(
				'step' => 1,
				'data-options' => '[{
					"name": "Infinite",
					"value": -1
				}]'
			),
			'props' => array(
				'output' => true
			)
		),

		'loopWait' => array(
			'value' => 0,
			'name' => __('Wait', 'LayerSlider'),
			'keys' => 'looprepeatdelay',
			'tooltip' => __('Waiting time between repeats in milliseconds. A second is 1000 milliseconds.', 'LayerSlider'),
			'attrs' => array( 'min' => 0, 'step' => 100 )
		),

		'loopYoyo' => array(
			'value' => false,
			'name' => __('Yoyo', 'LayerSlider'),
			'keys' => 'loopyoyo',
			'tooltip' => __('Enable this option to allow reverse transition, so you can loop back and forth seamlessly.', 'LayerSlider')
		),

		'loopPerspective' => array(
			'value' => '500',
			'name' => __('Perspective', 'LayerSlider'),
			'keys' => 'looptransformperspective',
			'tooltip' => __('Changes the perspective of this layer in the 3D space.', 'LayerSlider')
		),

		'loopFilter' => array(
			'value' => '',
			'name' => __('Filter', 'LayerSlider'),
			'keys' => 'loopfilter',
			'tooltip' => __('Filters provide effects like blurring or color shifting your layers. Click into the text field to see a selection of filters you can use. Although clicking on the pre-defined options will reset the text field, you can apply multiple filters simply by providing a space separated list of all the filters you would like to use. Click on the "Filter" link for more information.', 'LayerSlider'),
			'premium' => true,
			'attrs' => array(
				'data-options' => '[{
					"name": "Blur",
					"value": "blur(5px)"
				}, {
					"name": "Brightness",
					"value": "brightness(40%)"
				}, {
					"name": "Contrast",
					"value": "contrast(200%)"
				}, {
					"name": "Grayscale",
					"value": "grayscale(50%)"
				}, {
					"name": "Hue-rotate",
					"value": "hue-rotate(90deg)"
				}, {
					"name": "Invert",
					"value": "invert(75%)"
				}, {
					"name": "Saturate",
					"value": "saturate(30%)"
				}, {
					"name": "Sepia",
					"value": "sepia(60%)"
				}]'
			)
		),





		// HOVER

		'hover' => array(
			'value' => false,
			'keys' => 'hover'
		),


		'hoverOffsetX' => array(
			'value' => 0,
			'name' => __('OffsetX', 'LayerSlider'),
			'keys' => 'hoveroffsetx',
			'tooltip' => __("Moves the layer horizontally by the given number of pixels. Use negative values for the opposite direction. Percentage values are relative to the width of this layer. ", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "20% layer width",
				"value": "20lw"
			}, {
				"name": "-20% layer width",
				"value": "-20lw"
			}, {
				"name": "Random",
				"value": "random(-100,100)"
			}]')
		),

		'hoverOffsetY' => array(
			'value' => 0,
			'name' => __('OffsetY', 'LayerSlider'),
			'keys' => 'hoveroffsety',
			'tooltip' => __("Moves the layer vertically by the given number of pixels. Use negative values for the opposite direction. Percentage values are relative to the width of this layer. ", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "20% layer height",
				"value": "20lh"
			}, {
				"name": "-20% layer height",
				"value": "-20lh"
			}, {
				"name": "Random",
				"value": "random(-100,100)"
			}]')
		),

		'hoverInDuration' => array(
			'value' => 500,
			'name' => __('Duration', 'LayerSlider'),
			'keys' => 'hoverdurationin',
			'tooltip' => __('The length of the transition in milliseconds. A second is equal to 1000 milliseconds.', 'LayerSlider'),
			'attrs' => array( 'min' => 0, 'step' => 100 )
		),

		'hoverOutDuration' => array(
			'value' => '',
			'name' => __('Reverse<br>duration', 'LayerSlider'),
			'keys' => 'hoverdurationout',
			'tooltip' => __('The duration of the reverse transition in milliseconds. A second is equal to 1000 milliseconds.', 'LayerSlider'),
			'attrs' => array( 'min' => 0, 'step' => 100, 'placeholder' => 'same')
		),

		'hoverInEasing' => array(
			'value' => 'easeInOutQuint',
			'name' => __('Easing', 'LayerSlider'),
			'keys' => 'hovereasingin',
			'tooltip' => __("The timing function of the animation to manipualte the layer's movement. Click on the link next to this field to open easings.net for examples and more information", "LayerSlider")
		),

		'hoverOutEasing' => array(
			'value' => '',
			'name' => __('Reverse<br>easing', 'LayerSlider'),
			'keys' => 'hovereasingout',
			'tooltip' => __("The timing function of the reverse animation to manipualte the layer's movement. Click on the link next to this field to open easings.net for examples and more information", "LayerSlider"),
			'attrs' => array( 'placeholder' => 'same')
		),

		'hoverOpacity' => array(
			'value' => 1,
			'name' => __('Opacity', 'LayerSlider'),
			'keys' => 'hoveropacity',
			'tooltip' => __('Fades the layer. You can use values between 1 and 0 to set the layer fully opaque or transparent respectively. For example, the value 0.5 will make the layer semi-transparent.', 'LayerSlider'),
			'attrs' => array( 'min' => 0, 'max' => 1, 'step' => 0.01 )
		),

		'hoverRotate' => array(
			'value' => 0,
			'name' => __('Rotate', 'LayerSlider'),
			'keys' => 'hoverrotate',
			'tooltip' => __('Rotates the layer clockwise by the given number of degrees. Negative values are allowed for counterclockwise rotation.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'hoverRotateX' => array(
			'value' => 0,
			'name' => __('RotateX', 'LayerSlider'),
			'keys' => 'hoverrotatex',
			'tooltip' => __('Rotates the layer along the X (horizontal) axis by the given number of degrees. Negative values are allowed for reverse direction.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'hoverRotateY' => array(
			'value' => 0,
			'name' => __('RotateY', 'LayerSlider'),
			'keys' => 'hoverrotatey',
			'tooltip' => __('Rotates the layer along the Y (vertical) axis by the given number of degrees. Negative values are allowed for reverse direction.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'hoverSkewX' => array(
			'value' => 0,
			'name' => __('SkewX', 'LayerSlider'),
			'keys' => 'hoverskewx',
			'tooltip' => __('Skews the layer along the X (horizontal) axis by the given number of degrees. Negative values are allowed for reverse direction.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'hoverSkewY' => array(
			'value' => 0,
			'name' => __('SkewY', 'LayerSlider'),
			'keys' => 'hoverskewy',
			'tooltip' => __('Skews the layer along the Y (vertical) axis by the given number of degrees. Negative values are allowed for reverse direction.', 'LayerSlider'),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(-45,45)"
			}]')
		),

		'hoverScaleX' => array(
			'value' => 1,
			'name' => __('ScaleX', 'LayerSlider'),
			'keys' => 'hoverscalex',
			'tooltip' => __("Scales the layer along the X (horizontal) axis by the specified vector. Use the value 1 for the original size. The value 2 will double, while 0.5 shrinks the layer compared to its original size.", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(2,4)"
			}]')
		),

		'hoverScaleY' => array(
			'value' => 1,
			'name' => __('ScaleY', 'LayerSlider'),
			'keys' => 'hoverscaley',
			'tooltip' => __("Scales the layer along the Y (vertical) axis by the specified vector. Use the value 1 for the original size. The value 2 will double, while 0.5 shrinks the layer compared to its original size.", "LayerSlider"),
			'attrs' => array('type' => 'text', 'data-options' => '[{
				"name": "Random",
				"value": "random(2,4)"
			}]')
		),

		'hoverTransformOrigin' => array(
			'value' => '50% 50% 0',
      		'attrs' => array( 'placeholder' => 'inherit' ),
			'name' => __('Transform Origin', 'LayerSlider'),
			'keys' => 'hovertransformorigin',
			'tooltip' => __('Sets a point on canvas from which transformations are calculated. For example, a layer may rotate around its center axis or a completely custom point, such as one of its corners. The three values represent the X, Y and Z axes in 3D space. Apart from the pixel and percentage values, you can also use the following constants: top, right, bottom, left, center.', 'LayerSlider'),
		),

		'hoverBGColor' => array(
			'value' => '',
			'name' => __('Background', 'LayerSlider'),
			'keys' => 'hoverbgcolor',
			'tooltip' => __("The background color of this layer. You can use color names, hexadecimal, RGB or RGBA values as well as the 'transparent' keyword. Example: #FFF", "LayerSlider")
		),

		'hoverColor' => array(
			'value' => '',
			'name' => __('Color', 'LayerSlider'),
			'keys' => 'hovercolor',
			'tooltip' => __('The text color of this text. You can use color names, hexadecimal, RGB or RGBA values. Example: #333', 'LayerSlider')
		),

		'hoverBorderRadius' => array(
			'value' => '',
			'name' => __('Rounded corners', 'LayerSlider'),
			'keys' => 'hoverborderradius',
			'tooltip' => __('If you want rounded corners, you can set here its radius in pixels. Example: 5px', 'LayerSlider')
		),

		'hoverTransformPerspective' => array(
			'value' => 500,
			'name' => __('Perspective', 'LayerSlider'),
			'keys' => 'hovertransformperspective',
			'tooltip' => __('Changes the perspective of layers in the 3D space.', 'LayerSlider')
		),

		'hoverTopOn' => array(
			'value' => true,
			'name' => __('Always on top', 'LayerSlider'),
			'keys' => 'hoveralwaysontop',
			'tooltip' => __('Show this layer above every other layer while hovering.', 'LayerSlider')
		),





		// Parallax
		'parallax' => array(
			'value' => false,
			'keys' => 'parallax'
		),

		'parallaxLevel' => array(
			'value' => 10,
			'name' => __('Parallax Level', 'LayerSlider'),
			'tooltip' => __('Set the intensity of the parallax effect. Use negative values to shift layers in the opposite direction.', 'LayerSlider'),
			'keys' => 'parallaxlevel',
			'props' => array(
				'output' => true
			)
		),

		'parallaxType' => array(
			'value' => 'inherit',
			'name' => __('Type', 'LayerSlider'),
			'tooltip' => __('Choose if you want 2D or 3D parallax layers.', 'LayerSlider'),
			'keys' => 'parallaxtype',
			'options' => array(
				'inherit' => __('Inherit from Slide Options', 'LayerSlider'),
				'2d' => __('2D', 'LayerSlider'),
				'3d' => __('3D', 'LayerSlider')
 			)
		),

		'parallaxEvent' => array(
			'value' => 'inherit',
			'name' => __('Event', 'LayerSlider'),
			'tooltip' => __('You can trigger the parallax effect by either scrolling the page, or by moving your mouse cursor / tilting your mobile device.', 'LayerSlider'),
			'keys' => 'parallaxevent',
			'options' => array(
				'inherit' => __('Inherit from Slide Options', 'LayerSlider'),
				'cursor' => __('Cursor or Tilt', 'LayerSlider'),
				'scroll' => __('Scroll', 'LayerSlider')
 			)
		),

		'parallaxAxis' => array(
			'value' => 'inherit',
			'name' => __('Axes', 'LayerSlider'),
			'tooltip' => __('Choose on which axes parallax layers should move.', 'LayerSlider'),
			'keys' => 'parallaxaxis',
			'options' => array(
				'inherit' => __('Inherit from Slide Options', 'LayerSlider'),
				'none' => __('None', 'LayerSlider'),
				'both' => __('Both', 'LayerSlider'),
				'x' => __('Horizontal only', 'LayerSlider'),
				'y' => __('Vertical only', 'LayerSlider')
			)
		),


		'parallaxTransformOrigin' => array(
			'value' => '',
			'name' => __('Transform Origin', 'LayerSlider'),
			'tooltip' => __('Sets a point on canvas from which transformations are calculated. For example, a layer may rotate around its center axis or a completely custom point, such as one of its corners. The three values represent the X, Y and Z axes in 3D space. Apart from the pixel and percentage values, you can also use the following constants: top, right, bottom, left, center.', 'LayerSlider'),
			'keys' => 'parallaxtransformorigin',
			'attrs' => array(
				'placeholder' => 'Inherit from Slide Options'
			)
		),

		'parallaxDurationMove' => array(
			'value' => '',
			'name' => __('Move Duration', 'LayerSlider'),
			'tooltip' => __('Controls the speed of animating layers when you move your mouse cursor or tilt your mobile device.', 'LayerSlider'),
			'keys' => 'parallaxdurationmove',
			'attrs' => array(
				'type' => 'number',
				'step' => 100,
				'min' => 0,
				'placeholder' => 'Inherit from Slide Options'
			)
		),

		'parallaxDurationLeave' => array(
			'value' => '',
			'name' => __('Leave Duration', 'LayerSlider'),
			'tooltip' => __('Controls how quickly parallax layers revert to their original position when you move your mouse cursor outside of the slider. This value is in milliseconds. A second equals to 1000 milliseconds.', 'LayerSlider'),
			'keys' => 'parallaxdurationleave',
			'attrs' => array(
				'type' => 'number',
				'step' => 100,
				'min' => 0,
				'placeholder' => 'Inherit from Slide Options'
			)
		),

		'parallaxRotate' => array(
			'value' => '',
			'name' => __('Rotation', 'LayerSlider'),
			'tooltip' => __('Increase or decrease the amount of layer rotation in the 3D space when moving your mouse cursor or tilting on a mobile device.', 'LayerSlider'),
			'keys' => 'parallaxrotate',
			'attrs' => array(
				'type' => 'number',
				'step' => 1,
				'placeholder' => 'Inherit from Slide Options'
			)
		),

		'parallaxDistance' => array(
			'value' => '',
			'name' => __('Distance', 'LayerSlider'),
			'tooltip' => __('Increase or decrease the amount of layer movement when moving your mouse cursor or tilting on a mobile device.', 'LayerSlider'),
			'keys' => 'parallaxdistance',
			'attrs' => array(
				'type' => 'number',
				'step' => 1,
				'placeholder' => 'Inherit from Slide Options'
			)
		),

		'parallaxPerspective' => array(
			'value' => '',
			'name' => __('Perspective', 'LayerSlider'),
			'tooltip' => __('Changes the perspective of layers in the 3D space.', 'LayerSlider'),
			'keys' => 'parallaxtransformperspective',
			'attrs' => array(
				'type' => 'number',
				'step' => 100,
				'placeholder' => 'Inherit from Slide Options'
			)
		),


		// TRANSITON MISC
		'transitionStatic' => array(
			'value' => 'none',
			'name' => __('Keep this layer visible:', 'LayerSlider'),
			'keys' => 'static',
			'tooltip' => __("You can keep this layer on top of the slider across multiple slides. Just select the slide on which this layer should animate out. Alternatively, you can make this layer global on all slides after it transitioned in."),
			'options' => array(
				'none' => __('Until the end of this slide (default)', 'LayerSlider'),
				'forever' => __('Forever (the layer will never animate out)', 'LayerSlider')
			)
		),

		'transitionKeyframe' => array(
			'value' => false,
			'name' => __('Play By Scroll Keyframe', 'LayerSlider'),
			'keys' => 'keyframe',
			'tooltip' => __('A Play by Scroll slider will pause when this layer finished its opening transition.', 'LayerSlider')
		),


// Attributes


		'linkURL' => array(
			'value' => '',
			'name' => __('Enter URL', 'LayerSlider'),
			'keys' => 'url',
			'tooltip' => __('If you want to link your layer, type here the URL. You can use a hash mark followed by a number to link this layer to another slide. Example: #3 - this will switch to the third slide.', 'LayerSlider'),
			'attrs' => array(
				'data-options' => '[{
					"name": "Switch to the next slide",
					"value": "#next"
				}, {
					"name": "Switch to the previous slide",
					"value": "#prev"
				}, {
					"name": "Stop the slideshow",
					"value": "#stop"
				}, {
					"name": "Resume the slideshow",
					"value": "#start"
				}]'
			),
			'props' => array(
				'meta' => true
			)
		),


		'linkTarget' => array(
			'value' => '_self',
			'name' => __('URL target', 'LayerSlider'),
			'keys' => 'target',
			'options' => array(
				'_self' => __('Open on the same page', 'LayerSlider'),
				'_blank' => __('Open on new page', 'LayerSlider'),
				'_parent' => __('Open in parent frame', 'LayerSlider'),
				'_top' => __('Open in main frame', 'LayerSlider'),
				'ls-scroll' => __('Scroll to element (Enter selector)', 'LayerSlider')
			),
			'props' => array(
				'meta' => true
			)
		),

		'innerAttributes' => array(
			'value' => '',
			'name' => __('Custom Attributes', 'LayerSlider'),
			'keys' => 'innerAttributes',
			'desc' => __('Your list of custom attributes. Use this feature if your needs are not covered by the common attributes above or you want to override them. You can use data-* as well as regular attribute names. Empty attributes (without value) are also allowed. For example, to make a FancyBox gallery, you may enter "data-fancybox-group" and "gallery1" for the attribute name and value, respectively.', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'outerAttributes' => array(
			'value' => '',
			'name' => __('Custom Attributes', 'LayerSlider'),
			'keys' => 'outerAttributes',
			'desc' => __('Your list of custom attributes. Use this feature if your needs are not covered by the common attributes above or you want to override them. You can use data-* as well as regular attribute names. Empty attributes (without value) are also allowed. For example, to make a FancyBox gallery, you may enter "data-fancybox-group" and "gallery1" for the attribute name and value, respectively.', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		// Styles

		'width' => array(
			'value' => '',
			'name' => __('Width', 'LayerSlider'),
			'keys' => 'width',
			'tooltip' => __("You can set the width of your layer. You can use pixels, percentage, or the default value 'auto'. Examples: 100px, 50% or auto.", "LayerSlider"),
			'props' => array(
				'meta' => true
			)
		),

		'height' => array(
			'value' => '',
			'name' => __('Height', 'LayerSlider'),
			'keys' => 'height',
			'tooltip' => __("You can set the height of your layer. You can use pixels, percentage, or the default value 'auto'. Examples: 100px, 50% or auto", "LayerSlider"),
			'props' => array(
				'meta' => true
			)
		),

		'top' => array(
			'value' => '10px',
			'name' => __('Top', 'LayerSlider'),
			'keys' => 'top',
			'tooltip' => __("The layer position from the top of the slide. You can use pixels and percentage. Examples: 100px or 50%. You can move your layers in the preview above with a drag n' drop, or set the exact values here.", "LayerSlider"),
			'props' => array(
				'meta' => true
			)
		),

		'left' => array(
			'value' => '10px',
			'name' => __('Left', 'LayerSlider'),
			'keys' => 'left',
			'tooltip' => __("The layer position from the left side of the slide. You can use pixels and percentage. Examples: 100px or 50%. You can move your layers in the preview above with a drag n' drop, or set the exact values here.", "LayerSlider"),
			'props' => array(
				'meta' => true
			)
		),

		'paddingTop' => array(
			'value' => '',
			'name' => __('Top', 'LayerSlider'),
			'keys' => 'padding-top',
			'tooltip' => __('Padding on the top of the layer. Example: 10px', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'paddingRight' => array(
			'value' => '',
			'name' => __('Right', 'LayerSlider'),
			'keys' => 'padding-right',
			'tooltip' => __('Padding on the right side of the layer. Example: 10px', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'paddingBottom' => array(
			'value' => '',
			'name' => __('Bottom', 'LayerSlider'),
			'keys' => 'padding-bottom',
			'tooltip' => __('Padding on the bottom of the layer. Example: 10px', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'paddingLeft' => array(
			'value' => '',
			'name' => __('Left', 'LayerSlider'),
			'keys' => 'padding-left',
			'tooltip' => __('Padding on the left side of the layer. Example: 10px', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'borderTop' => array(
			'value' => '',
			'name' => __('Top', 'LayerSlider'),
			'keys' => 'border-top',
			'tooltip' => __('Border on the top of the layer. Example: 5px solid #000', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'borderRight' => array(
			'value' => '',
			'name' => __('Right', 'LayerSlider'),
			'keys' => 'border-right',
			'tooltip' => __('Border on the right side of the layer. Example: 5px solid #000', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'borderBottom' => array(
			'value' => '',
			'name' => __('Bottom', 'LayerSlider'),
			'keys' => 'border-bottom',
			'tooltip' => __('Border on the bottom of the layer. Example: 5px solid #000', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'borderLeft' => array(
			'value' => '',
			'name' => __('Left', 'LayerSlider'),
			'keys' => 'border-left',
			'tooltip' => __('Border on the left side of the layer. Example: 5px solid #000', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'fontFamily' => array(
			'value' => '',
			'name' => __('Family', 'LayerSlider'),
			'keys' => 'font-family',
			'tooltip' => __('List of your chosen fonts separated with a comma. Please use apostrophes if your font names contains white spaces. Example: Helvetica, Arial, sans-serif', 'LayerSlider')
		),

		'fontSize' => array(
			'value' => '',
			'name' => __('Font size', 'LayerSlider'),
			'keys' => 'font-size',
			'tooltip' => __('The font size in pixels. Example: 16px.', 'LayerSlider'),
			'attrs' => array('data-options' => '["9", "10", "11", "12", "13", "14", "18", "24", "36", "48", "64", "96"]'),
			'props' => array(
				'meta' => true
			)
		),

		'lineHeight' => array(
			'value' => '',
			'name' => __('Line height', 'LayerSlider'),
			'keys' => 'line-height',
			'tooltip' => __("The line height of your text. The default setting is 'normal'. Example: 22px", "LayerSlider"),
			'props' => array(
				'meta' => true
			)
		),

		'fontWeight' => array(
			'value' => 400,
			'name' => __('Font weight', 'LayerSlider'),
			'keys' => 'font-weight',
			'tooltip' => __('Sets the font boldness. Please note, not every font supports all the listed variants, thus some settings may have the same result.', ''),
			'options' => array(
				'100' => __('100 (UltraLight)', 'LayerSlider'),
				'200' => __('200 (Thin)', 'LayerSlider'),
				'300' => __('300 (Light)', 'LayerSlider'),
				'400' => __('400 (Regular)', 'LayerSlider'),
				'500' => __('500 (Medium)', 'LayerSlider'),
				'600' => __('600 (Semibold)', 'LayerSlider'),
				'700' => __('700 (Bold)', 'LayerSlider'),
				'800' => __('800 (Heavy)', 'LayerSlider'),
				'900' => __('900 (Black)', 'LayerSlider')
			),
			'props' => array(
				'meta' => true
			)
		),

		'fontStyle' => array(
			'value' => 'normal',
			'name' => __('Font style', 'LayerSlider'),
			'keys' => 'font-style',
			'tooltip' => __('Oblique is an auto-generated italic version of your chosen font and can force slating even if there is no italic font variant available. However, you should use the regular italic option whenever is possible. Please double check to load italic font variants when using Google Fonts.', ''),
			'options' => array(
				'normal' => __('Normal', 'LayerSlider'),
				'italic' => __('Italic', 'LayerSlider'),
				'oblique' => __('Oblique (Forced slant)', 'LayerSlider')
			),
			'props' => array(
				'meta' => true
			)
		),

		'textDecoration' => array(
			'value' => 'none',
			'name' => __('Text decoration', 'LayerSlider'),
			'keys' => 'text-decoration',
			'options' => array(
				'none' => 'None',
				'underline' => __('Underline', 'LayerSlider'),
				'overline' => __('Overline', 'LayerSlider'),
				'line-through' => __('Line through', 'LayerSlider')

			),
			'props' => array(
				'meta' => true
			)
		),

		'textAlign' => array(
			'value' => 'none',
			'name' => __('Text align', 'LayerSlider'),
			'keys' => 'text-align',
			'options' => array(
				'initial' => __('Initial (Language default)', 'LayerSlider'),
				'left' => __('Left', 'LayerSlider'),
				'right' => __('Right', 'LayerSlider'),
				'center' => __('Center', 'LayerSlider'),
				'justify' => __('Justify', 'LayerSlider')

			),
			'props' => array(
				'meta' => true
			)
		),

		'opacity' => array(
			'value' => 1,
			'name' => __('Opacity', 'LayerSlider'),
			'keys' => 'opacity',
			'tooltip' => __('Fades the layer. You can use values between 1 and 0 to set the layer fully opaque or transparent respectively. For example, the value 0.5 will make the layer semi-transparent.', 'LayerSlider'),
			'attrs' => array(
				'min' => 0,
				'max' => 1,
				'step' => 0.1
			),
			'props' => array(
				'meta' => true
			)
		),

		'minFontSize' => array(
			'value' => '',
			'name' => __('Min. font size', 'LayerSlider'),
			'keys' => 'minfontsize',
			'tooltip' => __('The minimum font size in a responsive slider. This option allows you to prevent your texts layers becoming too small on smaller screens.', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'minMobileFontSize' => array(
			'value' => '',
			'name' => __('Min. mobile font size', 'LayerSlider'),
			'keys' => 'minmobilefontsize',
			'tooltip' => __('The minimum font size in a responsive slider on mobile devices. This option allows you to prevent your texts layers becoming too small on smaller screens.', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),



		'color' => array(
			'value' => '',
			'name' => __('Color', 'LayerSlider'),
			'keys' => 'color',
			'tooltip' => __('The color of your text. You can use color names, hexadecimal, RGB or RGBA values. Example: #333', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'background' => array(
			'value' => '',
			'name' => __('Background', 'LayerSlider'),
			'keys' => 'background',
			'tooltip' => __("The background color of your layer. You can use color names, hexadecimal, RGB or RGBA values as well as the 'transparent' keyword. Example: #FFF", "LayerSlider"),
			'props' => array(
				'meta' => true
			)
		),

		'borderRadius' => array(
			'value' => '',
			'name' => __('Rounded corners', 'LayerSlider'),
			'keys' => 'border-radius',
			'tooltip' => __('If you want rounded corners, you can set its radius here. Example: 5px', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'wordWrap' => array(
			'value' => false,
			'name' => 'Word-wrap',
			'keys' => 'wordwrap',
			'tooltip' => 'Enable this option to allow line breaking if your text content does not fit into one line. By default, layers have auto sizes based on the text length. If you set custom sizes, it\'s recommended to enable this option in most cases.',
			'props' => array(
				'meta' => true
			)
		),

		'style' => array(
			'value' => '',
			'name' => __('Custom styles', 'LayerSlider'),
			'keys' => 'style',
			'tooltip' => __('If you want to set style settings other than above, you can use here any CSS codes. Please make sure to write valid markup.', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'styles' => array(
			'value' => '',
			'keys' => 'styles',
			'props' => array(
				'meta' => true,
				'raw' => true
			)
		),

		'rotate' => array(
			'value' => 0,
			'name' => __('Rotate', 'LayerSlider'),
			'keys' => 'rotation',
			'tooltip' => __('The rotation angle where this layer animates toward when entering into the slider canvas. Negative values are allowed for counterclockwise rotation.', 'LayerSlider')
		),

		'rotateX' => array(
			'value' => 0,
			'name' => __('RotateX', 'LayerSlider'),
			'keys' => 'rotationX',
			'tooltip' => __('The rotation angle on the horizontal axis where this animates toward when entering into the slider canvas. Negative values are allowed for reversed direction.', 'LayerSlider')
		),

		'rotateY' => array(
			'value' => 0,
			'name' => __('RotateY', 'LayerSlider'),
			'keys' => 'rotationY',
			'tooltip' => __('The rotation angle on the vertical axis where this layer animates toward when entering into the slider canvas. Negative values are allowed for reversed direction.', 'LayerSlider')
		),

		'scaleX' => array(
			'value' => 1,
			'name' => __('ScaleX', 'LayerSlider'),
			'keys' => 'scaleX',
			'tooltip' => __('The layer horizontal scale where this layer animates toward when entering into the slider canvas.', 'LayerSlider')
		),

		'scaleY' => array(
			'value' => 1,
			'name' => __('ScaleY', 'LayerSlider'),
			'keys' => 'scaleY',
			'tooltip' => __('The layer vertical scale where this layer animates toward when entering into the slider canvas.', 'LayerSlider')
		),

		'skewX' => array(
			'value' => 0,
			'name' => __('SkewX', 'LayerSlider'),
			'keys' => 'skewX',
			'tooltip' => __('The layer horizontal skewing angle where this layer animates toward when entering into the slider canvas.', 'LayerSlider')
		),

		'skewY' => array(
			'value' => 0,
			'name' => __('SkewY', 'LayerSlider'),
			'keys' => 'skewY',
			'tooltip' => __('The layer vertical skewing angle where this layer animates toward when entering into the slider canvas.', 'LayerSlider')
		),

		'position' => array(
			'value' => 'relative',
			'name' => __('Calculate positions from', 'LayerSlider'),
			'keys' => 'position',
			'tooltip' => __('Sets the layer position origin from which top and left values are calculated. The default is the upper left corner of the slider canvas. In a full width and full size slider, your content is centered based on the screen size to achieve the best possible fit. By selecting the "sides of the screen" option in those scenarios, you can allow layers to escape the centered inner area and stick to the sides of the screen.', 'LayerSlider'),
			'options' => array(
				'relative' => __('sides of the slider', 'LayerSlider'),
				'fixed' => __('sides of the screen', 'LayerSlider'),
			)
		),

		'filter' => array(
			'value' => '',
			'name' => __('Filter', 'LayerSlider'),
			'keys' => 'filter',
			'tooltip' => __('Filters provide effects like blurring or color shifting your layers. Click into the text field to see a selection of filters you can use. Although clicking on the pre-defined options will reset the text field, you can apply multiple filters simply by providing a space separated list of all the filters you would like to use. Click on the "Filter" link for more information.', 'LayerSlider'),
			'premium' => true,
			'attrs' => array(
				'data-options' => '[{
					"name": "Blur",
					"value": "blur(5px)"
				}, {
					"name": "Brightness",
					"value": "brightness(40%)"
				}, {
					"name": "Contrast",
					"value": "contrast(200%)"
				}, {
					"name": "Grayscale",
					"value": "grayscale(50%)"
				}, {
					"name": "Hue-rotate",
					"value": "hue-rotate(90deg)"
				}, {
					"name": "Invert",
					"value": "invert(75%)"
				}, {
					"name": "Saturate",
					"value": "saturate(30%)"
				}, {
					"name": "Sepia",
					"value": "sepia(60%)"
				}]'
			)
		),



		// Attributes

		'ID' => array(
			'value' => '',
			'name' => __('ID', 'LayerSlider'),
			'keys' => 'id',
			'tooltip' => __("You can apply an ID attribute on the HTML element of this layer to work with it in your custom CSS or Javascript code.", 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'class' => array(
			'value' => '',
			'name' => __('Classes', 'LayerSlider'),
			'keys' => 'class',
			'tooltip' => __('You can apply classes on the HTML element of this layer to work with it in your custom CSS or Javascript code.', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'title' => array(
			'value' => '',
			'name' => __('Title', 'LayerSlider'),
			'keys' => 'title',
			'tooltip' => __('You can add a title to this layer which will display as a tooltip if someone holds his mouse cursor over the layer.', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'alt' => array(
			'value' => '',
			'name' => __('Alt', 'LayerSlider'),
			'keys' => 'alt',
			'tooltip' => __('Name or describe your image layer, so search engines and VoiceOver softwares can properly identify it.', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		),

		'rel' => array(
			'value' => '',
			'name' => __('Rel', 'LayerSlider'),
			'keys' => 'rel',
			'tooltip' => __('Plugins and search engines may use this attribute to get more information about the role and behavior of a link.', 'LayerSlider'),
			'props' => array(
				'meta' => true
			)
		)

	),

	'easings' => array(
		'linear',
		'swing',
		'easeInQuad',
		'easeOutQuad',
		'easeInOutQuad',
		'easeInCubic',
		'easeOutCubic',
		'easeInOutCubic',
		'easeInQuart',
		'easeOutQuart',
		'easeInOutQuart',
		'easeInQuint',
		'easeOutQuint',
		'easeInOutQuint',
		'easeInSine',
		'easeOutSine',
		'easeInOutSine',
		'easeInExpo',
		'easeOutExpo',
		'easeInOutExpo',
		'easeInCirc',
		'easeOutCirc',
		'easeInOutCirc',
		'easeInElastic',
		'easeOutElastic',
		'easeInOutElastic',
		'easeInBack',
		'easeOutBack',
		'easeInOutBack',
		'easeInBounce',
		'easeOutBounce',
		'easeInOutBounce'
	)
);
