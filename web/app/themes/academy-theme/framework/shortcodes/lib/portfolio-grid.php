<?php

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Portfolio Grid Shortcode
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

function vntd_portfolio_grid($atts, $content = null) {
	extract(shortcode_atts(array(
		"filter" => 'yes',
		"posts_nr" => '',
		"cats" => '',
		"thumb_size" => 'square',
		"order" => '',
		"el_position" => '',
		"width" => '',
		"composer" => '',
		"paged_posts" => '',
		"more_url" => '',
		"thumb_space" => 'yes',
		"cols" => '5',
		"thumb_size" => 'square',
		"link_type" => 'ajax'
	), $atts));
	
	// Define container and item span value
	
	global $post;

	if(!$posts_nr) $posts_nr = "-1";
	$block_id = rand(5,5000);
	
	$layout_class = '';
	$item_class = 'boxed-item col-xs-4';	
	if($thumb_space == 'no') {
		$layout_class = 'fullwidth relative';
		$item_class = 'five';
		if($cols == "4") {
			$item_class = 'four';
		}
	}

	
	if($link_type != 'direct' && $link_type != 'external') {
		wp_enqueue_script('portfolioExpand', '', '', '', true);
		wp_enqueue_style('portfolioExpand');
	}

	ob_start();

	echo '<div class="portfolio t-center '.$layout_class.'"><div class="vntd-grid-before"></div>';
	if($filter == "yes") vntd_portfolio_filters($cats);
	echo '<div class="portfolio-items">';
	wp_reset_postdata();
	$paged = '';
	if($paged_posts == 'yes') {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	}
	
	//echo $cats_arr."ECHO TEST | | ".$cats;
	
	$cats_arr = explode(" ", $cats);
	$args = array(
		'posts_per_page' => $posts_nr,
		'project-type' => $cats,
		'paged' => $paged,
		'post_type' => 'portfolio'
	);
	$the_query = new WP_Query($args); 	
	
	// Default Thumbnail Sizes
	
	$size = "portfolio-square";	
	if($thumb_size == "auto") $size = "portfolio-auto";
	//$size = "portfolio-auto";
	
	$data_content = $ajax_class = '';
	
	if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
		
		$img_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $size);
		$thumb_url = $img_url[0];
		
		$post_link = get_permalink();
		
		$post_link_type = get_post_meta($post->ID,'link_type',TRUE);
		
		if($link_type != 'direct' && $post_link_type != 'direct') {
			$data_content = ' data-content="'.get_permalink().'"';
			$ajax_class = ' colio-link';
		}
		
		if($post_link_type == 'external' && get_post_meta($post->ID,'portfolio_external_url',TRUE)) {
			$data_content = '';
			$ajax_class = '';
			$post_link = get_post_meta($post->ID,'portfolio_external_url',TRUE);
		}
		
				?>
				
					<div class="item <?php echo $item_class; ?> <?php echo vntd_portfolio_item_class(); ?>"<?php echo $data_content; ?>>
						<!-- Item Inner -->
						<div class="item-inner">
							<!-- Item Link -->
							<a href="<?php echo $post_link; ?>" class="work-image<?php echo $ajax_class; ?>">
								<!-- Item Image -->
								<img src="<?php echo $thumb_url ?>" alt="<?php the_title(); ?>">
								<!-- Item Details -->
								<div class="item-details">
									<!-- Item Header -->
									<h1 class="portfolio-grid-title white"><?php the_title(); ?></h1>
									<!-- Item Strips -->
									<span class="portfolio-strips"></span>
									<!-- Item Description -->
									<p class="font-primary uppercase">
										<?php vntd_portfolio_overlay_categories(); ?>
									</p>
								</div>
								<!-- End Item Details -->
							</a>
							<!-- End Item Link -->
						</div>
						<!-- End Item Inner -->
					</div>
					
					<?php 
					
					$data_content = $ajax_class = '';

	endwhile; endif; ?>

	<?php 
	if($paged_posts == 'yes') vntd_pagination($the_query);
	wp_reset_postdata(); 
	
	echo '</div>';
	
	if($more_url) {
		echo '<a href="'.$more_url.'" class="portfolio-view-more uppercase ex-link"><i class="fa fa-plus fa-3x"></i></a>';
	}
	
	echo '</div>';

	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
	
}
remove_shortcode('portfolio_grid');
add_shortcode('portfolio_grid', 'vntd_portfolio_grid');