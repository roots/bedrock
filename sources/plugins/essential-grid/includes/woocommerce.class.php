<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();

class Essential_Grid_Woocommerce {

	const ARG_REGULAR_PRICE_FROM = 'reg_price_from';
	const ARG_REGULAR_PRICE_TO = 'reg_price_to';
	const ARG_SALE_PRICE_FROM = 'sale_price_from';
	const ARG_SALE_PRICE_TO = 'sale_price_to';
	const ARG_IN_STOCK_ONLY = 'instock_only';		
	const ARG_FEATURED_ONLY = 'featured_only';		
	
	const META_REGULAR_PRICE = '_regular_price';
	const META_SALE_PRICE = '_sale_price';
	const META_STOCK_STATUS = '_stock_status'; //can be 'instock' or 'outofstock'
	const META_SKU = '_sku'; //can be 'instock' or 'outofstock'
	const META_FEATURED = '_featured'; //can be 'instock' or 'outofstock'
	const META_STOCK = '_stock'; //can be 'instock' or 'outofstock'
	
	
	const SORTBY_NUMSALES = 'meta_num_total_sales';
	const SORTBY_REGULAR_PRICE = 'meta_num__regular_price';
	const SORTBY_SALE_PRICE = 'meta_num__sale_price';
	const SORTBY_FEATURED = 'meta__featured';
	const SORTBY_SKU = 'meta__sku';
	const SORTBY_STOCK = 'meta_num_stock';
	
	
	/**
	 * true / false if the wpml plugin exists
	 */
	public static function is_woo_exists(){
		
		if(class_exists('Woocommerce'))
			return(true);
		else
			return(false);
	}
	
