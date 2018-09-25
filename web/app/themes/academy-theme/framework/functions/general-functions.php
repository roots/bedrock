<?php

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//
// 		Theme Functions
//
//		Q: Why place theme here instead of the functions.php file?
//		A: WordPress totally breaks if you make any accident changes
//		   to that file.
//
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-


// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Image cropping functions
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

function vntd_thumb($w,$h = null){
	require_once dirname(__FILE__).'/../../includes/aq_resizer.php';
	
	global $post;
	$imgurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
	return $imgurl[0];
	return aq_resize($imgurl[0],$w,$h,true);
}

function vntd_body_skin() {

	global $smof_data;
	
	$return = '';
	
	if(array_key_exists('vntd_skin', $smof_data)) {
		if($smof_data['vntd_skin'] == 'night' || $smof_data['vntd_skin'] == 'dark') {
			$return .= 'dark-layout';
		}
	}
	
	if( array_key_exists('vntd_sticky_header', $smof_data) ) {
		if( $smof_data['vntd_sticky_header'] == false ) {
			$return .= ' header-not-sticky';
		} elseif( $smof_data['vntd_sticky_header_mobile'] == false ) {
			$return .= ' header-not-sticky-mobile';
		} else {
			$return .= ' header-sticky';
		}
	}
	
	return $return;
}


// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
// 		Pagination
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-


function vntd_pagination($the_query = NULL)
{  

	global $wp_query,$paged;
	 
//	$total_pages = $wp_query->max_num_pages;
//	
//	if(!is_null($the_query)) {
//		$total_pages = $the_query->max_num_pages;
//	} 
//	
//	if ($total_pages > 1){
//	 
//	  $current_page = max(1, get_query_var('paged'));
//	  
//	  
//	  
//	  echo '<div class="blog_pagination t-right pagination pagination-sm no-margin">';
//	  echo paginate_links(array(
//	      'base' => get_pagenum_link(1) . '%_%',
//	      'format' => ( ( get_option( 'permalink_structure' ) && ! $wp_query->is_search ) || ( is_home() && get_option( 'show_on_front' ) !== 'page' && ! get_option( 'page_on_front' ) ) ) ? '?paged=%#%' : '&paged=%#%', // %#% will be replaced with page number	      
//	      'current' => $current_page,
//	      'total' => $total_pages,
//	      'prev_text' => __('Prev','north'),
//	      'next_text' => __('Next','north')
//	    ));
//	  echo '</div>';
//	}
	
	$big = 999999999; // need an unlikely integer
    $pages = paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
             'format' => ( ( get_option( 'permalink_structure' ) && ! $wp_query->is_search ) || ( is_home() && get_option( 'show_on_front' ) !== 'page' && ! get_option( 'page_on_front' ) ) ) ? '?paged=%#%' : '&paged=%#%', // %#% will be replaced with page number	
            'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages,
            'prev_next' => false,
            'type'  => 'array',
            'prev_next'   => TRUE,
			'prev_text' => __('Prev','north'),
			'next_text' => __('Next','north')
        ) );
        if( is_array( $pages ) ) {
            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
            echo '<div class="blog_pagination t-right"><ul class="pagination">';
            foreach ( $pages as $page ) {
                    echo "<li>$page</li>";
            }
           echo '</ul></div>';
        }
	
}

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Custom Excerpt Size
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

function vntd_custom_excerpt_length( $length ) {
	return 70; // Increase maximum excerpt size
}
add_filter( 'excerpt_length', 'vntd_custom_excerpt_length', 999 );

function vntd_excerpt($limit,$more = NULL,$class = NULL) {
	global $post;
	setup_postdata($post);
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	}else{
		$excerpt = implode(" ",$excerpt);
	} 
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	$p_class = '';
	if($class) $p_class = ' class="'.$class.'"';
	$output = '<p'.$p_class.'>'.$excerpt.'</p>';
	
	if($more === 'link') {
		$output .= '<a href="'.get_post_meta($post->ID,"post_link",TRUE).'" class="post-read-more">'.__('Visit Site','north').'</a>';
	}elseif($more) {
		$output .= '<div class="fullwidth t-right"><a href="'.get_permalink($post->ID).'" class="read-more-post ex-link uppercase">'.__('Read more','north').' <i class="fa fa-angle-right"></i></a></div>';
	}

	return $output;
	
}

