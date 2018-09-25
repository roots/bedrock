<?php 
$post = $wp_query->post;
get_header(); 
$layout = "fullwidth";
$page_width = "content";
$page_links = '';
?>

<div class="page-holder page-layout-<?php echo $layout; ?>">
		
	<?php 		
	
	if($page_width != 'fullwidth') {
		echo '<div class="inner clearfix">';
	}
	
	if($layout != "fullwidth") {
		echo '<div class="page_inner">';
	}
	
	if (have_posts()) : while (have_posts()) : the_post(); 
	        
		woocommerce_content();
	          
	endwhile; endif; 	     
	
	if($layout != "fullwidth") { 
		echo '</div>';
		get_sidebar();    		
	}
	
	if($page_width != 'fullwidth') {
		echo '</div>';
	}
	
	if($page_links == 'yes') {
		wp_link_pages();
	}
	
	?>

</div>

<?php get_footer(); ?>