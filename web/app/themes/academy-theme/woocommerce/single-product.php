<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); 

$layout = 'fullwidth';
$page_width = 'content';

?>

<div class="page-holder page-layout-<?php echo $layout; ?>">
		
	<?php 		
	
	if($page_width != 'fullwidth') {
		echo '<div class="inner clearfix">';
	}
	
	if($layout != "fullwidth") {
		echo '<div class="page_inner">';
	}
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */


if($layout != "fullwidth") { 
	echo '</div>';
	get_sidebar();  		
}

if($page_width != 'fullwidth') {
	echo '</div>';
}

?>

</div>

<?php

get_footer( 'shop' ); ?>

