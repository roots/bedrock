<?php
/**
 * EasySocialShareButtons DisplayMethod: Point
 *
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 3.6
 *
 */

class ESSBDisplayMethodPoint {

	public static function generate_point_code($options, $share_buttons, $total_shares_code, $is_shortcode = false, $shortcode_options = array()) {
		
		$output = '';
		$point_position = ESSBOptionValuesHelper::options_value($options, 'point_position', 'bottomright');
		$point_display_style = ESSBOptionValuesHelper::options_value($options, 'point_style', 'simple');
		$point_shape = ESSBOptionValuesHelper::options_value($options, 'point_shape', 'round');
		$point_display_total = ESSBOptionValuesHelper::options_bool_value($options, 'point_total');
		$point_articles = ESSBOptionValuesHelper::options_bool_value($options, 'point_articles');
		
		$point_top_content = ESSBOptionValuesHelper::options_value($options, 'point_top_content');
		$point_bottom_content = ESSBOptionValuesHelper::options_value($options, 'point_bottom_content');
		
		$point_open_end = ESSBOptionValuesHelper::options_value($options, 'point_open_auto');
		
		$point_animation = ESSBOptionValuesHelper::options_value($options, 'point_animation');
		
		$point_autoclose = essb_option_value('point_close');
		
		if ($is_shortcode) {
			$shortcode_point_style = isset($shortcode_options['point_type']) ? $shortcode_options['point_type'] : '';
			if ($shortcode_point_style != '') {
				$point_display_style = $shortcode_point_style;
			}
		}
		
		// demo mode options
		if (ESSB3_DEMO_MODE) {
			$demo_style = isset($_REQUEST['point_style']) ? $_REQUEST['point_style'] : '';
			$demo_shape = isset($_REQUEST['point_shape']) ? $_REQUEST['point_shape'] : '';
			$demo_position = isset($_REQUEST['point_pos']) ? $_REQUEST['point_pos'] : '';
			
			if ($demo_style != '') { $point_display_style = $demo_style; }
			if ($demo_shape != '') { $point_shape = $demo_shape; }
			if ($demo_position != '') { $point_position = $demo_position; }
		}
		
		// colors
		$point_bgcolor = ESSBOptionValuesHelper::options_value($options, 'point_bgcolor');
		$point_color = ESSBOptionValuesHelper::options_value($options, 'point_color');
		$point_accentcolor = ESSBOptionValuesHelper::options_value($options, 'point_accentcolor');
		$point_altcolor = ESSBOptionValuesHelper::options_value($options, 'point_altcolor');
		
		$point_style = "";
		$total_style = "";
		
		if ($point_bgcolor != '') $point_style .= 'background-color:'.$point_bgcolor.';';
		if ($point_color != '') $point_style .= 'color:'.$point_color.';';

		if ($point_accentcolor != '') $total_style .= 'background-color:'.$point_accentcolor.';';
		if ($point_altcolor != '') $total_style .= 'color:'.$point_altcolor.';';
		
		if ($point_style != '') $point_style = ' style="'.$point_style.'"';
		if ($total_style != '') $total_style = ' style="'.$total_style.'"';
		
		
		$output .= '<div class="essb-point essb-point-'.$point_position.' essb-point-'.$point_shape.' '.$point_animation.'" id="essb-point" data-trigger-scroll="'.($point_open_end).'" data-point-type="'.$point_display_style.'" data-autoclose="'.$point_autoclose.'">';
		$output .= '<i class="essbpb-share essb_icon_share"'.$point_style.'></i>';
		
		if ($point_display_total) {
			$output .= '<div class="essb-point-total"'.$total_style.'>'.$total_shares_code.'</div>';
		}
				
		$output .= '</div>';
		
		$output .= '<div class="essb-point-share-buttons essb-point-share-buttons-'.$point_position.' essb-point-share-buttons-'.$point_display_style.'">';
		
		$output .= '<div class="essb-point-share-buttons-content">';
		
		if ($point_top_content != '' && $point_display_style != 'simple') {
			$point_top_content = stripslashes($point_top_content);
			$point_top_content = essb_post_details_to_content($point_top_content);
			$point_top_content = do_shortcode($point_top_content);
			
			$output .= '<div class="essb-point-share-buttons-content-top">'.$point_top_content.'</div>';
		}
		
		$output .= $share_buttons;

		if ($point_bottom_content != '' && $point_display_style != 'simple') {
			$point_bottom_content = stripslashes($point_bottom_content);
			$point_bottom_content = essb_post_details_to_content($point_bottom_content);
			$point_bottom_content = do_shortcode($point_bottom_content);
				
			$output .= '<div class="essb-point-share-buttons-content-bottom">'.$point_bottom_content.'</div>';
		}
		
		if ($point_articles && $point_display_style != 'simple') {
			
			$output .= '<div class="essb-point-share-buttons-content-articles">';
			
			// previous post
			$prev_post = get_adjacent_post( true, '', true, 'category');
			
			if ( is_a( $prev_post, 'WP_Post' ) ) {
				
				$post_address = get_permalink( $prev_post->ID );
				
				$output .= '<div class="essb-point-prevnext-post">';
				$output .= '<div class="essb-point-prevnext-post-title">';
				$output .= '<a href="'.$post_address.'"><i class="essbpb-prev"></i><span>'.get_the_title( $prev_post->ID).'</span></a>';
				$output .= '</div>';
				
				$output .= '<div class="essb-point-prevnext-post-category">';
				if(is_singular( 'post' )) {
					$category = get_the_category($prev_post->ID);
					$output .= $category[0]->cat_name;
				}
				$output .= '</div>';
				
				$working_post_content = $prev_post->post_content;
					
				//$essb_post_og_desc = strip_shortcodes($essb_post_og_desc);
				$post_shortdesc = $prev_post->post_excerpt;
				if ($post_shortdesc != '') {
					$working_post_content = $post_shortdesc;
				}
					
					
				$working_post_content = strip_tags ( $working_post_content );
				$working_post_content = preg_replace( '/\s+/', ' ', $working_post_content );
				$working_post_content = strip_shortcodes($working_post_content);
				$working_post_content = trim ( $working_post_content );
				$working_post_content = substr ( $working_post_content, 0, 150 );
				$working_post_content .= '&hellip;';
				
				$output .= '<div class="essb-point-prevnext-post-desc">';
				$output .= '<a href="'.$post_address.'">'.$working_post_content.'</a>';
				$output .= '</div>';
				
				$output .= '</div>';
							
			}
			
			// next post
			$next_post = get_adjacent_post( true, '', false, 'category');
			
			if ( is_a( $next_post, 'WP_Post' ) ) {
				$post_address = get_permalink( $next_post->ID );
				$output .= '<div class="essb-point-prevnext-post">';
				$output .= '<div class="essb-point-prevnext-post-title">';
				$output .= '<a href="'.$post_address.'"><i class="essbpb-next"></i><span>'.get_the_title( $next_post->ID).'</span></a>';
				$output .= '</div>';
				
				$output .= '<div class="essb-point-prevnext-post-category">';
				if(is_singular( 'post' )) {
					$category = get_the_category($next_post->ID);
					$output .= $category[0]->cat_name;
				}
				$output .= '</div>';
				
				$working_post_content = $next_post->post_content;
					
				//$essb_post_og_desc = strip_shortcodes($essb_post_og_desc);
				$post_shortdesc = $next_post->post_excerpt;
				if ($post_shortdesc != '') {
					$working_post_content = $post_shortdesc;
				}
					
					
				$working_post_content = strip_tags ( $working_post_content );
				$working_post_content = preg_replace( '/\s+/', ' ', $working_post_content );
				$working_post_content = strip_shortcodes($working_post_content);
				$working_post_content = trim ( $working_post_content );
				$working_post_content = substr ( $working_post_content, 0, 150 );
				$working_post_content .= '&hellip;';
				
				$output .= '<div class="essb-point-prevnext-post-desc">';
				$output .= '<a href="'.$post_address.'">'.$working_post_content.'</a>';
				$output .= '</div>';
				
				$output .= '</div>';
			}
				
			
			$output .= '</div>';
		}
		
		$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}