<?php 
$post = $wp_query->post;
get_header();
$page_width = get_post_meta($post->ID, 'page_width', true);

if(!$page_width) $page_width == 'fullwidth';
?>

<div class="single-post single-team-post page-holder">
		
	<?php 		
	
	if($page_width != 'fullwidth') {
		echo '<div class="inner clearfix">';
	}
	
	echo do_shortcode('[services_carousel]');
	
	if($page_width != 'fullwidth') {
		echo '</div>';
	}
	
	?>

</div>

<?php get_footer(); ?>