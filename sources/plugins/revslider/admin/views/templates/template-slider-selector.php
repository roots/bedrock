<?php
if( !defined( 'ABSPATH') ) exit();

$tmpl = new RevSliderTemplate();

$author_template_slider = $tmpl->getDefaultTemplateSliders();

$tmp_slider = new RevSlider();

$operations = new RevSliderOperations();
$glob_vals = $operations->getGeneralSettingsValues();
//$all_slider = $tmp_slider->getArrSliders();

?>
<!-- THE TEMPLATE AREA -->
<div id="template_area">
	<div id="template_header_part">
		<h2><span class="revlogo-mini" style="margin-right:15px;"></span><?php _e('Slider Template Library', 'revslider'); ?></h2>
		
		<div id="close-template"></div>
		
		<div class="revolution-template-switcher">		
			<span id="template_filter_buttons_wrapper" style="display:table-cell;vertical-align:top">	
				<?php
				if(!empty($author_template_slider) && is_array($author_template_slider)){
					foreach($author_template_slider as $name => $v){
						?>
						<span data-type="temp_<?php echo sanitize_title($name); ?>" class="template_filter_button"><?php echo esc_attr($name); ?></span>
						<?php
					}
				}
				?>
				<span style="display:none" id="selected_template_package_title">Light Content Block Page</span>
				<span  style="display:none" id="leave_selected_template_package"><?php _e('Back', 'revslider'); ?></span>
				<span class="template_filter_button selected" data-type="temp_all"><?php _e('All Templates', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="template_free"><?php _e('Free Templates', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="template_premium"><?php _e('Premium Templates', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="template_package_parent"><?php _e('Packages', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="temp_slider"><?php _e('Slider', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="temp_carousel"><?php _e('Carousel', 'revslider'); ?></span>			
				<span class="template_filter_button" data-type="temp_hero"><?php _e('Hero', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="temp_notinstalled"><?php _e('Not Installed', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="temp_socialmedia"><?php _e('Social Media', 'revslider'); ?></span>
				<span class="template_filter_button" data-type="temp_postbased"><?php _e('Post-Based', 'revslider'); ?></span>
				<span class="template_filter_button temp_new_udpated" data-type="temp_newupdate"><?php _e('New / Updated', 'revslider'); ?></span>			
			</span>
			<span style="display:table-cell;vertical-align:top;text-align:right">
				<span class="rs-reload-shop"><i class="eg-icon-arrows-ccw"></i><?php _e('Update Library', 'revslider'); ?></span>
			</span>			
		</div>
	</div>

	<!-- THE REVOLUTION BASE TEMPLATES -->
	<div class="revolution-template-groups">
		<!-- TEMPLATES WILL BE ADDED OVER AJAX -->
	</div>
	
	
</div>

<script>
	function isElementInViewport(element,sctop,wh,rtgt) {		
			var etp = parseInt(element.offset().top,0)-rtgt,
				etpp = parseInt(element.position().top,0),
				inviewport = false;		
			//element.closest('.template_group_wrappers').find('.template_thumb_title').html("Offset:"+etp+"   Scroll:"+sctop+" POffset:"+rtgt);
			if ((etp>-50) && (etp<wh+50))
				inviewport =  true;						
			return inviewport;
	}
	
	function scrollTA() {
		var ta = jQuery('.revolution-template-groups'),
			st = ta.scrollTop(),
			rtgt = parseInt(jQuery('.revolution-template-groups').offset().top,0),
			wh = jQuery(window).height();

		ta.find('.template_slider_item:visible, .template_slider_item_import:visible, .template_slider_item_img:visible').each(function() {
			var el = jQuery(this);				
			if (el.data('src')!=undefined && el.data('bgadded')!=1) {
				if (jQuery('#template_area').hasClass("show"))
					if (isElementInViewport(el,st,wh,rtgt)){
						el.css({backgroundImage:'url("'+el.data('src')+'")'});
						el.data('bgadded',1);						
					}
			}
		});
	}
	function setTWHeight() {
			var w = jQuery(window).height(),
				wh = jQuery('#template_header_part').height();
			jQuery('.revolution-template-groups').css({height:(w-wh)+"px"});
			jQuery('.revolution-template-groups').perfectScrollbar("update");
			scrollTA();
		};

	function initTemplateSliders() {
	
		
		jQuery('#template_area').on('showitnow',scrollTA);


		jQuery('body').on('click','.show_more_template_slider',function() {
			jQuery('.template_group_wrappers').css({zIndex:2});
			var item = jQuery(this).closest('.template_group_wrappers');
			if (item.length>0) {				
				if (jQuery(window).width() - item.offset().left < item.width()*2.1)
					item.addClass("show_more_to_left")
				else 
					item.removeClass("show_more_to_left");

				item.find('.template_thumb_more').fadeIn(100);
				jQuery('#template_bigoverlay').fadeIn(100);
				item.css({zIndex:15});
			}
		});

		jQuery('body').on('click','#leave_selected_template_package',function() {
			jQuery('.template_filter_button.selected').click();
			jQuery('#leave_selected_template_package').hide();
			jQuery('#selected_template_package_title').hide();
			jQuery('.template_filter_button').show(); 
		});

		// SHOW / HIDE THE SLIDERS IN PACKAGES
		jQuery('body').on('click','.template_group_opener',function() {
			var item = jQuery(this).closest('.template_package_parent'),
				title = item.find('.template_thumb_title').text();
				dg = item.data('package-group'),
				items = [];


			jQuery('.template_group_wrappers').each(function() {
				items.push(jQuery(this));
			});

			jQuery('.template_filter_button').hide(); 
			jQuery('#leave_selected_template_package').show();
			jQuery('#selected_template_package_title').show();
			jQuery('#selected_template_package_title').html(title);
			jQuery('#template_filter_buttons_wrapper')
			if (dg!==undefined) {
				for (var i=0;i<items.length;i++) {					
					if (items[i].hasClass(dg))
						items[i].fadeIn(100);
					else
						items[i].fadeOut(100);
				}
				setTimeout(scrollTA,100);
			}			
		})

		jQuery('#template_bigoverlay').on('click',function() {
			jQuery('#template_bigoverlay').fadeOut(100);
			jQuery('.template_thumb_more:visible').fadeOut(100);
		});

		// TEMPLATE ELEMENTS
		jQuery('.template_filter_button').on("click",function() {
			jQuery('#template_bigoverlay').fadeOut(100);
			jQuery('.template_thumb_more:visible').fadeOut(100);
			var btn = jQuery(this),
				sch = btn.data('type');
			jQuery('.template_filter_button').removeClass("selected");
			btn.addClass("selected");
			jQuery('.template_group_wrappers').hide();
			if (sch=="temp_all") {
				jQuery('.template_group_wrappers').each(function() {
					var item = jQuery(this);
					if (!item.hasClass("template_package")) item.show();
				});
			} else {				
				jQuery('.'+sch).each(function() {
					var item = jQuery(this);
					if ((sch==="template_free" || sch==="template_premium") && item.hasClass("template_package")) {
						item.hide();
					} else {
						item.show();
					}				
				});
			}
			jQuery('.revolution-template-groups').scrollTop(0);		
			scrollTA();	
			
		});

		
		jQuery('.template_slider_item, .template_slider_item_import').each(function() {
			var item = jQuery(this),
				gw = item.data('gridwidth'),
				gh = item.data('gridheight'),
				id = item.data('slideid'),
				w = 180;
				
			if (gw==undefined || gw<=0) gw = w;
			if (gh==undefined || gh<=0) gh = w;
			
			var	h = Math.round((w/gw)*gh);
			//item.css({height:h+"px"});
			
			var factor = w/gw;
			
			var htitle = item.closest('.template_group_wrappers').find('h3');
			if (!htitle.hasClass("modificated")) {
				htitle.html(htitle.html()+" ("+gw+"x"+gh+")").addClass("modificated");
			}			
		});
		
		// CLOSE SLIDE TEMPLATE
		jQuery('#close-template').click(function() {
			jQuery('#template_area').removeClass("show");
		});		

		// TEMPLATE TAB CHANGE 
		jQuery('body').on("click",'.revolution-templatebutton',function() {
			var btn = jQuery(this);
			jQuery('.revolution-template-groups').each(function() { jQuery(this).hide();});
			jQuery("."+btn.data("showgroup")).show();
			jQuery('.revolution-templatebutton').removeClass("selected");
			btn.addClass("selected");
			scrollTA();
			jQuery('.revolution-template-groups').perfectScrollbar("update");
		});
		
		setTWHeight();
		jQuery(window).on("resize",setTWHeight);
		jQuery('.revolution-template-groups').perfectScrollbar();

		document.addEventListener('ps-scroll-y', function (e) {
			if (jQuery(e.target).closest('.revolution-template-groups').length>0) {
				scrollTA();
				jQuery('#template_bigoverlay').css({top:jQuery('.revolution-template-groups').scrollTop()});
			}
	    });
		
		jQuery(".input_import_slider").change(function(){
			if(jQuery(this).val() !== ''){
				jQuery('.rs-import-slider-button').show();
			}else{
				jQuery('.rs-import-slider-button').hide();
			}
		});
	};
	
	<?php
	if(isset($_REQUEST['update_shop'])){
		?>
		jQuery(document).ready(function(){
			var recalls_amount = 0;
			function callTemplateSlider() {
				recalls_amount++;
				if (recalls_amount>5000) {
					jQuery('#waitaminute').hide();
				} else {
					
					if (jQuery('#template_area').length>0) {
						jQuery('#template_area').addClass("show");
						scrollTA();
						setTWHeight();
						jQuery('.revolution-template-groups').perfectScrollbar("update");
						jQuery('#waitaminute').hide();
						
						RevSliderAdmin.load_slider_template_html();
						//jQuery('#button_import_template_slider').click();
					} else {
						callTemplateSlider();
					}
				}			
			}
			callTemplateSlider();
		});			
		<?php
	}
	?>
</script>


<!-- Import template slider dialog -->
<div id="dialog_import_template_slider" title="<?php _e("Import Template Slider",'revslider'); ?>" class="dialog_import_template_slider" style="display:none">
	<form action="<?php echo RevSliderBase::$url_ajax; ?>" enctype="multipart/form-data" method="post">
		<input type="hidden" name="action" value="revslider_ajax_action">
		<input type="hidden" name="client_action" value="import_slider_template_slidersview">
		<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("revslider_actions"); ?>">
		<input type="hidden" name="uid" class="rs-uid" value="">
		
		<p><?php _e('Please select the corresponding zip file from the download packages import folder called', 'revslider'); ?>:</p> 
		<p class="filetoimport"><b><span class="rs-zip-name"></span></b></p>
		<?php
		$single_page_creation = RevSliderFunctions::getVal($glob_vals, "single_page_creation", "off");
		?>
		<table style="margin: 20px 0;<?php echo ($single_page_creation == 'on') ? '' : 'display: none;'; ?>">
			<tr>
				<td><?php _e('Create Blank Page:','revslider'); ?></td>
				<td><input type="radio" name="page-creation" value="true"> <?php _e('Yes', 'revslider'); ?></td>
				<td><input type="radio" name="page-creation" value="false" checked="checked"> <?php _e('No', 'revslider'); ?></td>
			</tr>
		</table>
		<?php
		
		?>
		<p class="import-file-wrapper"><input type="file" size="60" name="import_file" class="input_import_slider "></p>
		<span style="margin-top:45px;display:block"><input type="submit" class="rs-import-slider-button button-primary revblue tp-be-button" value="<?php _e("Import Template Slider",'revslider'); ?>"></span>
		<span class="tp-clearfix"></span>
		<span style="font-weight: 700;"><?php _e("Note: style templates will be updated if they exist!",'revslider'); ?></span>
		<table style="display: none;">
			<tr>
				<td><?php _e("Custom Animations:",'revslider'); ?></td>
				<td><input type="radio" name="update_animations" value="true" checked="checked"> <?php _e('Overwrite','revslider'); ?></td>
				<td><input type="radio" name="update_animations" value="false"> <?php _e('Append','revslider'); ?></td>
			</tr>
			<tr>
				<td><?php _e("Static Styles:",'revslider'); ?></td>
				<td><input type="radio" name="update_static_captions" value="true"> <?php _e('Overwrite','revslider'); ?></td>
				<td><input type="radio" name="update_static_captions" value="false"> <?php _e('Append','revslider'); ?></td>
				<td><input type="radio" name="update_static_captions" value="none" checked="checked"> <?php _e('Ignore','revslider'); ?></td>
			</tr>
		</table>
	</form>
</div>


<div id="dialog_import_template_slider_from" title="<?php _e("Import Template Slider",'revslider'); ?>" class="dialog_import_template_slider_from" style="display:none">
	<?php _e('Import Slider from local or from ThemePunch server?', 'revslider'); ?>
	<form action="<?php echo RevSliderBase::$url_ajax; ?>" enctype="multipart/form-data" method="post" name="rs-import-template-from-server" id="rs-import-template-from-server">
		<input type="hidden" name="action" value="revslider_ajax_action">
		<input type="hidden" name="client_action" value="import_slider_online_template_slidersview">
		<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("revslider_actions"); ?>">
		<input type="hidden" name="uid" class="rs-uid" value="">
		<input type="hidden" name="package" class="rs-package" value="false">
		<input type="hidden" name="page-creation" class="rs-page-creation" value="false">
	</form>
</div>

<div id="dialog_import_template_slider_page_template" title="<?php _e("Create Blank Page",'revslider'); ?>" class="dialog_import_template_slider_page_template" style="display:none">
	<?php
	_e('Create a Blank Demo Page with this Slider added to it?', 'revslider');
	?>
</div>