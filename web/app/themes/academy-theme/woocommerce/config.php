<?php 

function woocommerce_init_settings()
{
	$catalog = array(
		'width' 	=> '300',	// px
		'height'	=> '360',	// px
		'crop'		=> 1 		// true
	);
 
	$single = array(
		'width' 	=> '600',	// px
		'height'	=> '',	// px
		'crop'		=> 1 		// true
	);
 
	$thumbnail = array(
		'width' 	=> '120',	// px
		'height'	=> '120',	// px
		'crop'		=> 0 		// false
	);
 
	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
	
	wp_register_script('woo-js', get_template_directory_uri() . '/woocommerce/assets/woocommerce-scripts.js', array('jquery'));			
	wp_enqueue_script('woo-js', '', '', '', true);
	
	wp_register_style('woocommerce-custom', get_template_directory_uri() . '/woocommerce/assets/woocommerce-styling.css', array('woocommerce-general', 'woocommerce-layout'));
	
	wp_enqueue_style('woocommerce-custom');
}

add_action('init', 'woocommerce_init_settings', 1);

add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 999; // 3 products per row
	}
}
//
//remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
//remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
//remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

add_action('woocommerce_before_shop_loop_item_title', 'vntd_woocommerce_loop_thumbnail', 10);

function vntd_woocommerce_loop_thumbnail() {
	echo '<div class="product-thumbnail-wrap">';
	woocommerce_template_loop_product_thumbnail();
	echo '<div class="product-overlay-add">';
	woocommerce_template_loop_add_to_cart();
	echo '</div></div>';
}

//
// Nav Cart
//

function vntd_woo_nav_cart() {
	global $woocommerce;

	$cart_count = $woocommerce->cart->get_cart_contents_count();
	if($cart_count == 0) $inactive = ' nav-cart-inactive'; ?>

	<div id="woo-nav-cart" class="nav-cart<?php echo $inactive; ?>">
		<div class="nav-cart-content">
			<div class="pulsed"></div>
			<i class="fa fa-shopping-cart"></i>
			<span class="woo-cart-count"><?php echo $cart_count; ?></span>
		</div>
		<div class="nav-cart-products">
			<div class="widget_shopping_cart"><div class="widget_shopping_cart_content"></div></div>				
		</div>
	</div>

<?php 
}

// Related Products

function woo_related_products_limit() {
  global $product;
	
	$args['posts_per_page'] = 6;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args' );
  function jk_related_products_args( $args ) {

	$args['posts_per_page'] = 4; // 4 related products
	$args['columns'] = 4; // arranged in 2 columns
	return $args;
}

add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );
