<?php

define( 'VNTD_SHORTCODES', dirname( __FILE__ ) );

// Add TinyMCE Button

add_action( 'init', 'vntd_add_tinymce_button' );

function vntd_add_tinymce_button()
{
	//if(strstr($_SERVER['REQUEST_URI'], 'wp-admin/post-new.php') || strstr($_SERVER['REQUEST_URI'], 'wp-admin/post.php')) {
	add_filter( 'mce_external_plugins', 'vntd_add_tinymce_plugin' );
	add_filter( 'mce_buttons', 'vntd_register_tinymce_button' );
	//}
}

function vntd_register_tinymce_button( $buttons )
{
	array_push( $buttons, 'separator', "vntd_shortcodes_button" );
	//array_push($buttons, "vntd_visual_button"); 
	return $buttons;
}

function vntd_add_tinymce_plugin( $plugin_array )
{
	$plugin_array['vntd_shortcodes_button'] = get_template_directory_uri() . '/framework/shortcodes/tinymce/tinymce-quick-shortcodes.js';
	//$plugin_array['vntd_visual_button'] = get_template_directory_uri() . '/framework/shortcodes/tinymce/tinymce-visual-shortcodes.js';
	return $plugin_array;
}

// Load complex shortcodes

include_once( VNTD_SHORTCODES . '/lib/google-map.php' );
//include_once( VNTD_SHORTCODES . '/lib/blog.php');
include_once( VNTD_SHORTCODES . '/lib/carousel-portfolio.php' );
include_once( VNTD_SHORTCODES . '/lib/carousel-blog.php' );
include_once( VNTD_SHORTCODES . '/lib/carousel-team.php' );
include_once( VNTD_SHORTCODES . '/lib/carousel-testimonials.php' );
include_once( VNTD_SHORTCODES . '/lib/carousel-logos.php' );
include_once( VNTD_SHORTCODES . '/lib/carousel-services.php' );
include_once( VNTD_SHORTCODES . '/lib/accordion.php' );
include_once( VNTD_SHORTCODES . '/lib/button.php' );
include_once( VNTD_SHORTCODES . '/lib/counter.php' );
include_once( VNTD_SHORTCODES . '/lib/contact-block.php' );
include_once( VNTD_SHORTCODES . '/lib/contact-form.php' );
include_once( VNTD_SHORTCODES . '/lib/call-to-action.php' );
include_once( VNTD_SHORTCODES . '/lib/fancy-text-block.php' );
include_once( VNTD_SHORTCODES . '/lib/fullscreen-slider.php' );
include_once( VNTD_SHORTCODES . '/lib/icon.php' );
include_once( VNTD_SHORTCODES . '/lib/icon-box.php' );
include_once( VNTD_SHORTCODES . '/lib/list.php' );
include_once( VNTD_SHORTCODES . '/lib/portfolio-grid.php' );
include_once( VNTD_SHORTCODES . '/lib/portfolio-details.php' );
include_once( VNTD_SHORTCODES . '/lib/pricing-box.php' );
include_once( VNTD_SHORTCODES . '/lib/progress-bar.php' );
include_once( VNTD_SHORTCODES . '/lib/north-tabs.php' );
include_once( VNTD_SHORTCODES . '/lib/section.php' );
include_once( VNTD_SHORTCODES . '/lib/social-icons.php' );
include_once( VNTD_SHORTCODES . '/lib/tabs.php' );
include_once( VNTD_SHORTCODES . '/lib/team-member.php' );
include_once( VNTD_SHORTCODES . '/lib/toggle.php' );
include_once( VNTD_SHORTCODES . '/lib/video-lightbox.php' );

// - - -
// Function removing extra br and p tags
// - - -

function vntd_do_shortcode( $content )
{
	$array   = array(
		 '<p>[' => '[',
		'<br />[' => '[',
		'<br>[' => '[',
		']</p>' => ']',
		']<br />' => ']',
		']<br>' => ']' 
	);
	$content = strtr( $content, $array );
	return do_shortcode( $content );
}

// - - - - - - - - - -
// Separator
// - - - - - - - - - -

function vntd_separator( $atts, $content = null )
{
	extract( shortcode_atts( array(
		 "type" => '',
		"style" => 'default',
		"label" => '',
		"align" => 'center',
		"space_height" => '' 
	), $atts ) );
	
	$separator_class = $separator_label = '';
	
	if ( $type != "space" ) {
		if ( $style != "default" ) {
			$separator_class .= ' separator-shadow';
		}
		if ( $type == "fullwidth" ) {
			$separator_class .= ' separator-fullwidth';
		}
		if ( $label ) {
			$separator_label = '<div>' . $label . '</div>';
			$separator_class .= ' separator-text-align-' . $align;
		}
		$output = '<div class="separator' . $separator_class . '">' . $separator_label . '</div>';
	} else {
		if ( $space_height != 40 ) {
			$space_style = 'style="height:' . $space_height . 'px;"';
		}
		$output = '<div class="white-space"' . $space_style . '></div>';
	}
	
	
	return $output;
	
}
remove_shortcode( 'separator' );
add_shortcode( 'separator', 'vntd_separator' );

