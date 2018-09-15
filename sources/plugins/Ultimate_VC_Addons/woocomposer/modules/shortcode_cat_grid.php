<?php
/*
@Module: Category Grid Layout
@Since: 1.0
@Package: WooComposer
*/
if(!class_exists('WooComposer_Cat_Grid')){
	class WooComposer_Cat_Grid
	{
		function __construct(){
			add_action('admin_init',array($this,'woocomposer_init_grid'));
			add_shortcode('woocomposer_grid_cat',array($this,'woocomposer_grid_shortcode'));
		} /* end constructor */
		function woocomposer_init_grid(){
			if(function_exists('vc_map')){
				$orderby_arr = array(
					"Date" => "date",
					"Title" => "title",
					"Product ID" => "ID",
					"Name" => "name",
					"Price" => "price",
					"Sales" => "sales",
					"Random" => "rand",
				);
				vc_map(
					array(
						"name"		=> __("Categories Grid", "ultimate_vc"),
						"base"		=> "woocomposer_grid_cat",
						"icon"		=> "woo_grid",
						"class"	   => "woo_grid",
						"category"  => __("WooComposer [ Beta ]", "ultimate_vc"),
						"description" => __("Display categories in grid view","ultimate_vc"),
						"controls" => "full",
						"wrapper_class" => "clearfix",
						"deprecated" => "3.13.5",
						"show_settings_on_create" => true,
						"params" => array(
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Number of Categories", "ultimate_vc"),
								"param_name" => "number",
								"value" => "",
								"min" => 1,
								"max" => 500,
								"suffix" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Number of Columns", "ultimate_vc"),
								"param_name" => "columns",
								"value" => "",
								"min" => 1,
								"max" => 4,
								"suffix" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Orderby", "ultimate_vc"),
								"param_name" => "orderby",
								"admin_label" => true,
								"value" => $orderby_arr,
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Order", "ultimate_vc"),
								"param_name" => "order",
								"admin_label" => true,
								"value" =>  array(
										__("Asending","ultimate_vc") => "asc",
										__("Desending","ultimate_vc") => "desc",
									),
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "ult_switch",
								"class" => "",
								"heading" => __("Options", "ultimate_vc"),
								"param_name" => "options",
								"admin_label" => true,
								"value" => "",
								"options" => array(
										"hide_empty" => array(
													"label" => __("Hide empty categories","ultimate_vc"),
													"on" => __("Yes","ultimate_vc"),
													"off" => __("No","ultimate_vc"),
												),
										"parent" => array(
													"label" => __("Display Child Categories if availabe in the loop","ultimate_vc"),
													"on" => __("Yes","ultimate_vc"),
													"off" => __("No","ultimate_vc"),
												),
										"sel_cat" => array(
													"label" => __("Select custom categories to display","ultimate_vc"),
													"on" => __("Yes","ultimate_vc"),
													"off" => __("No","ultimate_vc"),
												),
									),
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "product_categories",
								"class" => "",
								"heading" => __("Select Categories", "ultimate_vc"),
								"param_name" => "ids",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Category count text", "ultimate_vc"),
								"param_name" => "cat_count",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Design Style", "ultimate_vc"),
								"param_name" => "design_style",
								"admin_label" => true,
								"value" => array(
										__("Style 1","ultimate_vc") => "style01",
										__("Style 2","ultimate_vc") => "style02",
										__("Style 3","ultimate_vc") => "style03",
									),
								//"description" => __("", "woocomposer"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Text Alignment", "ultimate_vc"),
								"param_name" => "text_align",
								"value" => array(
									__("Left","ultimate_vc")=> "left",
									__("Center","ultimate_vc")=> "center",
									__("Right","ultimate_vc") => "right",
								),
								//"description" => __("","smile"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Product Border Style", "ultimate_vc"),
								"param_name" => "border_style",
								"value" => array(
									__("None","ultimate_vc")=> "",
									__("Solid","ultimate_vc")=> "solid",
									__("Dashed","ultimate_vc") => "dashed",
									__("Dotted","ultimate_vc") => "dotted",
									__("Double","ultimate_vc") => "double",
									__("Inset","ultimate_vc") => "inset",
									__("Outset","ultimate_vc") => "outset",
								),
								//"description" => __("","smile"),
								"group" => "Initial Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Border Color", "ultimate_vc"),
								"param_name" => "border_color",
								"value" => "#333333",
								//"description" => __("", "woocomposer"),	
								"dependency" => Array("element" => "border_style", "not_empty" => true),
								"group" => "Initial Settings",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Border Size", "ultimate_vc"),
								"param_name" => "border_size",
								"value" => 1,
								"min" => 1,
								"max" => 10,
								"suffix" => "px",
								//"description" => __("", "woocomposer"),
								"dependency" => Array("element" => "border_style", "not_empty" => true),
								"group" => "Initial Settings",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Border Radius", "ultimate_vc"),
								"param_name" => "border_radius",
								"value" => 5,
								"min" => 1,
								"max" => 500,
								"suffix" => "px",
								//"description" => __("", "woocomposer"),
								"dependency" => Array("element" => "border_style", "not_empty" => true),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Animation","ultimate_vc"),
								"param_name" => "product_animation",
								"value" => array(
							 		__("No Animation","ultimate_vc") => "",
									__("Swing","ultimate_vc") => "swing",
									__("Pulse","ultimate_vc") => "pulse",
									__("Fade In","ultimate_vc") => "fadeIn",
									__("Fade In Up","ultimate_vc") => "fadeInUp",
									__("Fade In Down","ultimate_vc") => "fadeInDown",
									__("Fade In Left","ultimate_vc") => "fadeInLeft",
									__("Fade In Right","ultimate_vc") => "fadeInRight",
									__("Fade In Up Long","ultimate_vc") => "fadeInUpBig",
									__("Fade In Down Long","ultimate_vc") => "fadeInDownBig",
									__("Fade In Left Long","ultimate_vc") => "fadeInLeftBig",
									__("Fade In Right Long","ultimate_vc") => "fadeInRightBig",
									__("Slide In Down","ultimate_vc") => "slideInDown",
									__("Slide In Left","ultimate_vc") => "slideInLeft",
									__("Slide In Left","ultimate_vc") => "slideInLeft",
									__("Bounce In","ultimate_vc") => "bounceIn",
									__("Bounce In Up","ultimate_vc") => "bounceInUp",
									__("Bounce In Down","ultimate_vc") => "bounceInDown",
									__("Bounce In Left","ultimate_vc") => "bounceInLeft",
									__("Bounce In Right","ultimate_vc") => "bounceInRight",
									__("Rotate In","ultimate_vc") => "rotateIn",
									__("Light Speed In","ultimate_vc") => "lightSpeedIn",
									__("Roll In","ultimate_vc") => "rollIn",
									),
								//"description" => __("","smile"),
								"group" => "Initial Settings",
						  	),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Categories Title Background Color", "ultimate_vc"),
								"param_name" => "color_categories_bg",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Categories Title Color", "ultimate_vc"),
								"param_name" => "color_categories",
								"value" => "",
								//"description" => __("", "woocomposer"),
								"group" => "Style Settings",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Categories Title", "ultimate_vc"),
								"param_name" => "size_cat",
								"value" => "",
								"min" => 10,
								"max" => 72,
								"suffix" => "px",
								//"description" => __("", "woocomposer"),
								"group" => "Size Settings",
							),
						)/* vc_map params array */
					)/* vc_map parent array */ 
				); /* vc_map call */ 
			} /* vc_map function check */
		} /* end woocomposer_init_grid */
		function woocomposer_grid_shortcode($atts){
			global $woocommerce_loop;
			
			$number = $orderby = $order = $columns = $options = $parent = $design_style = $text_align = $border_style = $border_color = '';
			$border_size = $border_radius = $product_animation = $color_categories = $size_cat = $img_animate = $color_categories_bg = '';
			$color_cat_count_color = $color_cat_count_bg = $cat_count = '';
			extract( shortcode_atts( array(
				'number'     => null,
				'orderby'    => 'date',
				'order'      => 'ASC',
				'columns' 	 => '4',
				'ids'		=> '',
				'options' => '',
				'cat_count' => '',
				'design_style' => 'style01',
				'text_align' => '',
				'border_style' => '',
				'border_color' => '',
				'border_size' => '',
				'border_radius' => '',
				'product_animation' => '',
				'color_categories_bg' => '',
				'color_categories' => '',
				'color_cat_count_bg' => '',
				'color_cat_count_color' => '',
				'size_cat' => '',
				'img_animate' => '',
			), $atts ) );
	
			$border = $size = $count_style = '';
			$opts = explode(",",$options);
			
			if($color_categories !== ''){
				$size .= 'color:'.$color_categories.';';
			}
			if($color_categories_bg !== ''){
				$size .= 'background:'.$color_categories_bg.';';
			}
			if($size_cat !== ''){
				$size .= 'font-size:'.$size_cat.'px;';
			}
			
			if($color_cat_count_bg !== ''){
				$count_style .= 'background:'.$color_cat_count_bg.';';
			}
			if($color_cat_count_color !== ''){
				$count_style .= 'color:'.$color_cat_count_color.';';
			}
			
			if ( isset( $atts[ 'ids' ] ) ) {
				$ids = explode( ',', $atts[ 'ids' ] );
				$ids = array_map( 'trim', $ids );
			} else {
				$ids = array();
			}
	
			$hide_empty = in_array('hide_empty',$opts) ? 1 : 0;
			$parent = in_array('parent',$opts) ? '' : 0;
	
			if($border_style !== ''){
				$border .= 'border:'.$border_size.'px '.$border_style.' '.$border_color.';';
				$border .= 'border-radius:'.$border_radius.'px;';
			}
			// get terms and workaround WP bug with parents/pad counts
			$args = array(
				'orderby'    => $orderby,
				'order'      => $order,
				'hide_empty' => $hide_empty,
				'include'    => $ids,
				'pad_counts' => true,
				'child_of'   => $parent
			);
	
			$product_categories = get_terms( 'product_cat', $args );
	
			if ( $parent !== "" ) {
				$product_categories = wp_list_filter( $product_categories, array( 'parent' => $parent ) );
			}
	
			if ( $hide_empty ) {
				foreach ( $product_categories as $key => $category ) {
					if ( $category->count == 0 ) {
						unset( $product_categories[ $key ] );
					}
				}
			}
	
			if ( $number ) {
				$product_categories = array_slice( $product_categories, 0, $number );
			}
	
			$woocommerce_loop['columns'] = $columns;
	
			ob_start();
	
			// Reset loop/columns globals when starting a new loop
			$woocommerce_loop['loop'] = $woocommerce_loop['column'] = '';
	
			if ( $product_categories ) {
	
				//woocommerce_product_loop_start();
				
				echo '<ul class="wcmp-cat-grid products">';
	
				foreach ( $product_categories as $category ) {
	
					// Store loop count we're currently on
					if ( empty( $woocommerce_loop['loop'] ) )
						$woocommerce_loop['loop'] = 0;
					
					// Store column count for displaying the grid
					if ( empty( $woocommerce_loop['columns'] ) )
						$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
					
					// Increase loop count
					$woocommerce_loop['loop']++;
					?>
					<li class="product-category product<?php
						if ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 || $woocommerce_loop['columns'] == 1 )
							echo ' first';
						if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 )
							echo ' last';
						?>">
                        
                        <div class="wcmp-product wcmp-img-<?php echo $img_animate; ?> wcmp-cat-<?php echo $design_style.' animated '.$product_animation; ?>" style="<?php echo $border; ?>">     
					
						<?php do_action( 'woocommerce_before_subcategory', $category ); ?>                        
					
                          <a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>" style="text-align:<?php echo $text_align; ?>;">
							
                            <div class="wcmp-product-image">
							<?php
								/**
								 * woocommerce_before_subcategory_title hook
								 *
								 * @hooked woocommerce_subcategory_thumbnail - 10
								 */
								do_action( 'woocommerce_before_subcategory_title', $category );
							?>
                            </div><!--.wcmp-product-image-->
					
							<h3 style="<?php echo $size; ?>">
								<?php
									echo $category->name;
					
									if ( $category->count > 0 )
										echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count" style="'.$count_style.'">' . $category->count . ' '. $cat_count.'</mark>', $category );
								?>
							</h3>
					
							<?php
								/**
								 * woocommerce_after_subcategory_title hook
								 */
								do_action( 'woocommerce_after_subcategory_title', $category );
							?>
					
						</a>
                        
						<?php do_action( 'woocommerce_after_subcategory', $category ); ?>
                        
                        </div><!--.wcmp-product-->
					
					</li>	
	<?php
				}
	
				woocommerce_product_loop_end();
	
			}
	
			woocommerce_reset_loop();
	
			return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
		}/* end woocomposer_grid_shortcode */
	} /* end class WooComposer_Cat_Grid */
	new WooComposer_Cat_Grid;
}