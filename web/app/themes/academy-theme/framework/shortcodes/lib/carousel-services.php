<?php

// Blog Posts Carousel

function vntd_services_carousel($atts, $content = null) {
	extract(shortcode_atts(array(
		"posts_nr" => '6'
	), $atts));
	
	wp_enqueue_script('owl-carousel', '', '', '', true);
	wp_enqueue_style('owl-carousel');
	
	ob_start();	
	
	echo '<div class="vntd-services-carousel">';	
	
	
	echo '<div class="service-boxes clearfix t-center">';	
		wp_reset_postdata();
		
		$args = array(
			'posts_per_page' => $posts_nr,
			'post_type' => 'services'
		);
		
		$the_query = new WP_Query($args);
		
		if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
		?>
		
		<div class="item service-box">
		
			<!-- Service Icon -->
			<a class="service-icon">
				<i class="fa <?php echo get_post_meta(get_the_ID(),"icon",TRUE); ?>"></i>
			</a>

			<!-- Service Box Header -->
			<h3 class="uppercase normal font-primary">
				<?php echo get_post_meta(get_the_ID(),"title",TRUE); ?>
			</h3>

			<!-- Service Box Description -->
			<p class="normal">
				<?php echo get_post_meta(get_the_ID(),"desc",TRUE); ?>
			</p>

		</div>			
							
		<?php		 
		endwhile; endif; wp_reset_postdata();
		
	echo '</div></div>';
	
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
	
}
remove_shortcode('services_carousel');
add_shortcode('services_carousel', 'vntd_services_carousel');