function vntd_excerpt_plain($limit) {
      $excerpt = explode(' ', get_the_excerpt(), $limit);
      
      if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
      } else {
        $excerpt = implode(" ",$excerpt);
      } 
      
      $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
      return $excerpt;
}

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Post Gallery
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

function vntd_post_gallery($type,$thumb_size) {
		
	global $post;

	$gallery_images = get_post_meta($post->ID, 'gallery_images', true);
	
	if(!$gallery_images && has_post_thumbnail()) { // No Gallery Images	
		$url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $thumb_size);
		return '<img src="'.$url[0].'" alt="'.get_the_title($post->ID).'">';
	}
	
	echo '<div class="vntd-post-gallery vntd-post-gallery-'.$type.'">';	
				
	if($type == "slider") { // Slider Gallery
		
		echo '<div class="flexslider vntd-flexslider"><ul class="slides">';
					
		$ids = explode(",", $gallery_images);				
		foreach($ids as $id){
			$image_url = wp_get_attachment_image_src($id, $thumb_size);
			echo '<li><img src="'.$image_url[0].'" alt></li>';
		}
							
		echo '</ul></div>';				
		
	} elseif($type == "list" || $type == "list_lightbox") {
		
		$ids = explode(",", $gallery_images);				
		foreach($ids as $id){
			//global $post = $post=>$id;
			$image_url = wp_get_attachment_image_src($id, $thumb_size);
			$big_url = wp_get_attachment_image_src($id, 'fullwidth-auto');
			echo '<div class="vntd-gallery-item">';
			if($type == "list_lightbox") echo '<a href="'.$big_url[0].'" class="hover-item" rel="gallery[gallery'.$post->ID.']" title="'.get_post($id)->post_excerpt.'"><span class="hover-overlay"></span><span class="hover-icon hover-icon-zoom"></span>';			
			echo '<img src="'.$image_url[0].'" alt>';
			if($type == "list_lightbox") echo '</a>';
			echo '</div>';
		}	
	
	} else {	
		// If Lightbox Gallery
		echo '<div class="featured-image-holder"><div class="gallery clearfix">';
		
		$ids = explode(",", $gallery_images);
		if($gallery_images) $id = array_shift(array_values($ids));
		$image_url = wp_get_attachment_image_src($id, $thumb_size);
		$large_url = wp_get_attachment_image_src($id, 'large');
		echo '<a class="hover-item" href="'.$large_url[0].'" rel="gallery[gallery'.$post->ID.']"><img src="'.$image_url[0].'"><span class="hover-overlay"></span><span class="hover-icon hover-icon-zoom"></span></a>';
			
			if($gallery_images){
			
				echo '<div class="lightbox-hidden">';								
				foreach(array_slice($ids,1) as $id){
					echo '<a href="'.wp_get_attachment_url($id).'" rel="gallery[gallery'. $post->ID .']"></a>';
				}
				echo '</div>';
							
			}
								
		echo '</div></div>';
		
	}
	
	echo '</div>';
}


