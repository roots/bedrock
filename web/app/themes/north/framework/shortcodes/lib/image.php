<?php

// Shortcode init

function vntd_sc_image()
{
	add_action('cs_init_bilder', 'vntd_image_init_info');
	add_action('cs_init_shortcode','vntd_image_init_bilder');
}

add_action('wp_cs_init','vntd_sc_image');


// Shortcode Builder


function vntd_image_init_info()
{
	cs_show_bilder(
		'image',
		'Image',
		'',
		''
	);
}

function vntd_image_init_bilder($id)
{
	if($id == 'image'):
		$out = '';
		ob_start(); 
		vntd_image_builder();
		$out .= ob_get_contents(); 
		ob_end_clean();
		cs_show_shortcode($id,$out,"short");
	endif;
}
	
function vntd_image_builder()
{

?>

<script type="text/javascript">

(function($){

	function imageCallback(){
		console.log('image Callback');
	}		
	carretaSetData('image','callback',imageCallback);
	
	$('select.select-folds').change(function() {
		var val = $(this).val();
		var name = $(this).attr('name');
		$('.folds-'+name).hide();
		$('.folds-'+name+'.folds-'+name+'-'+val).fadeIn();		
	});
	
					
})(jQuery);
	
</script>

<style type="text/css">

.preview-fullwidth {
	width: 100%;
}

.centered-holder {
	text-align: center;
}

.insert-show {
	display: none;
}

.image-holder img {
	display: block;
	margin: 0 auto;
	margin-bottom: 30px;
	padding: 5px;
	border: 1px solid #ddd;
	border-radius: 2px;
}

.attachment-details,
.attachment-display-settings > *:nth-child(2),
.attachment-display-settings div.setting
{
	display: none;
}

</style>

<div>
<div class="image-right cs-c-right">
	
	<!-- Hidden field for the original image size URL and attachment ID -->
	<input type="hidden" name="image-url" data-cs-name="src" value="true">
	
	<div class="cs-settings admin-form">
			
		<div class="caretta-cf">
			<label>
				Image align		
				<i class="icon-question-sign tip-icon" title="Click for more information"></i>
			</label>
			
			<div class="tip-box">
				This is some information given for this shortcode attribute setting. It can be even longer than this. Much longer.
			</div>
			
				<select name="align" data-cs-name="align" class="select select-layout">
					<option value="none" selected="selected">No align</option>
					<option value="center">Center</option>		
					<option value="left">Left</option>	
					<option value="right">Right</option>			
				</select>			
		</div>
		
		<div class="caretta-cf">
			<label>On click action</label>
			<select name="onclick" data-cs-name="onclick" class="select select-folds">
				<option value="" selected="selected">None</option>
				<option value="link">Open link</option>	
				<option value="lightbox">Lightbox</option>		
			</select>
			<div class="to-fold folds-onclick folds-onclick-link">
				<input type="text" name="url" data-cs-name="link" value="http://">
			</div>
		</div>
		
		<div class="caretta-cf">
			<label>Image Animation on Appear?</label>
			<select name="animation" data-cs-name="animation" class="select select-folds">
				<option value="" selected="selected">No</option>
				<option value="yes">Yes</option>				
			</select>
			<div class="to-fold folds-animation folds-animation-yes">
			<label>Animation Side</label>
				<select name="animation_side" data-cs-name="animation_side" class="select select-link">
					<option value="left" selected="selected">Left</option>
					<option value="right">Right</option>				
				</select>
			</div>
		</div>
		
		<div class="caretta-cf insert-show">
			<label>Image size</label>
			<input type="text" name="image-size" value="" disabled>
		</div>
		
		
		
	</div>
	
</div>
<div class="image-left cs-c-left">

	<div class="preview-fullwidth">		
		<div class="centered-holder">			
			
			<div class="uploader-inline-content uploader-inline">
			
				<!-- No image placeholder -->
				<h3 class="upload-instructions no-image">No image has been selected</h3>
							
				<!-- Uploaded image -->
				<div class="image-holder insert-show">
					<img src="">
				</div>
			
				<a href="#" id="swopen-media-editor" class="browser button button-hero add-single-image" data-upload-type="single-image">Select Image</a>
			</div>
		</div>
	</div>
	
</div>

<br clear="both"/>
</div>
<?php			
}


// Shortcode Processing


function vntd_image($atts, $content=null) {
	extract(shortcode_atts(array(
		"src" => '',
		"style" => '1',
		"width" => '280',
		"align" => 'none',
		"caption" => '',
		"margin_top" => '',
		"margin_bottom" => '',
		"margin_left" => '',
		"margin_right" => '',
		"link" => 'no',
		"lightbox_src" => '',
		"animation" => '',
	), $atts));
	
	$extra_styling = 'style="width:300px;';
	
	if($margin_top) { $extra_styling .= 'margin-top:'.$margin_top.'px;';}
	if($margin_bottom) { $extra_styling .= 'margin-bottom:'.$margin_bottom.'px;';}
	if($margin_left) { $extra_styling .= 'margin-left:'.$margin_left.'px;';}
	if($margin_right) { $extra_styling .= 'margin-right:'.$margin_right.'px;';}
	
	if($caption) { $caption_markup = '<div class="vntd-image-caption">'.$caption.'</div>'; }
	$extra_styling .= '"';
	
	if($animation) { $animation_class = ' vntd-image-animated vntd_'.$animation; }
	
	if($lightbox_src) { 
		$link_start = '<a href="'.$lightbox_src.'" rel="prettyPhoto" title="'.$caption.'">';
		$link_end = '<span class="hover-overlay"></span><span class="hover-icon hover-icon-zoom"></span></a>';
	} elseif($link) {
		$link_start = '<a href="'.$link.'">';
		$link_end = '<span class="hover-overlay"></span><span class="hover-icon hover-icon-link"></span></a>'; 
	}
	
	if($lightbox_src || $link) {
		$hover_class = " hover-item";
	}
	
	
	$output = '<div class="vntd-image vntd-align-'.$align.' vntd-image-'.$style.$animation_class.$hover_class.'"'.$extra_styling.'>'.$link_start.'<img src="'.$src.'">'.$link_end.$caption_markup.'</div>';
	
	return $output;
}
add_shortcode('vd_image', 'vntd_image');  
