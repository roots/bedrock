<?php

// Recent Work Shortcode


function vntd_portfolio_carousel($atts, $content = null) {
	extract(shortcode_atts(array(
		"cats" => '',
		"posts_nr" => '6',
		"thumb_style" => ''
	), $atts));
	
	wp_enqueue_script('prettyPhoto', '', '', '', true);
	wp_enqueue_style('prettyPhoto');
	
	wp_enqueue_script('owl-carousel', '', '', '', true);
	wp_enqueue_style('owl-carousel');

	ob_start();

	echo '<div class="vntd-portfolio-carousel"><div class="works white">';
	
	$size = 'portfolio-square';
				
	wp_reset_postdata();
	
	$args = array(
		'posts_per_page' => $posts_nr,
		'project-type'		=> $cats,
		'post_type' => 'portfolio',
		'orderby'	=> 'slug'
	);
	$the_query = new WP_Query($args); 
	
	if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
	
	$img_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $size);
	$thumb_url = $img_url[0];
	
	?>
		
		<!-- Item -->
		<div class="item">
			<!-- Image, Buttons -->
			<div class="f-image">
				<!-- Image -->
				<img src="<?php echo $thumb_url; ?>" alt="<?php echo the_title(); ?>">

				<!-- Hover Tags, Link -->
				<div class="f-button first">
					<a href="<?php echo get_permalink(); ?>" class="featured-ball first ex-link" >
						<i class="fa fa-link"></i>
					</a>
				</div>
				<!-- End Link -->

				<!-- Detail -->
				<div class="f-button second">
					<a href="<?php echo $thumb_url; ?>" data-rel="prettyPhoto[featured-work]" class="featured-ball second">
						<i class="fa fa-plus"></i>
					</a>
				</div>
				<!-- End Detail -->
			</div>
			<!-- End Image, Buttons -->

			<!-- Texts -->
			<div class="texts">
				<!-- Item Header -->
				<h1 class="f-head font-primary normal uppercase">
					<?php the_title(); ?>
				</h1>

				<!-- Item Description -->
				<h2 class="f-text font-secondary normal">
					<?php vntd_portfolio_overlay_categories(); ?>
				</h2>
			</div>
			<!-- End Texts -->
		</div>
		<!-- End Item -->
	
	<?php
	
	
	endwhile; endif; wp_reset_postdata();		
	
	echo '</div>';
	
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
	
}
remove_shortcode('portfolio_carousel');
add_shortcode('portfolio_carousel', 'vntd_portfolio_carousel');