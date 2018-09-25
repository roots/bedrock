<?php

//
// Custom Visual Composer Scripts for a Theme Integration
//

vc_disable_frontend();

// Load Templatera 
//if (!class_exists('VcTemplateManager')) {
//	
//	require_once locate_template('/wpbakery/templatera/templatera.php');
//	
//	$dir = dirname(__FILE__);
//	$dir .= '/templatera';
//
//	// Init or use instance of the manager.
//	global $vc_template_manager;
//	$vc_template_manager = new VcTemplateManager($dir);
//	$vc_template_manager->init();
//	
//}

// Fade Animation for elements

function vntd_vc_animation($css_animation) {
	$animation_data = '';
	
	if($css_animation != '') {
		$animation_data = ' data-animation="';
		if($css_animation == 'left-to-right') {
			$animation_data .= 'fadeInLeft';
		} elseif($css_animation == 'right-to-left') {
			$animation_data .= 'fadeInRight';
		} elseif($css_animation == 'top-to-bottom') {
			$animation_data .= 'fadeInTop';
		} elseif($css_animation == 'bottom-to-top') {
			$animation_data .= 'fadeInBottom';
		} else {
			$animation_data .= 'fadeIn';
		}
		$animation_data .= '" data-animation-delay="100"';
	}
	
	return $animation_data;
}

// VC Row

if( north_option( 'vntd_vc_default' ) != true ) {

	vc_add_param("vc_row", array(
	    "type" => "textfield",
	    "heading" => __("Row ID", "north"),
	    "param_name" => "el_id",
	    "value" => "",
	    "description" => __("Row's unique ID.", "north")
	));
	
	vc_remove_param("vc_row","font_color");
	vc_remove_param("vc_row","full_width");
	
	vc_add_param("vc_row", array(
		'type' => 'css_editor',
		'heading' => __( 'Css', 'north' ),
		'param_name' => 'css',
		'group' => __( 'Design options', 'north' )
	));
	
	vc_add_param("vc_row", array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Font Color Scheme", 'north'),
		"param_name" => "color_scheme",
		"value" => array(
			"Default" => "",
			"White Scheme" => "white",
			"Custom" => "custom"		
		),
		"description" => __("White Scheme - all text styled to white color, recommended for dark backgrounds. Custom - choose your own heading and text color.", 'north'),
	));
	
		vc_add_param("vc_row", array(
		  "type" => "colorpicker",
		  "heading" => __("Heading Color", "north"),
		  "param_name" => "customcolor_heading",
		  "class" => "hidden-label",
		  "description" => __("Custom color for section headings.", "north"),
		  "dependency" => Array('element' => "color_scheme", 'value' => array('custom'))
		));
		
		vc_add_param("vc_row", array(
		  "type" => "colorpicker",
		  "heading" => __("Text Color", "north"),
		  "param_name" => "customcolor_text",
		  "class" => "hidden-label",
		  "description" => __("Custom color for section paragraph texts.", "north"),
		  "dependency" => Array('element' => "color_scheme", 'value' => array('custom'))
		));
	
	vc_add_param("vc_row", array(
		"type" => "dropdown",
		"class" => "",
		"heading" => "Parallax Effect",
		"param_name" => "parallax",
		"value" => array(
			"No" => "",
			"Yes" => "yes"		
		),
		"description" => __("Enable or disable the parallax effect. Available only if background image is set in the 'Design Options' tab.", 'north'),
	));
	
	vc_add_param("vc_row", array(
		"type" => "dropdown",
		"class" => "",
		"heading" => "Background Image Overlay",
		"param_name" => "bg_overlay",
		"value" => array(
			"None" => "",
			"Dark" => "dark",
			"Darker" => "darker",
			"Light" => "light",
			"White Dots" => 'dots_white',
			"Dark Dots" => 'dots_dark'	
		),
		"description" => __("Enable the row's background verlay to darken or lighten the background image.", 'north'),
	));
	
	vc_add_param("vc_row", array(
		"type" => "dropdown",
		"class" => "",
		"heading" => "Background Image Rain Effect",
		"param_name" => "bg_rain",
		"value" => array(
			"No" => "",
			"Yes" => "yes"
		),
		"description" => __("Enable the Rain Effect over the row's background image.", 'north'),
	));
	
		vc_add_param("vc_row", array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Rain Sound Effects",
			"param_name" => "bg_rain_sound",
			"value" => array(
				"No" => "",
				"Yes" => "yes"
			),
			"description" => __("Enable or disable the rain sound effect playing in a background.", 'north'),
			"dependency" => Array('element' => "bg_rain", 'value' => 'yes')
		));
	
	vc_add_param("vc_row", array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Row's Content Width", 'north'),
		"param_name" => "content_width",
		"value" => array(
			"Container" => "container",
			"Fullwidth" => "fullwidth"
		),
		"description" => __("Make the row's content width fullwidth. Useful for fullwidth Portfolio Grid or Portfolio Carousel.","north")
	));
	
	vc_add_param("vc_row", array(
		"type" => "dropdown",
		"class" => "",
		"heading" => "Fullscreen",
		"param_name" => "fullscreen",
		"value" => array(
			"No" => "",
			"Yes" => "yes"		
		),
		"description" => __("Make the row's height and width fullscreen' tab. Suitable mainly for 'Fancy Text Blocks'.", 'north'),
	));
	
	vc_add_param("vc_row", array(
		"type" => "dropdown",
		"class" => "",
		"heading" => "Video Background",
		"param_name" => "video_bg",
		"value" => array(
			"No" => "",
			"YouTube" => "youtube",
			"Vimeo" => "vimeo"	
		),
		"group" => __( 'Video Background', 'north' ),
		"description" => __("Enable a Video Background", 'north'),
	));
	
	vc_add_param("vc_row", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "YouTube Video ID",
		"param_name" => "video",
		"value"	=> '',
		"description" => __("Enter the YouTube video's ID to be displayed as the row background. Example: mSLAF_DjiDU", 'north'),
		"group" => __( 'Video Background', 'north' ),
		"dependency" => Array('element' => "video_bg", 'value' => 'youtube')
	));
	
	vc_add_param("vc_row", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "Vimeo ID",
		"param_name" => "vimeo",
		"value"	=> '',
		"description" => __("Enter the Vimeo video's ID to be displayed as the row background. Example: 51287059", 'north'),
		"group" => __( 'Video Background', 'north' ),
		"dependency" => Array('element' => "video_bg", 'value' => 'vimeo')
	));
	
	vc_add_param("vc_row", array(
		"type" => "dropdown",
		"class" => "",
		"heading" => "Video Autoplay",
		"param_name" => "video_autoplay",
		"value" => array(
			"True" => "true",
			"False" => "false"		
		),
		"description" => "Should the video play in a loop or not?",
		"group" => __( 'Video Background', 'north' ),
		"dependency" => Array('element' => "video_bg", 'value' => array('youtube','vimeo'))
	));
	
	vc_add_param("vc_row", array(
		"type" => "dropdown",
		"class" => "",
		"heading" => "Video Player Controls",
		"param_name" => "video_controls",
		"value" => array(
			"True" => "true",
			"False" => "false"		
		),
		"description" => "Display the video player controls?",
		"group" => __( 'Video Background', 'north' ),
		"dependency" => Array('element' => "video_bg", 'value' => array('youtube'))
	));
	
	vc_add_param("vc_row", array(
		"type" => "dropdown",
		"class" => "",
		"heading" => "Mute Video",
		"param_name" => "video_mute",
		"value" => array(
			"True" => "true",
			"False" => "false"		
		),
		"description" => "Mute the video?",
		"group" => __( 'Video Background', 'north' ),
		"dependency" => Array('element' => "video_bg", 'value' => array('youtube'))
	));

}

// VC Video

vc_add_param("vc_video", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Frame Style",
	"param_name" => "frame",
	"value" => array(
		"None" => "",
		"iPad" => "ipad"		
	),
	"description" => "Enable the iPad frame around the video embed. If enabled, the video will be displayed with preset height and width.",
));

// VC Carousel

vc_remove_param("vc_images_carousel","title");
vc_remove_param("vc_images_carousel","el_class");
vc_remove_param("vc_images_carousel","onclick");
vc_remove_param("vc_images_carousel","custom_links");
vc_remove_param("vc_images_carousel","custom_links_target");
vc_remove_param("vc_images_carousel","mode");
vc_remove_param("vc_images_carousel","speed");
vc_remove_param("vc_images_carousel","slides_per_view");
vc_remove_param("vc_images_carousel","autoplay");
vc_remove_param("vc_images_carousel","hide_pagination_control");
vc_remove_param("vc_images_carousel","hide_prev_next_buttons");
vc_remove_param("vc_images_carousel","partial_view");
vc_remove_param("vc_images_carousel","wrap");

vc_add_param("vc_images_carousel", array(
	"type" => "dropdown",
	"heading" => __("Captions", "north"),
	"param_name" => "captions",
	"class" => "hidden-label",
	"value" => array("Yes, from media library" => "library", "Yes, custom" => "custom", "None" => 'none'),
	"description" => __("Choose a type of captions or completely disable them.", "north")
));

vc_add_param("vc_images_carousel", array(
	"type" => "exploded_textarea",
	"heading" => __("Custom Captions", "north"),
	"param_name" => "custom_captions",
	"class" => "hidden-label",
	"value" => "Slide 1 Title|Slide 1 Subtitle,Slide 2 Title|Slide 2 Subtitle,Slide 3 Title|Slide 3 Subtitle",
	"description" => __("Enter custom captions for your slider images. Separate each with new line (Enter)", "north"),
	"dependency" => Array('element' => "captions", 'value' => array("custom"))
));

vc_add_param("vc_images_carousel", array(
	"type" => "dropdown",
	"heading" => __("Fullscreen", "north"),
	"param_name" => "fullscreen",
	"class" => "hidden-label",
	"value" => array("No" => "no", "Yes" => "yes"),
	"description" => __("Toggle the fullscreen size of the image slider.", "north")
));
 

// VC Tabs

vc_remove_param("vc_tabs","el_class");

vc_add_param("vc_tabs", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Tabs Style",
	"param_name" => "style",
	"value" => array(
		"Default Tabs" => "",
		"Stylish Tabs" => "stylish"
	),
	"description" => "Tab's style.",
));


// VC Separator

vc_add_param("vc_separator", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Fullscreen width",
	"param_name" => "fullwidth",
	"value" => array(
		"No" => "",
		"Yes" => "yes"
	),
	"description" => "Make the divider stretch to full size of the browser's viewport.",
));

// VC Text

vc_add_param("vc_column_text", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Fullscreen width",
	"param_name" => "fullwidth",
	"value" => array(
		"No" => "",
		"Yes" => "yes"
	),
	"description" => "Make the divider stretch to full size of the browser's viewport.",
));

// VC Progress Bar

vc_remove_param("vc_progress_bar","options");
vc_remove_param("vc_progress_bar","el_class");

// VC Gallery

vc_remove_param("vc_gallery","type");
vc_remove_param("vc_gallery","interval");
vc_remove_param("vc_gallery","el_class");
vc_remove_param("vc_gallery","img_size");

//vc_add_param("vc_gallery", array(
//   "type" => "dropdown",
//   "class" => "hidden-label",
//   "heading" => __("Number of columns", "north"),
//   "param_name" => "cols",
//   "value" => array(8,7,6,5,4,3,2,1),
//   "description" => __("Choose a number of columns for your carousel.", "north"),
//   "admin_label" => true
//));

vc_add_param("vc_gallery", array(
    "type" => "dropdown",
    "heading" => __("Image Size", "north"),
    "param_name" => "img_size",
    "description" => __('Choose an image size for your gallery thumbnails.', 'north'),
    'value' => array(
    	"875x360" => "875x360",
    	"800x600" => "800x600",
    	"460x368" => "460x368",
    	"Custom size" => "custom",
    )
));

