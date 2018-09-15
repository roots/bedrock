<?php
/**
 * @package   Revolution Slider
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://revolution.themepunch.com/
 * @copyright 2015 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();

$nav = new RevSliderNavigation();

$navigation = intval(RevSliderBase::getGetVar('navigation', 0));

$navigs = $nav->get_all_navigations();

$rsopr = new RevSliderOperations();


$font_families = $rsopr->getArrFontFamilys();
?>
<script>
	jQuery(document).ready(function(){function r(r){var i;return r=r.replace(/ /g,""),r.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)?(i=100*parseFloat(r.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)[1]).toFixed(2),i=parseInt(i)):i=100,i}function i(r,i,e,t){var n,o,c;n=i.data("a8cIris"),o=i.data("wpWpColorPicker"),n._color._alpha=r,c=n._color.toString(),i.val(c),o.toggler.css({"background-color":c}),t&&a(r,e),i.wpColorPicker("color",c)}function a(r,i){i.slider("value",r),i.find(".ui-slider-handle").text(r.toString())}Color.prototype.toString=function(r){if("no-alpha"==r)return this.toCSS("rgba","1").replace(/\s+/g,"");if(1>this._alpha)return this.toCSS("rgba",this._alpha).replace(/\s+/g,"");var i=parseInt(this._color,10).toString(16);if(this.error)return"";if(i.length<6)for(var a=6-i.length-1;a>=0;a--)i="0"+i;return"#"+i},jQuery.fn.alphaColorPicker=function(){return this.each(function(){var e,t,n,o,c,l,s,d,u,p,f;e=jQuery(this),e.wrap('<div class="alpha-color-picker-wrap"></div>'),n=e.attr("data-palette")||"true",o=e.attr("data-show-opacity")||"true",c=e.attr("data-default-color")||"",l=-1!==n.indexOf("|")?n.split("|"):"false"==n?!1:!0,t=e.val().replace(/\s+/g,""),""==t&&(t=c),s={change:function(i,a){var t,n,o,l;t=e.attr("data-customize-setting-link"),n=e.wpColorPicker("color"),c==n&&(o=r(n),u.find(".ui-slider-handle").text(o)),"undefined"!=typeof wp.customize&&wp.customize(t,function(r){r.set(n)}),l=d.find(".transparency"),l.css("background-color",a.color.toString("no-alpha"))},palettes:l},e.wpColorPicker(s),d=e.parents(".wp-picker-container:first"),jQuery('<div class="alpha-color-picker-container"><div class="min-click-zone click-zone"></div><div class="max-click-zone click-zone"></div><div class="alpha-slider"></div><div class="transparency"></div></div>').appendTo(d.find(".wp-picker-holder")),u=d.find(".alpha-slider"),p=r(t),f={create:function(r,i){var a=jQuery(this).slider("value");jQuery(this).find(".ui-slider-handle").text(a),jQuery(this).siblings(".transparency ").css("background-color",t)},value:p,range:"max",step:1,min:0,max:100,animate:300},u.slider(f),"true"==o&&u.find(".ui-slider-handle").addClass("show-opacity"),d.find(".min-click-zone").on("click",function(){i(0,e,u,!0)}),d.find(".max-click-zone").on("click",function(){i(100,e,u,!0)}),d.find(".iris-palette").on("click",function(){var i,t;i=jQuery(this).css("background-color"),t=r(i),a(t,u),100!=t&&(i=i.replace(/[^,]+(?=\))/,(t/100).toFixed(2))),e.wpColorPicker("color",i)}),d.find(".button.wp-picker-default").on("click",function(){var i=r(c);a(i,u)}),e.on("input",function(){var i=jQuery(this).val(),e=r(i);a(e,u)}),u.slider().on("slide",function(r,a){var t=parseFloat(a.value)/100;i(t,e,u,!1),jQuery(this).find(".ui-slider-handle").text(a.value)})})}});
</script>
<div class='wrap'>
	<div class="clear_both"></div>

	<div class="title_line nobgnopd" style="margin-bottom: 20px !important;">
		<?php 
			$icon_general = '<div class="icon32" id="icon-options-general"></div>';
			echo apply_filters( 'rev_icon_general_filter', $icon_general ); 
		?>
		<div class="view_title">
			<?php _e('Navigation Editor', 'revslider'); ?>
		</div>
	</div>
	
	<div class="setting_box navig" style="margin-bottom: 20px;">
		<h3><span class="setting-step-number">1</span><span style="max-width: 400px;"><?php _e('Select the Navigation Category to Edit', 'revslider'); ?></span> <a original-title="" class="button-primary revblue" id="rs-add-new-navigation-element" href="javascript:void(0);"><?php _e('Add New', 'revslider'); ?></a></h3>
		
		<div class="table-titles">				
			<div class="rs-nav-table-cell rs-nav-table-title"><?php _e('#ID', 'revslider'); ?></div>
			<div class="rs-nav-table-cell rs-nav-table-title"><?php _e('Skin Name', 'revslider'); ?></div>
			<div class="rs-nav-table-cell rs-nav-table-title"><?php _e('Arrows', 'revslider'); ?></div>
			<div class="rs-nav-table-cell rs-nav-table-title"><?php _e('Bullets', 'revslider'); ?></div>
			<div class="rs-nav-table-cell rs-nav-table-title"><?php _e('Thumbs', 'revslider'); ?></div>
			<div class="rs-nav-table-cell rs-nav-table-title"><?php _e('Tabs', 'revslider'); ?></div>	
			<div class="rs-nav-table-cell rs-nav-table-title" style="width:auto;text-align:left;padding:0px 20px;"><?php _e('Actions', 'revslider'); ?></div>
		</div>
		
		<div id="list-of-navigations" style="max-height:430px;overflow:hidden;position:relative;top:0px;left:0px;">  
			<div class="rs-nav-table tablecontent">
				<?php
				//all will be added here through JavaScript
				?>
			</div>
		</div>
	</div>
	
	<div style="clear: both;"></div>
	
	<div class="setting_box navig" style="margin-bottom: 20px;">
		<div class="rs-editing-wrapper" style="display: none;">
			<h3 style="border:0;"><span class="setting-step-number">2</span><span style="max-width: 400px;"><?php _e('Editing', 'revslider'); ?> <span class="rs-nav-editing-title"></span></span> <a href="javascript:void(0);" class="button-primary revred rs-remove-nav-element"><?php _e('Remove', 'revslider'); ?></a></h3>
			<div class="rs-editing-markups-wrap">
				<div class="rs-markup-selector">
					<div class="rs-selector-title"><?php _e('Markup', 'revslider'); ?></div> <span class="rs-editor-open-field"><i class="revicon-list-add"></i></span>
				</div>
				<div class="rs-markup-wrapper" style="display: none;">
					<div class="rs-markup-elements">
						<div style="padding: 20px;" class="closemeshowhide">
							<div class="helper-wrappers">
								<h4><?php _e('Actions', 'revslider'); ?></h4>
								<ul class="rs-element-list">
								<!--	<li id="reset-markup-arrow" data-call="arrows_markup"><span class="libtn"><?php _e('Reset Defaults', 'revslider'); ?><span class="more-values-available resetme"></span></span></li>
									<li id="reset-markup-bullets" data-call="bullets_markup"><span class="libtn"><?php _e('Reset Defaults', 'revslider'); ?><span class="more-values-available resetme"></span></span></li>
									<li id="reset-markup-thumbs" data-call="thumbs_markup"><span class="libtn"><?php _e('Reset Defaults', 'revslider'); ?><span class="more-values-available resetme"></span></span></li>
									<li id="reset-markup-tabs" data-call="tabs_markup"><span class="libtn"><?php _e('Reset Defaults', 'revslider'); ?><span class="more-values-available resetme"></span></span></li>-->
									<li><span class="libtn"><?php _e('Parameters', 'revslider'); ?><span class="more-values-available"></span></span>
										<ul style="display: none;" class="rs-element-add">
											<li data-call="params_special" data-paramid="title"><span class="libtn"><?php _e('Slide Title', 'revslider'); ?></span></li>
											<li data-call="params_special" data-paramid="description"><span class="libtn"><?php _e('Slide Description', 'revslider'); ?></span></li>
											<?php
											for($i=1;$i<=10;$i++){
												?>
												<li data-call="params_markup" data-paramid="<?php echo $i; ?>"><span class="libtn"><?php _e('Parameter ', 'revslider'); ?> <?php echo $i; ?></span></li>
												<?php
											}
											?>
										</ul>
									</li>
								</ul>
							</div>
						</div>
						<div class="showhidehelper"></div>
					</div>

					<textarea name="rs-cm-markup" id="rs-cm-markup"></textarea>
				</div><div class="rs-css-selector open">
					<div class="rs-selector-title"><?php _e('CSS', 'revslider'); ?></div> <span class="rs-editor-open-field"><i class="revicon-list-add"></i></span>
				</div>
				<div class="rs-css-wrapper" style="display: none;">
					<div class="rs-css-elements">
						<div style="padding: 20px;" class="closemeshowhide">
							<div class="helper-wrappers rea-open">
								<h4><span class="libtn"><?php _e('Style Helper', 'revslider'); ?><span class="more-values-available"></span></span></h4>
								<ul class="rs-element-list collapsable" style="display:block">
									<li data-call="color_value"><span class="libtn"><?php _e('Color Value', 'revslider'); ?><span class="more-values-available"></span></span>
										<div style="display: none;" class="rs-element-add rs-element-add-color">										
											<input type="text" name="rs-color" class="my-color-field" value="#000000">
											<span class="tp-clearfix"></span>
											<a href="javascript:void(0);" id="rs-add-css-color" class="button-primary revblue" original-title=""><?php _e('Add', 'revslider'); ?></a>
										</div>
									</li>
									<li data-call="border_radius"><span class="libtn"><?php _e('Border Radius', 'revslider'); ?><span class="more-values-available"></span></span>
										<div style="display: none;" class="rs-element-add rs-element-add-border-radius">
											<label><?php _e('Top Left', 'revslider'); ?></label>
											<input class="rs-small-input" type="text" name="rs-border-radius-top-left" value="1"></td>
											<label><?php _e('Top Right', 'revslider'); ?></label>
											<input class="rs-small-input" type="text" name="rs-border-radius-top-right" value="1"></td>
											<label><?php _e('Bottom Right', 'revslider'); ?></label>
											<input class="rs-small-input" type="text" name="rs-border-radius-bottom-right" value="1"></td>
											<label><?php _e('Bottom Left', 'revslider'); ?></label>
											<input class="rs-small-input" type="text" name="rs-border-radius-bottom-left" value="1"></td>
											<span class="tp-clearfix"></span>
											<a href="javascript:void(0);" id="rs-add-css-border-radius" class="button-primary revblue" original-title=""><?php _e('Add', 'revslider'); ?></a>
										</div>
									</li>
									<li data-call="border"><span class="libtn"><?php _e('Border', 'revslider'); ?><span class="more-values-available"></span></span>
										<div style="display: none;" class="rs-element-add rs-element-add-border">
											<label><?php _e('Top', 'revslider'); ?></label>
											<input class="rs-small-input" type="text" name="rs-border-top" value="1">
											<label><?php _e('Right', 'revslider'); ?></label>
											<input class="rs-small-input" type="text" name="rs-border-right" value="1">
											<label><?php _e('Bottom', 'revslider'); ?></label>
											<input class="rs-small-input" type="text" name="rs-border-bottom" value="1">
											<label><?php _e('Left', 'revslider'); ?></label>
											<input class="rs-small-input" type="text" name="rs-border-left" value="1">
											<label><?php _e('Opacity', 'revslider'); ?></label>
											<input class="rs-small-input" type="text" name="rs-border-opacity" value="100">
											<span class="tp-clearfix"></span>														
											<input type="text" name="rs-border-color" class="my-color-field" value="#000000">
											<span class="tp-clearfix"></span>																				
											<a href="javascript:void(0);" id="rs-add-css-border" class="button-primary revblue" original-title=""><?php _e('Add', 'revslider'); ?></a>
										</div>
									</li>
									<li data-call="text_shadow"><span class="libtn"><?php _e('Text-Shadow', 'revslider'); ?><span class="more-values-available"></span></span>
										<div style="display: none;" class="rs-element-add rs-element-add-text-shadow">
											<label><?php _e('Angle', 'revslider'); ?></label>
											<input class="rs-small-input" type="text" name="rs-text-shadow-angle" value="0">
											<label><?php _e('Distance', 'revslider'); ?></label>
											<input class="rs-small-input" type="text" name="rs-text-shadow-distance" value="0">
											<label><?php _e('Blur', 'revslider'); ?></label>
											<input class="rs-small-input" type="text" name="rs-text-shadow-blur" value="0">
											<label><?php _e('Opacity', 'revslider'); ?></label>
											<input class="rs-small-input" type="text" name="rs-text-shadow-opacity" value="100">
											<span class="tp-clearfix"></span>
											<input type="text" name="rs-text-shadow-color" class="my-color-field" value="#000000">
											<span class="tp-clearfix"></span>										
											<a href="javascript:void(0);" id="rs-add-css-text-shadow" class="button-primary revblue" original-title=""><?php _e('Add', 'revslider'); ?></a>
										</div>
									</li>
									<li data-call="box_shadow"><span class="libtn"><?php _e('Box-Shadow', 'revslider'); ?><span class="more-values-available"></span></span>
										<div style="display: none;" class="rs-element-add rs-element-add-box-shadow">
											<label><?php _e('Angle', 'revslider'); ?></label>
											<input class="rs-small-input" type="text" name="rs-box-shadow-angle" value="0">
											<label><?php _e('Distance', 'revslider'); ?></label>
											<input class="rs-small-input" type="text" name="rs-box-shadow-distance" value="0">
											<label><?php _e('Blur', 'revslider'); ?></label>
											<input class="rs-small-input" type="text" name="rs-box-shadow-blur" value="0">										
											<label><?php _e('Opacity', 'revslider'); ?></label>																				
											<input class="rs-small-input" type="text" name="rs-box-shadow-opacity" value="100">
											<span class="tp-clearfix"></span>
											<input type="text" name="rs-box-shadow-color" class="my-color-field" value="#000000">
											<span class="tp-clearfix"></span>										
											<a href="javascript:void(0);" id="rs-add-css-box-shadow" class="button-primary revblue" original-title=""><?php _e('Add', 'revslider'); ?></a>
										</div>
									</li>
									<li data-call="font_families"><span class="libtn"><?php _e('Font Family', 'revslider'); ?><span class="more-values-available"></span></span>
										<div style="display: none;" class="rs-element-add rs-element-add-box-shadow">
											<select name="rs-font-family" style="width: 160px">
												<?php
												foreach($font_families as $handle => $name){
													if($name['label'] == 'Dont Show Me') continue;
													?>
													<option value="<?php echo esc_attr($name['label']); ?>"><?php echo esc_attr($name['label']); ?></option>
													<?php
												}
												?>
											</select>
											<a href="javascript:void(0);" id="rs-add-css-font-family" class="button-primary revblue" original-title=""><?php _e('Add', 'revslider'); ?></a>
										</div>
									</li>
								</ul>								
							</div>
							<div class="helper-wrappers">
								<!--<h4><span class="libtn"><?php _e('Resets', 'revslider'); ?><span class="more-values-available"></span></span></h4>
								<ul class="rs-element-list collapsable" style="display:none">
									<li id="reset-css-arrow" data-call="arrows_css"><span class="libtn"><?php _e('Classes & Style', 'revslider'); ?><span class="more-values-available resetme"></span></span></li>
									<li id="reset-css-arrow-empty" data-call="arrows_css_empty"><span class="libtn"><?php _e('Only Classes', 'revslider'); ?><span class="more-values-available resetme"></span></span></li>
									<li id="reset-css-bullets" data-call="bullets_css"><span class="libtn"><?php _e('Classes & Style', 'revslider'); ?><span class="more-values-available resetme"></span></span></li>
									<li id="reset-css-bullets-empty" data-call="bullets_css_empty"><span class="libtn"><?php _e('Only Classes', 'revslider'); ?><span class="more-values-available resetme"></span></span></li>
									<li id="reset-css-thumbs" data-call="thumbs_css"><span class="libtn"><?php _e('Classes & Style', 'revslider'); ?><span class="more-values-available resetme"></span></span></li>
									<li id="reset-css-thumbs-empty" data-call="thumbs_css_empty"><span class="libtn"><?php _e('Only Classes', 'revslider'); ?><span class="more-values-available resetme"></span></span></li>
									<li id="reset-css-tabs" data-call="tabs_css"><span class="libtn"><?php _e('Classes & Style', 'revslider'); ?><span class="more-values-available resetme"></span></span></li>
									<li id="reset-css-tabs-empty" data-call="tabs_css_empty"><span class="libtn"><?php _e('Only Classes', 'revslider'); ?><span class="more-values-available resetme"></span></span></li>
								</ul>-->		
							</div>
							<div class="helper-wrappers">
								<h4><span class="libtn"><?php _e('Dynamic Values', 'revslider'); ?><span class="more-values-available"></span></span></h4>
								<ul class="rs-element-list collapsable" id="rs-placeholder-container" style="display:none">
									<li class="rs-always-stay">
										<div class="rs-element-add rs-element-add-placeholder">
											<a href="javascript:void(0);" id="rs-add-placeholder" class="button-primary revblue" original-title=""><?php _e('Add', 'revslider'); ?></a>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<div class="showhidehelper"></div>
					</div>
					<textarea name="rs-cm-css" id="rs-cm-css"></textarea>
				</div>
			</div>
			<div class="rs-editing-preview-wrap">
				<div class="rs-editing-preview-overlay"></div>
				<div class="rs-arrows-preview">
					<div class="tp-arrows tp-leftarrow"></div>
					<div class="tp-arrows tp-rightarrow"></div>
				</div>
				<div class="rs-bullets-preview"></div>
				<div class="rs-thumbs-preview"></div>
				<div class="rs-tabs-preview"></div>
				<input id="rs-preview-color-changer" type="text" name="rs-preview-color" class="bg-color-field" value="#000000">
				<span class="little-info"><?php _e('Live Preview - Hover & Click for test', 'revslider'); ?></span>
				<span class="little-sizes">
					<?php _e('Suggested Width:', 'revslider'); ?>
					<input class="rs-small-input" type="text" name="rs-test-width" value="160" style="width:45px !important; margin-right:15px;">
					<?php _e('Suggested Height:', 'revslider'); ?>
					<input class="rs-small-input" type="text" name="rs-test-height" value="160" style="width:45px !important;">
				</span>
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>

	<div id="preview-nav-wrapper">
		<div class="rs-editing-preview-overlay"></div>
		<div class="rs-arrows-preview">
			<div class="tp-arrows tp-leftarrow"></div>
			<div class="tp-arrows tp-rightarrow"></div>
		</div>
		<div class="rs-bullets-preview"></div>
		<div class="rs-thumbs-preview"></div>
		<div class="rs-tabs-preview"></div>
	</div>
	
	<!--a class="button-primary revgreen" id="rs-save-navigation-style" href="javascript:void(0);"><i class="rs-icon-save-light"></i><?php _e('Save All Changes','revslider'); ?></a-->
	
	
	<script type="text/javascript">
		var rs_navigations = jQuery.parseJSON(<?php echo RevSliderFunctions::jsonEncodeForClientSide($navigs); ?>) || new Array();

		jQuery(document).ready(function(){
			var rs_current_editing = false;
			var cur_edit_type = false;
			var latest_nav_id = 0;
			var global_navigation_template = wp.template( "rs-navigation-wrap" );
			var global_navigation_template_header = wp.template( "rs-navigation-header-wrap" );
			
			rs_add_all_navigation_entries();
			
			function rs_add_navigation_header(title, type){
				var data = { title: title, type: type };
				
				var content = global_navigation_template_header(data);
				jQuery('.rs-nav-table.tablecontent').append(content);
			}
			
			function rs_add_navigation_element(nav_values, is_new){
				var data = {
					'name': 		nav_values['name'],
					'id':			nav_values['id'],
					'show-arrows':	'none',
					'hide-arrows':	'block',
					'show-bullets':	'none',
					'hide-bullets':	'block',
					'show-thumbs':	'none',
					'hide-thumbs':	'block',
					'show-tabs':	'none',
					'hide-tabs':	'block'
				};
				
				if(typeof(nav_values['css']) !== 'undefined' && nav_values['css'] !== null){
					if(typeof(nav_values['css']['arrows']) !== 'undefined' && nav_values['css']['arrows'] !== null){
						data['hide-arrows'] = 'none';
						data['show-arrows'] = 'block';
					}
					if(typeof(nav_values['css']['bullets']) !== 'undefined' && nav_values['css']['bullets'] !== null){
						data['hide-bullets'] = 'none';
						data['show-bullets'] = 'block';
					}
					if(typeof(nav_values['css']['thumbs']) !== 'undefined' && nav_values['css']['thumbs'] !== null){
						data['hide-thumbs'] = 'none';
						data['show-thumbs'] = 'block';
					}
					if(typeof(nav_values['css']['tabs']) !== 'undefined' && nav_values['css']['tabs'] !== null){
						data['hide-tabs'] = 'none';
						data['show-tabs'] = 'block';
					}
				}
				
				data['has-original'] = false;
				if(typeof(nav_values['settings']) !== 'undefined' && typeof(nav_values['settings']['original']) !== 'undefined'){
					data['has-original'] = true;
				}
				
				data['edit'] = (typeof(nav_values['default']) !== 'undefined' && nav_values['default'] == true) ? false : true;
				data['show_text'] = (typeof(nav_values['default']) !== 'undefined' && nav_values['default'] == true) ? '<?php _e('View', 'revslider'); ?>' : '<?php _e('Edit', 'revslider'); ?>';
				
				var content = global_navigation_template(data);
				
				if(is_new){
					jQuery('.rs-default-t-wrap').before(content);
				}else{
					jQuery('.rs-nav-table.tablecontent').append(content);
				}
				
			}
			
			
			var rs_nav_placeholder = {
				arrows: '<div class="tp-arr-allwrapper">'+"\n\t"+'<div class="tp-arr-iwrapper">'+"\n\t\t"+'<div class="tp-arr-imgholder"></div>'+"\n\t\t"+'<div class="tp-arr-titleholder"></div>'+"\n\t\t"+'<div class="tp-arr-subtitleholder"></div>'+"\n\t"+'</div>'+"\n"+'</div>',
				bullets: '<span class="tp-bullet-image"></span>'+"\n"+'<span class="tp-bullet-title"></span>',
				thumbs: '<span class="tp-thumb-image"></span><span class="tp-thumb-title"></span>',
				tabs: '<span class="tp-tab-image"></span><span class="tp-tab-title"></span>'
			};

			var rs_css_placeholder = {
				arrows: '.{{class}}.tparrows {'+"\n\t"+'cursor:pointer;'+"\n\t"+'background:#000;'+"\n\t"+'background:rgba(0,0,0,0.5);'+"\n\t"+'width:40px;'+"\n\t"+'height:40px;'+"\n\t"+'position:absolute;'+"\n\t"+'display:block;'+"\n\t"+'z-index:100;'+"\n"+'}'+"\n"+
						'.{{class}}.tparrows:hover {'+"\n\t"+'background:#000;'+"\n"+'}'+"\n"+
						'.{{class}}.tparrows:before {'+"\n\t"+'font-family: "revicons";'+"\n\t"+'font-size:15px;'+"\n\t"+'color:#fff;'+"\n\t"+'display:block;'+"\n\t"+'line-height: 40px;'+"\n\t"+'text-align: center;'+"\n"+'}'+"\n"+
						'.{{class}}.tparrows.tp-leftarrow:before {'+"\n\t"+'content: "\\e824";'+"\n"+'}'+"\n"+
						'.{{class}}.tparrows.tp-rightarrow:before {'+"\n\t"+'content: "\\e825";'+"\n"+'}'+"\n"+
						'.{{class}} .tp-arr-allwrapper {'+"\n"+'}'+"\n"+
						'.{{class}} .tp-arr-iwrapper {'+"\n"+'}'+"\n"+
						'.{{class}} .tp-arr-imgholder {'+"\n"+'}'+"\n"+
						'.{{class}} .tp-arr-titleholder {'+"\n"+'}'+"\n"+
						'.{{class}} .tp-arr-subtitleholder {'+"\n"+'}'+"\n",
				arrows_empty:'.{{class}}.tparrows {'+"\n"+'}'+"\n"+
						'.{{class}}.tparrows:hover {'+"\n"+'}'+"\n"+
						'.{{class}}.tparrows:before {'+"\n"+'}'+"\n"+
						'.{{class}}.tparrows.tp-leftarrow:before {'+"\n"+'}'+"\n"+
						'.{{class}}.tparrows.tp-rightarrow:before {'+"\n"+'}'+"\n"+
						'.{{class}} .tp-arr-allwrapper {'+"\n"+'}'+"\n"+
						'.{{class}} .tp-arr-iwrapper {'+"\n"+'}'+"\n"+
						'.{{class}} .tp-arr-imgholder {'+"\n"+'}'+"\n"+
						'.{{class}} .tp-arr-titleholder {'+"\n"+'}'+"\n"+
						'.{{class}} .tp-arr-subtitleholder {'+"\n"+'}'+"\n",


				bullets:'.{{class}}.tp-bullets {'+"\n"+'}'+"\n"+
						'.{{class}}.tp-bullets:before {'+"\n\t"+'content:" ";'+"\n\t"+'position:absolute;'+"\n\t"+'width:100%;'+"\n\t"+'height:100%;'+"\n\t"+'background:#fff;'+"\n\t"+'padding:10px;'+"\n\t"+'margin-left:-10px;margin-top:-10px;'+"\n\t"+'box-sizing:content-box;'+"\n"+'}'+"\n"+
						'.{{class}} .tp-bullet {'+"\n\t"+'width:12px;'+"\n\t"+'height:12px;'+"\n\t"+'position:absolute;'+"\n\t"+'background:#aaa;'+"\n\t"+'border:3px solid #e5e5e5;'+"\n\t"+'border-radius:50%;'+"\n\t"+'cursor: pointer;'+"\n\t"+'box-sizing:content-box;'+"\n"+'}'+"\n"+
						'.{{class}} .tp-bullet:hover,'+"\n"+
						'.{{class}} .tp-bullet.selected {'+"\n\t"+'background:#666;'+"\n"+'}'+"\n"+
						'.{{class}} .tp-bullet-image {'+"\n"+'}'+"\n"+
						'.{{class}} .tp-bullet-title {'+"\n"+'}'+"\n",	
				bullets_empty:'.{{class}}.tp-bullets {'+"\n"+'}'+"\n"+
						'.{{class}} .tp-bullet {'+"\n"+'}'+"\n"+
						'.{{class}} .tp-bullet:hover,'+"\n"+
						'.{{class}} .tp-bullet.selected {'+"\n"+'}'+"\n"+
						'.{{class}} .tp-bullet-image {'+"\n"+'}'+"\n"+
						'.{{class}} .tp-bullet-title {'+"\n"+'}'+"\n",						


				thumbs:'',
				tabs:''
			}

			
			
			var rs_cm_markup_editor = CodeMirror.fromTextArea(document.getElementById("rs-cm-markup"), {
				lineNumbers: true,
				smartIndent:false,
				//lineWrapping:true,
				mode: 'text/html',
				onChange: function(){ rs_cm_modified('markup', rs_cm_markup_editor); drawEditor();},
				onCursorActivity: function() {
				    rs_cm_markup_editor.setLineClass(hlLineM, null, null);
				    hlLineM = rs_cm_markup_editor.setLineClass(rs_cm_markup_editor.getCursor().line, null, "activeline");
  					rs_cm_markup_editor.matchHighlight("CodeMirror-matchhighlight");
				  }


			});
			rs_cm_markup_editor.setSize(null, 600);
			
			var rs_cm_css_editor = CodeMirror.fromTextArea(document.getElementById("rs-cm-css"), {
				lineNumbers: true,
				smartIndent:false,
				//lineWrapping:true,
				mode: 'css',
				onChange: function(){ rs_cm_modified('css', rs_cm_css_editor);drawEditor(); },
				onCursorActivity: function() {
				    rs_cm_css_editor.setLineClass(hlLineC, null, null);
				    hlLineC = rs_cm_css_editor.setLineClass(rs_cm_css_editor.getCursor().line, null, "activeline");
				    rs_cm_css_editor.matchHighlight("CodeMirror-matchhighlight");
				  }
			});


			var hlLineM = rs_cm_markup_editor.setLineClass(0, "activeline"),
				hlLineC = rs_cm_css_editor.setLineClass(0, "activeline");				

			
			//----------------------------------------------------
			// 		DRAW PREVIEW OF NAVIGATION ELEMENTS
			//----------------------------------------------------
			var previewNav = function(sbut,mclass,the_css,the_markup,settings, cur_edit_type) {
				the_css = replace_placeholder_in_css(the_css, mclass, cur_edit_type);
				
				var ap = jQuery('#preview-nav-wrapper .rs-arrows-preview'),
					bp = jQuery('#preview-nav-wrapper .rs-bullets-preview'),
					tabp = jQuery('#preview-nav-wrapper .rs-tabs-preview'),
					thumbp = jQuery('#preview-nav-wrapper .rs-thumbs-preview'),
					sizer = jQuery('#preview-nav-wrapper .little-sizes');
					

				ap.html("");
				bp.html("");
				tabp.html("");
				thumbp.html("");
				
				ap.hide();
				bp.hide();
				tabp.hide();
				thumbp.hide();
				sizer.hide();

				

				if (sbut.hasClass("rs-nav-arrows-edit")) {
					ap.show();		
					var pattern = new RegExp(":hover",'g');			
					
					var t = '<style>'+the_css.replace(pattern,'.fakehover')+'</style>';
					t = t + '<div class="'+mclass+' tparrows tp-leftarrow">'+the_markup+'</div>';
					t = t + '<div class="'+mclass+' tparrows tp-rightarrow">'+the_markup+'</div>';					
					ap.html(t);	
					setTimeout(function() {
						try{ap.find('.tp-rightarrow').addClass("fakehover");} catch(e) {}
					},200);
					
				} else 
				if (sbut.hasClass("rs-nav-bullets-edit")) {
					bp.show();	
					var t = '<style>'+the_css+'</style>';
					t = t + '<div class="'+mclass+' tp-bullets">'
					for (var i=0;i<5;i++) {
						t = t + '<div class="tp-bullet">'+the_markup+'</div>';
					}
					t= t + '</div>';
					bp.html(t);
					var b = bp.find('.tp-bullet').first(),
						bw = b.outerWidth(true),
						bh = b.outerHeight(true),						
						mw = 0;
					bp.find('.tp-bullet').each(function(i) {
						var e = jQuery(this);
						if (i==0) 
							setTimeout(function() {
								try{e.addClass("selected");} catch(e) {}
							},150);
						
						
						var np = i*bw + i*10;
						e.css({left:np+"px"});
						mw = mw + bw + 10;
					})
					mw = mw-10;
					bp.find('.tp-bullets').css({width:mw, height:bh});					
				} else
				if (sbut.hasClass("rs-nav-tabs-edit")) {
					tabp.show();
					var t = '<style>'+the_css+'</style>';
					t = t + '<div class="'+mclass+'"><div class="tp-tab">'+the_markup+'</div></div>';
					tabp.html(t);
					var s = new Object();
					s.w = 160,
					s.h = 160;
					if (settings!="" && settings!=undefined) {							
						if (settings.width!=undefined && settings.width.tabs!=undefined)
							s.w=settings.width.tabs;
						if (settings.height!=undefined && settings.height.tabs!=undefined)
							s.h=settings.height.tabs;
					}
					tabp.find('.tp-tab').each(function(){
						jQuery(this).css({width:s.w+"px",height:s.h+"px"});
					});
					
				} else
				if (sbut.hasClass("rs-nav-thumbs-edit")) {
					thumbp.show();
					var t = '<style>'+the_css+'</style>';
					t = t + '<div class="'+mclass+'"><div class="tp-thumb">'+the_markup+'</div></div>';
					thumbp.html(t);
					var s = new Object();
					s.w = 160,
					s.h = 160;
					if (settings!="" && settings!=undefined) {							
						if (settings.width!=undefined && settings.width.thumbs!=undefined)
							s.w=settings.width.thumbs;
						if (settings.height!=undefined && settings.height.thumbs!=undefined)
							s.h=settings.height.thumbs;
					}
					thumbp.find('.tp-thumb').each(function(){
						jQuery(this).css({width:s.w+"px",height:s.h+"px"});			
					});					
				}

			}

			//----------------------------------------------------
			// 		DRAW PREVIEW OF NAVIGATION ELEMENTS
			//----------------------------------------------------
			var drawEditor = function() {

				var sline = jQuery('.rs-nav-table-row.rs-nav-entry-wrap.selected'),
					sbut = sline.find('a.selected'),
					ap = jQuery('.rs-editing-preview-wrap .rs-arrows-preview'),
					bp = jQuery('.rs-editing-preview-wrap .rs-bullets-preview'),
					tabp = jQuery('.rs-editing-preview-wrap .rs-tabs-preview'),
					thumbp = jQuery('.rs-editing-preview-wrap .rs-thumbs-preview'),
					sizer = jQuery('.rs-editing-preview-wrap .little-sizes'),
					mclass = UniteAdminRev.sanitize_input(jQuery('.rs-nav-table-row.rs-nav-entry-wrap.selected').find('input[name="navigation-name"]').val().toLowerCase());
				
				ap.html("");
				bp.html("");
				tabp.html("");
				thumbp.html("");
				
				ap.hide();
				bp.hide();
				tabp.hide();
				thumbp.hide();
				sizer.hide();

				var cur_css = rs_cm_css_editor.getValue();
				cur_css = replace_placeholder_in_css(cur_css, mclass);

				
				
				if (sbut.hasClass("rs-nav-arrows-edit")) {
					ap.show();					
					var t = '<style>'+cur_css+'</style>';
					t = t + '<div class="'+mclass+' tparrows tp-leftarrow">'+rs_cm_markup_editor.getValue()+'</div>';
					t = t + '<div class="'+mclass+' tparrows tp-rightarrow">'+rs_cm_markup_editor.getValue()+'</div>';
					ap.html(t);	
				} else 
				if (sbut.hasClass("rs-nav-bullets-edit")) {
					bp.show();	
					var t = '<style>'+cur_css+'</style>';
					t = t + '<div class="'+mclass+' tp-bullets">'
					for (var i=0;i<5;i++) {
						t = t + '<div class="tp-bullet">'+rs_cm_markup_editor.getValue()+'</div>';
					}
					t= t + '</div>';
					bp.html(t);
					var b = bp.find('.tp-bullet').first(),
						bw = b.outerWidth(true),
						bh = b.outerHeight(true),						
						mw = 0;
					bp.find('.tp-bullet').each(function(i) {
						jQuery(this).click(function() {
							bp.find('.tp-bullet').removeClass("selected");
							jQuery(this).addClass("selected");
						})
						var np = i*bw + i*10;
						jQuery(this).css({left:np+"px"});
						mw = mw + bw + 10;
					})
					mw = mw-10;
					bp.find('.tp-bullets').css({width:mw, height:bh});					
				} else
				if (sbut.hasClass("rs-nav-tabs-edit")) {
					tabp.show();
					var t = '<style>'+cur_css+'</style>';
					t = t + '<div class="'+mclass+'"><div class="tp-tab">'+rs_cm_markup_editor.getValue()+'</div></div>';
					tabp.html(t);
					changeTabThumbSize();
					sizer.show();
				} else
				if (sbut.hasClass("rs-nav-thumbs-edit")) {
					thumbp.show();
					var t = '<style>'+cur_css+'</style>';
					t = t + '<div class="'+mclass+'"><div class="tp-thumb">'+rs_cm_markup_editor.getValue()+'</div></div>';
					thumbp.html(t);
					sizer.show();
					changeTabThumbSize();					
				}

			}

			jQuery('input[name="rs-test-width"]').on("change",changeTabThumbSize);
			jQuery('input[name="rs-test-height"]').on("change",changeTabThumbSize);

			


			function changeTabThumbSize() {				
				var tabp = tabp = jQuery('.rs-tabs-preview'),
					thumbp = jQuery('.rs-thumbs-preview');
				tabp.find('.tp-tab').css({width:jQuery('input[name="rs-test-width"]').val(), height:jQuery('input[name="rs-test-height"]').val()});
				thumbp.find('.tp-thumb').css({width:jQuery('input[name="rs-test-width"]').val(), height:jQuery('input[name="rs-test-height"]').val()});
			}

			rs_cm_css_editor.setSize(null, 600);
			
			function rs_cm_modified(add_to, editor){												
				if(rs_current_editing !== false && cur_edit_type !== false){
					for(var key in rs_navigations){
						if(rs_navigations[key]['id'] == rs_current_editing){							
							rs_navigations[key][add_to][cur_edit_type] = editor.getValue();
							break;
						}
					}
				}
			}

			// COLLAPSE UL ON CLICK
			jQuery('body').on('click','.rs-editing-wrapper h4 .libtn',function() {
				var _t = jQuery(this),
					hw = _t.closest('.helper-wrappers'),
					ul = hw.find('ul.collapsable');
				
				ul.addClass("infocus");
				jQuery('.rs-editing-wrapper ul.collapsable').each(function() {
					var ul = jQuery(this),
						hw = ul.closest('.helper-wrappers');
					if (!ul.hasClass("infocus") && hw.hasClass("rea-open")) {
						ul.slideUp(100);
						hw.removeClass("rea-open")
					}
				});
				
				if (hw.hasClass("rea-open")) {
					ul.slideUp(100);
					hw.removeClass("rea-open");
				} else {
					ul.slideDown(100);
					hw.addClass("rea-open");
				}
				ul.removeClass("infocus");
			});
			
			var rs_replace = function(str, find, replace) {
				return str.replace(new RegExp(find, 'g'), replace);
			}

			
			function convertAnytoRGBorRGBA(a,c) {
				if (a==="color" || a==="color-rgba") {						
					if (c.indexOf("rgb")>=0) {
						c = c.split('(')[1].split(")")[0];
					}
					else{							
						c = UniteAdminRev.convertHexToRGB(c);
						c = c[0]+","+c[1]+","+c[2];
						
					}

					if (a==="color-rgba" && c.split(",").length<4) c = c+",1";						
					
				}
				return c;
			}
			
			
			/**
			 * Default navigations have a different handle, replace them for the preview
			 **/
			var return_true_handle = function(css_handle){
				
				var def = {
					'hesperiden': 'round',
					'gyges': 'navbar',
					'hades': 'preview1',
					'ares': 'preview2',
					'hebe': 'preview3',
					'hermes': 'preview4',
					'hephaistos': 'round-old',
					'persephone': 'square-old',
					'erinyen': 'navbar-old'
				};
				css_handle = (def[css_handle] !== undefined) ? def[css_handle] : css_handle;
				
				
				return css_handle;
			}
			
			
			var replace_placeholder_in_css = function(css, css_handle, nav_type){
				if(nav_type === undefined){
					var nav_type = rs_get_current_nav_type();
				}
				
				css_handle = return_true_handle(css_handle);
				
				for(var key in rs_navigations){
					if(rs_navigations[key]['handle'] != css_handle) continue;
					
					
					
					if(typeof(rs_navigations[key]['settings']) !== 'undefined'){
						if(rs_navigations[key]['settings']['placeholders'] == undefined) return css;
					}
					
					for(var phkey in rs_navigations[key]['settings']['placeholders']){
						if(rs_navigations[key]['settings']['placeholders'][phkey]['nav-type'] !== nav_type) continue;
						var d = rs_navigations[key]['settings']['placeholders'][phkey];
						
						switch(d['type']){
							case 'color':			

								css = rs_replace(css, '##'+d['handle']+'##', convertAnytoRGBorRGBA('color',d['data']['color']));
							break;
							case 'color-rgba':
								css = rs_replace(css, '##'+d['handle']+'##', convertAnytoRGBorRGBA('color-rgba',d['data']['color-rgba']));								
							break;
							case 'font-family':
								css = rs_replace(css, '##'+d['handle']+'##', d['data'].font_family);
							break;
							case 'custom':
								css = rs_replace(css, '##'+d['handle']+'##', d['data'].custom);
								break;
							default:
								//return false;
							break;
						}
						
					}
					
				}
				
				return css;
			}
			
			jQuery('body').on('click', '.rs-nav-arrows-edit, .rs-nav-bullets-edit, .rs-nav-thumbs-edit, .rs-nav-tabs-edit', function(){
				var nav_id = jQuery(this).closest('.rs-nav-table-row').attr('id').replace('rs-nav-table-', ''),
					edit_title = jQuery(this).closest('.rs-nav-table-row').find('input[name="navigation-name"]').val(),
					cur_edit = {};
				
				for(var key in rs_navigations){
					if(rs_navigations[key]['id'] == nav_id){
						cur_edit = jQuery.extend(true, {}, rs_navigations[key]);
						break;
					}
				}
				
				jQuery('#reset-markup-arrow').hide();				
				jQuery('#reset-markup-bullets').hide();
				jQuery('#reset-markup-tabs').hide();
				jQuery('#reset-markup-thumbs').hide();

				jQuery('#reset-css-arrow').hide();				
				jQuery('#reset-css-bullets').hide();
				jQuery('#reset-css-tabs').hide();
				jQuery('#reset-css-thumbs').hide();
				jQuery('#reset-css-arrow-empty').hide();				
				jQuery('#reset-css-bullets-empty').hide();
				jQuery('#reset-css-tabs-empty').hide();
				jQuery('#reset-css-thumbs-empty').hide();

				if(jQuery.isEmptyObject(cur_edit)) return false;
				
				
				if(jQuery(this).hasClass('rs-nav-arrows-edit')){
					edit_title += ' - ' + rev_lang.arrows;					
					cur_edit_type = 'arrows';
					jQuery('#reset-markup-arrow').show();
					jQuery('#reset-css-arrow').show();					
					jQuery('#reset-css-arrow-empty').show();					
				}else if(jQuery(this).hasClass('rs-nav-bullets-edit')){
					edit_title += ' - ' + rev_lang.bullets;
					cur_edit_type = 'bullets';
					jQuery('#reset-markup-bullets').show();
					jQuery('#reset-css-bullets').show();
					jQuery('#reset-css-bullets-empty').show();
				}else if(jQuery(this).hasClass('rs-nav-thumbs-edit')){
					edit_title += ' - ' + rev_lang.thumbnails;
					cur_edit_type = 'thumbs';
					jQuery('#reset-markup-thumbs').show();
					jQuery('#reset-css-thumbs').show();
					jQuery('#reset-css-thumbs-empty').show();
				}else if(jQuery(this).hasClass('rs-nav-tabs-edit')){
					edit_title += ' - ' + rev_lang.tabs;
					cur_edit_type = 'tabs';
					jQuery('#reset-markup-tabs').show();
					jQuery('#reset-css-tabs').show();
					jQuery('#reset-css-tabs-empty').show();
				}else{
					return false;
				}


				
				var the_css = (typeof(cur_edit['css']) !== 'undefined' && cur_edit['css'] !== null && typeof(cur_edit['css'][cur_edit_type]) !== 'undefined') ? cur_edit['css'][cur_edit_type] : '';
				var the_markup = (typeof(cur_edit['markup']) !== 'undefined' && cur_edit['markup'] !== null && typeof(cur_edit['markup'][cur_edit_type]) !== 'undefined') ? cur_edit['markup'][cur_edit_type] : rs_nav_placeholder[cur_edit_type];
				
				
				if(cur_edit['css'] == null) cur_edit['css'] = {};
				if(cur_edit['markup'] == null) cur_edit['markup'] = {};
				
				if((typeof(cur_edit['css']) == 'undefined' || typeof(cur_edit['css'][cur_edit_type]) == 'undefined') || (typeof(cur_edit['markup']) == 'undefined' || typeof(cur_edit['markup'][cur_edit_type]) == 'undefined')){
					if(typeof(cur_edit.default) !== 'undefined' && cur_edit.default == true) return false;
					
					if(!confirm(rev_lang.create_this_nav_element)){
						return false;
					}else{
						if(rs_navigations[key]['css'] == null) rs_navigations[key]['css'] = {};
						if(rs_navigations[key]['markup'] == null) rs_navigations[key]['markup'] = {};
						rs_navigations[key]['css'][cur_edit_type] = the_css;
						rs_navigations[key]['markup'][cur_edit_type] = the_markup;
						rs_navigations[key]['settings']['width'] = {"thumbs":"160","arrows":"160","bullets":"160","tabs":"160"};
						rs_navigations[key]['settings']['height'] = {"thumbs":"160","arrows":"160","bullets":"160","tabs":"160"};
						
						jQuery(this).find('.rs-edit-nav').show();
						jQuery(this).find('.rs-edit-cancel-nav').hide();
					}
				}
				
				
				jQuery('.rs-nav-table-row').removeClass('selected');
				jQuery('.rs-nav-table-row').find('*').removeClass('selected');
				
				jQuery(this).closest('.rs-nav-table-row').addClass('selected');
				jQuery(this).closest('.rs-nav-table-cell').addClass('selected');
				
				jQuery(this).addClass('selected');
				
				jQuery('.rs-editing-wrapper').show();
				jQuery('.rs-nav-editing-title').text(edit_title);
				
				rs_current_editing = nav_id;
				
				rs_cm_css_editor.setValue(the_css);
				rs_cm_markup_editor.setValue(the_markup);
				
				rs_cm_css_editor.refresh();
				rs_cm_markup_editor.refresh();
				
				cur_edit.settings = cur_edit.settings === undefined || typeof(cur_edit.settings) === 'string' ? {width: {"thumbs":"160","arrows":"160","bullets":"160","tabs":"160"}, height: {"thumbs":"160","arrows":"160","bullets":"160","tabs":"160"}} : cur_edit.settings;
				cur_edit.settings.width = cur_edit.settings.width === undefined || typeof(cur_edit.settings.width) === 'string' ? {"thumbs":"160","arrows":"160","bullets":"160","tabs":"160"} : cur_edit.settings.width;
				cur_edit.settings.height = cur_edit.settings.height === undefined || typeof(cur_edit.settings.height) === 'string' ? {"thumbs":"160","arrows":"160","bullets":"160","tabs":"160"} : cur_edit.settings.height;
				
				cur_edit.settings.width[cur_edit_type] = cur_edit.settings.width[cur_edit_type] === undefined ? "160" : cur_edit.settings.width[cur_edit_type];
				cur_edit.settings.height[cur_edit_type] = cur_edit.settings.height[cur_edit_type] === undefined ? "160" : cur_edit.settings.height[cur_edit_type];
				
				jQuery('input[name="rs-test-width"]').val(cur_edit.settings.width[cur_edit_type]);
				jQuery('input[name="rs-test-height"]').val(cur_edit.settings.height[cur_edit_type]);
				
				drawEditor();
				jQuery('.rs-markup-selector').click();
				setCMSize();
				
				if(typeof(cur_edit.default) !== 'undefined' && cur_edit.default == true){ //disable both editors
					rs_cm_css_editor.setOption("readOnly", true);
					rs_cm_markup_editor.setOption("readOnly", true);
				}else{ //enable both editors
					rs_cm_css_editor.setOption("readOnly", false);
					rs_cm_markup_editor.setOption("readOnly", false);
				}
				
				
				remove_placeholder();
				add_placeholder(cur_edit);
				
			});
			
			var remove_placeholder = function(){
				jQuery('#rs-placeholder-container li').each(function(){
					if(!jQuery(this).hasClass('rs-always-stay')){
						jQuery(this).remove();
					}
				});
			}
			
			var add_placeholder = function(cur_edit){
				//add placeholder to CSS if they exist
				if(cur_edit.settings !== undefined && cur_edit.settings.placeholders !== undefined){
					var nav_type = rs_get_current_nav_type();
					
					for(var key in cur_edit.settings.placeholders){
						
						if(cur_edit.settings.placeholders[key]['nav-type'] != nav_type) continue;
						
						//add to list
						var ph_title = '';
						switch(cur_edit.settings.placeholders[key]['type']){
							case 'color':
								ph_title = '<?php _e('Color', 'revslider'); ?>';
							break;
							case 'color-rgba':
								ph_title = '<?php _e('Color-RGBA', 'revslider'); ?>';
							break;
							case 'font-family':
								ph_title = '<?php _e('Font Family', 'revslider'); ?>';
							break;
							case 'custom':
								ph_title = '<?php _e('Custom', 'revslider'); ?>';
							break;
							default:
								continue;
							break;
						}
						
						jQuery('#rs-placeholder-container').prepend('<li data-placeholder="##'+cur_edit.settings.placeholders[key]['handle']+'##"><span class="rs-placeholder-title">'+cur_edit.settings.placeholders[key]['title']+'</span><a href="javascript:void(0);" class="rs-add-placeholder"><i class="eg-icon-plus"></i></a><a href="javascript:void(0);" class="rs-edit-placeholder"><i class="eg-icon-cog"></i></a><a href="javascript:void(0);" class="rs-remove-placeholder"><i class="eg-icon-trash"></i></a></li>');
					}
				}
			}
			
			
			jQuery('body').on('click', '.rs-edit-placeholder', function(){
				var placeholder = jQuery(this).closest('li').data('placeholder').replace(/#/g, '');
				var cur_id = rs_nav_get_selected_id();
				var nav_type = rs_get_current_nav_type();
				
				for(var key in rs_navigations){
					if(rs_navigations[key]['id'] != cur_id) continue;
					
					if(typeof(rs_navigations[key]['settings']) !== 'undefined'){
						if(rs_navigations[key]['settings']['placeholders'] == undefined) rs_navigations[key]['settings']['placeholders'] = [];
					}
					
					for(var phkey in rs_navigations[key]['settings']['placeholders']){
						if(rs_navigations[key]['settings']['placeholders'][phkey]['nav-type'] !== nav_type) continue;
						
						if(rs_navigations[key]['settings']['placeholders'][phkey]['handle'] == placeholder){
							
							rs_open_placeholder_dialog(rs_navigations[key]['settings']['placeholders'][phkey], phkey, key);
							
							return true;
						}
					}
					
				}
				
				alert('<?php _e('Entry not found', 'revslider'); ?>');
			});
			
			
			jQuery('body').on('click', '.rs-remove-placeholder', function(){
				if(confirm('<?php _e('Delete this Placeholder?', 'revslider'); ?>')){
					var placeholder = jQuery(this).closest('li').data('placeholder').replace(/#/g, '');
					var cur_id = rs_nav_get_selected_id();
					var nav_type = rs_get_current_nav_type();
					
					for(var key in rs_navigations){
						if(rs_navigations[key]['id'] != cur_id) continue;
						
						if(typeof(rs_navigations[key]['settings']) !== 'undefined'){
							if(rs_navigations[key]['settings']['placeholders'] == undefined) rs_navigations[key]['settings']['placeholders'] = [];
						}
						for(var phkey in rs_navigations[key]['settings']['placeholders']){
							
							if(rs_navigations[key]['settings']['placeholders'][phkey]['nav-type'] !== nav_type) continue;
							
							if(rs_navigations[key]['settings']['placeholders'][phkey]['handle'] == placeholder){
								delete(rs_navigations[key]['settings']['placeholders'][phkey]);
								
								remove_placeholder();
								add_placeholder(rs_navigations[key]);
				
								return true;
							}
						}
						
					}
					
					alert('<?php _e('Could not delete, entry not found', 'revslider'); ?>');
				}
			});
			
			jQuery('body').on('click', '#rs-placeholder-container li .rs-add-placeholder', function(){
				if(rs_check_if_default_nav()) return false;
				if(jQuery(this).closest('li').data('placeholder') == undefined) return false;
				
				var css = jQuery(this).closest('li').data('placeholder');
				
				rs_cm_css_editor.replaceSelection(css+"\n","end");
			});


			// SHOW ELEMENT ON HOVER
			jQuery('body').on('mouseenter', '.rs-nav-arrows-edit, .rs-nav-bullets-edit, .rs-nav-thumbs-edit, .rs-nav-tabs-edit', function(){
				var e = jQuery(this),
					nav_id = e.closest('.rs-nav-table-row').attr('id').replace('rs-nav-table-', ''),
					edit_title = e.closest('.rs-nav-table-row').find('input[name="navigation-name"]').val(),
					cur_edit = {};
					
				for(var key in rs_navigations){
					if(rs_navigations[key]['id'] == nav_id){
						cur_edit = jQuery.extend(true, {}, rs_navigations[key]);
						break;
					}
				}
				var cur_edit_type="";

				if(e.hasClass('rs-nav-arrows-edit')){					
					cur_edit_type = 'arrows';					
				}else if(e.hasClass('rs-nav-bullets-edit')){
					cur_edit_type = 'bullets';					
				}else if(e.hasClass('rs-nav-thumbs-edit')){					
					cur_edit_type = 'thumbs';					
				}else if(e.hasClass('rs-nav-tabs-edit')){					
					cur_edit_type = 'tabs';					
				}else{
					return false;
				}
				
				var the_css = (typeof(cur_edit['css']) !== 'undefined' && cur_edit['css'] !== null && typeof(cur_edit['css'][cur_edit_type]) !== 'undefined') ? cur_edit['css'][cur_edit_type] : '',
					the_markup = (typeof(cur_edit['markup']) !== 'undefined' && cur_edit['markup'] !== null && typeof(cur_edit['markup'][cur_edit_type]) !== 'undefined') ? cur_edit['markup'][cur_edit_type] : rs_nav_placeholder[cur_edit_type],
					sline = e.closest('.rs-nav-table-row.rs-nav-entry-wrap'),
					settings = (typeof(cur_edit['settings']) !== 'undefined' && cur_edit['settings'] !== null) ? cur_edit['settings'] : "",				
					mclass = UniteAdminRev.sanitize_input(sline.find('input[name="navigation-name"]').val().toLowerCase());
				
				if(cur_edit['css'] == null) return false;
				if(cur_edit['markup'] == null) return false;

				previewNav(e,mclass,the_css,the_markup,settings, cur_edit_type);
				var pos = e.offset(),
					pp =jQuery('#viewWrapper').offset(),
					ll = pos.left-pp.left,
					tt = pos.top-pp.top+65;
				punchgs.TweenLite.set(jQuery('#preview-nav-wrapper'),{top:tt,left:ll,autoAlpha:1,overwrite:"all"});
				
			});
			jQuery('body').on('mouseleave', '.rs-nav-arrows-edit, .rs-nav-bullets-edit, .rs-nav-thumbs-edit, .rs-nav-tabs-edit', function(e){
				punchgs.TweenLite.set(jQuery('#preview-nav-wrapper'),{autoAlpha:0});
			});
			
			
			jQuery('.rs-markup-selector').click(function(){
				jQuery('.rs-markup-wrapper').show();
				jQuery('.rs-css-wrapper').hide();
				jQuery(this).addClass('open');
				jQuery('.rs-css-selector').removeClass('open');
				rs_cm_markup_editor.refresh();
				setCMSize();
			});
			
			jQuery('.rs-css-selector').click(function(){
				jQuery('.rs-css-wrapper').show();
				jQuery('.rs-markup-wrapper').hide();
				jQuery(this).addClass('open');
				jQuery('.rs-markup-selector').removeClass('open');
				rs_cm_css_editor.refresh();
				setCMSize();
			});
			
			
			jQuery('.rs-element-list li .libtn').click(function(){
				
				if(rs_check_if_default_nav()) return false;
				
				var li = jQuery(this).parent(),
					call = li.data('call'),
					ins = li.data('insert'),
					edit_title = UniteAdminRev.sanitize_input(jQuery('.rs-nav-table-row.rs-nav-entry-wrap.selected').find('input[name="navigation-name"]').val().toLowerCase());



				if (call!=='params_markup' && call!=='params_special')
					jQuery('.rs-element-add').slideUp(100);
				//rs_cm_markup_editor.replaceSelection(rs_nav_placeholder['arrows'],"end");

				if (call==='arrows_markup')
					rs_cm_markup_editor.setValue(rs_nav_placeholder['arrows']);
				else
				if (call==='bullets_markup') 
					rs_cm_markup_editor.setValue(rs_nav_placeholder['bullets']);
				else
				if (call==='thumbs_markup')
					rs_cm_markup_editor.setValue(rs_nav_placeholder['thumbs']);
				else
				if (call==='tabs_markup')
					rs_cm_markup_editor.setValue(rs_nav_placeholder['tabs']);
				else
				if (call==='arrows_css') 
					rs_cm_css_editor.setValue(rs_css_placeholder['arrows'].replace(/\{\{class\}\}/g,edit_title).toLowerCase());
				else
				if (call==='arrows_css_empty') 
					rs_cm_css_editor.setValue(rs_css_placeholder['arrows_empty'].replace(/\{\{class\}\}/g,edit_title).toLowerCase());
				else
				if (call==='bullets_css') 
					rs_cm_css_editor.setValue(rs_css_placeholder['bullets'].replace(/\{\{class\}\}/g,edit_title).toLowerCase());
				else
				if (call==='bullets_css_empty') 
					rs_cm_css_editor.setValue(rs_css_placeholder['bullets_empty'].replace(/\{\{class\}\}/g,edit_title).toLowerCase());
				
				else
				if (call==='params_markup')
					rs_cm_markup_editor.replaceSelection('{{param'+li.data('paramid')+'}}',"end");
				else
				if (call==='params_special')
					rs_cm_markup_editor.replaceSelection('{{'+li.data('paramid')+'}}',"end");
				else {										
						var add = false;
						if (!li.hasClass("rea-open")) {
							li.find('.rs-element-add').slideDown(100);
							add = true;
						} 
						jQuery('.rs-element-list li').removeClass("rea-open");
						if (add) li.addClass("rea-open");
				}
				
			});


			
			
			jQuery('.my-color-field').alphaColorPicker({palettes:true});
			jQuery('.bg-color-field').alphaColorPicker({
				palettes:true,
				change:function() {
					jQuery('.rs-editing-preview-overlay').css({backgroundColor:jQuery('#rs-preview-color-changer').val()})		
				}
			});
			
			jQuery('input[name="rs-test-width"], input[name="rs-test-height"]').change(function(){
				if(rs_check_if_default_nav()) return false;
				
				if(rs_current_editing !== false && cur_edit_type !== false){
					for(var key in rs_navigations){
						if(rs_navigations[key]['id'] == rs_current_editing){
							if(typeof(rs_navigations[key]['settings']) == 'undefined' || typeof(rs_navigations[key]['settings']) == 'string') rs_navigations[key]['settings'] = {};
							rs_navigations[key]['settings'] = rs_navigations[key]['settings'] === undefined || typeof(rs_navigations[key]['settings']) === 'string' ? {width: {"thumbs":"160","arrows":"160","bullets":"160","tabs":"160"}, height: {"thumbs":"160","arrows":"160","bullets":"160","tabs":"160"}} : rs_navigations[key]['settings'];
							
							rs_navigations[key]['settings'].width = rs_navigations[key]['settings'].width === undefined || typeof(rs_navigations[key]['settings'].width) === 'string' ? {"thumbs":"160","arrows":"160","bullets":"160","tabs":"160"} : rs_navigations[key]['settings'].width;
							rs_navigations[key]['settings'].height = rs_navigations[key]['settings'].height === undefined || typeof(rs_navigations[key]['settings'].height) === 'string' ? {"thumbs":"160","arrows":"160","bullets":"160","tabs":"160"} : rs_navigations[key]['settings'].height;
							
							rs_navigations[key]['settings']['height'][cur_edit_type] = parseInt(jQuery('input[name="rs-test-height"]').val());
							rs_navigations[key]['settings']['width'][cur_edit_type] = parseInt(jQuery('input[name="rs-test-width"]').val());
							break;
						}
					}
				}
			});
			
			jQuery('#rs-save-navigation-style').click(function(){
				
				var marr = [];
				
				for(var key in rs_navigations){
					if(rs_navigations[key].default !== true) marr.push(rs_navigations[key]);
				}
				UniteAdminRev.ajaxRequest('change_navigations', marr, function(data){
					var cur_id = rs_nav_get_selected_id();
					if(cur_id !== false)
						var cur_type = rs_nav_get_selected_nav_type(cur_id);
					
					if(data.success == true){
						rs_navigations = data.navs;
				
						//rebuild all entries
						jQuery('.rs-nav-entry-wrap').remove();
						
						latest_nav_id = 0;
						
						rs_add_all_navigation_entries();
					}
					
					rs_nav_unselect_all();
					
					if(cur_id !== false)
						rs_nav_select_by_id(cur_id, cur_type);
				});
			});
			
			
			jQuery('body').on('click', '.rs-nav-reset', function(){
				if(confirm(rev_lang.this_will_reset_navigation)){
					var nav_id = jQuery(this).closest('.rs-nav-table-row').attr('id').replace('rs-nav-table-', '');
					for(var key in rs_navigations){
						if(rs_navigations[key]['id'] != nav_id) continue;
						
						if(typeof(rs_navigations[key]['settings']) !== 'undefined' && typeof(rs_navigations[key]['settings']['original']) !== 'undefined'){
							rs_navigations[key]['css'] = {};
							if(typeof(rs_navigations[key]['settings']['original']['css']) !== 'undefined'){
								for(var ckey in rs_navigations[key]['settings']['original']['css']){
									rs_navigations[key]['css'][ckey] = rs_navigations[key]['settings']['original']['css'][ckey];
								}
							}
							
							rs_navigations[key]['markup'] = {};
							if(typeof(rs_navigations[key]['settings']['original']['markup']) !== 'undefined'){
								for(var ckey in rs_navigations[key]['settings']['original']['markup']){
									rs_navigations[key]['markup'][ckey] = rs_navigations[key]['settings']['original']['markup'][ckey];
								}
							}
						}
					}
					
					//refresh all elements in editor
					var cur_id = rs_nav_get_selected_id();
					if(cur_id !== false)
						var cur_type = rs_nav_get_selected_nav_type(cur_id);
			
					jQuery('.rs-nav-entry-wrap').remove();
					latest_nav_id = 0;
					
					rs_add_all_navigation_entries();
					
					rs_nav_unselect_all();
					
					if(cur_id !== false)
						rs_nav_select_by_id(cur_id, cur_type);
				}
			});
			
			
			jQuery('body').on('click', '.rs-nav-delete', function(){
				var nav_id = jQuery(this).closest('.rs-nav-table-row').attr('id').replace('rs-nav-table-', '');
				if(confirm(rev_lang.delete_navigation)){
					
					for(var key in rs_navigations){
						if(rs_navigations[key]['id'] != nav_id) continue;

						if(typeof(rs_navigations[key]['new']) !== 'undefined' && rs_navigations[key]['new'] == true){
							delete rs_navigations[key];
							
							jQuery('#rs-nav-table-'+nav_id).remove();
							
							rs_nav_unselect_all();
							
							return true;
						}
					}

					UniteAdminRev.ajaxRequest('delete_navigation', nav_id, function(data){
						if(data.success == true){
							for(var key in rs_navigations){
								if(rs_navigations[key]['id'] != nav_id) continue;
								
								delete rs_navigations[key];
								break;
							}
							jQuery('#rs-nav-table-'+nav_id).remove();
							
							rs_nav_unselect_all();
						}
					});
					
				}
			});
			
			
			jQuery('body').on('click', '.rs-nav-duplicate',function(){
				var nav_id = jQuery(this).closest('.rs-nav-table-row').attr('id').replace('rs-nav-table-', '');
				
				latest_nav_id++;
				
				for(var key in rs_navigations){
					if(rs_navigations[key]['id'] == nav_id){
						var the_copy = jQuery.extend(true, the_copy, rs_navigations[key]);
						the_copy['id'] = latest_nav_id;
						the_copy['name'] += '-'+latest_nav_id;
						the_copy['handle'] += '-'+latest_nav_id;
						
						if(rs_check_if_default_nav(nav_id)){
							delete(the_copy['default']);
						}
						if(typeof(the_copy['settings']) === 'undefined' || the_copy['settings'] == '' || the_copy['settings'] == null) the_copy['settings'] = {};
						
						the_copy['settings']['original'] = {css:{},markup:{}};
						the_copy['settings']['original']['css'] = rs_navigations[key]['css'];
						
						var re = new RegExp('.'+rs_navigations[key]['name'].toLowerCase(), 'g'); //for defaults
						//var re2 = new RegExp('.'+ += '-'+latest_nav_id;, 'g'); //for custom 
						for(var t in the_copy['css']){ 
							the_copy['css'][t] = the_copy['css'][t].replace(re, '.'+the_copy['name'].toLowerCase()).toLowerCase();
							//the_copy['css'][t] = the_copy['css'][t].replace(re2, '.'+the_copy['handle'].toLowerCase()).toLowerCase();
						}
						
						the_copy['settings']['original']['markup'] = rs_navigations[key]['markup'];
						
						rs_add_navigation_element(the_copy, true);
						
						the_copy['new'] = true;
						
						rs_navigations.push(the_copy);
						
						break;
					}
				}
				
			});
			
			var updateNavName = function() {
				var inp = jQuery(".focused-navname"),
					cell = inp.closest('.rs-nav-table-row.rs-nav-entry-wrap'),
					curselected = cell.hasClass("selected"),
					updated = false,
					nav_id = inp.closest('.rs-nav-table-row').attr('id').replace('rs-nav-table-', ''),
					name = inp.val(),
					name_handle = UniteAdminRev.sanitize_input(name).toLowerCase();
				 jQuery(".focused-navname").removeClass("focused-navname")
				if(name_handle.length < 3){
					alert(rev_lang.name_too_short_sanitize_3);
					return false;
				}
				
				for(var key in rs_navigations){
					if(rs_navigations[key]['id'] == nav_id){
						updated = key;						
						continue;
					}
					if(rs_navigations[key]['name'] == name){
						alert(rev_lang.nav_name_already_exists);
						return false;
					}
				}
				
				if(updated !== false){
					var oldname = rs_navigations[updated]['handle'],
						oldname_b = rs_navigations[updated]['name'];
					rs_navigations[updated]['name'] = name;
					rs_navigations[updated]['handle'] = name_handle;
					var regex = new RegExp("\\."+oldname+"|."+oldname_b,"gi");
						

					if (curselected) {
						var el = cell.find('.selected .selected');
						el = el.hasClass('rs-nav-bullets-edit') ? "bullets" : el.hasClass('rs-nav-arrows-edit') ? "arrows" : el.hasClass('rs-nav-thumbs-edit') ? "thumbs" : el.hasClass('rs-nav-tabs-edit') ? "tabs" : "none";
						if (el!=="none") {
							rs_cm_css_editor.setValue(rs_cm_css_editor.getValue().replace(regex,"."+name_handle));
							rs_cm_markup_editor.setValue(rs_cm_markup_editor.getValue().replace(regex,"."+name_handle));
						}
					}
					
					if (rs_navigations[updated].css.arrows) rs_navigations[updated].css.arrows = rs_navigations[updated].css.arrows.replace(regex,"."+name_handle);
					if (rs_navigations[updated].markup.arrows) rs_navigations[updated].markup.arrows = rs_navigations[updated].markup.arrows.replace(regex,"."+name_handle);
				
					if (rs_navigations[updated].css.bullets) rs_navigations[updated].css.bullets = rs_navigations[updated].css.bullets.replace(regex,"."+name_handle);
					if (rs_navigations[updated].markup.bullets) rs_navigations[updated].markup.bullets = rs_navigations[updated].markup.bullets.replace(regex,"."+name_handle);
				
					if (rs_navigations[updated].css.thumbs) rs_navigations[updated].css.thumbs = rs_navigations[updated].css.thumbs.replace(regex,"."+name_handle);
					if (rs_navigations[updated].markup.thumbs) rs_navigations[updated].markup.thumbs = rs_navigations[updated].markup.thumbs.replace(regex,"."+name_handle);
				
					if (rs_navigations[updated].css.tabs) rs_navigations[updated].css.tabs = rs_navigations[updated].css.tabs.replace(regex,"."+name_handle);
					if (rs_navigations[updated].markup.tabs) rs_navigations[updated].markup.tabs = rs_navigations[updated].markup.tabs.replace(regex,"."+name_handle);
					

					jQuery(this).parent().siblings('.rs-nav-name-wrap').find('.rs-nav-name-text').text(rs_navigations[updated]['name']);				
					jQuery(this).parent().siblings('.rs-nav-name-wrap').show();
					jQuery(this).parent().hide();
				}else{
					alert(rev_lang.could_not_update_nav_name);
				}
			}
			
			jQuery('body').on('click', '.rs-nav-name-wrap', function(){
				//check if this is a default
				var nav_id = jQuery(this).closest('.rs-nav-table-row').attr('id').replace('rs-nav-table-', '');
				if(rs_check_if_default_nav(nav_id)) return false;				
				jQuery(this).siblings('.rs-nav-name-edit-wrap').show().find('input').focus();				
				jQuery(this).hide();				
			});			
			
			jQuery('body').on('click', '.rs-edit-navigation-name', updateNavName);
			jQuery('body').on('focus','input[name="navigation-name"]',function() {
				jQuery(this).addClass("focused-navname");
			});
			jQuery('body').on('blur','input[name="navigation-name"]',updateNavName);
			
			
			jQuery('body').on('click', '.rs-nav-save', function(){
				var nav_id = jQuery(this).closest('.rs-nav-table-row').attr('id').replace('rs-nav-table-', '');

				for(var key in rs_navigations){
					if(rs_navigations[key]['id'] == nav_id){
						UniteAdminRev.ajaxRequest('change_specific_navigation', rs_navigations[key], function(data){
							var cur_id = rs_nav_get_selected_id();
							if(cur_id !== false)
								var cur_type = rs_nav_get_selected_nav_type(cur_id);
							
							if(data.success == true){
								rs_navigations = data.navs;
						
								//rebuild all entries
								jQuery('.rs-nav-entry-wrap').remove();
								
								latest_nav_id = 0;
								
								rs_add_all_navigation_entries();
							}
							
							rs_nav_unselect_all();
							
							if(cur_id !== false)
								rs_nav_select_by_id(cur_id, cur_type);
						});
						break;
					}
				}
				
			});
			
			jQuery('body').on('click', '.rs-remove-nav-element', function(){
				if(rs_current_editing === false) return false;
				
				if(confirm(rev_lang.remove_nav_element)){
					for(var key in rs_navigations){
						if(rs_navigations[key]['id'] == rs_current_editing){
							delete rs_navigations[key]['css'][cur_edit_type];
							delete rs_navigations[key]['markup'][cur_edit_type];
							rs_nav_unselect_all();
							
							break;
						}
					}
				}
			});
			
			
			function rs_nav_get_selected_id(){
				var curselel = jQuery('.rs-nav-entry-wrap.selected');
				if(curselel.length == 0) return false;
				var cur_id = curselel.attr('id').replace('rs-nav-table-','');
				return cur_id;
			}
			
			function rs_nav_get_selected_nav_type(nav_id){
				var nav_el = jQuery('#rs-nav-table-'+nav_id);
				return nav_el.find('.rs-nav-table-cell.selected .selected').attr('class').replace('selected', '');
			}
			
			function rs_nav_select_by_id(nav_id, nav_type){
				var found = false;
				jQuery('#rs-nav-table-'+nav_id).find('.'+nav_type).click();
			}
			
			function rs_nav_unselect_all(){
				rs_current_editing = false;
				cur_edit_type = false;
				
				jQuery('.rs-nav-table-row').removeClass('selected');
				jQuery('.rs-nav-table-cell').each(function(){
					if(jQuery(this).hasClass('selected')){
						jQuery(this).find('.rs-edit-nav').hide();
						jQuery(this).find('.rs-edit-cancel-nav').show();
					}
					jQuery(this).removeClass('selected');
				});
				jQuery('.rs-nav-table-row').find('*').removeClass('selected');
				
				jQuery('.rs-editing-wrapper').hide();
			}
			
			
			function rs_check_if_default_nav(check_id){
				var check_for = (check_id !== undefined) ? check_id : rs_current_editing;
				
				if(check_for !== false){
					for(var key in rs_navigations){
						if(rs_navigations[key]['id'] == check_for){
							if(typeof(rs_navigations[key]['default']) !== 'undefined' && rs_navigations[key]['default'] == true) return true;
						}
					}
				}
				return false;
			}
			
			function rs_add_all_navigation_entries(){
				rs_add_navigation_header('<?php _e('Custom Navigations', 'revslider'); ?>', 'rs-custom-t-wrap');
				
				for(var i = 1; i<=2; i++){
					if(i === 2) rs_add_navigation_header('<?php _e('Default Navigations', 'revslider'); ?>', 'rs-default-t-wrap');
					
					for(var key in rs_navigations){
						if(i === 1){
							if(typeof(rs_navigations[key]['default']) !== 'undefined') continue;
						}else{
							if(typeof(rs_navigations[key]['default']) === 'undefined') continue;
						}
						
						if(parseInt(rs_navigations[key]['id']) > parseInt(latest_nav_id) && parseInt(rs_navigations[key]['id']) < 5000) latest_nav_id = parseInt(rs_navigations[key]['id']);
						
						if(typeof(rs_navigations[key]['settings']) !== 'object'){
							rs_navigations[key]['settings'] = jQuery.parseJSON(rs_navigations[key]['settings']);
						}
						if(typeof(rs_navigations[key]['settings']) == 'string' || rs_navigations[key]['settings'] == null) rs_navigations[key]['settings'] = {};
						
						rs_add_navigation_element(rs_navigations[key]);
					}
				}
			}
			
			jQuery('#rs-add-css-color').click(function(){
				if(rs_check_if_default_nav()) return false;
				
				var br_c = jQuery('input[name="rs-color"]').val();
				
				var css = 'color: '+br_c+';';
				
				rs_cm_css_editor.replaceSelection(css+"\n","end");
			});
			
			jQuery('#rs-add-css-border-radius').click(function(){
				if(rs_check_if_default_nav()) return false;
				
				var br_tl = Math.round(jQuery('input[name="rs-border-radius-top-left"]').val());
				var br_tr = Math.round(jQuery('input[name="rs-border-radius-top-right"]').val());
				var br_br = Math.round(jQuery('input[name="rs-border-radius-bottom-right"]').val());
				var br_bl = Math.round(jQuery('input[name="rs-border-radius-bottom-left"]').val());
				
				//css = '-webkit-border-radius: '+br_tl+'px '+br_tr+'px '+br_br+'px '+br_bl+'px;'+"\n";
				//css += '-moz-border-radius: '+br_tl+'px '+br_tr+'px '+br_br+'px '+br_bl+'px;'+"\n";
				var css = 'border-radius: '+br_tl+'px '+br_tr+'px '+br_br+'px '+br_bl+'px;';
				
				rs_cm_css_editor.replaceSelection(css+"\n","end");
			});
			
			jQuery('#rs-add-css-border').click(function(){
				if(rs_check_if_default_nav()) return false;
				
				var br_t = Math.round(jQuery('input[name="rs-border-top"]').val());
				var br_r = Math.round(jQuery('input[name="rs-border-right"]').val());
				var br_b = Math.round(jQuery('input[name="rs-border-bottom"]').val());
				var br_l = Math.round(jQuery('input[name="rs-border-left"]').val());
				var br_c = jQuery('input[name="rs-border-color"]').val();
				
				var css = 'border-top: solid '+br_t+'px '+br_c+';';
				css += "\n"+'border-right: solid '+br_r+'px '+br_c+';';
				css += "\n"+'border-bottom: solid '+br_b+'px '+br_c+';';
				css += "\n"+'border-left: solid '+br_l+'px '+br_c+';';
				
				rs_cm_css_editor.replaceSelection(css+"\n","end");
			});
			
			jQuery('#rs-add-css-text-shadow').click(function(){
				if(rs_check_if_default_nav()) return false;
				
				var ts_a = Math.round(jQuery('input[name="rs-text-shadow-angle"]').val());
				var ts_d = Math.round(jQuery('input[name="rs-text-shadow-distance"]').val());
				var ts_b = Math.round(jQuery('input[name="rs-text-shadow-blur"]').val());
				var ts_c = jQuery('input[name="rs-text-shadow-color"]').val();
				var ts_o = Math.round(jQuery('input[name="rs-text-shadow-opacity"]').val()) / 100;
				
				ts_c = UniteAdminRev.convertHexToRGB(ts_c);
				
				ts_a = ts_a*((Math.PI)/180);
				var x = Math.round(ts_d * Math.cos(ts_a));
				var y = Math.round(ts_d * Math.sin(ts_a));
				
				var css = 'text-shadow: '+x+'px '+y+'px '+ts_b+'px  rgba('+ts_c+', '+ts_o+');';
				
				rs_cm_css_editor.replaceSelection(css+"\n","end");
			});
			
			jQuery('#rs-add-css-box-shadow').click(function(){
				if(rs_check_if_default_nav()) return false;
				
				var bs_a = Math.round(jQuery('input[name="rs-box-shadow-angle"]').val());
				var bs_d = Math.round(jQuery('input[name="rs-box-shadow-distance"]').val());
				var bs_b = Math.round(jQuery('input[name="rs-box-shadow-blur"]').val());
				var bs_c = jQuery('input[name="rs-box-shadow-color"]').val();
				var bs_o = Math.round(jQuery('input[name="rs-box-shadow-opacity"]').val()) / 100;
				
				bs_c = UniteAdminRev.convertHexToRGB(bs_c);
				
				bs_a = bs_a*((Math.PI)/180);
				var x = Math.round(bs_d * Math.cos(bs_a));
				var y = Math.round(bs_d * Math.sin(bs_a));
				
				var css = 'box-shadow: '+x+'px '+y+'px '+bs_b+'px rgba('+bs_c+', '+bs_o+');';
				
				rs_cm_css_editor.replaceSelection(css+"\n","end");
			});
			
			jQuery('#rs-add-css-font-family').click(function(){
				if(rs_check_if_default_nav()) return false;
				
				var ff = jQuery('select[name="rs-font-family"] option:selected').val();
				var css = 'font-family: '+ff+';';
				
				rs_cm_css_editor.replaceSelection(css+"\n","end");
			});
			
			
			jQuery('#rs-add-placeholder').click(function(){
				if(rs_check_if_default_nav()) return false;

				jQuery('select[name="ph-type"] option[value="color"]').attr('selected', 'selected');
				jQuery('select[name="ph-type"]').change();
				
				rs_open_placeholder_dialog();
			});
			
			
			var rs_open_placeholder_dialog = function(entry, phkey, key){
				if(entry != undefined){
					
					switch(entry['type']){
						case 'color':
							jQuery('input[name="ph-color"]').val(entry['data'].color);
							jQuery('input[name="ph-color"]').change();
						break;
						case 'color-rgba':
							jQuery('input[name="ph-color-rgba"]').val(entry['data']['color-rgba']);
							jQuery('input[name="ph-color-rgba"]').change();
						break;
						case 'font-family':
							jQuery('select[name="ph-font-family"] option[value="'+entry['data'].font_family+'"]').attr('selected', true);
						break;
						case 'custom':
							jQuery('input[name="ph-custom"]').val(entry['data'].custom);
							break;
						default:
							alert('<?php _e('Wrong Handle', 'revslider'); ?>');
							return false;
						break;
					}
					
					jQuery('input[name="ph-id"]').val(phkey);
					jQuery('input[name="ph-handle"]').val(entry['handle']);
					jQuery('input[name="ph-title"]').val(entry['title']);
					
					jQuery('select[name="ph-type"] option[value="'+entry['type']+'"]').attr('selected', true);
					jQuery('select[name="ph-type"]').change();
					
					jQuery('select[name="ph-nav-type"] option[value="'+entry['nav-type']+'"]').attr('selected', 'selected');
					
					var btn_title = "<?php _e('Currently Editing:', 'revslider'); ?> "+entry['title'];
					
					var btn_text = '<?php _e('Update', 'revslider'); ?>';
				}else{
					//check what type we currently are
					var nav_type = rs_get_current_nav_type();
					
					var btn_title = "<?php _e('Currently Editing a New Dynamic Value', 'revslider'); ?>";
					jQuery('input[name="ph-id"]').val('NEW');
					
					jQuery('input[name="ph-handle"]').val('');
					jQuery('input[name="ph-title"]').val('');
					
					jQuery('input[name="ph-color"]').val('#000000');
					jQuery('input[name="ph-color"]').change();
					
					jQuery('input[name="ph-color-rgba"]').val('0,0,0,0');
					jQuery('input[name="ph-color-rgba"]').change();
					jQuery('select[name="ph-font-family"] option:first-child').attr('selected', true);
					jQuery('input[name="ph-custom"]').val('');
					
					jQuery('select[name="ph-nav-type"] option[value="'+nav_type+'"]').attr('selected', 'selected');
					
					var btn_text = '<?php _e('Add', 'revslider'); ?>';
				}
			
				
				jQuery('#add-placeholder-dialog').dialog({
					modal:true,
					draggable:false,
					resizable:false,
					width:600,
					height:370,
					closeOnEscape:true,
					title:btn_title,
					dialogClass:'wp-dialog',
					buttons: [ { text: btn_text, click: function() {
						var ph_title = UniteAdminRev.sanitize_input(jQuery('input[name="ph-title"]').val());
						var ph_handle = UniteAdminRev.sanitize_input(jQuery('input[name="ph-handle"]').val());
						var ph_type = jQuery('select[name="ph-type"] option:selected').val();
						var ph_nav_type = jQuery('select[name="ph-nav-type"] option:selected').val();
						
						var ph_data = {};
						
						var ph_id = jQuery('input[name="ph-id"]').val();
						
						switch(ph_type){
							case 'color':
								ph_data.color = jQuery('input[name="ph-color"]').val();
							break;
							case 'color-rgba':
								ph_data['color-rgba'] = jQuery('input[name="ph-color-rgba"]').val();
							break;
							case 'font-family':
								ph_data.font_family = jQuery('select[name="ph-font-family"] option:selected').val();
							break;
							case 'custom':
								ph_data.custom = jQuery('input[name="ph-custom"]').val();
								break;
							default:
								alert('<?php _e('Wrong Handle', 'revslider'); ?>');
								return false;
							break;
						}
						
						if(ph_handle !== '' && ph_title !== ''){
							var cur_id = rs_nav_get_selected_id();
							
							for(var key in rs_navigations){
								if(rs_navigations[key]['handle'] == ph_handle){
									alert('<?php _e('Handle already existing', 'revslider'); ?>');
									return false;
								}
							}
							for(var key in rs_navigations){
								if(rs_navigations[key]['id'] != cur_id) continue;
								
								if(typeof(rs_navigations[key]['settings']) !== 'undefined'){
									if(rs_navigations[key]['settings']['placeholders'] == undefined) rs_navigations[key]['settings']['placeholders'] = [];
								}
								
								if(ph_id == 'NEW'){
									rs_navigations[key]['settings']['placeholders'].push({'title': ph_title, 'handle': ph_handle, 'type': ph_type, 'nav-type': ph_nav_type, 'data': ph_data});
								}else{
									rs_navigations[key]['settings']['placeholders'][ph_id] = {'title': ph_title, 'handle': ph_handle, 'type': ph_type, 'nav-type': ph_nav_type, 'data': ph_data};
								}
								
								remove_placeholder();
								add_placeholder(rs_navigations[key]);
								
								jQuery(this).dialog('close');
								
								drawEditor();
								return true;
							}
							alert('<?php _e('Navigation not found', 'revslider'); ?>');
						}else{
							alert('<?php _e('Please add a valid handle/title', 'revslider'); ?>');
						}
						
					} } ],
				});
			}
			
			
			jQuery('select[name="ph-type"]').change(function(){
				var the_type = jQuery(this).val();
				jQuery(this).closest('ul').find('li').hide();
				jQuery(this).closest('li').show();
				jQuery(this).closest('ul').find('li[data-menu="'+the_type+'"]').show();
				jQuery(this).closest('ul').find('li[data-menu="always"]').show();
				jQuery(this).closest('ul').find('li[data-menu="never"]').hide();
			});
			
			
			jQuery('#rs-add-new-navigation-element').click(function(){
				latest_nav_id++;
				
				var the_copy = {};
				
				the_copy['id'] = latest_nav_id;
				the_copy['name'] = 'New-'+latest_nav_id;
				the_copy['handle'] = 'new-'+latest_nav_id;
				the_copy['settings'] = {};
				
				rs_add_navigation_element(the_copy, true);
				
				the_copy['new'] = true;
				
				rs_navigations.push(the_copy);
			});

			jQuery('#list-of-navigations').perfectScrollbar({wheelPropagation:true});
			jQuery('#list-of-navigations').perfectScrollbar('update');
			
			var rs_get_current_nav_type = function(){
				var ret = 'arrows';
				jQuery('.rs-nav-arrows-edit').each(function(){
					if(jQuery(this).hasClass('selected')){
						ret = 'arrows';
					}
				});
				jQuery('.rs-nav-bullets-edit').each(function(){
					if(jQuery(this).hasClass('selected')){
						ret = 'bullets';
					}
				});
				jQuery('.rs-nav-thumbs-edit').each(function(){
					if(jQuery(this).hasClass('selected')){
						ret = 'thumbs';
					}
				});
				jQuery('.rs-nav-tabs-edit').each(function(){
					if(jQuery(this).hasClass('selected')){
						ret = 'tabs';
					}
				});
				
				return ret;
			}

			
			var setCMSize = function() {
				var newsize = (jQuery('.rs-editing-markups-wrap').width() - jQuery('.rs-css-elements').width())-25;
				jQuery('.CodeMirror .CodeMirror-lines').css({width:newsize + "px"});
			}


			jQuery(window).resize(setCMSize);

			jQuery('.showhidehelper').click(function() {
				var elm = jQuery('.rs-markup-elements'),
					elc = jQuery('.rs-css-elements');

				if (elm.hasClass("small")) {
					elm.css({width:"auto",minWidth:"200px"});
					elc.css({width:"auto",minWidth:"200px"});
					jQuery('.closemeshowhide').show();
					jQuery('.showhidehelper').removeClass("small");
					elm.removeClass("small");
				} else {
					elm.css({width:"20px",minWidth:"20px"});
					elc.css({width:"20px",minWidth:"20px"});
					elm.addClass("small");
					jQuery('.showhidehelper').addClass("small");
					jQuery('.closemeshowhide').hide();

				}
				setCMSize();	
			});						
		});
		
		

		

		setTimeout(function() {					
	//		jQuery('#rs-nav-table-15 .rs-nav-tabs-edit').click();
		},1000)

		
		
	</script>

	
