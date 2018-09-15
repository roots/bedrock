<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();

class RevSliderTinyBox {
	
	protected static $instanceIndex = 1;
	
    public function __construct(){
		
    }
	
	/**
	 * Add interface for custom shortcodes to tinymce
	 * @since: 5.1.1
	 */
	public static function add_tinymce_editor(){
		global $typenow;
		
		// check user permissions
		if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) return;
		
		$post_types = get_post_types();
		if(!is_array($post_types)) $post_types = array( 'post', 'page' );
		// verify the post type
		if(!in_array($typenow, $post_types)) return;
		
		// check if WYSIWYG is enabled
		if(get_user_option('rich_editing') == 'true'){
			add_filter('mce_external_plugins', array('RevSliderTinyBox', 'add_tinymce_shortcode_editor_plugin'));
			add_filter('mce_buttons', array('RevSliderTinyBox', 'add_tinymce_shortcode_editor_button'));
		}
		
		add_action('in_admin_footer', array('RevSliderTinyBox', 'add_tiny_mce_shortcode_dialog'));

	}
	
	
	/**
	 * Allow for VC to use this plugin
	 */
	public static function visual_composer_include(){
		
		if(@is_user_logged_in()){
			
			if(!function_exists('vc_map') || !function_exists('vc_action')) return false;
			
			if('vc_inline' === vc_action() || is_admin()){
				add_action( 'init', array('RevSliderTinyBox', 'add_to_VC' ));
			}
		}
	}
	
	
	public static function add_to_VC() {
		
		//wp_enqueue_script('revslider-admin-script', RS_PLUGIN_URL.'admin/assets/js/admin.js', array('jquery'), RevSliderGlobals::SLIDER_REVISION );
		wp_enqueue_script('wpdialogs', 'jquery-ui-sortable', 'jquery-ui-dialog');
		wp_enqueue_style('wp-jquery-ui-dialog');
		
		vc_map( array(
			'name' => __('Revolution Slider 5', 'revslider'),
			'base' => 'rev_slider',
			'icon' => 'icon-wpb-revslider',
			'category' => __('Content', 'revslider'),
			'show_settings_on_create' => false,
			'js_view' => 'VcSliderRevolution',
			'admin_enqueue_js' => RS_PLUGIN_URL.'admin/assets/js/vc.js',
			'front_enqueue_js' => RS_PLUGIN_URL.'admin/assets/js/vc.js',
			'params' => array(
				array(
					'type' => 'rev_slider_shortcode',
					'heading' => __('Alias', 'revslider'),
					'param_name' => 'alias',
					'admin_label' => true,
					'value' => ''
				),
				array(
					'type' => 'rev_slider_shortcode',
					'heading' => __('Order', 'revslider'),
					'param_name' => 'order',
					'admin_label' => true,
					'value' => ''
				)
			)
		) );
		
		if(version_compare(WPB_VC_VERSION, '4.4', '>=')){ //use if 4.4 or newer
			vc_add_shortcode_param('rev_slider_shortcode', array('RevSliderTinyBox', 'revslider_shortcode_settings_field'));
		}else{ //use if older than 4.4
			add_shortcode_param('rev_slider_shortcode', array('RevSliderTinyBox', 'revslider_shortcode_settings_field'));
		}
		
		//if ( vc_is_frontend_ajax() || vc_is_frontend_editor() ) {
		//	remove_filter( 'vc_revslider_shortcode', array( 'Vc_Vendor_Revslider', 'setId' ) );
		//}
		
	}
	
	//public function setId( $output ) {
	//	return preg_replace( '/rev_slider_(\d+)_(\d+)/', 'rev_slider_$1_$2' . time() . '_' . self::$instanceIndex ++, $output );
	//}

	
	/**
	 * The Dialog for Visual Composer
	 * @since: 5.1.1
	 */
	public static function revslider_shortcode_settings_field($settings, $value) {
		
		return '<div class="rev_slider_shortcode_block">'
			.'<input id="rs-vc-input-'.$settings['param_name'].'" name="'.$settings['param_name']
			.'" class="wpb_vc_param_value wpb-textinput '
			.$settings['param_name'].' '.$settings['type'].'_field" type="text" value="'
			.$value.'" />'
			.'</div>';
		
	}
	
	
	/**
	 * add script tinymce shortcode script
	 * @since: 5.1.1
	 */
	public static function add_tinymce_shortcode_editor_plugin($plugin_array){
	
		$plugin_array['revslider_sc_button'] = RS_PLUGIN_URL . 'admin/assets/js/tinymce-shortcode-script.js';
		
		return $plugin_array;
		
	}
	
	/**
	 * Add button to tinymce
	 * @since: 5.1.1
	 */
	public static function add_tinymce_shortcode_editor_button($buttons){
	
		array_push($buttons, "revslider_sc_button");
		
		return $buttons;
		
	}

	
	/**
	 * Add dialog for shortcode generator
	 * @since: 5.1.1
	 */
	public static function add_tiny_mce_shortcode_dialog(){
		$sld = new RevSlider();
		$sliders = $sld->getArrSliders();
		$shortcodes = '';
		
		?>
		<div id="revslider-tiny-mce-dialog" tabindex="-1" action="" title="" style="display: none; ">
			<form id="revslider-tiny-mce-settings-form" action="">
				<!-- STEP 1 -->
				<div id="revslider-tiny-dialog-step-1">					
					<p class="revslider-quicktitle"></p>
					<div class="revslider-quick-inner-wrapper" style="padding-right:0px;padding-bottom:0px;">
						<select name="revslider-existing-slider" id="revslider-existing-slider">
							<option value="-1" selected="selected"><?php _e('--- Choose Slider ---', 'revslider'); ?></option>
							<?php
							$sl = array();
							$sliders_info = array();
							if(!empty($sliders)){
								foreach($sliders as $slider){
									$alias = $slider->getParam('alias','false');
									$title = $slider->getTitle();
									$type = $slider->getParam('source_type','gallery');
									$slider_type = $slider->getParam('slider-type','standard');
									$active_slide = $slider->getParam('hero_active', -1);
									$sliderID = $slider->getID();
									
									if($type == 'gallery'){
										$slides = $slider->getSlides();
									}elseif($type == 'specific_posts'){
										$slides = $slider->getSlidesFromPosts();
									}
									
									if(!empty($slides)){
										$sliders_info[$sliderID] = array();
										
										foreach($slides as $slide){
											$bg_extraClass = '';
											$bg_fullstyle = '';
											
											$urlImageForView = $slide->getThumbUrl();
											
											$bgt = $slide->getParam('background_type', 'transparent');
											if($type == 'woocommerce'){
											}
											if($bgt == 'image' || $bgt == 'streamvimeo' || $bgt == 'streamyoutube' || $bgt == 'streaminstagram'){
												switch($type){
													case 'posts':
														$urlImageForView = RS_PLUGIN_URL.'public/assets/assets/sources/post.png';
													break;
													case 'woocommerce':
														$urlImageForView = RS_PLUGIN_URL.'public/assets/assets/sources/wc.png';
													break;
													case 'facebook':
														$urlImageForView = RS_PLUGIN_URL.'public/assets/assets/sources/fb.png';
													break;
													case 'twitter':
														$urlImageForView = RS_PLUGIN_URL.'public/assets/assets/sources/tw.png';
													break;
													case 'instagram':
														$urlImageForView = RS_PLUGIN_URL.'public/assets/assets/sources/ig.png';
													break;
													case 'flickr':
														$urlImageForView = RS_PLUGIN_URL.'public/assets/assets/sources/fr.png';
													break;
													case 'youtube':
														$urlImageForView = RS_PLUGIN_URL.'public/assets/assets/sources/yt.png';
													break;
													case 'vimeo':
														$urlImageForView = RS_PLUGIN_URL.'public/assets/assets/sources/vm.png';
													break;
												}
											}
											
											if ($bgt == 'image' || $bgt == 'vimeo' || $bgt == 'youtube' || $bgt == 'html5' || $bgt == 'streamvimeo' || $bgt == 'streamyoutube' || $bgt == 'streaminstagram'){
												$bg_style = ' ';
												if($slide->getParam('bg_fit', 'cover') == 'percentage'){
													$bg_style .= "background-size: ".$slide->getParam('bg_fit_x', '100').'% '.$slide->getParam('bg_fit_y', '100').'%;';
												}else{
													$bg_style .= "background-size: ".$slide->getParam('bg_fit', 'cover').";";
												}
												if($slide->getParam('bg_position', 'center center') == 'percentage'){
													$bg_style .= "background-position: ".intval($slide->getParam('bg_position_x', '0')).'% '.intval($slide->getParam('bg_position_y', '0')).'%;';
												}else{
													$bg_style .= "background-position: ".$slide->getParam('bg_position', 'center center').";";
												}
												$bg_style .= "background-repeat: ".$slide->getParam('bg_repeat', 'no-repeat').";";
												$bg_fullstyle =' style="background-image:url('.$urlImageForView.');'.$bg_style.'" ';
											}
											
											if ($bgt == 'solid') $bg_fullstyle =' style="background-color:'.$slide->getParam('slide_bg_color', 'transparent').';" ';
											if ($bgt == 'trans') $bg_extraClass = 'mini-transparent';
											if ($slide->getParam('thumb_for_admin', 'off') == "on") $bg_fullstyle =' style="background-image:url('.$slide->getParam('slide_thumb','').');background-size:cover;background-position:center center" ';
											
											$sliders_info[$sliderID][] = array( 'id' => $slide->getID(),
																				'slider_type' => $slider_type,
																				'title' => $slide->getTitle(),
																				'slidertitle' => $title,
																				'slideralias' => $alias,
																				'sliderid' => $sliderID,
																				'state' => $slide->getParam('state', 'published'),
																				'slide_thumb' => $slide->getParam('slide_thumb', ''),
																				'bg_fullstyle' => $bg_fullstyle,
																				'bg_extraClass' => $bg_extraClass,
																				'active_slide' => $active_slide
																				);
																				
											if($active_slide == -1) $active_slide = -99; //do this so that we are hero, only the first slide will be active if no hero slide was yet set
										}
									}
									
									$sl[$type][] = array('alias' => $alias, 'title' => $title, 'id' => $sliderID);
								}
								
								if(!empty($sl)){
									foreach($sl as $type => $slider){
										$mtype = ($type == 'specific_posts') ? 'Specific Posts' : $type;
										echo '<option disabled="disabled">--- '.ucfirst(esc_attr($mtype)).' ---</option>';
										foreach($slider as $values){
											if($values['alias'] != 'false'){
												echo '<option data-sliderid="'.esc_attr($values['id']).'" data-slidertype="'.esc_attr($type).'" value="'.esc_attr($values['alias']).'">'.esc_attr($values['title']).'</option>'."\n";
											}
										}
									}
								}
							}
							?>
						</select>

						<ul id="rs-shortcode-select-wrapper">
							<li class="rs-slider-modify-li rs-slider-modify-new-slider">								
								<a href="<?php echo RevSliderBaseAdmin::getViewUrl(RevSliderAdmin::VIEW_SLIDER); ?>" target="_blank" class="button-primary revgreen" id="rs-create-predefined-slider"><span class="dashicons dashicons-plus"></span><span class="rs-slider-modify-title"><?php _e('Create Slider', 'revslider'); ?></span></a>
							</li>
							<?php
							if(!empty($sliders_info)){
								foreach($sliders_info as $type => $slider){
									foreach($slider as $values){
										?>
										<li id="slider_list_item_<?php echo $values['sliderid']; ?>" class="rs-slider-modify-li" data-sliderid="<?php echo esc_attr($values['sliderid']); ?>" data-slideralias="<?php echo esc_attr($values['slideralias']); ?>">
											<span class="mini-transparent mini-as-bg"></span>
											<div class="rs-slider-modify-container <?php echo $values['bg_extraClass']; ?>"  <?php echo $values['bg_fullstyle']; ?>></div>
											<i class="slide-link-forward eg-icon-forward"></i>

											<span class="rs-slider-modify-title">#<?php echo $values['sliderid'].' '.$values['slidertitle']; ?></span>
										</li>
										<?php
										break;
									}
								}
							}
							?>
							
							<span style="clear:both;width:100%;display:block"></span>

						</ul>
						<span style="clear:both;width:100%;display:block"></span>
						<script type="text/javascript">
							var rev_sliders_info = jQuery.parseJSON(<?php echo RevSliderFunctions::jsonEncodeForClientSide($sliders_info); ?>);
						</script>
					</div>
					<div class="revslider-stepnavigator">
						<span class="revslider-currentstep"><strong><?php _e('STEP 1', 'revslider'); ?></strong><?php _e('Select / Create Slider', 'revslider'); ?></span>
						<span class="revslider-step-actions-wrapper">
							<a href="javascript:void(0);" class="button-primary nonclickable" id="rs-modify-predefined-slider"><span class="dashicons dashicons-admin-generic"></span><?php _e('Quick Modify Slider', 'revslider'); ?></a>
							<a href="javascript:void(0);" class="button-primary nonclickable" id="rs-add-predefined-slider"><span class="dashicons dashicons-migrate"></span><?php _e('Add Selected Slider', 'revslider'); ?></a>							
						</span>
						<span style="clear:both;width:100%;display:block"></span>
					</div>
				</div>
				
				<!-- STEP 1.5 -->
				<div id="revslider-tiny-dialog-step-1-5" style="display: none;">
					<p class="revslider-quicktitle"></p>
					<div id="revslider-tiny-settings-wrap" class="revslider-quick-inner-wrapper" style="padding-right:0px;padding-bottom:0px;">
							<ul class="rs-mod-slides-wrapper">
								
							</ul>
					</div>					
					<div class="revslider-stepnavigator"><span class="revslider-currentstep"><strong><?php _e('STEP 2', 'revslider'); ?></strong><?php _e('Quick Modify / Add Slider', 'revslider'); ?></span>
						<span class="revslider-step-actions-wrapper">
							<a href="javascript:void(0);" class="button-primary  rs-goto-step-1"><span class="dashicons dashicons-arrow-left-alt"></span><?php _e('Select Slider', 'revslider'); ?></a>
							<a href="javascript:void(0);" class="button-primary " id="revslider-add-custom-shortcode-modify"><span class="dashicons dashicons-migrate"></span><?php _e('Add Selected Slider', 'revslider'); ?></a>							
						</span>
					</div>
				</div>
			</form>
		</div>

		<script>
			jQuery("document").ready(function() {
				jQuery('body').on('click', '.slide-published.pubclickable', function(){
					var li = jQuery(this).closest('li');						
					li.find('.slide-published').removeClass("pubclickable");
					li.find('.slide-unpublished').addClass("pubclickable");
				});		
				jQuery('body').on('click', '.slide-unpublished.pubclickable', function(){
					var li = jQuery(this).closest('li');
					li.find('.slide-published').addClass("pubclickable");
					li.find('.slide-unpublished').removeClass("pubclickable");
				});
				
				jQuery('body').on('click', '.slide-hero-published.pubclickable', function(){
					var li = jQuery(this).closest('li');
					jQuery('.slide-link-published-wrapper').each(function(){
						jQuery(this).find('.slide-hero-published').addClass("pubclickable");
						jQuery(this).find('.slide-hero-unpublished').removeClass("pubclickable");
					});
					li.find('.slide-hero-published').removeClass("pubclickable");
					li.find('.slide-hero-unpublished').addClass("pubclickable");
				});		
				jQuery('body').on('click', '.slide-hero-unpublished.pubclickable', function(){
					var li = jQuery(this).closest('li');
					jQuery('.slide-link-published-wrapper').each(function(){
						jQuery(this).find('.slide-hero-published').addClass("pubclickable");
						jQuery(this).find('.slide-hero-unpublished').removeClass("pubclickable");
					});
					li.find('.slide-hero-published').addClass("pubclickable");
					//li.find('.slide-hero-unpublished').removeClass("pubclickable");
				});	
			});		
		</script>

		
		<script type="text/html" id="tmpl-rs-modify-slide-wrap">
			<li id="slidelist_item_{{ data.id }}" class="rs-slide-modify-li">
				<span class="mini-transparent mini-as-bg"></span>
				<div class="rs-slide-modify-container {{ data.bg_extraClass }}" {{{ data.bg_fullstyle }}}></div>
				<i class="slide-link-forward eg-icon-forward"></i>
				
				<span class="slide-link-published-wrapper">
					<# if(data.slider_type !== 'hero'){ #>
						<# if(data.state == 'published'){ #>
							<span class="slide-published" ></span>
							<span class="slide-unpublished pubclickable"></span>
						<# }else{ #>
							<span class="slide-unpublished"></span>
							<span class="slide-published pubclickable"></span>
						<# } #>
					<# }else{ #>
						<# if(data.active_slide == data.id || data.active_slide == -1){ #> <?php /* || data.active_slide == -1 */ ?>
							<span class="slide-hero-published"></span>
							<span class="slide-hero-unpublished pubclickable"></span>
						<# }else{ #>
							<span class="slide-hero-published pubclickable"></span>
							<span class="slide-hero-unpublished"></span>
						<# } #>
					<# } #>
				</span>
				<span class="rs-slide-modify-title">{{ data.title }}</span>
			</li>
		</script>
		<?php
	}
}

/**
 * old classname extends new one (old classnames will be obsolete soon)
 * @since: 5.0
 **/
class RevSlider_TinyBox extends RevSliderTinyBox {}
?>