vc_add_param("vc_gallery", array(
    "type" => "textfield",
    "heading" => __("Image size", "north"),
    "param_name" => "img_size_custom",
    "value" => "",
    "description" => __("Enter image size in pixels, e.g: 300x200 (Width x Height).", "north"),
    "dependency" => Array('element' => "img_size", 'value' => array("custom"))
));


// Font Awesome Icons Param

function vntd_init_icons_param($settings, $value) {
   return 'init_icons';
}
//add_shortcode_param('init_icons', 'vntd_init_icons_param', get_template_directory_uri().'/wpbakery/assets/icon-init.js');

function vntd_fontawesome_array() {
	$icons = array ('fa-glass' => 'fa-glass',
	  'fa-music' => 'fa-music',
	  'fa-search' => 'fa-search',
	  'fa-envelope-o' => 'fa-envelope-o',
	  'fa-heart' => 'fa-heart',
	  'fa-star' => 'fa-star',
	  'fa-star-o' => 'fa-star-o',
	  'fa-user' => 'fa-user',
	  'fa-film' => 'fa-film',
	  'fa-th-large' => 'fa-th-large',
	  'fa-th' => 'fa-th',
	  'fa-th-list' => 'fa-th-list',
	  'fa-check' => 'fa-check',
	  'fa-times' => 'fa-times',
	  'fa-search-plus' => 'fa-search-plus',
	  'fa-search-minus' => 'fa-search-minus',
	  'fa-power-off' => 'fa-power-off',
	  'fa-signal' => 'fa-signal',
	  'fa-cog' => 'fa-cog',
	  'fa-trash-o' => 'fa-trash-o',
	  'fa-home' => 'fa-home',
	  'fa-file-o' => 'fa-file-o',
	  'fa-clock-o' => 'fa-clock-o',
	  'fa-road' => 'fa-road',
	  'fa-download' => 'fa-download',
	  'fa-arrow-circle-o-down' => 'fa-arrow-circle-o-down',
	  'fa-arrow-circle-o-up' => 'fa-arrow-circle-o-up',
	  'fa-inbox' => 'fa-inbox',
	  'fa-play-circle-o' => 'fa-play-circle-o',
	  'fa-repeat' => 'fa-repeat',
	  'fa-refresh' => 'fa-refresh',
	  'fa-list-alt' => 'fa-list-alt',
	  'fa-lock' => 'fa-lock',
	  'fa-flag' => 'fa-flag',
	  'fa-headphones' => 'fa-headphones',
	  'fa-volume-off' => 'fa-volume-off',
	  'fa-volume-down' => 'fa-volume-down',
	  'fa-volume-up' => 'fa-volume-up',
	  'fa-qrcode' => 'fa-qrcode',
	  'fa-barcode' => 'fa-barcode',
	  'fa-tag' => 'fa-tag',
	  'fa-tags' => 'fa-tags',
	  'fa-book' => 'fa-book',
	  'fa-bookmark' => 'fa-bookmark',
	  'fa-print' => 'fa-print',
	  'fa-camera' => 'fa-camera',
	  'fa-font' => 'fa-font',
	  'fa-bold' => 'fa-bold',
	  'fa-italic' => 'fa-italic',
	  'fa-text-height' => 'fa-text-height',
	  'fa-text-width' => 'fa-text-width',
	  'fa-align-left' => 'fa-align-left',
	  'fa-align-center' => 'fa-align-center',
	  'fa-align-right' => 'fa-align-right',
	  'fa-align-justify' => 'fa-align-justify',
	  'fa-list' => 'fa-list',
	  'fa-outdent' => 'fa-outdent',
	  'fa-indent' => 'fa-indent',
	  'fa-video-camera' => 'fa-video-camera',
	  'fa-picture-o' => 'fa-picture-o',
	  'fa-pencil' => 'fa-pencil',
	  'fa-map-marker' => 'fa-map-marker',
	  'fa-adjust' => 'fa-adjust',
	  'fa-tint' => 'fa-tint',
	  'fa-pencil-square-o' => 'fa-pencil-square-o',
	  'fa-share-square-o' => 'fa-share-square-o',
	  'fa-check-square-o' => 'fa-check-square-o',
	  'fa-arrows' => 'fa-arrows',
	  'fa-step-backward' => 'fa-step-backward',
	  'fa-fast-backward' => 'fa-fast-backward',
	  'fa-backward' => 'fa-backward',
	  'fa-play' => 'fa-play',
	  'fa-pause' => 'fa-pause',
	  'fa-stop' => 'fa-stop',
	  'fa-forward' => 'fa-forward',
	  'fa-fast-forward' => 'fa-fast-forward',
	  'fa-step-forward' => 'fa-step-forward',
	  'fa-eject' => 'fa-eject',
	  'fa-chevron-left' => 'fa-chevron-left',
	  'fa-chevron-right' => 'fa-chevron-right',
	  'fa-plus-circle' => 'fa-plus-circle',
	  'fa-minus-circle' => 'fa-minus-circle',
	  'fa-times-circle' => 'fa-times-circle',
	  'fa-check-circle' => 'fa-check-circle',
	  'fa-question-circle' => 'fa-question-circle',
	  'fa-info-circle' => 'fa-info-circle',
	  'fa-crosshairs' => 'fa-crosshairs',
	  'fa-times-circle-o' => 'fa-times-circle-o',
	  'fa-check-circle-o' => 'fa-check-circle-o',
	  'fa-ban' => 'fa-ban',
	  'fa-arrow-left' => 'fa-arrow-left',
	  'fa-arrow-right' => 'fa-arrow-right',
	  'fa-arrow-up' => 'fa-arrow-up',
	  'fa-arrow-down' => 'fa-arrow-down',
	  'fa-share' => 'fa-share',
	  'fa-expand' => 'fa-expand',
	  'fa-compress' => 'fa-compress',
	  'fa-plus' => 'fa-plus',
	  'fa-minus' => 'fa-minus',
	  'fa-asterisk' => 'fa-asterisk',
	  'fa-exclamation-circle' => 'fa-exclamation-circle',
	  'fa-gift' => 'fa-gift',
	  'fa-leaf' => 'fa-leaf',
	  'fa-fire' => 'fa-fire',
	  'fa-eye' => 'fa-eye',
	  'fa-eye-slash' => 'fa-eye-slash',
	  'fa-exclamation-triangle' => 'fa-exclamation-triangle',
	  'fa-plane' => 'fa-plane',
	  'fa-calendar' => 'fa-calendar',
	  'fa-random' => 'fa-random',
	  'fa-comment' => 'fa-comment',
	  'fa-magnet' => 'fa-magnet',
	  'fa-chevron-up' => 'fa-chevron-up',
	  'fa-chevron-down' => 'fa-chevron-down',
	  'fa-retweet' => 'fa-retweet',
	  'fa-shopping-cart' => 'fa-shopping-cart',
	  'fa-folder' => 'fa-folder',
	  'fa-folder-open' => 'fa-folder-open',
	  'fa-arrows-v' => 'fa-arrows-v',
	  'fa-arrows-h' => 'fa-arrows-h',
	  'fa-bar-chart-o' => 'fa-bar-chart-o',
	  'fa-twitter-square' => 'fa-twitter-square',
	  'fa-facebook-square' => 'fa-facebook-square',
	  'fa-camera-retro' => 'fa-camera-retro',
	  'fa-key' => 'fa-key',
	  'fa-cogs' => 'fa-cogs',
	  'fa-comments' => 'fa-comments',
	  'fa-thumbs-o-up' => 'fa-thumbs-o-up',
	  'fa-thumbs-o-down' => 'fa-thumbs-o-down',
	  'fa-star-half' => 'fa-star-half',
	  'fa-heart-o' => 'fa-heart-o',
	  'fa-sign-out' => 'fa-sign-out',
	  'fa-linkedin-square' => 'fa-linkedin-square',
	  'fa-thumb-tack' => 'fa-thumb-tack',
	  'fa-external-link' => 'fa-external-link',
	  'fa-sign-in' => 'fa-sign-in',
	  'fa-trophy' => 'fa-trophy',
	  'fa-github-square' => 'fa-github-square',
	  'fa-upload' => 'fa-upload',
	  'fa-lemon-o' => 'fa-lemon-o',
	  'fa-phone' => 'fa-phone',
	  'fa-square-o' => 'fa-square-o',
	  'fa-bookmark-o' => 'fa-bookmark-o',
	  'fa-phone-square' => 'fa-phone-square',
	  'fa-twitter' => 'fa-twitter',
	  'fa-facebook' => 'fa-facebook',
	  'fa-github' => 'fa-github',
	  'fa-unlock' => 'fa-unlock',
	  'fa-credit-card' => 'fa-credit-card',
	  'fa-rss' => 'fa-rss',
	  'fa-hdd-o' => 'fa-hdd-o',
	  'fa-bullhorn' => 'fa-bullhorn',
	  'fa-bell' => 'fa-bell',
	  'fa-certificate' => 'fa-certificate',
	  'fa-hand-o-right' => 'fa-hand-o-right',
	  'fa-hand-o-left' => 'fa-hand-o-left',
	  'fa-hand-o-up' => 'fa-hand-o-up',
	  'fa-hand-o-down' => 'fa-hand-o-down',
	  'fa-arrow-circle-left' => 'fa-arrow-circle-left',
	  'fa-arrow-circle-right' => 'fa-arrow-circle-right',
	  'fa-arrow-circle-up' => 'fa-arrow-circle-up',
	  'fa-arrow-circle-down' => 'fa-arrow-circle-down',
	  'fa-globe' => 'fa-globe',
	  'fa-wrench' => 'fa-wrench',
	  'fa-tasks' => 'fa-tasks',
	  'fa-filter' => 'fa-filter',
	  'fa-briefcase' => 'fa-briefcase',
	  'fa-arrows-alt' => 'fa-arrows-alt',
	  'fa-users' => 'fa-users',
	  'fa-link' => 'fa-link',
	  'fa-cloud' => 'fa-cloud',
	  'fa-flask' => 'fa-flask',
	  'fa-scissors' => 'fa-scissors',
	  'fa-files-o' => 'fa-files-o',
	  'fa-paperclip' => 'fa-paperclip',
	  'fa-floppy-o' => 'fa-floppy-o',
	  'fa-square' => 'fa-square',
	  'fa-bars' => 'fa-bars',
	  'fa-list-ul' => 'fa-list-ul',
	  'fa-list-ol' => 'fa-list-ol',
	  'fa-strikethrough' => 'fa-strikethrough',
	  'fa-underline' => 'fa-underline',
	  'fa-table' => 'fa-table',
	  'fa-magic' => 'fa-magic',
	  'fa-truck' => 'fa-truck',
	  'fa-pinterest' => 'fa-pinterest',
	  'fa-pinterest-square' => 'fa-pinterest-square',
	  'fa-google-plus-square' => 'fa-google-plus-square',
	  'fa-google-plus' => 'fa-google-plus',
	  'fa-money' => 'fa-money',
	  'fa-caret-down' => 'fa-caret-down',
	  'fa-caret-up' => 'fa-caret-up',
	  'fa-caret-left' => 'fa-caret-left',
	  'fa-caret-right' => 'fa-caret-right',
	  'fa-columns' => 'fa-columns',
	  'fa-sort' => 'fa-sort',
	  'fa-sort-desc' => 'fa-sort-desc',
	  'fa-sort-asc' => 'fa-sort-asc',
	  'fa-envelope' => 'fa-envelope',
	  'fa-linkedin' => 'fa-linkedin',
	
	  'fa-undo' => 'fa-undo',
	  'fa-gavel' => 'fa-gavel',
	  'fa-tachometer' => 'fa-tachometer',
	  'fa-comment-o' => 'fa-comment-o',
	  'fa-comments-o' => 'fa-comments-o',
	  'fa-bolt' => 'fa-bolt',
	  'fa-sitemap' => 'fa-sitemap',
	  'fa-umbrella' => 'fa-umbrella',
	  'fa-clipboard' => 'fa-clipboard',
	  'fa-lightbulb-o' => 'fa-lightbulb-o',
	  'fa-exchange' => 'fa-exchange',
	  'fa-cloud-download' => 'fa-cloud-download',
	  'fa-cloud-upload' => 'fa-cloud-upload',
	  'fa-user-md' => 'fa-user-md',
	  'fa-stethoscope' => 'fa-stethoscope',
	  'fa-suitcase' => 'fa-suitcase',
	  'fa-bell-o' => 'fa-bell-o',
	  'fa-coffee' => 'fa-coffee',
	  'fa-cutlery' => 'fa-cutlery',
	  'fa-file-text-o' => 'fa-file-text-o',
	  'fa-building-o' => 'fa-building-o',
	  'fa-hospital-o' => 'fa-hospital-o',
	  'fa-ambulance' => 'fa-ambulance',
	  'fa-medkit' => 'fa-medkit',
	  'fa-fighter-jet' => 'fa-fighter-jet',
	  'fa-beer' => 'fa-beer',
	  'fa-h-square' => 'fa-h-square',
	  'fa-plus-square' => 'fa-plus-square',
	  'fa-angle-double-left' => 'fa-angle-double-left',
	  'fa-angle-double-right' => 'fa-angle-double-right',
	  'fa-angle-double-up' => 'fa-angle-double-up',
	  'fa-angle-double-down' => 'fa-angle-double-down',
	  'fa-angle-left' => 'fa-angle-left',
	  'fa-angle-right' => 'fa-angle-right',
	  'fa-angle-up' => 'fa-angle-up',
	  'fa-angle-down' => 'fa-angle-down',
	  'fa-desktop' => 'fa-desktop',
	  'fa-laptop' => 'fa-laptop',
	  'fa-tablet' => 'fa-tablet',
	  'fa-mobile' => 'fa-mobile',
	  'fa-circle-o' => 'fa-circle-o',
	  'fa-quote-left' => 'fa-quote-left',
	  'fa-quote-right' => 'fa-quote-right',
	  'fa-spinner' => 'fa-spinner',
	  'fa-circle' => 'fa-circle',
	  'fa-reply' => 'fa-reply',
	  'fa-github-alt' => 'fa-github-alt',
	  'fa-folder-o' => 'fa-folder-o',
	  'fa-folder-open-o' => 'fa-folder-open-o',
	  'fa-smile-o' => 'fa-smile-o',
	  'fa-frown-o' => 'fa-frown-o',
	  'fa-meh-o' => 'fa-meh-o',
	  'fa-gamepad' => 'fa-gamepad',
	  'fa-keyboard-o' => 'fa-keyboard-o',
	  'fa-flag-o' => 'fa-flag-o',
	  'fa-flag-checkered' => 'fa-flag-checkered',
	  'fa-terminal' => 'fa-terminal',
	  'fa-code' => 'fa-code',
	  'fa-reply-all' => 'fa-reply-all',
	  'fa-star-half-o' => 'fa-star-half-o',
	  'fa-location-arrow' => 'fa-location-arrow',
	  'fa-crop' => 'fa-crop',
	  'fa-code-fork' => 'fa-code-fork',
	  'fa-chain-broken' => 'fa-chain-broken',
	  'fa-question' => 'fa-question',
	  'fa-info' => 'fa-info',
	  'fa-exclamation' => 'fa-exclamation',
	  'fa-superscript' => 'fa-superscript',
	  'fa-subscript' => 'fa-subscript',
	  'fa-eraser' => 'fa-eraser',
	  'fa-puzzle-piece' => 'fa-puzzle-piece',
	  'fa-microphone' => 'fa-microphone',
	  'fa-microphone-slash' => 'fa-microphone-slash',
	  'fa-shield' => 'fa-shield',
	  'fa-calendar-o' => 'fa-calendar-o',
	  'fa-fire-extinguisher' => 'fa-fire-extinguisher',
	  'fa-rocket' => 'fa-rocket',
	  'fa-maxcdn' => 'fa-maxcdn',
	  'fa-chevron-circle-left' => 'fa-chevron-circle-left',
	  'fa-chevron-circle-right' => 'fa-chevron-circle-right',
	  'fa-chevron-circle-up' => 'fa-chevron-circle-up',
	  'fa-chevron-circle-down' => 'fa-chevron-circle-down',
	  'fa-html5' => 'fa-html5',
	  'fa-css3' => 'fa-css3',
	  'fa-anchor' => 'fa-anchor',
	  'fa-unlock-alt' => 'fa-unlock-alt',
	  'fa-bullseye' => 'fa-bullseye',
	  'fa-ellipsis-h' => 'fa-ellipsis-h',
	  'fa-ellipsis-v' => 'fa-ellipsis-v',
	  'fa-rss-square' => 'fa-rss-square',
	  'fa-play-circle' => 'fa-play-circle',
	  'fa-ticket' => 'fa-ticket',
	  'fa-minus-square' => 'fa-minus-square',
	  'fa-minus-square-o' => 'fa-minus-square-o',
	  'fa-level-up' => 'fa-level-up',
	  'fa-level-down' => 'fa-level-down',
	  'fa-check-square' => 'fa-check-square',
	  'fa-pencil-square' => 'fa-pencil-square',
	  'fa-external-link-square' => 'fa-external-link-square',
	  'fa-share-square' => 'fa-share-square',
	  'fa-compass' => 'fa-compass',
	  'fa-caret-square-o-down' => 'fa-caret-square-o-down',
	  'fa-caret-square-o-up' => 'fa-caret-square-o-up',
	  'fa-caret-square-o-right' => 'fa-caret-square-o-right',
	  'fa-eur' => 'fa-eur',
	  'fa-gbp' => 'fa-gbp',
	  'fa-usd' => 'fa-usd',
	  'fa-inr' => 'fa-inr',
	  'fa-jpy' => 'fa-jpy',
	  'fa-rub' => 'fa-rub',
	  'fa-krw' => 'fa-krw',
	  'fa-btc' => 'fa-btc',
	  'fa-file' => 'fa-file',
	  'fa-file-text' => 'fa-file-text',
	  'fa-sort-alpha-asc' => 'fa-sort-alpha-asc',
	  'fa-sort-alpha-desc' => 'fa-sort-alpha-desc',
	  'fa-sort-amount-asc' => 'fa-sort-amount-asc',
	  'fa-sort-amount-desc' => 'fa-sort-amount-desc',
	  'fa-sort-numeric-asc' => 'fa-sort-numeric-asc',
	  'fa-sort-numeric-desc' => 'fa-sort-numeric-desc',
	  'fa-thumbs-up' => 'fa-thumbs-up',
	  'fa-thumbs-down' => 'fa-thumbs-down',
	  'fa-youtube-square' => 'fa-youtube-square',
	  'fa-youtube' => 'fa-youtube',
	  'fa-xing' => 'fa-xing',
	  'fa-xing-square' => 'fa-xing-square',
	  'fa-youtube-play' => 'fa-youtube-play',
	  'fa-dropbox' => 'fa-dropbox',
	  'fa-stack-overflow' => 'fa-stack-overflow',
	  'fa-instagram' => 'fa-instagram',
	  'fa-flickr' => 'fa-flickr',
	  'fa-adn' => 'fa-adn',
	  'fa-bitbucket' => 'fa-bitbucket',
	  'fa-bitbucket-square' => 'fa-bitbucket-square',
	  'fa-tumblr' => 'fa-tumblr',
	  'fa-tumblr-square' => 'fa-tumblr-square',
	  'fa-long-arrow-down' => 'fa-long-arrow-down',
	  'fa-long-arrow-up' => 'fa-long-arrow-up',
	  'fa-long-arrow-left' => 'fa-long-arrow-left',
	  'fa-long-arrow-right' => 'fa-long-arrow-right',
	  'fa-apple' => 'fa-apple',
	  'fa-windows' => 'fa-windows',
	  'fa-android' => 'fa-android',
	  'fa-linux' => 'fa-linux',
	  'fa-dribbble' => 'fa-dribbble',
	  'fa-skype' => 'fa-skype',
	  'fa-foursquare' => 'fa-foursquare',
	  'fa-trello' => 'fa-trello',
	  'fa-female' => 'fa-female',
	  'fa-male' => 'fa-male',
	  'fa-gittip' => 'fa-gittip',
	  'fa-sun-o' => 'fa-sun-o',
	  'fa-moon-o' => 'fa-moon-o',
	  'fa-archive' => 'fa-archive',
	  'fa-bug' => 'fa-bug',
	  'fa-vk' => 'fa-vk',
	  'fa-weibo' => 'fa-weibo',
	  'fa-renren' => 'fa-renren',
	  'fa-pagelines' => 'fa-pagelines',
	  'fa-stack-exchange' => 'fa-stack-exchange',
	  'fa-arrow-circle-o-right' => 'fa-arrow-circle-o-right',
	  'fa-arrow-circle-o-left' => 'fa-arrow-circle-o-left',
	  'fa-caret-square-o-left' => 'fa-caret-square-o-left',
	  'fa-dot-circle-o' => 'fa-dot-circle-o',
	  'fa-wheelchair' => 'fa-wheelchair',
	  'fa-vimeo-square' => 'fa-vimeo-square',
	  'fa-try' => 'fa-try',
	  'fa-plus-square-o' => 'fa-plus-square-o',
	  'fa-space-shuttle' => 'fa-space-shuttle',
	  'fa-slack' => 'fa-slack',
	  'fa-envelope-square' => 'fa-envelope-square',
	  'fa-wordpress' => 'fa-wordpress',
	  'fa-openid' => 'fa-openid',
	  'fa-university' => 'fa-university',
	  'fa-graduation-cap' => 'fa-graduation-cap',
	  'fa-yahoo' => 'fa-yahoo',
	  'fa-google' => 'fa-google',
	  'fa-reddit' => 'fa-reddit',
	  'fa-reddit-square' => 'fa-reddit-square',
	  'fa-stumbleupon-circle' => 'fa-stumbleupon-circle',
	  'fa-stumbleupon' => 'fa-stumbleupon',
	  'fa-delicious' => 'fa-delicious',
	  'fa-digg' => 'fa-digg',
	  'fa-pied-piper' => 'fa-pied-piper',
	  'fa-pied-piper-alt' => 'fa-pied-piper-alt',
	  'fa-drupal' => 'fa-drupal',
	  'fa-joomla' => 'fa-joomla',
	  'fa-language' => 'fa-language',
	  'fa-fax' => 'fa-fax',
	
	  'fa-building' => 'fa-building',
	  'fa-child' => 'fa-child',
	  'fa-paw' => 'fa-paw',
	  'fa-spoon' => 'fa-spoon',
	  'fa-cube' => 'fa-cube',
	  'fa-cubes' => 'fa-cubes',
	  'fa-behance' => 'fa-behance',
	  'fa-behance-square' => 'fa-behance-square',
	  'fa-steam' => 'fa-steam',
	  'fa-steam-square' => 'fa-steam-square',
	  'fa-recycle' => 'fa-recycle',
	  'fa-car' => 'fa-car',
	  'fa-taxi' => 'fa-taxi',
	  'fa-tree' => 'fa-tree',
	  'fa-spotify' => 'fa-spotify',
	  'fa-deviantart' => 'fa-deviantart',
	  'fa-soundcloud' => 'fa-soundcloud',
	  'fa-database' => 'fa-database',
	  'fa-file-pdf-o' => 'fa-file-pdf-o',
	  'fa-file-word-o' => 'fa-file-word-o',
	  'fa-file-excel-o' => 'fa-file-excel-o',
	  'fa-file-powerpoint-o' => 'fa-file-powerpoint-o',
	  'fa-file-image-o' => 'fa-file-image-o',
	  'fa-file-archive-o' => 'fa-file-archive-o',
	  'fa-file-audio-o' => 'fa-file-audio-o',
	  'fa-file-video-o' => 'fa-file-video-o',
	  'fa-file-code-o' => 'fa-file-code-o',
	  'fa-vine' => 'fa-vine',
	  'fa-codepen' => 'fa-codepen',
	  'fa-jsfiddle' => 'fa-jsfiddle',
	  'fa-life-ring' => 'fa-life-ring',
	  'fa-circle-o-notch' => 'fa-circle-o-notch',
	  'fa-rebel' => 'fa-rebel',
	  'fa-empire' => 'fa-empire',
	  'fa-git-square' => 'fa-git-square',
	  'fa-git' => 'fa-git',
	  'fa-hacker-news' => 'fa-hacker-news',
	  'fa-tencent-weibo' => 'fa-tencent-weibo',
	  'fa-qq' => 'fa-qq',
	  'fa-weixin' => 'fa-weixin',
	  'fa-paper-plane' => 'fa-paper-plane',
	  'fa-paper-plane-o' => 'fa-paper-plane-o',
	  'fa-history' => 'fa-history',
	  'fa-circle-thin' => 'fa-circle-thin',
	  'fa-header' => 'fa-header',
	  'fa-paragraph' => 'fa-paragraph',
	  'fa-sliders' => 'fa-sliders',
	  'fa-share-alt' => 'fa-share-alt',
	  'fa-share-alt-square' => 'fa-share-alt-square',
	  'fa-angellist' => 'fa-angellist',
	  'fa-bomb' => 'fa-bomb');
	
	return $icons;
}

