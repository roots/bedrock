<?php if( !defined( 'ABSPATH') ) exit(); 

$slide_general_addon = apply_filters('revslider_slide_settings_addons', array(), $slide, $slider);
?>

<script>
	jQuery(document).ready(function(){function r(r){var i;return r=r.replace(/ /g,""),r.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)?(i=100*parseFloat(r.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)[1]).toFixed(2),i=parseInt(i)):i=100,i}function i(r,i,e,t){var n,o,c;n=i.data("a8cIris"),o=i.data("wpWpColorPicker"),n._color._alpha=r,c=n._color.toString(),i.val(c),o.toggler.css({"background-color":c}),t&&a(r,e),i.wpColorPicker("color",c)}function a(r,i){i.slider("value",r),i.find(".ui-slider-handle").text(r.toString())}Color.prototype.toString=function(r){if("no-alpha"==r)return this.toCSS("rgba","1").replace(/\s+/g,"");if(1>this._alpha)return this.toCSS("rgba",this._alpha).replace(/\s+/g,"");var i=parseInt(this._color,10).toString(16);if(this.error)return"";if(i.length<6)for(var a=6-i.length-1;a>=0;a--)i="0"+i;return"#"+i},jQuery.fn.alphaColorPicker=function(){return this.each(function(){var e,t,n,o,c,l,s,d,u,p,f;e=jQuery(this),e.wrap('<div class="alpha-color-picker-wrap"></div>'),n=e.attr("data-palette")||"true",o=e.attr("data-show-opacity")||"true",c=e.attr("data-default-color")||"",l=-1!==n.indexOf("|")?n.split("|"):"false"==n?!1:!0,t=e.val().replace(/\s+/g,""),""==t&&(t=c),s={change:function(i,a){var t,n,o,l;t=e.attr("data-customize-setting-link"),n=e.wpColorPicker("color"),c==n&&(o=r(n),u.find(".ui-slider-handle").text(o)),"undefined"!=typeof wp.customize&&wp.customize(t,function(r){r.set(n)}),l=d.find(".transparency"),l.css("background-color",a.color.toString("no-alpha"))},palettes:l},e.wpColorPicker(s),d=e.parents(".wp-picker-container:first"),jQuery('<div class="alpha-color-picker-container"><div class="min-click-zone click-zone"></div><div class="max-click-zone click-zone"></div><div class="alpha-slider"></div><div class="transparency"></div></div>').appendTo(d.find(".wp-picker-holder")),u=d.find(".alpha-slider"),p=r(t),f={create:function(r,i){var a=jQuery(this).slider("value");jQuery(this).find(".ui-slider-handle").text(a),jQuery(this).siblings(".transparency ").css("background-color",t)},value:p,range:"max",step:1,min:0,max:100,animate:300},u.slider(f),"true"==o&&u.find(".ui-slider-handle").addClass("show-opacity"),d.find(".min-click-zone").on("click",function(){i(0,e,u,!0)}),d.find(".max-click-zone").on("click",function(){i(100,e,u,!0)}),d.find(".iris-palette").on("click",function(){var i,t;i=jQuery(this).css("background-color"),t=r(i),a(t,u),100!=t&&(i=i.replace(/[^,]+(?=\))/,(t/100).toFixed(2))),e.wpColorPicker("color",i)}),d.find(".button.wp-picker-default").on("click",function(){var i=r(c);a(i,u)}),e.on("input",function(){var i=jQuery(this).val(),e=r(i);a(e,u)}),u.slider().on("slide",function(r,a){var t=parseFloat(a.value)/100;i(t,e,u,!1),jQuery(this).find(".ui-slider-handle").text(a.value)})})}});
</script>

<!-- THE CONTEXT MENU -->
<div id="context_menu_underlay" class="ignorecontextmenu"></div>
<nav id="context-menu" class="context-menu">
<ul id="context-menu-first-ul" class="context-menu__items">
  <!-- CURRENT LAYER -->
  <li class="context-menu__item not_in_ctx_bg" id="ctx-m-activelayer">
    <div class="ctx_item_inner"><i id="cx-selected-layer-icon" class="rs-icon-layerimage_n context-menu__link" data-action="nothing"></i><span id="cx-selected-layer-name">Black Canon DSLR</span>
    	<span data-uniqueid="4" id="ctx-list-of-layer-links" class="ctx-list-of-layer-links">			
    		<span id="ctx-layer-link-type-element-cs" class="ctx-layer-link-type-element ctx-layer-link-type-element-cs ctx-layer-link-type-3"></span>			
    		<span class="ctx-list-of-layer-links-inner">				
    			<span data-linktype="1" data-action="grouplinkchange" class="context-menu__link ctx-layer-link-type-element ctx-layer-link-type-1"></span>				
    			<span data-linktype="2" data-action="grouplinkchange" class="context-menu__link ctx-layer-link-type-element ctx-layer-link-type-2"></span>				
    			<span data-linktype="3" data-action="grouplinkchange" class="context-menu__link ctx-layer-link-type-element ctx-layer-link-type-3"></span>				
    			<span data-linktype="4" data-action="grouplinkchange" class="context-menu__link ctx-layer-link-type-element ctx-layer-link-type-4"></span>				
    			<span data-linktype="5" data-action="grouplinkchange" class="context-menu__link ctx-layer-link-type-element ctx-layer-link-type-5"></span>				
    			<span data-linktype="0" data-action="grouplinkchange" class="context-menu__link ctx-layer-link-type-element ctx-layer-link-type-0"></span>			
    		</span>		
    	</span>
    </div>
  </li>
  <!-- BACKGROUND CONTEXT - ADD LAYER -->
  <li class="context-menu__item context-with-sub not_in_ctx_layer">
  	<div class="ctx_item_inner"><div class="context-menu__link"><i class="rs-icon-addlayer2"></i><span class="cx-layer-name"><?php _e('Add Layer', 'revslider'); ?></span></div><i class="fa-icon-chevron-right"></i></div>    
    <ul class="context-submenu">
    	<li class="context-menu__item"><div class="ctx_item_inner"><div class="context-menu__link" data-action="addtextlayer"><i class="rs-icon-layerfont_n"></i><span class="cx-layer-name"><?php _e('Add Text/Html Layer', 'revslider'); ?></span></div></div></li>
    	<li class="context-menu__item"><div class="ctx_item_inner"><div class="context-menu__link" data-action="addimagelayer"><i class="rs-icon-layerimage_n"></i><span class="cx-layer-name"><?php _e('Add Image Layer', 'revslider'); ?></span></div></div></li>
    	<li class="context-menu__item"><div class="ctx_item_inner"><div class="context-menu__link" data-action="addaudiolayer"><i class="rs-icon-layeraudio_n"></i><span class="cx-layer-name"><?php _e('Add Audio Layer', 'revslider'); ?></span></div></div></li>
    	<li class="context-menu__item"><div class="ctx_item_inner"><div class="context-menu__link" data-action="addvideolayer"><i class="rs-icon-layervideo_n"></i><span class="cx-layer-name"><?php _e('Add Video Layer', 'revslider'); ?></span></div></div></li>
    	<li class="context-menu__item"><div class="ctx_item_inner"><div class="context-menu__link" data-action="addbuttonlayer"><i class="rs-icon-layerbutton_n"></i><span class="cx-layer-name"><?php _e('Add Button Layer', 'revslider'); ?></span></div></div></li>
    	<li class="context-menu__item"><div class="ctx_item_inner"><div class="context-menu__link" data-action="addshapelayer"><i class="rs-icon-layershape_n"></i><span class="cx-layer-name"><?php _e('Add Shape Layer', 'revslider'); ?></span></div></div></li>
    	<li class="context-menu__item"><div class="ctx_item_inner"><div class="context-menu__link" data-action="addobjectlayer"><i class="rs-icon-layersvg_n"></i><span class="cx-layer-name"><?php _e('Add Object Layer', 'revslider'); ?></span></div></div></li>

		
	</ul>
  </li>
  <!-- ALL LAYERS -->
  <li class="context-menu__item ctx-m-top-divider context-with-sub" id="ctx-select-layer">
    <div class="ctx_item_inner"><div class="context-menu__link" data-action="select layer"><i class="eg-icon-menu"></i><span class="cx-layer-name"><?php _e('Select Layer', 'revslider'); ?></span></div><i class="fa-icon-chevron-right"></i></div>
    <ul class="context-submenu" id="ctx_list_of_layers">
    	
    </ul>
  </li>
  <!-- LAYER MANIPULATION -->
  <li class="context-menu__item not_in_ctx_bg">
    <div class="ctx_item_inner"><div class="context-menu__link" data-action="delete"><i class="rs-lighttrash"></i><span class="cx-layer-name"><?php _e('Delete Layer', 'revslider'); ?></span></div></div>
  </li>

  <li class="context-menu__item not_in_ctx_bg">
    <div class="ctx_item_inner"><div class="context-menu__link" data-action="duplicate"><i class="rs-lightcopy"></i><span class="cx-layer-name"><?php _e('Duplicate Layer', 'revslider'); ?></span></div></div>
  </li>
  <!-- LAYER VISIBILTY AND LOCK -->
  <li class="context-menu__item ctx-m-top-divider context-with-sub">
    <div class="ctx_item_inner"><div class="context-menu__link"><i class="eg-icon-eye"></i><span class="cx-layer-name"><?php _e('Show Layers', 'revslider'); ?></span></div><i class="fa-icon-chevron-right"></i></div>
    <ul class="context-submenu" id="ctx_list_of_invisibles">
    	<li class="context-menu__item">
		    <div class="ctx_item_inner"><div class="context-menu__link" data-action="showalllayer"><i class="fa-icon-asterisk"></i><span class="cx-layer-name"><?php _e('Show All Layers', 'revslider'); ?></span></div></div>
		  </li>
		<li class="context-menu__item">
		    <div class="ctx_item_inner"><div class="context-menu__link" data-action="showonlycurrent"><i class="fa-icon-hand-o-right"></i><span class="cx-layer-name"><?php _e('Show Only Current Layer', 'revslider'); ?></span></div></div>
		</li>
    </ul>
  </li>

  <li class="context-menu__item not_in_ctx_bg" id="cx-selected-layer-visible">
    <div class="ctx_item_inner"><div class="context-menu__link" data-action="showhide"><i class="eg-icon-eye-off"></i><span class="cx-layer-name"><?php _e('Hide Layer', 'revslider'); ?></span></div></div>
  </li>

  <li class="context-menu__item not_in_ctx_bg" id="cx-selected-layer-locked">
    <div class="ctx_item_inner"><div class="context-menu__link" data-action="lockunlock"><i class="eg-icon-lock-open"></i><span class="cx-layer-name"><?php _e('Lock Layer', 'revslider'); ?></span></div></div>
  </li>

  <!-- LAYER SPECIALS -->
  <!-- STYLE OF LAYERS -->
  <li class="context-menu__item ctx-m-top-divider context-with-sub not_in_ctx_bg">
  	<div class="ctx_item_inner"><div class="context-menu__link"><i class="fa-icon-paint-brush"></i><span class="cx-layer-name"><?php _e('Style', 'revslider'); ?></span></div><i class="fa-icon-chevron-right"></i></div>    
    <ul class="context-submenu">
    	<li class="context-menu__item">
		    <div class="ctx_item_inner"><div class="context-menu__link" data-action="copystyle"><i class="fa-icon-cut"></i><span class="cx-layer-name"><?php _e('Copy Style', 'revslider'); ?></span></div></div>
		</li>
		<li class="context-menu__item">
		    <div class="ctx_item_inner"><div class="context-menu__link" data-action="pastestyle"><i class="fa-icon-edit"></i><span class="cx-layer-name"><?php _e('Paste Style', 'revslider'); ?></span></div></div>
		</li>
		<li class="context-menu__item">
		    <div class="ctx_item_inner">
		    	<div style="display:inline-block" class="context-menu__link" data-action="nothing"><i class="fa-icon-edit"></i><span class="cx-layer-name"><?php _e('Inherit Style from', 'revslider'); ?></span></div>
		    	<div style="display:inline-block; float:right; margin-top:3px; height:20px" data-action="nothing">
			    	<div id="ctx-inheritdesktop" class="ctx-in-one-row context-menu__link" data-size="desktop" data-action="inheritfromdesktop"><i style="width:19px; margin:0px;" class="rs-displays-icon rs-slide-ds-desktop"></i></div>
			    	<div id="ctx-inheritnotebook" class="ctx-in-one-row context-menu__link" data-size="notebook" data-action="inheritfromnotebook"><i style="width:26px; margin:0px;" class="rs-displays-icon rs-slide-ds-notebook"></i></div>
			    	<div id="ctx-inherittablet" class="ctx-in-one-row context-menu__link" data-size="tablet" data-action="inheritfromtablet"><i style="width:15px; margin:0px;"class="rs-displays-icon rs-slide-ds-tablet"></i></div>
			    	<div id="ctx-inheritmobile" class="ctx-in-one-row context-menu__link" data-size="mobile" data-action="inheritfrommobile"><i style="width:17px; margin:0px;"class="rs-displays-icon rs-slide-ds-mobile"></i></div>
		    	</div>
		    </div>
		</li>
		<li class="context-menu__item">
		    <div class="ctx_item_inner"><div class="context-menu__link" data-action="advancedcss"><i class="fa-icon-code"></i><span class="cx-layer-name"><?php _e('Advanced Layer CSS', 'revslider'); ?></span></div></div>
		</li>
		<li class="context-menu__item ctx-m-top-divider _ho_image _ho_group _ho_row _ho_column _ho_svg _ho_audio _ho_video _ho_group _ho_shape _ho_button">
		    <div class="ctx_item_inner context-menu__link noleftmargin" data-action="delegate" data-delegate="ctx_linebreak"><i class="fa-icon-level-down"></i><span class="cx-layer-name"><?php _e('Line Break', 'revslider'); ?></span><div id="ctx_linebreak" class="ctx-td-switcher context-menu__link" data-action="linebreak"></div></div>
		</li>
		 <li class="context-menu__item _ho_image _ho_group _ho_row _ho_column _ho_svg _ho_audio _ho_video _ho_group _ho_notincolumn">
		    <div class="ctx_item_inner context-menu__link noleftmargin" data-action="nothing"><i class="fa-icon-text-width"></i><span class="cx-layer-name"><?php _e('Display Mode', 'revslider'); ?></span><div class="context-menu__link ctx-td-option-selector-wrapper" data-action="nothing"><div id="ctx_displayblock" class="ctx-td-option-selector context-menu__link selected" data-action="displayblock">Block</div><div id="ctx_displayinline" class="ctx-td-option-selector context-menu__link" data-action="displayinline">Inline</div></div></div>
		</li>
		
		<li class="context-menu__item ctx-m-top-divider _ho_text  _ho_row _ho_column _ho_audio _ho_shape _ho_button">
		    <div class="ctx_item_inner context-menu__link noleftmargin" data-action="delegate" data-delegate="ctx_keepaspect"><i class="fa-icon-expand"></i><span class="cx-layer-name"><?php _e('Keep Aspect Ratio', 'revslider'); ?></span><div id="ctx_keepaspect" class="ctx-td-switcher context-menu__link" data-action="aspectratio"></div></div>
		</li>
		<li class="context-menu__item _ho_text _ho_group _ho_row _ho_column _ho_audio _ho_video _ho_shape _ho_button">
			<div class="ctx_item_inner"><div class="context-menu__link" data-action="resetsize"><i class="fa-icon-rotate-left"></i><span class="cx-layer-name"><?php _e('Reset Size', 'revslider'); ?></span></div></div>		    
		</li>
    </ul>
  </li>
  <!-- RESPONSIVENESS -->
  <li class="context-menu__item context-with-sub not_in_ctx_bg">
    <div class="ctx_item_inner"><div class="context-menu__link"><i class="fa-icon-compress"></i><span class="cx-layer-name"><?php _e('Layer Responsiveness', 'revslider'); ?></span></div><i class="fa-icon-chevron-right"></i></div>
    <ul class="context-submenu">
    	<li class="context-menu__item">
		    <div class="ctx_item_inner context-menu__link" data-action="nothing"><span class="cx-layer-name"><?php _e('Alignment', 'revslider'); ?></span><div class="context-menu__link ctx-td-option-selector-wrapper" data-action="nothing"><div id="ctx_gridbased" class="ctx-td-option-selector context-menu__link selected" data-action="gridbased">Grid Based</div><div id="ctx_slidebased" class="ctx-td-option-selector context-menu__link" data-action="slidebased">Slide Based</div></div></div>
		</li>
    	<li class="context-menu__item _ho_row _ho_column">
		    <div class="ctx_item_inner context-menu__link" data-action="delegate" data-delegate="ctx_autoresponsive"><span class="cx-layer-name"><?php _e('Auto Responsive', 'revslider'); ?></span><div id="ctx_autoresponsive" class="ctx-td-switcher context-menu__link" data-action="autoresponsive"></div></div>
		</li>
		<li class="context-menu__item _ho_row _ho_column">
		    <div class="ctx_item_inner context-menu__link" data-action="delegate" data-delegate="ctx_childrenresponsive"><span class="cx-layer-name"><?php _e('Children Responsive', 'revslider'); ?></span><div id="ctx_childrenresponsive" class="ctx-td-switcher context-menu__link" data-action="childrenresponsive"></div></div>
		</li>
		<li class="context-menu__item">
		    <div class="ctx_item_inner context-menu__link" data-action="delegate" data-delegate="ctx_responsiveoffset"><span class="cx-layer-name"><?php _e('Responsive Offset', 'revslider'); ?></span><div id="ctx_responsiveoffset" class="ctx-td-switcher context-menu__link" data-action="responsiveoffset"></div></div>
		</li>
    </ul>
  </li>

   <!-- VISIBILITY -->
  <li class="context-menu__item context-with-sub not_in_ctx_bg">
    <div class="ctx_item_inner"><div class="context-menu__link"><i class="fa-icon-eye"></i><span class="cx-layer-name"><?php _e('Visibility', 'revslider'); ?></span></div><i class="fa-icon-chevron-right"></i></div>
    <ul class="context-submenu">    	
    	<li class="context-menu__item">
		    <div class="ctx_item_inner context-menu__link noleftmargin" data-action="delegate" data-delegate="ctx_showhideondesktop"><i class="rs-displays-icon rs-slide-ds-desktop"></i><span class="cx-layer-name"><?php _e('Desktop', 'revslider'); ?></span><div id="ctx_showhideondesktop" class="ctx-td-switcher context-menu__link" data-action="showhideondesktop"></div></div>
		</li>
		<li class="context-menu__item">
		    <div class="ctx_item_inner context-menu__link noleftmargin" data-action="delegate" data-delegate="ctx_showhideonnotebook"><i class="rs-displays-icon rs-slide-ds-notebook"></i><span class="cx-layer-name"><?php _e('Notebook', 'revslider'); ?></span><div id="ctx_showhideonnotebook" class="ctx-td-switcher context-menu__link" data-action="showhideonnotebook"></div></div>
		</li>
		<li class="context-menu__item">
		    <div class="ctx_item_inner context-menu__link noleftmargin" data-action="delegate" data-delegate="ctx_showhideontablet"><i class="rs-displays-icon rs-slide-ds-tablet"></i><span class="cx-layer-name"><?php _e('Tablet', 'revslider'); ?></span><div id="ctx_showhideontablet" class="ctx-td-switcher context-menu__link" data-action="showhideontablet"></div></div>
		</li>
		<li class="context-menu__item">
		    <div class="ctx_item_inner context-menu__link noleftmargin" data-action="delegate" data-delegate="ctx_showhideonmobile"><i class="rs-displays-icon rs-slide-ds-mobile"></i><span class="cx-layer-name"><?php _e('Mobile', 'revslider'); ?></span><div id="ctx_showhideonmobile" class="ctx-td-switcher context-menu__link" data-action="showhideonmobile"></div></div>
		</li>
		
    </ul>
  </li>

