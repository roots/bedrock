<?php

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Testimonials Carousel
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

function vntd_testimonials($atts, $content = null) {
	extract(shortcode_atts(array(
		"posts_nr" => '6',
		"style" => 'simple'
	), $atts));
	
	wp_enqueue_script('owl-carousel', '', '', '', true);
	wp_enqueue_style('owl-carousel');
	
	ob_start();		
    
    ?>
    
	<div class="vntd-testimonial-carousel">
	
	<?php if($style != 'expanded') { ?>
	
		<div class="testimonials t-center">
	
		<a class="t-arrow"></a>
		
		<h1 class="quote white">			
			<i class="fa fa-quote-right"></i>
		</h1>	
		
		<ul class="text-slider clearfix">
	
	<?php } else { ?>
	
		<div class="clients t-center animated" data-animation="fadeIn" data-animation-delay="400">
	
	<?php }	
					 			
	wp_reset_postdata();
	
	$args = array(
		'posts_per_page' => $posts_nr,
		'post_type' => 'testimonials'
	);
	$the_query = new WP_Query($args); 	
	
	if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
	
	if($style != 'expanded') {
	
		echo '<li class="text normal"><h1 class="white">'.get_post_meta(get_the_id(), 'testimonial_content', true).'</h1>';
		echo '<p class="author uppercase">'.get_post_meta(get_the_id(), 'name', true).'</p></li>';
	
	} else {
	
		wp_enqueue_script('owl-carousel', '', '', '', true);
		wp_enqueue_style('owl-carousel');	
	
		echo '<div class="item"><a class="client-image"><img src="'.vntd_thumb(130,130).'" class="round"></a><h1 class="client-name">'.get_post_meta(get_the_id(), 'name', true).'</h1><h3 class="client-position">'.get_post_meta(get_the_id(), 'role', true).'</h3>';
		echo '<p class="client-desc">'.get_post_meta(get_the_id(), 'testimonial_content', true).'</p></div>';
	
	}
	
	endwhile; endif; wp_reset_postdata();
	
	if($style != 'expanded') {
		echo '</ul></div>';
	} else {
		echo '</div>';
	}
			
	echo '</div>';
	
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
	
}
remove_shortcode('testimonials');
add_shortcode('testimonials', 'vntd_testimonials');