function vntd_gallery_metabox($gallery_images) {

	$modal_update_href = esc_url( add_query_arg( array(
	     'page' => 'shiba_gallery',
	     '_wpnonce' => wp_create_nonce('shiba_gallery_options'),
	 ), admin_url('upload.php') ) );
	 ?>	          
	
	 <div class="vntd-gallery-thumbs">
	 	<?php
	 	
 		if($gallery_images){
 		
 			$ids = explode(",", $gallery_images);
 			
 			foreach($ids as $id){
 				echo '<img src="'.wp_get_attachment_thumb_url($id).'" alt>';
 			}
 		
 		}
	 	
	 	?>
	 </div>
	 
	 <input type="text" class="hidden" id="gallery_images" name="gallery_images" value="<?php echo $gallery_images; ?>">
	 <?php if($gallery_images) { $button_text = __("Modify Gallery", "north"); } else { $button_text = __("Create Gallery", "north"); } ?>
	 <a id="vntd-gallery-add" class="button" href="#"
	     data-update-link="<?php echo esc_attr( $modal_update_href ); ?>"
	     data-choose="<?php _e('Choose a Default Image', "north"); ?>"
	     data-update="<?php _e('Set as default image', "north"); ?>"><?php echo $button_text; ?>
	 </a>
	 <?php if($gallery_images){ ?><span class="vntd-gallery-or">
	 <?php _e('or', 'north') ?> </span><input type="button" id="vntd-gallery-remove" class="button" value="Remove Gallery">
	 
	 
	 <?php
	 }
	 // Add to the top of our data-update-link page
	 if (isset($_REQUEST['file'])) { 
	     check_admin_referer("shiba_gallery_options");
	  
	         // Process and save the image id
	     $options = get_option('shiba_gallery_options', TRUE);
	     $options['default_image'] = absint($_REQUEST['file']);
	     update_option('shiba_gallery_options', $options);
	 
	}

}

function vntd_get_id() {

	global $post;
	
	$post_id = '';
	
	if(is_object($post)) {
		$post_id = $post->ID;
	}
	if(is_home()) {
		$post_id = get_option('page_for_posts');
	}
	
	return $post_id;
}

function vntd_fonts() {

	global $smof_data;
	
	$font_body = 'Raleway';	
	$font_heading = 'Oswald';	
	$font_weight = $nav_font_weight = '';
	
	if(array_key_exists('vntd_body_font', $smof_data)) {
	if($smof_data['vntd_body_font'] && $smof_data['vntd_body_font'] != $font_body) {
		$font_body = $smof_data['vntd_body_font'];
	}
	}
	if(array_key_exists('vntd_heading_font', $smof_data)) {
	if($smof_data['vntd_heading_font'] && $smof_data['vntd_heading_font'] != $font_heading) {
		$font_heading = $smof_data['vntd_heading_font'];
	}
	}
	//if($font_body == 'Open Sans' && $font_heading == 'Open Sans') return false;
	
	$font_heading_weight = ':300,400';
	if(array_key_exists('vntd_heading_font_weight', $smof_data)) {
		$font_weight = $smof_data['vntd_heading_font_weight'];	
	}
	if(!$font_weight) $font_weight = 400;	
	
	$font_heading_weight = ':300,'.$font_weight;
	
	//$font_heading_weight = ':300,400,500,600,700';
	
	if(array_key_exists('vntd_navigation_font_weight', $smof_data)) {
	$nav_font_weight = $smof_data['vntd_navigation_font_weight'];
	}
	if(!$nav_font_weight) $nav_font_weight = 600;
	
	if($nav_font_weight != $font_weight && $nav_font_weight != 300) {
		$font_heading_weight .= ','.$nav_font_weight;
	}
	
	if($font_body != $font_heading && strpos($font_body, ',') === false ) {
		wp_enqueue_style('google-font-body', 'http://fonts.googleapis.com/css?family='.str_replace(' ','+',$font_body).$font_heading_weight);
	}	
	
	if( strpos($font_heading, ',') === false ) {
		wp_enqueue_style('google-font-heading', 'http://fonts.googleapis.com/css?family='.str_replace(' ','+',$font_heading).$font_heading_weight);	
	}
	wp_enqueue_style('google-font-third', 'http://fonts.googleapis.com/css?family=Indie+Flower');

}
add_action('wp_enqueue_scripts', 'vntd_fonts');
add_action( 'admin_enqueue_scripts', 'vntd_fonts');

if ( function_exists('vntd_footer_tracking_code') ) {
  add_action('wp_footer', 'vntd_footer_tracking_code');
}

function vntd_footer_tracking_code() {
	global $smof_data;
	if(array_key_exists('vntd_tracking_code',$smof_data)) {
		echo $smof_data['vntd_tracking_code'];
	}
	
}

