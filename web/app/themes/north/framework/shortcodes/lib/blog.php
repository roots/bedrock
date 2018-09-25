<?php

// Blog Shortcode


function vntd_blog($atts, $content = null) {
	extract(shortcode_atts(array(
		"cats" => '',
		"style" => '',
		"grid_columns" => '',
		"pagination_type" => '',
		"posts_nr" => '',
		"el_position" => '',
		"width" => '',
	), $atts));
	
	// Get Page Layout
	
	global $post;
	
	//$content_class = 9;
	$layout = get_post_meta($post->ID, 'page_layout', true);
	//if($width == "1/1") $content_class = 12;
	if($layout != "fullwidth") $sidebar_class = "page-sidebar";

	// Define grid item size

	if($style == "grid"){

		if($grid_columns == 2){
			$item_class = "col2";
		}elseif($grid_columns == 3){
			$item_class = "col3";
		}else{
			$item_class = "col4";
		}
	}
	
	// Define container and item span value
	
	ob_start();
	
	echo '<div class="blog-wrap blog-'.$style.'">';
		
	// If Grid layout

	if($style == "grid") echo '<div class="vntd-grid">'; 
	
		
	// The Loop
	
	wp_reset_query(); $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;	
	query_posts('post_type=post&cat='.$cats.'&posts_per_page='.$posts_nr.'&paged='.$paged);
	
	global $more; $more = 0; // Reset the More Tage
	
	if (have_posts()) : while (have_posts()) : the_post();
		
		vntd_blog_post_index('fullwidth',$style,$grid_columns);
		
	endwhile; endif; 
	
	// Loop END
				
	
	if($style == "grid") echo '</div>'; 
		
	vntd_pagination(); // Pagination
	
	wp_reset_query(); 
	
	echo '</div>';
	
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
	
}
remove_shortcode('blog');
add_shortcode('blog', 'vntd_blog');