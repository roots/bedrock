<?php
$output = $title = $type = $onclick = $custom_links = $img_size = $mp_gallery = $custom_links_target = $images = $el_class = $interval = '';
extract(shortcode_atts(array(
    'title' => '',
    'type' => 'image_grid',
    'onclick' => 'link_image',
    'custom_links' => '',
    'custom_links_target' => '',
    'img_size' => 'large',
    'img_size_custom' => '',
    'images' => '',
    'el_class' => '',
    'interval' => '5'
    
), $atts));
$gal_images = '';
$link_start = '';
$link_end = '';
$el_start = '';
$el_end = '';
$slides_wrap_start = '';
$slides_wrap_end = '';

$el_class = $this->getExtraClass($el_class);


    $el_start = '<li class="gallery-item">';
    $el_end = '</li>';
    $slides_wrap_start = '<ul>';
    $slides_wrap_end = '</ul>';


if ( $onclick == 'link_image' ) {
    wp_enqueue_script('magnific-popup', '', '', '', true);
    wp_enqueue_style('magnific-popup');
    $mp_class = ' mp-gallery';
}


    $type = ' wpb_image_grids';


//if ( $images == '' ) return null;
if ( $images == '' ) $images = '-1,-2,-3';

$pretty_rel_random = ' rel="prettyPhoto[rel-'.rand().']"'; //rel-'.rand();

if ( $onclick == 'custom_link' ) { $custom_links = explode( ',', $custom_links); }
$images = explode( ',', $images);
$i = -1;

if($img_size == "custom" && $img_size_custom) {
	$img_size = $img_size_custom;
}

foreach ( $images as $attach_id ) {
    $i++;
    if ($attach_id > 0) {
        $post_thumbnail = wpb_getImageBySize(array( 'attach_id' => $attach_id, 'thumb_size' => $img_size ));
    }
    else {
        $different_kitten = 400 + $i;
        $post_thumbnail = array();
        $post_thumbnail['thumbnail'] = '<img src="http://placekitten.com/g/'.$different_kitten.'/300" />';
        $post_thumbnail['p_img_large'][0] = 'http://placekitten.com/g/1024/768';
    }

    $thumbnail = $post_thumbnail['thumbnail'];
    $p_img_large = $post_thumbnail['p_img_large'];
    $link_start = $link_end = '';
	

    if ( $onclick == 'link_image' ) {
        $link_start = '<a href="'.$p_img_large[0].'">';
        $link_end = '<span class="hover-overlay"></span><span class="hover-icon hover-icon-zoom"></span></a>';
    }
    else if ( $onclick == 'custom_link' && isset( $custom_links[$i] ) && $custom_links[$i] != '' ) {
        $link_start = '<a href="'.$custom_links[$i].'"' . (!empty($custom_links_target) ? ' target="'.$custom_links_target.'"' : '') . '>';
        $link_end = '</a>';
    }
    $gal_images .= $el_start . $link_start . $thumbnail . $link_end . $el_end;
}
$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_gallery wpb_content_element'.$el_class.' clearfix', $this->settings['base']);
$output .= "\n\t".'<div class="'.$css_class.$mp_class.' vntd-gallery">';
$output .= "\n\t\t".'<div class="wpb_wrapper">';
$output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_gallery_heading'));
$output .= '<div class="wpb_gallery_slides'.$type.'" data-interval="'.$interval.'">'.$slides_wrap_start.$gal_images.$slides_wrap_end.'</div>';
$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
$output .= "\n\t".'</div> '.$this->endBlockComment('.wpb_gallery');

echo $output;