</div>

<script type="text/html" id="tmpl-rs-navigation-header-wrap">
	<div class="rs-nav-table-row rs-nav-entry-wrap rs-nav-fullrow {{ data['type'] }}">
		<div class="rs-nav-table-cell rs-nav-fullcell">{{ data['title'] }}</div>
	</div>
</script>

<script type="text/html" id="tmpl-rs-navigation-wrap">
	<div class="rs-nav-table-row rs-nav-entry-wrap" id="rs-nav-table-{{ data['id'] }}">
		<div class="rs-nav-table-cell">{{ data['id'] }}</div>
		<div class="rs-nav-table-cell" style="position: relative;">
			<span class="rs-nav-name-edit-wrap" style="display: none;"><input class="regular-text" name="navigation-name" type="text" value="{{ data['name'] }}" /> <i class="input-edit-icon rs-edit-navigation-name"></i></span>
			<span class="rs-nav-name-wrap"><span class="rs-nav-name-text">{{ data['name'] }}</span> <# if ( data.edit ) { #><i class="input-edit-icon"></i><# } #></span>
		</div>
		<div class="rs-nav-table-cell">
			<a href="javascript:void(0);" class="rs-nav-arrows-edit">
				<span class="rs-edit-nav" style="display:{{ data['show-arrows'] }}">{{ data['show_text'] }}</span>
				<i class="eg-icon-plus-circled rs-edit-cancel-nav" style="display:{{ data['hide-arrows'] }}"></i>
			</a>
		</div>
		<div class="rs-nav-table-cell">
			<a href="javascript:void(0);" class="rs-nav-bullets-edit">
				<span class="rs-edit-nav" style="display:{{ data['show-bullets'] }}">{{ data['show_text'] }}</span>
				<i class="eg-icon-plus-circled rs-edit-cancel-nav" style="display:{{ data['hide-bullets'] }}"></i>
			</a>
		</div>
		<div class="rs-nav-table-cell">
			<a href="javascript:void(0);" class="rs-nav-thumbs-edit">
				<span class="rs-edit-nav" style="display:{{ data['show-thumbs'] }}">{{ data['show_text'] }}</span>
				<i class="eg-icon-plus-circled rs-edit-cancel-nav" style="display:{{ data['hide-thumbs'] }}"></i>
			</a>
		</div>
		<div class="rs-nav-table-cell">
			<a href="javascript:void(0);" class="rs-nav-tabs-edit">
				<span class="rs-edit-nav" style="display:{{ data['show-tabs'] }}">{{ data['show_text'] }}</span>
				<i class="eg-icon-plus-circled rs-edit-cancel-nav" style="display:{{ data['hide-tabs'] }}"></i>
			</a>
		</div>
		<div class="rs-nav-table-cell"><# if ( data.edit ) { #><a href="javascript:void(0);" class="rs-nav-delete"><i class="revicon-trash"></i></a><# } #></div>
		<div class="rs-nav-table-cell"><a href="javascript:void(0);" class="rs-nav-duplicate"><i class="revicon-picture"></i></a></div>
		<!--<div class="rs-nav-table-cell"><# if ( data['has-original'] ) { #><a href="javascript:void(0);" class="rs-nav-reset"><i class="eg-icon-ccw-1"></i></a><# } #></div>-->
		<div class="rs-nav-table-cell"><# if ( data.edit ) { #><a href="javascript:void(0);" class="rs-nav-save"><i class="revicon-arrows-ccw"></i></a><# } #></div>
		<div class="rs-nav-table-cell">&nbsp;</div>
	</div>
