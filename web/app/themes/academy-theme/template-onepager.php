<?php 
/* Template Name: Homepage / One Pager */
$post = $wp_query->post;
get_header();
		
	if (have_posts()) : while (have_posts()) : the_post(); 
	        
		the_content(); 
	          
	endwhile; endif;   

get_footer(); 
 
?>