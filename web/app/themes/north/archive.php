<?php 
get_header(); 
$layout = 'sidebar_right';

if( north_option( 'archives_layout' ) ) {
	if( north_option( 'archives_layout' ) != 'sidebar_right' ) $layout = north_option( 'archives_layout' );
}

?>

<div class="page-holder blog page-layout-<?php echo $layout; ?>">

	<div class="inner clearfix">	
		
		<?php 		
		
		if($layout != "fullwidth") {
			echo '<div class="page_inner">';
		}
		
		if (have_posts()) : while (have_posts()) : the_post();
		 	
		 	vntd_blog_post_content();
		 	
		endwhile;
		
	    // Archive doesn't exist:
	    else :
	    
	        esc_html__( 'Nothing found, sorry.','north' );
	    
	    endif;	     
    	
    	if($layout != "fullwidth") { 
    		echo '</div>';
    		get_sidebar();    		
    	}
    	
    	?>
    </div>

</div>

<?php get_footer(); ?>