function vntd_spacer( $atts, $content = null )
{
	extract( shortcode_atts( array(
		 "height" => '40' 
	), $atts ) );
	
	if ( $height != 40 ) {
		$height_style = 'style="height:' . $height . 'px;"';
	}
	
	return '<div class="spacer"' . $height_style . '></div>';
	
}
remove_shortcode( 'spacer' );
add_shortcode( 'spacer', 'vntd_spacer' );


// - - - - - - - - - -
// Typography
// - - - - - - - - - -

function vntd_heading( $atts, $content = null )
{
	extract( shortcode_atts( array(
		 "title" => '',
		"subtitle" => '',
		"animated" => '',
		"margin_bottom" => '',
		"font" => '' 
	), $atts ) );
	
	$animation_class = $animation_data = $margin_style = $font_class = '';
	
	if ( $animated != 'no' ) {
		$animation_class = North::get_animated_class();
		$animation_data  = 'data-animation="fadeIn" data-animation-delay="100"';
	}
	$margin_bottom = str_replace( 'px', '', $margin_bottom );
	if ( $margin_bottom != 30 ) {
		$margin_style = 'style="margin-bottom:' . $margin_bottom . 'px;"';
	}
	
	if ( $font == 'secondary' ) {
		$font_class = ' font-secondary';
	}
	
	$return = '<div class="vntd-special-heading"' . $margin_style . '><h1 class="header ' . $font_class . $animation_class . '" ' . $animation_data . '>' . $title . '</h1>';
	
	$return .= '<div class="header-strips-one ' . $animation_class . '" ' . $animation_data . '></div>';
	if ( $subtitle ) {
		$return .= '<h2 class="description normal ' . $animation_class . '" ' . $animation_data . '>' . $subtitle . '</h2>';
	}
	$return .= '</div>';
	return $return;
	
}

function vntd_callout_box( $atts, $content = null )
{
	extract( shortcode_atts( array(
		 "title" => '',
		"subtitle" => '' 
	), $atts ) );
	
	$return = '<div class="vntd-callout-box bs-callout bs-callout-north"><h2 class="colored uppercase font-primary">' . $title . '</h2><p>' . $subtitle . '</p></div>';
	
	return $return;
	
}


function vntd_highlight( $atts, $content = null )
{
	extract( shortcode_atts( array(
		 "color" => '',
		"bgcolor" => '' 
	), $atts ) );
	
	if ( $color || $bgcolor ) {
		$color_class = 'style="background-color:' . $bgcolor . ';color:' . $color . '"';
	}
	
	return '<span class="vntd-highlight vntd-accent-bgcolor"' . $color_class . '>' . $content . '</span>';
}

function vntd_alternative( $atts, $content = null )
{
	
	return '<div class="vntd-alternative-section">' . $content . '</div>';
}

function vntd_dropcap1( $atts, $content = null )
{
	
	return '<span class="vntd-dropcap1">' . $content . '</span>';
}

function vntd_dropcap2( $atts, $content = null )
{
	extract( shortcode_atts( array(
		 "color" => '' 
	), $atts ) );
	
	if ( $color ) {
		$color_class = 'style="background-color:' . $color . '"';
	}
	
	return '<span class="vntd-dropcap2 vntd-accent-bgcolor"' . $color_class . '>' . $content . '</span>';
}

function vntd_blockquote( $atts, $content = null )
{
	extract( shortcode_atts( array(
		 "style" => '' 
	), $atts ) );
	
	$extra_class = ' class="vntd-blockquote1"';
	
	if ( $style == 2 ) {
		$extra_class = ' class="vntd-blockquote2"';
	}
	
	return '<blockquote' . $extra_class . '>' . $content . '</blockquote>';
}

remove_shortcode( 'highlight' );
remove_shortcode( 'alternative' );
remove_shortcode( 'dropcap1' );
remove_shortcode( 'dropcap2' );
remove_shortcode( 'special_heading' );
remove_shortcode( 'blockquote' );
remove_shortcode( 'callout_box' );

add_shortcode( 'special_heading', 'vntd_heading' );
add_shortcode( 'dropcap1', 'vntd_dropcap1' );
add_shortcode( 'dropcap2', 'vntd_dropcap2' );
add_shortcode( 'alternative', 'vntd_alternative' );
add_shortcode( 'highlight', 'vntd_highlight' );
add_shortcode( 'blockquote', 'vntd_blockquote' );
add_shortcode( 'tooltip', 'vntd_tooltip' );
add_shortcode( 'callout_box', 'vntd_callout_box' );