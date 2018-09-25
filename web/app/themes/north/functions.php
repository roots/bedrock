<?php

//
// North Theme Functions
//
// Author: Veented
// URL: http://themeforest.net/user/Veented/
// Design: GoldEyes Themes
//
//

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Load Framework
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-


require_once('framework/plugins/plugins-config.php'); 			// Plugins Manager
require_once('framework/functions/blog-functions.php'); 		// Blog related functions
require_once('framework/functions/page-functions.php'); 		// Page functions & metaboxes
require_once('framework/functions/header-functions.php'); 		// Header related functions
require_once('framework/functions/general-functions.php'); 		// General functions
require_once('framework/portfolio/portfolio-functions.php'); 	// Portfolio Post Type
require_once('framework/team/team-functions.php'); 				// Team Member Post Type
require_once('framework/testimonials/testimonials-functions.php'); // Testimonial Post Type
require_once('framework/services/services-functions.php'); 		// Services Post Type
require_once('framework/shortcodes/shortcodes.php'); 			// Shortcodes
require_once('framework/widgets/widgets.php'); 				// Widgets

if (!function_exists( 'optionsframework_admin_init')) { // Theme Options Panel
	require_once ('framework/theme-options/index.php');
} 

if(class_exists('Vc_Manager')) {	

	function vntd_extend_composer() {
		require_once locate_template('/wpbakery/vc-extend.php');
	}

	add_action('init', 'vntd_extend_composer', 20);	
}


// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Localization
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-


function vntd_theme_setup() {
	load_theme_textdomain( 'north', get_template_directory() . '/lang' );
}
add_action( 'after_setup_theme', 'vntd_theme_setup' );


// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Theme Scripts & Styles
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-