</ul>
</nav>

		
<div class="editor_buttons_wrapper  postbox unite-postbox" style="max-width:100% !important; min-width:1200px !important;">
	<div class="box-closed tp-accordion" style="border-bottom:5px solid #ddd;">
		<ul class="rs-slide-settings-tabs">
			<?php
			if(!$slide->isStaticSlide()){
				?>
				<li id="v_sgs_mp_1" data-content="#slide-main-image-settings-content" class="selected"><i style="height:45px" class="rs-mini-layer-icon eg-icon-picture-1 rs-toolbar-icon"></i><span><?php _e("Main Background",'revslider'); ?></span></li>					
				<?php
			}
			?>				
				<li id="v_sgs_mp_2" class="<?php echo ($slide->isStaticSlide()) ? ' selected' : ''; ?>" data-content="#slide-general-settings-content"><i style="height:45px" class="rs-mini-layer-icon rs-icon-chooser-2 rs-toolbar-icon"></i><?php _e("General Settings",'revslider'); ?></li>
			<?php
			if(!$slide->isStaticSlide()){
				?>
				<li id="v_sgs_mp_3" data-content="#slide-thumbnail-settings-content"><i style="height:45px" class="rs-mini-layer-icon eg-icon-flickr-1 rs-toolbar-icon"></i><?php _e("Thumbnail",'revslider'); ?></li>
				<li id="v_sgs_mp_4" data-content="#slide-animation-settings-content" id="slide-animation-settings-content-tab"><i style="height:45px" class="rs-mini-layer-icon rs-icon-chooser-3 rs-toolbar-icon"></i><?php _e("Slide Animation",'revslider'); ?></li>
				<li id="v_sgs_mp_5" data-content="#slide-seo-settings-content"><i style="height:45px" class="rs-mini-layer-icon rs-icon-advanced rs-toolbar-icon"></i><?php _e("Link & Seo",'revslider'); ?></li>
				<li id="v_sgs_mp_6" data-content="#slide-info-settings-content"><i style="height:45px; font-size:16px;" class="rs-mini-layer-icon eg-icon-info-circled rs-toolbar-icon"></i><?php _e("Slide Info",'revslider'); ?></li>						
				<li id="main-menu-nav-settings-li" data-content="#slide-nav-settings-content"><i style="height:45px; font-size:16px;" class="rs-mini-layer-icon eg-icon-magic rs-toolbar-icon"></i><?php _e("Nav. Overwrite",'revslider'); ?></li>
				<?php
			}
			?>				
			<?php if(!empty($slide_general_addon)){ ?>
				<li data-content="#slide-addon-wrapper"><i style="height:45px; font-size:16px;" class="rs-mini-layer-icon eg-icon-plus-circled rs-toolbar-icon"></i><?php _e("AddOns",'revslider'); ?></li>
			<?php } ?>
		</ul>

		<div style="clear:both"></div>
		<script type="text/javascript">
			jQuery('document').ready(function() {
				jQuery('.rs-slide-settings-tabs li').click(function() {
					var tw = jQuery('.rs-slide-settings-tabs .selected'),
						tn = jQuery(this);
					jQuery(tw.data('content')).hide(0);
					tw.removeClass("selected");
					tn.addClass("selected");
					jQuery(tn.data('content')).show(0);
				});
			});
		</script>
	</div>
	<div style="padding:15px">
		<form name="form_slide_params" id="form_slide_params" class="slide-main-settings-form">
			<?php 
			if(!$slide->isStaticSlide()){
				?>
				<div id="slide-main-image-settings-content" class="slide-main-settings-form">

					<ul class="rs-layer-main-image-tabs" style="display:inline-block; ">
						<li data-content="#mainbg-sub-source" class="selected"><?php _e('Source', 'revslider'); ?></li>
						<li class="mainbg-sub-settings-selector" data-content="#mainbg-sub-setting"><?php _e('Source Settings', 'revslider'); ?></li>					
						<li class="mainbg-sub-filtres-selector" data-content="#mainbg-sub-filters"><?php _e('Filters', 'revslider'); ?></li>
						<li class="mainbg-sub-parallax-selector" data-content="#mainbg-sub-parallax"><?php _e('Parallax / 3D', 'revslider'); ?></li>
						<li class="mainbg-sub-kenburns-selector" data-content="#mainbg-sub-kenburns"><?php _e('Ken Burns', 'revslider'); ?></li>
					</ul>

					<div class="tp-clearfix"></div>

					<script type="text/javascript">
						jQuery('document').ready(function() {
							jQuery('.rs-layer-main-image-tabs li').click(function() {
								var tw = jQuery('.rs-layer-main-image-tabs .selected'),
									tn = jQuery(this);
								jQuery(tw.data('content')).hide(0);
								tw.removeClass("selected");
								tn.addClass("selected");
								jQuery(tn.data('content')).show(0);
							});
						});
					</script>


					<!-- SLIDE MAIN IMAGE -->
					<span id="mainbg-sub-source" style="display:block">
						<div style="float:none; clear:both; margin-bottom: 10px;"></div>
						<input type="hidden" name="rs-gallery-type" value="<?php echo esc_attr($slider_type); ?>" />
						<span class="diblock bg-settings-block">
							<!-- IMAGE FROM MEDIAGALLERY -->												
							<?php
							if($slider_type == 'posts' || $slider_type == 'specific_posts' || $slider_type == 'woocommerce'){
								?>
								<label><?php _e("Featured Image",'revslider'); ?></label>
								<input type="radio" name="background_type" value="image" class="bgsrcchanger" data-callid="tp-bgimagewpsrc" data-imgsettings="on" data-bgtype="image" id="radio_back_image" <?php checked($bgType, 'image'); ?>>
								
								<?php
								/*
								<div class="tp-clearfix"></div>
								<label><?php _e("Meta Image",'revslider'); ?></label>
								<input type="radio" name="background_type" value="meta" class="bgsrcchanger" data-callid="tp-bgimagewpsrc" data-imgsettings="on" data-bgtype="meta" <?php checked($bgType, 'meta'); ?>>
								<span id="" class="" style="margin-left:20px;">
									<span style="margin-right: 10px"><?php _e('Meta Handle', 'revslider'); ?></span>
									<input type="text" id="meta_handle" name="meta_handle" value="<?php echo $meta_handle; ?>">
								</span>*/ ?>
								<?php
							}elseif($slider_type !== 'gallery'){
								?>
								<label><?php _e("Stream Image",'revslider'); ?></label>
								<input type="radio" name="background_type" value="image" class="bgsrcchanger" data-callid="tp-bgimagewpsrc" data-imgsettings="on" data-bgtype="image" id="radio_back_image" <?php checked($bgType, 'image'); ?>>
								<?php
								if($slider_type == 'vimeo' || $slider_type == 'youtube' || $slider_type == 'instagram' || $slider_type == 'twitter'){
									?>
									<div class="tp-clearfix"></div>
									<label><?php _e("Stream Video",'revslider'); ?></label>
									<input type="radio" name="background_type" value="stream<?php echo $slider_type; ?>" class="bgsrcchanger" data-callid="tp-bgimagewpsrc" data-imgsettings="on" data-bgtype="stream<?php echo $slider_type; ?>" <?php checked($bgType, 'stream'.$slider_type); ?>>
									<span id="streamvideo_cover" class="streamvideo_cover" style="display:none;margin-left:20px;">
										<span style="margin-right: 10px"><?php _e("Use Cover",'revslider'); ?></span>
										<input type="checkbox" class="tp-moderncheckbox" id="stream_do_cover" name="stream_do_cover" data-unchecked="off" <?php checked($stream_do_cover, 'on'); ?>>
									</span>
									
									<div class="tp-clearfix"></div>
									<label><?php _e("Stream Video + Image",'revslider'); ?></label>
									<input type="radio" name="background_type" value="stream<?php echo $slider_type; ?>both" class="bgsrcchanger" data-callid="tp-bgimagewpsrc" data-imgsettings="on" data-bgtype="stream<?php echo $slider_type; ?>both" <?php checked($bgType, 'stream'.$slider_type.'both'); ?>>
									<span id="streamvideo_cover_both" class="streamvideo_cover_both" style="display:none;margin-left:20px;">
										<span style="margin-right: 10px"><?php _e("Use Cover",'revslider'); ?></span>
										<input type="checkbox" class="tp-moderncheckbox" id="stream_do_cover_both" name="stream_do_cover_both" data-unchecked="off" <?php checked($stream_do_cover_both, 'on'); ?>>
									</span>
									<?php
								}
							}else{
								?>
								<label ><?php _e("Main / Background Image",'revslider'); ?></label>
								<input type="radio" name="background_type" value="image" class="bgsrcchanger" data-callid="tp-bgimagewpsrc" data-imgsettings="on" data-bgtype="image" id="radio_back_image" <?php checked($bgType, 'image'); ?>>
								
								<?php
							}
							?>
							<!-- THE BG IMAGE CHANGED DIV -->
							<span id="tp-bgimagewpsrc" class="bgsrcchanger-div" style="display:none;margin-left:20px;">																
								<a href="javascript:void(0)" id="button_change_image" class="button-primary revblue" ><i class="fa-icon-wordpress"></i><?php _e("Media Library", 'revslider'); ?></a>
								<a href="javascript:void(0)" id="button_change_image_objlib" class="button-primary revpurple" ><i class="fa-icon-book"></i><?php _e("Object Library", 'revslider'); ?></a>
							</span>
							
							</span>
							<div class="tp-clearfix"></div>
							
							<!-- IMAGE FROM EXTERNAL -->
							<label><?php _e("External URL",'revslider'); ?></label>
							<input type="radio" name="background_type" value="external" data-callid="tp-bgimageextsrc" data-imgsettings="on" class="bgsrcchanger" data-bgtype="external" id="radio_back_external" <?php checked($bgType, 'external'); ?>>

							<!-- THE BG IMAGE FROM EXTERNAL SOURCE -->
							<span id="tp-bgimageextsrc" class="bgsrcchanger-div" style="display:none;margin-left:20px;">
								<input type="text" name="bg_external" id="slide_bg_external" value="<?php echo $slideBGExternal?>" <?php echo ($bgType != 'external') ? ' class="disabled"' : ''; ?>>
								<a href="javascript:void(0)" id="button_change_external" class="button-primary revblue" ><?php _e("Get External",'revslider'); ?></a>
							</span>
							
							<div class="tp-clearfix"></div>
							
							<!-- TRANSPARENT BACKGROUND -->
							<label><?php _e("Transparent",'revslider'); ?></label>
							<input type="radio" name="background_type" value="trans" data-callid="" class="bgsrcchanger" data-bgtype="trans" id="radio_back_trans" <?php checked($bgType, 'trans'); ?>>
							<div class="tp-clearfix"></div>
							
							<!-- COLORED BACKGROUND -->
							<label><?php _e("Solid Colored",'revslider'); ?></label>
							<input type="radio" name="background_type" value="solid"  data-callid="tp-bgcolorsrc" class="bgsrcchanger" data-bgtype="solid" id="radio_back_solid" <?php checked($bgType, 'solid'); ?>>
							
							<!-- THE COLOR SELECTOR -->
							<span id="tp-bgcolorsrc"  class="bgsrcchanger-div"  style="display:none;margin-left:20px;">
								<input type="text" name="bg_color" id="slide_bg_color" class="my-color-field" value="<?php echo $slideBGColor; ?>">
							</span>
							<div class="tp-clearfix"></div>

							<!-- THE YOUTUBE SELECTOR -->
							<label><?php _e("YouTube Video",'revslider'); ?></label>
							<input type="radio" name="background_type" value="youtube"  data-callid="tp-bgyoutubesrc" class="bgsrcchanger" data-bgtype="youtube" id="radio_back_youtube" <?php checked($bgType, 'youtube'); ?>>
							<div class="tp-clearfix"></div>
							
							<!-- THE BG IMAGE FROM YOUTUBE SOURCE -->
							<span id="tp-bgyoutubesrc" class="bgsrcchanger-div" style="display:none; margin-left:20px;">
								<label style="min-width:180px"><?php _e("ID:",'revslider'); ?></label>
								<input type="text" name="slide_bg_youtube" id="slide_bg_youtube" value="<?php echo $slideBGYoutube; ?>" <?php echo ($bgType != 'youtube') ? ' class="disabled"' : ''; ?>>							
								<?php _e('example: T8--OggjJKQ', 'revslider'); ?>
								<div class="tp-clearfix"></div>
								<label style="min-width:180px"><?php _e("Cover Image:",'revslider'); ?></label>
								<span id="youtube-image-picker"></span>
							</span>
							<div class="tp-clearfix"></div>
							
							<!-- THE VIMEO SELECTOR -->
							<label><?php _e("Vimeo Video",'revslider'); ?></label>
							<input type="radio" name="background_type" value="vimeo"  data-callid="tp-bgvimeosrc" class="bgsrcchanger" data-bgtype="vimeo" id="radio_back_vimeo" <?php checked($bgType, 'vimeo'); ?>>
							<div class="tp-clearfix"></div>

							<!-- THE BG IMAGE FROM VIMEO SOURCE -->
							<span id="tp-bgvimeosrc" class="bgsrcchanger-div" style="display:none; margin-left:20px;">
								<label style="min-width:180px"><?php _e("ID:",'revslider'); ?></label>
								<input type="text" name="slide_bg_vimeo" id="slide_bg_vimeo" value="<?php echo $slideBGVimeo; ?>" <?php echo ($bgType != 'vimeo') ? ' class="disabled"' : ''; ?>>							
								<?php _e('example: 30300114', 'revslider'); ?>
								<div class="tp-clearfix"></div>
								<label style="min-width:180px"><?php _e("Cover Image:",'revslider'); ?></label>
								<span id="vimeo-image-picker"></span>
							</span>
							<div class="tp-clearfix"></div>

							<!-- THE HTML5 SELECTOR -->
							<label><?php _e("HTML5 Video",'revslider'); ?></label>
							<input type="radio" name="background_type" value="html5"  data-callid="tp-bghtmlvideo" class="bgsrcchanger" data-bgtype="html5" id="radio_back_htmlvideo" <?php checked($bgType, 'html5'); ?>>
							<div class="tp-clearfix"></div>
							<!-- THE BG IMAGE FROM HTML5 SOURCE -->
							<span id="tp-bghtmlvideo" class="bgsrcchanger-div" style="display:none; margin-left:20px;">
								
								<label style="min-width:180px"><?php _e('MPEG:', 'revslider'); ?></label>
								<input type="text" name="slide_bg_html_mpeg" id="slide_bg_html_mpeg" value="<?php echo $slideBGhtmlmpeg; ?>" <?php echo ($bgType != 'html5') ? ' class="disabled"' : ''; ?>>
								<span class="vidsrcchanger-div" style="margin-left:20px;">
									<a href="javascript:void(0)" data-inptarget="slide_bg_html_mpeg" class="button_change_video button-primary revblue" ><?php _e('Change Video', 'revslider'); ?></a>
								</span>
								<div class="tp-clearfix"></div>
								<label style="min-width:180px"><?php _e('WEBM:', 'revslider'); ?></label>
								<input type="text" name="slide_bg_html_webm" id="slide_bg_html_webm" value="<?php echo $slideBGhtmlwebm; ?>" <?php echo ($bgType != 'html5') ? ' class="disabled"' : ''; ?>>
								<span class="vidsrcchanger-div" style="margin-left:20px;">
									<a href="javascript:void(0)" data-inptarget="slide_bg_html_webm" class="button_change_video button-primary revblue" ><?php _e('Change Video', 'revslider'); ?></a>
								</span>
								<div class="tp-clearfix"></div>
								<label style="min-width:180px"><?php _e('OGV:', 'revslider'); ?></label>
								<input type="text" name="slide_bg_html_ogv" id="slide_bg_html_ogv" value="<?php echo $slideBGhtmlogv; ?>" <?php echo ($bgType != 'html5') ? ' class="disabled"' : ''; ?>>							
								<span class="vidsrcchanger-div" style="margin-left:20px;">
									<a href="javascript:void(0)" data-inptarget="slide_bg_html_ogv" class="button_change_video button-primary revblue" ><?php _e('Change Video', 'revslider'); ?></a>
								</span>
								<div class="tp-clearfix"></div>
								<label style="min-width:180px"><?php _e('Cover Image:', 'revslider'); ?></label>
								<span id="html5video-image-picker"></span>
							</span>
						</span>
					</span>
					<div id="mainbg-sub-setting" style="display:none">
						<div style="float:none; clear:both; margin-bottom: 10px;"></div>
						<div class="rs-img-source-url">						
							<label><?php _e('Source Info:', 'revslider'); ?></label>
							<span class="text-selectable" id="the_image_source_url" style="margin-right:20px"></span>
							<span class="description"><?php _e('Read Only ! Image can be changed from "Source Tab"','revslider'); ?></span>
						</div>

						<div class="rs-img-source-size">
							
							<label><?php _e('Image Source Size:', 'revslider'); ?></label>
							<span style="margin-right:20px">
								<select name="image_source_type">
									<?php
									foreach($img_sizes as $imghandle => $imgSize){
										$sel = ($bg_image_size == $imghandle) ? ' selected="selected"' : '';
										echo '<option value="'.sanitize_title($imghandle).'"'.$sel.'>'.$imgSize.'</option>';
									}
									?>
								</select>
							</span>
						</div>
						
						<div id="tp-bgimagesettings" class="bgsrcchanger-div" style="display:none;">
							<!-- ALT -->
							<div>
								<?php $alt_option = RevSliderFunctions::getVal($slideParams, 'alt_option', 'media_library'); ?>
								<label><?php _e("Alt:",'revslider'); ?></label>
								<select id="alt_option" name="alt_option">
									<option value="media_library" <?php selected($alt_option, 'media_library'); ?>><?php _e('From Media Library', 'revslider'); ?></option>
									<option value="file_name" <?php selected($alt_option, 'file_name'); ?>><?php _e('From Filename', 'revslider'); ?></option>
									<option value="custom" <?php selected($alt_option, 'custom'); ?>><?php _e('Custom', 'revslider'); ?></option>
								</select>
								<?php $alt_attr = RevSliderFunctions::getVal($slideParams, 'alt_attr', ''); ?>
								<input style="<?php echo ($alt_option !== 'custom') ? 'display:none;' : ''; ?>" type="text" id="alt_attr" name="alt_attr" value="<?php echo $alt_attr; ?>">
							</div>
							<div class="ext_setting" style="display: none;">
								<label><?php _e('Width:', 'revslider')?></label>
								<input type="text" name="ext_width" value="<?php echo $ext_width; ?>" />
							</div>
							<div class="ext_setting" style="display: none;">
								<label><?php _e('Height:', 'revslider')?></label>
								<input type="text" name="ext_height" value="<?php echo $ext_height; ?>" />
							</div>
						
							<!-- TITLE -->
							<div>
								<?php $title_option = RevSliderFunctions::getVal($slideParams, 'title_option', 'media_library'); ?>
								<label><?php _e('Title:','revslider'); ?></label>
								<select id="title_option" name="title_option">
									<option value="media_library" <?php selected($title_option, 'media_library'); ?>><?php _e('From Media Library', 'revslider'); ?></option>
									<option value="file_name" <?php selected($title_option, 'file_name'); ?>><?php _e('From Filename', 'revslider'); ?></option>
									<option value="custom" <?php selected($title_option, 'custom'); ?>><?php _e('Custom', 'revslider'); ?></option>
								</select>
								<?php $title_attr = RevSliderFunctions::getVal($slideParams, 'title_attr', ''); ?>
								<input style="<?php echo ($title_option !== 'custom') ? 'display:none;' : ''; ?>" type="text" id="title_attr" name="title_attr" value="<?php echo $title_attr; ?>">
							</div>
						</div>					
						
						<div id="video-settings" style="display: block;">
							<div>
								<label for="video_force_cover" class="video-label"><?php _e('Force Cover:', 'revslider'); ?></label>
								<input type="checkbox" class="tp-moderncheckbox" id="video_force_cover" name="video_force_cover" data-unchecked="off" <?php checked($video_force_cover, 'on'); ?>>
							</div>
							<span id="video_dotted_overlay_wrap">
								<label for="video_dotted_overlay">
									<?php _e('Dotted Overlay:', 'revslider'); ?>
								</label>				
								<select id="video_dotted_overlay" name="video_dotted_overlay" style="width:100px">
									<option <?php selected($video_dotted_overlay, 'none'); ?> value="none"><?php _e('none', 'revslider'); ?></option>
									<option <?php selected($video_dotted_overlay, 'twoxtwo'); ?> value="twoxtwo"><?php _e('2 x 2 Black', 'revslider'); ?></option>
									<option <?php selected($video_dotted_overlay, 'twoxtwowhite'); ?> value="twoxtwowhite"><?php _e('2 x 2 White', 'revslider'); ?></option>
									<option <?php selected($video_dotted_overlay, 'threexthree'); ?> value="threexthree"><?php _e('3 x 3 Black', 'revslider'); ?></option>
									<option <?php selected($video_dotted_overlay, 'threexthreewhite'); ?> value="threexthreewhite"><?php _e('3 x 3 White', 'revslider'); ?></option>
								</select>
								<div style="clear: both;"></div>
							</span>
							<label for="video_ratio">
								<?php _e("Aspect Ratio:", 'revslider'); ?>
							</label>				
							<select id="video_ratio" name="video_ratio" style="width:100px">
								<option <?php selected($video_ratio, '16:9');?> value="16:9"><?php _e('16:9','revslider'); ?></option>
								<option <?php selected($video_ratio, '4:3');?> value="4:3"><?php _e('4:3','revslider'); ?></option>
							</select>
							<div style="clear: both;"></div>
							<div>
								<label for="video_ratio">
									<?php _e("Start At:", 'revslider'); ?>
								</label>				
								<input type="text" value="<?php echo $video_start_at; ?>" name="video_start_at"> <?php _e('For Example: 00:17', 'revslider'); ?>
								<div style="clear: both;"></div>
							</div>
							<div>
								<label for="video_ratio">
									<?php _e("End At:", 'revslider'); ?>
								</label>				
								<input type="text" value="<?php echo $video_end_at; ?>" name="video_end_at"> <?php _e('For Example: 02:17', 'revslider'); ?>
								<div style="clear: both;"></div>
							</div>
							<div>
								<label for="video_loop"><?php _e('Loop Video:', 'revslider'); ?></label>
								<select id="video_loop" name="video_loop" style="width: 200px;">
									<option <?php selected($video_loop, 'none');?> value="none"><?php _e('Disable', 'revslider'); ?></option>
									<option <?php selected($video_loop, 'loop');?> value="loop"><?php _e('Loop, Slide is paused', 'revslider'); ?></option>
									<option <?php selected($video_loop, 'loopandnoslidestop');?> value="loopandnoslidestop"><?php _e('Loop, Slide does not stop', 'revslider'); ?></option>
								</select>
							</div>
							
							<div>	
								<label for="video_nextslide"><?php _e('Next Slide On End:', 'revslider'); ?></label>
								<input type="checkbox" class="tp-moderncheckbox" id="video_nextslide" name="video_nextslide" data-unchecked="off" <?php checked($video_nextslide, 'on'); ?>>
							</div>
							<div>
								<label for="video_force_rewind"><?php _e('Rewind at Slide Start:', 'revslider'); ?></label>
								<input type="checkbox" class="tp-moderncheckbox" id="video_force_rewind" name="video_force_rewind" data-unchecked="off" <?php checked($video_force_rewind, 'on'); ?>>
							</div>
							
							<div>	
								<label for="video_mute"><?php _e('Mute Video:', 'revslider'); ?></label>
								<input type="checkbox" class="tp-moderncheckbox" id="video_mute" name="video_mute" data-unchecked="off" <?php checked($video_mute, 'on'); ?>>
							</div>
							
							<div class="vid-rev-vimeo-youtube video_volume_wrapper">
								<label for="video_volume"><?php _e('Video Volume:', 'revslider'); ?></label>
								<input type="text" id="video_volume" name="video_volume" <?php echo esc_attr($video_volume); ?>>
							</div>

							<span id="vid-rev-youtube-options">
								<div>
									<label for="video_speed"><?php _e('Video Speed:', 'revslider'); ?></label>
									<select id="video_speed" name="video_speed" style="width:75px">
										<option <?php selected($video_speed, '0.25');?> value="0.25"><?php _e('0.25', 'revslider'); ?></option>
										<option <?php selected($video_speed, '0.50');?> value="0.50"><?php _e('0.50', 'revslider'); ?></option>
										<option <?php selected($video_speed, '1');?> value="1"><?php _e('1', 'revslider'); ?></option>
										<option <?php selected($video_speed, '1.5');?> value="1.5"><?php _e('1.5', 'revslider'); ?></option>
										<option <?php selected($video_speed, '2');?> value="2"><?php _e('2', 'revslider'); ?></option>
									</select>
								</div>
								<div>
									<label><?php _e('Arguments YouTube:', 'revslider'); ?></label>
									<input type="text" id="video_arguments" name="video_arguments" style="width:350px;" value="<?php echo esc_attr($video_arguments); ?>">
								</div>
							</span>
							<div id="vid-rev-vimeo-options">
								<label><?php _e('Arguments Vimeo:', 'revslider'); ?></label>
								<input type="text" id="video_arguments_vim" name="video_arguments_vim" style="width:350px;" value="<?php echo esc_attr($video_arguments_vim); ?>">
							</div>
						</div>
						
						<div id="bg-setting-wrap">
							<div id="bg-setting-bgfit-wrap">
								<label for="slide_bg_fit"><?php _e('Background Fit:', 'revslider'); ?></label>
								<select name="bg_fit" id="slide_bg_fit" style="margin-right:20px">
									<option value="cover"<?php selected($bgFit, 'cover'); ?>>cover</option>
									<option value="contain"<?php selected($bgFit, 'contain'); ?>>contain</option>
									<option value="percentage"<?php selected($bgFit, 'percentage'); ?>>(%, %)</option>
									<option value="normal"<?php selected($bgFit, 'normal'); ?>>normal</option>
								</select>
								<input type="text" name="bg_fit_x" style="min-width:54px;width:54px; <?php if($bgFit != 'percentage') echo 'display: none; '; ?> width:60px;margin-right:10px" value="<?php echo $bgFitX; ?>" />
								<input type="text" name="bg_fit_y" style="min-width:54px;width:54px;  <?php if($bgFit != 'percentage') echo 'display: none; '; ?> width:60px;margin-right:10px"  value="<?php echo $bgFitY; ?>" />
							</div>
							<div id="bg-setting-bgpos-def-wrap">
								<div id="bg-setting-bgpos-wrap">
									<label for="slide_bg_position" id="bg-position-lbl"><?php _e('Background Position:', 'revslider'); ?></label>
									<span id="bg-start-position-wrapper">
										<select name="bg_position" id="slide_bg_position">
											<option value="center top"<?php selected($bgPosition, 'center top'); ?>>center top</option>
											<option value="center right"<?php selected($bgPosition, 'center right'); ?>>center right</option>
											<option value="center bottom"<?php selected($bgPosition, 'center bottom'); ?>>center bottom</option>
											<option value="center center"<?php selected($bgPosition, 'center center'); ?>>center center</option>
											<option value="left top"<?php selected($bgPosition, 'left top'); ?>>left top</option>
											<option value="left center"<?php selected($bgPosition, 'left center'); ?>>left center</option>
											<option value="left bottom"<?php selected($bgPosition, 'left bottom'); ?>>left bottom</option>
											<option value="right top"<?php selected($bgPosition, 'right top'); ?>>right top</option>
											<option value="right center"<?php selected($bgPosition, 'right center'); ?>>right center</option>
											<option value="right bottom"<?php selected($bgPosition, 'right bottom'); ?>>right bottom</option>
											<option value="percentage"<?php selected($bgPosition, 'percentage'); ?>>(x%, y%)</option>
										</select>
										<input type="text" name="bg_position_x" style="min-width:54px;width:54px; <?php if($bgPosition != 'percentage') echo 'display: none;'; ?>width:60px;margin-right:10px" value="<?php echo $bgPositionX; ?>" />
										<input type="text" name="bg_position_y" style="min-width:54px;width:54px; <?php if($bgPosition != 'percentage') echo 'display: none;'; ?>width:60px;margin-right:10px" value="<?php echo $bgPositionY; ?>" />
									</span>
								</div>
							</div>
							<div id="bg-setting-bgrep-wrap">
								<label><?php _e("Background Repeat:",'revslider')?></label>
								<span>
									<select name="bg_repeat" id="slide_bg_repeat" style="margin-right:20px">
										<option value="no-repeat"<?php selected($bgRepeat, 'no-repeat'); ?>>no-repeat</option>
										<option value="repeat"<?php selected($bgRepeat, 'repeat'); ?>>repeat</option>
										<option value="repeat-x"<?php selected($bgRepeat, 'repeat-x'); ?>>repeat-x</option>
										<option value="repeat-y"<?php selected($bgRepeat, 'repeat-y'); ?>>repeat-y</option>
									</select>
								</span>
							</div>
						</div>
						
					</div>

					<span id="mainbg-sub-parallax" style="display:none">
						<p>
							<?php 
							if ($use_parallax=="off") {						
								echo '<i style="color:#c0392b">';
								_e("Parallax Feature in Slider Settings is deactivated, parallax will be ignored.",'revslider'); 
								echo '</i>';
							} else {
							
									if ($parallaxisddd=="off") { 
								?>
								<label><?php _e("Parallax Level:",'revslider'); ?></label>
								<select name="slide_parallax_level" id="slide_parallax_level">
									<option value="-" <?php selected($slide_parallax_level, '-'); ?>><?php _e('No Parallax', 'revslider'); ?></option>
									<option value="1" <?php selected($slide_parallax_level, '1'); ?>>1 - (<?php echo $parallax_level[0]; ?>%)</option>
									<option value="2" <?php selected($slide_parallax_level, '2'); ?>>2 - (<?php echo $parallax_level[1]; ?>%)</option>
									<option value="3" <?php selected($slide_parallax_level, '3'); ?>>3 - (<?php echo $parallax_level[2]; ?>%)</option>
									<option value="4" <?php selected($slide_parallax_level, '4'); ?>>4 - (<?php echo $parallax_level[3]; ?>%)</option>
									<option value="5" <?php selected($slide_parallax_level, '5'); ?>>5 - (<?php echo $parallax_level[4]; ?>%)</option>
									<option value="6" <?php selected($slide_parallax_level, '6'); ?>>6 - (<?php echo $parallax_level[5]; ?>%)</option>
									<option value="7" <?php selected($slide_parallax_level, '7'); ?>>7 - (<?php echo $parallax_level[6]; ?>%)</option>
									<option value="8" <?php selected($slide_parallax_level, '8'); ?>>8 - (<?php echo $parallax_level[7]; ?>%)</option>
									<option value="9" <?php selected($slide_parallax_level, '9'); ?>>9 - (<?php echo $parallax_level[8]; ?>%)</option>
									<option value="10" <?php selected($slide_parallax_level, '10'); ?>>10 - (<?php echo $parallax_level[9]; ?>%)</option>
									<option value="11" <?php selected($slide_parallax_level, '11'); ?>>11 - (<?php echo $parallax_level[10]; ?>%)</option>
									<option value="12" <?php selected($slide_parallax_level, '12'); ?>>12 - (<?php echo $parallax_level[11]; ?>%)</option>
									<option value="13" <?php selected($slide_parallax_level, '13'); ?>>13 - (<?php echo $parallax_level[12]; ?>%)</option>
									<option value="14" <?php selected($slide_parallax_level, '14'); ?>>14 - (<?php echo $parallax_level[13]; ?>%)</option>
									<option value="15" <?php selected($slide_parallax_level, '15'); ?>>15 - (<?php echo $parallax_level[14]; ?>%)</option>							
								</select>
								<?php } else {
									if ($parallaxbgfreeze=="off") {
								?>							
									<label><?php _e("Selected 3D Depth:",'revslider'); ?></label>
									<input style="min-width:54px;width:54px" type="text" disabled value="<?php echo $parallax_level[15];?>%" />							
									<span><i><?php _e('3D Parallax is Enabled via Slider Settings !', 'revslider'); ?></i></span>
								<?php
									} else {								
										?>
											<label><?php _e("Background 3D is Disabled",'revslider'); ?></label>									
											<span style="display: inline-block;vertical-align: middle;line-height:32px"><i><?php _e('To Enable 3D Parallax for Background please change the Option "BG 3D Disabled" to "OFF" via the Slider Settings !', 'revslider'); ?></i></span>
										<?php
									}
								}
							}
							?>
						</p>
						
					</span>
					<span id="mainbg-sub-filters" style="display:none">
						<div style="display:none; margin-bottom: 10px;">																	
							<select id="media-filter-type" name="media-filter-type">
								<option value="none">No Filter</option>
									<option <?php selected($mediafilter, '_1977'); ?> value="_1977">1977</option>
									<option <?php selected($mediafilter, 'aden'); ?> value="aden">Aden</option>
									<option <?php selected($mediafilter, 'brooklyn'); ?> value="brooklyn">Brooklyn</option>
									<option <?php selected($mediafilter, 'clarendon'); ?> value="clarendon">Clarendon</option>
									<option <?php selected($mediafilter, 'earlybird'); ?> value="earlybird">Earlybird</option>
									<option <?php selected($mediafilter, 'gingham'); ?> value="gingham">Gingham</option>
									<option <?php selected($mediafilter, 'hudson'); ?> value="hudson">Hudson</option>
									<option <?php selected($mediafilter, 'inkwell'); ?> value="inkwell">Inkwell</option>
									<option <?php selected($mediafilter, 'lark'); ?> value="lark">Lark</option>
									<option <?php selected($mediafilter, 'lofi'); ?> value="lofi">Lo-Fi</option>
									<option <?php selected($mediafilter, 'mayfair'); ?> value="mayfair">Mayfair</option>
									<option <?php selected($mediafilter, 'moon'); ?> value="moon">Moon</option>
									<option <?php selected($mediafilter, 'nashville'); ?> value="nashville">Nashville</option>
									<option <?php selected($mediafilter, 'perpetua'); ?> value="perpetua">Perpetua</option>
									<option <?php selected($mediafilter, 'reyes'); ?> value="reyes">Reyes</option>
									<option <?php selected($mediafilter, 'rise'); ?> value="rise">Rise</option>
									<option <?php selected($mediafilter, 'slumber'); ?> value="slumber">Slumber</option>
									<option <?php selected($mediafilter, 'toaster'); ?> value="toaster">Toaster</option>
									<option <?php selected($mediafilter, 'walden'); ?> value="walden">Walden</option>
									<option <?php selected($mediafilter, 'willow'); ?> value="willow">Willow</option>
									<option <?php selected($mediafilter, 'xpro2'); ?> value="xpro2">X-pro II</option>
							</select>
						</div>
						<div id="inst-filter-grid">									
							<div data-type="none" class="filter_none inst-filter-griditem selected"><div class="ifgname">No Filter</div><div class="inst-filter-griditem-img none" style="visibility: inherit; opacity: 1;"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="_1977" class="filter__1977 inst-filter-griditem "><div class="ifgname">1977</div><div class="inst-filter-griditem-img _1977" style="visibility: inherit; opacity: 1;"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="aden" class="filter_aden inst-filter-griditem "><div class="ifgname">Aden</div><div class="inst-filter-griditem-img aden" style="visibility: inherit; opacity: 1;"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="brooklyn" class="filter_brooklyn inst-filter-griditem "><div class="ifgname">Brooklyn</div><div class="inst-filter-griditem-img brooklyn" style="visibility: inherit; opacity: 1;"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="clarendon" class="filter_clarendon inst-filter-griditem "><div class="ifgname">Clarendon</div><div class="inst-filter-griditem-img clarendon" style="visibility: inherit; opacity: 1;"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="earlybird" class="filter_earlybird inst-filter-griditem "><div class="ifgname">Earlybird</div><div class="inst-filter-griditem-img earlybird" style="visibility: inherit; opacity: 1;"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="gingham" class="filter_gingham inst-filter-griditem "><div class="ifgname">Gingham</div><div class="inst-filter-griditem-img gingham"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="hudson" class="filter_hudson inst-filter-griditem "><div class="ifgname">Hudson</div><div class="inst-filter-griditem-img hudson"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="inkwell" class="filter_inkwell inst-filter-griditem "><div class="ifgname">Inkwell</div><div class="inst-filter-griditem-img inkwell"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="lark" class="filter_lark inst-filter-griditem "><div class="ifgname">Lark</div><div class="inst-filter-griditem-img lark" style="visibility: inherit; opacity: 1;"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="lofi" class="filter_lofi inst-filter-griditem "><div class="ifgname">Lo-Fi</div><div class="inst-filter-griditem-img lofi" style="visibility: inherit; opacity: 1;"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="mayfair" class="filter_mayfair inst-filter-griditem "><div class="ifgname">Mayfair</div><div class="inst-filter-griditem-img mayfair" style="visibility: inherit; opacity: 1;"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="moon" class="filter_moon inst-filter-griditem "><div class="ifgname">Moon</div><div class="inst-filter-griditem-img moon"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="nashville" class="filter_nashville inst-filter-griditem "><div class="ifgname">Nashville</div><div class="inst-filter-griditem-img nashville"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="perpetua" class="filter_perpetua inst-filter-griditem "><div class="ifgname">Perpetua</div><div class="inst-filter-griditem-img perpetua" style="visibility: inherit; opacity: 1;"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="reyes" class="filter_reyes inst-filter-griditem "><div class="ifgname">Reyes</div><div class="inst-filter-griditem-img reyes" style="visibility: inherit; opacity: 1;"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="rise" class="filter_rise inst-filter-griditem "><div class="ifgname">Rise</div><div class="inst-filter-griditem-img rise" style="visibility: inherit; opacity: 1;"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="slumber" class="filter_slumber inst-filter-griditem "><div class="ifgname">Slumber</div><div class="inst-filter-griditem-img slumber" style="visibility: inherit; opacity: 1;"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="toaster" class="filter_toaster inst-filter-griditem "><div class="ifgname">Toaster</div><div class="inst-filter-griditem-img toaster" style="visibility: inherit; opacity: 1;"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="walden" class="filter_walden inst-filter-griditem "><div class="ifgname">Walden</div><div class="inst-filter-griditem-img walden" style="visibility: inherit; opacity: 1;"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="willow" class="filter_willow inst-filter-griditem "><div class="ifgname">Willow</div><div class="inst-filter-griditem-img willow" style="visibility: inherit; opacity: 1;"></div><div class="inst-filter-griditem-img-noeff"></div></div>
							<div data-type="xpro2" class="filter_xpro2 inst-filter-griditem "><div class="ifgname">X-pro II</div><div class="inst-filter-griditem-img xpro2" style="visibility: inherit; opacity: 1;"></div><div class="inst-filter-griditem-img-noeff"></div></div>
						</div>						
					</span>
					<div id="mainbg-sub-kenburns" style="display:none; position:relative">
						<div>
							<label><?php _e('Ken Burns / Pan Zoom:', 'revslider'); ?></label>
							<input type="checkbox" class="tp-moderncheckbox withlabel" id="kenburn_effect" name="kenburn_effect" data-unchecked="off" <?php checked($kenburn_effect, 'on'); ?>>
						</div>
						<div id="kenburn_wrapper" <?php echo ($kenburn_effect == 'off') ? 'style="display: none;"' : ''; ?>>						
							<div id="ken_burn_example_wrapper">									
								<div id="kenburn-playpause-wrapper"><i class="eg-icon-play"></i><span>PLAY</span></div><div id="kenburn-backtoidle"></div>
								<div id="ken_burn_example">								
									<div id="ken_burn_slot_example" class="tp-bgimg defaultimg">									
									</div>
								</div>									
							</div>
							
							<p>
								<label><?php _e('Scale: (in %):', 'revslider'); ?></label>
								<label style="min-width:40px"><?php _e('From', 'revslider'); ?></label>
								<input style="min-width:54px;width:54px" class="kb_input_values" type="text" name="kb_start_fit" id="kb_start_fit" value="<?php echo intval($kb_start_fit); ?>" />
								<label style="min-width:20px"><?php _e('To', 'revslider')?></label>
								<input style="min-width:54px;width:54px" class="kb_input_values" type="text" name="kb_end_fit" id="kb_end_fit" value="<?php echo intval($kb_end_fit); ?>" />
							</p>
							
							<p>
								<label><?php _e('Horizontal Offsets (+/-):', 'revslider')?></label>
								<label style="min-width:40px"><?php _e('From', 'revslider'); ?></label>							
								<input style="min-width:54px;width:54px" class="kb_input_values" type="text" name="kb_start_offset_x" id="kb_start_offset_x" value="<?php echo $kbStartOffsetX; ?>" />
								<label style="min-width:20px"><?php _e('To', 'revslider')?></label>
								<input style="min-width:54px;width:54px" class="kb_input_values" type="text" name="kb_end_offset_x" id="kb_end_offset_x" value="<?php echo $kbEndOffsetX; ?>" />								
							</p>

							<p>
								<label><?php _e('Vertical Offsets (+/-):', 'revslider')?></label>		
								<label style="min-width:40px"><?php _e('From', 'revslider'); ?></label>												
								<input style="min-width:54px;width:54px" class="kb_input_values" type="text" name="kb_start_offset_y" id="kb_start_offset_y" value="<?php echo $kbStartOffsetY; ?>" />
								<label style="min-width:20px"><?php _e('To', 'revslider')?></label>
								<input style="min-width:54px;width:54px" class="kb_input_values" type="text" name="kb_end_offset_y" id="kb_end_offset_y" value="<?php echo $kbEndOffsetY; ?>" />								
							</p>							
							<p>
								<label><?php _e('Rotation:', 'revslider')?></label>		
								<label style="min-width:40px"><?php _e('From', 'revslider'); ?></label>												
								<input style="min-width:54px;width:54px" class="kb_input_values" type="text" name="kb_start_rotate" id="kb_start_rotate" value="<?php echo $kbStartRotate; ?>" />
								<label style="min-width:20px"><?php _e('To', 'revslider')?></label>
								<input style="min-width:54px;width:54px" class="kb_input_values" type="text" name="kb_end_rotate" id="kb_end_rotate" value="<?php echo $kbEndRotate; ?>" />
							</p>
							
							<p>
								<label><?php _e('Easing:', 'revslider'); ?></label>
								<select name="kb_easing" id="kb_easing" class="kb_input_values" >
									<option <?php selected($kb_easing, 'Linear.easeNone'); ?> value="Linear.easeNone">Linear.easeNone</option>
									<option <?php selected($kb_easing, 'Power0.easeIn'); ?> value="Power0.easeIn">Power0.easeIn  (linear)</option>
									<option <?php selected($kb_easing, 'Power0.easeInOut'); ?> value="Power0.easeInOut">Power0.easeInOut  (linear)</option>
									<option <?php selected($kb_easing, 'Power0.easeOut'); ?> value="Power0.easeOut">Power0.easeOut  (linear)</option>
									<option <?php selected($kb_easing, 'Power1.easeIn'); ?> value="Power1.easeIn">Power1.easeIn</option>
									<option <?php selected($kb_easing, 'Power1.easeInOut'); ?> value="Power1.easeInOut">Power1.easeInOut</option>
									<option <?php selected($kb_easing, 'Power1.easeOut'); ?> value="Power1.easeOut">Power1.easeOut</option>
									<option <?php selected($kb_easing, 'Power2.easeIn'); ?> value="Power2.easeIn">Power2.easeIn</option>
									<option <?php selected($kb_easing, 'Power2.easeInOut'); ?> value="Power2.easeInOut">Power2.easeInOut</option>
									<option <?php selected($kb_easing, 'Power2.easeOut'); ?> value="Power2.easeOut">Power2.easeOut</option>
									<option <?php selected($kb_easing, 'Power3.easeIn'); ?> value="Power3.easeIn">Power3.easeIn</option>
									<option <?php selected($kb_easing, 'Power3.easeInOut'); ?> value="Power3.easeInOut">Power3.easeInOut</option>
									<option <?php selected($kb_easing, 'Power3.easeOut'); ?> value="Power3.easeOut">Power3.easeOut</option>
									<option <?php selected($kb_easing, 'Power4.easeIn'); ?> value="Power4.easeIn">Power4.easeIn</option>
									<option <?php selected($kb_easing, 'Power4.easeInOut'); ?> value="Power4.easeInOut">Power4.easeInOut</option>
									<option <?php selected($kb_easing, 'Power4.easeOut'); ?> value="Power4.easeOut">Power4.easeOut</option>
									<option <?php selected($kb_easing, 'Back.easeIn'); ?> value="Back.easeIn">Back.easeIn</option>
									<option <?php selected($kb_easing, 'Back.easeInOut'); ?> value="Back.easeInOut">Back.easeInOut</option>
									<option <?php selected($kb_easing, 'Back.easeOut'); ?> value="Back.easeOut">Back.easeOut</option>
									<option <?php selected($kb_easing, 'Bounce.easeIn'); ?> value="Bounce.easeIn">Bounce.easeIn</option>
									<option <?php selected($kb_easing, 'Bounce.easeInOut'); ?> value="Bounce.easeInOut">Bounce.easeInOut</option>
									<option <?php selected($kb_easing, 'Bounce.easeOut'); ?> value="Bounce.easeOut">Bounce.easeOut</option>
									<option <?php selected($kb_easing, 'Circ.easeIn'); ?> value="Circ.easeIn">Circ.easeIn</option>
									<option <?php selected($kb_easing, 'Circ.easeInOut'); ?> value="Circ.easeInOut">Circ.easeInOut</option>
									<option <?php selected($kb_easing, 'Circ.easeOut'); ?> value="Circ.easeOut">Circ.easeOut</option>
									<option <?php selected($kb_easing, 'Elastic.easeIn'); ?> value="Elastic.easeIn">Elastic.easeIn</option>
									<option <?php selected($kb_easing, 'Elastic.easeInOut'); ?> value="Elastic.easeInOut">Elastic.easeInOut</option>
									<option <?php selected($kb_easing, 'Elastic.easeOut'); ?> value="Elastic.easeOut">Elastic.easeOut</option>
									<option <?php selected($kb_easing, 'Expo.easeIn'); ?> value="Expo.easeIn">Expo.easeIn</option>
									<option <?php selected($kb_easing, 'Expo.easeInOut'); ?> value="Expo.easeInOut">Expo.easeInOut</option>
									<option <?php selected($kb_easing, 'Expo.easeOut'); ?> value="Expo.easeOut">Expo.easeOut</option>
									<option <?php selected($kb_easing, 'Sine.easeIn'); ?> value="Sine.easeIn">Sine.easeIn</option>
									<option <?php selected($kb_easing, 'Sine.easeInOut'); ?> value="Sine.easeInOut">Sine.easeInOut</option>
									<option <?php selected($kb_easing, 'Sine.easeOut'); ?> value="Sine.easeOut">Sine.easeOut</option>
									<option <?php selected($kb_easing, 'SlowMo.ease'); ?> value="SlowMo.ease">SlowMo.ease</option>
								</select>
							</p>
							<p>
								<label><?php _e('Duration (in ms):', 'revslider')?></label>
								<input type="text" name="kb_duration" class="kb_input_values"  id="kb_duration" value="<?php echo intval($kb_duration); ?>" />
							</p>
						</div>
					</div>
					
					<input type="hidden" id="image_url" name="image_url" value="<?php echo $imageUrl; ?>" />
					<input type="hidden" id="image_id" name="image_id" value="<?php echo $imageID; ?>" />
				</div>
			<?php
			}
			?>	
				<div id="slide-general-settings-content" style="<?php echo (!$slide->isStaticSlide()) ? ' display:none' : ''; ?>">
					<?php 
					if(!$slide->isStaticSlide()){
					?>
						<!-- SLIDE TITLE -->
						<p style="display:none">
							<?php $title = RevSliderFunctions::getVal($slideParams, 'title','Slide'); ?>
							<label><?php _e("Slide Title",'revslider'); ?></label>
							<input type="text" class="medium" id="title" disabled="disabled" name="title" value="<?php echo $title; ?>">
							<span class="description"><?php _e("The title of the slide, will be shown in the slides list.",'revslider'); ?></span>
						</p>

						<!-- SLIDE DELAY -->
						<p>
							<?php $delay = RevSliderFunctions::getVal($slideParams, 'delay',''); ?>
							<label><?php _e('Slide "Delay":','revslider'); ?></label>
							<input type="text" class="small-text" id="delay" name="delay" value="<?php echo $delay; ?>">
							<span class="description"><?php _e("A new delay value for the Slide. If no delay defined per slide, the delay defined via Options (9000ms) will be used.",'revslider'); ?></span>
						</p>

						<!-- SLIDE PAUSE ON PURPOSE -->
						<p>
							<?php $stoponpurpose = RevSliderFunctions::getVal($slideParams, 'stoponpurpose','published'); ?>
							<label><?php _e("Pause Slider:",'revslider'); ?></label>
							<select id="stoponpurpose" name="stoponpurpose">
								<option value="false"<?php selected($stoponpurpose, 'false'); ?>><?php _e("Default",'revslider'); ?></option>
								<option value="true"<?php selected($stoponpurpose, 'true'); ?>><?php _e("Stop Slider Progress",'revslider'); ?></option>						
							</select>
							<span class="description"><?php _e("Stop Slider Progress on this slider or use Slider Settings Defaults",'revslider'); ?></span>
						</p>


						<!-- SLIDE PAUSE ON PURPOSE -->
						<p>
							<?php $invisibleslide = RevSliderFunctions::getVal($slideParams, 'invisibleslide','published'); ?>
							<label><?php _e("Slide in Navigation (invisible):",'revslider'); ?></label>
							<select id="invisibleslide" name="invisibleslide">
								<option value="false"<?php selected($invisibleslide, 'false'); ?>><?php _e("Show Always",'revslider'); ?></option>
								<option value="true"<?php selected($invisibleslide, 'true'); ?>><?php _e("Only Via Actions",'revslider'); ?></option>						
							</select>
							<span class="description"><?php _e("Show Slide always or only on Action calls. Invisible slides are not available due Navigation Elements.",'revslider'); ?></span>
						</p>


						<!-- SLIDE STATE -->
						<p>
							<?php $state = RevSliderFunctions::getVal($slideParams, 'state','published'); ?>
							<label><?php _e("Slide State:",'revslider'); ?></label>
							<select id="state" name="state">
								<option value="published"<?php selected($state, 'published'); ?>><?php _e("Published",'revslider'); ?></option>
								<option value="unpublished"<?php selected($state, 'unpublished'); ?>><?php _e("Unpublished",'revslider'); ?></option>
							</select>
							<span class="description"><?php _e("The state of the slide. The unpublished slide will be excluded from the slider.",'revslider'); ?></span>
						</p>

						<!-- SLIDE HIDE AFTER LOOP -->
						<p>
							<?php $hideslideafter = RevSliderFunctions::getVal($slideParams, 'hideslideafter',0); ?>
							<label><?php _e('Hide Slide After Loop:','revslider'); ?></label>
							<input type="text" class="small-text" id="hideslideafter" name="hideslideafter" value="<?php echo $hideslideafter; ?>">
							<span class="description"><?php _e("After how many Loops should the Slide be hidden ? 0 = Slide is never hidden.",'revslider'); ?></span>
						</p>

						<!-- HIDE SLIDE ON MOBILE -->
						<p>
							<?php $hideslideonmobile = RevSliderFunctions::getVal($slideParams, 'hideslideonmobile', 'off'); ?>
							<label><?php _e('Hide Slide On Mobile:','revslider'); ?></label>
							<span style="display:inline-block; width:200px; margin-right:20px;line-height:27px">
								<input type="checkbox" class="tp-moderncheckbox" id="hideslideonmobile" name="hideslideonmobile" data-unchecked="off" <?php checked($hideslideonmobile, 'on'); ?>>
							</span>
							<span class="description"><?php _e("Show/Hide this Slide if Slider loaded on Mobile Device.",'revslider'); ?></span>
						</p>

						<!-- SLIDE LANGUAGE SELECTOR -->
						<?php
						if(isset($slider) && $slider->isInited()){
							$isWpmlExists = RevSliderWpml::isWpmlExists();
							$useWpml = $slider->getParam("use_wpml","off");

							if($isWpmlExists && $useWpml == "on"){
								$arrLangs = RevSliderWpml::getArrLanguages();
								$curset_lang = RevSliderFunctions::getVal($slideParams, "lang","all");
								?>
								<p>
									<label><?php _e("Language",'revslider'); ?></label>
									<select name="lang">
										<?php
										if(!empty($arrLangs) && is_array($arrLangs)){
											foreach($arrLangs as $lang_handle => $lang_name){
												$sel = ($lang_handle === $curset_lang) ? ' selected="selected"' : '';
												echo '<option value="'.$lang_handle.'"'.$sel.'>'.$lang_name.'</option>';
											}
										}
										?>
									</select>
									<span class="description"><?php _e("The language of the slide (uses WPML plugin).",'revslider'); ?></span>
								</p>
								<?php
							}
						}
						?>
						<!-- SLIDE VISIBLE FROM -->
						<p>
							<?php $date_from = RevSliderFunctions::getVal($slideParams, 'date_from',''); ?>
							<label><?php _e("Visible from:",'revslider'); ?></label>
							<input type="text" class="inputDatePicker" id="date_from" name="date_from" value="<?php echo $date_from; ?>">
							<span class="description"><?php _e("If set, slide will be visible after the date is reached.",'revslider'); ?></span>
						</p>

						<!-- SLIDE VISIBLE UNTIL -->
						<p>
							<?php $date_to = RevSliderFunctions::getVal($slideParams, 'date_to',''); ?>
							<label><?php _e("Visible until:",'revslider'); ?></label>
							<input type="text" class="inputDatePicker" id="date_to" name="date_to" value="<?php echo $date_to; ?>">
							<span class="description"><?php _e("If set, slide will be visible till the date is reached.",'revslider'); ?></span>
						</p>

						
						<!-- SLIDE VISIBLE FROM -->
						<p style="display:none">
							<?php $save_performance = RevSliderFunctions::getVal($slideParams, 'save_performance','off'); ?>
							<label><?php _e("Save Performance:",'revslider'); ?></label>
							<span style="display:inline-block; width:200px; margin-right:20px;">
								<input type="checkbox" class="tp-moderncheckbox withlabel" id="save_performance" name="save_performance" data-unchecked="off" <?php checked( $save_performance, "on" ); ?>>
							</span>
							<span class="description"><?php _e("Slide End Transition will first start when last Layer has been removed.",'revslider'); ?></span>
						</p>
					<?php
					} else {
					?>
						<!-- STATIC LAYER OVERFLOW (ON/OFF) -->
						<p>
							<?php $staticoverflow = RevSliderFunctions::getVal($slideParams, 'staticoverflow','published'); ?>
							<label><?php _e("Static Layers Overflow:",'revslider'); ?></label>
							<select id="staticoverflow" name="staticoverflow">
								<option value="visible"<?php selected($staticoverflow, 'visible'); ?>><?php _e("Visible",'revslider'); ?></option>
								<option value="hidden"<?php selected($staticoverflow, 'hidden'); ?>><?php _e("Hidden",'revslider'); ?></option>						
							</select>
							<span class="description"><?php _e("Set the Overflow of Static Layers to Visible or Hidden.",'revslider'); ?></span>
						</p>
					<?php
					}
					?>
				</div>
			<?php
			if(!$slide->isStaticSlide()){
				?>

				<!-- THUMBNAIL SETTINGS -->
				<div id="slide-thumbnail-settings-content" style="display:none">
					<!-- THUMBNAIL SETTINGS -->
					<div style="margin-top:10px">
						<?php $slide_thumb = RevSliderFunctions::getVal($slideParams, 'slide_thumb',''); ?>
						<span style="display:inline-block; vertical-align: top;">
							<label><?php _e("Thumbnail:",'revslider'); ?></label>
						</span>
						<div style="display:inline-block; vertical-align: top;">
							<div id="slide_thumb_button_preview" class="setting-image-preview"><?php
							if(intval($slide_thumb) > 0){
								?>
								<div style="width:100px;height:70px;background:url('<?php echo admin_url( 'admin-ajax.php' ); ?>?action=revslider_show_image&amp;img=<?php echo $slide_thumb; ?>&amp;w=100&amp;h=70&amp;t=exact'); background-position:center center; background-size:cover;"></div>
								<?php
							}elseif($slide_thumb !== ''){
								?>
								<div style="width:100px;height:70px;background:url('<?php echo $slide_thumb; ?>'); background-position:center center; background-size:cover;"></div>
								<?php
							}
							?></div>
							<input type="hidden" id="slide_thumb" name="slide_thumb" value="<?php echo $slide_thumb; ?>">
							<span style="clear:both;display:block"></span>
							<input type="button" id="slide_thumb_button" style="width:110px !important; display:inline-block;" class="button-image-select button-primary revblue" value="Choose Image" original-title="">
							<input type="button" id="slide_thumb_button_remove" style="margin-right:20px !important; width:85px !important; display:inline-block;" class="button-image-remove button-primary revred"  value="Remove" original-title="">
							<span class="description"><?php _e("Slide Thumbnail. If not set - it will be taken from the slide image.",'revslider'); ?></span>
						</div>
					</div>
					<?php $thumb_dimension = RevSliderFunctions::getVal($slideParams, 'thumb_dimension', 'slider'); ?>
					<?php $thumb_for_admin = RevSliderFunctions::getVal($slideParams, 'thumb_for_admin', 'off'); ?>

					<p>
						<span style="display:inline-block; vertical-align: top;">
							<label><?php _e("Thumbnail Dimensions:",'revslider'); ?></label>
						</span>
						<select name="thumb_dimension">
							<option value="slider" <?php selected($thumb_dimension, 'slider'); ?>><?php _e('From Slider Settings', 'revslider'); ?></option>
							<option value="orig" <?php selected($thumb_dimension, 'orig'); ?>><?php _e('Original Size', 'revslider'); ?></option>
						</select>
						<span class="description"><?php _e("Width and height of thumbnails can be changed in the Slider Settings -> Navigation -> Thumbs tab.",'revslider'); ?></span>
					</p>

					<p style="display:none;" class="show_on_thumbnail_exist">
						<span style="display:inline-block; vertical-align: top;">
							<label><?php _e("Thumbnail Admin Purpose:",'revslider'); ?></label>
						</span>
						<span style="display:inline-block; width:200px; margin-right:20px;line-height:27px">
							<input type="checkbox" class="tp-moderncheckbox" id="thumb_for_admin" name="thumb_for_admin" data-unchecked="off" <?php checked($thumb_for_admin, 'on'); ?>>
						</span>
						<span class="description"><?php _e("Use the Thumbnail also for Admin purposes. This will use the selected Thumbnail to represent the Slide in all Slider Admin area.",'revslider'); ?></span>
					</p>
				</div>

				<!-- SLIDE ANIMATIONS -->
				<div id="slide-animation-settings-content" style="display:none">

					<!-- ANIMATION / TRANSITION -->
					<div id="slide_transition_row">
						<?php
							$slide_transition = RevSliderFunctions::getVal($slideParams, 'slide_transition',$def_transition);
							if(!is_array($slide_transition))
								$slide_transition = explode(',', $slide_transition);
							
							if(!is_array($slide_transition)) $slide_transition = array($slide_transition);
							$transitions = $operations->getArrTransition();
						?>
						<?php $slot_amount = (array) RevSliderFunctions::getVal($slideParams, 'slot_amount','default'); ?>
						<?php $transition_rotation = (array) RevSliderFunctions::getVal($slideParams, 'transition_rotation','0'); ?>
						<?php $transition_duration = (array) RevSliderFunctions::getVal($slideParams, 'transition_duration',$def_transition_duration); ?>
						<?php $transition_ease_in = (array) RevSliderFunctions::getVal($slideParams, 'transition_ease_in','default'); ?>
						<?php $transition_ease_out = (array) RevSliderFunctions::getVal($slideParams, 'transition_ease_out','default'); ?>
						<script type="text/javascript">
							var choosen_slide_transition = [];
							<?php
							$tr_count = count($slide_transition);
							foreach($slide_transition as $tr){
								echo 'choosen_slide_transition.push("'.$tr.'");'."\n";
							}
							?>
							var transition_settings = {
								'slot': [],
								'rotation': [],
								'duration': [],
								'ease_in': [],
								'ease_out': []
								};
							<?php
							foreach($slot_amount as $sa){
								echo 'transition_settings["slot"].push("'.$sa.'");'."\n";
							}
							$sac = count($slot_amount);
							if($sac < $tr_count){
								while($sac < $tr_count){
									$sac++;
									echo 'transition_settings["slot"].push("'.$slot_amount[0].'");'."\n";
								}
							}
							
							foreach($transition_rotation as $sa){
								echo 'transition_settings["rotation"].push("'.$sa.'");'."\n";
							}
							$sac = count($transition_rotation);
							if($sac < $tr_count){
								while($sac < $tr_count){
									$sac++;
									echo 'transition_settings["rotation"].push("'.$transition_rotation[0].'");'."\n";
								}
							}
							
							foreach($transition_duration as $sa){
								echo 'transition_settings["duration"].push("'.$sa.'");'."\n";
							}
							$sac = count($transition_duration);
							if($sac < $tr_count){
								while($sac < $tr_count){
									$sac++;
									echo 'transition_settings["duration"].push("'.$transition_duration[0].'");'."\n";
								}
							}
							
							foreach($transition_ease_in as $sa){
								echo 'transition_settings["ease_in"].push("'.$sa.'");'."\n";
							}
							$sac = count($transition_ease_in);
							if($sac < $tr_count){
								while($sac < $tr_count){
									$sac++;
									echo 'transition_settings["ease_in"].push("'.$transition_ease_in[0].'");'."\n";
								}
							}
							
							foreach($transition_ease_out as $sa){
								echo 'transition_settings["ease_out"].push("'.$sa.'");'."\n";
							}
							$sac = count($transition_ease_out);
							if($sac < $tr_count){
								while($sac < $tr_count){
									$sac++;
									echo 'transition_settings["ease_out"].push("'.$transition_ease_out[0].'");'."\n";
								}
							}
							
							?>
						</script>
						<div id="slide_transition"  multiple="" size="1" style="z-index: 100;">
							<?php
							if(!empty($transitions) && is_array($transitions)){
								$counter = 0;
								$optgroupexist = false;
								$transmenu = '<ul class="slide-trans-menu">';
								$lastclass = '';
								$transchecks ='';
								$listoftrans = '<div class="slide-trans-lists">';
								
								foreach($transitions as $tran_handle => $tran_name){

									$sel = (in_array($tran_handle, $slide_transition)) ? ' checked="checked"' : '';

									if (strpos($tran_handle, 'notselectable') !== false) {
										$listoftrans = $listoftrans.$transchecks;
										$lastclass = "slide-trans-".$tran_handle;
										$transmenu = $transmenu.'<li class="slide-trans-menu-element" data-reference="'.$lastclass.'">'.$tran_name.'</li>';
										$transchecks ='';		

									}
									else
										$transchecks = $transchecks.'<div class="slide-trans-checkelement '.$lastclass.'"><input name="slide_transition[]" type="checkbox" data-useval="true" value="'.$tran_handle.'"'.$sel.'>'.$tran_name.'</div>';							
								}

								$listoftrans = $listoftrans.$transchecks;
								$transmenu = $transmenu."</ul>";
								$listoftrans = $listoftrans."</div>";
								echo $transmenu;
								echo $listoftrans;							
							}
							?>
							
							<div class="slide-trans-example">
								<div class="slide-trans-example-inner">
									<div class="oldslotholder" style="overflow:hidden;width:100%;height:100%;position:absolute;top:0px;left:0px;z-index:1">
										<div class="tp-bgimg defaultimg slide-transition-example"></div>
									</div>
									<div class="slotholder" style="overflow:hidden;width:100%;height:100%;position:absolute;top:0px;left:0px;z-index:1">
										<div class="tp-bgimg defaultimg slide-transition-example"></div>
									</div>
								</div>
							</div>
							<div class="slide-trans-cur-selected">
								<p><?php _e("Used Transitions (Order in Loops)",'revslider'); ?></p>
								<ul class="slide-trans-cur-ul">
								</ul>
							</div>
							<div class="slide-trans-cur-selected-settings">
								<!-- SLOT AMOUNT -->
								
								<label><?php _e("Slot / Box Amount:",'revslider'); ?></label>
								<input type="text" class="small-text input-deepselects" id="slot_amount" name="slot_amount" value="<?php echo $slot_amount[0]; ?>" data-selects="1||Random||Custom||Default" data-svalues ="1||random||3||default" data-icons="thumbs-up||shuffle||wrench||key">
								<span class="tp-clearfix"></span>
								<span class="description"><?php _e("# of slots/boxes the slide is divided into or divided by.",'revslider'); ?></span>					
								<span class="tp-clearfix"></span>
								
								<!-- ROTATION -->
								
								<label><?php _e("Slot Rotation:",'revslider'); ?></label>
								<input type="text" class="small-text input-deepselects" id="transition_rotation" name="transition_rotation" value="<?php echo $transition_rotation[0]; ?>" data-selects="0||Random||Custom||Default||45||90||180||270||360" data-svalues ="0||random||-75||default||45||90||180||270||360" data-icons="thumbs-up||shuffle||wrench||key||star-empty||star-empty||star-empty||star-empty||star-empty">
								<span class="tp-clearfix"></span>
								<span class="description"><?php _e("Start Rotation of Transition (deg).",'revslider'); ?></span>
								<span class="tp-clearfix"></span>

								<!-- DURATION -->
								
								<label><?php _e("Animation Duration:",'revslider'); ?></label>
								<input type="text" class="small-text input-deepselects" id="transition_duration" name="transition_duration" value="<?php echo $transition_duration[0]; ?>" data-selects="300||Random||Custom||Default" data-svalues ="500||random||650||default" data-icons="thumbs-up||shuffle||wrench||key">
								<span class="tp-clearfix"></span>
								<span class="description"><?php _e("The duration of the transition.",'revslider'); ?></span>
								<span class="tp-clearfix"></span>

								<!-- IN EASE -->
								
								<label><?php _e("Easing In:",'revslider'); ?></label>
								<select name="transition_ease_in">
										<option value="default">Default</option>
										<option value="Linear.easeNone">Linear.easeNone</option>
										<option value="Power0.easeIn">Power0.easeIn  (linear)</option>
										<option value="Power0.easeInOut">Power0.easeInOut  (linear)</option>
										<option value="Power0.easeOut">Power0.easeOut  (linear)</option>
										<option value="Power1.easeIn">Power1.easeIn</option>
										<option value="Power1.easeInOut">Power1.easeInOut</option>
										<option value="Power1.easeOut">Power1.easeOut</option>
										<option value="Power2.easeIn">Power2.easeIn</option>
										<option value="Power2.easeInOut">Power2.easeInOut</option>
										<option value="Power2.easeOut">Power2.easeOut</option>
										<option value="Power3.easeIn">Power3.easeIn</option>
										<option value="Power3.easeInOut">Power3.easeInOut</option>
										<option value="Power3.easeOut">Power3.easeOut</option>
										<option value="Power4.easeIn">Power4.easeIn</option>
										<option value="Power4.easeInOut">Power4.easeInOut</option>
										<option value="Power4.easeOut">Power4.easeOut</option>
										<option value="Back.easeIn">Back.easeIn</option>
										<option value="Back.easeInOut">Back.easeInOut</option>
										<option value="Back.easeOut">Back.easeOut</option>
										<option value="Bounce.easeIn">Bounce.easeIn</option>
										<option value="Bounce.easeInOut">Bounce.easeInOut</option>
										<option value="Bounce.easeOut">Bounce.easeOut</option>
										<option value="Circ.easeIn">Circ.easeIn</option>
										<option value="Circ.easeInOut">Circ.easeInOut</option>
										<option value="Circ.easeOut">Circ.easeOut</option>
										<option value="Elastic.easeIn">Elastic.easeIn</option>
										<option value="Elastic.easeInOut">Elastic.easeInOut</option>
										<option value="Elastic.easeOut">Elastic.easeOut</option>
										<option value="Expo.easeIn">Expo.easeIn</option>
										<option value="Expo.easeInOut">Expo.easeInOut</option>
										<option value="Expo.easeOut">Expo.easeOut</option>
										<option value="Sine.easeIn">Sine.easeIn</option>
										<option value="Sine.easeInOut">Sine.easeInOut</option>
										<option value="Sine.easeOut">Sine.easeOut</option>
										<option value="SlowMo.ease">SlowMo.ease</option>
								</select>
								<span class="tp-clearfix"></span>
								<span class="description"><?php _e("The easing of Appearing transition.",'revslider'); ?></span>
								<span class="tp-clearfix"></span>

								<!-- OUT EASE -->
								
								<label><?php _e("Easing Out:",'revslider'); ?></label>
								<select name="transition_ease_out">
										<option value="default">Default</option>
										<option value="Linear.easeNone">Linear.easeNone</option>
										<option value="Power0.easeIn">Power0.easeIn  (linear)</option>
										<option value="Power0.easeInOut">Power0.easeInOut  (linear)</option>
										<option value="Power0.easeOut">Power0.easeOut  (linear)</option>
										<option value="Power1.easeIn">Power1.easeIn</option>
										<option value="Power1.easeInOut">Power1.easeInOut</option>
										<option value="Power1.easeOut">Power1.easeOut</option>
										<option value="Power2.easeIn">Power2.easeIn</option>
										<option value="Power2.easeInOut">Power2.easeInOut</option>
										<option value="Power2.easeOut">Power2.easeOut</option>
										<option value="Power3.easeIn">Power3.easeIn</option>
										<option value="Power3.easeInOut">Power3.easeInOut</option>
										<option value="Power3.easeOut">Power3.easeOut</option>
										<option value="Power4.easeIn">Power4.easeIn</option>
										<option value="Power4.easeInOut">Power4.easeInOut</option>
										<option value="Power4.easeOut">Power4.easeOut</option>
										<option value="Back.easeIn">Back.easeIn</option>
										<option value="Back.easeInOut">Back.easeInOut</option>
										<option value="Back.easeOut">Back.easeOut</option>
										<option value="Bounce.easeIn">Bounce.easeIn</option>
										<option value="Bounce.easeInOut">Bounce.easeInOut</option>
										<option value="Bounce.easeOut">Bounce.easeOut</option>
										<option value="Circ.easeIn">Circ.easeIn</option>
										<option value="Circ.easeInOut">Circ.easeInOut</option>
										<option value="Circ.easeOut">Circ.easeOut</option>
										<option value="Elastic.easeIn">Elastic.easeIn</option>
										<option value="Elastic.easeInOut">Elastic.easeInOut</option>
										<option value="Elastic.easeOut">Elastic.easeOut</option>
										<option value="Expo.easeIn">Expo.easeIn</option>
										<option value="Expo.easeInOut">Expo.easeInOut</option>
										<option value="Expo.easeOut">Expo.easeOut</option>
										<option value="Sine.easeIn">Sine.easeIn</option>
										<option value="Sine.easeInOut">Sine.easeInOut</option>
										<option value="Sine.easeOut">Sine.easeOut</option>
										<option value="SlowMo.ease">SlowMo.ease</option>
								</select>
								<span class="tp-clearfix"></span>
								<span class="description"><?php _e("The easing of Disappearing transition.",'revslider'); ?></span>
								
							</div>

						</div>
						
					</div>

					
				</div>
				
				<!-- SLIDE BASIC INFORMATION -->
				<div id="slide-nav-settings-content" style="display:none">		
					<ul class="rs-layer-nav-settings-tabs" style="display:inline-block; ">
						<li id="custom-nav-arrows-tab-selector" data-content="arrows" class="selected"><?php _e('Arrows', 'revslider'); ?></li>
						<li id="custom-nav-bullets-tab-selector" data-content="bullets"><?php _e('Bullets', 'revslider'); ?></li>					
						<li id="custom-nav-tabs-tab-selector" data-content="tabs"><?php _e('Tabs', 'revslider'); ?></li>
						<li id="custom-nav-thumbs-tab-selector" data-content="thumbs"><?php _e('Thumbnails', 'revslider'); ?></li>
					</ul>

					<div class="tp-clearfix"></div>



					<ul id="navigation-placeholder-wrapper">					
						<?php
						$ph_types = array('navigation_arrow_style' => 'arrows', 'navigation_bullets_style' => 'bullets', 'tabs_style' => 'tabs', 'thumbnails_style' => 'thumbs');
						foreach($ph_types as $phname => $pht){
							
							$ph_arr_type = $slider->getParam($phname,'');
							
							$ph_init = array();
							foreach($arr_navigations as $nav){
								if($nav['handle'] == $ph_arr_type){ //check for settings, placeholders
									if(isset($nav['settings']) && isset($nav['settings']['placeholders'])){
										foreach($nav['settings']['placeholders'] as $placeholder){
											if(empty($placeholder)) continue;
											
											$ph_vals = array();
											
											//$placeholder['type']
											foreach($placeholder['data'] as $k => $d){
												$get_from = RevSliderFunctions::getVal($slideParams, 'ph-'.$ph_arr_type.'-'.$pht.'-'.$placeholder['handle'].'-'.$k.'-slide', 'off');
												if($get_from == 'on'){ //get from Slide
													$ph_vals[$k] = RevSliderFunctions::getVal($slideParams, 'ph-'.$ph_arr_type.'-'.$pht.'-'.$placeholder['handle'].'-'.$k, $d);											
												}else{ ////get from Slider
													$ph_vals[$k] = $slider->getParam('ph-'.$ph_arr_type.'-'.$pht.'-'.$placeholder['handle'].'-'.$k, $d);											
												}
											}										
											?>
											<?php if ($placeholder['nav-type'] === $pht) { ?>
												<li class="custom-nav-types nav-type-<?php echo $placeholder['nav-type']; ?>">										
												<?php
												switch($placeholder['type']){
													case 'color':
														$get_from = RevSliderFunctions::getVal($slideParams, 'ph-'.$ph_arr_type.'-'.$pht.'-'.$placeholder['handle'].'-color-slide', 'off');
														?>
														<label><?php echo $placeholder['title']; ?></label>
														<input type="checkbox" class="tp-moderncheckbox" id="<?php echo 'ph-'.$ph_arr_type.'-'.$pht.'-'.$placeholder['handle'].'-color-slide'; ?>" name="<?php echo 'ph-'.$ph_arr_type.'-'.$pht.'-'.$placeholder['handle'].'-color-slide'; ?>" data-unchecked="off" <?php checked($get_from, 'on'); ?>>
														<input type="text" name="<?php echo 'ph-'.$ph_arr_type.'-'.$pht.'-'.$placeholder['handle'].'-color'; ?>" class="my-alphacolor-field" value="<?php echo $ph_vals['color']; ?>">																								
														<?php
													break;

													case 'color-rgba':
														$get_from = RevSliderFunctions::getVal($slideParams, 'ph-'.$ph_arr_type.'-'.$pht.'-'.$placeholder['handle'].'-color-rgba-slide', 'off');
														?>
														<label><?php echo $placeholder['title']; ?></label>
														<input type="checkbox" class="tp-moderncheckbox" id="<?php echo 'ph-'.$ph_arr_type.'-'.$pht.'-'.$placeholder['handle'].'-color-rgba-slide'; ?>" name="<?php echo 'ph-'.$ph_arr_type.'-'.$pht.'-'.$placeholder['handle'].'-color-rgba-slide'; ?>" data-unchecked="off" <?php checked($get_from, 'on'); ?>>
														<input type="text" name="<?php echo 'ph-'.$ph_arr_type.'-'.$pht.'-'.$placeholder['handle'].'-color-rgba'; ?>" class="my-alphacolor-field" value="<?php echo $ph_vals['color-rgba']; ?>">																								
														<?php
													break;
													case 'font-family':
														$get_from_font_family = RevSliderFunctions::getVal($slideParams, 'ph-'.$ph_arr_type.'-'.$pht.'-'.$placeholder['handle'].'-font_family-slide', 'off');
														?>
														<label><?php echo $placeholder['title']; ?></label>
														<input type="checkbox" class="tp-moderncheckbox" id="<?php echo 'ph-'.$ph_arr_type.'-'.$pht.'-'.$placeholder['handle'].'-font_family-slide'; ?>" name="<?php echo 'ph-'.$ph_arr_type.'-'.$pht.'-'.$placeholder['handle'].'-font_family-slide'; ?>" data-unchecked="off" <?php checked($get_from_font_family, 'on'); ?>>
														<select style="width: 140px;" name="<?php echo 'ph-'.$ph_arr_type.'-'.$pht.'-'.$placeholder['handle'].'-font_family'; ?>">
														<?php
														$font_families = $operations->getArrFontFamilys();
														foreach($font_families as $handle => $name){
															if($name['label'] == 'Dont Show Me') continue;
															
															echo '<option value="'. esc_attr($name['label']) .'"';
															if($ph_vals['font_family'] == esc_attr($name['label'])){
																echo ' selected="selected"';
															}
															echo '>'. esc_attr($name['label']) .'</option>';													
														}
														?>
														</select>												
														<?php
													break;
													case 'custom':
														$get_from_custom = RevSliderFunctions::getVal($slideParams, 'ph-'.$ph_arr_type.'-'.$pht.'-'.$placeholder['handle'].'-custom-slide', 'off');
														?>
														<label><?php echo $placeholder['title']; ?></label>
														<input type="checkbox" class="tp-moderncheckbox" id="<?php echo 'ph-'.$ph_arr_type.'-'.$pht.'-'.$placeholder['handle'].'-custom-slide'; ?>" name="<?php echo 'ph-'.$ph_arr_type.'-'.$pht.'-'.$placeholder['handle'].'-custom-slide'; ?>" data-unchecked="off" <?php checked($get_from_custom, 'on'); ?>>
														<input type="text" name="<?php echo 'ph-'.$ph_arr_type.'-'.$pht.'-'.$placeholder['handle'].'-custom'; ?>" value="<?php echo $ph_vals['custom']; ?>">												
														<?php
													break;
												}
												?>
												</li>
											<?php
											}
											?>
											<?php
										}
									}
									break;
								}
							}
						}
						?>
						
						
						
					</ul>
					<p style="margin-top:25px"><i><?php _e("The Custom Settings are always depending on the current selected Navigation Elements in Slider Settings, and will only be active on the current Slide.",'revslider'); ?></i></p>
					<script type="text/javascript">
						jQuery(document).ready(function() {
							if (jQuery('.custom-nav-types.nav-type-arrows').length==0)
								jQuery('#custom-nav-arrows-tab-selector').remove();

							if (jQuery('.custom-nav-types.nav-type-bullets').length==0)
								jQuery('#custom-nav-bullets-tab-selector').remove();

							if (jQuery('.custom-nav-types.nav-type-tabs').length==0)
								jQuery('#custom-nav-tabs-tab-selector').remove();

							if (jQuery('.custom-nav-types.nav-type-thumbs').length==0)
								jQuery('#custom-nav-thumbs-tab-selector').remove();

							if (jQuery('#navigation-placeholder-wrapper li').length==0) 
								jQuery('#main-menu-nav-settings-li').remove();
							
						
							jQuery('document').ready(function() {
								jQuery('.rs-layer-nav-settings-tabs li').click(function() {							
									var tn = jQuery(this);							
									jQuery('.custom-nav-types').hide();
									jQuery('.custom-nav-types.nav-type-'+tn.data('content')).show();
									jQuery('.rs-layer-nav-settings-tabs .selected').removeClass("selected");
									tn.addClass("selected");							
								});
							});
							setTimeout(function() {
								jQuery('.rs-layer-nav-settings-tabs li:nth-child(1)').click();	
							},100)
							
						});
					</script>
				</div>
				<?php
			}
			?>
			<!-- SLIDE ADDON WRAP -->
			<div id="slide-addon-wrapper" style="margin:-15px; display:none">
				<div id="rs-addon-wrapper-button-row">
					<span class="rs-layer-toolbar-box" style="padding:5px 20px"><?php _e('Select Add-on', 'revslider'); ?></span>
					<?php
					if(!empty($slide_general_addon)){
						foreach($slide_general_addon as $rs_addon_handle => $rs_addon){
							?>
							<span class="rs-layer-toolbar-box">
								<span id="rs-addon-settings-trigger-<?php echo esc_attr($rs_addon_handle); ?>" class="rs-addon-settings-trigger"><?php echo esc_attr($rs_addon['title']); ?></span>
							</span>
							<?php
						}
					}
					?>
				</div>
				<div style="border-top:1px solid #ddd;">
					<?php
					if(!empty($slide_general_addon)){
						foreach($slide_general_addon as $rs_addon_handle => $rs_addon){
							?>
							<div id="rs-addon-settings-trigger-<?php echo esc_attr($rs_addon_handle); ?>-settings" class="rs-addon-settings-wrapper-settings" style="display: none;">
								<?php echo $rs_addon['markup']; ?>
								<script type="text/javascript">
									<?php echo $rs_addon['javascript']; ?>
								</script>
							</div>
							<?php
						}
					}
					?>
					<script type="text/javascript">
						jQuery('.rs-addon-settings-trigger').click(function(){
							var show_addon = jQuery(this).attr('id');
							jQuery('.rs-addon-settings-trigger').removeClass("selected");
							jQuery(this).addClass("selected");
							jQuery('.rs-addon-settings-wrapper-settings').hide();
							jQuery('#'+show_addon+'-settings').show();
						});
					</script>
				</div>
			</div>
			<?php 
			if(!$slide->isStaticSlide()){
				?>
			
				<!-- SLIDE BASIC INFORMATION -->
				<div id="slide-info-settings-content" style="display:none">
					<ul>
						<?php
						for($i=1;$i<=10;$i++){
							?>
							<li>
								<label><?php _e('Parameter', 'revslider'); echo ' '.$i; ?></label> <input type="text" name="params_<?php echo $i; ?>" value="<?php echo stripslashes(esc_attr(RevSliderFunctions::getVal($slideParams, 'params_'.$i,''))); ?>">
								<?php _e('Max. Chars', 'revslider'); ?> <input type="text" style="width: 50px; min-width: 50px;" name="params_<?php echo $i; ?>_chars" value="<?php echo esc_attr(RevSliderFunctions::getVal($slideParams, 'params_'.$i.'_chars',10, RevSlider::FORCE_NUMERIC)); ?>">
								<?php if($slider_type !== 'gallery'){ ?><i class="eg-icon-pencil rs-param-meta-open" data-curid="<?php echo $i; ?>"></i><?php } ?>
							</li>
							<?php
						}
						?>
					</ul>
					
					<!-- BASIC DESCRIPTION -->
					<p>
						<?php $slide_description = stripslashes(RevSliderFunctions::getVal($slideParams, 'slide_description', '')); ?>
						<label><?php _e("Description of Slider:",'revslider'); ?></label>

						<textarea name="slide_description" style="height: 425px; width: 100%"><?php echo $slide_description; ?></textarea>
						<span class="description"><?php _e('Define a description here to show at the navigation if enabled in Slider Settings','revslider'); ?></span>
					</p>
				</div>

				<!-- SLIDE SEO INFORMATION -->
				<div id="slide-seo-settings-content" style="display:none">
					<!-- CLASS -->
					<p>
						<?php $class_attr = RevSliderFunctions::getVal($slideParams, 'class_attr',''); ?>
						<label><?php _e("Class:",'revslider'); ?></label>
						<input type="text" class="" id="class_attr" name="class_attr" value="<?php echo $class_attr; ?>">
						<span class="description"><?php _e('Adds a unique class to the li of the Slide like class="rev_special_class" (add only the classnames, seperated by space)','revslider'); ?></span>
					</p>

					<!-- ID -->
					<p>
						<?php $id_attr = RevSliderFunctions::getVal($slideParams, 'id_attr',''); ?>
						<label><?php _e("ID:",'revslider'); ?></label>
						<input type="text" class="" id="id_attr" name="id_attr" value="<?php echo $id_attr; ?>">
						<span class="description"><?php _e('Adds a unique ID to the li of the Slide like id="rev_special_id" (add only the id)','revslider'); ?></span>
					</p>

					<!-- CUSTOM FIELDS -->
					<p>
						<?php $data_attr = stripslashes(RevSliderFunctions::getVal($slideParams, 'data_attr','')); ?>
						<label><?php _e("Custom Fields:",'revslider'); ?></label>
						<textarea id="data_attr" name="data_attr"><?php echo $data_attr; ?></textarea>
						<span class="description"><?php _e('Add as many attributes as you wish here. (i.e.: data-layer="firstlayer" data-custom="somevalue").','revslider'); ?></span>
					</p>

					<!-- Enable Link -->
					<p>
						<?php $enable_link = RevSliderFunctions::getVal($slideParams, 'enable_link','false'); ?>
						<label><?php _e("Enable Link:",'revslider'); ?></label>
						<select id="enable_link" name="enable_link">
							<option value="true"<?php selected($enable_link, 'true'); ?>><?php _e("Enable",'revslider'); ?></option>
							<option value="false"<?php selected($enable_link, 'false'); ?>><?php _e("Disable",'revslider'); ?></option>
						</select>
						<span class="description"><?php _e('Link the Full Slide to an URL or Action.','revslider'); ?></span>
					</p>
					
					<div class="rs-slide-link-setting-wrapper">
						<!-- Link Type -->
						<p>
							<?php $enable_link = RevSliderFunctions::getVal($slideParams, 'link_type','regular'); ?>
							<label><?php _e("Link Type:",'revslider'); ?></label>
							<span style="display:inline-block; width:200px; margin-right:20px;">
								<input type="radio" id="link_type_1" value="regular" name="link_type"<?php checked($enable_link, 'regular'); ?>><span style="line-height:30px; vertical-align: middle; margin:0px 20px 0px 10px;"><?php _e('Regular','revslider'); ?></span>
								<input type="radio" id="link_type_2" value="slide" name="link_type"<?php checked($enable_link, 'slide'); ?>><span style="line-height:30px; vertical-align: middle; margin:0px 20px 0px 10px;"><?php _e('To Slide','revslider'); ?></span>
							</span>
							<span class="description"><?php _e('Regular - Link to URL,  To Slide - Call a Slide Action','revslider'); ?></span>
						</p>

						<div class="rs-regular-link-setting-wrap">
							<!-- SLIDE LINK -->
							<p>
								<?php $val_link = RevSliderFunctions::getVal($slideParams, 'link',''); ?>
								<label><?php _e("Slide Link:",'revslider'); ?></label>
								<input type="text" id="rev_link" name="link" value="<?php echo $val_link; ?>">
								<span class="description"><?php _e('A link on the whole slide pic (use {{link}} or {{meta:somemegatag}} in template sliders to link to a post or some other meta)','revslider'); ?></span>
							</p>
						
							<!-- LINK TARGET -->
							<p>
								<?php $link_open_in = RevSliderFunctions::getVal($slideParams, 'link_open_in','same'); ?>
								<label><?php _e("Link Target:",'revslider'); ?></label>
								<select id="link_open_in" name="link_open_in">
									<option value="same"<?php selected($link_open_in, 'same'); ?>><?php _e('Same Window','revslider'); ?></option>
									<option value="new"<?php selected($link_open_in, 'new'); ?>><?php _e('New Window','revslider'); ?></option>
								</select>
								<span class="description"><?php _e('The target of the slide link.','revslider'); ?></span>
							</p>
						</div>
						<!-- LINK TO SLIDE -->
						<p class="rs-slide-to-slide">
							<?php $slide_link = RevSliderFunctions::getVal($slideParams, 'slide_link','nothing');
							//num_slide_link
							$arrSlideLink = array();
							$arrSlideLink["nothing"] = __("-- Not Chosen --",'revslider');
							$arrSlideLink["next"] = __("-- Next Slide --",'revslider');
							$arrSlideLink["prev"] = __("-- Previous Slide --",'revslider');

							$arrSlideLinkLayers = $arrSlideLink;
							$arrSlideLinkLayers["scroll_under"] = __("-- Scroll Below Slider --",'revslider');
							$arrSlideNames = array();
							if(isset($slider) && $slider->isInited())
								$arrSlideNames = $slider->getArrSlideNames();
							if(!empty($arrSlideNames) && is_array($arrSlideNames)){
								foreach($arrSlideNames as $slideNameID=>$arr){
									$slideName = $arr["title"];
									$arrSlideLink[$slideNameID] = $slideName;
									$arrSlideLinkLayers[$slideNameID] = $slideName;
								}
							}
							?>
							<label><?php _e("Link To Slide:",'revslider'); ?></label>
							<select id="slide_link" name="slide_link">
								<?php
								if(!empty($arrSlideLinkLayers) && is_array($arrSlideLinkLayers)){
									foreach($arrSlideLinkLayers as $link_handle => $link_name){
										$sel = ($link_handle == $slide_link) ? ' selected="selected"' : '';
										echo '<option value="'.$link_handle.'"'.$sel.'>'.$link_name.'</option>';
									}
								}
								?>
							</select>
							<span class="description"><?php _e('Call Slide Action','revslider'); ?></span>
						</p>
						<!-- Link POSITION -->
						<p>
							<?php $link_pos = RevSliderFunctions::getVal($slideParams, 'link_pos','front'); ?>
							<label><?php _e("Link Sensibility:",'revslider'); ?></label>
							<span style="display:inline-block; width:200px; margin-right:20px;">
								<input type="radio" id="link_pos_1" value="front" name="link_pos"<?php checked($link_pos, 'front'); ?>><span style="line-height:30px; vertical-align: middle; margin:0px 20px 0px 10px;"><?php _e('Front','revslider'); ?></span>
								<input type="radio" id="link_pos_2" value="back" name="link_pos"<?php checked($link_pos, 'back'); ?>><span style="line-height:30px; vertical-align: middle; margin:0px 20px 0px 10px;"><?php _e('Back','revslider'); ?></span>
							</span>
							<span class="description"><?php _e('The z-index position of the link related to layers','revslider'); ?></span>
						</p>
					</div>
				</div>
			<?php
			}
			?>

		</form>

	</div>
</div>
<script type="text/javascript">
	var rs_plugin_url = '<?php echo RS_PLUGIN_URL; ?>';
	
	jQuery('document').ready(function() {
		jQuery('.my-alphacolor-field').alphaColorPicker();
		jQuery('#enable_link').change(function(){
			if(jQuery(this).val() == 'true'){
				jQuery('.rs-slide-link-setting-wrapper').show();
			}else{
				jQuery('.rs-slide-link-setting-wrapper').hide();
			}
		});
		jQuery('#enable_link option:selected').change();
		
		jQuery('input[name="link_type"]').change(function(){
			if(jQuery(this).val() == 'regular'){
				jQuery('.rs-regular-link-setting-wrap').show();
				jQuery('.rs-slide-to-slide').hide();
			}else{
				jQuery('.rs-regular-link-setting-wrap').hide();
				jQuery('.rs-slide-to-slide').show();
			}
		});
		jQuery('input[name="link_type"]:checked').change();
		
	});
</script>