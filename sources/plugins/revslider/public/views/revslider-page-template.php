<?php
/**
 * Template Name: Slider Revolution Blank Template
 * The template for displaying RevSlider on a blank page
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div>
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			echo do_shortcode( get_the_content() );

		// End the loop.
		endwhile;
		?>
</div>
<?php wp_footer(); ?>

</body>
</html>