	/**
	 * valdiate that wpml exists
	 */
	private static function validate_woo_exists(){
		if(!self::is_woo_exists())
			Essential_Grid_Base::throw_error(__('The Woocommerce plugin does not exist', EG_TEXTDOMAIN));
	}
	
	
	/**
	 * get wc post types
	 */
	public static function get_custom_post_types(){
	
		$arr = array();
		$arr['product'] = __('Product', EG_TEXTDOMAIN);
		$arr['product_variation'] = __('Product Variation', EG_TEXTDOMAIN);
		
		return(apply_filters('essgrid_wc_get_custom_post_types', $arr));
	}
	
	
	/**
	 * get price query
	 */
	private static function get_price_query($priceFrom, $priceTo, $metaTag){
		
		if(empty($priceFrom))
			$priceFrom = 0;
			
		if(empty($priceTo))
			$priceTo = 9999999999;
		
		$query = array('key' => $metaTag,
					   'value' => array( $priceFrom, $priceTo),
					   'type' => 'numeric',
					   'compare' => 'BETWEEN');
					   
		return(apply_filters('essgrid_wc_get_price_query', $query));
	}
	
	
	/**
	 * get meta query for filtering woocommerce posts. 
	 */
	public static function get_meta_query($args){
		$base = new Essential_Grid_Base();
		
		$regPriceFrom = $base->getVal($args, self::ARG_REGULAR_PRICE_FROM);
		$regPriceTo = $base->getVal($args, self::ARG_REGULAR_PRICE_TO);
		
		$salePriceFrom = $base->getVal($args, self::ARG_SALE_PRICE_FROM);
		$salePriceTo = $base->getVal($args, self::ARG_SALE_PRICE_TO);
		
		$inStockOnly = $base->getVal($args, self::ARG_IN_STOCK_ONLY);
		$featuredOnly = $base->getVal($args, self::ARG_FEATURED_ONLY);
		
		$arrQueries = array();
		
		//get regular price array
		if(!empty($regPriceFrom) || !empty($regPriceTo)){
			$arrQueries[] = self::get_price_query($regPriceFrom, $regPriceTo, self::META_REGULAR_PRICE);
		}
		
		//get sale price array
		if(!empty($salePriceFrom) || !empty($salePriceTo)){
			$arrQueries[] = self::get_price_query($salePriceFrom, $salePriceTo, self::META_SALE_PRICE);
		}
		
		if($inStockOnly == 'true'){
			$query = array( 'key' => self::META_STOCK_STATUS,
							'value' => 'instock');
			$arrQueries[] = $query;
		}
		
		if($featuredOnly == 'true'){
			$query = array( 'key' => self::META_FEATURED,
							'value' => 'yes');
			$arrQueries[] = $query;
		}
		
		
		$query = array();
		if(!empty($arrQueries))
			$query = array('meta_query'=>$arrQueries);
			
		return(apply_filters('essgrid_wc_get_meta_query', $query));		
	}
	
	
	/**
	 * get sortby function including standart wp sortby array
	 */
	public static function get_arr_sort_by(){
		
		$arrSortBy = array();
		$arrSortBy[self::SORTBY_REGULAR_PRICE] = __('Price', EG_TEXTDOMAIN);
		//$arrSortBy[self::SORTBY_SALE_PRICE] = __('Sale Price', EG_TEXTDOMAIN);
		$arrSortBy[self::SORTBY_NUMSALES] = __('Number Of Sales', EG_TEXTDOMAIN);
		$arrSortBy[self::SORTBY_FEATURED] = __('Featured Products', EG_TEXTDOMAIN);
		$arrSortBy[self::SORTBY_SKU] = __('SKU', EG_TEXTDOMAIN);
		$arrSortBy[self::SORTBY_STOCK] = __('Stock Quantity', EG_TEXTDOMAIN);
		
		$arrOutput = array();
		$arrOutput['opt_disabled_1'] = __('---- WooCommerce Filters ----', EG_TEXTDOMAIN);
		$arrOutput = array_merge($arrOutput, $arrSortBy);
		$arrOutput['opt_disabled_2'] = __('---- Regular Filters ----', EG_TEXTDOMAIN);
		
		return(apply_filters('essgrid_wc_get_arr_sort_by', $arrOutput));
	}
	
	
	/**
	 * check if product is on sale
	 */
	public static function check_if_on_sale($post_id){
	
		$product = get_product($post_id);
		
		$is_on_sale = ($product !== false) ? $product->is_on_sale() : false;
		
		return apply_filters('essgrid_wc_check_if_on_sale', $is_on_sale, $post_id);
		
	}
	
	
	/**
	 * check if product is on sale
	 */
	public static function check_if_is_featured($post_id){
	
		$product = get_product($post_id);
		
		$is_featured = ($product !== false) ? $product->is_featured() : false;
		
		return apply_filters('essgrid_wc_check_if_is_featured', $is_featured, $post_id);
		
	}
	
	
	/**
	 * get sortby function including standart wp sortby array
	 */
	public static function get_value_by_meta($post_id, $meta, $separator = ','){
		
		$meta_value = '';
		
		$product = get_product($post_id);
		
		if($product !== false){
			switch($meta){
				case 'wc_price':
					$meta_value = wc_price($product->get_price());
				break;
				case 'wc_price_no_cur':
					$meta_value = $product->get_price();
				break;
				case 'wc_full_price':
					$meta_value = $product->get_price_html();
				break;
				case 'wc_stock':
					$meta_value = $product->get_total_stock();
				break;
				case 'wc_rating':
					$meta_value = $product->get_rating_html();
				break;
				case 'wc_star_rating':
					$cur_rating = $product->get_rating_html();
					if($cur_rating !== '')
						$meta_value = '<div class="esg-starring">'.$cur_rating.'</div>';
				break;
				case 'wc_categories':
					$categories = $product->get_categories($separator);
					$meta_value = $categories;
				break;
				case 'wc_add_to_cart':
					$meta_value = $product->add_to_cart_url();
				break;
				case 'wc_add_to_cart_button': //get whole button from WooCommerce
					$suffix               	= defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
					$ajax_cart_en			= get_option( 'woocommerce_enable_ajax_add_to_cart' ) == 'yes' ? true : false;
					$assets_path          	= str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ) . '/assets/';
					$frontend_script_path 	= $assets_path . 'js/frontend/';
					
					if ( $ajax_cart_en ){
						wp_enqueue_script( 'wc-add-to-cart', $frontend_script_path . 'add-to-cart' . $suffix . '.js', array( 'jquery' ), WC_VERSION, true );
						
						global $wc_is_localized;
						if($wc_is_localized === false){ //load it only one time
							wp_localize_script( 'wc-add-to-cart', 'wc_add_to_cart_params', apply_filters( 'wc_add_to_cart_params', array(
								'ajax_url'                => WC()->ajax_url(),
								'wc_ajax_url'             => WC_AJAX::get_endpoint( "%%endpoint%%" ),
								'ajax_loader_url'         => apply_filters( 'woocommerce_ajax_loader_url', $assets_path . 'images/ajax-loader@2x.gif' ),
								'i18n_view_cart'          => esc_attr__( 'View Cart', 'woocommerce' ),
								'cart_url'                => get_permalink( wc_get_page_id( 'cart' ) ),
								'is_cart'                 => is_cart(),
								'cart_redirect_after_add' => get_option( 'woocommerce_cart_redirect_after_add' )
							) ) );
							$wc_is_localized = true;
						}
					}
					$meta_value = apply_filters( 'woocommerce_loop_add_to_cart_link',
										sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button %s %s product_type_%s">%s</a>',
											esc_url( $product->add_to_cart_url() ),
											esc_attr( $product->id ),
											esc_attr( $product->get_sku() ),
											$product->is_purchasable() ? 'add_to_cart_button' : '',
											$product->is_purchasable() && $ajax_cart_en && esc_attr( $product->product_type ) !="variable" ? 'ajax_add_to_cart' : '',
											esc_attr( $product->product_type ),
											esc_html( $product->add_to_cart_text() )
										),
									$product );
				break;
				default:
					$meta_value = apply_filters('essgrid_woocommerce_meta_content', $meta_value, $meta, $post_id, $product);
				break;
			}
		}
		
		return apply_filters('essgrid_wc_get_value_by_meta', $meta_value, $meta, $post_id, $product);
	}
	
	
	/**
	 * get sortby function including standart wp sortby array
	 */
	public static function get_meta_array(){
		
		$wc_array = array(
					'wc_full_price' => __('Full Price', EG_TEXTDOMAIN),
					'wc_price' => __('Single Price', EG_TEXTDOMAIN),
					'wc_price_no_cur' => __('Single Price without currency', EG_TEXTDOMAIN),
					'wc_stock' => __('In Stock', EG_TEXTDOMAIN),
					'wc_rating' => __('Text Rating', EG_TEXTDOMAIN),
					'wc_star_rating' => __('Star Rating', EG_TEXTDOMAIN),
					'wc_categories' => __('Categories', EG_TEXTDOMAIN),
					'wc_add_to_cart' => __('Add to Cart URL', EG_TEXTDOMAIN),
					'wc_add_to_cart_button' => __('Add to Cart Button', EG_TEXTDOMAIN),
					);
		
		return apply_filters('essgrid_woocommerce_meta_handle', $wc_array);
	}
	
	
	/**
	 * get all attached images
	 * @since: 1.5.4
	 */
	public static function get_image_attachements($post_id, $url = false){
	
		$product = get_product($post_id);
		
		$ret_img = '';
		
		if($product !== false){
			$wc_img = $product->get_gallery_attachment_ids();
			
			if($url){
				$images = array();
				foreach($wc_img as $img){
					$t_img = wp_get_attachment_image_src($img, 'full');
					if($t_img !== false){
						$images[] = $t_img[0];
					}
				}
				$ret_img = $images;
			}else{ //get URL instead of ID
				$ret_img = $wc_img;
			}
		}
		
		return apply_filters('essgrid_wc_get_image_attachements', $ret_img, $post_id, $url);
	}

	/**
	 * update Cart Overview after Ajax call
	 * @since: 2.1.0.2
	 */
	public static function woocommerce_header_add_to_cart_fragment( $fragments ) {
	  global $woocommerce;
	  ob_start();
	  ?>
	  <span class="ess-cart-content"><?php echo $woocommerce->cart->cart_contents_count; ?><?php _e(' items - ', EG_TEXTDOMAIN); ?><span class="woocommerce-Price-amount amount"><?php echo $woocommerce->cart->get_cart_total(); ?></span></span>
	  <?php
	  $fragments['span.ess-cart-content'] = ob_get_clean();
	  return $fragments;
	}
	
}

?>