function vntd_custom() {
	if (!is_admin()) 
	{
	
		// Load jQuery scripts
			
		wp_register_script('custom', get_template_directory_uri() . '/js/jquery.custom.js', array('jquery'));	
		wp_register_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'));		
		wp_register_script('SmoothScroll', get_template_directory_uri() . '/js/SmoothScroll.js', array('jquery'));		
		wp_register_script('fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array('jquery'));		
		wp_register_script('vntdIsotope', get_template_directory_uri() . '/js/jquery.isotope.js', array('jquery'));	
		wp_register_script('prettyPhoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array('jquery'));	
		wp_register_script('flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array('jquery'));	
		wp_register_script('owl-carousel', get_template_directory_uri() . '/js/owl.carousel.js', array('jquery'));	
		wp_register_script('appear', get_template_directory_uri() . '/js/jquery.appear.js', array('jquery'));	
		wp_register_script('YTPlayer', get_template_directory_uri() . '/js/jquery.mb.YTPlayer.js', array('jquery'));	
		wp_register_script('sticky', get_template_directory_uri() . '/js/jquery.sticky.js', array('jquery'));	
		wp_register_script('easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array('jquery'));	
		wp_register_script('parallax', get_template_directory_uri() . '/js/jquery.parallax-1.1.3.js', array('jquery'));	
		wp_register_script('waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array('jquery'));	
		wp_register_script('superslides', get_template_directory_uri() . '/js/jquery.superslides.js', array('jquery'));		
		wp_register_script('google-map', get_template_directory_uri() . '/js/google-map.js', array('jquery'));
		wp_register_script('magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array('jquery'));	
		wp_register_script('rainyday', get_template_directory_uri() . '/js/rainyday.min.js', array('jquery'));	
		wp_register_script('vimeoBg', get_template_directory_uri() . '/js/fullscreen_background.js', array('jquery'));
		wp_register_script('jQueryUI', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js', array('jquery'));
		wp_register_script('portfolioExpand', get_template_directory_uri() . '/js/jquery.colio.js', array('jquery'));
								
		wp_enqueue_script('bootstrap', '', '', '', true);
		wp_enqueue_script('SmoothScroll', '', '', '', true);
		wp_enqueue_script('fitvids', '', '', '', true);
		wp_enqueue_script('waypoints', '', '', '', true);		
		wp_enqueue_script('flexslider', '', '', '', true);	
		wp_enqueue_script('vntdIsotope', '', '', '', true);
		wp_enqueue_script('sticky', '', '', '', true);
		wp_enqueue_script('appear', '', '', '', true);
		wp_enqueue_script('easing', '', '', '', true);
		wp_enqueue_script('parallax', '', '', '', true);	
		wp_enqueue_script('custom', '', '', '', true);
		wp_enqueue_script('superslides', '', '', '', true);
		wp_enqueue_script('owl-carousel', '', '', '', true);		
			
		
		// Load stylesheets		
		
		wp_dequeue_style('font-awesome'); // Dequeue plugin version	
		wp_enqueue_style('font-awesomes', get_template_directory_uri() . '/css/font-awesome/css/font-awesome.min.css', false, '4.6.3');		

		wp_register_style('style-dynamic', get_template_directory_uri() . '/css/style-dynamic.php');				
		wp_register_style('theme-styles', get_template_directory_uri() . '/style.css',array('bootstrap'));	
		wp_register_style('elements', get_template_directory_uri() . '/css/elements.css');	
		
		wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
		wp_register_style('animate', get_template_directory_uri() . '/css/scripts/animate.min.css');
		wp_register_style('owl-carousel', get_template_directory_uri() . '/css/scripts/owl.carousel.css');
		wp_register_style('flexslider', get_template_directory_uri() . '/css/scripts/flexslider.css');
		wp_register_style('socials', get_template_directory_uri() . '/css/socials.css');
		wp_register_style('YTPlayer', get_template_directory_uri() . '/css/scripts/YTPlayer.css');
		wp_register_style('magnific-popup', get_template_directory_uri() . '/css/scripts/magnific-popup.css');
		wp_register_style('prettyPhoto', get_template_directory_uri() . '/css/scripts/prettyPhoto.css');
		wp_register_style('north-responsive', get_template_directory_uri() . '/css/responsive.css');
		wp_register_style('vimeoBg', get_template_directory_uri() . '/css/scripts/fullscreen_background.css');
		wp_register_style('portfolioExpand', get_template_directory_uri() . '/css/scripts/colio.css');
		
		//wp_enqueue_style('bootstrap');	
		wp_enqueue_style('animate');
		wp_enqueue_style('elements');
		
		
		
		wp_enqueue_style('theme-styles'); // MAIN STYLESHEET
		wp_enqueue_style('socials');
		
		global $smof_data;
		if(array_key_exists('vntd_skin_overlay', $smof_data)) {
			if($smof_data['vntd_skin_overlay'] == 'night') {
				wp_enqueue_style('layout-tone', get_template_directory_uri() . '/css/skins/night.css');
			} else {
				wp_enqueue_style('layout-tone', get_template_directory_uri() . '/css/skins/dark.css');
			}		
		}
		wp_enqueue_style('style-dynamic');			
		if(array_key_exists('vntd_responsive', $smof_data)) {
			if($smof_data['vntd_responsive']) {
				wp_enqueue_style('north-responsive');	// Load responsive stylesheet
			}
		}
		
		// Google Maps
		
		$api_key = '';
		
		if(array_key_exists('vntd_google_map_api', $smof_data)) {
			if($smof_data['vntd_google_map_api'] != '') {
				$api_key = esc_attr( $smof_data['vntd_google_map_api'] );
			}
		}
		
		wp_register_script('google-map-sensor', 'http://maps.google.com/maps/api/js?sensor=false&key=' . $api_key , array('jquery'));	
		
	}
}
add_action('wp_enqueue_scripts', 'vntd_custom');


// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
// 		Custom Image Sizes & Post Formats
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-


if (function_exists('add_theme_support')) { 
	
	// Post Formats	
	
	add_theme_support('post-formats', array('gallery', 'video')); 	
	
	// Image Sizes		
	
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(100, 100, true);
		
	add_image_size('bg-image', 1670, 9999);
	add_image_size('fullwidth-landscape', 1170, 500, true);
	add_image_size('sidebar-landscape', 880, 380, true);
	add_image_size('sidebar-auto', 880, 9999);	
	add_image_size('portfolio-square', 450, 350, true);	
	add_image_size('portfolio-auto', 450, 9999);
	add_image_size('square', 270, 270, true);
}

function vntd_image_sizes($sizes) {
	
    $sizes['fullwidth-landscape'] = __( 'Fullwidth Landscape', 'north');
    $sizes['sidebar-landscape'] = __( 'Content Landscape', 'north'); 
    $sizes['sidebar-auto'] = __( 'Content Portrait', 'north');
    $sizes['portfolio-auto'] = __( 'Portfolio Portrait', 'north');
    $sizes['portfolio-square'] = __( 'Portfolio Square', 'north');
    return $sizes;
}
add_filter('image_size_names_choose', 'vntd_image_sizes');

function vntd_editor_css() {

}
add_action( 'init', 'vntd_editor_css' );

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
// 		Custom Menus
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-


add_action('init', 'vntd_register_custom_menu');
 
function vntd_register_custom_menu() {
	register_nav_menu('primary', __('Primary Navigation','north'));
}

class Vntd_Custom_Menu_Class extends Walker_Nav_Menu {
	function start_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"dropdown-menu\">\n";
	}
}

function mytheme_walk_nav_menu_items($output, $item, $depth, $args) {

	global $post;
	$front_id = get_option('page_on_front');
	
	if(is_object($post)) {
		$output = str_replace( 'http://frontpage_url/', get_permalink($front_id), $output);	
		$output = str_replace( get_permalink($post->ID).'#', '#', $output );
	}
    
    
    return $output;
}
add_filter( 'walker_nav_menu_start_el', 'mytheme_walk_nav_menu_items', 10, 4);

// Remove custom post type parent element

function remove_parent_classes($class)
{
	return ($class == 'current_page_item' || $class == 'current_page_parent' || $class == 'current_page_ancestor'  || $class == 'current-menu-item') ? FALSE : TRUE;
}

function add_class_to_wp_nav_menu($classes)
{
	//if(get_post_type() == 'portfolio') {
		$classes = array_filter($classes, "remove_parent_classes");
	//}	
	return $classes;
}
add_filter('nav_menu_css_class', 'add_class_to_wp_nav_menu');


// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
// 		Sidebars
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-


if (function_exists('register_sidebar')){
	register_sidebar(array(
        'name' => __('Default Sidebar','north'),
        'id' => 'default_sidebar',
        'before_widget' => '<div id="%1$s" class="bar %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));	
	register_sidebar(array(
        'name' => __('Archives/Search Sidebar','north'),
        'id' => 'archives',
        'before_widget' => '<div id="%1$s" class="bar %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));	
    
    register_sidebar(array(
        'name' => __('Footer Column 1','north'),
        'id' => 'footer1',
        'before_widget' => '<div class="bar footer-widget footer-widget-col-1">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => __('Footer Column 2','north'),
        'id' => 'footer2',
        'before_widget' => '<div class="bar footer-widget footer-widget-col-2">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => __('Footer Column 3','north'),
        'id' => 'footer3',
        'before_widget' => '<div class="bar footer-widget footer-widget-col-3">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => __('Footer Column 4','north'),
        'id' => 'footer4',
        'before_widget' => '<div class="bar footer-widget footer-widget-col-4">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    
    if (class_exists('Woocommerce')) { // If WooCommerce is enabled, activate related sidebars 
    
    	register_sidebar(array(
    	    'name' => 'WooCommerce Shop Page',
    	    'id'	=> 'woocommerce_shop',
    	    'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
    	    'after_widget' => '</div>',
    	    'before_title' => '<h4>',
    	    'after_title' => '</h4>',
    	));   	
    }

	global $smof_data;
	
	if(!$smof_data) $smof_data = array();
	
	if(array_key_exists('sidebar_generator',$smof_data)) {
		if($smof_data['sidebar_generator'] > 0) {
			foreach($smof_data['sidebar_generator'] as $sidebar)  
			{  
				register_sidebar( array(  
					'name' => $sidebar['title'],
					'id' => north_generate_slug( $sidebar['title'], 45 ),
					'before_widget' => '<div id="%1$s" class="bar %2$s">',  
					'after_widget' => '</div>',
					'before_title' => '<h3>',
					'after_title' => '</h3>',
				) );  
			}
		}
	}
	
}

function north_generate_slug($phrase, $maxLength = null)
{

	if($maxLength == null) $maxLength = 45;
	
    $result = strtolower($phrase);
 
    $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
    $result = trim(preg_replace("/[\s-]+/", " ", $result));
    $result = trim(substr($result, 0, $maxLength));
    $result = preg_replace("/\s/", "-", $result);
 
    return $result;
}

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Configure Tag Cloud
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

function vntd_tag_cloud($args = array()) {
   $args['smallest'] = 12;
   $args['largest'] = 12;
   $args['unit'] = 'px';
   return $args;
   
}
add_filter('widget_tag_cloud_args', 'vntd_tag_cloud', 90);
add_filter('widget_text', 'do_shortcode');


// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Print comment scripts
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-


function vntd_comments() {
	if(is_singular() || is_page())
	wp_enqueue_script( 'comment-reply', '', '', '', true);
}
add_action('wp_enqueue_scripts', 'vntd_comments');


// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Set content width
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-


function vntd_custom_content_width_embed_size($embed_size){
	global $content_width;
	$content_width = 1170;
}
add_filter('template_redirect', 'vntd_custom_content_width_embed_size');


// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		WooCommerce Support
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-


add_theme_support('woocommerce');
add_theme_support( 'title-tag' );

if (class_exists('Woocommerce')) {
	require_once('woocommerce/config.php'); 	
}


// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Dashboard scripts & styles
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-


function vntd_admin_scripts() {	
	wp_enqueue_media();
	wp_register_script('dashboard-jquery', get_template_directory_uri() . '/framework/theme-options/assets/js/jquery.dashboard.js');
	wp_register_script('media-uploader', get_template_directory_uri() . '/framework/theme-options/assets/js/media-uploader.js',array( 'jquery' ),true);
	
	wp_enqueue_script('dashboard-jquery', '', '', '', true);
	wp_enqueue_script('media-uploader', '', '', '', true);
	wp_enqueue_script('thickbox', '', '', '', true);	
	wp_localize_script('dashboard-jquery', 'WPURLS', array( 'themeurl' => get_template_directory_uri() ));	
}

function vntd_media_view_settings($settings, $post ) {
    if (!is_object($post)) return $settings;
    $shortcode = '[gallery ';
    $ids = get_post_meta($post->ID, 'gallery_images', TRUE);
    $ids = explode(",", $ids);
	
    if (is_array($ids))
        $shortcode .= 'ids = "' . implode(',',$ids) . '"]';
    else
        $shortcode .= "id = \"{$post->ID}\"]";
    $settings['shibaMlib'] = array('shortcode' => $shortcode);
    return $settings;

}

add_filter( 'media_view_settings','vntd_media_view_settings', 10, 2 );

function vntd_admin_styles() {
	wp_enqueue_style('vntd-admin', get_template_directory_uri() . '/framework/theme-options/assets/css/vntd-admin.css');		
	wp_enqueue_style('vntd-admin-dynamic', get_template_directory_uri() . '/framework/theme-options/assets/css/vntd-admin-dynamic.php');	
	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome/css/font-awesome.min.css');
}

add_action( 'admin_enqueue_scripts', 'vntd_admin_scripts' );
add_action( 'admin_enqueue_scripts', 'vntd_admin_styles' );
add_theme_support( 'automatic-feed-links' );

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Theme Updates
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

if(class_exists( 'Theme_Upgrader' )) { // Load only if Envato Toolkit plugin is activated
function envato_toolkit_admin_init() {
 
    // Include the Toolkit Library
    include_once( get_template_directory() . '/framework/theme-updates/envato-wordpress-toolkit-library/class-envato-wordpress-theme-upgrader.php' );
 
    // Add further code here
 
}
add_action( 'admin_init', 'envato_toolkit_admin_init' );
}

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Add Theme Options button to the WP Admin Bar
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

if( !function_exists( 'north_option' ) ) {
	function north_option( $option_name ) {
		
		global $smof_data;
		$prefix = 'vntd_';
		
		if( array_key_exists( $prefix . $option_name, $smof_data ) ) {
			return $smof_data[ $prefix . $option_name ];
		}
		
		return false;
		
	}
}

function vntd_options_button() {
	global $wp_admin_bar;
	if (!is_super_admin() || !is_admin_bar_showing())
		return;
	$wp_admin_bar->add_menu( array(
		'id' 	=> 'theme_options',
		'title' => __('Theme Options', 'north'),
		'href' 	=> admin_url( 'admin.php?page=optionsframework'),
	));
}
add_action('admin_bar_menu', 'vntd_options_button',35);

class North {
		
	public static function get_animated_class() {
		return ' animated vntd-animated';
	}
	
}