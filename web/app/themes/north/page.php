<?php 
$post = $wp_query->post;
get_header(); 
$layout = get_post_meta(vntd_get_id(), 'page_layout', true);
$page_width = get_post_meta(vntd_get_id(), 'page_width', true);
if(!$page_width) $page_width = 'content';
$page_links = '';
?>

<div class="page-holder page-layout-<?php echo $layout; ?>">
		
	<?php 		
	
	if( $page_width != 'fullwidth' || $layout == 'fullwidth' && ( !north_vc_active() || north_option( 'vntd_vc_default' ) == true ) ) {
		echo '<div class="inner clearfix">';
	}
	
	if( $layout != "fullwidth"  ) {
		echo '<div class="page_inner">';
	}
	
	if (have_posts()) : while (have_posts()) : the_post(); 
	        
		the_content(); 
	          
	endwhile; endif; 	     
	
	if( $layout != "fullwidth" ) { 
		echo '</div>';
		get_sidebar();    		
	}
	
	if( $page_width != 'fullwidth' || $layout == 'fullwidth' && ( !north_vc_active() || north_option( 'vntd_vc_default' ) == true ) ) {
		echo '</div>';
	}
	
	if( $page_links == 'yes') {
		wp_link_pages();
	}
	
	?>

</div>

<?php get_footer(); ?>