<?php
/**
 */

function vntd_image_slider( $atts, $content = null ) {
    $title = $type = $onclick = $custom_links = $img_size = $custom_links_target = '' ;
    $width = $images = $el_class = $interval = $el_position = '';
    extract(shortcode_atts(array(
        'title' => '',
        'onclick' => 'link_image',
        'custom_links' => '',
        'custom_links_target' => '',
        'img_size' => 'thumbnail',
        'img_size_custom' => 'thumbnail',
        'width' => '1/1',
        'images' => '',
        'el_class' => '',
        'interval' => '5',
        'el_position' => ''
    ), $atts));
    $output = '';
    $gal_images = '';
    $link_start = '';
    $link_end = '';
    $el_start = '';
    $el_end = '';
    $slides_wrap_start = '';
    $slides_wrap_end = '';

    $width = wpb_translateColumnWidthToSpan($width);
	$type = "flexslider";
	
	// FlexSlider
	
    $el_start = '<li>';
    $el_end = '</li>';
    $slides_wrap_start = '<ul class="slides">';
    $slides_wrap_end = '</ul>';
    wp_enqueue_style('flexslider');
    wp_enqueue_script('flexslider', '', '', '', true);


    if ( $onclick == 'link_image' ) {
        wp_enqueue_script( 'prettyphoto' , '', '', '', true);
        wp_enqueue_style( 'prettyphoto' );
    }

    $flex_fx = '';
    if ( $type == "flexslider" || $type == "flexslider_fade" || $type == "fading" ) {
        $type = ' wpb_flexslider flexslider_fade flexslider';
        $flex_fx = ' data-flex_fx="fade"';
    } else if ( $type == 'flexslider_slide' ) {
        $type = ' wpb_flexslider flexslider_slide flexslider';
        $flex_fx = ' data-flex_fx="slide"';
    }

    if ( $images == '' ) return null;

    $pretty_rel_random = 'rel-'.rand();

    if ( $onclick == 'custom_link' ) { $custom_links = explode( ',', $custom_links); }
    $images = explode( ',', $images);
    $i = -1;
    
    if($img_size != "custom") {
    	$img_size_custom = $img_size;
    }
	
    foreach ( $images as $attach_id ) {
        $i++;
        $post_thumbnail = wpb_getImageBySize(array( 'attach_id' => $attach_id, 'thumb_size' => $img_size_custom ));
        if ( wpb_debug() ) {
            //var_dump($post_thumbnail);
        }
        $thumbnail = $post_thumbnail['thumbnail'];
        $p_img_large = $post_thumbnail['p_img_large'];
        $link_start = $link_end = '';
        

        if ( $onclick == 'link_image' ) {
            $link_start = '<a class="prettyphoto" rel="prettyPhoto['.$pretty_rel_random.']" href="'.$p_img_large[0].'">';
            $link_end = '</a>';
        }
        else if ( $onclick == 'custom_link' && isset( $custom_links[$i] ) && $custom_links[$i] != '' ) {
            $link_start = '<a href="'.$custom_links[$i].'"' . (!empty($custom_links_target) ? ' target="'.$custom_links_target.'"' : '') . '>';
            $link_end = '</a>';
        }
        $gal_images .= $el_start . $link_start . $thumbnail . $link_end . $el_end;
    }

    $output .= "\n\t".'<div class="wpb_gallery wpb_content_element '.$width.$el_class.'">';
    $output .= "\n\t\t".'<div class="wpb_wrapper">';
    //$output .= ($title != '' ) ? "\n\t\t\t".'<h2 class="wpb_heading wpb_gallery_heading">'.$title.'</h2>' : '';
    $output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_gallery_heading'));
    $output .= '<div class="wpb_gallery_slides'.$type.'" data-interval="'.$interval.'"'.$flex_fx.'>'.$slides_wrap_start.$gal_images.$slides_wrap_end.'</div>';
    $output .= "\n\t\t".'</div> ';
    $output .= "\n\t".'</div> ';

    $output = vntd_startRow($el_position) . $output . vntd_endRow($el_position);
    
    return $output;
}
add_shortcode("image_slider","sc_image_slider");