//
// Register new params
//

// Dropdown menu of pages

function param_pages_dropdown($settings, $value) {
       
           
	$return = '<div class="select_wrapper"><select name="'.$settings['param_name'].'" class="wpb_vc_param_value dropdown wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'">';
	$return .= '<option value="">Select Page</option> ';
    	
	$pages = get_pages(); 
	foreach ( $pages as $page ) {
		$selected = '';
		if($page->ID == $value) { $selected = 'selected="selected"'; }	
		$return .= '<option value="'.$page->ID.'" '.$selected.'>'.$page->post_title.'</option>';
		$checked = "";
 	}
 	
	$return .= '</select></div>';
   
	return $return;
}
add_shortcode_param('pages_dropdown', 'param_pages_dropdown');

// Dropdown menu of blog categories

function vntd_vc_blog_cats() {
	$blog_cats = array();
	$blog_categories = get_categories();
	
	foreach($blog_categories as $blog_cat) {
		$blog_cats[$blog_cat->name] = $blog_cat->term_id;
	}
	
	return $blog_cats;
}

// Dropdown menu of portfolio categories

function vntd_vc_portfolio_cats() {

	$portfolio_categories = get_categories('taxonomy=project-type');
	
	$portfolio_cats = array();
	
	foreach($portfolio_categories as $portfolio_cat) {
		$portfolio_cats[$portfolio_cat->name] = $portfolio_cat->slug;
	}
	
	return $portfolio_cats;
	
}

