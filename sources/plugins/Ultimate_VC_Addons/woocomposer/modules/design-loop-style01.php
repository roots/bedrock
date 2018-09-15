<?php
function WooComposer_Loop_style01($atts,$element){
	global $woocommerce;
	$product_style = $display_elements = $quick_view_style = $img_animate = $text_align = $color_heading = $color_categories = $color_price = '';
	$color_rating = $color_rating_bg = $color_quick_bg = $color_quick = $color_cart_bg = $color_cart = $color_product_desc = $advanced_opts = '';
	$color_product_desc_bg = $size_title = $size_cat = $size_price = $color_on_sale = $color_on_sale_bg = $label_on_sale = $product_animation = '';
	$disp_type = $category = $output = $product_style = $border_style = $border_color = $border_size = $border_radius = $lazy_images = $pagination = '';
	$sale_price = $shortcode = $on_sale_alignment = $on_sale_style = $product_img_disp = '';
	extract(shortcode_atts(array(
		"disp_type" => "",
		"category" => "",
		"shortcode" => "",
		"product_style" => "style01",
		"display_elements" => "",
		"quick_view_style" => "expandable",
		"label_on_sale" => "Sale!",
		"text_align" => "left",
		"img_animate" => "rotate-clock",
		"pagination" => "",
		"color_heading" => "",
		"color_categories" => "",
		"color_price" => "",
		"color_rating" => "",
		"color_rating_bg" => "",
		"color_quick_bg" => "",
		"color_quick" => "",
		"color_cart_bg" => "",
		"color_on_sale_bg" => "",
		"color_on_sale" => "",
		"color_cart" => "",
		"color_product_desc" => "",
		"color_product_desc_bg" => "",
		"size_title" => "",
		"size_cat" => "",
		"size_price" => "",
		"border_style" => "",
		"border_color" => "",
		"border_size" => "",
		"border_radius" => "",
		"product_animation" => "",
		"lazy_images" => "",
		"advanced_opts" => "",
		"sale_price" => "",
		"on_sale_style" => "wcmp-sale-circle",
		"on_sale_alignment" => "wcmp-sale-right",
		"product_img_disp" => "single",
	),$atts));
	$output = $heading_style = $cat_style = $price_style = $cart_style = $cart_bg_style = $view_style = $view_bg_style = $rating_style = '';
	$desc_style = $label_style = $on_sale = $class = $style = $border = $desc_style = $sale_price_size = $text_align_style = '';
	$image_size = apply_filters( 'single_product_large_thumbnail_size', 'shop_single' );
	$img_animate = 'wcmp-img-'.$img_animate;
	if($sale_price !== ''){
		$sale_price_size = 'font-size:'.$sale_price.'px;';
	}
	if($border_style !== ''){
		$border .= 'border:'.$border_size.'px '.$border_style.' '.$border_color.';';
		$border .= 'border-radius:'.$border_radius.'px;';
	}
	if($color_product_desc_bg !== ''){
		$desc_style .= 'background:'.$color_product_desc_bg.';';
	}
	if($color_product_desc !== ''){
		$desc_style .= 'color:'.$color_product_desc.';';
	}
	$columns = 3;
	$display_type = $disp_type;
	if($color_heading !== ""){
		$heading_style = 'color:'.$color_heading.';';
	}
	if($size_title !== ""){
		$heading_style .= 'font-size:'.$size_title.'px;';
	}
	if($color_categories !== ""){
		$cat_style = 'color:'.$color_categories.';';
	}
	if($size_cat !== ""){
		$cat_style .= 'font-size:'.$size_cat.'px;';
	}
	if($color_price !== ""){
		$price_style = 'color:'.$color_price.';';
	}
	if($size_price !== ""){
		$price_style .= 'font-size:'.$size_price.'px;';
	}
	if($color_rating !== ""){
		$rating_style .= 'color:'.$color_rating.';';
	}
	if($color_rating_bg !== ""){
		$rating_style .= 'background:'.$color_rating_bg.';';
	}
	if($color_quick_bg !== ""){
		$view_bg_style = 'background:'.$color_quick_bg.';';
	}
	if($color_quick !== ""){
		$view_style = 'color:'.$color_quick.';';
	}
	if($color_cart_bg !== ""){
		$cart_bg_style = 'background:'.$color_cart_bg.';';
	}
	if($color_cart !== ""){
		$cart_style = 'color:'.$color_cart.';';
	}
	if($color_on_sale_bg !== ""){
		$label_style = 'background:'.$color_on_sale_bg.';';
	}
	if($color_on_sale !== ""){
		$label_style .= 'color:'.$color_on_sale.';';
	}
	$elemets = explode(",",$display_elements);
	if($element == "grid"){
		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	} else {
		$paged = 1;
	}
	$post_count = '12';
	/* $output .= do_shortcode($content); */
	if($shortcode !== ''){
		$new_shortcode = rawurldecode( base64_decode( strip_tags( $shortcode ) ) );
	}
	$pattern = get_shortcode_regex();
	$shortcode_str = $short_atts = '';
	preg_match_all("/".$pattern."/",$new_shortcode,$matches);
	$shortcode_str = str_replace('"','',str_replace(" ","&",trim($matches[3][0])));
	$short_atts = parse_str($shortcode_str);//explode("&",$shortcode_str);
	if(isset($matches[2][0])): $display_type = $matches[2][0]; else: $display_type = ''; endif;
	if(!isset($columns)): $columns = '4'; endif;
	if(isset($per_page)): $post_count = $per_page; endif;
	if(isset($number)): $post_count = $number; endif;
	if(!isset($order)): $order = 'asc'; endif;
	if(!isset($orderby)): $orderby = 'date'; endif;
	if(!isset($category)): $category = ''; endif;
	if(!isset($ids)): $ids = ''; endif;
	if($ids){
		$ids = explode( ',', $ids );
		$ids = array_map( 'trim', $ids );
	}
	$col = $columns;
	if($columns == "2") $columns = 6;
	elseif($columns == "3") $columns = 4;
	elseif($columns == "4") $columns = 3;
	$meta_query = '';
	if($display_type == "recent_products"){
		$meta_query = WC()->query->get_meta_query();
	}
	if($display_type == "featured_products"){
		$meta_query = array(
			array(
				'key' 		=> '_visibility',
				'value' 	  => array('catalog', 'visible'),
				'compare'	=> 'IN'
			),
			array(
				'key' 		=> '_featured',
				'value' 	  => 'yes'
			)
		);
	}
	if($display_type == "top_rated_products"){
		add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
		$meta_query = WC()->query->get_meta_query();
	}
	$args = array(
		'post_type'			=> 'product',
		'post_status'		  => 'publish',
		'ignore_sticky_posts'  => 1,
		'posts_per_page' 	   => $post_count,
		'orderby' 			  => $orderby,
		'order' 				=> $order,
		'paged' 				=> $paged,
		'meta_query' 		   => $meta_query
	);
	if($display_type == "sale_products"){
		$product_ids_on_sale = woocommerce_get_product_ids_on_sale();
		$meta_query = array();
		$meta_query[] = $woocommerce->query->visibility_meta_query();
	    $meta_query[] = $woocommerce->query->stock_status_meta_query();
		$args['meta_query'] = $meta_query;
		$args['post__in'] = $product_ids_on_sale;
	}
	if($display_type == "best_selling_products"){
		$args['meta_key'] = 'total_sales';
		$args['orderby'] = 'meta_value_num';
		$args['meta_query'] = array(
				array(
					'key' 		=> '_visibility',
					'value' 	=> array( 'catalog', 'visible' ),
					'compare' 	=> 'IN'
				)
			);
	}
	if($display_type == "product_category"){
		$args['tax_query'] = array(
			array(
				'taxonomy' 	 => 'product_cat',
				'terms' 		=> array( esc_attr( $category ) ),
				'field' 		=> 'slug',
				'operator' 	 => 'IN'
			)
		);
	}
	if($display_type == "product_categories"){
		$args['tax_query'] = array(
			array(
				'taxonomy' 	 => 'product_cat',
				'terms' 		=> $ids,
				'field' 		=> 'term_id',
				'operator' 	 => 'IN'
			)
		);
	}
	$test = '';
	if(vc_is_inline()){
		$test = "wcmp_vc_inline";
	}
	if($product_animation == ''){
		$product_animation = 'no-animation';
	} else {
		$style .= 'opacity:1;';
	}
	if($element == "grid"){
		$class = 'vc_span'.$columns.' ';
	}
	$output .= '<div class="woocomposer '.$test.'" data-columns="'.$col.'">';
	$query = new WP_Query( $args );
	if($query->have_posts()):
		while ( $query->have_posts() ) : $query->the_post();
			$product_id = get_the_ID();
			$uid = uniqid();
			$output .= '<div id="product-'.$uid.'" style="'.$style.'" class="'.$class.' wpb_column column_container wooproduct" data-animation="animated '.$product_animation.'">';
			if($element == 'carousel'){
				$output .= '<div class="wcmp-carousel-item">';
			}
			$product_title = get_the_title($product_id);
			$post = get_post($product_id);
			$product_desc = get_post($product_id)->post_excerpt;
			$product_img = wp_get_attachment_image_src( get_post_thumbnail_id($product_id),$image_size);
			$product = new WC_Product( $product_id );
			$attachment_ids = $product->get_gallery_attachment_ids();
			$price = $product->get_price_html();
			$rating = $product->get_rating_html();
			$attributes = $product->get_attributes();
			$stock = $product->is_in_stock() ? 'InStock' : 'OutOfStock';
			if ( $product->is_on_sale() ) :
				$on_sale = apply_filters( 'woocommerce_sale_flash', $label_on_sale , $post, $product );
			else:
				$on_sale = '';
			endif;
			if($quick_view_style == "expandable"){
				$quick_view_class = 'quick-view-loop';
			} else {
				$quick_view_class = 'quick-view-loop-popup';
			}
			$cat_count = sizeof( get_the_terms( $product_id, 'product_cat' ) );
			$tag_count = sizeof( get_the_terms( $product_id, 'product_tag' ) );
			$categories = $product->get_categories(', ','<span class="posted_in">'._n('','',$cat_count,'woocommerce').' ','.</span>');
			$tags = $product->get_tags( ', ','<span class="tagged_as">'._n('', '',$tag_count, 'woocommerce').' ', '.</span>' );
			$output .= "\n".'<div class="wcmp-product woocommerce wcmp-'.$product_style.' '.$img_animate.'" style="'.$border.' '.$desc_style.'">';
				$output .= "\n\t".'<div class="wcmp-product-image">';
					if(empty($attachment_ids) && count($attachment_ids) > 1 && $product_img_disp == "carousel"){
						$uniqid = uniqid();
						$output .= '<div class="wcmp-single-image-carousel carousel-in-loop">';
						$product_img = wp_get_attachment_image_src( get_post_thumbnail_id($product_id),$image_size);
						if($lazy_images == "enable"){
							$src = plugins_url('../assets/img/loader.gif',__FILE__);
						} else {
							$src = $product_img[0];
						}
						$output .= '<div><div class="wcmp-image"><img class="wcmp-img" src="'.$src.'" data-src="'.$product_img[0].'"/></div></div>';
						foreach($attachment_ids as $attachment_id){
							$product_img = wp_get_attachment_image_src( $attachment_id,$image_size);
							if($lazy_images == "enable"){
								$src = plugins_url('../assets/img/loader.gif',__FILE__);
							} else {
								$src = $product_img[0];
							}
							$output .= '<div><div class="wcmp-image"><img class="wcmp-img" src="'.$src.'" data-src="'.$product_img[0].'"/></div></div>';
						}
						$output .= '</div>';
					} else {
						$product_img = wp_get_attachment_image_src( get_post_thumbnail_id($product_id),$image_size);
						if($lazy_images == "enable"){
							$src = plugins_url('../assets/img/loader.gif',__FILE__);
						} else {
							$src = $product_img[0];
						}
						$output .= '<a href="'.get_permalink($product_id).'"><img class="wcmp-img" src="'.$src.'" data-src="'.$product_img[0].'"/></a>';
					}
					if($stock == 'OutOfStock'){
						$output .= "\n".'<span class="wcmp-out-stock">'.__('Out Of Stock!','woocomposer').'</span>';							
					}
					if($on_sale !== ''){
						$output .= "\n".'<div class="wcmp-onsale '.$on_sale_alignment.' '.$on_sale_style.'"><span class="onsale" style="'.$label_style.' '.$sale_price_size.'">'.$on_sale.'</span></div>';
					}
					$output .= '<div class="wcmp-add-to-cart" style="'.$cart_bg_style.'"><a style="'.$cart_style.'" title="Add to Cart" href="?add-to-cart='.$product_id.'" rel="nofollow" data-product_id="'.$product_id.'" data-product_sku="" class="add_to_cart_button product_type_simple"><i class="wooicon-cart4"></i></a></div>';
					if(in_array("quick",$elemets)){
						$output .= '<div class="wcmp-quick-view '.$quick_view_class.'" style="'.$view_bg_style.'"><a style="'.$view_style.'" title="Quick View" href="'.get_permalink($product_id).'"><i class="wooicon-plus32"></i></a></div>';
					}
					if(in_array("reviews",$elemets)){
						$output .= "\n".'<div class="wcmp-star-ratings" style="'.$rating_style.'">'.$rating.'</div>';
					}
				$output .= '</div>';
				if($text_align !== ''){
					$text_align_style = 'text-align:'.$text_align.';';
				}
				$output .= "\n\t".'<div class="wcmp-product-desc" style="'.$text_align_style.'">';
					$output .= '<a href="'.get_permalink($product_id).'">';
					$output .= "\n\t\t".'<h2 style="'.$heading_style.'">'.$product_title.'</h2>';
					$output .= '</a>';
					if(in_array("category",$elemets)){
						$output .= '<h5 style="'.$cat_style.'">';
						if($categories !== ''){
							$output .= $categories;
							$output .= $tags;
						}
						$output .= '</h5>';
					}
					$output .= "\n\t\t".'<div class="wcmp-price"><span class="price" style="'.$price_style.'">'.$price.'</span></div>';
					if(in_array("description",$elemets)){
						$output .= "\n\t\t".'<div class="wcmp-product-content" style="'.$desc_style.'">'.$product_desc.'</div>';
					}
				$output .= "\n\t".'</div>';
			$output .= "\n\t".'</div>';
			if(in_array("quick",$elemets)){
				$output .= '<div class="wcmp-quick-view-wrapper" data-columns="'.$col.'">';
					if($quick_view_style !== "expandable"){
						$output .= '<div class="wcmp-quick-view-wrapper woocommerce product">';
						$output .= '<div class="wcmp-close-single"><i class="wooicon-cross2"></i></div>';
					}
					if(!empty($attachment_ids) && count($attachment_ids) > 1){
						$uniqid = uniqid();
						$output .= '<div class="slider wcmp-image-carousel wcmp-carousel-'.$uniqid.'" data-class="wcmp-carousel-'.$uniqid.'">';
						foreach($attachment_ids as $attachment_id){
							$product_img = wp_get_attachment_image_src( $attachment_id,$image_size);
							if($lazy_images == "enable"){
								$src = plugins_url('../assets/img/loader.gif',__FILE__);
							} else {
								$src = $product_img[0];
							}
							$output .= '<div><div class="wcmp-image"><img class="wcmp-img" src="'.$src.'" data-src="'.$product_img[0].'"/></div></div>';
						}
						$output .= '</div>';
					} else {
						$product_img = wp_get_attachment_image_src( get_post_thumbnail_id($product_id),$image_size);
						if($lazy_images == "enable"){
							$src = plugins_url('../assets/img/loader.gif',__FILE__);
						} else {
							$src = $product_img[0];
						}
						$output .= '<div class="wcmp-single-image wcmp-quickview-img images"><img class="wcmp-img" src="'.$src.'" data-src="'.$product_img[0].'"/></div>';
					}
					if($quick_view_style !== "expandable"){
						$output .= '<div class="wcmp-product-content-single">';
					} else {
						$output .= '<div class="wcmp-product-content">';					
					}
					ob_start();
					do_action( 'woocommerce_single_product_summary' );
					$output .= ob_get_clean();
					
					$output .= '</div>';
					$output .= '<div class="clear"></div>';
					if($quick_view_style !== "expandable"){	
						$output .= '</div>';
					}
				$output .= '</div>';
			}
			$output .= "\n".'</div>';
		if($element == 'carousel'){
			$output .= "\n\t".'</div>';
		}
		endwhile;
	endif;
	if($pagination == "enable"){
		$output .= '<div class="wcmp-paginate">';
		$output .= woocomposer_pagination($query->max_num_pages);
		$output .= '</div>';
	}
	$output .= '</div>';
	if($display_type == "top_rated_products"){
		remove_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
	}
	wp_reset_postdata();
	return $output;
}