</script>


<div id="add-placeholder-dialog" style="display: none">
	<input type="hidden" name="ph-id" value="NEW">
	<ul id="placeholder-options">
		<li data-menu="never" style="display: none;">
			<label><?php _e('On Navigation:', 'revslider'); ?></label>
			<select name="ph-nav-type">
				<option value="arrows"><?php _e('Arrows', 'revslider'); ?></option>
				<option value="bullets"><?php _e('Bullets', 'revslider'); ?></option>
				<option value="thumbs"><?php _e('Thumbs', 'revslider'); ?></option>
				<option value="tabs"><?php _e('Tabs', 'revslider'); ?></option>
			</select>
		</li>
		<li>
			<label><?php _e('Type:', 'revslider'); ?></label>
			<select name="ph-type">
				<option value="color"><?php _e('Color RGB', 'revslider'); ?></option>
				<option value="color-rgba"><?php _e('Color RGBA', 'revslider'); ?></option>
				<option value="font-family"><?php _e('Font Family', 'revslider'); ?></option>
				<option value="custom"><?php _e('Text/Custom', 'revslider'); ?></option>
			</select>
		</li>
		<li data-menu="always">
			<label><?php _e('Title:', 'revslider'); ?></label>
			<input type="text" name="ph-title" value="">
		</li>
		<li data-menu="always">
			<label><?php _e('Handle:', 'revslider'); ?></label>
			<span style="margin-left:-20px">##<input type="text" name="ph-handle" value="">##</span>
		</li>
		<li data-menu="color">
			<label><?php _e('Default Value:', 'revslider'); ?></label>
			<input type="text" name="ph-color" class="my-color-field" value="#000000">
		</li>
		<li data-menu="color-rgba">
			<label><?php _e('Default Value:', 'revslider'); ?></label>
			<input type="text" name="ph-color-rgba" class="my-color-field" value="0,0,0,0">
		</li>
		<li data-menu="font-family">
			<label><?php _e('Default Value:', 'revslider'); ?></label>
			<select name="ph-font-family" style="width: 112px;">
				<?php
				foreach($font_families as $handle => $name){
					if($name['label'] == 'Dont Show Me') continue;
					?>
					<option value="<?php echo esc_attr($name['label']); ?>"><?php echo esc_attr($name['label']); ?></option>
					<?php
				}
				?>
			</select>
		</li>
		<li data-menu="custom">
			<label><?php _e('Default Value:', 'revslider'); ?></label>
			<input type="text" name="ph-custom" value="">
		</li>
	</ul>
</div>