//
// Register new shortcodes:
//


// Carousel Portfolio

add_action("admin_init", "vntd_vc_shortcodes"); 

function vntd_vc_shortcodes() {

	// Link Target array
	$target_arr = array(__("Same window", "north") => "_self", __("New window", "north") => "_blank");
	$colors_arr = array(__("Accent Color", "north") => "accent", __("Blue", "north") => "blue", __("Turquoise", "north") => "turquoise", __("Green", "north") => "green", __("Orange", "north") => "orange", __("Red", "north") => "red", __("Dark", "north") => "dark",__("Grey", "north") => "grey", __("Custom Color", "north") => "custom");
	
	wpb_map( array(
	   "name" => __("Portfolio Carousel", "north"),
	   "base" => "portfolio_carousel",
	   "class" => "font-awesome",
	   "icon"      => "fa-briefcase",
	   "controls" => "full",
	   "description" => "Carousel of portfolio posts",
	   "category" => array("Carousels", "Posts"),
	   "params" => array(
	      array(
	         "type" => "checkbox",
	         "class" => "hidden-label",
	         "value" => vntd_vc_portfolio_cats(),
	         "heading" => __("Portfolio Categories", "north"),
	         "param_name" => "cats",
	         "admin_label" => true,
	         "description" => __("Select categories to be displayed in your carousel. Leave blank for all.", "north")
	      ),	      
	      array(
	         "type" => "textfield",
	         "class" => "hidden-label",
	         "heading" => __("Number of posts to show", "north"),
	         "param_name" => "posts_nr",
	         "value" => "6",
	         "description" => __("This is a total number of posts in the carousel.", "north")
	      )
	      
	   )
	));
	
	// Blog Carousel
	
	wpb_map( array(
	   "name" => __("Blog Carousel", "north"),
	   "base" => "blog_carousel",
	   "class" => "font-awesome",
	   "icon"      => "fa-book",
	   "controls" => "full",
	   "description" => "Carousel of blog posts",
	   "category" => array("Carousels", "Posts"),
	   "params" => array(
	      array(
	         "type" => "checkbox",
	         "class" => "hidden-label",
	         "value" => vntd_vc_blog_cats(),
	         "heading" => __("Blog Categories", "north"),
	         "param_name" => "cats",
	         "admin_label" => true,
	         "description" => __("Select categories to be displayed in your carousel. Leave blank for all.", "north")
	      ),	      
	      array(
	         "type" => "textfield",
	         "class" => "hidden-label",
	         "heading" => __("Number of posts to show", "north"),
	         "param_name" => "posts_nr",
	         "value" => "6",
	         "description" => __("This is a total number of posts in the carousel.", "north")
	      ),	      
	      array(
	         "type" => "textfield",
	         "class" => "hidden-label",
	         "heading" => __("Post Title Height", "north"),
	         "param_name" => "title_height",
	         "value" => "",
	         "description" => __("Set an optional minimum height for the post titles. If some of your posts have a longer title and you want each item in the carousel perfectly aligned then please type a value like: 50px", "north")
	      )
	      
	   )
	));
		
	// Testimonials Carousel
	
	wpb_map( array(
	   "name" => __("Testimonials Carousel", "north"),
	   "base" => "testimonials",
	   "icon" => "fa-comments",
	   "class" => "font-awesome",
	   "category" => array("Carousels"),
	   "description" => "Fancy testimonials",
	   "params" => array(  
			array(
			   "type" => "dropdown",
			   "description" => "Choose a style for your testimonials carousel",
			   "class" => "hidden-label",
			   "heading" => __("Testimonials Style", "north"),
			   "param_name" => "style",
			   "value" => array("Simple" => "simple","Expanded (client avatar, columned view)" => "expanded"),
			   "admin_label" => true
			),
			array(	      
			 "type" => "textfield",
			 "class" => "hidden-label",
			 "heading" => __("Number of posts to show", "north"),
			 "param_name" => "posts_nr",
			 "value" => "6"
			)
	   )
	));
	
	// Logos Carousel
	
	wpb_map( array(
	   "name" => __("Logos Carousel", "north"),
	   "base" => "logos_carousel",
	   "icon" => "fa-css3",
	   "class" => "font-awesome",
	   "category" => array("Carousels"),
	   "description" => "Carousel of logo images",
	   "params" => array(  
			array(
				'type' => 'attach_images',
				'heading' => __( 'Images', 'north' ),
				'param_name' => 'images',
				'value' => '',
				'description' => __( 'Select images from media library.', 'north' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'On click', 'north' ),
				'param_name' => 'onclick',
				'value' => array(
					__( 'Do nothing', 'north' ) => 'link_no',
					__( 'Open custom link', 'north' ) => 'custom_link'
				),
				'description' => __( 'Define action for onclick event if needed.', 'north' )
			),
			array(
				'type' => 'exploded_textarea',
				'heading' => __( 'Custom links', 'north' ),
				'param_name' => 'custom_links',
				'description' => __( 'Enter links for each logo here. Divide links with linebreaks (Enter) . ', 'north' ),
				'dependency' => array(
					'element' => 'onclick',
					'value' => array( 'custom_link' )
				)
			),
	   )
	));
	
	// Services Carousel
	
	wpb_map( array(
	   "name" => __("Services Carousel", "north"),
	   "base" => "services_carousel",
	   "icon" => "fa-wrench",
	   "class" => "font-awesome",
	   "description" => "Carousel of services",
	   "category" => array("Carousels"),
	   "params" => array(  
			array(	      
			 "type" => "textfield",
			 "class" => "hidden-label",
			 "admin_label" => true,
			 "heading" => __("Number of services to show", "north"),
			 "param_name" => "posts_nr",
			 "value" => "6"
			)
	   )
	));
	
	// Video Lightbox
	
	wpb_map( array(
	   "name" => __("Video Lightbox", "north"),
	   "base" => "video_lightbox",
	   "icon" => "fa-play-circle-o",
	   "category" => array("Media"),
	   "class" => "font-awesome",
	   "description" => "Video in lightbox window",
	   "params" => array(  
	   		array(
	   			'type' => 'textfield',
	   			'heading' => __( 'Video link', 'north' ),
	   			'param_name' => 'link',
	   			'admin_label' => true,
	   			'description' => sprintf( __( 'Link to the video. More about supported formats at %s.', 'north' ), '<a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">WordPress codex page</a>' )
	   		),
			array(	      
			 "type" => "textfield",
			 "class" => "hidden-label",
			 "heading" => __("Label", "north"),
			 "param_name" => "label",
			 "value" => "6",
			 "desc" => 'Text label visible under the Play icon'
			)
	   )
	));
	
	// Team Carousel
	
	wpb_map( array(
	   "name" => __("Team Carousel", "north"),
	   "base" => "team_carousel",
	   "class" => "font-awesome",
	   "icon"      => "fa-users",
	   "controls" => "full",
	   "category" => array("Carousels", "Posts"),
	   "description" => "Carousel of your team members",
	   "params" => array(
	   	array(
	   	   "type" => "textfield",
	   	   "class" => "hidden-label",
	   	   "value" => "",
	   	   "heading" => __("Team Members ID", "north"),
	   	   "param_name" => "ids",
	   	   "description" => __("Insert IDs of specific team members to be displayed in this carousel. Leave blank to display all", "north")
	   	),
	      array(
	         "type" => "textfield",
	         "class" => "hidden-label",
	         "heading" => __("Number of posts to show", "north"),
	         "param_name" => "posts_nr",
	         "value" => "6",
	         "admin_label" => true,
	         "description" => __("Number of team members to be displayed in the carousel.", "north")
	      ),
	      array(
	         "type" => "dropdown",
	         "class" => "hidden-label",
	         "heading" => __("Lightbox Window with Member Details", "north"),
	         "param_name" => "lightbox",
	         "value" => array("Yes" => "yes","No" => "no"),
	         "description" => __("Disable the '+' icon that launches the lightbox window with the team member details.", "north")
	      ),
	      array(
	         "type" => "dropdown",
	         "class" => "hidden-label",
	         "heading" => __("Social icons link type", "north"),
	         "param_name" => "target",
	         "value" => array( esc_html__( "Open in a new tab", 'north' ) => "_blank", esc_html__( "Open in the same tab", 'north' ) => "_self" ),
	         "description" => esc_html__( "Decide if links should open in a new or same tab.", "north" )
	      ),
	      
	   )
	));
	
	// Portfolio Grid
	
	wpb_map( array(
	   "name" => __("Portfolio Grid", "north"),
	   "base" => "portfolio_grid",
	   "class" => "font-awesome",
	   "icon"      => "fa-th",
	   "controls" => "full",
	   "category" => array('Posts'),
	   "description" => "Portfolio posts grid",
	   "params" => array(
	      array(
	         "type" => "dropdown",
	         "class" => "hidden-label",
	         "heading" => __("Filtering menu", "north"),
	         "param_name" => "filter",
	         "value" => array("Yes" => "yes","No" => "no"),
	         "description" => __("Enable or disable the filterable effect.", "north")
	      ),
	      array(
	         "type" => "checkbox",
	         "class" => "hidden-label",
	         "value" => vntd_vc_portfolio_cats(),
	         "heading" => __("Portfolio Categories", "north"),
	         "param_name" => "cats",
	         "description" => __("Select categories to be displayed in the grid. Leave blank to display all.", "north")
	      ),
	      array(
	         "type" => "dropdown",
	         "class" => "hidden-label",
	         "heading" => __("Thumbnail Link Type", "north"),
	         "param_name" => "link_type",
	         "value" => array(
	         	'Ajax expandable content' => 'ajax',
	         	'Link to individual posts' => 'direct'
	          )
	      ),
	      array(
	         "type" => "dropdown",
	         "class" => "hidden-label",
	         "heading" => __("Thumbnail Spacing", "north"),
	         "param_name" => "thumb_space",
	         "value" => array("Yes" => "yes","No" => "no"),
	         "description" => __("Enable or disable the white space between post thumbnails.", "north")
	      ),
	      array(
	         "type" => "dropdown",
	         "class" => "hidden-label",
	         "heading" => __("Columns", "north"),
	         "param_name" => "cols",
	         "value" => array("5","4"),
	         "description" => __("Number of columns", "north"),
	         "dependency" => Array('element' => "thumb_space", 'value' => array("no"))
	      ),
	      array(
	         "type" => "dropdown",
	         "class" => "hidden-label",
	         "heading" => __("Thumbnail Size", "north"),
	         "std"	=> 'square',
	         "param_name" => "thumb_size",
	         "value" => array("Square" => "square","Original Aspect Ratio" => "auto"),
	         "description" => __("Portfolio grid thumbnails size.", "north")
	      ),	      
	      array(
	         "type" => "textfield",
	         "class" => "hidden-label",
	         "heading" => __("Posts Number", "north"),
	         "param_name" => "posts_nr",
	         "value" => '',
	         "description" => __("Number of portfolio posts to be displayed. Leave blank for no limit.", "north")
	      ),
	      array(
	         "type" => "textfield",
	         "class" => "hidden-label",
	         "heading" => __("See More Link", "north"),
	         "param_name" => "more_url",
	         "value" => '',
	         "description" => __("Enter the URL of your Portfolio page. If not blank - a big, square PLUS icon will appear under the portfolio grid.", "north")
	      ),
	   )
	));
	
	// Blog
	
//	wpb_map( array(
//	   "name" => __("Blog", "north"),
//	   "base" => "blog",
//	   "class" => "",
//	   "icon" => "fa-file-text-o",
//	   "controls" => "full",
//	   "category" => "Posts",
//	   "params" => array(     
//	      array(
//	         "type" => "checkbox",
//	         "class" => "hidden-label",
//	         "value" => vntd_vc_blog_cats(),
//	         "heading" => __("Blog Categories", "north"),
//	         "param_name" => "cats"
//	      ),
//	      array(
//	         "type" => "dropdown",
//	         "class" => "hidden-label",
//	         "heading" => __("Layout", "north"),
//	         "param_name" => "style",
//	         "value" => array("Default" => "default","Classic" => "classic","Grid" => "grid"),
//	         "admin_label" => true
//	      ), 
//	      array(
//	         "type" => "dropdown",
//	         "class" => "hidden-label",
//	         "heading" => __("Grid columns number", "north"),
//	         "param_name" => "grid_columns",
//	         "value" => array("4","3","2"),
//	         "dependency" => Array('element' => "style", 'value' => array("grid"))
//	      ),
//	      array(
//	         "type" => "textfield",
//	         "class" => "hidden-label",
//	         "heading" => __("Posts per page", "north"),
//	         "param_name" => "posts_nr",
//	         "value" => '',
//	      )      
//	   )
//	));

	$pixel_icons = array(
		array( 'vc_pixel_icon vc_pixel_icon-alert' => esc_html__( 'Alert', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-info' => esc_html__( 'Info', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-tick' => esc_html__( 'Tick', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-explanation' => esc_html__( 'Explanation', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-address_book' => esc_html__( 'Address book', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-alarm_clock' => esc_html__( 'Alarm clock', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-anchor' => esc_html__( 'Anchor', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-application_image' => esc_html__( 'Application Image', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-arrow' => esc_html__( 'Arrow', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-asterisk' => esc_html__( 'Asterisk', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-hammer' => esc_html__( 'Hammer', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-balloon' => esc_html__( 'Balloon', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-balloon_buzz' => esc_html__( 'Balloon Buzz', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-balloon_facebook' => esc_html__( 'Balloon Facebook', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-balloon_twitter' => esc_html__( 'Balloon Twitter', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-battery' => esc_html__( 'Battery', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-binocular' => esc_html__( 'Binocular', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-document_excel' => esc_html__( 'Document Excel', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-document_image' => esc_html__( 'Document Image', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-document_music' => esc_html__( 'Document Music', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-document_office' => esc_html__( 'Document Office', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-document_pdf' => esc_html__( 'Document PDF', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-document_powerpoint' => esc_html__( 'Document Powerpoint', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-document_word' => esc_html__( 'Document Word', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-bookmark' => esc_html__( 'Bookmark', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-camcorder' => esc_html__( 'Camcorder', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-camera' => esc_html__( 'Camera', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-chart' => esc_html__( 'Chart', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-chart_pie' => esc_html__( 'Chart pie', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-clock' => esc_html__( 'Clock', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-fire' => esc_html__( 'Fire', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-heart' => esc_html__( 'Heart', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-mail' => esc_html__( 'Mail', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-play' => esc_html__( 'Play', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-shield' => esc_html__( 'Shield', 'north' ) ),
		array( 'vc_pixel_icon vc_pixel_icon-video' => esc_html__( 'Video', 'north' ) ),
	);
	
	
	// Icon Box
	
	wpb_map( array(
	   "name" => __("Icon Box", "north"),
	   "base" => "icon_box",
	   "class" => "font-awesome",
	   "icon" => "fa-check-circle-o",
	   "controls" => "full",
	   "category" => 'Content',
	   "description" => "Text with an icon",
	   "params" => array(
	      array(
	         "type" => "textfield",
	         "class" => "hidden-label",
	         "heading" => __("Title", "north"),
	         "param_name" => "title",
	         "holder" => "h4",
	         "value" => ''
	      ), 	      
	      array(
	         "type" => "textarea",
	         "class" => "hidden-label",
	         "heading" => __("Text Content", "north"),
	         "param_name" => "text",
	         "holder" => "span",
	         "value" => '',
	      ), 
	      array(
	        "type" => "textfield",
	        "heading" => __("URL (Link)", "north"),
	        "param_name" => "url",
	        "description" => __("Optional icon link.", "north")
	      ),
	      array(
	        "type" => "textfield",
	        "heading" => __("Link Title", "north"),
	        "param_name" => "link_title",
	        "value" => 'More Info',
	        "dependency" => Array('element' => "url", 'not_empty' => true)
	      ),
	      array(
	        "type" => "dropdown",
	        "heading" => __("Target", "north"),
	        "param_name" => "target",
	        "value" => $target_arr,
	        "dependency" => Array('element' => "url", 'not_empty' => true)
	      ),
	      array(
	         "type" => "dropdown",
	         "class" => "hidden-label",
	         "heading" => __("Style", "north"),
	         "param_name" => "style",
	         "value" => array(
	         	'Default (Aligned Left)' => 'default',
	         	'Big Centered' => 'centered',
	         	'Aligned Left 2' => 'left',
	         	'Aligned Right 2' => 'right'
	         	)
	      ), 
	      array(
	        "type" => "dropdown",
	        "heading" => __("Animated", "north"),
	        "param_name" => "animated",
	        "value" => array("Yes" => "yes","No" => "no"),
	        "description" => "Enable the element fade in animation on scroll"
	      ),
	      	array(
	      	  "type" => "textfield",
	      	  "heading" => __("Animation Delay", "north"),
	      	  "param_name" => "animation_delay",
	      	  "value" => '100',
	      	  "description" => "Fade in animation delay. Can be used to create a nice delay effect if multiple elements of same type.",
	      	  "dependency" => Array('element' => "animated", 'value' => 'yes')
	      	),
//	      array(
//	          "type" => "checkbox",
//	          "class" => "radio-checkboxes",
//	          "heading" => __("Icon", "north"),
//	          "param_name" => "icon",
//	          "value" => vntd_fontawesome_array()
//	      ),
//	      array("type" => "init_icons"),
	      array(
	      	'type' => 'dropdown',
	      	'heading' => esc_html__( 'Icon library', 'north' ),
	      	'value' => array(
	      		esc_html__( 'Font Awesome', 'north' ) => 'fontawesome',
	      		esc_html__( 'Open Iconic', 'north' ) => 'openiconic',
	      		esc_html__( 'Typicons', 'north' ) => 'typicons',
	      		esc_html__( 'Entypo', 'north' ) => 'entypo',
	      		esc_html__( 'Linecons', 'north' ) => 'linecons',
	      		esc_html__( 'Pixel', 'north' ) => 'pixelicons',
	      	),
	      	'param_name' => 'icon_type',
	      	'description' => esc_html__( 'Select icon library.', 'north' ),
	      ),
	      array(
	      	'type' => 'iconpicker',
	      	'heading' => esc_html__( 'Icon', 'north' ),
	      	'param_name' => 'icon_fontawesome',
	          'value' => 'fa fa-info-circle',
	      	'settings' => array(
	      		'emptyIcon' => false, // default true, display an "EMPTY" icon?
	      		'iconsPerPage' => 200, // default 100, how many icons per/page to display
	      	),
	      	'dependency' => array(
	      		'element' => 'icon_type',
	      		'value' => 'fontawesome',
	      	),
	      	'description' => esc_html__( 'Select icon from library.', 'north' ),
	      ),
	      array(
	      	'type' => 'iconpicker',
	      	'heading' => esc_html__( 'Icon', 'north' ),
	      	'param_name' => 'icon_openiconic',
	      	'settings' => array(
	      		'emptyIcon' => false, // default true, display an "EMPTY" icon?
	      		'type' => 'openiconic',
	      		'iconsPerPage' => 200, // default 100, how many icons per/page to display
	      	),
	      	'dependency' => array(
	      		'element' => 'icon_type',
	      		'value' => 'openiconic',
	      	),
	      	'description' => esc_html__( 'Select icon from library.', 'north' ),
	      ),
	      array(
	      	'type' => 'iconpicker',
	      	'heading' => esc_html__( 'Icon', 'north' ),
	      	'param_name' => 'icon_typicons',
	      	'settings' => array(
	      		'emptyIcon' => false, // default true, display an "EMPTY" icon?
	      		'type' => 'typicons',
	      		'iconsPerPage' => 200, // default 100, how many icons per/page to display
	      	),
	      	'dependency' => array(
	      	'element' => 'icon_type',
	      	'value' => 'typicons',
	      ),
	      	'description' => esc_html__( 'Select icon from library.', 'north' ),
	      ),
	      array(
	      	'type' => 'iconpicker',
	      	'heading' => esc_html__( 'Icon', 'north' ),
	      	'param_name' => 'icon_entypo',
	      	'settings' => array(
	      		'emptyIcon' => false, // default true, display an "EMPTY" icon?
	      		'type' => 'entypo',
	      		'iconsPerPage' => 300, // default 100, how many icons per/page to display
	      	),
	      	'dependency' => array(
	      		'element' => 'icon_type',
	      		'value' => 'entypo',
	      	),
	      ),
	      array(
	      	'type' => 'iconpicker',
	      	'heading' => esc_html__( 'Icon', 'north' ),
	      	'param_name' => 'icon_linecons',
	      	'settings' => array(
	      		'emptyIcon' => false, // default true, display an "EMPTY" icon?
	      		'type' => 'linecons',
	      		'iconsPerPage' => 200, // default 100, how many icons per/page to display
	      	),
	      	'dependency' => array(
	      		'element' => 'icon_type',
	      		'value' => 'linecons',
	      	),
	      	'description' => esc_html__( 'Select icon from library.', 'north' ),
	      ),
	      array(
	      	'type' => 'iconpicker',
	      	'heading' => esc_html__( 'Icon', 'north' ),
	      	'param_name' => 'icon_pixelicons',
	      	'settings' => array(
	      		'emptyIcon' => false, // default true, display an "EMPTY" icon?
	      		'type' => 'pixelicons',
	      		'source' => $pixel_icons,
	      	),
	      	'dependency' => array(
	      		'element' => 'icon_type',
	      		'value' => 'pixelicons',
	      	),
	      	'description' => esc_html__( 'Select icon from library.', 'north' ),
	      )	      
	   )
	));	
	
	
	// Google Map
	
	wpb_map( array(
	   "name" => __("Google Map", "north"),
	   "base" => "gmap",
	   "icon"      => "icon-wpb-map-pin",
	   "category" => 'Content',
	   "description" => "Map block",
	   "params" => array(
	      array(
	         "type" => "textfield",
	         "class" => "hidden-label",
	         "heading" => __("Location Latitude", "north"),
	         "param_name" => "lat",
	         "value" => '41.862274',
	         "description" => __("Please insert the map address latitude if you have problems displaying it. Helpful site: <a target='_blank' href='http://www.latlong.net/'>http://www.latlong.net/</a>", "north")
	      ),
	      array(
	         "type" => "textfield",
	         "class" => "hidden-label",
	         "heading" => __("Location Longitude", "north"),
	         "param_name" => "long",
	         "value" => '-87.701328',
	         "description" => __("Please insert the map address longitude value.", "north")
	      ),
	      array(
	         "type" => "textfield",
	         "class" => "hidden-label",
	         "heading" => __("Map Height", "north"),
	         "param_name" => "height",
	         "value" => '400',
	         "description" => __("Height of the map element in pixels.", "north")
	      ),
	      array(
	         "type" => "textfield",
	         "class" => "hidden-label",
	         "heading" => __("Map Zoom", "north"),
	         "param_name" => "zoom",
	         "value" => '15',
	         "description" => __("Choose the map zoom. Default value: 15", "north")
	      ),
	      array(
	         "type" => "textfield",
	         "class" => "hidden-label",
	         "heading" => __("Marker 1 Title", "north"),
	         "param_name" => "marker1_title",
	         "value" => 'Office 1',
	         "description" => __("Marker 1 Title.", "north")
	      ),
	      array(
	         "type" => "textfield",
	         "class" => "hidden-label",
	         "heading" => __("Marker 1 Text", "north"),
	         "param_name" => "marker1_text",
	         "value" => 'Your description goes here.',
	         "description" => __("Marker 1 description text.", "north")
	      ),	      
	      array(
	        "type" => "dropdown",
	        "heading" => __("Marker 1 Location", "north"),
	        "param_name" => "marker1_location",
	        "value" => array(__("Map Center", "north") => "center", __("Custom", "north") => "custom"),
	        "description" => __("The first marker location", "north")
	      ),
	      array(
	         "type" => "textfield",
	         "class" => "hidden-label",
	         "heading" => __("Marker 1 Custom Location", "north"),
	         "param_name" => "marker1_location_custom",
	         "value" => '441.863774,-87.721328',
	         "description" => __("Marker 1 custom location in latitude,longitude format.", "north")
	      ),	
	      array(
	         "type" => "textfield",
	         "class" => "hidden-label",
	         "heading" => __("Marker 2 Title", "north"),
	         "param_name" => "marker2_title",
	         "value" => '',
	         "description" => __("Marker 2 Title.", "north")
	      ), 
	      array(
	         "type" => "textfield",
	         "class" => "hidden-label",
	         "heading" => __("Marker 2 Text", "north"),
	         "param_name" => "marker2_text",
	         "value" => 'My secondary marker description.',
	         "dependency" => Array('element' => "marker2_title", 'not_empty' => true),
	         "description" => __("Marker 2 description text.", "north")
	      ),
	      array(
	         "type" => "textfield",
	         "class" => "hidden-label",
	         "heading" => __("Marker 2 Custom Location", "north"),
	         "param_name" => "marker2_location",
	         "value" => '41.858774,-87.685328',
	         "dependency" => Array('element' => "marker2_title", 'not_empty' => true),
	         "description" => __("Marker 2 location in latitude,longitude format.", "north")
	      ) 	         
	      
	   )
	));
		
	vc_map( array(
	  "name" => __("Button", "north"),
	  "base" => "button",
	  "class" => "no-padding",
	  "icon" => "icon-wpb-ui-button",
	  "category" => 'Content',
	  "description" => "Simple button",
	  "params" => array(
	    array(
	      "type" => "textfield",
	      "heading" => __("Text on the button", "north"),
	      "holder" => "button",
	      "class" => "button",
	      "param_name" => "label",
	      "value" => __("Text on the button", "north"),
	      "description" => __("Text on the button.", "north")
	    ),
	    array(
	      "type" => "textfield",
	      "heading" => __("URL (Link)", "north"),
	      "param_name" => "url",
	      "description" => __("Button link.", "north")
	    ),
	    array(
	      "type" => "dropdown",
	      "heading" => __("Target", "north"),
	      "param_name" => "target",
	      "value" => $target_arr,
	      "dependency" => Array('element' => "url", 'not_empty' => true)
	    ),
	    array(
	      "type" => "dropdown",
	      "heading" => __("Button color", "north"),
	      "param_name" => "color",
	      "class" => "hidden-label",
	      "value" => $colors_arr,
	      "description" => __("Select button color.", "north"),
	      //"param_holder_class" => 'vc-colored-dropdown'
	    ),
		    array(
		      "type" => "colorpicker",
		      "heading" => __("Button custom color", "north"),
		      "param_name" => "customcolor",
		      "class" => "hidden-label",
		      "description" => __("Select custom color for your button.", "north"),
		      "dependency" => Array('element' => "color", 'value' => array('custom'))
		    ),
		    
		array(
		  "type" => "dropdown",
		  "heading" => __("Size", "north"),
		  "param_name" => "size",
		  "class" => "hidden-label",
		  "value" => array(__("Regular size", "north") => "regular", __("Large", "north") => "large", __("Small", "north") => "small"),
		  "description" => __("Button size.", "north")
		),
		array(
		  "type" => "dropdown",
		  "heading" => __("Button Align", "north"),
		  "param_name" => "align",
		  "value" =>  array(__("Left", "north") => "", __("Centered", "north") => "center"),
		  "description" => __("Button align.", "north")
		),
	    array("type" => "init_icons"),
	    array(
	      "type" => "textfield",
	      "heading" => __("Margin Top", "north"),
	      "param_name" => "margin_top",
	      "description" => __("Change button's top margin value. Default value: 0px", "north")
	    ),
	    array(
	      "type" => "textfield",
	      "heading" => __("Margin Bottom", "north"),
	      "param_name" => "margin_bottom",
	      "description" => __("Change button's bottom margin value. Default value: 20px", "north")
	    )
	  )
	));
	
	// Special Heading
	
	wpb_map( array(
	   "name" => __("Special Heading", "north"),
	   "base" => "special_heading",
	   "class" => "no-icon",
	   "icon" => "fa-header",
	   "description" => "Centered heading text",
	   "category" => 'Content',
	   "params" => array(     
			array(
			    "type" => "textfield",	         
			    "heading" => __("Title", 'north'),
			    "param_name" => "title",
			    "holder" => "h5",
			    "description" => __("Main heading text.", 'north'),
			    "value" => "This is a Special Heading"
			),
			array(
			    "type" => "textfield",	       
			    "heading" => __("Subtitle", 'north'),
			    "param_name" => "subtitle",
			    "holder" => "span",
			    "description" => __("Smaller text visible below the Main one.", 'north'),
			    "value" => "Isn't it awesome?"
			),      			    
			array(
			  "type" => "dropdown",
			  "heading" => __("Animation", "north"),
			  "param_name" => "animated",
			  "class" => "hidden-label",
			  "value" => array(__("Yes", "north") => "yes", __("No", "north") => "no"),
			  "description" => __("Enable the fade-in animation of the heading elements on site scroll.", "north")
			),
			array(
			   "type" => "dropdown",
			   "class" => "hidden-label",
			   "heading" => __("Title Font", "north"),
			   "param_name" => "font",
			   "value" => array(
			   	'Primary' => '',
			   	'Secondary' => 'secondary'
			   	)
			),
			array(
			  "type" => "textfield",
			  "heading" => __("Margin Bottom", "north"),
			  "param_name" => "margin_bottom",
			  "class" => "hidden-label",
			  "value" => '30',
			  "description" => __("Bottom margin of the heading section, given in pixels. Default: 30", "north")
			)
			
	   )
	));	
	
	// Callout Box
	
	wpb_map( array(
	   "name" => __("Callout Box", "north"),
	   "base" => "callout_box",
	   "class" => "font-awesome",
	   "icon" => "fa-align-left",
	   "category" => 'Content',
	   "description" => "Nice blockquote",
	   "params" => array(     
			array(
			    "type" => "textfield",	         
			    "heading" => __("Title", 'north'),
			    "param_name" => "title",
			    "holder" => "h3",
			    "description" => __("Main heading text.", 'north'),
			    "value" => "Callout"
			),
			array(
			    "type" => "textfield",	       
			    "heading" => __("Subtitle", 'north'),
			    "param_name" => "subtitle",
			    "holder" => "span",
			    "description" => __("Smaller text visible below the Main one.", 'north'),
			    "value" => "Callout Box subtitle"
			)
	   )
	));

	//if(get_post_type($post_id) == 'portfolio') {	
		wpb_map( array(
		   "name" => __("Portfolio Post Details", "north"),
		   "base" => "portfolio_details",
		   "class" => "font-awesome",
		   "icon" => "fa-suitcase",
		   "description" => "Single portfolio post details",
		   "category" => 'Content',
		   "params" => array(				
				array(
				   "type" => "dropdown",
				   "class" => "hidden-label",
				   "heading" => __("Style", "north"),
				   "param_name" => "style",
				   "value" => array(
				   	'Style 1 (split in two columns)' => 'style2',
				   	'Style 2' => 'style1'
				   	)
				),
				array(
				    "type" => "textfield",	         
				    "heading" => __("Title", 'north'),
				    "param_name" => "title",
				    "holder" => "h2",
				    "description" => __("Main heading text.", 'north'),
				    "value" => "Project Details"
				),
				array(
				    "type" => "textarea_html",	       
				    "heading" => __("Text Content", 'north'),
				    "param_name" => "content",
				    "holder" => "div",
				    "description" => __("Smaller text visible below the Main one.", 'north'),
				    "value" => "Contrary to popular belief, Lorem Ipsum is not simply random text. It has rootsin piece of classical Latin literature from old. Richard McClintock, a Latin profes sor at Hampden-Sydney College in Virginia, looked up."
				),
				array(
				    "type" => "textfield",	         
				    "heading" => __("Secondary Title", 'north'),
				    "param_name" => "title2",
				    "holder" => "h2",
				    "description" => __("Secondary Title", 'north'),
				    "value" => "Project Description",
				    "dependency" => Array('element' => "style", 'value' => array('style2'))
				),			
				
				array(
				    "type" => "textfield",	         
				    "heading" => __("Client Name", 'north'),
				    "param_name" => "client",
				    "holder"	=> "p",
				    "description" => __("Your project client name.", 'north'),
				    "value" => "Gold Eye Themes"
				),	
				array(
				  "type" => "exploded_textarea",
				  "heading" => __("Skills", "north"),
				  "param_name" => "skills",
				  "holder" => "p",
				  "value"	=> 'Design,Photography,HTML,jQuery',
				  "description" => __('Enter the projects skills here. Divide each feature with linebreaks (Enter).', 'north')
				),
				array(
				    "type" => "textfield",	         
				    "heading" => __("Client Website", 'north'),
				    "param_name" => "client_website",
				    "description" => __("Your project client's website. Leave blank to hide.", 'north'),
				    "value" => ""
				),
				array(
				    "type" => "textfield",	         
				    "heading" => __("Button1 Label", 'north'),
				    "param_name" => "button1_label",
				    "description" => __("Primary button label.", 'north'),
				    "value" => "Live Preview"
				),
				array(
				    "type" => "textfield",	         
				    "heading" => __("Button1 URL", 'north'),
				    "param_name" => "button1_url",
				    "description" => __("Primary button URL.", 'north'),
				    "value" => "http://",
				    'dependency' => Array('element' => "button1_label", 'not_empty' => true)
				),
				array(
				    "type" => "textfield",	         
				    "heading" => __("Button2 Label", 'north'),
				    "param_name" => "button2_label",
				    "description" => __("Primary button label.", 'north'),
				    "value" => ""
				),
				array(
				    "type" => "textfield",	         
				    "heading" => __("Button2 URL", 'north'),
				    "param_name" => "button2_url",
				    "description" => __("Secondary button URL.", 'north'),
				    "value" => "http://",
				    'dependency' => Array('element' => "button1_label", 'not_empty' => true)
				)				 		   
				
			)
		));
	//}
	
	// Fancy Block
	
	wpb_map( array(
	   "name" => __("Fancy Text Block", "north"),
	   "base" => "fancy_text_block",
	   "class" => "font-awesome",
	   "icon" => "fa-list-alt",
	   "category" => 'Content',
	   "description" => "Eye-catching block of text",
	   "params" => array( 
	   		array(
	   		  "type" => "dropdown",
	   		  "heading" => __("Style", "north"),
	   		  "param_name" => "style",
	   		  "class" => "hidden-label",
	   		  "value" => array("Style 1" => "style1", "Style 2 (Transparent Background)" => "style2","Style 3 (Centered)" => "style3"),
	   		  "description" => __("Enable the fade-in animation of the heading elements on site scroll.", "north")
	   		),    
			array(
			    "type" => "textfield",	         
			    "heading" => __("Title", 'north'),
			    "param_name" => "title",
			    "holder" => "h2",
			    "description" => __("Main heading text.", 'north'),
			    "value" => "Fancy Title"
			),
			array(
			    "type" => "textfield",	       
			    "heading" => __("Subtitle", 'north'),
			    "param_name" => "subtitle",
			    "holder" => "h4",
			    "description" => __("Smaller text visible below the Main one.", 'north'),
			    "value" => "Fancy Block subtitle"
			),
			array(
			    "type" => "textfield",	       
			    "heading" => __("Alt Title", 'north'),
			    "param_name" => "alttitle",
			    "description" => __("Medium text visible above the Main one.", 'north'),
			    "value" => "#01"
			),
			array(
			    "type" => "textarea",	       
			    "heading" => __("Text Content", 'north'),
			    "param_name" => "text",
			    "description" => __("Fancy Text Block content.", 'north'),
			    "value" => "Text content"
			),
			array(
			    "type" => "textfield",	       
			    "heading" => __("Button Label", 'north'),
			    "param_name" => "button_label",
			    "description" => __("Button Label.", 'north'),
			    "value" => "Continue"
			),
			array(
			    "type" => "textfield",	       
			    "heading" => __("Button URL", 'north'),
			    "param_name" => "button_url",
			    "description" => __("Button URL.", 'north'),
			    "value" => "#"
			),
			array(
			    "type" => "textfield",	       
			    "heading" => __("Plus Icon URL", 'north'),
			    "param_name" => "plus_url",
			    "description" => __("URL for the big, PLUS icon. Leave blank to hide the icon.", 'north'),
			    "value" => ""
			)
	   )
	));
		
	// Social Icons
	
	$social_icons_param = array(
	  "type" => "dropdown",
	  "heading" => __("Style", "north"),
	  "param_name" => "style",
	  "class" => "hidden-label",
	  "value" => array("Square" => "square", "Round" => "round"),
	  "description" => __("Social icons style.", "north")
	);
	
	$social_icons_params_arr[] = $social_icons_param;
	
	$social_icons = array('mail' => "E-Mail",'facebook','twitter','instagram','mail' => "E-Mail",'tumblr','linkedin','youtube' => 'YouTube','vimeo','skype','google_plus' => 'Google Plus','flickr','dropbox','pinterest','dribbble','rss','snapchat','soundcloud');
	
	$icon_key = '';
	
	foreach($social_icons as $social_icon_key => $social_icon_name) {
	
		$icon_key = $social_icon_key;
		
		if(is_numeric($social_icon_key)) {
			$icon_key = $social_icon_name;
		}
		
		//echo 'NAME: '.$social_icon_name.' KEY: '.$social_icon_key .'|  ';
		
		$social_icons_params_arr[] = array(
		    "type" => "textfield",	         
		    "heading" => ucfirst($social_icon_name),
		    "param_name" => $icon_key,
		    "holder" => "h5",
		    "description" => ucfirst($social_icon_name).' social site URL.'
		);
	}
	
	wpb_map( array(
	   "name" => __("Social Icons", "north"),
	   "base" => "social_icons",
	   "class" => "font-awesome",
	   "icon" => "fa-twitter",
	   "category" => 'Content',
	   "description" => "List of social icons",
	   "params" => $social_icons_params_arr
	));
	
	// Simple Contact Form
	
	
	include_once(ABSPATH . 'wp-admin/includes/plugin.php'); // Require plugin.php to use is_plugin_active() below

	if (is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
	
	vc_remove_element('contact-form-7');
	  global $wpdb;
	  $cf7 = $wpdb->get_results(
	    "
	    SELECT ID, post_title
	    FROM $wpdb->posts
	    WHERE post_type = 'wpcf7_contact_form'
	    "
	  );
	  $contact_forms = array();
	  if ($cf7) {
	    foreach ( $cf7 as $cform ) {
	      $contact_forms[$cform->post_title] = $cform->ID;
	    }
	  } else {
	    $contact_forms["No contact forms found"] = 0;
	  }	  
	  vc_map( array(
	    "base" => "vntd_contact_form",
	    "name" => __("Contact Form 7", "north"),
	    "icon" => "icon-wpb-contactform7",
	    "category" => __('Content', 'north'),
	    "description" => __('Place Contact Form7', 'north'),
	    "params" => array(
	      array(
	        "type" => "dropdown",
	        "heading" => __("Select contact form", "north"),
	        "param_name" => "id",
	        "admin_label" => true,
	        "value" => $contact_forms,
	        "description" => __("Choose previously created Contact Form 7 form from the drop down list.", "north")
	      ),
	      array(
	        "type" => "dropdown",
	        "heading" => __("Animated", "north"),
	        "param_name" => "animated",
	        "value" => array("No" => "no", "Yes" => "no"),
	        "description" => __("Enable fade in animation on scroll", "north")
	      )
	    )
	  ) );
	} // if contact form7 plugin active
	

	
	// Contact Block
	
	wpb_map( array(
	   "name" => __("Contact Block", "north"),
	   "base" => "contact_block",
	   "class" => "font-awesome",
	   "icon" => "fa-envelope-square",
	   "description" => "Show off your contact data",
	   "category" => 'Content',
	   "params" => array(     
			array(
			    "type" => "textfield",	         
			    "heading" => __("Phone Number", 'north'),
			    "param_name" => "phone",
			    "holder" => "div",
			    "description" => __("Your phone number.", 'north'),
			    "value" => "0123 456 789"
			),
			array(
			    "type" => "textfield",	         
			    "heading" => __("Phone Number", 'north'),
			    "param_name" => "phone2",
			    "holder" => "div",
			    "description" => __("Secondary phone number.", 'north'),
			    "value" => ""
			),
			array(
			    "type" => "textfield",	       
			    "heading" => __("Address", 'north'),
			    "param_name" => "address",
			    "holder" => "div",
			    "description" => __("Your address.", 'north'),
			    "value" => "North, Street Name 6901, Melbourne Australia"
			),      			    
			array(
			    "type" => "textfield",	       
			    "heading" => __("E-Mail", 'north'),
			    "param_name" => "email",
			    "holder" => "div",
			    "description" => __("Your e-mail address.", 'north'),
			    "value" => "support@goldeyethemes.com"
			),  
			array(
			    "type" => "textfield",	         
			    "heading" => __("Facebook", 'north'),
			    "param_name" => "facebook",
			    "description" => __("Social site URL (optional).", 'north'),
			    "value" => ""
			), 
			array(
			    "type" => "textfield",	         
			    "heading" => __("Twitter", 'north'),
			    "param_name" => "twitter",
			    "description" => __("Social site URL (optional).", 'north'),
			), 
			array(
			    "type" => "textfield",	         
			    "heading" => __("Google+", 'north'),
			    "param_name" => "googleplus",
			    "description" => __("Social site URL (optional).", 'north'),
			), 
			array(
			    "type" => "textfield",	         
			    "heading" => __("Tumblr", 'north'),
			    "param_name" => "tumblr",
			    "description" => __("Social site URL (optional).", 'north'),
			), 
			array(
			    "type" => "textfield",	         
			    "heading" => __("Pinterest", 'north'),
			    "param_name" => "pinterest",
			    "description" => __("Social site URL (optional).", 'north'),
			), 
			array(
			    "type" => "textfield",	         
			    "heading" => __("LinkedIn", 'north'),
			    "param_name" => "linkedin",
			    "description" => __("Social site URL (optional).", 'north'),
			), 
			array(
			    "type" => "textfield",	         
			    "heading" => __("Dribbble", 'north'),
			    "param_name" => "dribbble",
			    "description" => __("Social site URL (optional).", 'north'),
			), 
			array(
			    "type" => "textfield",	         
			    "heading" => __("Instagram", 'north'),
			    "param_name" => "instagram",
			    "description" => __("Social site URL (optional).", 'north'),
			), 
			array(
			    "type" => "textfield",	         
			    "heading" => __("YouTube", 'north'),
			    "param_name" => "youtube",
			    "description" => __("Social site URL (optional).", 'north'),
			),
			array(
			    "type" => "textfield",	         
			    "heading" => __("Soundcloud", 'north'),
			    "param_name" => "soundcloud",
			    "description" => __("Social site URL (optional).", 'north'),
			)
			
	   )
	));
	
	// Call to Action
	
	wpb_map( array(
	   "name" => __("Call to Action", "north"),
	   "base" => "cta",
	   "class" => "",
	   "icon" => "icon-wpb-call-to-action",
	   "controls" => "edit_popup_delete",
	   "category" => 'Content',
	   "description" => "Heading text with buttons",
	   "params" => array(   	  
	      array(
	          "type" => "textarea",
	          "heading" => __("Heading", 'north'),
	          "param_name" => "heading",
	          "value" => "Example Heading",
	          "description" => __("Enter your Call to Action Heading", 'north'),
	          "admin_label" => true
	      ),
	      array(
	          "type" => "textarea",
	          "heading" => __("Subtitle", 'north'),
	          "param_name" => "subtitle",
	          "value" => "Feel free to change the subtitle!",
	          "description" => __("Subtitle displayed under the main Heading.", 'north'),
	          "admin_label" => true
	      ),
	      array(
	          "type" => "textfield",	          
	          "heading" => __("Button 1 Label", 'north'),
	          "param_name" => "button1_title",
	          "description" => __("Enter the title for the first button", 'north'),
	          "value" => "Click me!",
	          "admin_label" => true
	      ),
	      array(
	          "type" => "textfield",	          
	          "heading" => __("Button 1 Sublabel (optional)", 'north'),
	          "param_name" => "button1_subtitle",
	          "description" => __("Optional button secondary label (available for Centered style).", 'north'),
	          "value" => "",
	          "dependency" => Array( 'element' => "button1_title", 'not_empty' => true )
	      ),
	      array(
	          "type" => "textfield",
	          "heading" => __("Button 1 Link", 'north'),
	          "param_name" => "button1_url",
	          "description" => __("Enter the URL the first button will link to", 'north'),
	          "value" => "http://",
	          "dependency" => Array( 'element' => "button1_title", 'not_empty' => true )
	      ), 
	      array(
	          "type" => "textfield",	          
	          "heading" => __("Button 2 Label", 'north'),
	          "param_name" => "button2_title",
	          "description" => __("Enter the title for the second button", 'north'),
	          "value" => "",
	          "admin_label" => true
	      ),
	      array(
	          "type" => "textfield",	          
	          "heading" => __("Button 2 Sublabel (optional)", 'north'),
	          "param_name" => "button2_subtitle",
	          "description" => __("Optional button secondary label (available for Centered style).", 'north'),
	          "value" => "",
	          "dependency" => Array( 'element' => "button2_title", 'not_empty' => true )
	      ),
	      array(
	          "type" => "textfield",
	          "heading" => __("Button 2 Link", 'north'),
	          "param_name" => "button2_url",
	          "description" => __("Enter the URL the second button will link to", 'north'),
	          "value" => "http://",
	          "dependency" => Array( 'element' => "button2_title", 'not_empty' => true )
	      ),
	      array(
	        "type" => "dropdown",
	        "heading" => __("Buttons Link Target", "north"),
	        "param_name" => "buttons_target",
	        "value" => $target_arr
	      ),
	      array(
	      	"type" => "dropdown",
	      	"class" => "hidden-label",
	      	"value" => array(
	      		"Default (Floated)" => 'default',
	      		"Centered" => 'centered',
	      	),
	      	"heading" => __("Style", "north"),
	      	"description" => __('Style of your Call to Action area.', "north"),
	      	"param_name" => "style"
	      	),       
	      array(
	         "type" => "colorpicker",
	         "heading" => __("Heading color", "north"),
	         "param_name" => "heading_color",
	         "value" => '',
	         "description" => __("Select the heading color. Leave blank for default.", "north"),
	      ),
	      array(
	         "type" => "colorpicker",
	         "heading" => __("Text color", "north"),
	         "param_name" => "text_color",
	         "value" => '',
	         "description" => __("Select text color. Leave blank for default.", "north"),
	      ),
	      array(
	      	"type" => "dropdown",
	      	"class" => "hidden-label",
	      	"value" => array(
	      		"Dark" => 'dark',
	      		"White" => 'white',
	      	),
	      	"heading" => __("Button Color", "north"),
	      	"description" => __('Color of your Call to Action area buttons.', "north"),
	      	"param_name" => "button_color"
	      	),     
	      array(
	          "type" => "textfield",
	          "heading" => __("Margin bottom", 'north'),
	          "param_name" => "margin_bottom",
	          "value" => "0",
	          "dependency" => Array('element' => "fullscreen", 'value' => array("yes"))
	      )    
	   )
	));
	
	// Centered Heading
	
	wpb_map( array(
	   "name" => __("Pricing Box", "north"),
	   "base" => "pricing_box",
	   "class" => "font-awesome",
	   "icon" => "fa-usd",
	   "category" => 'Content',
	   "description" => "Product box with prices",
	   "params" => array(     
			array(
			    "type" => "textfield",	         
			    "heading" => __("Box Title", 'north'),
			    "param_name" => "title",
			    "description" => __("Your Pricing Box title", 'north'),
			    "value" => "",
			    "admin_label" => true
			),
			array(
			    "type" => "textfield",	       
			    "heading" => __("Price", 'north'),
			    "param_name" => "price",
			    "description" => __("Pricing Box price", 'north'),
			    "value" => "$99",
			    "admin_label" => true
			),  
			array(
			    "type" => "textfield",	       
			    "heading" => __("Period", 'north'),
			    "param_name" => "period",
			    "description" => __("Pricing Box period", 'north'),
			    "value" => "per year"
			), 
			array(
			  "type" => "exploded_textarea",
			  "heading" => __("Features", "north"),
			  "param_name" => "features",
			  "description" => __('Enter features here. Divide each feature with linebreaks (Enter).', 'north')
			),  
			array(
				"type" => "dropdown",
				"class" => "hidden-label",
				"value" => array(
					"Not Featured" => 'no',
					"Featured" => 'yes',
				),
				"heading" => __("Featured?", "north"),
				"description" => __('Make the box stand out from the crew.', "north"),
				"param_name" => "featured"
				),
			array(
			    "type" => "textfield",	       
			    "heading" => __("Button Label", 'north'),
			    "param_name" => "button_label",
			    "description" => __("Text visible on the box button", 'north'),
			    "value" => "Buy Now"
			),  
			array(
			    "type" => "textfield",	       
			    "heading" => __("Button URL", 'north'),
			    "param_name" => "button_url",
			    "description" => __("Button URL, start with http://", 'north'),
			    "value" => "",
			    'dependency' => Array('element' => "button_label", 'not_empty' => true)			
			),
			array(
			  "type" => "dropdown",
			  "heading" => __("Animated", "north"),
			  "param_name" => "animated",
			  "value" => array("Yes" => "yes","No" => "no"),
			  "description" => "Enable the element fade in animation on scroll"
			),
				array(
				  "type" => "textfield",
				  "heading" => __("Animation Delay", "north"),
				  "param_name" => "animation_delay",
				  "value" => '100',
				  "description" => "Fade in animation delay. Can be used to create a nice delay effect if multiple elements of same type.",
				  "dependency" => Array('element' => "animated", 'value' => 'yes')
				),
	   )
	));
	
	// Centered Heading
	
	wpb_map( array(
	   "name" => __("Counter", "north"),
	   "base" => "counter",
	   "class" => "font-awesome",
	   "icon" => "fa-clock-o",
	   "category" => 'Content',
	   "description" => "Countdown numbers",
	   "params" => array(     
			array(
			    "type" => "textfield",	         
			    "heading" => __("Counter Title", 'north'),
			    "param_name" => "title",
			    "description" => __("Your Counter title.", 'north'),
			    "value" => "Days",
			    "admin_label" => true
			),
			array(
			    "type" => "textfield",	       
			    "heading" => __("Number value", 'north'),
			    "param_name" => "number",
			    "description" => __("Value of the counter number.", 'north'),
			    "value" => "100",
			    "admin_label" => true
			)  
	   )
	));
	
	
	// Fullscreen slider
	
	wpb_map( array(
	   "name" => __("Fullscreen Text Slider", "north"),
	   "base" => "vntd_fullscreen_slider",
	   "class" => "font-awesome",
	   "icon" => "fa-arrows-alt",
	   "category" => 'Media',
	   "params" => array(     
			array(
				'type' => 'attach_images',
				'heading' => __( 'Background Images', 'north' ),
				'param_name' => 'images',
				'value' => '',
				'description' => __( 'Select images from media library. Leave blank to use row\'s background image/video.', 'north' )
			),
			array(
			    "type" => "textarea",	       
			    "heading" => __("Static Text", 'north'),
			    "param_name" => "text_static",
			    "description" => __("Static text displayed on the slider.", 'north'),
			    "value" => "Hello there",
			    "admin_label" => true
			),
			array(
				'type' => 'exploded_textarea',
				'heading' => __( 'Dynamic Text Lines', 'north' ),
				'param_name' => 'text_dynamic',
				"value"	=> 'Welcome to North,We are Designers,We love to Design',
				'description' => __( 'Dynamic Text Lines are displayed one after another as slides. Separate each line with linebreaks (Enter). To have a comma please use a double semicolon like: We have over 2;;435 clients.', 'north' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Slider Style', 'north' ),
				'param_name' => 'style',
				'value' => array(
					__( 'Style 1', 'north' ) => 'style1',
					__( 'Style 2 (with services slider)', 'north' ) => 'style2'
				),
				'description' => __( 'Choose a style for the slider.', 'north' )
			),
			array(
			    "type" => "dropdown",	       
			    "heading" => __("Display icons?", 'north'),
			    "param_name" => "service_icons",
			    "description" => __("Enable or disable icons to be displayed next to each service, defined in the service post.", 'north'),
			    'value' => array(
			    	__( 'No', 'north' ) => 'no',
			    	__( 'Yes', 'north' ) => 'yes'
			    ),
			    'dependency' => Array('element' => "style", 'value' => 'style2')			
			),
			array(
			    "type" => "textfield",	       
			    "heading" => __("Services post number.", 'north'),
			    "param_name" => "posts_nr",
			    "description" => __("Number of services type of posts to be displayed in the slider.", 'north'),
			    "value" => "6",
			    'dependency' => Array('element' => "style", 'value' => 'style2')			
			),	
			array(
				'type' => 'dropdown',
				'heading' => __( 'Background Overlay', 'north' ),
				'param_name' => 'bg_overlay',
				'value' => array(
					'Dark 1' => 'dark1',
					'Dark 2' => 'dark2',
					'Dark pattern' => 'dots',
					'White pattern' => 'dots_white',
					'None'	=> 'none'
				),
				'description' => __( 'Choose the slider overlay background type.', 'north' )
			),		
			array(
			    "type" => "textfield",	       
			    "heading" => __("Button 1 Label", 'north'),
			    "param_name" => "button1_label",
			    "description" => __("First button label.", 'north'),
			    "value" => "Read More"
			),
			array(
			    "type" => "textfield",	       
			    "heading" => __("Button 1 URL", 'north'),
			    "param_name" => "button1_url",
			    "description" => __("First button URL.", 'north'),
			    "value" => "#",
			    'dependency' => Array('element' => "button1_label", 'not_empty' => true)			
			),
			array(
			    "type" => "textfield",	       
			    "heading" => __("Button 2 Label", 'north'),
			    "param_name" => "button2_label",
			    "description" => __("Second button label.", 'north'),
			    "value" => ""
			),
			array(
			    "type" => "textfield",	       
			    "heading" => __("Button 2 URL", 'north'),
			    "param_name" => "button2_url",
			    "description" => __("Second button URL.", 'north'),
			    "value" => "",
			    'dependency' => Array('element' => "button2_label", 'not_empty' => true)
			),
			array(
			  "type" => "dropdown",
			  "heading" => __("Animated", "north"),
			  "param_name" => "animated",
			  "value" => array("No" => "no","Yes" => "yes"),
			  "description" => "Enable the element fade in animation on scroll"
			),
			array(
			    "type" => "dropdown",       
			    "heading" => __("Buttons Color", 'north'),
			    "param_name" => "buttons_color",
			    "description" => __("Color of your slider buttons.", 'north'),
			    "value" => array("Dark" => "dark","Light" => "light")
			),
			array(
			    "type" => "textfield",	       
			    "heading" => __("Plus Icon URL", 'north'),
			    "param_name" => "plus_url",
			    "holder" => "span",
			    "description" => __("URL for the big, PLUS icon. Leave blank to hide the icon.", 'north'),
			    "value" => ""
			)
	   )
	));
	
	
	vc_map( array(
		   "name" => esc_html__("North Tabs", 'north'),
		   "base" => "north_tabs",
		   "class" => "font-awesome",
		   "icon" => "fa-picture-o",
		   "description" => "Fancy North Theme Tabs.",
		   "category" => 'Content',
		   "params" => array(   
		   		array(
		   			'type' => 'param_group',
		   			'heading' => __( 'Tabs', 'north' ),
		   			'param_name' => 'tabs',
		   			'description' => __( 'Add tabs.', 'north' ),
		   			'value' => urlencode( json_encode( array(
		   				array(
		   					'title' => 'Movie',
		   					'heading' => 'Movie',
		   					'text'	=> 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Rich McClintock not simply. There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.'
		   				),
		   				array(
	   						'title' => 'Landing',
	   						'heading' => 'Landing',
	   						'text'	=> 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don’t look even snormally believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn’t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.'
	   					),
	   					array(
   							'title' => 'Design',
   							'heading' => 'Design',
   							'text'	=> 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ‘Content here, content here’, making it look like readable English.'
   						),
   						array(
							'title' => 'Art',
							'heading' => 'Art',
							'text'	=> 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ‘Content here, content here’, making it look like readable English.'
						),
		   			) ) ),
		   			'params' => array(
		   				array(
	   						'type' => 'textfield',
	   						'heading' => __( 'Title', 'north' ),
	   						'param_name' => 'title',
	   						'description' => __( 'Tab title, displayed in the diamond box.', 'north' ),
	   						'admin_label' => true,
	   					),
		   				array(
		   					'type' => 'textfield',
		   					'heading' => __( 'Text Heading', 'north' ),
		   					'param_name' => 'heading',
		   					'description' => __( 'Text content heading.', 'north' ),
		   					'admin_label' => true,
		   				),
		   				array(
		   					'type' => 'textarea',
		   					'heading' => __( 'Text Content', 'north' ),
		   					'param_name' => 'text',
		   					'description' => __( 'Text content.', 'north' ),
		   				),
		   			),
		   		), 
		   	)
	));

}
  

?>