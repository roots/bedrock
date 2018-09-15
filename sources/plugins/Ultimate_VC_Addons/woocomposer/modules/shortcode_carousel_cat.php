<?php
/*
@Module: Category Grid Layout
@Since: 1.0
@Package: WooComposer
*/
if(!class_exists('WooComposer_Cat_Carousel')){
	class WooComposer_Cat_Carousel
	{
		function __construct(){
			add_action('admin_init',array($this,'woocomposer_init_grid'));
			add_shortcode('woocomposer_carousel_cat',array($this,'woocomposer_carousel_shortcode'));
		} /* end constructor */
		function woocomposer_init_grid(){
			if(function_exists('vc_map')){
				$orderby_arr = array(
					__("Date","ultimate_vc") => "date",
					__("Title","ultimate_vc") => "title",
					__("Product ID","ultimate_vc") => "ID",
					__("Name","ultimate_vc") => "name",
					__("Price","ultimate_vc") => "price",
					__("Sales","ultimate_vc") => "sales",
					__("Random","ultimate_vc") => "rand",
				);
				vc_map(
					array(
						"name"		=> __("Categories Carousel", "ultimate_vc"),
						"base"		=> "woocomposer_carousel_cat",
						"icon"		=> "woo_grid",
						"class"	   => "woo_grid",
						"category"  => __("WooComposer [ Beta ]", "ultimate_vc"),
						"description" => __("Display categories in grid view","ultimate_vc"),
						"controls" => "full",
						"wrapper_class" => "clearfix",
						"show_settings_on_create" => true,
						"deprecated" => "3.13.5",
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
								////"description" => __("","smile"),,
								"group" => "Initial Settings",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Number of Columns", "ultimate_vc"),
								"param_name" => "columns",
								"value" => "",
								"min" => 1,
								"max" => 6,
								"suffix" => "",
								////"description" => __("","smile"),,
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Orderby", "ultimate_vc"),
								"param_name" => "orderby",
								"admin_label" => true,
								"value" => $orderby_arr,
								////"description" => __("","smile"),,
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
								////"description" => __("","smile"),,
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
													"label" => __("Display Child Categories","ultimate_vc"),
													"on" => __("Yes","ultimate_vc"),
													"off" => __("No","ultimate_vc"),
												),
										"sel_cat" => array(
													"label" => __("Select custom categories to display","ultimate_vc"),
													"on" => __("Yes","ultimate_vc"),
													"off" => __("No","ultimate_vc"),
												),
									),
								////"description" => __("","smile"),,
								"group" => "Initial Settings",
							),
							array(
								"type" => "product_categories",
								"class" => "",
								"heading" => __("Select Categories", "ultimate_vc"),
								"param_name" => "ids",
								"value" => "",
								////"description" => __("","smile"),,
								"dependency" => Array("element" => "options", "value" => array("sel_cat")),
								"group" => "Initial Settings",
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Category count text", "ultimate_vc"),
								"param_name" => "cat_count",
								"value" => "",
								////"description" => __("","smile"),,
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
								////"description" => __("","smile"),,
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Product Image Setting", "ultimate_vc"),
								"param_name" => "product_img",
								"value" => array(
									__("Display product featured image","ultimate_vc") => "single",
									__("Display product gallery in carousel slider","ultimate_vc") => "carousel",
								),
								////"description" => __("","smile"),,
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
								////"description" => __("","smile"),,	
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
								////"description" => __("","smile"),,
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
								////"description" => __("","smile"),,
								"dependency" => Array("element" => "border_style", "not_empty" => true),
								"group" => "Initial Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Image Hover Style", "ultimate_vc"),
								"param_name" => "img_animate",
								"value" => array(
									__("Rotate Clock","ultimate_vc")=> "rotate-clock",
									__("Rotate Anti-clock","ultimate_vc")=> "rotate-anticlock",
									__("Zoom-In","ultimate_vc") => "zoomin",
									__("Zoom-Out","ultimate_vc") => "zoomout",
									__("Fade","ultimate_vc") => "fade",
									__("Gray Scale","ultimate_vc") => "grayscale",
									__("Shadow","ultimate_vc") => "imgshadow",
									__("Blur","ultimate_vc") => "blur",
									__("Anti Grayscale","ultimate_vc") => "antigrayscale",
								),
								//"description" => __("","smile"),
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
								////"description" => __("","smile"),,
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Categories Title Color", "ultimate_vc"),
								"param_name" => "color_categories",
								"value" => "",
								////"description" => __("","smile"),,
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Category Count Background Color", "ultimate_vc"),
								"param_name" => "color_cat_count_bg",
								"value" => "",
								////"description" => __("","smile"),,
								"group" => "Style Settings",
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Category Count Text Color", "ultimate_vc"),
								"param_name" => "color_cat_count_color",
								"value" => "",
								////"description" => __("","smile"),,
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
								////"description" => __("","smile"),,
								"group" => "Size Settings",
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Slide to Scroll Setting ", "ultimate_vc"),
								"param_name" => "scroll_opts",
								"value" => array(
										__("Auto","ultimate_vc") => "auto",
										__("Custom","ultimate_vc") => "custom",
									),
								////"description" => __("","smile"),,
								"group" => "Carousel Settings",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Number of Slides to Scroll", "ultimate_vc"),
								"param_name" => "slides_to_scroll",
								"value" => "1",
								"min" => 1,
								"max" => 10,
								"suffix" => "",
								"description" => __("The number of slides to move on transition", "ultimate_vc"),
								"dependency" => Array("element" => "scroll_opts", "value" => array("custom")),
								"group" => "Carousel Settings",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Slide Scrolling Speed", "ultimate_vc"),
								"param_name" => "scroll_speed",
								"value" => "1000",
								"min" => 100,
								"max" => 10000,
								"suffix" => "ms",
								"description" => __("Slide transition duration (in ms)", "ultimate_vc"),
								"group" => "Carousel Settings",
							),
							array(
								"type" => "ult_switch",
								"class" => "",
								"heading" => __("Advanced settings -", "ultimate_vc"),
								"param_name" => "advanced_opts",
								"value" => "",
								"options" => array(
									"infinite" => array(
												"label" => __("Infinite scroll","ultimate_vc"),
												"on" => __("Enable","ultimate_vc"),
												"off" => __("Disable","ultimate_vc"),
											),
									"dots" => array(
												"label" => __("Navigation dots","ultimate_vc"),
												"on" => __("Enable","ultimate_vc"),
												"off" => __("Disable","ultimate_vc"),
											),
									"autoplay" => array(
												"label" => __("Slider auto play","ultimate_vc"),
												"on" => __("Enable","ultimate_vc"),
												"off" => __("Disable","ultimate_vc"),
											),
								),
								////"description" => __("","smile"),,
								"group" => "Carousel Settings",
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Autoplay Speed", "ultimate_vc"),
								"param_name" => "autoplay_speed",
								"value" => "500",
								"min" => 100,
								"max" => 10000,
								"suffix" => "ms",
								"description" => __("The amount of time (in ms) between each auto transition", "ultimate_vc"),
								"group" => "Carousel Settings",
								"dependency" => Array("element" => "advanced_opts", "value" => array("autoplay")),
							),
						)/* vc_map params array */
					)/* vc_map parent array */ 
				); /* vc_map call */ 
			} /* vc_map function check */
		} /* end woocomposer_init_grid */
		function woocomposer_carousel_shortcode($atts){
			global $woocommerce_loop;
			
			$number = $orderby = $order = $columns = $options = $parent = $design_style = $text_align = $border_style = $border_color = '';
			$border_size = $border_radius = $product_animation = $color_categories = $size_cat = $img_animate = $color_categories_bg = $cat_count = '';
			$slides_to_scroll = $scroll_speed = $advanced_opts = $output = $autoplay_speed = $scroll_opts = $color_cat_count_color = $color_cat_count_bg = '';
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
				'slides_to_scroll' => '1',
				'scroll_speed' => '1000',
				'advanced_opts' => '',
				'autoplay_speed' => '500',
				'scroll_opts' => '',
				'img_animate' => '',
			), $atts ) );
	
			$border = $size = $count_style = '';
			$opts = explode(",",$options);
			
			$infinite = $autoplay = $dots = 'false';
			if($product_animation !== ''){
				$product_animation = 'animated '.$product_animation.' ';
			}
			$uid = uniqid();
			$advanced_opts = explode(",", $advanced_opts);
			if(in_array("infinite",$advanced_opts)){
				$infinite = 'true';
			}
			if(in_array("autoplay",$advanced_opts)){
				$autoplay = 'true';
			}
			if(in_array("dots",$advanced_opts)){
				$dots = 'true';
			}			
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
				
				foreach ( $product_categories as $category ) {
					$vc_span = '';
					if($columns == "2") $vc_span = 'vc_span6 wpb_column column_container';
					elseif($columns == "3") $vc_span = 'vc_span4 wpb_column column_container';
					elseif($columns == "4") $vc_span = 'vc_span3 wpb_column column_container';
					
					echo '<div id="wcmp-category-'.uniqid().'" class="wooproduct">';
					// Store loop count we're currently on
					if ( empty( $woocommerce_loop['loop'] ) )
						$woocommerce_loop['loop'] = 0;
					
					// Store column count for displaying the grid
					if ( empty( $woocommerce_loop['columns'] ) )
						$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
					
					// Increase loop count
					$woocommerce_loop['loop']++;
					?>
					<div class="wcmp-carousel-item <?php $product_animation;?>product-category <?php
						if ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 || $woocommerce_loop['columns'] == 1 )
							echo ' first';
						if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 )
							echo ' last';
						?>" style="<?php //echo $border; ?>">
                        <div class="wcmp-product wcmp-img-<?php echo $img_animate; ?> woocommerce wcmp-cat-<?php echo $design_style; ?>">
							<?php do_action( 'woocommerce_before_subcategory', $category ); ?>
                              <a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>" style="text-align:<?php echo $text_align; ?>;">
                         		<div class="wcmp-product-image">     
                                <?php
                                    do_action( 'woocommerce_before_subcategory_title', $category );
                                ?>
                                </div><!--.wcmp-product-image-->
                                
                                <h3 style="<?php echo $size; ?>">
                                    <?php
                                        echo $category->name;
                                        if ( $category->count > 0 )
                                            echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count" style="'.$count_style.'">' . $category->count .  ' '. $cat_count. '</mark>', $category );
                                    ?>
                                </h3>
                                <?php
                                    do_action( 'woocommerce_after_subcategory_title', $category );
                                ?>
                            </a>
                            <?php do_action( 'woocommerce_after_subcategory', $category ); ?>
                		</div>
					</div>	
	<?php
			echo '</div>';
				}
				//woocommerce_product_loop_end();
			}
	
			woocommerce_reset_loop();
			
		?>
			<script type="text/javascript">
			jQuery(document).ready(function(e) {
				jQuery("#woo-carousel-<?php echo $uid; ?> > .woocomposer").slick({
					infinite: <?php echo $infinite; ?>,
					slidesToShow:  <?php echo $columns; ?>,
					slidesToScroll: <?php echo $slides_to_scroll; ?>,
					speed: <?php echo $scroll_speed; ?>,
					dots: <?php echo $dots; ?>,
					autoplay: <?php echo $autoplay; ?>,
					autoplaySpeed: <?php echo $autoplay_speed; ?>,
					responsive: [{
						breakpoint: 1024,
						settings: {
							slidesToShow: 3,
							slidesToScroll: 3,
							infinite: true,
							dots: true
						}
					}, {
						breakpoint: 600,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 2
						}
					}, {
						breakpoint: 480,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					}]
				});
			});
			</script>
		<?php
			$output = '<div id="woo-carousel-'.$uid.'" class="woocommerce woocomposer_carousel wcmp-cat-carousel">';
			$output .= '<div class="woocomposer" data-columns="'.$columns.'">';
			$output .= ob_get_clean();
			$output .= '</div>';
			$output .= '</div>';
			
			return $output;
		}/* end woocomposer_carousel_shortcode */
	} /* end class WooComposer_Cat_Carousel */
	new WooComposer_Cat_Carousel;
}