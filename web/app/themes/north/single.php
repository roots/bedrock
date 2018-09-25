<?php 
$post = $wp_query->post;
get_header();
$layout = get_post_meta($post->ID, 'page_layout', true);
$page_width = get_post_meta($post->ID, 'page_width', true);
if(!$page_width) $page_width = 'content';
?>

<div class="single-post post blog page-holder page-layout-<?php echo $layout; ?>">
		
	<?php 		
	
	if($page_width != 'fullwidth') {
		echo '<div class="inner clearfix">';
	}
	
	if($layout != "fullwidth") {
		echo '<div class="page_inner">';
	}
	
	if (have_posts()) : while (have_posts()) : the_post(); 
	        
		vntd_blog_post_content();
	          
	endwhile; endif; 
	
	if (comments_open()){ comments_template(); } // Load comments if enabled	     
	
	if($layout != "fullwidth") { 
		echo '</div>';
		get_sidebar();    		
	}
	
	if($page_width != 'fullwidth') {
		echo '</div>';
	}
	
	?>

</div>

<?php get_footer(); ?>