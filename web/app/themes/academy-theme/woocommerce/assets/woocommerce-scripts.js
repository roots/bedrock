/*
 * ---------------------------------------------------------------- 
 *  
 *  WooCommerce custom javascripts
 *  
 * ----------------------------------------------------------------  
 */


jQuery(document).ready(function($) {

	add_to_cart_action();
	add_to_cart_data();
	
	jQuery('#woo-nav-cart').on('hover', function() {
		jQuery(this).find('i').removeClass('added');
		jQuery(this).find('pulsed').removeClass('pulse-now');
	});
	
	
    if(jQuery('#woo-nav-cart').length !== 0) {
    	jQuery('#woo-nav-cart').hover(function() {
    		jQuery('#woo-nav-cart .nav-cart-products').stop().fadeIn();
    	}, function() {
    		jQuery('#woo-nav-cart .nav-cart-products').stop().fadeOut();
    	});
    }
	
});

var currentItem = '';
var count;
function add_to_cart_action() {
	
	jQuery('body').bind('added_to_cart', function()
	{
		
		jQuery('#woo-nav-cart i').addClass('added');
		
		var pulsar = jQuery('#woo-nav-cart .pulsed');
		var newPulsar = pulsar.clone(true);
		
		pulsar.replaceWith(newPulsar);
		
		jQuery('#woo-nav-cart .pulsed').removeClass('pulse-now').addClass('pulse-now');

	});
	
}

var newWooProduct = {};
function add_to_cart_data()
{
	jQuery('body').on('click','.add_to_cart_button', function()
	{	

		var productContainer	= jQuery(this).parents('.product').eq(0), product = {};
			product.name		= productContainer.find('h3').text();
			product.img		 	= productContainer.find('.product-thumbnail img.wp-post-imag');
			product.price	 	= productContainer.find('.price .amount').last().text().replace(/[^0-9\.]+/g, '');
			
			newWooProduct = product;

	});
}