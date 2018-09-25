<?php

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//
// 		Header related functions
//
//		Q: Why place theme here instead of the functions.php file?
//		A: WordPress totally breaks if you make any accident changes
//		   to that file.
//
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-


// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
// 		Mobile Navigation
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

function vntd_mobile_nav($button = NULL) {

	global $smof_data;
	
	if(!$smof_data['vntd_responsive']) {
		return false;
	}

	
	if($button) {
		echo '<div id="vntd-mobile-nav-toggle"><i class="fa fa-bars"></i></div>';
	} else { ?>
		<div id="mobile-navigation" class="vntd-container">
			<?php wp_nav_menu( array('theme_location' => 'primary' )); ?>
		</div>	
	<?php }

}


function vntd_retina_logo() {
	
	global $smof_data;
	
	$logo_url = $smof_data['vntd_logo_url'];
	
	if(!$logo_url) return false;
	
	
	if($smof_data['vntd_logo_url_retina']) {
		$logo_url = $smof_data['vntd_logo_url_retina'];
	}
	
	echo '<img class="vntd-retina-logo-img" src="'.$logo_url.'" alt="'.get_bloginfo().'" style="height:'.$smof_data['vntd_logo_height'].'px;">';
}

function vntd_navbar_style($type = NULL) {
	
	global $smof_data,$post;
	
	$navbar_style = $navbar_color = '';
	
	if(array_key_exists('vntd_navbar_style', $smof_data)) {
		$navbar_style = $smof_data['vntd_navbar_style'];
	}
	if(get_post_meta(vntd_get_id(),'navbar_style',TRUE) && get_post_meta(vntd_get_id(),'navbar_style',TRUE) != 'default') {
		$navbar_style = get_post_meta(vntd_get_id(),'navbar_style',TRUE);
	}
	if(array_key_exists('vntd_navbar_color', $smof_data)) {
		$navbar_color = $smof_data['vntd_navbar_color'];
	}
	if(get_post_meta(vntd_get_id(),'navbar_color',TRUE) && get_post_meta(vntd_get_id(),'navbar_color',TRUE) != 'default') {
		$navbar_color = get_post_meta(vntd_get_id(),'navbar_color',TRUE);
	}
	
	$navfirst_class = $navtop_class = '';
	$navcolor_class = 'white-nav b-shadow';
	$navbar_style1 = true;
	
	if(is_single() && get_post_type() == 'team' || is_single() && get_post_type() == 'testimonials' || is_single() && get_post_type() == 'services') {
		$navbar_style = 'style1';
		//echo $navbar_style;
	}
	
	if(!is_search() && !is_archive() && !is_404()) {
		if($navbar_style == 'style2' || $navbar_style == 'style3') {
			$navfirst_class = ' first-nav';
		}
		if($navbar_color == 'dark') {
			$navcolor_class = 'dark-nav';
		}
		if($navbar_style == 'style3') {
			$navtop_class = ' nav-from-top';
		}
		if($navbar_style == 'style2' || $navbar_style == 'style3') $navbar_style1 = false;
	}
	
	if($type == 'id') {
		if($navbar_style1 == true) return '-sticky';
	} elseif($type == 'style') {
		return $navbar_style;
	} else {
		return $navcolor_class . $navtop_class . $navfirst_class . ' navbar-' . $navbar_style;
	}
}

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
// 		Breadcrumbs
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

function vntd_breadcrumbs() {

	global $post,$smof_data;
	
	$title = $url = '';
	
    if (!is_front_page()) {    	   		
    	
		if(is_single() && get_post_type() == 'portfolio') {

			if(!$smof_data['vntd_portfolio_url']) return false;			
			
			$page_data = get_page_by_path($smof_data['vntd_portfolio_url']);
			
			$title = __('Back to Portfolio','north');
			$url = get_permalink($page_data->ID);
			
		} elseif(is_single()) {			
		
			$title = __('Back to Blog','north');
			$url = get_permalink(get_option('page_for_posts'));
		} else {
			$title = __('Back to Home','north');
			$url = site_url();
		}
		
		if (class_exists('Woocommerce')) {
		    if( is_product() ) {        
		    	$title = __('Back to Shop','north');
		    	$url = get_permalink(get_option('woocommerce_shop_page_id'));        
		    } elseif( is_product_category() ) {
		    	$title = __('Back to Shop','north');
		    	$url = get_permalink(get_option('woocommerce_shop_page_id'));
		    }
		}
		
		
		
		echo '<div class="p_head_right f-left t-right"><a href="'.$url.'" title="'.$title.'" class="ex-link p-head-button uppercase"><i class="fa fa-angle-left"></i> '.$title.'</a></div>';
    }
}

function vntd_logo_url() {
	if(is_front_page()) {
		echo '#home';
	} else {
		echo site_url();
	}
}

//
// Page Title Function
//

function vntd_print_page_title() {

	global $post,$smof_data;
	
	$page_id = 1;
	
	if(get_post_type() == 'services' || get_post_type() == 'testimonials') {
		return false;
	}	
	
	if(is_object($post)) {
		$page_id = $post->ID;
	}
	
	$page_title = get_the_title($page_id);
	
	if( is_home() ) {
		$page_title = __('Blog','north');
	}
	
	$page_tagline_wrap = '';
	
	if(get_post_meta($page_id,'page_subtitle',TRUE)) {
		$page_tagline_wrap = '<p class="p-desc">'.get_post_meta($page_id,'page_subtitle',TRUE).'</p>';
	}
	
	if( is_search() ) {
		$page_title = __('Search','north');
		$page_tagline_wrap = '<p class="p-desc">'.__('Search results for: ','north').get_search_query().'</p>';
	}
	
	if ( class_exists('Woocommerce') ) {
	    if( is_shop() || is_product() || is_product_category() ) {        
	    	$page_title = get_the_title( get_option('woocommerce_shop_page_id') );        
	    }

	}
	
	?>
	
	<section id="page-title" class="page_header">
		<div class="page_header_inner clearfix">
			<div class="p_head_left f-left">
				<h1 class="p-header font-primary uppercase">
					<?php echo $page_title; ?>
				</h1>
				<?php echo $page_tagline_wrap; ?>				
			</div>
			
			<?php
			if(array_key_exists('vntd_breadcrumbs', $smof_data)) {
				if($smof_data['vntd_breadcrumbs']) {
				
					vntd_breadcrumbs();
					
				}
			}
			?>
			
		</div>
	</section>
	
	<?php
	
}