<?php
if( !defined( 'ABSPATH') ) exit();
$obj_library = new RevSliderObjectLibrary();

$startanims = $operations->getArrAnimations();
$slider_addons = apply_filters('revslider_slide_addons', array(), $slide, $slider);
?>



<div style="width:100%;height:20px"></div>
<div class="editor_buttons_wrapper  postbox unite-postbox" style="max-width:100% !important; min-width:1200px !important">
	<div class="box-closed tp-accordion" style="border-bottom:5px solid #ddd;">
		<ul class="rs-layer-settings-tabs">
			<li id="rs-style-tab-button" data-content="#rs-style-content-wrapper" class="selected"><i style="height:45px" class="rs-mini-layer-icon rs-icon-droplet rs-toolbar-icon"></i>
				<span class="rs-anim-tab-txt"><?php _e("Style",'revslider'); ?></span>
				<span id="style-morestyle" class="tipsy_enabled_top" title="<?php _e("Advanced Style on/off",'revslider'); ?>">
					<span class="rs-icon-morestyles-dark"><i class="eg-icon-down-open"></i></span>
					<span class="rs-icon-morestyles-light"><i class="eg-icon-down-open"></i></span>
				</span>				
			</li>
			<li id="rs-animation-tab-button" data-content="#rs-animation-content-wrapper"><i style="height:45px" class="rs-mini-layer-icon rs-icon-chooser-2 rs-toolbar-icon"></i>
				<span class="rs-anim-tab-txt"><?php _e("Animation",'revslider'); ?></span>
				<span id="layeranimation-playpause" class=" tipsy_enabled_top" title="<?php _e("Play/Pause Single Layer Animation",'revslider'); ?>">
					<i class="eg-icon-play"></i>
					<i class="eg-icon-pause"></i>
				</span>
			</li>
			<li id="rs-loopanimation-tab-button" data-content="#rs-loop-content-wrapper"><i style="height:45px" class="rs-mini-layer-icon rs-icon-chooser-3 rs-toolbar-icon"></i>
				<span class="rs-anim-tab-txt"><?php _e("Loop",'revslider'); ?></span>
				<span id="loopanimation-playpause" class="tipsy_enabled_top" title="<?php _e("Play/Pause Layer Loop Animation",'revslider'); ?>">
					<i class="eg-icon-play"></i>
					<i class="eg-icon-pause"></i>
				</span>
			</li>
			<li id="v_layers_mp_4" data-content="#rs-visibility-content-wrapper"><i style="height:45px" class="rs-mini-layer-icon rs-icon-visibility rs-toolbar-icon"></i><?php _e("Visibility",'revslider'); ?></li>
			<li id="v_layers_mp_5" data-content="#rs-behavior-content-wrapper"><i style="height:45px" class="rs-mini-layer-icon eg-icon-resize-full-2 rs-toolbar-icon "></i><?php _e("Behavior",'revslider'); ?></li>
			<li id="v_layers_mp_6" data-content="#rs-action-content-wrapper"><i style="height:45px; font-size:16px" class="rs-mini-layer-icon eg-icon-link rs-toolbar-icon"></i><?php _e("Actions",'revslider'); ?></li>
			
			<li id="v_layers_mp_7" data-content="#rs-attribute-content-wrapper"><i style="height:45px" class="rs-mini-layer-icon rs-icon-edit-basic rs-toolbar-icon"></i><?php _e("Attributes",'revslider'); ?></li>
			<?php if($slide->isStaticSlide()){ ?>
			<li id="v_layers_mp_8" data-content="#rs-static-content-wrapper"><i style="height:45px" class="rs-mini-layer-icon eg-icon-dribbble-1 rs-toolbar-icon"></i><?php _e("Static Layers",'revslider'); ?></li>
			<?php } ?>
			<li id="v_layers_mp_9" data-content="#rs-parallax-content-wrapper"><i style="height:45px; font-size:16px;" class="rs-mini-layer-icon eg-icon-picture-1 rs-toolbar-icon"></i><?php _e("Parallax / 3D",'revslider'); ?></li>			
			<?php if(!empty($slider_addons)){ ?>
			<li id="v_layers_mp_10" class="rs-addon-tab-button" data-content="#rs-addon-wrapper"><i style="height:45px; font-size:16px;" class="rs-mini-layer-icon eg-icon-plus-circled rs-toolbar-icon"></i><?php _e("Add-ons",'revslider'); ?></li>
			<?php } ?>
		</ul>
		<div style="clear:both"></div>
	</div>
	<div style="clear:both"></div>

	<!-- THE AMAZING TOOLBAR ABOVE THE SLIDE EDITOR -->
	<form name="form_layers" class="form_layers notselected">

		<!-- LAYER STYLING -->
		<div class="layer-settings-toolbar " id="rs-style-content-wrapper" style="">
			<?php //add global styles editor ?>
			<div id="css_static_editor_wrap ho_row_ ho_column_ ho_group_" title="<?php _e("Global Style Editor",'revslider') ?>" style="display:none;">
				<div id="css-static-accordion">
					<h3><?php _e("Dynamic Styles (Not Editable):",'revslider')?></h3>
					<div class="css_editor_novice_wrap">
						<textarea id="textarea_show_dynamic_styles" rows="20" cols="81"></textarea>
					</div>
					<h3 class="notopradius" style="margin-top:20px"><?php _e("Static Styles:",'revslider')?></h3>
					<div>
						<textarea id="textarea_edit_static" rows="20" cols="81"></textarea>
					</div>
				</div>
			</div>
			<div id="dialog-change-css-static" title="<?php _e("Save Static Styles",'revslider') ?>" style="display:none;">
				<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 50px 0;"></span><?php _e('Overwrite current static styles?','revslider')?></p>
			</div>
			
			<div>

				<!-- FONT TEMPLATE -->
				<span class="rs-layer-toolbar-box ho_row_ ho_column_ ho_group_" style="padding-right:15px;">
					<i class="rtlmr0 rs-mini-layer-icon rs-icon-fonttemplate rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Caption Style",'revslider'); ?>" style="margin-right:10px"></i>
					<input type="text"  style="width:150px; padding-right:30px;" class="textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Style Template",'revslider'); ?>"  id="layer_caption" name="layer_caption" value="-" />
					<span id="layer_captions_down" ><i class="eg-icon-arrow-combo"></i></span>
					<!--<a href="javascript:void(0)" id='button_edit_css' class='revnewgray layer-toolbar-button  tipsy_enabled_top' title="<?php _e("More Style Settings",'revslider'); ?>"><i class="revicon-cog"></i></a>-->
					<!--<a href="javascript:void(0)" id='button_css_reset' class='revnewgray layer-toolbar-button tipsy_enabled_top' title="<?php _e("Reset Style Template",'revslider'); ?>"><i class="revicon-ccw"></i></a>-->

					<span id="css-template-handling-dd" class="clicktoshowmoresub">
						<span id="css-template-handling-dd-inner" class="clicktoshowmoresub_inner">
							<span style="background:#ddd !important; padding-left:20px;margin-bottom:5px" class="css-template-handling-menupoint"><span><?php _e("Style Options",'revslider'); ?></span></span>
							<span id="save-current-css"   class="save-current-css css-template-handling-menupoint"><i class="rs-mini-layer-icon rs-toolbar-icon rs-icon-save-dark"></i><span><?php _e("Save",'revslider'); ?></span></span>
							<span id="save-as-current-css"   class="save-as-current-css css-template-handling-menupoint"><i class="rs-mini-layer-icon rs-toolbar-icon rs-icon-save-dark"></i><span><?php _e("Save As",'revslider'); ?></span></span>
							<span id="rename-current-css" class="rename-current-css css-template-handling-menupoint"><i class="rs-mini-layer-icon rs-toolbar-icon rs-icon-chooser-1"></i><span><?php _e("Rename",'revslider'); ?></span></span>
							<span id="reset-current-css"  class="reset-current-css css-template-handling-menupoint"><i class="rs-mini-layer-icon rs-toolbar-icon rs-icon-2drotation"></i><span><?php _e("Reset",'revslider'); ?></span></span>
							<span id="delete-current-css" class="delete-current-css css-template-handling-menupoint"><i style="background-size:10px 14px;" class="rs-mini-layer-icon rs-toolbar-icon rs-icon-delete"></i><span><?php _e("Delete",'revslider'); ?></span></span>
						</span>
					</span>
				</span>



				
				<span class="rs-layer-toolbar-box ho_shape_ ho_video_ ho_image_ ho_row_ ho_column_ ho_group_">
					<!-- FONT SIZE -->
					<i class="rs-mini-layer-icon rs-icon-fontsize rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Font Size (px)",'revslider'); ?>" style="margin-right:6px" ></i>
					<input type="text"  data-suffix="px" class="rs-layer-input-field tipsy_enabled_top" title="<?php _e("Font Size",'revslider'); ?>" style="width:61px" id="layer_font_size_s" name="font_size_static" value="20px" />
					<span class="rs-layer-toolbar-space"></span>


					<!-- LINE HEIGHT -->
					<i class="rs-mini-layer-icon rs-icon-lineheight rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Line Height (px)",'revslider'); ?>" style="margin-right:11px" ></i>
					<input type="text" data-suffix="px" class="rs-layer-input-field tipsy_enabled_top" title="<?php _e("Line Height",'revslider'); ?>" style="width:61px" id="layer_line_height_s" name="line_height_static" value="22px" />
					<span class="rs-layer-toolbar-space" style="margin-right:10px" ></span>
				</span>


				<!-- WRAP -->
				<span class="rs-layer-toolbar-box tipsy_enabled_top ho_row_ ho_column_ ho_group_" style="display: none" title="<?php _e("White Space",'revslider'); ?>">
					<i class="rs-mini-layer-icon rs-icon-wrap rs-toolbar-icon"></i>
					<select class="rs-layer-input-field" style="width:95px" id="layer_whitespace" name="layer_whitespace">
						<option value="normal"><?php _e('Normal', 'revslider'); ?></option>
						<option value="pre"><?php _e('Pre', 'revslider'); ?></option>
						<option value="nowrap" selected="selected"><?php _e('No-wrap', 'revslider'); ?></option>
						<option value="pre-wrap"><?php _e('Pre-Wrap', 'revslider'); ?></option>
						<option value="pre-line"><?php _e('Pre-Line', 'revslider'); ?></option>
					</select>
				</span>

				<!-- ALIGN -->
				<span class="rs-layer-toolbar-box tipsy_enabled_top ho_row_ ho_sltic_ ho_column_" style="padding-right:18px;" id="rs-align-wrapper">
					<i class="rs-mini-layer-icon eg-icon-arrow-combo rs-toolbar-icon" style="margin-right:3px"></i>
					<a href="javascript:void(0)" id='align_left' data-hor="left"  class='revnewgray layer-toolbar-button rs-new-align-button tipsy_enabled_top' title="<?php _e("Layer Align Left",'revslider'); ?>"><i class="rs-mini-layer-icon rs-icon-alignleft rs-toolbar-icon"></i></a>
					<a href="javascript:void(0)" id='align_center_h' data-hor="center" class='revnewgray layer-toolbar-button rs-new-align-button tipsy_enabled_top' title="<?php _e("Layer Align Center",'revslider'); ?>"><i class="rs-mini-layer-icon rs-icon-aligncenterh rs-toolbar-icon"></i></a>
					<a href="javascript:void(0)" id='align_right' data-hor="right" class='revnewgray layer-toolbar-button rs-new-align-button tipsy_enabled_top' title="<?php _e("Layer Align Right",'revslider'); ?>"><i class="rs-mini-layer-icon rs-icon-alignright rs-toolbar-icon"></i></a>									
					<input type="text"  class='text-sidebar' style="display:none" id="layer_align_hor" name="layer_align_hor" value="left" />				

				</span>

				<span class="rs-layer-toolbar-box ho_row_ ho_column_ ho_sltic_">
					<!-- POSITION X -->
					<i class="rs-mini-layer-icon rs-icon-xoffset rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Horizontal Offset from Aligned Position (px)",'revslider'); ?>" style="margin-right:8px"></i>
					<input type="text" data-suffix="px" class="text-sidebar setting-disabled rs-layer-input-field tipsy_enabled_top" title="<?php _e("Horizontal Offset from Aligned Position (px)",'revslider'); ?>" style="width:60px" id="layer_left" name="layer_left" value="" disabled="disabled">
					<span class="rs-layer-toolbar-space" style="margin-right:10px"></span>

					<!-- POSITION Y -->
					<i class="rs-mini-layer-icon rs-icon-yoffset rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Vertical Offset from Aligned Position (px)",'revslider'); ?>" style="margin-right:4px"></i>
					<input type="text" data-suffix="px" class="text-sidebar setting-disabled rs-layer-input-field tipsy_enabled_top" title="<?php _e("Vertical Offset from Aligned Position (px)",'revslider'); ?>" style="width:60px" id="layer_top" name="layer_top" value="" disabled="disabled">					
				</span>


				<span class="rs-layer-toolbar-box">
					<!-- HTML TAG -->
					<span class="ho_shape_ ho_video_ ho_image_ ho_button_ ho_column_ ho_row_ ho_group_">				
						<i class="rs-mini-layer-icon eg-icon-code rs-toolbar-icon tipsy_enabled_top" title="<?php _e("HTML Tag for Layer",'revslider'); ?>"></i>
						<select class="rs-layer-input-field tipsy_enabled_top" title="<?php _e("HTML Tag",'revslider'); ?>" style="width:61px" id="layer_html_tag" name="layer_html_tag">
							<option value="div">&lt;div&gt; - default</option>
							<option value="p">&lt;p&gt;</option>
							<option value="h1">&lt;h1&gt;</option>
							<option value="h2">&lt;h2&gt;</option>
							<option value="h3">&lt;h3&gt;</option>
							<option value="h4">&lt;h4&gt;</option>
							<option value="h5">&lt;h5&gt;</option>
							<option value="h6">&lt;h6&gt;</option>
							<option value="span">&lt;span&gt;</option>
						</select>					
					</span>
				</span>
			</div>


			<div style="border-top:1px solid #ddd;">

				<!-- FONT FAMILY-->
				<span class="rs-layer-toolbar-box ho_shape_ ho_video_ ho_image_ ho_row_ ho_column_ ho_group_" style="padding-right:0px;">
					<i class="rs-mini-layer-icon rs-icon-fontfamily rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Font Family",'revslider'); ?>" style="margin-right:10px"></i>
					<input type="text" class="rs-staticcustomstylechange text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Font Family",'revslider'); ?>" style="width:185px" type="text" id="css_font-family" name="css_font-family" value="" autocomplete="off"> <?php /*  id="font_family" */ ?>
					<span id="css_fonts_down" class="ui-state-active" style="position: relative;"><i class="eg-icon-arrow-combo"></i></span>
					<span class="rs-layer-toolbar-space" style="margin-right:9px"></span>
				</span>



				<!-- FONT DIRECT MANAGEMENT -->
				<span class="rs-layer-toolbar-box ho_shape_ ho_video_ ho_image_ ho_row_ ho_column_ ho_group_">

					<!-- FONT WEIGHT -->
					<i class="rs-mini-layer-icon rs-icon-fontweight rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Font Weight",'revslider'); ?>"></i>
					<select class="rs-layer-input-field tipsy_enabled_top" title="<?php _e("Font Weight",'revslider'); ?>" style="width:61px" id="layer_font_weight_s" name="font_weight_static">
						<option value="100">100</option>
						<option value="200">200</option>
						<option value="300">300</option>
						<option value="400">400</option>
						<option value="500">500</option>
						<option value="600">600</option>
						<option value="700">700</option>
						<option value="800">800</option>
						<option value="900">900</option>
					</select>
					<span class="rs-layer-toolbar-space"></span>

					<!-- COLOR -->
					<i class="rs-mini-layer-icon rs-icon-color rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Font Color",'revslider'); ?>"></i>
					<input type="text" class="my-color-field rs-layer-input-field tipsy_enabled_top" title="<?php _e("Font Color",'revslider'); ?>"  id="layer_color_s" name="color_static" value="#ffffff" />
				</span>

				<!-- ALIGN -->
				<span class="rs-layer-toolbar-box tipsy_enabled_top ho_sltic_ ho_column_" style="padding-right:18px;" id="rs-align-wrapper-ver">
					<i class="rs-mini-layer-icon eg-icon-arrow-combo rs-toolbar-icon" style="margin-right:3px"></i>															
					<a href="javascript:void(0)" id='align_top' data-ver="top" class='revnewgray layer-toolbar-button rs-new-align-button tipsy_enabled_top' title="<?php _e("Layer Align Top",'revslider'); ?>"><i class="rs-mini-layer-icon rs-icon-aligntop rs-toolbar-icon"></i></a>
					<a href="javascript:void(0)" id='align_center_v' data-ver="middle" class='revnewgray layer-toolbar-button rs-new-align-button tipsy_enabled_top' title="<?php _e("Layer Align Middle",'revslider'); ?>"><i class="rs-mini-layer-icon rs-icon-aligncenterv rs-toolbar-icon"></i></a>
					<a href="javascript:void(0)" id='align_bottom' data-ver="bottom" class='revnewgray layer-toolbar-button rs-new-align-button tipsy_enabled_top' title="<?php _e("Layer Align Bottom",'revslider'); ?>"><i class="rs-mini-layer-icon rs-icon-alignbottom rs-toolbar-icon"></i></a>
					<input type="text"  class='text-sidebar' style="display:none" id="layer_align_vert" name="layer_align_vert" value="top" />
				</span>

				<span class="rs-layer-toolbar-box" style="position:relative">
				

					<!-- IMAGE SIZE -->
					<span id="layer_scaleXY_wrapper" class="ho_row_ ho_column_" style="display:none">
						<i class="rs-mini-layer-icon rs-icon-maxwidth rs-toolbar-icon tipsy_enabled_top " title="<?php _e("Layer Width (px/%). Use 'auto' to respect White Space",'revslider'); ?>" style="margin-right:3px"></i>						
						<input type="text" data-suffix="px" data-suffixalt="%" class="input-deepselects text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Layer Width (px/%). Use 'auto' to respect White Space",'revslider'); ?>" style="width:60px" id="layer_scaleX" name="layer_scaleX" value="" data-deepwidth="125" data-selects="Custom %||Custom PX||100%||100px||auto" data-svalues ="50%||150px||100%||100px||auto" data-icons="wrench||wrench||filter||filter||font">						
						<span class="rs-layer-toolbar-space" style="margin-right:11px"></span>						
						<i class="rs-mini-layer-icon rs-icon-maxheight rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Layer Height (px). Use 'auto' to respect White Space",'revslider'); ?>"></i>						
						<input type="text" data-suffix="px" data-suffixalt="%" class="input-deepselects text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Layer Height (px) Use 'auto' to respect White Space",'revslider'); ?>" style="width:60px" id="layer_scaleY" name="layer_scaleY" value="" data-deepwidth="125" data-selects="Custom %||Custom PX||100%||100px||auto" data-svalues ="50%||150px||100%||100px||auto" data-icons="wrench||wrench||filter||filter||font">						
					</span>
					<!-- DEFAULT LAYER SIZE -->
					<span id="layer_max_widthheight_wrapper" class="ho_row_ ho_column_">
						<i class="rs-mini-layer-icon rs-icon-maxwidth rs-toolbar-icon tipsy_enabled_top " title="<?php _e("Layer Width (px/%). Use 'auto' to respect White Space",'revslider'); ?>" style="margin-right:3px"></i>
						<input type="text" data-suffix="px" data-suffixalt="%" class="input-deepselects text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Layer Width (px/%). Use 'auto' to respect White Space",'revslider'); ?>" style="width:60px" id="layer_max_width" name="layer_max_width" value="auto" data-deepwidth="125" data-selects="Custom %||Custom PX||100%||100px||auto" data-svalues ="50%||150px||100%||100px||auto" data-icons="wrench||wrench||filter||filter||font">						
						<span class="rs-layer-toolbar-space" style="margin-right:11px"></span>
						<i class="rs-mini-layer-icon rs-icon-maxheight rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Layer Height (px). Use 'auto' to respect White Space",'revslider'); ?>"></i>
						<input type="text" data-suffix="px" data-suffixalt="%" class="input-deepselects text-sidebar rs-layer-input-field tipsy_enabled_top " title="<?php _e("Layer Height (px). Use 'auto' to respect White Space",'revslider'); ?>" style="width:60px" id="layer_max_height" name="layer_max_height" value="auto" data-deepwidth="125" data-selects="Custom %||Custom PX||100%||100px||auto" data-svalues ="50%||150px||100%||100px||auto" data-icons="wrench||wrench||filter||filter||font">
					</span>
					<!-- VIDEO SIZE -->
					<span id="layer_video_widthheight_wrapper" class="ho_row_ ho_column_" style="display:none">
						<i class="rs-mini-layer-icon rs-icon-maxwidth rs-toolbar-icon tipsy_enabled_top " title="<?php _e("Layer Width (px/%). Use 'auto' to respect White Space",'revslider'); ?>" style="margin-right:3px"></i>						
						<input type="text" data-suffix="px" data-suffixalt="%" class="input-deepselects text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Video Width (px/%). Use 'auto' to respect White Space",'revslider'); ?>" style="width:60px" id="layer_video_width" name="layer_video_width" value="" data-deepwidth="125" data-selects="Custom %||Custom PX||100%||100px||auto" data-svalues ="50%||150px||100%||100px||auto" data-icons="wrench||wrench||filter||filter||font">					
						<span class="rs-layer-toolbar-space" style="margin-right:11px"></span>
						<i class="rs-mini-layer-icon rs-icon-maxheight rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Layer Height (px). Use 'auto' to respect White Space",'revslider'); ?>"></i>
						<input type="text" data-suffix="px" data-suffixalt="%" class="input-deepselects text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Video Height (px). Use 'auto' to respect White Space",'revslider'); ?>" style="width:60px" id="layer_video_height" name="layer_video_height" value="" data-deepwidth="125" data-selects="Custom %||Custom PX||100%||100px||auto" data-svalues ="50%||150px||100%||100px||auto" data-icons="wrench||wrench||filter||filter||font">					
					</span>

					<!-- MIN HEIGHT -->
					<span id="layer_minwidthheight_wrapper" style="display:none">
						<i class="rs-mini-layer-icon rs-icon-maxwidth rs-toolbar-icon tipsy_enabled_top ho_column_" title="<?php _e("Min Width of Element. Use 'auto' to respect White Space",'revslider'); ?>" style="margin-right:3px"></i>						
						<input type="text" data-suffix="px" data-suffixalt="%" class="input-deepselects text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Min Width",'revslider'); ?>" style="width:60px" id="layer_min_width" name="layer_min_width" value="" data-deepwidth="125" data-selects="Custom %||Custom PX||100%||100px||auto" data-svalues ="50%||150px||100%||100px||auto" data-icons="wrench||wrench||filter||filter||font">
						<span class="rs-layer-toolbar-space" style="margin-right:11px"></span>
						<i class="rs-mini-layer-icon rs-icon-minheight rs-toolbar-icon tipsy_enabled_top " title="<?php _e("Min Height (px).",'revslider'); ?>"></i>					
						<input type="text" data-suffix="px" class="text-sidebar rs-layer-input-field tipsy_enabled_top " title="<?php _e("Min. Height (px)",'revslider'); ?>" style="width:60px" id="layer_min_height" name="layer_min_height" value="">											
					</span>

					<!-- RESET ORIGINAL SIZE -->
					<span id="reset-scale" class="ho_column_ ho_row_ ho_group_ ho_svg_ ho_text_ ho_video_ ho_shape_"></span>

					<!-- MEDIA PROPORTION -->
					<span id="layer-prop-wrapper" class="rs-proportion-check layer-toolbar-button ho_column_ ho_row_ ho_svg_" title="<?php _e("Keep Aspect Ratio (on/off)",'revslider'); ?>">												
						<input type="checkbox" id="layer_proportional_scale" class="inputCheckbox" name="layer_proportional_scale">
					</span>

				</span>

				<span class="rs-layer-toolbar-box">	
						
					

					

					

					<!-- LINE BREAK -->					
					<span id="layer-linebreak-wrapper" class="rs-linebreak-check layer-toolbar-button tipsy_enabled_top ho_column_ ho_row_ ho_group_ ho_svg_" title="<?php _e("Auto Linebreak (on/off - White Space:normal / nowrap).  ",'revslider'); ?>">												
						<input type="checkbox" id="layer_auto_line_break" class="inputCheckbox" name="layer_auto_line_break" >
					</span>

					<!-- DISPLAY MODE -->					
					<span id="layer-displaymode-wrapper" class="rs-displaymode-check layer-toolbar-button tipsy_enabled_top show_on_miw ho_row_ ho_column_ ho_row_ ho_group_ ho_svg_" title="<?php _e("Display Mode Block / Inline-Block).  ",'revslider'); ?>">												
						<input type="checkbox" id="layer_displaymode" class="inputCheckbox" name="layer_displaymode" >						
					</span>

					<!-- DISPLAY OPTIONS (NONE VISIBLE) -->
					<span class="rs-layer-toolbar-box tipsy_enabled_top" style="display: none">						
						<select id="layer_display" name="layer_display">
							<option value="block" selected="selected"><?php _e('Block', 'revslider'); ?></option>
							<option value="inline-block"><?php _e('Inline-Block', 'revslider'); ?></option>
							<option value="flex"><?php _e('Flex', 'revslider'); ?></option>
							<option value="table"><?php _e('Table', 'revslider'); ?></option>
							<option value="table-cell"><?php _e('Table-Cell', 'revslider'); ?></option>
						</select>
					</span>

					
				</span>

				<span class="rs-layer-toolbar-box">	

					<!-- COVERMODE -->
					<span id="layer-covermode-wrapper" class="tipsy_enabled_top ho_row_ ho_column_" title="<?php _e("Cover Mode",'revslider'); ?>">						
						<i class="rs-mini-layer-icon rs-toolbar-icon rs-cover-size-icon"></i>
						<select class="rs-layer-input-field"  style="width:75px" id="layer_cover_mode" name="layer_cover_mode">
							<option value="custom"><?php _e('Custom', 'revslider'); ?></option>
							<option value="fullwidth"><?php _e('Full Width', 'revslider'); ?></option>
							<option value="fullheight"><?php _e('Full Height', 'revslider'); ?></option>
							<option value="cover"><?php _e('Stretch', 'revslider'); ?></option>
							<option value="cover-proportional"><?php _e('Cover', 'revslider'); ?></option>
						</select>
					</span>
					
				</span>
			</div>


			<!-- SUB SETTINGS FOR CSS -->
			<div id="style_form_wrapper">
				<div id="extra_style_settings" class="extra_sub_settings_wrapper" >
					<div class="close_extra_settings"></div>
					<div class="inner-settings-wrapper">
						<div id="tp-idle-state-advanced-style" style="float:left; padding-left:20px;">
							
							<ul class="rs-layer-animation-settings-tabs" style="display:inline-block; ">
								<li data-content="#style-sub-font" class="selected ho_row_ ho_column_ ho_group_ ho_image_ ho_shape_"><?php _e("Font",'revslider'); ?></li>
								<li data-content="#style-sub-background"><?php _e("Background",'revslider'); ?></li>
								<li data-content="#style-sub-spaces"><?php _e("Spaces",'revslider'); ?></li>
								<li data-content="#style-sub-border"><?php _e("Border",'revslider'); ?></li>
								<li data-content="#style-sub-transfrom" ><?php _e("Transform",'revslider'); ?></li>
								<li data-content="#style-sub-rotation" ><?php _e("Rotation",'revslider'); ?></li>
								<li data-content="#style-sub-perspective"><?php _e("Perspective",'revslider'); ?></li>								
								<li data-content="#style-sub-svg" class="ho_row_ ho_column_ ho_group_ ho_image_ ho_shape_ ho_video_ ho_button_"><?php _e("SVG",'revslider'); ?></li>
								<li data-content="#style-sub-sharpc" class="ho_row_ ho_column_ ho_group_ ho_image_"><?php _e("Corners",'revslider'); ?></li>								
								<li data-content="#style-sub-advcss"><?php _e("Advanced CSS",'revslider'); ?></li>		
								<li data-content="#style-sub-hover"><?php _e("Hover",'revslider'); ?></li>
								<li data-content="#style-sub-toggle"><?php _e("Toggle",'revslider'); ?></li>		
							</ul>
							<div style="width:100%;height:1px;display:block"></div>
							<span id="style-sub-font" class="rs-layer-toolbar-box ho_shape_ ho_video_ ho_image_ ho_row_ ho_column_ ho_group_" style="display:block">

								<!-- FONT OPACITY -->
								<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Font Opacity",'revslider'); ?>" style="margin-right:10px"></i>
								<input data-suffix="" data-steps="0.05" data-min="0" data-max="1" class="rs-staticcustomstylechange pad-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Font Opacity",'revslider'); ?>" style="width:50px" type="text" id="css_font-transparency" name="css_font-transparency" value="1">
								<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

								<!-- ITALIC -->
								<i class="rs-mini-layer-icon rs-icon-italic rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Italic Font",'revslider'); ?>" style="margin-right:10px"></i>
								<input type="checkbox" id="css_font-style" name="css_font-style" class="rs-staticcustomstylechange tipsy_enabled_top tp-moderncheckbox" title="<?php _e("Italic Font On/Off",'revslider'); ?>">
								<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

								<!-- DECORATION -->
								<i class="rs-mini-layer-icon rs-icon-decoration rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Font Decoration",'revslider'); ?>" style="margin-right:10px"></i>
								<select class="rs-staticcustomstylechange rs-layer-input-field  tipsy_enabled_top" title="<?php _e("Font Decoration",'revslider'); ?>" style="width:100px;cursor:pointer" id="css_text-decoration" name="css_text-decoration">
									<option value="none"><?php _e('none', 'revslider'); ?></option>
									<option value="underline"><?php _e('underline', 'revslider'); ?></option>
									<option value="overline"><?php _e('overline', 'revslider'); ?></option>
									<option value="line-through"><?php _e('line-through', 'revslider'); ?></option>
								</select>

								<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

								<!-- TEXT TRANSFORM -->
								<i class="rs-mini-layer-icon rs-icon-transform rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Text Transform",'revslider'); ?>" style="margin-right:10px"></i>
								<select class="rs-staticcustomstylechange rs-layer-input-field  tipsy_enabled_top" title="<?php _e("Text Transform",'revslider'); ?>" style="width:100px;cursor:pointer" id="css_text-transform" name="css_text-transform">
									<option value="none"><?php _e('None', 'revslider'); ?></option>
									<option value="lowercase"><?php _e('Lowercase', 'revslider'); ?></option>
									<option value="uppercase"><?php _e('Uppercase', 'revslider'); ?></option>
									<option value="capitalize"><?php _e('Capitalize', 'revslider'); ?></option>
								</select>


								

							

								<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

								<!-- LAYER SELECTABLE -->
								<i class="rs-mini-layer-icon eg-icon-lightbulb rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Layer is Selectable",'revslider'); ?>" style="margin-right:10px"></i>
								<!--input type="checkbox" id="css_layer_selectable" name="css_layer_selectable-style" class="rs-staticcustomstylechange tipsy_enabled_top tp-moderncheckbox" title="<?php _e("Layer is Selectable / Markable on Frontend",'revslider'); ?>"-->
								<select class="rs-staticcustomstylechange rs-layer-input-field  tipsy_enabled_top" title="<?php _e("Layer is Selectable / Markable on Frontend",'revslider'); ?>" style="width:100px;cursor:pointer" id="css_layer_selectable" name="css_layer_selectable-style">
									<option value="default"><?php _e('Default', 'revslider'); ?></option>
									<option value="off"><?php _e('Off', 'revslider'); ?></option>
									<option value="on"><?php _e('On', 'revslider'); ?></option>
								</select>
								<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>
								
							</span>


							<span id="style-sub-background" class="rs-layer-toolbar-box" style="display:none;border:none;">
								<!-- BACKGROUND COLOR -->
								<i class="rs-mini-layer-icon rs-icon-bg rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Background Color",'revslider'); ?>" style="margin-right:10px"></i>
								<input type="text" class="rs-staticcustomstylechange rs-layer-input-field tipsy_enabled_top my-color-field" title="<?php _e("Background Color",'revslider'); ?>" style="width:150px" id="css_background-color" name="css_background-color" value="transparent" />
								<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

								<!-- BACKGROUND OPACITY -->
								<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Background Opacity",'revslider'); ?>" style="margin-right:10px"></i>
								<input data-suffix="" data-steps="0.05" data-min="0" data-max="1" class="rs-staticcustomstylechange pad-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Background Opacity",'revslider'); ?>" style="width:50px" type="text" id="css_background-transparency" name="css_background-transparency" value="1">
								<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>
								
								<!-- BLEND MODE -->
								<i class="rs-mini-layer-icon fa-icon-star-half-empty rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Blend Mode (Not available for IE)",'revslider'); ?>" style="margin-right:10px"></i>
								<select class="rs-staticcustomstylechange rs-layer-input-field  tipsy_enabled_top" title="<?php _e("Blend Mode (Not available for IE)",'revslider'); ?>" style="width:100px;cursor:pointer" id="layer_blend_mode" name="layer_blend_mode">
									<option value="normal"><?php _e('normal', 'revslider'); ?></option>
									<option value="multiply"><?php _e('multiply', 'revslider'); ?></option>
									<option value="screen"><?php _e('screen', 'revslider'); ?></option>
									<option value="overlay"><?php _e('overlay', 'revslider'); ?></option>
									<option value="darken"><?php _e('darken', 'revslider'); ?></option>
									<option value="lighten"><?php _e('lighten', 'revslider'); ?></option>
									<option value="color-dodge"><?php _e('color-dodge', 'revslider'); ?></option>
									<option value="color-burn"><?php _e('color-burn', 'revslider'); ?></option>
									<option value="hard-light"><?php _e('hard-light', 'revslider'); ?></option>
									<option value="soft-light"><?php _e('soft-light', 'revslider'); ?></option>
									<option value="difference"><?php _e('difference', 'revslider'); ?></option>
									<option value="exclusion"><?php _e('exclusion', 'revslider'); ?></option>
									<option value="hue"><?php _e('hue', 'revslider'); ?></option>
									<option value="saturation"><?php _e('saturation', 'revslider'); ?></option>
									<option value="color"><?php _e('color', 'revslider'); ?></option>
									<option value="luminosity"><?php _e('luminosity', 'revslider'); ?></option>									
								</select>
								<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>
								
								<span class="ho_image_ ho_video_ ho_audio_ ho_image_ ">
									<!-- BACKGROUND IMAGE FOR CERTAIN LAYERS -->
									<i class="rs-mini-layer-icon eg-icon-picture-1 rs-toolbar-icon tipsy_enabled_top" title="<?php _e('Background Image','revslider'); ?>" style="margin-right:10px"></i>
									<a href="javascript:void(0)" id="button_change_background_image" class="button-primary revblue" ><i class="fa-icon-wordpress"></i></a>
									<a href="javascript:void(0)" id="button_change_background_image_objlib" class="button-primary revpurple" ><i class="fa-icon-book"></i></a>
									<a href="javascript:void(0)" id="button_clear_background_image" class="button-primary revred" ><i class="fa-icon-trash"></i></a>
									<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>
										
									<!-- BACKGROUND POSITION ALIGN -->
									<i class="rs-mini-layer-icon eg-icon-move rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Background Position",'revslider'); ?>" style="margin-right:5px"></i>
									<select class="rs-staticcustomstylechange rs-layer-input-field  tipsy_enabled_top" title="<?php _e("Background Position",'revslider'); ?>" style="width:100px;cursor:pointer" id="layer_bg_position" name="layer_bg_position">
										<option value="left top"><?php _e('Left Top', 'revslider'); ?></option>
										<option value="center top"><?php _e('Center Top', 'revslider'); ?></option>
										<option value="right top"><?php _e('Right Top', 'revslider'); ?></option>
										<option value="left center"><?php _e('Left Center', 'revslider'); ?></option>
										<option value="center center"><?php _e('Center Center', 'revslider'); ?></option>
										<option value="right center"><?php _e('Right Center', 'revslider'); ?></option>
										<option value="left bottom"><?php _e('Left Bottom', 'revslider'); ?></option>
										<option value="center bottom"><?php _e('Center Bottom', 'revslider'); ?></option>
										<option value="right bottom"><?php _e('Right Bottom', 'revslider'); ?></option>
									</select>
									<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

									<!-- BACKGROUND SIZE  -->
									<i class="rs-mini-layer-icon fa-icon-arrows-alt rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Background Size",'revslider'); ?>"></i>
									<select class="rs-staticcustomstylechange rs-layer-input-field  tipsy_enabled_top" title="<?php _e("Background Size",'revslider'); ?>" style="width:100px;cursor:pointer" id="layer_bg_size" name="layer_bg_size">
										<option value="cover"><?php _e('Cover', 'revslider'); ?></option>
										<option value="contain"><?php _e('Contain', 'revslider'); ?></option>
									</select>
									<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>
									
									<!-- BACKGROUND REPEAT  -->
									<i class="rs-mini-layer-icon  fa-icon-th-large rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Background Repeat",'revslider'); ?>" ></i>
									<select class="rs-staticcustomstylechange rs-layer-input-field  tipsy_enabled_top" title="<?php _e('Background Repeat','revslider'); ?>" style="width:100px;cursor:pointer" id="layer_bg_repeat" name="layer_bg_repeat">
										<option value="no-repeat">no-repeat</option>
										<option value="repeat">repeat</option>
										<option value="repeat-x">repeat-x</option>
										<option value="repeat-y">repeat-y</option>
									</select>
								</span>
							</span>

							<!-- LAYER SPACING'S -->
							<span id="style-sub-spaces" class="rs-layer-toolbar-box" style="display:none;border:none;">
								
								
								<!-- PADDING -->
								<i class="rs-mini-layer-icon rs-icon-padding rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Padding",'revslider'); ?>" style="margin-right:10px"></i>
								<input data-suffix="px" class="rs-staticcustomstylechange pad-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Padding Top",'revslider'); ?>" style="width:50px" type="text" name="css_padding[]" value="">
								<input data-suffix="px" class="rs-staticcustomstylechange pad-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Padding Right",'revslider'); ?>" style="width:50px" type="text" name="css_padding[]" value="">
								<input data-suffix="px" class="rs-staticcustomstylechange pad-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Padding Bottom",'revslider'); ?>" style="width:50px" type="text" name="css_padding[]" value="">
								<input data-suffix="px" class="rs-staticcustomstylechange pad-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Padding Left",'revslider'); ?>" style="width:50px" type="text" name="css_padding[]" value="">
								<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

								<!-- MARGIN -->
								<i class="rs-mini-layer-icon rs-icon-margin rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Margin",'revslider'); ?>" style="margin-right:10px"></i>
								<input data-suffix="px" class="rs-staticcustomstylechange margin-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Margin Top",'revslider'); ?>" style="width:50px" type="text" name="css_margin[]" value="">
								<input data-suffix="px" class="rs-staticcustomstylechange margin-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Margin Right",'revslider'); ?>" style="width:50px" type="text" name="css_margin[]" value="">
								<input data-suffix="px" class="rs-staticcustomstylechange margin-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Margin Bottom",'revslider'); ?>" style="width:50px" type="text" name="css_margin[]" value="">
								<input data-suffix="px" class="rs-staticcustomstylechange margin-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Margin Left",'revslider'); ?>" style="width:50px" type="text" name="css_margin[]" value="">
								<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>
								
								<!-- TEXT ALIGN -->
								<i class="ho_row_ rs-mini-layer-icon rs-icon-text-align rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Text Align",'revslider'); ?>" style="margin-right:10px"></i>
								<select class="ho_row_ rs-staticcustomstylechange rs-layer-input-field  tipsy_enabled_top" title="<?php _e("Text Align",'revslider'); ?>" style="width:100px;cursor:pointer" id="css_text-align" name="css_text-align">
									<option value="inherit"><?php _e('Inherit', 'revslider'); ?></option>
									<option value="left"><?php _e('Left', 'revslider'); ?></option>
									<option value="center"><?php _e('Center', 'revslider'); ?></option>
									<option value="right"><?php _e('Right', 'revslider'); ?></option>
								</select>
								<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

								<!-- TEXT ALIGN VERTICAL (NOT USED YET, NOT VISIBLE !!)-->
								<!--<i class="ho_row_ rs-mini-layer-icon rs-icon-vertical-align rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Vertical Align ",'revslider'); ?>" style="margin-right:10px"></i>
								<select class="ho_row_ rs-staticcustomstylechange rs-layer-input-field  tipsy_enabled_top" title="<?php _e("Vertical Align",'revslider'); ?>" style="width:100px;cursor:pointer" id="css_vertical-align" name="css_vertical-align">
									<option value="top"><?php _e('Top', 'revslider'); ?></option>
									<option value="middle"><?php _e('Middle', 'revslider'); ?></option>
									<option value="bottom"><?php _e('Bottom', 'revslider'); ?></option>
								</select>-->

								<!-- ROW BREAK (NOT VISIBLE !!) -->								
								<select style="display:none" class="rs-staticcustomstylechange rs-layer-input-field  tipsy_enabled_top" title="<?php _e("Columns Break at",'revslider'); ?>" style="width:100px;cursor:pointer" id="column_break_at" name="column_break_at">
									<option value="notebook"><?php _e('notebook', 'revslider'); ?></option>
									<option value="tablet"><?php _e('tablet', 'revslider'); ?></option>
									<option value="mobile" selected="selected"><?php _e('mobile', 'revslider'); ?></option>
								</select>


								<!-- OVERFLOW (HIDDEN/VISIBLE) ONLY FOR GROUPS FIRST -->
								<i class="ho_row_ ho_column_ ho_image_ ho_shape_ ho_button_ ho_video_ ho_svg_ ho_sltic_ ho_text_ rs-mini-layer-icon fa-icon-object-group rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Overflow",'revslider'); ?>" style="margin-right:10px"></i>
								<select class="ho_row_ ho_column_ ho_image_ ho_shape_ ho_button_ ho_video_ ho_svg_ ho_sltic_ ho_text_ rs-staticcustomstylechange rs-layer-input-field  tipsy_enabled_top" title="<?php _e("Overflow",'revslider'); ?>" style="width:100px;cursor:pointer" id="css_overflow" name="css_overflow">
									<option value="visible"><?php _e('Visible', 'revslider'); ?></option>
									<option value="hidden"><?php _e('Hidden', 'revslider'); ?></option>									
								</select>
								<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

								
							</span>

							<span id="style-sub-border" class="rs-layer-toolbar-box" style="display:none;border:none;">
								<!-- BORDER COLOR -->
								<i class="rs-mini-layer-icon rs-icon-bordercolor rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Border Color",'revslider'); ?>" style="margin-right:10px"></i>
								<input type="text" class="rs-staticcustomstylechange my-color-field rs-layer-input-field tipsy_enabled_top" title="<?php _e("Border Color",'revslider'); ?>"  style="width:150px" id="css_border-color-show" name="css_border-color-show" value="transparent" />
								<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

								<!-- FONT OPACITY -->
								<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Border Opacity",'revslider'); ?>" style="margin-right:10px"></i>
								<input data-suffix="" data-steps="0.05" data-min="0" data-max="1" class="rs-staticcustomstylechange pad-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Border Opacity",'revslider'); ?>" style="width:50px" type="text" id="css_border-transparency" name="css_border-transparency" value="1">
								<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

								<!-- BORDER STYLE -->
								<i class="rs-mini-layer-icon rs-icon-borderstyle rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Border Style",'revslider'); ?>" style="margin-right:10px"></i>
								<select class="rs-staticcustomstylechange rs-layer-input-field tipsy_enabled_top" title="<?php _e("Border Style",'revslider'); ?>" style="width:100px cursor:pointer" id="css_border-style" name="css_border-style">
									<option value="none"><?php _e('none', 'revslider'); ?></option>
									<option value="dotted"><?php _e('dotted', 'revslider'); ?></option>
									<option value="dashed"><?php _e('dashed', 'revslider'); ?></option>
									<option value="solid"><?php _e('solid', 'revslider'); ?></option>
									<option value="double"><?php _e('double', 'revslider'); ?></option>
								</select>
								<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

								<!-- BORDER WIDTH-->
								<i class="rs-mini-layer-icon rs-icon-borderwidth rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Border Width",'revslider'); ?>" style="margin-right:10px"></i>
								<input data-suffix="px" class="rs-staticcustomstylechange corn-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Border Width Top",'revslider'); ?>" style="width:50px" type="text" name="css_border-width[]" value="0">
								<input data-suffix="px" class="rs-staticcustomstylechange corn-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Border Width Right",'revslider'); ?>" style="width:50px" type="text" name="css_border-width[]" value="0">
								<input data-suffix="px" class="rs-staticcustomstylechange corn-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Border Width Bottom",'revslider'); ?>" style="width:50px" type="text" name="css_border-width[]" value="0">
								<input data-suffix="px" class="rs-staticcustomstylechange corn-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Border Width Left",'revslider'); ?>" style="width:50px" type="text" name="css_border-width[]" value="0">
								
								<span class="rs-layer-toolbar-space" style="margin-right:16px"></span>

								<!-- BORDER RADIUS -->
								<i class="rs-mini-layer-icon rs-icon-borderradius rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Border Radius (px)",'revslider'); ?>" style="margin-right:10px"></i>
								<input data-suffix="px" data-suffixalt="%" class="rs-staticcustomstylechange corn-input text-sidebar rs-layer-input-field tipsy_enabled_top" data-steps="1" data-min="0"  title="<?php _e("Border Radius Top Left",'revslider'); ?>" style="width:50px" type="text" name="css_border-radius[]" value="">
								<input data-suffix="px" data-suffixalt="%" class="rs-staticcustomstylechange corn-input text-sidebar rs-layer-input-field tipsy_enabled_top" data-steps="1" data-min="0" title="<?php _e("Border Radius Top Right",'revslider'); ?>" style="width:50px" type="text" name="css_border-radius[]" value="">
								<input data-suffix="px" data-suffixalt="%" class="rs-staticcustomstylechange corn-input text-sidebar rs-layer-input-field tipsy_enabled_top" data-steps="1" data-min="0" title="<?php _e("Border Radius Bottom Right",'revslider'); ?>" style="width:50px" type="text" name="css_border-radius[]" value="">
								<input data-suffix="px" data-suffixalt="%" class="rs-staticcustomstylechange corn-input text-sidebar rs-layer-input-field tipsy_enabled_top" data-steps="1" data-min="0" title="<?php _e("Border Radius Bottom Left",'revslider'); ?>" style="width:50px" type="text" name="css_border-radius[]" value="">
							</span>

						
							<span id="style-sub-rotation" class="rs-layer-toolbar-box" style="display:none;border:none;">
								<!--  X  ROTATE -->
								<i class="rs-mini-layer-icon rs-icon-rotationx rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Rotation on X axis (+/-)",'revslider'); ?>"></i>
								<input data-suffix="deg" type="text" style="width:55px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Rotation on X axis (+/-)",'revslider'); ?>" id="layer__xrotate" name="layer__xrotate" value="0">
								<span class="rs-layer-toolbar-space"></span>
								<!--  Y ROTATE -->
								<i class="rs-mini-layer-icon rs-icon-rotationy rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Rotation on Y axis (+/-)",'revslider'); ?>"></i>
								<input data-suffix="deg" type="text" style="width:55px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Rotation on Y axis (+/-)",'revslider'); ?>" id="layer__yrotate" name="layer__yrotate" value="0">
								<span class="rs-layer-toolbar-space"></span>

								<!--  Z ROTATE -->
								<i class="rs-mini-layer-icon rs-icon-rotationz rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Rotation on Z axis (+/-)",'revslider'); ?>"></i>
								<input data-suffix="deg" type="text" style="width:55px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Rotation on Z axis (+/-)",'revslider'); ?>" id="layer_2d_rotation" name="layer_2d_rotation" value="0">
								<span class="rs-layer-toolbar-space" style="margin-right:15px;"></span>
								
								<!-- ORIGIN X -->
								<i class="rs-mini-layer-icon rs-icon-originx rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Horizontal Origin",'revslider'); ?>"></i>
								<input data-suffix="%" type="text" style="width:55px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Horizontal Origin",'revslider'); ?>" id="layer_2d_origin_x" name="layer_2d_origin_x" value="50">
								<span class="rs-layer-toolbar-space"></span>
								<!-- ORIGIN Y -->
								<i class="rs-mini-layer-icon rs-icon-originy rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Vertical Origin",'revslider'); ?>"></i>
								<input data-suffix="%" type="text" style="width:55px;" class="textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Vertical Origin",'revslider'); ?>" id="layer_2d_origin_y" name="layer_2d_origin_y" value="50">
					
							</span>

							<span id="style-sub-transfrom" class="rs-layer-toolbar-box" style="display:none;border:none;">
								<!-- OPACITY -->
								<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Opacity. (1 = 100% Visible / 0.5 = 50% opacaity / 0 = transparent)",'revslider'); ?>" style="margin-right:8px"></i>
								<input data-suffix="" data-steps="0.05" data-min="0" data-max="1"  type="text" style="width:50px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Opacity (1 = 100% Visible / 0.5 = 50% opacaity / 0 = transparent)",'revslider'); ?>" id="layer__opacity" name="layer__opacity" value="1">
								<span class="rs-layer-toolbar-space" style="margin-right:15px;"></span>
								
								<!-- SCALE X -->
								<i class="rs-mini-layer-icon rs-icon-scalex rs-toolbar-icon tipsy_enabled_top" title="<?php _e("X Scale  1 = 100%, 0.5=50%... (+/-)",'revslider'); ?>" style="margin-right:4px"></i>
								<input data-suffix="" data-steps="0.01" data-min="0" type="text" style="width:50px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("X Scale  1 = 100%, 0.5=50%... (+/-)",'revslider'); ?>" id="layer__scalex" name="layer__scalex" value="1">
								<span class="rs-layer-toolbar-space" style="margin-right:15px;"></span>
								
								<!-- SCALE Y -->
								<i  class="rs-mini-layer-icon rs-icon-scaley rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Y Scale  1 = 100%, 0.5=50%... (+/-)",'revslider'); ?>" style="margin-right:8px"></i>
								<input data-suffix="" data-steps="0.01"  data-min="0" type="text" style="width:50px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Y Scale  1 = 100%, 0.5=50%... (+/-)",'revslider'); ?>" id="layer__scaley" name="layer__scaley" value="1">
								<span class="rs-layer-toolbar-space" style="margin-right:15px;"></span>
								
								<!-- SKEW X -->
								<i class="rs-mini-layer-icon rs-icon-skewx rs-toolbar-icon tipsy_enabled_top" title="<?php _e("X Skew (+/-  px)",'revslider'); ?>" style="margin-right:4px"></i>
								<input data-suffix="px" type="text" style="width:50px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field  tipsy_enabled_top" title="<?php _e("X Skew (+/-  px)",'revslider'); ?>" id="layer__skewx" name="layer__skewx" value="0">
								<span class="rs-layer-toolbar-space" style="margin-right:15px;"></span>
								
								<!-- SKEW Y -->
								<i class="rs-mini-layer-icon rs-icon-skewy rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Y Skew (+/-  px)",'revslider'); ?>" style="margin-right:8px"></i>
								<input data-suffix="px" type="text" style="width:50px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Y Skew (+/-  px)",'revslider'); ?>" id="layer__skewy" name="layer__skewy" value="0">
					
							</span>

							<!-- ADVANCED CSS -->
							<span id="style-sub-advcss" class="rs-layer-toolbar-box" style="display:none;border:none;">
								<div id="advanced-css-main" class="rev-advanced-css-idle advanced-copy-button"><?php _e("Template",'revslider'); ?></div>
								<div id="advanced-css-layer" class="rev-advanced-css-idle-layer advanced-copy-button"><?php _e("Layer",'revslider'); ?></div>
							</span>
							
							<?php $easings = $operations->getArrEasing(); ?>
							
							<!-- CAPTION HOVER CSS -->
							<span id="style-sub-hover" class="rs-layer-toolbar-box" style="display:none;border:none;">
								<!-- Caption Hover on/off -->
								<span><?php _e("Layer Hover",'revslider'); ?></span>
								<span class="rs-layer-toolbar-space"></span>
								<input id="hover_allow" name="hover_allow" type="checkbox" class="tp-moderncheckbox" />
								<span class="rs-layer-toolbar-space" style="margin-right: 10px"></span>
								
								<!-- ANIMATION START SPEED -->
								<i class="rs-mini-layer-icon rs-icon-clock rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Hover Animation Speed (in ms)",'revslider'); ?>"></i>
								<input type="text" style="width:90px; padding-right:10px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Hover Animation Speed (in ms)",'revslider'); ?>" id="hover_speed" name="hover_speed" value="">
								<span class="rs-layer-toolbar-space" style="margin-right: 10px"></span>
								
								
								<!-- HOVER EASE -->
								<i class="rs-mini-layer-icon rs-icon-easing rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Hover Animation Easing",'revslider'); ?>"></i>
								<select class="rs-layer-input-field tipsy_enabled_top" title="<?php _e("Hover Animation Easing",'revslider'); ?>" style="width:140px"  id="hover_easing" name="hover_easing">
									<?php
									foreach($easings as $ehandle => $ename){
										echo '<option value="'.$ehandle.'">'.$ename.'</option>';
									}
									?>
								</select>
								<span class="rs-layer-toolbar-space" style="margin-right: 10px"></span>

								<!-- CURSOR -->
								<i class="rs-mini-layer-icon eg-icon-up-hand rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Mouse Cursor",'revslider'); ?>" style="margin-right:10px"></i>
								<select class="rs-staticcustomstylechange rs-layer-input-field tipsy_enabled_top" title="<?php _e("Mouse Cursor",'revslider'); ?>" style="width:100px cursor:pointer" id="css_cursor" name="css_cursor">
									<option value="auto"><?php _e('auto', 'revslider'); ?></option>
									<option value="default"><?php _e('default', 'revslider'); ?></option>
									<option value="crosshair"><?php _e('crosshair', 'revslider'); ?></option>
									<option value="pointer"><?php _e('pointer', 'revslider'); ?></option>
									<option value="move"><?php _e('move', 'revslider'); ?></option>
									<option value="text"><?php _e('text', 'revslider'); ?></option>
									<option value="wait"><?php _e('wait', 'revslider'); ?></option>
									<option value="help"><?php _e('help', 'revslider'); ?></option>
									<option value="zoom-in"><?php _e('zoom-in', 'revslider'); ?></option>
									<option value="zoom-out"><?php _e('zoom-out', 'revslider'); ?></option>
								</select>
								<span class="rs-layer-toolbar-space" style="margin-right: 10px"></span>
								
								<!-- HOVER Z-INDEX -->
								<i class="rs-mini-layer-icon eg-icon-resize-vertical rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Z-Index",'revslider'); ?>" style="margin-right:10px"></i>
								<input type="text" style="width:90px; padding-right:10px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Hover Z-Index (Enter z-index level or enter auto for default value)",'revslider'); ?>" id="hover_zindex" name="hover_zindex" value="auto">
								<span class="rs-layer-toolbar-space" style="margin-right: 10px"></span>

								<!--Force Straight Hover Rendering -->
								<span><?php _e("Force Animation",'revslider'); ?></span>
								<span class="rs-layer-toolbar-space"></span>
								<input id="force_hover" name="force_hover" type="checkbox" class="tp-moderncheckbox" />
								
								
								
							</span>

							<!-- LAYER TOGGLE SETTINGS -->
							<span id="style-sub-toggle" class="rs-layer-toolbar-box" style="display:none;border:none;">
								<!-- Toggle Hover on/off -->
								<span><?php _e("Layer Toggle Mode",'revslider'); ?></span>
								<span class="rs-layer-toolbar-space"></span>
								<input id="toggle_allow" name="toggle_allow" type="checkbox" class="tp-moderncheckbox" />
								<span class="rs-layer-toolbar-space" style="margin-right: 10px"></span>

								<!-- Toggle ACTIVE Mode -->
								<span><?php _e("Use Hover Style when Toggle is Active",'revslider'); ?></span>
								<span class="rs-layer-toolbar-space"></span>
								<input id="toggle_use_hover" name="toggle_use_hover" type="checkbox" class="tp-moderncheckbox" />
								<span class="rs-layer-toolbar-space" style="margin-right: 10px"></span>								

								<!-- Toggle Invers Mode -->
								<span><?php _e("Invers Toggle Content",'revslider'); ?></span>
								<span class="rs-layer-toolbar-space"></span>
								<input id="toggle_inverse_content" name="toggle_inverse_content" type="checkbox" class="tp-moderncheckbox" />
								<span class="rs-layer-toolbar-space" style="margin-right: 10px"></span>								
								
							</span>

							

							<span id="style-sub-perspective" class="rs-layer-toolbar-box" style="display:none;border:none;">
								<!-- PERSPECTIVE -->
								<i class="rs-mini-layer-icon rs-icon-perspective rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Animation Perspective (default 600)",'revslider'); ?>" style="margin-right:8px"></i>
								<input type="text" style="width:50px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Animation Perspective (default 600)",'revslider'); ?>" id="layer__pers" name="layer__pers" value="600">
								<span class="rs-layer-toolbar-space"></span>

								<!-- Z - OFFSET -->
								<i class="rs-mini-layer-icon rs-icon-zoffset rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Z Offset (+/-  px)",'revslider'); ?>" style="margin-right:4px"></i>
								<input data-suffix="px" type="text" style="width:50px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Z Offset (+/-  px)",'revslider'); ?>" id="layer__z" name="layer__z" value="0">
							</span>
							
							
							<span id="style-sub-sharpc" class="rs-layer-toolbar-box" style="display:none;border:none;">

								<span><?php _e("Sharp Left",'revslider'); ?></span>
								<span class="rs-layer-toolbar-space"></span>
								<select id="layer_cornerleft" name="layer_cornerleft" class="rs-layer-input-field" style="width:175px">
									<option value="nothing" selected="selected"><?php _e("No Corner",'revslider'); ?></option>
									<option value="curved"><?php _e("Sharp",'revslider'); ?></option>
									<option value="reverced"><?php _e("Sharp Reversed",'revslider'); ?></option>
								</select>
								<span class="rs-layer-toolbar-space"></span>
	
								<span><?php _e("Sharp Right",'revslider'); ?></span>
								<span class="rs-layer-toolbar-space"></span>
								<select id="layer_cornerright" name="layer_cornerright" class="rs-layer-input-field" style="width:175px">
									<option value="nothing" selected="selected"><?php _e("No Corner",'revslider'); ?></option>
									<option value="curved"><?php _e("Sharp",'revslider'); ?></option>
									<option value="reverced"><?php _e("Sharp Reversed",'revslider'); ?></option>
								</select>

							</span>

							<span id="style-sub-svg" class="rs-layer-toolbar-box" style="display:none;border:none;">

								<!-- SVG STROKE COLOR -->
								<i class="rs-mini-layer-icon rs-icon-bordercolor rs-toolbar-icon tipsy_enabled_top" title="<?php _e("SVG Stroke Color",'revslider'); ?>" style="margin-right:10px"></i>
								<input type="text" class="rs-staticcustomstylechange my-color-field rs-layer-input-field tipsy_enabled_top" title="<?php _e("SVG Stroke Color",'revslider'); ?>"  style="width:150px" id="css_svgstroke-color-show" name="css_svgstroke-color-show" value="transparent" />
								<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

								<!-- SVG STROKE OPACITY -->
								<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon tipsy_enabled_top" title="<?php _e("SVG Stroke Opacity",'revslider'); ?>" style="margin-right:10px"></i>
								<input data-suffix="" data-steps="0.05" data-min="0" data-max="1" class="rs-staticcustomstylechange pad-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("SVG Stroke Opacity",'revslider'); ?>" style="width:50px" type="text" id="css_svgstroke-transparency" name="css_svgstroke-transparency" value="1">
								<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

								<!-- SVG STROKE WIDTH-->
								<i class="rs-mini-layer-icon rs-icon-borderwidth rs-toolbar-icon tipsy_enabled_top" title="<?php _e("SVG Stroke Width",'revslider'); ?>" style="margin-right:10px"></i>
								<input data-suffix="px" class="rs-staticcustomstylechange pad-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("SVG Stroke Width",'revslider'); ?>" style="width:50px" type="text" id="css_svgstroke-width" name="css_svgstroke-width" value="0">
								<span class="rs-layer-toolbar-space" style="margin-right:16px"></span>
								
								<!-- SVG STROKE DASHARRAY -->
								<i class="rs-mini-layer-icon rs-icon-borderstyle rs-toolbar-icon tipsy_enabled_top" title="<?php _e("SVG Stroke Dasharray",'revslider'); ?>" style="margin-right:10px"></i>
								<input type="text" class="rs-layer-input-field tipsy_enabled_top" style="width:61px" id="css_svgstroke-dasharray" name="css_svgstroke-dasharray" value="" original-title="<?php _e("SVG Stroke Dash Array",'revslider'); ?>">
								<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

								<!-- SVG STROKE DASH OFFSET -->
								<i style="transform: rotateZ(90deg);-webkit-transform: rotateZ(90deg);" class="rs-mini-layer-icon eg-icon-arrow-combo rs-toolbar-icon tipsy_enabled_top" title="<?php _e("SVG Stroke Dash Offset",'revslider'); ?>" style="margin-right:3px"></i>
								<input type="text" class="rs-layer-input-field tipsy_enabled_top" style="width:61px" id="css_svgstroke-dashoffset" name="css_svgstroke-dashoffset" value="" original-title="<?php _e("SVG Stroke Dash Offset",'revslider'); ?>">

							</span>
						</div>
						
						<!-- THE HOVER STLYE PART -->
						<div id="tp-hover-state-advanced-style" style="float:left;display:none; padding-left:20px;">
								<ul class="rs-layer-animation-settings-tabs" style="display:inline-block;min-width:615px ">
									<li data-content="#hover-sub-font" class="selected"><?php _e("Font",'revslider'); ?></li>
									<li data-content="#hover-sub-background"><?php _e("Background",'revslider'); ?></li>
									<li data-content="#hover-sub-border"><?php _e("Border",'revslider'); ?></li>
									<li data-content="#hover-sub-svg"><?php _e("SVG",'revslider'); ?></li>
									<li data-content="#hover-sub-transform"><?php _e("Transform",'revslider'); ?></li>
									<li data-content="#hover-sub-rotation" ><?php _e("Rotation",'revslider'); ?></li>
									<li data-content="#hover-sub-advcss" ><?php _e("Advanced CSS",'revslider'); ?></li>
								</ul>

								<div style="width:100%;height:1px;display:block"></div>

								<span id="hover-sub-svg" class="rs-layer-toolbar-box" style="display:none;border:none;">

									<!-- SVG STROKE COLOR -->
									<i class="rs-mini-layer-icon rs-icon-bordercolor rs-toolbar-icon tipsy_enabled_top" title="<?php _e("SVG Stroke Color",'revslider'); ?>" style="margin-right:10px"></i>
									<input type="text" class="rs-staticcustomstylechange my-color-field rs-layer-input-field tipsy_enabled_top" title="<?php _e("SVG Stroke Color",'revslider'); ?>"  style="width:150px" id="css_svgstroke-hover-color-show" name="css_svgstroke-hover-color-show" value="transparent" />
									<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

									<!-- SVG STROKE OPACITY -->
									<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon tipsy_enabled_top" title="<?php _e("SVG Stroke Opacity",'revslider'); ?>" style="margin-right:10px"></i>
									<input data-suffix="" data-steps="0.05" data-min="0" data-max="1" class="rs-staticcustomstylechange pad-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("SVG Stroke Opacity",'revslider'); ?>" style="width:50px" type="text" id="css_svgstroke-hover-transparency" name="css_svgstroke-hover-transparency" value="1">
									<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

									<!-- SVG STROKE WIDTH-->
									<i class="rs-mini-layer-icon rs-icon-borderwidth rs-toolbar-icon tipsy_enabled_top" title="<?php _e("SVG Stroke Width",'revslider'); ?>" style="margin-right:10px"></i>
									<input data-suffix="px" class="rs-staticcustomstylechange pad-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("SVG Stroke Width",'revslider'); ?>" style="width:50px" type="text" id="css_svgstroke-hover-width" name="css_svgstroke-hover-width" value="0">
									<span class="rs-layer-toolbar-space" style="margin-right:16px"></span>
									
									<!-- SVG STROKE DASHARRAY -->
									<i class="rs-mini-layer-icon rs-icon-borderstyle rs-toolbar-icon tipsy_enabled_top" title="<?php _e("SVG Stroke Dasharray",'revslider'); ?>" style="margin-right:10px"></i>
									<input type="text" class="rs-layer-input-field tipsy_enabled_top" style="width:61px" id="css_svgstroke-hover-dasharray" name="css_svgstroke-hover-dasharray" value="" original-title="<?php _e("SVG Stroke Dash Array",'revslider'); ?>">
									<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

									<!-- SVG STROKE DASH OFFSET -->
									<i style="transform: rotateZ(90deg);-webkit-transform: rotateZ(90deg);" class="rs-mini-layer-icon eg-icon-arrow-combo rs-toolbar-icon tipsy_enabled_top" title="<?php _e("SVG Stroke Dash Offset",'revslider'); ?>" style="margin-right:3px"></i>
									<input type="text" class="rs-layer-input-field tipsy_enabled_top" style="width:61px" id="css_svgstroke-hover-dashoffset" name="css_svgstroke-hover-dashoffset" value="" original-title="<?php _e("SVG Stroke Dash Offset",'revslider'); ?>">

								</span>

								<span id="hover-sub-font" class="rs-layer-toolbar-box" style="display:block">

									<i class="rs-mini-layer-icon rs-icon-color rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Font Color",'revslider'); ?>"></i>
									<input type="text" class="my-color-field rs-layer-input-field tipsy_enabled_top" title="<?php _e("Font Color",'revslider'); ?>"  id="hover_layer_color_s" name="hover_color_static" value="#ff0000" />
									<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

									<!-- FONT HOVER OPACITY -->
									<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Font Hover Opacity",'revslider'); ?>" style="margin-right:10px"></i>
									<input data-suffix="" data-steps="0.05" data-min="0" data-max="1" class="rs-staticcustomstylechange pad-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Font Hover Opacity",'revslider'); ?>" style="width:50px" type="text" id="hover_css_font-transparency" name="hover_css_font-transparency" value="1">
									<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

									<!-- DECORATION -->
									<i class="rs-mini-layer-icon rs-icon-decoration rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Font Decoration",'revslider'); ?>" style="margin-right:10px"></i>
									<select class="rs-staticcustomstylechange rs-layer-input-field  tipsy_enabled_top" title="<?php _e("Font Decoration",'revslider'); ?>" style="width:100px;cursor:pointer" id="hover_css_text-decoration" name="hover_css_text-decoration">
										<option value="none"><?php _e('none' ,'revslider'); ?></option>
										<option value="underline"><?php _e('underline' ,'revslider'); ?></option>
										<option value="overline"><?php _e('overline' ,'revslider'); ?></option>
										<option value="line-through"><?php _e('line-through' ,'revslider'); ?></option>
									</select>
								</span>
								
								<span id="hover-sub-background" class="rs-layer-toolbar-box" style="display:none;border:none;">
									<!-- BACKGROUND COLOR -->
									<i class="rs-mini-layer-icon rs-icon-bg rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Background Color",'revslider'); ?>" style="margin-right:10px"></i>
									<input type="text" class="rs-staticcustomstylechange my-color-field rs-layer-input-field tipsy_enabled_top" title="<?php _e("Background Color",'revslider'); ?>"  id="hover_css_background-color" name="hover_css_background-color" value="transparent" />
									<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

									<!-- BACKGROUND OPACITY -->
									<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Background Opacity",'revslider'); ?>" style="margin-right:10px"></i>
									<input data-suffix="" data-steps="0.05" data-min="0" data-max="1" class="rs-staticcustomstylechange pad-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Background Opacity",'revslider'); ?>" style="width:50px" type="text" id="hover_css_background-transparency" name="hover_css_background-transparency" value="1">
								</span>

								<span id="hover-sub-border" class="rs-layer-toolbar-box" style="display:none;border:none;">
									<!-- BORDER COLOR -->
									<i class="rs-mini-layer-icon rs-icon-bordercolor rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Border Color",'revslider'); ?>" style="margin-right:10px"></i>
									<input type="text" class="rs-staticcustomstylechange my-color-field rs-layer-input-field tipsy_enabled_top" title="<?php _e("Border Color",'revslider'); ?>"  id="hover_css_border-color-show" name="hover_css_border-color-show" value="transparent" />

									<!-- BORDER OPACITY -->
									<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Border Opacity",'revslider'); ?>" style="margin-right:10px"></i>
									<input data-suffix="" data-steps="0.05" data-min="0" data-max="1" class="rs-staticcustomstylechange pad-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Border Opacity",'revslider'); ?>" style="width:50px" type="text" id="hover_css_border-transparency" name="hover_css_border-transparency" value="1">


									<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

									<!-- BORDER STYLE -->
									<i class="rs-mini-layer-icon rs-icon-borderstyle rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Border Style",'revslider'); ?>" style="margin-right:10px"></i>
									<select class="rs-staticcustomstylechange rs-layer-input-field tipsy_enabled_top" title="<?php _e("Border Style",'revslider'); ?>" style="width:100px;cursor:pointer" id="hover_css_border-style" name="hover_css_border-style">
										<option value="none"><?php _e('none' ,'revslider'); ?></option>
										<option value="dotted"><?php _e('dotted' ,'revslider'); ?></option>
										<option value="dashed"><?php _e('dashed' ,'revslider'); ?></option>
										<option value="solid"><?php _e('solid' ,'revslider'); ?></option>
										<option value="double"><?php _e('double' ,'revslider'); ?></option>
									</select>
									<span class="rs-layer-toolbar-space" style="margin-right:15px"></span>

									<!-- BORDER WIDTH-->
									<i class="rs-mini-layer-icon rs-icon-borderwidth rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Border Width",'revslider'); ?>" style="margin-right:10px"></i>
									<input data-suffix="px" class="rs-staticcustomstylechange corn-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Border Width",'revslider'); ?>" style="width:50px" type="text" name="hover_css_border-width[]" value="0">
									<input data-suffix="px" class="rs-staticcustomstylechange corn-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Border Width",'revslider'); ?>" style="width:50px" type="text" name="hover_css_border-width[]" value="0">
									<input data-suffix="px" class="rs-staticcustomstylechange corn-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Border Width",'revslider'); ?>" style="width:50px" type="text" name="hover_css_border-width[]" value="0">
									<input data-suffix="px" class="rs-staticcustomstylechange corn-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Border Width",'revslider'); ?>" style="width:50px" type="text" name="hover_css_border-width[]" value="0">
									<span class="rs-layer-toolbar-space" style="margin-right:16px"></span>

									<!-- BORDER RADIUS -->
									<i class="rs-mini-layer-icon rs-icon-borderradius rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Border Radius (px)",'revslider'); ?>" style="margin-right:10px"></i>
									<input data-suffix="px" data-steps="1" data-min="0" class="rs-staticcustomstylechange corn-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Border Radius Top Left",'revslider'); ?>" style="width:50px" type="text" name="hover_css_border-radius[]" value="0px">
									<input data-suffix="px" data-steps="1" data-min="0" class="rs-staticcustomstylechange corn-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Border Radius Top Right",'revslider'); ?>" style="width:50px" type="text" name="hover_css_border-radius[]" value="0px">
									<input data-suffix="px" data-steps="1" data-min="0" class="rs-staticcustomstylechange corn-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Border Radius Bottom Right",'revslider'); ?>" style="width:50px" type="text" name="hover_css_border-radius[]" value="0px">
									<input data-suffix="px" data-steps="1" data-min="0" class="rs-staticcustomstylechange corn-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Border Radius Bottom Left",'revslider'); ?>" style="width:50px" type="text" name="hover_css_border-radius[]" value="0px">
								</span>
								
								<span id="hover-sub-transform" class="rs-layer-toolbar-box" style="display:none;border:none;">
									<!-- OPACITY -->
									<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Opacity. (1 = 100% Visible / 0.5 = 50% opacaity / 0 = transparent)",'revslider'); ?>" style="margin-right:8px"></i>
									<input data-suffix="" data-steps="0.05" data-min="0" data-max="1" type="text" style="width:50px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Opacity (1 = 100% Visible / 0.5 = 50% opacaity / 0 = transparent)",'revslider'); ?>" id="hover_layer__opacity" name="hover_layer__opacity" value="1">
									<span class="rs-layer-toolbar-space"></span>
									
									<!-- SCALE X -->
									<i class="rs-mini-layer-icon rs-icon-scalex rs-toolbar-icon tipsy_enabled_top" title="<?php _e("X Scale  1 = 100%, 0.5=50%... (+/-)",'revslider'); ?>" style="margin-right:8px"></i>
									<input data-suffix="" data-steps="0.01" data-min="0" type="text" style="width:50px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("X Scale  1 = 100%, 0.5=50%... (+/-)",'revslider'); ?>" id="hover_layer__scalex" name="hover_layer__scalex" value="1">
									<span class="rs-layer-toolbar-space"></span>
									<!-- SCALE Y -->
									<i class="rs-mini-layer-icon rs-icon-scaley rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Y Scale  1 = 100%, 0.5=50%... (+/-)",'revslider'); ?>" style="margin-right:4px"></i>
									<input data-suffix="" data-steps="0.01"  data-min="0" type="text" style="width:50px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Y Scale  1 = 100%, 0.5=50%... (+/-)",'revslider'); ?>" id="hover_layer__scaley" name="hover_layer__scaley" value="1">
									<span class="rs-layer-toolbar-space"></span>
									
									<!-- SKEW X -->
									<i class="rs-mini-layer-icon rs-icon-skewx rs-toolbar-icon tipsy_enabled_top" title="<?php _e("X Skew (+/-  px)",'revslider'); ?>" style="margin-right:8px"></i>
									<input data-suffix="px" type="text" style="width:50px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field  tipsy_enabled_top" title="<?php _e("X Skew (+/-  px)",'revslider'); ?>" id="hover_layer__skewx" name="hover_layer__skewx" value="0">
									<span class="rs-layer-toolbar-space"></span>
									<!-- SKEW Y -->
									<i class="rs-mini-layer-icon rs-icon-skewy rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Y Skew (+/-  px)",'revslider'); ?>" style="margin-right:4px"></i>
									<input data-suffix="px" type="text" style="width:50px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Y Skew (+/-  px)",'revslider'); ?>" id="hover_layer__skewy" name="hover_layer__skewy" value="0">
								</span>


								<span id="hover-sub-rotation" class="rs-layer-toolbar-box" style="display:none;border:none;">
									<!--  X  ROTATE -->
									<i class="rs-mini-layer-icon rs-icon-rotationx rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Rotation on X axis (+/-)",'revslider'); ?>"></i>
									<input data-suffix="deg" type="text" style="width:50px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Rotation on X axis (+/-)",'revslider'); ?>" id="hover_layer__xrotate" name="hover_layer__xrotate" value="0">
									<span class="rs-layer-toolbar-space"></span>
									<!--  Y ROTATE -->
									<i class="rs-mini-layer-icon rs-icon-rotationy rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Rotation on Y axis (+/-)",'revslider'); ?>"></i>
									<input data-suffix="deg" type="text" style="width:50px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Rotation on Y axis (+/-)",'revslider'); ?>" id="hover_layer__yrotate" name="hover_layer__yrotate" value="0">
									<span class="rs-layer-toolbar-space"></span>

									<!--  Z ROTATE -->
									<i class="rs-mini-layer-icon rs-icon-rotationz rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Rotation on Z axis (+/-)",'revslider'); ?>"></i>
									<input data-suffix="deg" type="text" style="width:50px;" class="rs-staticcustomstylechange textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Rotation on Z axis (+/-)",'revslider'); ?>" id="hover_layer_2d_rotation" name="hover_layer_2d_rotation" value="0">

								</span>
								
								<!-- ADVANCED CSS -->
								<span id="hover-sub-advcss" class="rs-layer-toolbar-box" style="display:none;border:none;">
									<div id="advanced-css-main" class="rev-advanced-css-hover advanced-copy-button"><?php _e("Template",'revslider'); ?></div>
									<div id="advanced-css-layer" class="rev-advanced-css-hover-layer advanced-copy-button"><?php _e("Layer",'revslider'); ?></div>
								</span>
								
						</div>


						<!-- IDLE OR HOVER -->
						<div id="idle-hover-swapper" style="width:83px; z-index:900;position: relative;">
							<span id="toggle-idle-hover" class="idleisselected">
								<span class="advanced-label icon-styleidle"><?php _e("Idle",'revslider'); ?></span>
								<span class="advanced-label icon-stylehover"><?php _e("Hover",'revslider'); ?></span>
							</span>
							<div style="width:100%;height:1px; clear:both"></div>
							<div style="margin:10px 0px 0px; text-align: center">
								<div id="copy-idle-css" class="advanced-copy-button copy-settings-trigger clicktoshowmoresub"><?php _e("COPY",'revslider'); ?><i class="eg-icon-down-open"></i>
									<span class="copy-settings-from clicktoshowmoresub_inner" style="display: none; height:58px;">
										<span class="copy-from-idle css-template-handling-menupoint"><?php _e("Copy From Idle",'revslider'); ?></span>
										<span class="copy-from-hover css-template-handling-menupoint"><?php _e("Copy From Hover",'revslider'); ?></span>
										<span class="copy-from-in-anim css-template-handling-menupoint"><?php _e("Copy From In Animation",'revslider'); ?></span>
										<span class="copy-from-out-anim css-template-handling-menupoint"><?php _e("Copy From Out Animation",'revslider'); ?></span>
									</span>
								</div>
							</div>
						</div>
						<div style="clear:both; display:block;"></div>
					</div>											
				</div>
			</div>

		</div><!-- LAYER POSITION AND ALIGN TOOLBAR ENDS HERE -->


		<!-- LAYER STYLING -->
		<!--<div class="layer-settings-toolbar" id="rs-hover-content-wrapper" style="display:none">
			<div id="extra_style_settings" class="extra_sub_settings_wrapper" style="margin:0; background:#fff;">
				<div style="width:137px;height:75px;float:left;display:inline-block;border-right:1px solid #ddd;padding: 6px 20px 0px;">
					<div id="advanced-css-hover" class="rev-advanced-css-hover"style="margin-right:0px"><?php _e("Hover CSS",'revslider'); ?></div>
				</div>
			</div>
		</div><!-- LAYER HOVER STYLES ENDS HERE -->

		<!-- LAYER ANIMATIONS -->
		<div class="layer-settings-toolbar" id="rs-animation-content-wrapper" style="display:none">
			<p style="margin:0; border-bottom:1px solid #ddd">
				<!-- START TRANSITIONS -->
				<span class="rs-layer-toolbar-box startanim_mainwrapper">
					<i class="rs-icon-inanim rs-toolbar-icon" style="z-index:100; position:relative;"></i>
					<span id="startanim_wrapper" style="z-index:50; ">
						<span id="startanim_timerunnerbox"></span>
						<span id="startanim_timerunner"></span>
					</span>
				</span>
				
				<span id="add_customanimation_in" title="<?php _e("Advanced Settings",'revslider'); ?>"><i style="width:40px;height:40px" class="rs-icon-plus-gray"></i></span>

				<span class="rs-layer-toolbar-box" style="">
					<!-- ANIMATION DROP DOWN -->
					<i class="rs-mini-layer-icon rs-icon-transition rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Animation Template",'revslider'); ?>"></i>
					<select class="rs-inoutanimationfield rs-layer-input-field tipsy_enabled_top" title="<?php _e("Animation Template",'revslider'); ?>" style="width:135px" id="layer_animation" name="layer_animation">
						<?php
						foreach($startanims as $ahandle => $aname){
							$dis = (in_array($ahandle,array('custom',"v5s","v5","v5e","v4s","v4","v4e","vss","vs","vse"))) ? ' disabled="disabled"' : '';
							echo '<option value="'.$ahandle.'"'.$dis.'>'.$aname['handle'].'</option>';
						}
						?>
					</select>
					<span id="animin-template-handling-dd" class="clicktoshowmoresub">
						<span id="animin-template-handling-dd-inner" class="clicktoshowmoresub_inner">
							<span style="background:#ddd !important; padding-left:20px;margin-bottom:5px" class="css-template-handling-menupoint"><span><?php _e("Template Options",'revslider'); ?></span></span>
							<span id="save-current-animin"   	class="save-current-animin css-template-handling-menupoint"><i class="rs-mini-layer-icon rs-toolbar-icon rs-icon-save-dark"></i><span><?php _e("Save",'revslider'); ?></span></span>
							<span id="save-as-current-animin"   class="save-as-current-animin css-template-handling-menupoint"><i class="rs-mini-layer-icon rs-toolbar-icon rs-icon-save-dark"></i><span><?php _e("Save As",'revslider'); ?></span></span>
							<span id="rename-current-animin" class="rename-current-animin css-template-handling-menupoint"><i class="rs-mini-layer-icon rs-toolbar-icon rs-icon-chooser-1"></i><span><?php _e("Rename",'revslider'); ?></span></span>
							<span id="reset-current-animin"  class="reset-current-animin css-template-handling-menupoint"><i class="rs-mini-layer-icon rs-toolbar-icon rs-icon-2drotation"></i><span><?php _e("Reset",'revslider'); ?></span></span>
							<span id="delete-current-animin" class="delete-current-animin css-template-handling-menupoint"><i style="background-size:10px 14px;" class="rs-mini-layer-icon rs-toolbar-icon rs-icon-delete"></i><span><?php _e("Delete",'revslider'); ?></span></span>
						</span>
					</span>
					
					<span class="rs-layer-toolbar-space" style="margin-right: 10px"></span>
					
					<!-- EASING-->
					<i class="rs-mini-layer-icon rs-icon-easing rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Animation Easing",'revslider'); ?>"></i>
					<select class="rs-inoutanimationfield rs-layer-input-field tipsy_enabled_top" title="<?php _e("Animation Easing",'revslider'); ?>" style="width:135px"  id="layer_easing" name="layer_easing">
						<?php
						foreach($easings as $ehandle => $ename){
							echo '<option value="'.$ehandle.'">'.$ename.'</option>';
						}
						?>
					</select>
					<span class="rs-layer-toolbar-space" style="margin-right: 10px"></span>

					<!-- ANIMATION START SPEED -->
					<i class="rs-mini-layer-icon rs-icon-clock rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Animation Speed (in ms)",'revslider'); ?>"></i>
					<input type="text" style="width:60px; padding-right:10px;" class="rs-inoutanimationfield textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Animation Speed (in ms)",'revslider'); ?>" id="layer_speed" name="layer_speed" value="">
					<span class="rs-layer-toolbar-space" style="margin-right: 10px"></span>

					<!-- SPLIT TEXT -->
					<i class="rs-mini-layer-icon rs-icon-splittext rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Split Animaton Text (will not respect Html Markups !)",'revslider'); ?>"></i>
					<select id="layer_split" name="layer_split" class="rs-inoutanimationfield rs-layer-input-field tipsy_enabled_top" title="<?php _e("Split Animaton Text (will not respect Html Markups !)",'revslider'); ?>" style="width:110px">
						<option value="none" selected="selected"><?php _e("No Split",'revslider'); ?></option>
							<option value="chars"><?php _e("Char Based",'revslider'); ?></option>
							<option value="words"><?php _e("Word Based",'revslider'); ?></option>
							<option value="lines"><?php _e("Line Based",'revslider'); ?></option>
					</select>
					<span class="rs-layer-toolbar-space" style="margin-right: 10px"></span>

					<i class="rs-mini-layer-icon rs-icon-splittext-delay rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Animation Delay between Splitted Elements",'revslider'); ?>"></i>
					<input type="text" style="width:65px; padding-right:10px;" class="rs-inoutanimationfield textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Animation Delay between Splitted Elements",'revslider'); ?>" id="layer_splitdelay" name="layer_splitdelay" value="10" disabled="disabled">
				</span>
			</p>

			<div id="extra_start_animation_settings" class="extra_sub_settings_wrapper" style="margin:0; background:#fff; display:none; " >

				<div class="anim-direction-wrapper" style="text-align: center">
						<i class="rs-icon-schin rs-toolbar-icon" style="height:90px"></i>																
				</div>

				<div class="float_left" style="display:inline-block;padding:10px 0px;">
						<div class="inner-settings-wrapper">
							<ul class="rs-layer-animation-settings-tabs">
								<li data-content="#anim-sub-s-offset" class="selected"><?php _e("Offset",'revslider'); ?></li>
								<li data-content="#anim-sub-s-opacity"><?php _e("Opacity",'revslider'); ?></li>
								<li data-content="#anim-sub-s-rotation"><?php _e("Rotation",'revslider'); ?></li>
								<li data-content="#anim-sub-s-scale"><?php _e("Scale",'revslider'); ?></li>
								<li data-content="#anim-sub-s-skew"><?php _e("Skew",'revslider'); ?></li>
								<li data-content="#anim-sub-s-mask"><?php _e("Masking",'revslider'); ?></li>
								<!--li data-content="#anim-sub-s-origin"><?php _e("Origin",'revslider'); ?></li-->
								<!--<li data-content="#anim-sub-s-perspective"><?php _e("Perspective",'revslider'); ?></li>-->
							</ul>

							<!-- MASKING IN -->							
							<span id="anim-sub-s-mask" class="rs-layer-toolbar-box" style="display:none;border:none;">
								<span class="mask-is-available">
									<i class="rs-mini-layer-icon eg-icon-scissors rs-toolbar-icon"></i>
									<input type="checkbox" id="masking-start" name="masking-start" class="rs-inoutanimationfield tp-moderncheckbox"/>
									<span class="rs-layer-toolbar-space"></span>
								</span>
								<span class="mask-not-available">
									<strong><?php _e('Mask is not available due Style Transitions. Please remove any Rotation, Scale or skew effect form Idle and Hover settings', 'revslider'); ?></strong>
								</span>
								<span class="mask-start-settings">
									<!-- MASK X OFFSET -->
									<i class="rs-mini-layer-icon rs-icon-xoffset rs-toolbar-icon "  style="margin-right:8px"></i>								
									<input data-suffix="px" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field "  id="mask_anim_xstart" name="mask_anim_xstart" value="0" data-reverse="on" data-selects="0||Random||Custom||Stage Left||Stage Right||-100%||100%||-175%||175%" data-svalues ="0||{-50,50}||50||stage_left||stage_right||[-100%]||[100%]||[-175%]||[175%]" data-icons="minus||shuffle||wrench||right||left||filter||filter||filter||filter">
									<span class="rs-layer-toolbar-space"></span>
									<!-- MASK Y OFFSET -->
									<i class="rs-mini-layer-icon rs-icon-yoffset rs-toolbar-icon "  style="margin-right:4px"></i>
									<input data-suffix="px" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field "  id="mask_anim_ystart" name="mask_anim_ystart" value="0" data-reverse="on" data-selects="0||Random||Custom||Stage Top||Stage Bottom||-100%||100%||-175%||175%" data-svalues ="0||{-5,50}||50||stage_top||stage_bottom||[-100%]||[100%]||[-175%]||[175%]" data-icons="minus||shuffle||wrench||down||up||filter||filter||filter||filter">
									<span class="rs-layer-toolbar-space"></span>									
								</span>					
							</span>
							

							<span id="anim-sub-s-offset" class="rs-layer-toolbar-box" style="border:none;">
								<!-- X OFFSET -->
								<i class="rs-mini-layer-icon rs-icon-xoffset rs-toolbar-icon "  style="margin-right:8px"></i>								
								<input data-suffix="px" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field "  id="layer_anim_xstart" name="layer_anim_xstart" value="inherit" data-reverse="on" data-selects="Inherit||Random||Custom||Stage Left||Stage Right||Stage Center||-100%||100%||-175%||175%" data-svalues ="inherit||{-50,50}||50||left||right||center||[-100%]||[100%]||[-175%]||[175%]" data-icons="export||shuffle||wrench||right||left||cancel||filter||filter||filter||filter">
								<span class="rs-layer-toolbar-space"></span>
								<!-- Y OFFSET -->
								<i class="rs-mini-layer-icon rs-icon-yoffset rs-toolbar-icon "  style="margin-right:4px"></i>
								<input data-suffix="px" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field "  id="layer_anim_ystart" name="layer_anim_ystart" value="inherit" data-reverse="on" data-selects="Inherit||Random||Custom||Stage Top||Stage Bottom||Stage Middle||-100%||100%||-175%||175%" data-svalues ="inherit||{-5,50}||50||top||bottom||middle||[-100%]||[100%]||[-175%]||[175%]" data-icons="export||shuffle||wrench||down||up||cancel||filter||filter||filter||filter">
								<span class="rs-layer-toolbar-space"></span>
								<!-- Z OFFSET -->
								<i class="rs-mini-layer-icon rs-icon-zoffset rs-toolbar-icon "  style="margin-right:4px"></i>
								<input type="text" data-suffix="px" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field "  id="layer_anim_zstart" name="layer_anim_zstart" value="inherit" id="layer_anim_ystart" name="layer_anim_ystart" value="inherit" data-selects="Inherit||Random||Custom" data-svalues ="inherit||{-20,20}||20" data-icons="export||shuffle||wrench">
							</span>

							<span id="anim-sub-s-skew" class="rs-layer-toolbar-box" style="display:none;border:none;">
								<!-- SKEW X -->
								<i class="rs-mini-layer-icon rs-icon-skewx rs-toolbar-icon "  style="margin-right:8px"></i>
								<input data-suffix="px" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field  "  id="layer_skew_xstart" name="layer_skew_xstart" value="inherit"  value="inherit" data-reverse="on" data-selects="Inherit||Random||Custom" data-svalues ="inherit||{-25,25}||20" data-icons="export||shuffle||wrench">
								<span class="rs-layer-toolbar-space"></span>
								<!-- SKEW Y -->
								<i class="rs-mini-layer-icon rs-icon-skewy rs-toolbar-icon "  style="margin-right:8px"></i>
								<input data-suffix="px" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field "  id="layer_skew_ystart" name="layer_skew_ystart" value="inherit" data-reverse="on" data-selects="Inherit||Random||Custom" data-svalues ="inherit||{-25,25}||20" data-icons="export||shuffle||wrench">
							</span>

							
							<span id="anim-sub-s-rotation" class="rs-layer-toolbar-box" style="display:none;border:none;">
								<!--  X  ROTATE -->
								<i class="rs-mini-layer-icon rs-icon-rotationx rs-toolbar-icon " ></i>
								<input data-suffix="deg" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field "  id="layer_anim_xrotate" name="layer_anim_xrotate" value="inherit" data-reverse="on" data-selects="Inherit||Random||Custom" data-svalues ="inherit||{-90,90}||45" data-icons="export||shuffle||wrench">
								<span class="rs-layer-toolbar-space"></span>
								<!--  Y ROTATE -->
								<i class="rs-mini-layer-icon rs-icon-rotationy rs-toolbar-icon " ></i>
								<input data-suffix="deg" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field "  id="layer_anim_yrotate" name="layer_anim_yrotate" value="inherit" data-reverse="on" data-selects="Inherit||Random||Custom" data-svalues ="inherit||{-90,90}||45" data-icons="export||shuffle||wrench">
								<span class="rs-layer-toolbar-space"></span>
								
								<!--  Z ROTATE -->
								<i class="rs-mini-layer-icon rs-icon-rotationz rs-toolbar-icon " ></i>
								<input data-suffix="deg" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field "  id="layer_anim_zrotate" name="layer_anim_zrotate" value="inherit" data-reverse="on" data-selects="Inherit||Random||Custom" data-svalues ="inherit||{-360,360}||45" data-icons="export||shuffle||wrench">

							</span>

							<span id="anim-sub-s-scale" class="rs-layer-toolbar-box" style="display:none;border:none;">
								<!-- SCALE X -->
								<i class="rs-mini-layer-icon rs-icon-scalex rs-toolbar-icon "  style="margin-right:8px"></i>
								<input data-suffix="" data-steps="0.01" data-min="0" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field "  id="layer_scale_xstart" name="layer_scale_xstart" value="inherit" data-reverse="on" data-selects="Inherit||Random||Custom" data-svalues ="inherit||{0,1}||0.5" data-icons="export||shuffle||wrench">
								<span class="rs-layer-toolbar-space"></span>
								<!-- SCALE Y -->
								<i class="rs-mini-layer-icon rs-icon-scaley rs-toolbar-icon " style="margin-right:8px"></i>
								<input data-suffix="" data-steps="0.01" data-min="0" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field " id="layer_scale_ystart" name="layer_scale_ystart" value="inherit" data-reverse="on" data-selects="Inherit||Random||Custom" data-svalues ="inherit||{0,1}||0.5" data-icons="export||shuffle||wrench">
							</span>

							<span id="anim-sub-s-opacity" class="rs-layer-toolbar-box" style="display:none;border:none;">
								<!-- OPACITY -->
								<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon "  style="margin-right:8px"></i>
								<input data-suffix="" data-steps="0.05" data-min="0" data-max="1" type="text" style="width:100px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field " id="layer_opacity_start" name="layer_opacity_start" value="inherit" data-selects="Inherit||Random||Custom" data-svalues ="inherit||{0,1}||0.5" data-icons="export||shuffle||wrench">
							</span>
						</div>																
				</div>				
				<div style="clear:both; display:block;"></div>


			</div>

			<!-- END TRANSITIONS -->
			<p style="margin:0;">
				<span class="rs-layer-toolbar-box endanim_mainwrapper">
					<i class="rs-icon-outanim rs-toolbar-icon " style="z-index:100; position:relative;"></i>
					<span id="endanim_wrapper" style="z-index:50">
						<span id="endanim_timerunnerbox"></span>
						<span id="endanim_timerunner"></span>
					</span>
				</span>
				
				<span id="add_customanimation_out" title="<?php _e("Advanced Settings",'revslider'); ?>"><i style="width:40px;height:40px" class="rs-icon-plus-gray"></i></span>
				
				<?php
				$endanims = $operations->getArrEndAnimations();
				?>
				<span class="rs-layer-toolbar-box" style="">
					<!-- ANIMATION DROP DOWN -->
					<i class="rs-mini-layer-icon rs-icon-transition rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Animation Template",'revslider'); ?>"></i>
					<select class="rs-inoutanimationfield rs-layer-input-field" style="width:135px" id="layer_endanimation" name="layer_endanimation" class=" tipsy_enabled_top" title="<?php _e("Animation Template",'revslider'); ?>">
						<?php
						foreach($endanims as $ahandle => $aname){
							$dis = (in_array($ahandle,array('custom',"v5s","v5","v5e","v4s","v4","v4e","vss","vs","vse"))) ? ' disabled="disabled"' : '';
							echo '<option value="'.$ahandle.'"'.$dis.'>'.$aname['handle'].'</option>';
						}
						?>
					</select>
					<span id="animout-template-handling-dd" class="clicktoshowmoresub" style="z-index:901">
						<span id="animout-template-handling-dd-inner" class="clicktoshowmoresub_inner">
							<span style="background:#ddd !important; padding-left:20px;margin-bottom:5px" class="css-template-handling-menupoint"><span><?php _e("Template Options",'revslider'); ?></span></span>
							<span id="save-current-animout"   	class="save-current-animout css-template-handling-menupoint"><i class="rs-mini-layer-icon rs-toolbar-icon rs-icon-save-dark"></i><span><?php _e("Save",'revslider'); ?></span></span>
							<span id="save-as-current-animout"   class="save-as-current-animout css-template-handling-menupoint"><i class="rs-mini-layer-icon rs-toolbar-icon rs-icon-save-dark"></i><span><?php _e("Save As",'revslider'); ?></span></span>
							<span id="rename-current-animout" class="rename-current-animout css-template-handling-menupoint"><i class="rs-mini-layer-icon rs-toolbar-icon rs-icon-chooser-1"></i><span><?php _e("Rename",'revslider'); ?></span></span>
							<span id="reset-current-animout"  class="reset-current-animout css-template-handling-menupoint"><i class="rs-mini-layer-icon rs-toolbar-icon rs-icon-2drotation"></i><span><?php _e("Reset",'revslider'); ?></span></span>
							<span id="delete-current-animout" class="delete-current-animout css-template-handling-menupoint"><i style="background-size:10px 14px;" class="rs-mini-layer-icon rs-toolbar-icon rs-icon-delete"></i><span><?php _e("Delete",'revslider'); ?></span></span>
						</span>
					</span>

					<span class="rs-layer-toolbar-space" style="margin-right: 10px"></span>
					<?php
					$easings = $operations->getArrEndEasing();
					?>
					<!-- EASING-->
					<i class="rs-mini-layer-icon rs-icon-easing rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Animation Easing",'revslider'); ?>"></i>
					<select class="rs-inoutanimationfield rs-layer-input-field tipsy_enabled_top" title="<?php _e("Animation Easing",'revslider'); ?>" style="width:135px"  id="layer_endeasing" name="layer_endeasing">
						<?php
						foreach($easings as $ehandle => $ename){
							echo '<option value="'.$ehandle.'">'.$ename.'</option>';
						}
						?>
						</select>
						<span class="rs-layer-toolbar-space" style="margin-right: 10px"></span>

						<!-- ANIMATION END SPEED -->
						<i class="rs-mini-layer-icon rs-icon-clock rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Animation Speed (in ms)",'revslider'); ?>"></i>
						<input type="text" style="width:60px; " class="rs-inoutanimationfield textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Animation Speed (in ms)",'revslider'); ?>" id="layer_endspeed" name="layer_endspeed" value="">
						<span class="rs-layer-toolbar-space" style="margin-right: 10px"></span>

						<!-- SPLIT TEXT -->
						<i class="rs-mini-layer-icon rs-icon-splittext rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Split Animaton Text (will not respect Html Markups !)",'revslider'); ?>"></i>
						<select id="layer_endsplit" name="layer_endsplit" class="rs-inoutanimationfield rs-layer-input-field tipsy_enabled_top" title="<?php _e("Split Animaton Text (will not respect Html Markups !)",'revslider'); ?>" style="width:110px">
							<option value="none" selected="selected"><?php _e("No Split",'revslider'); ?></option>
								<option value="chars"><?php _e("Char Based",'revslider'); ?></option>
								<option value="words"><?php _e("Word Based",'revslider'); ?></option>
								<option value="lines"><?php _e("Line Based",'revslider'); ?></option>
						</select>
						<span class="rs-layer-toolbar-space" style="margin-right: 10px"></span>

						<i class="rs-mini-layer-icon rs-icon-splittext-delay rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Animation Delay between Splitted Elements",'revslider'); ?>"></i>
						<input type="text" style="width:65px; " class="rs-inoutanimationfield textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Animation Delay between Splitted Elements",'revslider'); ?>" id="layer_endsplitdelay" name="layer_endsplitdelay" value="10" disabled="disabled">
				</span>
			</p>
			<div id="extra_end_animation_settings" class="extra_sub_settings_wrapper" style="margin:0; background:#fff; display:none;">
				<div class="anim-direction-wrapper" style="text-align: center">
						<i class="rs-icon-schout rs-toolbar-icon" style="height:90px"></i>																
				</div>


				<div class="float_left" style="display:inline-block;padding:10px 0px;">
					<div class="inner-settings-wrapper" >
						<ul class="rs-layer-animation-settings-tabs">
							<li data-content="#anim-sub-e-offset" class="selected"><?php _e("Offset",'revslider'); ?></li>
							<li data-content="#anim-sub-e-opacity"><?php _e("Opacity",'revslider'); ?></li>
							<li data-content="#anim-sub-e-rotation"><?php _e("Rotation",'revslider'); ?></li>
							<li data-content="#anim-sub-e-scale"><?php _e("Scale",'revslider'); ?></li>
							<li data-content="#anim-sub-e-skew"><?php _e("Skew",'revslider'); ?></li>
							<li data-content="#anim-sub-e-mask"><?php _e("Masking",'revslider'); ?></li>
							<!--li data-content="#anim-sub-e-origin"><?php _e("Origin",'revslider'); ?></li-->
							<!--<li data-content="#anim-sub-e-perspective"><?php _e("Perspective",'revslider'); ?></li>-->
						</ul>


						<!-- MASKING IN -->							
						<span id="anim-sub-e-mask" class="rs-layer-toolbar-box" style="display:none;border:none;">
							<span class="mask-is-available">
								<i class="rs-mini-layer-icon eg-icon-scissors rs-toolbar-icon"></i>
								<input type="checkbox" id="masking-end" name="masking-end" class="rs-inoutanimationfield tp-moderncheckbox"/>
								<span class="rs-layer-toolbar-space"></span>
							</span>
							<span class="mask-not-available">
								<strong><?php _e('Mask is not available due Style Transitions. Please remove any Rotation, Scale or skew effect form Idle and Hover settings' ,'revslider'); ?></strong>
							</span>
							<span class="mask-end-settings">
								<!-- MASK X OFFSET -->
								<i class="rs-mini-layer-icon rs-icon-xoffset rs-toolbar-icon "  style="margin-right:8px"></i>								
								<input data-suffix="px" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field "  id="mask_anim_xend" name="mask_anim_xend" value="0" data-reverse="on" data-selects="Inherit||Random||Custom||Stage Left||Stage Right||Stage Center||-100%||100%||-175%||175%" data-svalues ="inherit||{-50,50}||50||left||right||center||[-100%]||[100%]||[-175%]||[175%]" data-icons="export||shuffle||wrench||right||left||cancel||filter||filter||filter||filter">
								<span class="rs-layer-toolbar-space"></span>
								<!-- MASK Y OFFSET -->
								<i class="rs-mini-layer-icon rs-icon-yoffset rs-toolbar-icon "  style="margin-right:4px"></i>
								<input data-suffix="px" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field "  id="mask_anim_yend" name="mask_anim_yend" value="0" data-reverse="on" data-selects="Inherit||Random||Custom||Stage Top||Stage Bottom||Stage Middle||-100%||100%||-175%||175%" data-svalues ="inherit||{-5,50}||50||top||bottom||middle||[-100%]||[100%]||[-175%]||[175%]" data-icons="export||shuffle||wrench||down||up||cancel||filter||filter||filter||filter">
								<span class="rs-layer-toolbar-space"></span>
							</span>					
						</span>


						<span id="anim-sub-e-offset" class="rs-layer-toolbar-box" style="border:none;">
							<!-- X OFFSET END-->
							<i class="rs-mini-layer-icon rs-icon-xoffset rs-toolbar-icon"  style="margin-right:8px"></i>								
							<input data-suffix="px" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field"  id="layer_anim_xend" name="layer_anim_xend" value="inherit" data-reverse="on" data-selects="Inherit||Random||Custom||Stage Left||Stage Right||Stage Center||-100%||100%||-175%||175%" data-svalues ="inherit||{-50,50}||50||left||right||center||[-100%]||[100%]||[-175%]||[175%]" data-icons="export||shuffle||wrench||right||left||cancel||filter||filter||filter||filter">
							<span class="rs-layer-toolbar-space"></span>
							<!-- Y OFFSET END-->
							<i class="rs-mini-layer-icon rs-icon-yoffset rs-toolbar-icon"  style="margin-right:4px"></i>
							<input data-suffix="px" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field"  id="layer_anim_yend" name="layer_anim_yend" value="inherit" data-reverse="on" data-selects="Inherit||Random||Custom||Stage Top||Stage Bottom||Stage Middle||-100%||100%||-175%||175%" data-svalues ="inherit||{-5,50}||50||top||bottom||middle||[-100%]||[100%]||[-175%]||[175%]" data-icons="export||shuffle||wrench||down||up||cancel||filter||filter||filter||filter">
							<span class="rs-layer-toolbar-space"></span>
							<!-- Z OFFSET END-->
							<i class="rs-mini-layer-icon rs-icon-zoffset rs-toolbar-icon"  style="margin-right:4px"></i>
							<input type="text" data-suffix="px" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field"  id="layer_anim_zend" name="layer_anim_zend" value="inherit" value="0" data-reverse="on" data-selects="Inherit||Random||Custom" data-svalues ="inherit||{-20,20}||20" data-icons="export||shuffle||wrench">
						</span>


						<span id="anim-sub-e-skew" class="rs-layer-toolbar-box" style="display:none;border:none;">
							<!-- SKEW X -->
							<i class="rs-mini-layer-icon rs-icon-skewx rs-toolbar-icon"  style="margin-right:8px"></i>
							<input data-suffix="px" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field "  id="layer_skew_xend" name="layer_skew_xend" value="inherit" data-reverse="on" data-selects="Inherit||Random||Custom" data-svalues ="inherit||{-25,25}||20" data-icons="export||shuffle||wrench">
							<span class="rs-layer-toolbar-space"></span>
							<!-- SKEW Y -->
							<i class="rs-mini-layer-icon rs-icon-skewy rs-toolbar-icon"  style="margin-right:8px"></i>
							<input data-suffix="px" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field"  id="layer_skew_yend" name="layer_skew_yend" value="inherit" data-reverse="on" data-selects="Inherit||Random||Custom" data-svalues ="inherit||{-25,25}||20" data-icons="export||shuffle||wrench">
						</span>

			
						<span id="anim-sub-e-rotation" class="rs-layer-toolbar-box" style="display:none;border:none;">
							<!--  X  ROTATE -->
							<i class="rs-mini-layer-icon rs-icon-rotationx rs-toolbar-icon" ></i>
							<input data-suffix="deg" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field"  id="layer_anim_xrotate_end" name="layer_anim_xrotate_end" value="inherit" data-reverse="on" data-selects="Inherit||Random||Custom" data-svalues ="inherit||{-90,90}||45" data-icons="export||shuffle||wrench">
							<span class="rs-layer-toolbar-space"></span>
							<!--  Y ROTATE END -->
							<i class="rs-mini-layer-icon rs-icon-rotationy rs-toolbar-icon" ></i>
							<input data-suffix="deg" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field"  id="layer_anim_yrotate_end" name="layer_anim_yrotate_end" value="inherit" data-reverse="on" data-selects="Inherit||Random||Custom" data-svalues ="inherit||{-90,90}||45" data-icons="export||shuffle||wrench">
							<span class="rs-layer-toolbar-space"></span>
							
							<!--  Z ROTATE END -->
							<i class="rs-mini-layer-icon rs-icon-rotationz rs-toolbar-icon" ></i>
							<input data-suffix="deg" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field"  id="layer_anim_zrotate_end" name="layer_anim_zrotate_end" value="inherit" data-reverse="on" data-selects="Inherit||Random||Custom" data-svalues ="inherit||{-360,360}||45" data-icons="export||shuffle||wrench">
						</span>

						<span id="anim-sub-e-scale" class="rs-layer-toolbar-box" style="display:none;border:none;">
							<!-- SCALE X -->
							<i class="rs-mini-layer-icon rs-icon-scalex rs-toolbar-icon "  style="margin-right:8px"></i>
							<input data-suffix="" data-steps="0.01" data-min="0" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field "  id="layer_scale_xend" name="layer_scale_xend" value="inherit" data-reverse="on" data-selects="Inherit||Random||Custom" data-svalues ="inherit||{0,1}||0.5" data-icons="export||shuffle||wrench">
							<span class="rs-layer-toolbar-space"></span>
							<!-- SCALE Y -->
							<i class="rs-mini-layer-icon rs-icon-scaley rs-toolbar-icon " style="margin-right:8px"></i>
							<input data-suffix="" data-steps="0.01" data-min="0" type="text" style="width:175px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field " id="layer_scale_yend" name="layer_scale_yend" value="inherit" data-reverse="on" data-selects="Inherit||Random||Custom" data-svalues ="inherit||{0,1}||0.5" data-icons="export||shuffle||wrench">
						</span>

						<span id="anim-sub-e-opacity" class="rs-layer-toolbar-box" style="display:none;border:none;">
							<!-- OPACITY -->
							<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon "  style="margin-right:8px"></i>
							<input data-suffix="" data-steps="0.05" data-min="0" data-max="1" type="text" style="width:100px;" class="input-deepselects rs-inoutanimationfield textbox-caption rs-layer-input-field " id="layer_opacity_end" name="layer_opacity_end" value="inherit" data-selects="Inherit||Random||Custom" data-svalues ="inherit||{0,1}||0.5" data-icons="export||shuffle||wrench">
						</span>

					

					</div>					
				</div>
				<div style="clear:both; display:block;"></div>

			</div>

		</div>

		<!-- LOOP ANIMATIONS -->
		<div class="layer-settings-toolbar" id="rs-loop-content-wrapper" style="display: none">
			<div class="topdddborder">
				<span class="rs-layer-toolbar-box" style="padding-right:26px">
					<span><?php _e("Loop",'revslider'); ?></span>
				</span>

				<span class="rs-layer-toolbar-box" style="">
					<i class="rs-mini-layer-icon rs-icon-transition rs-toolbar-icon"></i>
					<select class="rs-loopanimationfield rs-layer-input-field" style="width:110px" id="layer_loop_animation" name="layer_loop_animation" class="">
						<option value="none" selected="selected"><?php _e('Disabled', 'revslider'); ?></option>
						<option value="rs-pendulum"><?php _e('Pendulum', 'revslider'); ?></option>
						<option value="rs-rotate"><?php _e('Rotate', 'revslider'); ?></option>
						<option value="rs-slideloop"><?php _e('Slideloop', 'revslider'); ?></option>
						<option value="rs-pulse"><?php _e('Pulse', 'revslider'); ?></option>
						<option value="rs-wave"><?php _e('Wave', 'revslider'); ?></option>
					</select>
				</span>

				<!-- ANIMATION END SPEED -->
				<span id="layer_speed_wrapper" class="rs-layer-toolbar-box tipsy_enabled_top" title="<?php _e("Loop Speed (sec) - 0.3 = 300ms",'revslider'); ?>" style="display:none">
					<i class="rs-mini-layer-icon rs-icon-clock rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Loop Speed (ms)",'revslider'); ?>"></i>
					<input type="text" style="width:90px;" class="rs-loopanimationfield  textbox-caption rs-layer-input-field" id="layer_loop_speed" name="layer_loop_speed" value="2">
					<span class="rs-layer-toolbar-space"></span>
				</span>
				<?php
				$easings = $operations->getArrEasing();
				?>
				
				<!-- EASING-->
				<span id="layer_easing_wrapper" class="rs-layer-toolbar-box tipsy_enabled_top" title="<?php _e("Loop Easing",'revslider'); ?>" style="display:none">
					<i class="rs-mini-layer-icon rs-icon-easing rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Loop Easing",'revslider'); ?>"></i>
					<select class="rs-loopanimationfield  rs-layer-input-field" style="width:175px"  id="layer_loop_easing" name="layer_loop_easing">
						<?php
						foreach($easings as $ehandle => $ename){
							echo '<option value="'.$ehandle.'">'.$ename.'</option>';
						}
						?>
					</select>
				</span>
			</div>
			<div>
				<!-- LOOP PARAMETERS -->
				<span class="rs-layer-toolbar-box" style="padding-right:18px; display:none;" id="layer_parameters_wrapper">
					<span><?php _e("Loop Parameters",'revslider'); ?></span>
				</span>

				<!-- ROTATION PART -->
				<span id="layer_degree_wrapper" class="rs-layer-toolbar-box" style="display:none">
					<!-- ROTATION START -->
					<i class="rs-mini-layer-icon rs-icon-rotation-start rs-toolbar-icon tipsy_enabled_top" title="<?php _e("2D Rotation start deg.",'revslider'); ?>"></i>
					<input data-suffix="deg" type="text" style="width:90px;" class="rs-loopanimationfield  textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("2D Rotation start deg.",'revslider'); ?>" id="layer_loop_startdeg" name="layer_loop_startdeg" value="-20">
					<span class="rs-layer-toolbar-space"></span>
					<!-- ROTATION END -->
					<i class="rs-mini-layer-icon rs-icon-rotation-end rs-toolbar-icon tipsy_enabled_top" title="<?php _e("2D Rotation end deg.",'revslider'); ?>"></i>
					<input data-suffix="deg" type="text" style="width:90px;" class="rs-loopanimationfield  textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("2D Rotation end deg.",'revslider'); ?>" id="layer_loop_enddeg" name="layer_loop_enddeg" value="20">
				</span>
				<!-- ORIGIN -->
				<span id="layer_origin_wrapper" class="rs-layer-toolbar-box" style="display:none">
					<!-- ORIGIN X -->
					<i class="rs-mini-layer-icon rs-icon-originx rs-toolbar-icon tipsy_enabled_top" title="<?php _e("2D Rotation X Origin",'revslider'); ?>"></i>
					<input data-suffix="%" type="text" style="width:90px;" class="rs-loopanimationfield  textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("2D Rotation X Origin",'revslider'); ?>" id="layer_loop_xorigin" name="layer_loop_xorigin" value="50">
					<span class="rs-layer-toolbar-space"></span>
					<!-- ORIGIN Y -->
					<i class="rs-mini-layer-icon rs-icon-originy rs-toolbar-icon tipsy_enabled_top" title="<?php _e("2D Rotation Y Origin",'revslider'); ?>"></i>
					<input data-suffix="%" type="text" style="width:90px;" class="rs-loopanimationfield  textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("2D Rotation Y Origin",'revslider'); ?>" id="layer_loop_yorigin" name="layer_loop_yorigin" value="50">
				</span>
				<!-- X/Y START -->
				<span id="layer_x_wrapper" class="rs-layer-toolbar-box" style="display:none">
					<span><?php _e("Start",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space"></span>
					<i class="rs-mini-layer-icon rs-icon-xoffset rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Start X Offset",'revslider'); ?>" style="margin-right:8px"></i>
					<input data-suffix="px" type="text" style="width:90px;" class="rs-loopanimationfield  textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Start X Offset",'revslider'); ?>" id="layer_loop_xstart" name="layer_loop_xstart" value="0">
					<span class="rs-layer-toolbar-space"></span>
					<i class="rs-mini-layer-icon rs-icon-yoffset rs-toolbar-icon tipsy_enabled_top" title="<?php _e("Start Y Offset",'revslider'); ?>" style="margin-right:4px"></i>
					<input data-suffix="px" type="text" style="width:90px;" class="rs-loopanimationfield  textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Start Y Offset",'revslider'); ?>" id="layer_loop_ystart" name="layer_loop_ystart" value="0">
				</span>
				<!-- X/Y END -->
				<span id="layer_y_wrapper" class="rs-layer-toolbar-box" style="display:none">
					<span><?php _e("End",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space"></span>
					<i class="rs-mini-layer-icon rs-icon-xoffset rs-toolbar-icon tipsy_enabled_top" title="<?php _e("End X Offset",'revslider'); ?>" style="margin-right:8px"></i>
					<input data-suffix="px" type="text" style="width:90px;" class="rs-loopanimationfield  textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("End X Offset",'revslider'); ?>" id="layer_loop_xend" name="layer_loop_xend" value="0">
					<span class="rs-layer-toolbar-space"></span>
					<i class="rs-mini-layer-icon rs-icon-yoffset rs-toolbar-icon tipsy_enabled_top" title="<?php _e("End Y Offset",'revslider'); ?>" style="margin-right:4px"></i>
					<input data-suffix="px" type="text" style="width:90px;" class="rs-loopanimationfield  textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("End Y Offset",'revslider'); ?>" id="layer_loop_yend" name="layer_loop_yend" value="0">
				</span>

				<!-- ZOOM -->
				<span id="layer_zoom_wrapper" class="rs-layer-toolbar-box" style="display:none">
					<span><?php _e("Zoom Start",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space"></span>
					<input type="text" style="width:90px;" class="rs-loopanimationfield  textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Zoom Start",'revslider'); ?>" id="layer_loop_zoomstart" name="layer_loop_zoomstart" value="1">
					<span class="rs-layer-toolbar-space"></span>
					<span><?php _e("Zoom End",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space"></span>
					<input type="text" style="width:90px;" class="rs-loopanimationfield  textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Zoom End",'revslider'); ?>" id="layer_loop_zoomend" name="layer_loop_zoomend" value="1">
				</span>
				<!-- ANGLE -->
				<span id="layer_angle_wrapper" class="rs-layer-toolbar-box" style="display:none">
					<span><?php _e("Angle",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space"></span>
					<input type="text" style="width:90px;" class="rs-loopanimationfield  textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Start Angle",'revslider'); ?>" id="layer_loop_angle" name="layer_loop_angle" value="0">
				</span>
				<!-- RADIUS -->
				<span id="layer_radius_wrapper" class="rs-layer-toolbar-box" style="display:none">
					<span><?php _e("Radius",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space"></span>
					<input data-suffix="px" type="text" style="width:90px;" class="rs-loopanimationfield  textbox-caption rs-layer-input-field tipsy_enabled_top" title="<?php _e("Radius of Rotation / Pendulum",'revslider'); ?>" id="layer_loop_radius" name="layer_loop_radius" value="10">
				</span>
			</div>
		</div>

		<!-- LINK SETTINGS -->
		<div class="layer-settings-toolbar" id="rs-parallax-content-wrapper" style="display:none;">
			<?php 
				if ($use_parallax=="off") {	
					echo '<span class="rs-layer-toolbar-box">';
					echo '<span class="rs-layer-toolbar-space"></span>';
					echo '<i style="color:#c0392b">';
					_e("Parallax Feature in Slider Settings is deactivated, parallax will be ignored.",'revslider'); 
					echo '</i>';
					echo '</span>';
				} else { ?>
				
					<!-- PARALLAX LEVEL -->
					<span class="rs-layer-toolbar-box">
							<?php 
								$ddd_label_text="Parallax Depth";
								$ddd_no_parallax="No Parallax";
								if ($parallaxisddd!="off") { 
									$ddd_label_text="3D Depth";
									$ddd_no_parallax="Default 3D Depth";
									
								}
							?>
							<span><?php _e($ddd_label_text,'revslider'); ?></span>

							<span class="rs-layer-toolbar-space"></span>
							<select class="rs-layer-input-field" style="width:149px" id="parallax_level" name="parallax_level">																								
								<option value="-"><?php _e($ddd_no_parallax, 'revslider'); ?></option>
								<option value="1">1 - (<?php echo $parallax_level[0]; ?>%)</option>
								<option value="2">2  - (<?php echo $parallax_level[1]; ?>%)</option>
								<option value="3">3  - (<?php echo $parallax_level[2]; ?>%)</option>
								<option value="4">4  - (<?php echo $parallax_level[3]; ?>%)</option>
								<option value="5">5  - (<?php echo $parallax_level[4]; ?>%)</option>
								<option value="6">6  - (<?php echo $parallax_level[5]; ?>%)</option>
								<option value="7">7  - (<?php echo $parallax_level[6]; ?>%)</option>
								<option value="8">8  - (<?php echo $parallax_level[7]; ?>%)</option>
								<option value="9">9  - (<?php echo $parallax_level[8]; ?>%)</option>
								<option value="10">10  - (<?php echo $parallax_level[9]; ?>%)</option>
								<option value="11">11  - (<?php echo $parallax_level[10]; ?>%)</option>
								<option value="12">12  - (<?php echo $parallax_level[11]; ?>%)</option>
								<option value="13">13  - (<?php echo $parallax_level[12]; ?>%)</option>
								<option value="14">14  - (<?php echo $parallax_level[13]; ?>%)</option>
								<option value="15">15  - (<?php echo $parallax_level[14]; ?>%)</option>
							</select>
					</span>
					<?php 
					if ($parallaxisddd!="off") { 
					?>
						<!-- CLASSES -->
						<span class="rs-layer-toolbar-box" id="put_layer_ddd_to_z">
							<span><?php _e("Attach to",'revslider'); ?></span>
							<span class="rs-layer-toolbar-space"></span>
							<select class="rs-layer-input-field" style="width:149px" id="parallax_layer_ddd_zlevel" name="parallax_layer_ddd_zlevel">									
									<option value="layers"><?php _e('Layers 3D Group', 'revslider'); ?></option>							
									<option value="bg"><?php _e('Background 3D Group', 'revslider'); ?></option>	
								</select>
						</span>
					<?php
					}				
				}
			?>						
		</div>
		<script>			
			jQuery('#parallax_level').on("change",function() {				
				var sbi = jQuery(this),
					v = sbi.find('option:selected').val();
				if (v=="-")				
					jQuery('#put_layer_ddd_to_z').show();				
				else
					jQuery('#put_layer_ddd_to_z').hide();				
			});
			jQuery('#parallax_level').change();			
		</script>
		
		
		
		<!-- ADDON SETTINGS -->
		<div class="layer-settings-toolbar" id="rs-addon-wrapper" style="display:none;">
			<div id="rs-addon-wrapper-button-row">
				<span class="rs-layer-toolbar-box"><?php _e('Select Add-on', 'revslider'); ?></span>
				<?php
				if(!empty($slider_addons)){
					foreach($slider_addons as $rs_addon_handle => $rs_addon){
						?>
						<span class="rs-layer-toolbar-box">
							<span id="rs-addon-trigger-<?php echo esc_attr($rs_addon_handle); ?>" class="rs-addon-trigger"><?php echo esc_attr($rs_addon['title']); ?></span>
						</span>
						<?php
					}
				?>
			</div>
			
			<div style="border-top:1px solid #ddd;">
				<?php
					foreach($slider_addons as $rs_addon_handle => $rs_addon){
						?>
						<div id="rs-addon-trigger-<?php echo esc_attr($rs_addon_handle); ?>-settings" class="rs-addon-settings-wrapper" style="display: none;">
							<?php echo $rs_addon['markup']; ?>
							<script type="text/javascript">
								<?php echo $rs_addon['javascript']; ?>
							</script>
						</div>
						<?php
					}
					?>
					<script type="text/javascript">
						jQuery('.rs-addon-trigger').click(function(){
							var show_addon = jQuery(this).attr('id');
							jQuery('.rs-addon-trigger').removeClass("selected");
							jQuery(this).addClass("selected");
							jQuery('.rs-addon-settings-wrapper').hide();
							jQuery('#'+show_addon+'-settings').show();
						});
					</script>
					<?php
				}
				?>
			</div>
		</div>
		
		<!-- LINK SETTINGS -->
		<div class="layer-settings-toolbar" id="rs-action-content-wrapper" style="display:none">		

			<div style="padding:5px 20px 5px">
				
				<span id="triggered-element-behavior">
					<span class="rs-layer-toolbar-box">
						<span><?php _e("Animation Timing",'revslider'); ?></span>
						<span class="rs-layer-toolbar-space"></span>
						<select id="layer-animation-overwrite" name="layer-animation-overwrite" class="rs-layer-input-field" style="width:150px">
							<option value="default" selected="selected"><?php _e("In and Out Animation Default",'revslider'); ?></option>							
							<option value="waitout"><?php _e("In Animation Default and Out Animation Wait for Trigger",'revslider'); ?></option>
							<option value="wait"><?php _e("Wait for Trigger",'revslider'); ?></option>
						</select>
					</span>
					<span class="rs-layer-toolbar-box">
						<span><?php _e("Trigger Memory",'revslider'); ?></span>
						<span class="rs-layer-toolbar-space"></span>
						<select id="layer-tigger-memory" name="layer-tigger-memory" class="rs-layer-input-field" style="width:150px">
							<option value="reset" selected="selected"><?php _e("Reset Animation and Trigger States every loop",'revslider'); ?></option>
							<option value="keep"><?php _e("Keep last selected State",'revslider'); ?></option>
							
						</select>
					</span>
				</span>	

				<ul class="layer_action_table">
					
					<!-- actions will be added here -->
					
					
					<li class="layer_action_row layer_action_add_template">
						<div class="add-action-row">
							<i class="eg-icon-plus"></i>
						</div>
					</li>
				</ul>

				<script>
					jQuery(document).ready(function() {
						jQuery('body').on('click','.remove-action-row',function() {
							UniteLayersRev.remove_action(jQuery(this));
						});
						
						jQuery('.add-action-row').click(function(){
							UniteLayersRev.add_layer_actions();
						});
					});

				</script>
			</div>
		
		</div>

		<!-- ATTRIBUTE SETTINGS -->
		<div class="layer-settings-toolbar" id="rs-attribute-content-wrapper" style="display:none;">
			<div class="topdddborder">
				
				<!-- ID -->
				<span class="rs-layer-toolbar-box">
					<span><?php _e("ID",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space" style="margin-right:11px"></span>
					<input type="text" style="width:105px;" class="textbox-caption rs-layer-input-field" id="layer_id" name="layer_id" value="">
				</span>
				
								
				<!-- CLASSES -->
				<span class="rs-layer-toolbar-box">
					<span><?php _e("Classes",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space"></span>
					<input type="text" style="width:105px;" class="textbox-caption rs-layer-input-field" id="layer_classes" name="layer_classes" value="">
				</span>

				<!-- WRAPPER ID -->
				<span class="rs-layer-toolbar-box">
					<span><?php _e("Wrapper ID",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space"></span>
					<input type="text" style="width:105px;" class="textbox-caption rs-layer-input-field" id="layer_wrapper_id" name="layer_wrapper_id" value="">
				</span>
				
				<!-- WRAPPER CLASSES -->
				<span class="rs-layer-toolbar-box">
					<span><?php _e("Wrapper Classes",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space"></span>
					<input type="text" style="width:105px;" class="textbox-caption rs-layer-input-field" id="layer_wrapper_classes" name="layer_wrapper_classes" value="">
				</span>

				<!-- INTERNAL CLASSES -->
				<span class="rs-layer-toolbar-box">
					<span><?php _e("Internal Classes:",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space"></span>
					<?php 
					//ONLY FOR DEBUG!!
					?>
					<!-- input type="text" style="width:105px;" class="textbox-caption rs-layer-input-field" id="internal_classes" name="internal_classes" value="" -->
					<input type="hidden" style="width:105px;" class="textbox-caption rs-layer-input-field" id="internal_classes" name="internal_classes" value="">
					<span class="rs-internal-class-wrapper"></span>
					<span class="rs-layer-toolbar-space"></span>
				</span>

			</div>
			<div>
				<!-- REL -->
				<span class="rs-layer-toolbar-box">
					<span><?php _e("Rel",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space"></span>
					<input type="text" style="width:105px;" class="textbox-caption rs-layer-input-field" id="layer_rel" name="layer_rel" value="">					
				</span>

				<!-- TITLE -->
				<span class="rs-layer-toolbar-box">
					<span><?php _e("Title",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space"></span>
					<input type="text" style="width:105px;" class="textbox-caption rs-layer-input-field" id="layer_title" name="layer_title" value="">
				</span>
				
				

				<!-- ALT -->
				<span id="layer_alt_row" class="rs-layer-toolbar-box">
					<span><?php _e("Alt",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space"></span>
					<select id="layer_alt_option" name="layer_alt_option" class="rs-layer-input-field" style="width:100px">
						<option value="media_library"><?php _e('From Media Library', 'revslider'); ?></option>
						<option value="file_name"><?php _e('From Filename', 'revslider'); ?></option>
						<option value="custom"><?php _e('Custom', 'revslider'); ?></option>
					</select>
					<input type="text" style="display: none; width:105px;" class="textbox-caption rs-layer-input-field" id="layer_alt" name="layer_alt" value="">
				</span>
				
				
				
				
				<?php 
				//ONLY FOR DEBUG!!
				?>
				<!-- LAYER TYPE -->
				<!--span class="rs-layer-toolbar-box">
					<span><?php _e("Layer Type:",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space"></span>
					<select name="layer_type" id="layer_type">
						<option value="text">text</option>
						<option value="video">video</option>
						<option value="button">button</option>
						<option value="shape">shape</option>
						<option value="image">image</option>
					</select>
					<span class="rs-layer-toolbar-space"></span>
				</span-->
				
			</div>
		</div>


		<!-- VISIBILITY SETTINGS -->
		<div class="layer-settings-toolbar" id="rs-visibility-content-wrapper" style="display:none">
			<div class="topdddborder">
				<span class="rs-layer-toolbar-box">
					<span><?php _e("Visibility on Devices",'revslider'); ?></span>
				</span>
				<span class="rs-layer-toolbar-box">
					<span class="rev-visibility-on-sizes">
						<i class="rs-mini-layer-icon rs-icon-desktop rs-toolbar-icon"></i>
						<input type="checkbox" id="visible-desktop" name="visible-desktop" class="tp-moderncheckbox"/>
						<span class="rs-layer-toolbar-space"></span>

						<i class="rs-mini-layer-icon rs-icon-laptop rs-toolbar-icon"></i>
						<input type="checkbox" id="visible-notebook" name="visible-notebook" class="tp-moderncheckbox"/>
						<span class="rs-layer-toolbar-space"></span>

						<i class="rs-mini-layer-icon rs-icon-tablet rs-toolbar-icon"></i>
						<input type="checkbox" id="visible-tablet" name="visible-tablet" class="tp-moderncheckbox"/>
						<span class="rs-layer-toolbar-space"></span>

						<i class="rs-mini-layer-icon rs-icon-phone rs-toolbar-icon"></i>
						<input type="checkbox" id="visible-mobile" name="visible-mobile" class="tp-moderncheckbox"/>
					</span>
				</span>
				
				<span class="rs-layer-toolbar-box">
					<span><?php _e("Hide 'Under' Width",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space"></span>
					<input type="checkbox" id="layer_hidden" class="tp-moderncheckbox" name="layer_hidden">
				</span>
				
				<span class="rs-layer-toolbar-box">
					<span><?php _e("Only on Slider Hover",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space"></span>
					<input type="checkbox" id="layer_on_slider_hover" class="tp-moderncheckbox" name="layer_on_slider_hover">
				</span>
			</div>
		</div>

		<!-- BEHAVIOR SETTINGS -->
		<div class="layer-settings-toolbar" id="rs-behavior-content-wrapper" style="display:none">
			<div class="topdddborder">
					
				<span class="rs-layer-toolbar-box ho_column_ ho_row_">
					<span><?php _e("Auto Responsive",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space" style="margin-right:18px"></span>
					<input type="checkbox" id="layer_resize-full" class="tp-moderncheckbox" name="layer_resize-full" checked="checked">
				</span>

				<span class="rs-layer-toolbar-box ho_row_ ho_column_ ho_group_">
					<span><?php _e("Child Elements Responsive",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space" style="margin-right:18px"></span>
					<input type="checkbox" id="layer_resizeme" class="tp-moderncheckbox" name="layer_resizeme" checked="checked">
				</span>

				<span class="rs-layer-toolbar-box">
					<span><?php _e("Align",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space" style="margin-right:18px"></span>
						<select id="layer_align_base" name="layer_align_base" class="rs-layer-input-field" style="width:100px">
							<option value="grid" selected="selected"><?php _e("Grid Based",'revslider'); ?></option>
							<option value="slide"><?php _e("Slide Based",'revslider'); ?></option>							
						</select>
				</span>

				<span class="rs-layer-toolbar-box">
					<span><?php _e("Responsive Offset",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space" style="margin-right:18px"></span>
					<input type="checkbox" id="layer_resp_offset" class="tp-moderncheckbox" name="layer_resp_offset" checked="checked">
				</span>
				
				<span class="rs-layer-toolbar-box" style="display:none">
					<span><?php _e("Position",'revslider'); ?></span>
					<span class="rs-layer-toolbar-space"></span>
					<select id="layer-css-position" name="layer-css-position" class="rs-layer-input-field" style="width:150px">
						<option value="absolute" selected="selected"><?php _e("absoolue",'revslider'); ?></option>
						<option value="relative"><?php _e("relative",'revslider'); ?></option>
					</select>
				</span>
			</div>
			
			<span class="rs-layer-toolbar-box rs-lazy-load-images-wrap">
				<span><?php _e("Lazy Loading",'revslider'); ?></span>
				<span class="rs-layer-toolbar-space"></span>
				<select id="layer-lazy-loading" name="layer-lazy-loading" class="rs-layer-input-field" style="width:150px">
					<option value="auto" selected="selected"><?php _e("Default Setting",'revslider'); ?></option>
					<option value="force"><?php _e("Force Lazy Loading",'revslider'); ?></option>
					<option value="ignore"><?php _e("Ignore Lazy Loading",'revslider'); ?></option>
				</select>
			</span>
			<span class="rs-layer-toolbar-box rs-lazy-load-images-wrap">
				<span><?php _e("Source Type",'revslider'); ?></span>
				<span class="rs-layer-toolbar-space"></span>
				<select id="layer-image-size" name="layer-image-size" class="rs-layer-input-field" style="width:150px">
					<option value="auto" selected="selected"><?php _e("Default Setting",'revslider'); ?></option>
					<?php
					foreach($img_sizes as $imghandle => $imgSize){
						echo '<option value="'.$imghandle.'">'.$imgSize.'</option>';
					}
					?>
				</select>
			</span>
			
			
		</div>


		<!-- STATIC LAYERS SETTINGS -->
		<div class="layer-settings-toolbar" id="rs-static-content-wrapper" style="display:none">
			<?php
				$show_static = 'display: none;';
				if($slide->isStaticSlide())
					$show_static = '';
				$isTemplate = $slider->getParam("template", "false");

			if($isTemplate == "true"){
			?>
				<span class="rs-layer-toolbar-box">
					<?php _e('Static Layers will be shown on every slide in template sliders', 'revslider'); ?>
				</span>
			<?php }
			?>

			<span class="rs-layer-toolbar-box" id="layer_static_wrapper" <?php echo ($isTemplate == "true") ? ' style="display: none;"' : ''; ?>>

				<span><?php _e("Start on Slide",'revslider'); ?></span>
				<span class="rs-layer-toolbar-space"></span>
				<select id="layer_static_start" name="static_start">
					<?php
					if(!empty($arrSlideNames)){
						$si = 1;
						end($arrSlideNames);
						//fetch key of the last element of the array.
						$lastElementKey = key($arrSlideNames);
						foreach($arrSlideNames as $sid => $sparams){
							if($lastElementKey == $sid) break; //break on the last element
							?>
							<option value="<?php echo $si; ?>"><?php echo $si; ?></option>
							<?php
							$si++;
						}
						/*?><option value="last"><?php _e('Last Slide', 'revslider'); ?></option><?php*/
					}else{
						?>
						<option value="-1">-1</option>
						<?php
					}
					?>
				</select>
				<span class="rs-layer-toolbar-space"></span>
				<span><?php _e("End on Slide",'revslider'); ?></span>
				<span class="rs-layer-toolbar-space"></span>
				<select id="layer_static_end" name="static_end">
					<?php
					if(!empty($arrSlideNames)){
						$si = 1;
						foreach($arrSlideNames as $sid => $sparams){
							?>
							<option value="<?php echo $si; ?>"><?php echo $si; ?></option>
							<?php
							$si++;
						}
						/*?><option value="last"><?php _e('Last Slide', 'revslider'); ?></option><?php*/
					}else{
						?>
						<option value="-1">-1</option>
						<?php
					}
					?>
				</select>
			</span>
		</div>
	</form>
	<!-- END OF AMAZING TOOLBAR -->
	<?php
	$slidertype = $slider->getParam("slider_type","fullwidth");
	$style .= ' margin: 0 auto;';
	$tempwidth_jq = $maxbgwidth;

	if($slidertype == 'fullwidth' || $slidertype == 'fullscreen'){

		$style_wrapper .= ' width: 100%;';
		$maxbgwidth ="";
	} else {
		$style_wrapper .= $style;
	}

	$hor_lines = RevSliderFunctions::getVal($settings, "hor_lines","");
	$ver_lines = RevSliderFunctions::getVal($settings, "ver_lines","");
	?>
	<script>
		var __slidertype  = "<?php echo $slidertype; ?>";
	</script>
	
	<div id="thelayer-editor-wrapper" class="context_menu_trigger">

		<!-- THE EDITOR PART -->
		<div id="horlinie"><div id="horlinetext">0</div></div>
		<div id="verlinie"><div id="verlinetext">0</div></div>
		<div id="hor-css-linear">
			<ul class="linear-texts"></ul>
			<div class="helplines-offsetcontainer">
				<?php
				if(!empty($hor_lines)){
					foreach($hor_lines as $lines){
						?>
						<div class="helplines" style="position:absolute;width:1px;background:#4AFFFF;left:<?php echo $lines; ?>;top:0px"><i class="helpline-drag eg-icon-move"></i><i class="helpline-remove eg-icon-cancel"></i></div>
						<?php
					}
				}
				?>
			</div>
		</div>
		<div id="ver-css-linear">
			<ul class="linear-texts"></ul>
			<div class="helplines-offsetcontainer">
				<?php
				if(!empty($ver_lines)){
					foreach($ver_lines as $lines){
						?>
						<div class="helplines" style="position:absolute;height:1px;background:#4AFFFF;top:<?php echo $lines; ?>;left:0px"><i class="helpline-drag eg-icon-move"></i><i class="helpline-remove eg-icon-cancel"></i></div>
						<?php
					}
				}
				?>
			</div>
		</div>

		<div id="hor-css-linear-cover-left"></div>
		<div id="hor-css-linear-cover-right"></div>
		<div id="ver-css-linear-cover"></div>
		<?php
			//show/hide layers of specific slides
			$add_static = 'false';
			if($slide->isStaticSlide()){
				$add_static = 'true';
			}
		?>
		<div id="top-toolbar-wrapper">
			<!--div id="rs-undo-redo-wrapper" style="position: relative;">
				<a href="javascript:void(0);" id="rs-undo-handler"><i class="eg-icon-reply-1"></i></a>
				<a href="javascript:void(0);" id="rs-redo-handler"><i class="eg-icon-forward-1"></i></a>
				<ul id="rs-undo-list" style="display: none; position: absolute; background-color: #FFF; padding: 10px;">
				
				</ul>
				<ul id="rs-redo-list" style="display: none; position: absolute; background-color: #FFF; padding: 10px;">
				
				</ul>
			</div-->
			
			<div id="object_library_call_wrapper">
				<a href="javascript:void(0)" id="button_add_object_layer" class=""><i class="fa-icon-book"></i><span class="add-layer-txt"><?php _e("Object Library",'revslider')?></span></a>
			</div>


			<div id="add-layer-selector-container">
				
				<a href="javascript:void(0)" id="button_add_any_layer" class="add-layer-button-any tipsy_enabled_top"><i class="rs-icon-addlayer2"></i><span class="add-layer-txt"><?php _e("Add Layer",'revslider')?></span></a>
				<div id="add-new-layer-container-wrapper">
					<div id="add-new-layer-container">
						<a href="javascript:void(0)" id="button_add_layer" data-isstatic="<?php echo $add_static; ?>" class="add-layer-button" ><i class="rs-icon-layerfont_n"></i><span class="add-layer-txt"><?php _e("Text/Html",'revslider')?></span></a>
						<a href="javascript:void(0)" id="button_add_layer_image" data-isstatic="<?php echo $add_static; ?>" class="add-layer-button" ><i class="rs-icon-layerimage_n"></i><span class="add-layer-txt"><?php _e("Image",'revslider')?></span></a>
						<a href="javascript:void(0)" id="button_add_layer_audio" data-isstatic="<?php echo $add_static; ?>" class="add-layer-button" ><i class="rs-icon-layeraudio_n"></i><span class="add-layer-txt"><?php _e("Audio",'revslider')?></span></a>
						<a href="javascript:void(0)" id="button_add_layer_video" data-isstatic="<?php echo $add_static; ?>" class="add-layer-button" ><i class="rs-icon-layervideo_n"></i><span class="add-layer-txt"><?php _e("Video",'revslider')?></span></a>
						<a href="javascript:void(0)" id="button_add_layer_button" data-isstatic="<?php echo $add_static; ?>" class="add-layer-button" ><i class="rs-icon-layerbutton_n"></i><span class="add-layer-txt"><?php _e("Button",'revslider')?></span></a>
						<a href="javascript:void(0)" id="button_add_layer_shape" data-isstatic="<?php echo $add_static; ?>" class="add-layer-button" ><i class="rs-icon-layershape_n"></i><span class="add-layer-txt"><?php _e("Shape",'revslider')?></span></a>						
						<a href="javascript:void(0)" id="button_add_layer_svg" data-isstatic="<?php echo $add_static; ?>" class="add-layer-button" ><i class="rs-icon-layersvg_n"></i><span class="add-layer-txt"><?php _e("Object",'revslider')?></span></a>
						<a href="javascript:void(0)" id="button_add_layer_import" data-isstatic="<?php echo $add_static; ?>" class="add-layer-button" ><i class="eg-icon-download"></i><span class="add-layer-txt"><?php _e("Import",'revslider')?></span></a>
					</div>
				</div>
			</div>

			<!-- DESKTOP / TABLET / PHONE SIZING -->
			<?php
			$_width = $slider->getParam('width', 1240);
			$_width_notebook = $slider->getParam('width_notebook', 1024);
			$_width_tablet = $slider->getParam('width_tablet', 778);
			$_width_mobile = $slider->getParam('width_mobile', 480);

			$_height = $slider->getParam('height', 868);
			$_height_notebook = $slider->getParam('height_notebook', 768);
			$_height_tablet = $slider->getParam('height_tablet', 960);
			$_height_mobile = $slider->getParam('height_mobile', 720);

			if($adv_resp_sizes === true){
				?>				
				<span id="rs-edit-layers-on-btn">
					<div data-val="desktop" class="rs-slide-device_selector rs-slide-ds-desktop selected"></div>
					<?php if($enable_custom_size_notebook == 'on'){ ?><div data-val="notebook" class="rs-slide-device_selector rs-slide-ds-notebook"></div><?php } ?>
					<?php if($enable_custom_size_tablet == 'on'){ ?><div data-val="tablet" class="rs-slide-device_selector rs-slide-ds-tablet"></div><?php } ?>
					<?php if($enable_custom_size_iphone == 'on'){ ?><div data-val="mobile" class="rs-slide-device_selector rs-slide-ds-mobile"></div><?php } ?>
				</span>
				
				<div id="rs-set-style-on-devices">
					<span id="rs-set-style-on-devices-button"></span>
					<div id="rs-set-style-on-devices-dialog">
						<label style="font-size:14px; color:#fff; margin-bottom:10px; display:block;"><?php _e("Force Inherit Styles",'revslider'); ?></label>
						<div class="rs-set-style-on-device-row">
							<label style="width: 100px"><?php _e("Color",'revslider'); ?></label>
							<input type="checkbox" id="on_all_devices_color" name="on_all_devices_color" class="rs-set-device-chk tp-moderncheckbox"  />
						</div>
						<div class="rs-set-style-on-device-row">
							<label style="width: 100px"><?php _e("Font Size",'revslider'); ?></label>
							<input type="checkbox" id="on_all_devices_fontsize" name="on_all_devices_fontsize" class="rs-set-device-chk tp-moderncheckbox"  />
						</div>
						<div class="rs-set-style-on-device-row">
							<label style="width: 100px"><?php _e("Line Height",'revslider'); ?></label>
							<input type="checkbox" id="on_all_devices_lineheight" name="on_all_devices_lineheight" class="rs-set-device-chk tp-moderncheckbox"  />
						</div>
						<div class="rs-set-style-on-device-row">
							<label style="width: 100px"><?php _e("Font Weight",'revslider'); ?></label>
							<input type="checkbox" id="on_all_devices_fontweight" name="on_all_devices_fontweight" class="rs-set-device-chk tp-moderncheckbox"  />
						</div>
					</div>
				</div>
				<script type="text/javascript">
					jQuery('#rs-set-style-on-devices-button').click(function(){
						jQuery('#rs-set-style-on-devices-dialog').toggle();
						jQuery(this).toggleClass('selected');						
					});
				</script>
				<?php
			}
			
			?>

			<div id="quick-layer-selector-container">
				<div class="current-active-main-toolbar">
					<div id="layer-short-toolbar" class="layer-toolbar-li">							
						<span id="button_show_all_layer" class="layer-short-tool revdarkgray"><i class="eg-icon-menu"></i>
							<input class="nolayerselectednow" type="text" id="the_current-editing-layer-title"  disabled name="the_current-editing-layer-title" value="No Layer Selected">
						</span>
						
						<span style="display:none;" id="button_change_video_settings" class="layer-short-tool revblue"><i class="eg-icon-pencil"></i></span>		
						<span id="layer-short-tool-placeholder-a" class="layer-short-tool revdarkgray"></span>
						<span id="layer-short-tool-placeholder-b" class="layer-short-tool revdarkgray"></span>					
						<span style="display:none" id="button_edit_layer" class="layer-short-tool revblue"><i class="eg-icon-pencil"></i></span>
						
						<span style="display:none;" id="button_change_image_source" class="layer-short-tool revblue"><i class="eg-icon-pencil"></i></span>		
						
						<span style="display:none" id="button_reset_size" class="layer-short-tool revblue"><i class="eg-icon-resize-normal"></i></span>				
						<span id="button_delete_layer" class="ho_column_ layer-short-tool revred"><i class="rs-lighttrash"></i></span>
						<span id="button_duplicate_layer" class="ho_column_ layer-short-tool revyellow" data-isstatic="<?php echo $add_static; ?>"><i class="rs-lightcopy"></i></span>				
						<span style="display:none;"  id="tp-addiconbutton" class="layer-short-tool revblue"><i class="eg-icon-th"></i></span>
						<?php if($slider_type != 'gallery'){ ?>
							<span id="linkInsertTemplate"  style="display:none" class="layer-short-tool revyellow"><i class="eg-icon-filter"></i></span>					
						<?php } ?>
						<span style="display:none" id="hide_layer_content_editor"  class="layer-short-tool revgreen" ><i class="eg-icon-check"></i></span>					
						<span class="quick-layer-view layer-short-tool revdarkgray"><i class="eg-icon-eye"></i></span>
						<span class="quick-layer-lock layer-short-tool revdarkgray"><i class="eg-icon-lock-open"></i></span>										
						<div style="clear:both;display:block"></div>
					</div>
				</div>
				<div id="quick-layers-wrapper" style="display:none">				
					<div id="quick-layers">	

						<div class="tp-clearfix"></div>
						<ul class="quick-layers-list" id="quick-layers-list-id">
							<li id="nolayersavailable" class="nolayersavailable"><div class="add-layer-button"><?php _e("Slide contains no layers",'revslider')?></div></li>
						</ul>
						<!--<div style="text-align:center; display:block; padding:0px 10px;">
							<span class="gototimeline">Animation Timeline</span>
							</div>-->
					</div>
				</div>
				<!-- TEXT / IMAGE INPUT FIELD CONTENT -->
				<form name="form_layers" class="form_layers">
					<div id="layer_text_holder">
						<div id="layer_text_wrapper" style="display:none">
							<span class="toggle_text_title"><?php _e("Untoggled Content",'revslider')?></span>
							<div class="layer_text_wrapper_inner">
								<div class="layer_text_wrapper_header">					
									<span style="display:none; font-weight:600;" class="layer-content-title-b"><?php _e("Image Layer Title ",'revslider'); ?><span style="margin-left:5px;font-size:11px; font-style: italic;"><?php _e("(only for internal usage):",'revslider'); ?></span> </span>					
								</div>
								<textarea id="layer_text" class="area-layer-params" name="layer_text" ></textarea>
							</div>
							<span class="toggle_text_title"><?php _e("Toggled Content",'revslider')?></span>
							<div class="layer_text_wrapper_inner toggled_text_wrapper">

								<textarea id="layer_text_toggle" class="area-layer-params" name="layer_text_toggle" ></textarea>
							</div>
						</div>
					</div>
					
				</form>
				<script>
					jQuery('#button_show_all_layer i, #button_show_all_layer').click(function() {

						var camt = jQuery('.current-active-main-toolbar'),
							t = jQuery('#button_show_all_layer'),
							b = jQuery(this);

						if (b.hasClass("eg-icon-up") || b.hasClass("eg-icon-menu") || jQuery('#the_current-editing-layer-title').hasClass("nolayerselectednow")) {
							if (camt.hasClass("opened")) {
								jQuery('#quick-layers-wrapper').slideUp(300);
								camt.removeClass("opened");
								t.find('i').removeClass("eg-icon-up").addClass("eg-icon-menu");
							} else {
								jQuery('#quick-layers-wrapper').slideDown(300);
								camt.addClass("opened");
								t.find('i').addClass("eg-icon-up").removeClass("eg-icon-menu");
								jQuery('#quick-layers-list-id').perfectScrollbar("update");
								
								// KRIKI
								jQuery('#layer_text_wrapper').hide();
								jQuery('#layer_text_wrapper').removeClass('currently_editing_txt');
								UniteLayersRev.showHideContentEditor(false);
								
							}
						} 
						return false;
					})
				</script>
			</div>
		</div>


		<div id="divLayers-wrapper" style="overflow: hidden;<?php echo $style.$maxbgwidth; ?>" class="slide_wrap_layers" >
			<div id="divbgholder" style="<?php echo $style_wrapper.$divbgminwidth.$maxbgwidth ?>" class="<?php echo $class_wrapper; ?>">
				<div class="oldslotholder" style="overflow:hidden;width:100%;height:100%;position:absolute;top:0px;left:0px;z-index:0;">
					<div class="tp-bgimg defaultimg"></div>
				</div>
				<div class="slotholder" style="overflow:hidden;width:100%;height:100%;position:absolute;top:0px;left:0px;z-index:1">
					<div class="tp-bgimg defaultimg" style="width: 100%;height: 100%;position: absolute;top:0px;left:0px; <?php echo $style_wrapper.$divbgminwidth.$maxbgwidth ?>"></div>
				</div>				
				<div id="divLayers" class="<?php echo $divLayersClass?>" style="<?php echo $style.$divLayersWidth; ?>">
					<div id="focusongroup"></div>
					<div class="slide_layers_border bg_context_listener"></div>
					<div class="row-zone-container bg_context_listener" id="row-zone-top"></div>
					<div class="row-zone-container bg_context_listener" id="row-zone-middle"></div>
					<div class="row-zone-container bg_context_listener" id="row-zone-bottom"></div>
				</div>
			</div>			
		</div>

		<!-- Row Layout Composer -->
		<div id="rs-layout-row-composer">
			<div id="rs-layout-row-picker">
				<div id="rowlayout1" class="rowlayout-single" data-comp="1"></div>
				<div id="rowlayout2" class="rowlayout-single" data-comp="1/2 + 1/2"></div>
				<div id="rowlayout3" class="rowlayout-single" data-comp="1/3 + 1/3 + 1/3"></div>
				<div id="rowlayout4" class="rowlayout-single" data-comp="1/4 + 1/4 + 1/4 + 1/4"></div>
				<div id="rowlayout5" class="rowlayout-single" data-comp="1/6 + 1/6 + 1/6 + 1/6 + 1/6 + 1/6"></div>
				<div id="rowlayout6" class="rowlayout-single" data-comp="1/4 + 1/2 + 1/4"></div>
				<div id="rowlayout7" class="rowlayout-single" data-comp="1/6 + 2/3 + 1/6"></div>
				<div id="rowlayout8" class="rowlayout-single" data-comp="2/3 + 1/3"></div>
				<div id="rowlayout9" class="rowlayout-single" data-comp="3/4 + 1/4"></div>
			</div>
			<div id="rs-layout-row-custom">
				<input type="text" placeholder="<?php _e('Enter Custom Layout. e.g.:1/2 + 1/2', 'revslider'); ?>" id="rs-row-layout" name="rs-row-layout"> <div id="rs-check-row-layout" href="javascript:void(0);"><?php _e('Update', 'revslider'); ?></div> 
			</div>
			<div id="rs-layout-row-break">
				<span class="setting_text_3"><?php _e('Break Columns at:', 'revslider'); ?></span>
				<span id="rs-row-break-on-btn">						
					<div data-val="notebook" class="rs-row-break-selector rs-slide-ds-notebook"></div>					
					<div data-val="tablet" class="rs-row-break-selector rs-slide-ds-tablet"></div>					
					<div data-val="mobile" class="rs-row-break-selector rs-slide-ds-mobile"></div>				
				</span>

			</div>
			<script>
				jQuery('.rowlayout-single').click(function() {
					jQuery('#rs-row-layout').val(jQuery(this).data('comp'));
					jQuery('#rs-check-row-layout').click();
				})
			</script>
		</div>		

		

		
		


		<!-- ADD LAYERS, REMOVE LAYERS, DUPLICATE LAYERS -->
		<div id="layer-settings-toolbar-bottom" class="layer-settings-toolbar-bottom">
		<span style="display:inline-block;line-height:50px;vertical-align: middle; ">
			<span class="setting_text_3"><?php _e("Change History:",'revslider'); ?></span>	
		</span>
		<div id="quick-undo">
			<span id="showhide_undolist" class="layer-short-tool revdarkgray">
				<i class="eg-icon-menu"></i>
			</span>
			<span class="single-undo-action" data-origtext="<?php _e("No More Steps",'revslider')?>">
				<span class="undo-name"><?php _e("No Changes Recorder",'revslider')?></span>
				<span class="undo-action"></span>
			</span>
			<span id="undo-last-action">
				<i class="eg-icon-cw"></i>
			</span>
		</div>
			
		

		<!--<a href="javascript:void(0)" id="button_delete_all"      class="button-primary  revred button-disabled"><i class="revicon-trash"></i><?php _e("Delete All Layers",'revslider')?> </a>-->
		



			<select style="display:none" name="rs-edit-layers-on" id="rs-edit-layers-on">
				<option value="desktop"><?php _e('Desktop','revslider'); ?></option>
				<option value="notebook"><?php _e('Notebook','revslider'); ?></option>
				<option value="tablet"><?php _e('Tablet','revslider'); ?></option>
				<option value="mobile"><?php _e('Mobile','revslider'); ?></option>
			</select>
			<script type="text/javascript">
				

				jQuery('#add-layer-selector-container').hover(function() {
					jQuery('#add-new-layer-container-wrapper').show();
				},function() {
					jQuery('#add-new-layer-container-wrapper').hide();
				});

				
			

				jQuery('#add-layer-minimiser').click(function() {
					var t = jQuery(this);
					if (t.hasClass("closed")) {
						t.removeClass("closed");
						punchgs.TweenLite.to(jQuery('#add-layer-selector-container'),0.4,{autoAlpha:1,rotationY:0,transformOrigin:"0% 50%",ease:punchgs.Power3.easeInOut});
						punchgs.TweenLite.to(jQuery('#quick-layer-selector-container'),0.4,{autoAlpha:1,rotationY:0,transformOrigin:"0% 50%",ease:punchgs.Power3.easeInOut});
					} else {
						t.addClass("closed");
						punchgs.TweenLite.to(jQuery('#add-layer-selector-container'),0.4,{autoAlpha:0,rotationY:-90,transformOrigin:"0% 50%",ease:punchgs.Power3.easeInOut});
						punchgs.TweenLite.to(jQuery('#quick-layer-selector-container'),0.4,{autoAlpha:0,rotationY:-90,transformOrigin:"0% 50%",ease:punchgs.Power3.easeInOut});
					}
					return false;
				});

				

				

				jQuery('#add-new-layer-container a').click(function() {
					jQuery('#add-new-layer-container-wrapper').hide();
					return true;
				});

				<?php
				if($adv_resp_sizes === true){
					?>
					var rev_adv_resp_sizes = true;
					var rev_sizes = {
						'desktop': [<?php echo $_width.', '.$_height; ?>],
						'notebook': [<?php echo $_width_notebook.', '.$_height_notebook; ?>],
						'tablet': [<?php echo $_width_tablet.', '.$_height_tablet; ?>],
						'mobile': [<?php echo $_width_mobile.', '.$_height_mobile; ?>]
					};

					<?php
				}else{
					?>
					var rev_adv_resp_sizes = false;
					<?php
				}
				?>


			</script>

			<!-- HELPER GRID ON/OFF -->
			<span style="float:right;display:inline-block;line-height:50px;vertical-align: middle; margin-right:30px;">
				<span class="setting_text_3"><?php _e("Helper Grid:",'revslider'); ?></span>
				<select name="rs-grid-sizes" id="rs-grid-sizes">
					<option value="1"><?php _e("Disabled",'revslider'); ?></option>
					<option value="10">10 x 10</option>
					<option value="25">25 x 25</option>
					<option value="50">50 x 50</option>
					<option value="custom"><?php _e('Custom', 'revslider'); ?></option>
				</select>
				<span class="rs-layer-toolbar-space" style="margin-right:20px"></span>
				<span class="setting_text_3"><?php _e("Snap to:",'revslider'); ?></span>
				<select name="rs-grid-snapto" id="rs-grid-snapto" >
					<option value=""><?php _e("None",'revslider'); ?></option>
					<option value=".helplines"><?php _e("Help Lines",'revslider'); ?></option>
					<option value=".slide_layer"><?php _e("Layers",'revslider'); ?></option>
				</select>
			</span>
		</div>

		<div id="timline-manual-dialog" style="display:none">			
			<!-- ANIMATION  TIME AND DURATION -->
			<span style="min-width:370px">
				<label><?php _e("Frame Start",'revslider'); ?></label>						
				<input type="text" style="width:90px;" class="textbox-caption rs-layer-input-field" id="clayer_start_time" name="clayer_start_time" value="0">
				<span class="over-ms">ms</span>			
				<span class="rs-layer-toolbar-space" style="margin-right:20px"></span>
				<label style="margin-left:10px"><?php _e("Duration",'revslider'); ?></label>						
				<input type="text" style="width:90px;" class="textbox-caption rs-layer-input-field" id="clayer_start_speed" name="clayer_start_speed" value="0">
				<span class="over-ms">ms</span>
			</span>			
			<span id="timline-manual-closer"><i class="eg-icon-cancel"></i></span>
			<span id="timline-manual-apply"><i class="eg-icon-ok"></i></span>
		</div>
	</div>



	<!-- THE CURRENT TIMER FOR LAYER -->
	<div id="mtw-wrapper">
		<div id="mastertimer-wrapper" class="layer_sortbox">
				


				<div id="master-selectedlayer-t"></div>
				<div id="master-selectedlayer-b"></div>
				<div class="master-leftcell">
					<div id="master-leftheader">
						<div id="mastertimer-playpause-wrapper">
								<i class="eg-icon-play"></i>
								<span><?php _e('PLAY', 'revslider'); ?></span>
						</div>
						<div id="mastertimer-backtoidle">
						</div>

						<div id="master-timer-time">00:00.00</div>
					</div>
					<div id="v_lw_le" class="layers-wrapper">
						<div class="layers-wrapper-scroll">
							<div id="layers-left" class="sortlist">
								<div class="mastertimer-slide-border"></div>
								<ul id="layers-left-ul" class="mjs-nestedSortable-branch">
									<li id="slide_in_sort" class="mastertimer-layer mastertimer-slide ui-state-default" style="overflow: visible !important; z-index: 1000; position: relative">
										<span class="list-of-layer-links multiple-selector tipsy_enabled_top" original-title="Select Multiple Layers">														
											<span class="list-of-layer-links-inner">				
												<input id="timing-all-onoff-checkbox" name="timing-all-onoff-checkbox" type="checkbox"></input>												
												<span data-linktype="1" class="timing-layer-link-type-element layer-link-type-1"></span>				
												<span data-linktype="2" class="timing-layer-link-type-element layer-link-type-2"></span>				
												<span data-linktype="3" class="timing-layer-link-type-element layer-link-type-3"></span>				
												<span data-linktype="4" class="timing-layer-link-type-element layer-link-type-4"></span>				
												<span data-linktype="5" class="timing-layer-link-type-element layer-link-type-5"></span>				
												<span data-linktype="0" class="timing-layer-link-type-element layer-link-type-0"></span>			
											</span>		
										</span>
										<div id="fake-select-title-wrapper">											
											<span id="fake-select-i" class="timeline-title-line mastertimer-timeline-selector-row">
												<i style="vertical-align:top; font-size:14px;margin-left:0px;margin-right:0px;" class="eg-icon-cog"></i>
											</span>
											<span id="fake-select-title"><?php _e('Slide Main Background', 'revslider'); ?></span>
											<!--<span id="fake-select-label"><?php _e('Animation', 'revslider'); ?></span>-->
										</div>
									</li>
									<li id="last_drop_zone_layers"></li>
								</ul>								
								<!--<div class="bottom-layers-divider"></div>-->
							</div>
						</div>						
					</div>
				</div>

				<div class="master-rightcell">
					<div id="linear-bg-fixer"></div>
					<div id="master-rightheader">
						
						<div id="mastertimer-position" class="timerinidle"><span id="mastertimer-poscurtime"><?php _e('DragMe','revslider'); ?></span></div>
						<div id="mastertimer-maxtime"><span id="mastertimer-maxcurtime"></span></div>
						<div id="mastertimer-curtime"><span id="mastertimer-curtimeinner"></span></div>
					
						<div id="mastertimer-idlezone"></div>


						<div class="mastertimer">

							<div id="mastertimer-linear">
								<ul  class="linear-texts">

								</ul>								
							</div>
						</div>
					</div>

					<div class="layers-wrapper" id="layers-wrapper-right-wrapper">
						<div id="mastertimer-curtime-b"></div>
						<div class="layers-wrapper-scroll">
							<div id="layers-right">
								<div class="mastertimer-slide-border"></div>
								<ul style="border-bottom: 5px solid #d5d5d5;" id="layers-right-ul">									
									<li id="slide_in_sort_time" class="mastertimer-layer mastertimer-slide ui-state-default">
										<div class="timeline_full"><span id="fake_layer_as_slide_title"><span id="fake-select-pre"><?php _e("Slide BG Animation",'revslider'); ?></span><span id="fake-select-label"><?php _e('Animation', 'revslider'); ?></span></span></div>
										<div class="timeline">
											<div data-frameindex="0" class="timeline_frame">
												<span class="timebefore_cont"></span>
												<div class="tl_speed_wrapper">
													<div class="tlf_speed"><span class="duration_cont"></span></div>													
												</div>
											</div>											
										</div>
										<div class="slide-idle-section"></div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div id="timing-helper">
					<div id="whiteblock_extrawrapper">
						<div id="add_new_group"><i class="fa-icon-object-group"></i><span><?php _e('ADD GROUP', 'revslider'); ?></span></div>
						<?php if($slide->isStaticSlide()){ } else {?>
							<div id="add_new_row"><i class="eg-icon-folder"></i><span><?php _e('ADD ROW', 'revslider'); ?></span></div>
						<?php } ?>

						<label id="abs_rel_label"><?php _e('Show Frame Times:', 'revslider'); ?></label>
						<select name="abs_rel_timeline" id="abs_rel_timeline" class="rs-layer-input-field">
							<option value="absolute"><?php _e('ABSOLUTE', 'revslider'); ?></option>
							<option value="relative"><?php _e('RELATIVE', 'revslider'); ?></option>
						</select>
					</div>


					

					<div class="timing-all-checker-wrapper">
						<div class="timing-all-checker"></div>
					</div>
					
				</div>
				<div id="mastertimer-wrapper-resizer"></div>
		</div>
	</div>
	<div id="tp-thelistofclasses"></div>
	<div id="tp-thelistoffonts"></div>
	
	<?php
	$obj_library->write_markup();
	?>
	
	<!-- THE BUTTON DIALOG WINDOW -->
	<div id="dialog_addbutton" class="dialog-addbutton" title="<?php _e("Add Button Layer",'revslider'); ?>" style="display:none">
		<div class="addbuton-dialog-inner">
			<div id="addbutton-examples">
				<div class="addbe-title-row">					
					<span class="addbutton-bg-light"></span>
					<span class="addbutton-bg-dark"></span>
					<span class="addbutton-title" style="font-size:14px;"><?php _e("Click on Element to add it",'revslider'); ?></span>
				</div>
				
				<div class="addbutton-examples-wrapper">
					<span class="addbutton-title"><?php _e("Buttons",'revslider'); ?></span>
					<div class="addbutton-buttonrow" style="padding-top: 10px;">
						<a data-needclass="rev-btn" class="rev-btn rev-bordered" href="javascript:void(0);"><?php _e("Click Here",'revslider'); ?></a>
						<a data-needclass="rev-btn" class="rev-btn rev-medium rev-bordered" href="javascript:void(0);"><?php _e("Click Here",'revslider'); ?></a>
						<a data-needclass="rev-btn" class="rev-btn rev-small rev-bordered" href="javascript:void(0);"><?php _e("Click Here",'revslider'); ?></a>
					</div>
					<div class="addbutton-buttonrow">
						<a data-needclass="rev-btn" class="rev-btn rev-minround rev-bordered" href="javascript:void(0);"><?php _e("Click Here",'revslider'); ?></a>
						<a data-needclass="rev-btn" class="rev-btn rev-medium rev-minround rev-bordered" href="javascript:void(0);"><?php _e("Click Here",'revslider'); ?></a>
						<a data-needclass="rev-btn" class="rev-btn rev-small rev-minround rev-bordered" href="javascript:void(0);"><?php _e("Click Here",'revslider'); ?></a>
					</div>
					<div class="addbutton-buttonrow">
						<a data-needclass="rev-btn" class="rev-btn rev-maxround rev-bordered" href="javascript:void(0);"><?php _e("Click Here",'revslider'); ?></a>
						<a data-needclass="rev-btn" class="rev-btn rev-medium rev-maxround rev-bordered" href="javascript:void(0);"><?php _e("Click Here",'revslider'); ?></a>
						<a data-needclass="rev-btn" class="rev-btn rev-small rev-maxround rev-bordered" href="javascript:void(0);"><?php _e("Click Here",'revslider'); ?></a>
					</div>
					<div class="addbutton-buttonrow">
						<a data-needclass="rev-btn rev-withicon" class="rev-btn rev-maxround rev-withicon rev-bordered" href="javascript:void(0);"><?php _e("Click Here",'revslider'); ?><i class="icon-right-open"></i></a>
						<a data-needclass="rev-btn rev-withicon" class="rev-btn rev-medium rev-maxround rev-withicon rev-bordered" href="javascript:void(0);"><?php _e("Click Here",'revslider'); ?><i class="icon-right-open"></i></a>
						<a data-needclass="rev-btn rev-withicon" class="rev-btn rev-small rev-maxround rev-withicon rev-bordered" href="javascript:void(0);"><?php _e("Click Here",'revslider'); ?><i class="icon-right-open"></i></a>
					</div>
					<div class="addbutton-buttonrow">
						<a data-needclass="rev-btn rev-hiddenicon" class="rev-btn rev-maxround rev-hiddenicon rev-bordered" href="javascript:void(0);"><?php _e("Click Here",'revslider'); ?><i class="icon-right-open"></i></a>
						<a data-needclass="rev-btn rev-hiddenicon" class="rev-btn rev-medium rev-maxround rev-hiddenicon rev-bordered" href="javascript:void(0);"><?php _e("Click Here",'revslider'); ?><i class="icon-right-open"></i></a>
						<a data-needclass="rev-btn rev-hiddenicon" class="rev-btn rev-small rev-maxround rev-hiddenicon rev-bordered" href="javascript:void(0);"><?php _e("Click Here",'revslider'); ?><i class="icon-right-open"></i></a>
					</div>
					<div class="addbutton-buttonrow">
						<a data-needclass="rev-btn rev-hiddenicon" class="rev-btn rev-maxround rev-hiddenicon rev-bordered rev-uppercase" href="javascript:void(0);"><?php _e("Click Here",'revslider'); ?><i class="icon-right-open"></i></a>
						<a data-needclass="rev-btn rev-hiddenicon" class="rev-btn rev-medium rev-maxround rev-hiddenicon rev-bordered rev-uppercase" href="javascript:void(0);"><?php _e("Click Here",'revslider'); ?><i class="icon-right-open"></i></a>
						<a data-needclass="rev-btn rev-hiddenicon" class="rev-btn rev-small rev-maxround rev-hiddenicon rev-bordered rev-uppercase" href="javascript:void(0);"><?php _e("Click Here",'revslider'); ?><i class="icon-right-open"></i></a>
					</div>
					<span class="addbutton-title" style="margin-top:10px;margin-bottom:10px;"><?php _e("Predefined Elements",'revslider'); ?></span>
					<div class="addbutton-buttonrow trans_bg">
						<div class="dark_trans_overlay"></div> 
						<div data-needclass="rev-burger revb-white" class="revb-white rev-burger" style="display:inline-block;margin-right:10px">
						  <span></span>
						  <span></span>
						  <span></span>
						</div>
						<div data-needclass="rev-burger revb-whitenoborder" class="revb-whitenoborder rev-burger" style="display:inline-block;margin-right:10px">
						  <span></span>
						  <span></span>
						  <span></span>
						</div>
						<div data-needclass="rev-burger revb-darkfull" class="revb-darkfull rev-burger" style="display:inline-block;margin-right:10px">
						  <span></span>
						  <span></span>
						  <span></span>
						</div>
						<div data-needclass="rev-burger revb-dark" class="revb-dark rev-burger" style="display:inline-block;margin-right:10px">
						  <span></span>
						  <span></span>
						  <span></span>
						</div>
						<div data-needclass="rev-burger revb-darknoborder" class="revb-darknoborder rev-burger" style="display:inline-block;margin-right:10px">
						  <span></span>
						  <span></span>
						  <span></span>
						</div>
						<div data-needclass="rev-burger revb-whitefull" class="revb-whitefull rev-burger" style="display:inline-block;margin-right:10px">
						  <span></span>
						  <span></span>
						  <span></span>
						</div>
						
						<div style="width:100%;height:25px;display:block"></div>
						<span data-needclass="rev-scroll-btn" class="rev-scroll-btn" style="margin-right:10px">							
							<span>
							</span>							
						</span>
						<span data-needclass="rev-scroll-btn revs-dark" class="rev-scroll-btn revs-dark" style="margin-right:10px">
							<span>
							</span>												
						</span>

						<span data-needclass="rev-scroll-btn revs-fullwhite" class="rev-scroll-btn revs-fullwhite" style="margin-right:10px">
							<span>
							</span>							
						</span>

						<span data-needclass="rev-scroll-btn revs-fulldark" class="rev-scroll-btn revs-fulldark" style="margin-right:10px">
							<span>
							</span>
						</span>

						<span data-needclass="" class="rev-control-btn rev-sbutton rev-sbutton-blue" style="margin-right:10px;vertical-align:top">
							<i class="fa-icon-facebook"></i>
						</span>

						<span data-needclass="" class="rev-control-btn rev-sbutton rev-sbutton-lightblue" style="margin-right:10px;vertical-align:top">
							<i class="fa-icon-twitter"></i>
						</span>

						<span data-needclass="" class="rev-control-btn rev-sbutton rev-sbutton-red" style="margin-right:10px;vertical-align:top">
							<i class="fa-icon-google-plus"></i>
						</span>

						<span data-needclass="" class="rev-control-btn rev-sbutton" style="margin-right:10px;vertical-align:top">
							<i class="fa-icon-envelope"></i>
						</span>

						<div style="width:100%;height:25px;display:block"></div>
						<span data-needclass="" class="rev-control-btn rev-cbutton-dark" style="margin-right:10px">
							<i class="fa-icon-play"></i>
						</span>

						<span data-needclass="" class="rev-control-btn rev-cbutton-light" style="margin-right:10px">
							<i class="fa-icon-play"></i>
						</span>

						<span data-needclass="" class="rev-control-btn rev-cbutton-dark-sr" style="margin-right:10px">
							<i class="fa-icon-play"></i>
						</span>

						<span data-needclass="" class="rev-control-btn rev-cbutton-light-sr" style="margin-right:10px">
							<i class="fa-icon-play"></i>
						</span>
						<div style="width:100%;height:25px;display:block"></div>
						<span data-needclass="" class="rev-control-btn rev-cbutton-dark" style="margin-right:10px">
							<i class="fa-icon-pause"></i>
						</span>

						<span data-needclass="" class="rev-control-btn rev-cbutton-light" style="margin-right:10px">
							<i class="fa-icon-pause"></i>
						</span>

						<span data-needclass="" class="rev-control-btn rev-cbutton-dark-sr" style="margin-right:10px">
							<i class="fa-icon-pause"></i>
						</span>

						<span data-needclass="" class="rev-control-btn rev-cbutton-light-sr" style="margin-right:10px">
							<i class="fa-icon-pause"></i>
						</span>
						<div style="width:100%;height:25px;display:block"></div>

						
					</div>
				</div>
			</div>
			<div id="addbutton-settings">
				<div class="adb-configs" style="padding-top:0px">
					<!-- TITLE -->
					<div class="add-togglebtn"><span class="addbutton-title"><?php _e("Idle State",'revslider'); ?></span><span class="adb-toggler eg-icon-minus"></span></div>
					<div class="add-intern-accordion" style="display:block">
						<!-- COLOR 1 -->
						<div class="add-lbl-wrapper">
						<label><?php _e("Background",'revslider'); ?></label>
						</div>					
						<!-- COLOR -->					
						<input type="text" class="rs-layer-input-field my-color-field" style="width:150px" name="adbutton-color-1" value="#000000" />
						<span class="rs-layer-toolbar-space" style="margin-right:0px"></span>

						<!-- OPACITY -->
						<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon " style="margin-right:5px"></i>
						<input data-suffix="" class="adb-input rs-layer-input-field "  style="width:45px" type="text" name="adbutton-opacity-1" value="0.75">
						

						
						<!-- TEXT / ICON -->
						<div style="width:100%;height:5px"></div>
						<div class="add-lbl-wrapper">
						<label><?php _e("Color",'revslider'); ?></label>
						</div>					
						<!-- TEXT COLOR -->					
						<input type="text" class="rs-layer-input-field  my-color-field" title="<?php _e("Color 2",'revslider'); ?>" style="width:150px" name="adbutton-color-2" value="#ffffff" />
						<span class="rs-layer-toolbar-space" style="margin-right:0px"></span>					

						<!-- TEXT OPACITY -->
						<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon "  style="margin-right:5px"></i>
						<input class="adb-input rs-layer-input-field "  style="width:45px" type="text" name="adbutton-opacity-2" value="1">
						<span class="rs-layer-toolbar-space" style="margin-right:0px"></span>

						
						<!-- BORDER -->
						<div style="width:100%;height:5px"></div>
						<div class="add-lbl-wrapper">
						<label><?php _e("Border",'revslider'); ?></label>
						</div>					
						<!-- BORDER COLOR -->					
						<input type="text" class="rs-layer-input-field  my-color-field" title="<?php _e("Border Color",'revslider'); ?>" style="width:150px" name="adbutton-border-color" value="#000000" />
						<span class="rs-layer-toolbar-space" style="margin-right:0px"></span>					

						<!-- BORDER OPACITY -->
						<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon " title="<?php _e("Border Opacity",'revslider'); ?>" style="margin-right:5px"></i>
						<input class="adb-input rs-layer-input-field " title="<?php _e("Border Opacity",'revslider'); ?>" style="width:45px" type="text" name="adbutton-border-opacity" value="1">
						<span class="rs-layer-toolbar-space" style="margin-right:0px"></span>

						<!-- BORDER WIDTH-->
						<i class="rs-mini-layer-icon rs-icon-borderwidth rs-toolbar-icon " title="<?php _e("Border Width",'revslider'); ?>" style="margin-right:5px"></i>
						<input class="adb-input text-sidebar rs-layer-input-field " title="<?php _e("Border Width",'revslider'); ?>" style="width:45px" type="text" name="adbutton-border-width" value="0">
						<div style="width:100%;height:5px"></div>
						
						<!-- ICON  & FONT-->
						<div style="width:100%;height:5px"></div>
						<div class="add-lbl-wrapper">
						<label><?php _e("Text / Icon",'revslider'); ?></label>
						</div>					
					
						<span class="addbutton-icon"><i class="fa-icon-chevron-right"></i></span>
						<span class="rs-layer-toolbar-space" style="margin-right:0px"></span>

						<i class="rs-mini-layer-icon rs-icon-fontfamily rs-toolbar-icon " title="<?php _e("Font Family",'revslider'); ?>" style="margin-right:5px"></i>
						<input class="adb-input text-sidebar rs-layer-input-field " title="<?php _e("Font Family",'revslider'); ?>" style="width:75px" type="text" name="adbutton-fontfamily" value="Roboto">
						
					</div>
				</div>
				<div class="adb-configs">
					<!-- TITLE -->
					<div class="add-togglebtn"><span class="addbutton-title"><?php _e("Hover State",'revslider'); ?></span><span class="adb-toggler eg-icon-plus"></span></div>
					<div class="add-intern-accordion" style="display:none">
						<!-- COLOR 1 -->
						<div class="add-lbl-wrapper">
						<label><?php _e("Background",'revslider'); ?></label>
						</div>					
						<!-- COLOR -->					
						<input type="text" class="rs-layer-input-field my-color-field" style="width:150px" name="adbutton-color-1-h" value="#FFFFFF" />
						<span class="rs-layer-toolbar-space" style="margin-right:0px"></span>

						<!-- OPACITY -->
						<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon " style="margin-right:5px"></i>
						<input data-suffix="" class="adb-input rs-layer-input-field "  style="width:45px" type="text" name="adbutton-opacity-1-h" value="1">
						
						<!-- TEXT / ICON -->
						<div style="width:100%;height:5px"></div>
						<div class="add-lbl-wrapper">
						<label><?php _e("Color",'revslider'); ?></label>
						</div>	
						
						<!-- TEXT COLOR -->					
						<input type="text" class="rs-layer-input-field  my-color-field" title="<?php _e("Color 2",'revslider'); ?>" style="width:150px" name="adbutton-color-2-h" value="#000000" />
						<span class="rs-layer-toolbar-space" style="margin-right:0px"></span>					

						<!-- TEXT OPACITY -->
						<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon "  style="margin-right:5px"></i>
						<input class="adb-input rs-layer-input-field "  style="width:45px" type="text" name="adbutton-opacity-2-h" value="1">
						<span class="rs-layer-toolbar-space" style="margin-right:0px"></span>

						
						<!-- BORDER -->
						<div style="width:100%;height:5px"></div>
						<div class="add-lbl-wrapper">
						<label><?php _e("Border",'revslider'); ?></label>
						</div>					
						<!-- BORDER COLOR -->					
						<input type="text" class="rs-layer-input-field  my-color-field" title="<?php _e("Border Color",'revslider'); ?>" style="width:150px" name="adbutton-border-color-h" value="#000000" />
						<span class="rs-layer-toolbar-space" style="margin-right:0px"></span>					

						<!-- BORDER OPACITY -->
						<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon " title="<?php _e("Border Opacity",'revslider'); ?>" style="margin-right:5px"></i>
						<input class="adb-input rs-layer-input-field " title="<?php _e("Border Opacity",'revslider'); ?>" style="width:45px" type="text" name="adbutton-border-opacity-h" value="1">
						<span class="rs-layer-toolbar-space" style="margin-right:0px"></span>

						<!-- BORDER WIDTH-->
						<i class="rs-mini-layer-icon rs-icon-borderwidth rs-toolbar-icon " title="<?php _e("Border Width",'revslider'); ?>" style="margin-right:5px"></i>
						<input class="adb-input text-sidebar rs-layer-input-field " title="<?php _e("Border Width",'revslider'); ?>" style="width:45px" type="text" name="adbutton-border-width-h" value="0">
						<div style="width:100%;height:5px"></div>
					</div>
					
					
				</div>
				<div class="adb-configs">	
					<div class="add-togglebtn"><span class="addbutton-title"><?php _e("Text",'revslider'); ?></span><span class="adb-toggler eg-icon-plus"></span></div>
					<div class="add-intern-accordion" style="display:none">						
						<input class="adb-input text-sidebar rs-layer-input-field " style="width:100%" type="text" name="adbutton-text" value="Click Here">						
					</div>
				</div>

			</div>
		</div>
	</div>

	
	<!-- THE import DIALOG WINDOW -->
	<div id="dialog_addimport" class="dialog-addimport" title="<?php _e('Import Layer','revslider'); ?>" style="display:none;">
		<div id="rs-import-layer-selector">

			<select name="rs-import-layer-slider" id="rs-import-layer-slider" class="rs-layer-input-field">
				<?php
				if(!empty($arrSlidersFull)){
					?>
					<option value="-" selected="selected"><?php _e('-- Select a Slider --', 'revslider'); ?></option>
					<?php
					foreach($arrSlidersFull as $ls_id => $ls_title){
						?>
						<option value="<?php echo esc_attr($ls_id); ?>"><?php echo esc_attr($ls_title); ?></option>
						<?php
					}
				}else{
					?>
					<option value="-" selected="selected"><?php _e('-- No Slider Available --', 'revslider'); ?></option>
					<?php
				}
				?>
			</select>
			<select name="rs-import-layer-slide" id="rs-import-layer-slide" class="rs-layer-input-field">
				<option value="-" selected="selected"><?php _e('-- Select a Slide --', 'revslider'); ?></option>
				<option value="all" selected="selected"><?php _e('All', 'revslider'); ?></option>
				
			</select>
			<select name="rs-import-layer-type" id="rs-import-layer-type" class="rs-layer-input-field">
				<option value="-" selected="selected"><?php _e('-- Select a Layer Type --', 'revslider'); ?></option>
				<option value="all"><?php _e('All', 'revslider'); ?></option>
				<option value="text"><?php _e('Text', 'revslider'); ?></option>
				<option value="image"><?php _e('Image', 'revslider'); ?></option>
				<option value="video"><?php _e('Video', 'revslider'); ?></option>
				<option value="button"><?php _e('Button', 'revslider'); ?></option>
				<option value="shape"><?php _e('Shape', 'revslider'); ?></option>
			</select>
			
			<ul id="rs-import-layer-holder">
				<div class="first-import-notice">
					<i class="eg-icon-download"></i>
					<span class="big-blue-block"><?php _e('Select a Slider/Slide/Layer to Import', 'revslider'); ?></span>
				</div>
			</ul>
		</div>
	</div>
	
	<script type="text/html" id="tmpl-rs-import-layer-wrap">
		<li id="to-import-layer-id-{{ data['slide_id'] }}-{{ data['unique_id'] }}" data-id="{{ data['unique_id'] }}" data-actiondep="{{ data['action_layers'] }}" data-sliderid="{{ data['slider_id'] }}" data-slideid="{{ data['slide_id'] }}" class="import-layer-li-class import-action-{{ data['withaction'] }}"><i class="rs-icon-layer{{ data['type'] }}"></i><span class="rs-import-layer-name">{{ data['alias'] }}</span><span class="rs-import-layer-dimension">{{ data['width'] }} x {{ data['height'] }}</span><span class="import-layer-withaction"><?php _e("Action Available","revslider"); ?></span><span class="import-layer-tools"><span class="import-layer-imported"><?php _e("Layer Added to Stage","revslider"); ?></span><span class="import-layer-now"><i class="eg-icon-plus"></i></span></span></li>
	</script>

	<script tyle="javascript">	
		jQuery(document).ready(function() {
			
			function hoverActionAllChildren(el) {				
				var	actionarray = el.data('actiondep'),
					sid = el.data('slideid'),
					a = actionarray.length>1 ? actionarray.split(",") : new Array();

					if (a.length==0) a.push(actionarray);				

				if (a && a.length>0) {
					jQuery.each(a,function(i,uid) {
						jQuery('#to-import-layer-id-'+sid+'-'+uid).addClass("actionhover");
					});
				}
			}

			jQuery('body').on('mouseenter','.import-layer-li-class',function() {
				hoverActionAllChildren(jQuery(this));
			});

			jQuery('body').on('mouseleave','.import-layer-li-class',function() {
					jQuery('.import-layer-li-class.actionhover').removeClass("actionhover");
			});

			
		});
	</script>
	<!-- THE shape DIALOG WINDOW -->
	<div id="dialog_addshape" class="dialog-addshape" title="<?php _e("Add Shape Layer",'revslider'); ?>" style="display:none">
		<div class="addbuton-dialog-inner">
			<div id="addshape-examples">
				<div class="addbe-title-row">					
					<span class="addshape-bg-light"></span>
					<span class="addshape-bg-dark"></span>
					<span class="addshape-title"><?php _e("Click your Shape below to add it",'revslider'); ?></span>
				</div>
				<div class="addshape-examples-wrapper">
					
				</div>

			</div>
			<div id="addshape-settings">
				<div class="adb-configs" style="padding-top:0px">
					<!-- TITLE -->
					<span class="addshape-title"><?php _e("Shape Settings",'revslider'); ?></span>
					<div class="add-intern-accordion" style="display:block">	
						<!-- COLOR 1 -->
						<div class="add-lbl-wrapper">
						<label><?php _e("Background",'revslider'); ?></label>
						</div>					
						<!-- COLOR -->					
						<input type="text" class="rs-layer-input-field my-color-field" style="width:150px" name="adshape-color-1" value="#000000" />
						<span class="rs-layer-toolbar-space" style="margin-right:0px"></span>

						<!-- OPACITY -->
						<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon " style="margin-right:5px"></i>
						<input data-suffix="" class="ads-input rs-layer-input-field "  style="width:45px" type="text" name="adshape-opacity-1" value="0.5">
						
						<!-- BORDER -->
						<div style="width:100%;height:5px"></div>
						<div class="add-lbl-wrapper">
						<label><?php _e("Border",'revslider'); ?></label>
						</div>					

						<!-- BORDER COLOR -->					
						<input type="text" class="rs-layer-input-field  my-color-field" title="<?php _e("Border Color",'revslider'); ?>" style="width:150px" name="adshape-border-color" value="#000000" />
						<span class="rs-layer-toolbar-space" style="margin-right:0px"></span>					

						<!-- BORDER OPACITY -->
						<i class="rs-mini-layer-icon rs-icon-opacity rs-toolbar-icon " title="<?php _e("Border Opacity",'revslider'); ?>" style="margin-right:5px"></i>
						<input class="ads-input rs-layer-input-field " title="<?php _e("Border Opacity",'revslider'); ?>" style="width:45px" type="text" name="adshape-border-opacity" value="0.5">
						<span class="rs-layer-toolbar-space" style="margin-right:0px"></span>

						<!-- BORDER WIDTH-->
						<i class="rs-mini-layer-icon rs-icon-borderwidth rs-toolbar-icon " title="<?php _e("Border Width",'revslider'); ?>" style="margin-right:5px"></i>
						<input class="ads-input text-sidebar rs-layer-input-field " title="<?php _e("Border Width",'revslider'); ?>" style="width:45px" type="text" name="adshape-border-width" value="0">
						<div style="width:100%;height:5px"></div>	


						<!-- BORDER RADIUS-->
						<div style="width:100%;height:5px"></div>
						<div class="add-lbl-wrapper">
						<label><?php _e("Border Radius",'revslider'); ?></label>
						</div>					
						<i class="rs-mini-layer-icon rs-icon-borderradius rs-toolbar-icon"  style="margin-right:10px"></i>
						<input data-suffix="px" class="ads-input text-sidebar rs-layer-input-field "  style="width:50px" type="text" name="shape_border-radius[]" value="0">
						<input data-suffix="px" class="ads-input text-sidebar rs-layer-input-field "  style="width:50px" type="text" name="shape_border-radius[]" value="0">
						<input data-suffix="px" class="ads-input text-sidebar rs-layer-input-field "  style="width:50px" type="text" name="shape_border-radius[]" value="0">
						<input data-suffix="px" class="ads-input text-sidebar rs-layer-input-field "  style="width:50px" type="text" name="shape_border-radius[]" value="0">
						
						<!-- SIZE OF SHAPE-->
						<div style="width:100%;height:5px"></div>
						<div class="add-lbl-wrapper">
						<label><?php _e("Width",'revslider'); ?></label>
						<span class="rs-layer-toolbar-space" style="margin-right:30px"></span>
						<label><?php _e("Full-Width",'revslider'); ?></label> 
						</div>				
						<input class="ads-input text-sidebar rs-layer-input-field "  style="width:50px" type="text" name="shape_width" value="200">
						<span class="rs-layer-toolbar-space" style="margin-right:13px"></span>						
						<input type="checkbox" name="shape_fullwidth" class="tp-moderncheckbox"/>

						<div style="width:100%;height:5px"></div>
						<div class="add-lbl-wrapper">
						<label><?php _e("Height",'revslider'); ?></label>
						<span class="rs-layer-toolbar-space" style="margin-right:30px"></span>
						<label><?php _e("Full-Height",'revslider'); ?></label> 
						</div>				
						<input class="ads-input text-sidebar rs-layer-input-field "  style="width:50px" type="text" name="shape_height" value="200">
						<span class="rs-layer-toolbar-space" style="margin-right:13px"></span>						
						<input type="checkbox" name="shape_fullheight" class="tp-moderncheckbox"/>

						<div class="shape_padding">
							<!-- SIZE OF SHAPE-->
							<div style="width:100%;height:5px"></div>
							<div class="add-lbl-wrapper">
								<label><?php _e("Padding",'revslider'); ?></label>
							</div>
							<i class="rs-mini-layer-icon rs-icon-padding rs-toolbar-icon" title="<?php _e("Padding",'revslider'); ?>" style="margin-right:10px"></i>
							<input data-suffix="px" disabled class="ads-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Padding Top",'revslider'); ?>" style="width:50px" type="text" name="shape_padding[]" value="0">
							<input data-suffix="px" disabled class="ads-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Padding Right",'revslider'); ?>" style="width:50px" type="text" name="shape_padding[]" value="0">
							<input data-suffix="px" disabled class="ads-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Padding Bottom",'revslider'); ?>" style="width:50px" type="text" name="shape_padding[]" value="0">
							<input data-suffix="px" disabled class="ads-input text-sidebar rs-layer-input-field tipsy_enabled_top" title="<?php _e("Padding Left",'revslider'); ?>" style="width:50px" type="text" name="shape_padding[]" value="0">
							
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	
	<div id="dialog-change-style-from-css" title="<?php _e('Apply Styles to Selection', 'revslider') ?>" style="display:none;width:275px">
				
		<div style="margin-top:3px;margin-bottom:13px;">
			<div class="rs-style-device-wrap"><div data-type="desktop" class="rs-style-device_selector_prev rs-preview-ds-desktop selected"></div><input type="checkbox" class="rs-style-device_input" name="rs-css-set-on[]" value="desktop" checked="checked" /></div><?php
		//check if advanced responsive size is enabled and which ones are
		if($adv_resp_sizes === true){
			if($enable_custom_size_notebook == 'on'){ ?><div class="rs-style-device-wrap"><div data-type="notebook" class="rs-style-device_selector_prev rs-preview-ds-notebook"></div><input type="checkbox" class="rs-style-device_input" name="rs-css-set-on[]" value="notebook" checked="checked" /></div><?php }
			if($enable_custom_size_tablet == 'on'){ ?><div class="rs-style-device-wrap"><div data-type="tablet" class="rs-style-device_selector_prev rs-preview-ds-tablet"></div><input type="checkbox" class="rs-style-device_input" name="rs-css-set-on[]" value="tablet" checked="checked" /></div><?php }
			if($enable_custom_size_iphone == 'on'){ ?><div class="rs-style-device-wrap"><div data-type="mobile" class="rs-style-device_selector_prev rs-preview-ds-mobile"></div><input type="checkbox" class="rs-style-device_input" name="rs-css-set-on[]" value="mobile" checked="checked" /></div><?php }
		}
		?>
		</div>
		
		<p style="margin:0px 0px 6px 0px;font-size:14px"><input type="checkbox" name="rs-css-include[]" value="color" checked="checked" /><?php _e('Color', 'revslider'); ?></p>
		<p style="margin:0px 0px 6px 0px;font-size:14px"><input type="checkbox" name="rs-css-include[]" value="font-size" checked="checked" /><?php _e('Font Size', 'revslider'); ?></p>
		<p style="margin:0px 0px 6px 0px;font-size:14px"><input type="checkbox" name="rs-css-include[]" value="line-height" checked="checked" /><?php _e('Line Height', 'revslider'); ?></p>
		<p style="margin:0px 0px 6px 0px;font-size:14px"><input type="checkbox" name="rs-css-include[]" value="font-weight" checked="checked" /><?php _e('Font Weight', 'revslider'); ?></p>
		<p style="margin:20px 0px 0px 0px;font-size:13px;color:#999;font-style:italic"><?php _e('Advanced Styles will alwys be applied to all Device Sizes.', 'revslider'); ?></p>
	</div>
	
	<div id="delete-full-group-dialog" title="<?php _e('Remove Group with Content', 'revslider') ?>" style="display:none;min-width:575px">
		<div class=""><?php _e('Further Layers exist in the Container. Please choose from following options:', 'revslider') ?></div>		
	</div>

	

<script type="text/html" id="tmpl-rs-action-layer-wrap">
	<li class="layer_action_row layer_action_wrap">
		<# if(data['edit'] == true){ #>
		<div class="remove-action-row">
			<i class="eg-icon-minus"></i>
		</div>
		<# }else{ #>
		
		<# } #>
		
		<select name="<# if(data['edit'] == false){ #>no_<# } #>layer_tooltip_event[]" class="<# if(data['edit'] == false){ #>rs_disabled_field <# } #>rs-layer-input-field" style="width:100px; margin-right:30px;">
			<option <# if( data['tooltip_event'] == 'click' ){ #>selected="selected" <# } #>value="click"><?php _e("Click",'revslider'); ?></option>
			<option <# if( data['tooltip_event'] == 'mouseenter' ){ #>selected="selected" <# } #>value="mouseenter"><?php _e("Mouse Enter",'revslider'); ?></option>
			<option <# if( data['tooltip_event'] == 'mouseleave' ){ #>selected="selected" <# } #>value="mouseleave"><?php _e("Mouse Leave",'revslider'); ?></option>
		</select>
		
		<select name="<# if(data['edit'] == false){ #>no_<# } #>layer_action[]" class="<# if(data['edit'] == false){ #>rs_disabled_field <# } #>layer_actions rs-layer-input-field" style="width:150px; margin-right:30px;">						
			<option <# if( data['action'] == 'none' ){ #>selected="selected" <# } #>value="none"><?php _e("Disabled",'revslider'); ?></option>
			<option <# if( data['action'] == 'link' ){ #>selected="selected" <# } #>value="link"><?php _e("Simple Link",'revslider'); ?></option>
			<option <# if( data['action'] == 'jumpto' ){ #>selected="selected" <# } #>value="jumpto"><?php _e("Jump to Slide",'revslider'); ?></option>
			<option <# if( data['action'] == 'next' ){ #>selected="selected" <# } #>value="next"><?php _e("Next Slide",'revslider'); ?></option>
			<option <# if( data['action'] == 'prev' ){ #>selected="selected" <# } #>value="prev"><?php _e("Previous Slide",'revslider'); ?></option>
			<option <# if( data['action'] == 'pause' ){ #>selected="selected" <# } #>value="pause"><?php _e("Pause Slider",'revslider'); ?></option>								
			<option <# if( data['action'] == 'resume' ){ #>selected="selected" <# } #>value="resume"><?php _e("Play Slider",'revslider'); ?></option>																
			<option <# if( data['action'] == 'toggle_slider' ){ #>selected="selected" <# } #>value="toggle_slider"><?php _e("Toggle Slider",'revslider'); ?></option>																
			<option <# if( data['action'] == 'callback' ){ #>selected="selected" <# } #>value="callback"><?php _e("CallBack",'revslider'); ?></option>												
			<option <# if( data['action'] == 'scroll_under' ){ #>selected="selected" <# } #>value="scroll_under"><?php _e("Scroll Below Slider",'revslider'); ?></option>
			<option <# if( data['action'] == 'start_in' ){ #>selected="selected" <# } #>value="start_in"><?php _e('Start Layer "in" Animation','revslider'); ?></option>
			<option <# if( data['action'] == 'start_out' ){ #>selected="selected" <# } #>value="start_out"><?php _e('Start Layer "out" Animation','revslider'); ?></option>
			<option <# if( data['action'] == 'toggle_layer' ){ #>selected="selected" <# } #>value="toggle_layer"><?php _e('Toggle Layer Animation','revslider'); ?></option>
			<option <# if( data['action'] == 'start_video' ){ #>selected="selected" <# } #>value="start_video"><?php _e('Start Media','revslider'); ?></option>
			<option <# if( data['action'] == 'stop_video' ){ #>selected="selected" <# } #>value="stop_video"><?php _e('Stop Media','revslider'); ?></option>
			<option <# if( data['action'] == 'toggle_video' ){ #>selected="selected" <# } #>value="toggle_video"><?php _e('Toggle Media','revslider'); ?></option>			
			<option <# if( data['action'] == 'mute_video' ){ #>selected="selected" <# } #>value="mute_video"><?php _e('Mute Media','revslider'); ?></option>
			<option <# if( data['action'] == 'unmute_video' ){ #>selected="selected" <# } #>value="unmute_video"><?php _e('Unmute Media','revslider'); ?></option>
			<option <# if( data['action'] == 'toggle_mute_video' ){ #>selected="selected" <# } #>value="toggle_mute_video"><?php _e('Toggle Mute Media','revslider'); ?></option>			
			<option <# if( data['action'] == 'toggle_global_mute_video' ){ #>selected="selected" <# } #>value="toggle_global_mute_video"><?php _e('Toggle Mute All Media','revslider'); ?></option>			
			<option <# if( data['action'] == 'simulate_click' ){ #>selected="selected" <# } #>value="simulate_click"><?php _e('Simulate Click','revslider'); ?></option>
			<option <# if( data['action'] == 'toggle_class' ){ #>selected="selected" <# } #>value="toggle_class"><?php _e('Toggle Layer Class','revslider'); ?></option>
			<option <# if( data['action'] == 'togglefullscreen' ){ #>selected="selected" <# } #>value="togglefullscreen"><?php _e("Toggle FullScreen",'revslider'); ?></option>
			<option <# if( data['action'] == 'gofullscreen' ){ #>selected="selected" <# } #>value="gofullscreen"><?php _e("Go FullScreen",'revslider'); ?></option>
			<option <# if( data['action'] == 'exitfullscreen' ){ #>selected="selected" <# } #>value="exitfullscreen"><?php _e("Exit FullScreen",'revslider'); ?></option>
			<?php do_action( 'rs_action_add_layer_action' ); ?>
		</select>
		<!-- SIMPLE LINK PARAMETERS -->
		<span class="action-link-wrapper" style="display:none;">
			<span><?php _e("Link Url",'revslider'); ?></span>
			<span class="rs-layer-toolbar-space"></span>
			<input type="text" style="width:150px;margin-right:30px;" class="<# if(data['edit'] == false){ #>rs_disabled_field <# } #>textbox-caption rs-layer-input-field"  name="<# if(data['edit'] == false){ #>no_<# } #>layer_image_link[]" value="{{ data['image_link'] }}">

			<span><?php _e("Link Target",'revslider'); ?></span>
			<span class="rs-layer-toolbar-space"></span>
			<select name="<# if(data['edit'] == false){ #>no_<# } #>layer_link_open_in[]" class="<# if(data['edit'] == false){ #>rs_disabled_field <# } #>rs-layer-input-field" style="width:150px;margin-right:30px;">
				<option <# if( data['link_open_in'] == '_same' ){ #>selected="selected" <# } #>value="_self"><?php _e("Same Window",'revslider'); ?></option>
				<option <# if( data['link_open_in'] == '_blank' ){ #>selected="selected" <# } #>value="_blank"><?php _e("New Window",'revslider'); ?></option>
			</select>
			
			<span><?php _e("Link Type",'revslider'); ?></span>
			<span class="rs-layer-toolbar-space"></span>
			<select name="<# if(data['edit'] == false){ #>no_<# } #>layer_link_type[]" class="<# if(data['edit'] == false){ #>rs_disabled_field <# } #>rs-layer-input-field" style="width:150px">
				<option <# if( data['link_type'] == 'jquery' ){ #>selected="selected" <# } #>value="jquery"><?php _e("jQuery Link",'revslider'); ?></option>
				<option <# if( data['link_type'] == 'a' ){ #>selected="selected" <# } #>value="a"><?php _e("a Tag Link",'revslider'); ?></option>
			</select>
		</span>


		<!-- JUMP TO SLIDE -->
		<span class="action-jump-to-slide" style="display:none;">
			<span><?php _e("Jump To",'revslider'); ?></span>
			<span class="rs-layer-toolbar-space"></span>
			<select name="<# if(data['edit'] == false){ #>no_<# } #>jump_to_slide[]" class="<# if(data['edit'] == false){ #>rs_disabled_field <# } #>rs-layer-input-field" style="width:150px" data-selectoption="{{ data['jump_to_slide'] }}">
			</select>		
		</span>

		<!-- SCROLL OFFSET -->
		<span class="action-scrollofset" style="display:none;">						
			<span><?php _e("Scroll Offset",'revslider'); ?></span>
			<span class="rs-layer-toolbar-space" ></span>
			<input type="text" style="width:125px;" class="<# if(data['edit'] == false){ #>rs_disabled_field <# } #>textbox-caption rs-layer-input-field"  name="<# if(data['edit'] == false){ #>no_<# } #>layer_scrolloffset[]" value="{{ data['scrolloffset'] }}">						
		</span>

		<!-- CALLBACK FUNCTION-->
		<span class="action-callback" style="display:none;">						
			<span><?php _e("Function",'revslider'); ?></span>
			<span class="rs-layer-toolbar-space" ></span>
			<input type="text" style="width:250px;" class="<# if(data['edit'] == false){ #>rs_disabled_field <# } #>textbox-caption rs-layer-input-field"  name="<# if(data['edit'] == false){ #>no_<# } #>layer_actioncallback[]" value="{{ data['actioncallback'] }}">						
		</span>

		<span class="action-target-layer" style="display:none;">
			<span><?php _e("Target",'revslider'); ?></span>
			<span class="rs-layer-toolbar-space"></span>
			<select name="<# if(data['edit'] == false){ #>no_<# } #>layer_target[]" id="layer_target" class="<# if(data['edit'] == false){ #>rs_disabled_field <# } #>rs-layer-input-field" style="width:100px;margin-right:30px;" data-selectoption="{{ data['layer_target'] }}">
			</select>
			
		</span>		


		<span class="action-toggle_layer" style="display:none;">
			<span class="rs-layer-toolbar-space"></span>
			<span><?php _e("at Start",'revslider'); ?></span>
			<select name="<# if(data['edit'] == false){ #>no_<# } #>toggle_layer_type[]" class="<# if(data['edit'] == false){ #>rs_disabled_field <# } #>rs-layer-input-field" style="width:150px">
				<option <# if( data['toggle_layer_type'] == 'visible' ){ #>selected="selected" <# } #>value="visible"><?php _e("Play In Animation",'revslider'); ?></option>
				<option <# if( data['toggle_layer_type'] == 'hidden' ){ #>selected="selected" <# } #>value="hidden"><?php _e("Keep Hidden",'revslider'); ?></option>
			</select>
		</span>	

		<!-- TOGGLE CLASS FUNCTION-->
		<span class="action-toggleclass" style="display:none;">	
			<span class="rs-layer-toolbar-space"></span>
			<span><?php _e("Class",'revslider'); ?></span>
			<span class="rs-layer-toolbar-space" ></span>
			<input type="text" style="width:100px;" class="<# if(data['edit'] == false){ #>rs_disabled_field <# } #>textbox-caption rs-layer-input-field"  name="<# if(data['edit'] == false){ #>no_<# } #>layer_toggleclass[]" value="{{ data['toggle_class'] }}">
		</span>
		
		<!-- Trigger States -->
		<span class="action-triggerstates" style="display: none; white-space:nowrap">
			<span class="rs-layer-toolbar-space" style="margin-left:42px"></span>
			<span><?php _e("Animation Timing",'revslider'); ?></span>
			<span class="rs-layer-toolbar-space" ></span>
			<select name="<# if(data['edit'] == false){ #>no_<# } #>do-layer-animation-overwrite[]" class="<# if(data['edit'] == false){ #>rs_disabled_field <# } #>rs-layer-input-field" style="width:150px; margin-right:23px">
				<option value="default"><?php _e("In and Out Animation Default",'revslider'); ?></option>
				<option value="waitout"><?php _e("In Animation Default and Out Animation Wait for Trigger",'revslider'); ?></option>
				<option value="wait"><?php _e("Wait for Trigger",'revslider'); ?></option>
			</select>
			<span class="rs-layer-toolbar-space" ></span>
			<span><?php _e("Trigger Memory",'revslider'); ?></span>
			<span class="rs-layer-toolbar-space" ></span>
			<select name="<# if(data['edit'] == false){ #>no_<# } #>do-layer-trigger-memory[]" class="<# if(data['edit'] == false){ #>rs_disabled_field <# } #>rs-layer-input-field" style="width:150px">
				<option value="reset"><?php _e("Reset Animation and Trigger States every loop",'revslider'); ?></option>
				<option value="keep"><?php _e("Keep last selected State",'revslider'); ?></option>
			</select>
		</span>

		<?php do_action( 'rs_action_add_layer_action_details' ); ?>

		<span class="action-delay-wrapper" style="display: none; white-space:nowrap">			
			<span><?php _e("Delay",'revslider'); ?></span>
			<span class="rs-layer-toolbar-space"></span>
			<input type="text" style="width:60px;margin-top:-2px" class="<# if(data['edit'] == false){ #>rs_disabled_field <# } #>textbox-caption rs-layer-input-field" name="<# if(data['edit'] == false){ #>no_<# } #>layer_action_delay[]" value="{{ data['action_delay'] }}"> <?php _e('ms', 'revslider'); ?>
		</span>


	</li>
</script>

	<script>
		// CHANGE STYLE OF EXAMPLE BUTTONS ON DEMAND
		// RGBA HEX CALCULATOR
		var local_cHex = function(hex,o){	
			o = parseFloat(o);
		    hex = hex.replace('#','');	    
		    var r = parseInt(hex.substring(0,2), 16),
		    	g = parseInt(hex.substring(2,4), 16),
		    	b = parseInt(hex.substring(4,6), 16),
				result = 'rgba('+r+','+g+','+b+','+o+')';
		    return result;
		}

		var getButtonExampleValues = function() {
			var o = new Object();
			o.bgc = local_cHex(jQuery('input[name="adbutton-color-1"]').val(), jQuery('input[name="adbutton-opacity-1"]').val());
			o.col = local_cHex(jQuery('input[name="adbutton-color-2"]').val(), jQuery('input[name="adbutton-opacity-2"]').val());
			o.borc = local_cHex(jQuery('input[name="adbutton-border-color"]').val(), jQuery('input[name="adbutton-border-opacity"]').val());
			o.borw = parseInt(jQuery('input[name="adbutton-border-width"]').val(),0)+"px";
			o.borwh = parseInt(jQuery('input[name="adbutton-border-width-h"]').val(),0)+"px";
			o.bgch = local_cHex(jQuery('input[name="adbutton-color-1-h"]').val(), jQuery('input[name="adbutton-opacity-1-h"]').val());
			o.colh = local_cHex(jQuery('input[name="adbutton-color-2-h"]').val(), jQuery('input[name="adbutton-opacity-2-h"]').val());
			o.borch = local_cHex(jQuery('input[name="adbutton-border-color-h"]').val(), jQuery('input[name="adbutton-border-opacity-h"]').val());
			o.ff = jQuery('input[name="adbutton-fontfamily"]').val();
			return o;
		}

		var setExampleButtons = function() {
			var c = jQuery('#addbutton-examples');
			c.find('.rev-btn').each(function() {
				var b = jQuery(this),
					o = getButtonExampleValues();
								
				b.css({backgroundColor:o.bgc,
					   color:o.col,
					   fontFamily:o.ff});
				
				b.find('i').css({color:o.col});


				if (b.hasClass("rev-bordered"))
					b.css({borderColor:o.borc,borderWidth:o.borw,borderStyle:"solid"})

				if (b.find('i').length>0) {
					b.find('i').remove();
					b.html(jQuery('input[name="adbutton-text"]').val());
					b.append(jQuery('.addbutton-icon').html());					
				} else {					
					b.html(jQuery('input[name="adbutton-text"]').val());
				}

				b.unbind('hover');
				b.hover(function() {
					var b = jQuery(this),
					o = getButtonExampleValues();				
					b.css({backgroundColor:o.bgch,color:o.colh});
					b.find('i').css({color:o.colh});					
					if (b.hasClass("rev-bordered"))
						b.css({borderColor:o.borch,borderWidth:o.borwh,borderStyle:"solid"});
				},
				function() {
					var b = jQuery(this),
					o = getButtonExampleValues();				
					b.css({backgroundColor:o.bgc,color:o.col});
					b.find('i').css({color:o.col});					
					if (b.hasClass("rev-bordered"))
						b.css({borderColor:o.borc,borderWidth:o.borw,borderStyle:"solid"});
				})

			})
		}

		var setExampleShape = function() {
			var p = jQuery('.addshape-examples-wrapper'),
				o = new Object();
			
			o.bgc = local_cHex(jQuery('input[name="adshape-color-1"]').val(), jQuery('input[name="adshape-opacity-1"]').val());
			o.w = parseInt(jQuery('input[name="shape_width"]').val(),0);
			o.h = parseInt(jQuery('input[name="shape_height"]').val(),0);
			o.borc = local_cHex(jQuery('input[name="adshape-border-color"]').val(), jQuery('input[name="adshape-border-opacity"]').val());
			o.borw = parseInt(jQuery('input[name="adshape-border-width"]').val(),0)+"px";			
			o.fw = jQuery('input[name="shape_fullwidth"]').is(':checked');
			o.fh = jQuery('input[name="shape_fullheight"]').is(':checked');	
			o.br = "";

			if (o.fw) {
				o.w = "100%";
				o.l = "0px";
				o.ml = "0px";
				jQuery('input[name="shape_width"]').attr("disabled","disabled");
			} else {
				o.w = parseInt(o.w,0)+"px";
				o.l="50%";
				o.ml = 0 - parseInt(o.w,0)/2;
				jQuery('input[name="shape_width"]').removeAttr("disabled");				
			}

			if (o.fh) {
				o.h = "100%";
				o.t = "0px";
				o.mt = "0px";
				jQuery('input[name="shape_height"]').attr("disabled","disabled");				
			} else {
				o.h = parseInt(o.h,0)+"px";
				o.t = "50%";
				o.mt = 0 - parseInt(o.h,0)/2;
				jQuery('input[name="shape_height"]').removeAttr("disabled");				
			}

			jQuery('input[name="shape_border-radius[]"]').each(function(i){		
				var t = jQuery.isNumeric(jQuery(this).val()) ? parseInt(jQuery(this).val(),0)+"px" : jQuery(this).val();
				o.br = o.br + t;
				o.br = i<3 ? o.br+" ":o.br;
			});
			o.pad="";
			if (o.fh && o.fw) {
				jQuery('input[name="shape_padding[]"]').removeAttr("disabled");
				jQuery('input[name="shape_padding[]"]').each(function(i){
					var t = jQuery.isNumeric(jQuery(this).val()) ? parseInt(jQuery(this).val(),0)+"px" : jQuery(this).val();
					o.pad = o.pad + t;
					o.pad = i<3 ? o.pad+" ":o.pad;

				});
			} else {
				jQuery('input[name="shape_padding[]"]').attr("disabled","disabled");
				o.pad="0";
				
			}
			
			if (p.find('.example-shape').length==0)
				p.append('<div class="example-shape-wrapper"><div class="example-shape"></div></div>');
			var e = p.find('.example-shape');

			e.css({backgroundColor:o.bgc, 
				   padding:o.pad,				   
				   borderStyle:"solid", borderWidth:o.borw, borderColor:o.borc, borderRadius:o.br});
			e.parent().css({
					top:o.t, left:o.l, marginLeft:o.ml,marginTop:o.mt,
				  	width:o.w, height:o.h,
					padding:o.pad
			})
			RevSliderSettings.onoffStatus(jQuery('input[name="shape_fullwidth"]'));
			RevSliderSettings.onoffStatus(jQuery('input[name="shape_fullheight"]'));
		}

		

		jQuery(document).ready(function() {

			jQuery('#quick-layers-list-id').perfectScrollbar({wheelPropagation:false});

			// MANAGE BG COLOR OF DIALOG BOXES
			jQuery('.addbutton-bg-dark').click(function() { jQuery('#addbutton-examples').css({backgroundColor:"#333333"});})
			jQuery('.addbutton-bg-light').click(function() { jQuery('#addbutton-examples').css({backgroundColor:"#eeeeee"});})
			jQuery('.addshape-bg-dark').click(function() { jQuery('#addshape-examples').css({backgroundColor:"#333333"});})
			jQuery('.addshape-bg-light').click(function() { jQuery('#addshape-examples').css({backgroundColor:"#eeeeee"});})
			
			// ADD BUTTON DIALOG RELEVANT FUNCTIONS
			jQuery('.addbutton-examples-wrapper').perfectScrollbar({wheelPropagation:true});
			jQuery('.add-togglebtn').click(function() {
				var aia = jQuery(this).parent().find('.add-intern-accordion');
				aia.addClass("nowactive");
				jQuery('.add-intern-accordion').each(function() {
					if (!jQuery(this).hasClass("nowactive")) jQuery(this).slideUp(200);
				});
				jQuery('.adb-toggler').removeClass("eg-icon-minus").addClass("eg-icon-plus");
				aia.slideDown(200);
				jQuery(this).find('.adb-toggler').addClass("eg-icon-minus").removeClass("eg-icon-plus");
				aia.removeClass("nowactive");
			})


			jQuery('body').on("click","fake-select-i, #fake-select-label" ,function() {
				var tab = jQuery('#slide-animation-settings-content-tab');
				tab.click();
				jQuery("html, body").animate({scrollTop:(tab.offset().top-200)+"px"},{duration:400});
			})

			jQuery('#divLayers-wrapper').perfectScrollbar({ suppressScrollY:true});

			
			function makelayerswrapperscrollable() {
				jQuery('.master-rightcell .layers-wrapper').perfectScrollbar({wheelPropagation:true, suppressScrollY:true});
				jQuery('.master-leftcell .layers-wrapper').perfectScrollbar({wheelPropagation:true,suppressScrollX:true});					
			}

			document.addEventListener('ps-scroll-y', function (e) {
				if (jQuery(e.target).closest('.master-rightcell').length>0) {
					var st = jQuery('.master-rightcell .layers-wrapper').scrollTop();							
					jQuery('.master-leftcell .layers-wrapper').scrollTop(st);						
				} else
		        if (jQuery(e.target).closest('.master-leftcell').length>0) {
	        		var st = jQuery('.master-leftcell .layers-wrapper').scrollTop();
					jQuery('.master-rightcell .layers-wrapper').scrollTop(st);												
				}				
		    });

			document.addEventListener('ps-scroll-x', function (e) {
				 if (jQuery(e.target).closest('.master-rightcell').length>0) {
					 	var ls = parseInt(jQuery('.master-rightcell .layers-wrapper').scrollLeft(),0);
						jQuery('#master-rightheader').css({left:(15-ls)}).data('left',(15-ls));
				 }
			});

			jQuery('#master-rightheader').data('left',15);
			
			makelayerswrapperscrollable();
			

			var bawi = jQuery('#thelayer-editor-wrapper').outerWidth(true)-2;
			//jQuery('.master-rightcell').css({maxWidth:bawi-222});
			jQuery('#mastertimer-wrapper').css({maxWidth:bawi});
			jQuery('.layers-wrapper').css({maxWidth:bawi-222});
			var scrint;



			jQuery(window).resize(function() {
				var bawi = jQuery('#thelayer-editor-wrapper').outerWidth(true)-2;
				//jQuery('.master-rightcell').css({maxWidth:bawi-222});
				jQuery('#mastertimer-wrapper').css({maxWidth:bawi});
				jQuery('.layers-wrapper').css({maxWidth:bawi-222});
				jQuery('.master-rightcell .layers-wrapper, #divLayers-wrapper').perfectScrollbar("update");
			});

			jQuery('#mastertimer-wrapper').resizable({
				handles:"s",
				minHeight:102,
				alsoResize:".layers-wrapper",
				start:function() {
					jQuery('.master-rightcell .layers-wrapper').perfectScrollbar("destroy");
				},
				resize:function() {
					
				},
				stop:function() {
					var maxh = ((jQuery('#layers-right ul li').length+1)*30) - ((jQuery('#layers-right ul li.layer-deleted').length+1)*30),	
						curh = jQuery('#mastertimer-wrapper').height();
					
					if (curh>maxh+3) {
						punchgs.TweenLite.set(jQuery('.layers-wrapper'),{height:maxh+3});
						punchgs.TweenLite.set(jQuery('#mastertimer-wrapper'),{height:maxh+3})
					}
					
					jQuery('.master-rightcell .layers-wrapper').perfectScrollbar({wheelPropagation:true});
					jQuery('.master-leftcell .layers-wrapper').perfectScrollbar({wheelPropagation:true, suppressScrollX:true});
					jQuery('#mastertimer-curtime-b').height(maxh+3);
				}
			});
			
			UniteAdminRev.initVideoDef();
		});
	</script>
</div>