function vntd_print_social_icons() {

	global $smof_data;
	$target = '';
	
	if(array_key_exists('vntd_social_icons',$smof_data)) {
		if($smof_data['vntd_social_icons']) {
			echo '<div class="vntd-social-icons">';
			if($smof_data['vntd_social_icons_target']) {
				$target = ' target="_blank"';
			}
			foreach($smof_data['vntd_social_icons'] as $social_icon)  
			{  
				echo '<a class="social-'.strtolower($social_icon['icon_name']).'" href="'.$social_icon['url'].'"'.$target.'><i class="fa fa-'.strtolower($social_icon['icon_name']).'"></i></a>';
			} 	
			echo '</div>';
		}
	}
}

// Footer Widgets related functions

function vntd_get_footer_cols() {
	
	if(is_active_sidebar('footer1') && is_active_sidebar('footer2') && is_active_sidebar('footer3') && is_active_sidebar('footer4')) {
		return 4;
	} elseif(is_active_sidebar('footer1') && is_active_sidebar('footer2') && is_active_sidebar('footer3')) {
		return 3;
	} elseif(is_active_sidebar('footer1') && is_active_sidebar('footer2')) {
		return 2;
	} else {
		return 1;
	}
	
	return 0;
}

function vntd_get_footer_cols_class() {

	$widget_col_class = 'col-xs-3';
	
	if(vntd_get_footer_cols() == 1) {
		$widget_col_class = 'col-md-12';
	} elseif(vntd_get_footer_cols() == 2) {
		$widget_col_class = 'col-md-6';
	} elseif(vntd_get_footer_cols() == 3) {
		$widget_col_class = 'col-md-4';
	}
	
	return $widget_col_class;
}

function vntd_get_footer_widgets_class() {
	
	global $smof_data;
	
	if($smof_data['vntd_footer_widgets_skin'] == 'dark') {
		return 'footer-widgets-dark';
	} elseif($smof_data['vntd_footer_widgets_skin'] == 'night') { 
		return 'footer-widgets-night';
	} elseif($smof_data['vntd_footer_widgets_skin'] == 'dark') {
		return 'footer-widgets-white';
	} else {
		
	}
	
	return 'footer-widgets-white';
	
}

if( !function_exists('north_vc_active') ) {
	function north_vc_active() { // Function to check if Visual Composer is enabled on a specific page.
	
		global $post;
		
		$found = false;
		
		if(is_object($post)) {
			$post_to_check = get_post($post->ID);
		} else {
			return $found;
		}
		   
		// check the post content for the short code
		if ( stripos($post_to_check->post_content, '[vc_row') !== false ) {
		    // we have found the short code
		    $found = true;
		}
		
		if(is_home()) {
			$found = false;
		}
		 
		// return our final results
		return $found;
	
	}
}

if( !function_exists( 'north_option' ) ) {
	function north_option( $option_name ) {
	
		global $smof_data;
		
		if ( strpos( $option_name, 'vntd_' ) !== false) {
			
		} else {
			$option_name = 'vntd_' . $option_name;
		}
		
		if( array_key_exists( $option_name, $smof_data ) ) {
			return $smof_data[ $option_name ];
		} else {
			return null;
		}
		
		return array();
	}
}

if( !function_exists( 'vntd_icon_select' ) ) {
	function vntd_icon_select( $name, $selected_icon = false, $multiple = false ) {
	
		$icons = north_fa_array();
		
		echo '<ul id="vntd-icon-select">';
		foreach( $icons as $icon => $key ) {
			$selected = '';
			if( $icon == $selected_icon ) $selected = 'checked="checked"';
			echo '<li><input type="radio" id="icon-' . esc_attr( $icon ) .'" name="' . esc_attr( $name ) . '" value="' . esc_attr( $icon ) . '"' . $selected . '><label for="icon-' . esc_attr( $icon ) . '"><i class="fa ' . esc_attr( $icon ) . '"></i></label></li>';
		}
		echo '</ul>';
		
	}
}