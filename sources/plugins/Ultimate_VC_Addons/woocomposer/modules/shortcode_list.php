<?php
/*
@Module: List view
@Since: 1.0
@Package: WooComposer
*/
if(!class_exists("WooComposer_ViewList")){
	class WooComposer_ViewList
	{
		function __construct(){
			add_shortcode('woocomposer_list',array($this,'woocomposer_list_shortcode'));
			add_action('admin_init',array($this,'woocomposer_init_grid'));
		} /* end constructor */
		function woocomposer_init_grid(){
			if(function_exists('vc_map')){
				vc_map(
					array(
						"name"		=> __("Product List", "ultimate_vc"),
						"base"		=> "woocomposer_list",
						"icon"		=> "woo_list",
						"class"	   => "woo_list",
						"category"  	=> __("WooComposer [ Beta ]", "ultimate_vc"),
						"description" => __("Display products in list view","ultimate_vc"),
						"controls" => "full",
						"show_settings_on_create" => true,
						"deprecated" => "3.13.5",
						"params" => array(
							array(
								"type" => "woocomposer",
								"class" => "",
								"heading" => __("Query Builder", "ultimate_vc"),
								"param_name" => "shortcode",
								"value" => "",
								"module" => "list",
								"labels" => array(
										"products_from"   => __("Display:","ultimate_vc"),
										"per_page"		=> __("How Many:","ultimate_vc"),
										"columns"		 => __("Columns:","ultimate_vc"),
										"order_by"		=> __("Order By:","ultimate_vc"),
										"order"		   => __("Display Order:","ultimate_vc"),
										"category" 		=> __("Category:","ultimate_vc"),
								),
								//"description" => __("", "woocommerce")
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Image Display", "ultimate_vc"),
								"param_name" => "img_position",
								"admin_label" => true,
								"value" => array(
										__("Left","ultimate_vc") => "left",
										__("Right","ultimate_vc") => "right",
									),
								//"description" => __("", "woocommerce"),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Image Width", "ultimate_vc"),
								"param_name" => "img_size",
								"value" => "",
								"min" => 30,
								"max" => 300,
								"suffix" => "px",
								//"description" => __("", "woocommerce")
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Image Border", "ultimate_vc"),
								"param_name" => "img_border",
								"admin_label" => true,
								"value" => array(
										__("None","ultimate_vc") => "",
										__("Solid","ultimate_vc") => "solid",
										__("Dashed","ultimate_vc") => "dashed",
										__("Dotted","ultimate_vc") => "dotted",
										__("Inset","ultimate_vc") => "inset",
										__("Outset","ultimate_vc") => "outset",
									),
								//"description" => __("", "woocommerce"),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Border Size", "ultimate_vc"),
								"param_name" => "border_size",
								"value" => "",
								"min" => 0,
								"max" => 10,
								"suffix" => "px",
								//"description" => __("", "woocommerce"),
								"dependency" => Array("element" => "img_border", "not_empty" => true),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Border Radius", "ultimate_vc"),
								"param_name" => "border_radius",
								"value" => "",
								"min" => 0,
								"max" => 500,
								"suffix" => "px",
								//"description" => __("", "woocommerce"),
								"dependency" => Array("element" => "img_border", "not_empty" => true),							
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Border Color", "ultimate_vc"),
								"param_name" => "border_color",
								"value" => "",
								//"description" => __("", "woocommerce"),
								"dependency" => Array("element" => "img_border", "not_empty" => true),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Product Title Font Size", "ultimate_vc"),
								"param_name" => "title_font",
								"value" => "",
								"min" => 10,
								"max" => 72,
								"suffix" => "px",
								//"description" => __("", "woocommerce"),			
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Product Title Color", "ultimate_vc"),
								"param_name" => "title_color",
								"value" => "",
								//"description" => __("", "woocommerce"),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Product Price Font Size", "ultimate_vc"),
								"param_name" => "price_font",
								"value" => "",
								"min" => 10,
								"max" => 72,
								"suffix" => "px",
								//"description" => __("", "woocommerce"),			
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Product Price Color", "ultimate_vc"),
								"param_name" => "price_color",
								"value" => "",
								//"description" => __("", "woocommerce"),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Star Rating Font Size", "ultimate_vc"),
								"param_name" => "rating_font",
								"value" => "",
								"min" => 10,
								"max" => 72,
								"suffix" => "px",
								//"description" => __("", "woocommerce"),			
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Star Ratings Color", "ultimate_vc"),
								"param_name" => "rating_color",
								"value" => "",
								//"description" => __("", "woocommerce"),
							),
						)/* vc_map params array */
					)/* vc_map parent array */ 
				); /* vc_map call */ 
			} /* vc_map function check */
		} /* end woocomposer_init_grid */
		function woocomposer_list_shortcode($atts){
			global $woocommerce;
			$img_position = $img_size = $img_border = $border_size = $border_radius = $border_color = $title_font = $price_font = $price_color = $rating_color = $rating_font = $shortcode = '';
			extract(shortcode_atts(array(
				"img_position" => "left",
				"shortcode" => "",
				"img_size" => "",
				"img_border" => "",
				"border_size" => "",
				"border_radius" => "",
				"border_color" => "",
				"title_color" => "",
				"title_font" => "",
				"price_font" => "",
				"price_color" => "",
				"rating_color" => "",
				"rating_font" => "",
			),$atts));
			$output = $on_sale = $style = $title_style = $pricing_style = $rating_style = '';
			if($img_size !== ""){
				$style .= 'width:'.$img_size.'px; height:'.$img_size.'px;';
			}
			if($title_color !== ""){
				$title_style .= 'color:'.$title_color.';';
			}
			if($title_font !== ""){
				$title_style .= 'font-size:'.$title_font.'px;';
			}
			
			if($img_border !== ''){
				$style .= 'border-style:'.$img_border.';';
				if($border_size !== ''){
					$style .= 'border-width:'.$border_size.'px;';					
				}
				if($border_color !== ''){
					$style .= 'border-color:'.$border_color.';';					
				}
				if($border_radius !== ''){
					$style .= 'border-radius:'.$border_radius.'px;';					
				}
			}
			if($price_font !== ""){
				$pricing_style .= 'font-size:'.$price_font.'px;';
			}
			if($price_color !== ""){
				$pricing_style .= 'color:'.$price_color.';';
			}
			if($rating_color !== ""){
				$rating_style .= 'color:'.$rating_color.';';
			}			
			if($rating_font !== ""){
				$rating_style .= 'font-size:'.$rating_font.'px;';
			}	
			$post_count = '12';
			$output .= '<div class="woocomposer_list woocommerce">';
			/* $output .= do_shortcode($content); */
			$pattern = get_shortcode_regex();
			if($shortcode !== ''){
				$new_shortcode = rawurldecode( base64_decode( strip_tags( $shortcode ) ) );
			}
			preg_match_all("/".$pattern."/",$new_shortcode,$matches);
			$shortcode_str = str_replace('"','',str_replace(" ","&",trim($matches[3][0])));
			$short_atts = parse_str($shortcode_str);//explode("&",$shortcode_str);
			if(isset($matches[2][0])): $display_type = $matches[2][0]; else: $display_type = ''; endif;
			if(!isset($columns)): $columns = '4'; endif;
			if(isset($per_page)): $post_count = $per_page; endif;
			if(isset($number)): $post_count = $number; endif;
			if(!isset($order)): $order = 'ASC'; endif;
			if(!isset($orderby)): $orderby = 'date'; endif;
			if(!isset($category)): $category = ''; endif;
			if(!isset($ids)): $ids = ''; endif;
			if($ids){
				$ids = explode( ',', $ids );
				$ids = array_map( 'trim', $ids );
			}
			
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
			$query = new WP_Query( $args );
			$output .= '<ul class="wcmp-product-list wcmp-img-'.$img_position.' '.$order.'">';
			if($query->have_posts()):
				while ( $query->have_posts() ) : $query->the_post();
					$product_id = get_the_ID();
					$post = get_post($product_id);
					$product_title = get_the_title();
					
					$product = new WC_Product( $product_id );
					$attachment_ids = $product->get_gallery_attachment_ids();
					$price = $product->get_price_html();
					$rating = $product->get_rating_html();
					$product_var = new WC_Product_Variable( $product_id );
					$available_variations = $product_var->get_available_variations();
				
						$output .= '<li>';
						
							$output .= '<a href="'.get_permalink($product_id).'">';
							$product_img = wp_get_attachment_image_src( get_post_thumbnail_id($product_id),'full');
							$output .= '<img style="'.$style.'" src="'.$product_img[0].'"/>';
							$output .= '<span style="'.$title_style.'">'.$product_title.'</span>';							
							$output .= '</a>';
							if($display_type == "top_rated_products"){						
								$output .= '<div style="'.$rating_style.'">'.$rating.'</div>';
							}					
							$output .= '<span class="amount" style="'.$pricing_style.'">'.$price.'</span>';
					$output .= '</li>';
				endwhile;
			endif;
			$output .= "\n".'</ul>';
			$output .= "\n".'</div>';
			if($display_type == "top_rated_products"){
				remove_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
			}
			wp_reset_postdata();
			return $output;
		}/* end woocomposer_list_shortcode */
	}
	new WooComposer_ViewList;
}
if(class_exists('WPBakeryShortCode'))
{
	class WPBakeryShortCode_woocomposer_list extends WPBakeryShortCode {
	}
}
