<?php

// Shortcode init

function vntd_sc_video()
{
	add_action('cs_init_bilder', 'vntd_video_init_info');
	add_action('cs_init_shortcode','vntd_video_init_bilder');
}

add_action('wp_cs_init','vntd_sc_video');


// Shortcode Builder


function vntd_video_init_info()
{
	cs_show_bilder(
		'video',
		'Video',
		'',
		''
	);
}

function vntd_video_init_bilder($id)
{
	if($id == 'video'):
		$out = '';
		ob_start(); 
		vntd_video_builder();
		$out .= ob_get_contents(); 
		ob_end_clean();
		cs_show_shortcode($id,$out,"short");
	endif;
}
	
function vntd_video_builder()
{

?>


<script type="text/javascript">

(function($){

	function imageCallback(){
		console.log('image Callback');
	}		
	carretaSetData('image','callback',imageCallback);
	
	$('.select_wrapper').each(function () {
	  $(this).prepend('<span>' + $(this).find('.select option:selected').text() + '</span>');
	});	
	
			
})(jQuery);




</script>


</script>

<style type="text/css">

.preview-fullwidth {
	width: 100%;
}

.centered-holder {
	text-align: center;
}

.image-holder {
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

</style>

<div>
<div class="video-right cs-c-right">

	<input type="hidden" name="self_hosted" data-cs-name="self_hosted" value="">
	<div class="cs-settings admin-form">
		<div class="caretta-cf">
			<label>
				Video URL		
				<i class="icon-question-sign tip-icon" title="Click for more information"></i>
			</label>
			
			<div class="tip-box">
				You may either upload a video or just insert it's URL into this field. List of supported sites can be found <a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">here</a>. 
			</div>
			<input type="text" name="url" data-cs-name="url" value="http://vimeo.com/22439234">
		</div>
		
		<div class="caretta-cf">
			<label>Width <i class="icon-question-sign tip-icon" title="Click for more information"></i></label>
			<div class="tip-box">Leave blank for auto width</div>
			<input type="text" name="width" data-cs-name="width" value="">
		</div>
		
	</div>
	
</div>
<div class="video-left cs-c-left">

	<div class="preview-fullwidth">		
		<div class="centered-holder">			
			
			<div class="uploader-inline-content uploader-inline">
			
				<!-- No image placeholder -->
				<h3 class="upload-instructions no-image">No video has been selected</h3>
							
				<!-- Video thumbnail -->
				<div class="image-holder">
					<img src="">
				</div>
			
				<a href="#" class="browser button button-hero add-video">Select Video</a>
			</div>
		</div>
	</div>
	
</div>

<br clear="both"/>
</div>
<?php			
}


// Shortcode Processing


function vntd_video($atts, $content=null) {
	extract(shortcode_atts(array(
		"width" => '',
		"url" => '',
		"self_hosted" => ''
	), $atts));
	
	if(!$width && !$self_hosted || $width == "full") {
		$start = '<div class="video-container">';
		$end = '</div>';
	} elseif($width && $self_hosted) {
		$width_att = 'width="'.$width.'"';
	}
	
	if($self_hosted){
		$return .= '<video src="'.$url.'" controls="controls" '.$width_att.'></video>';
	} else {
		$return .= $start.wp_oembed_get($url, array('width'=>$width)).$end;
	}
	
	return $return;
}
remove_shortcode('video');
add_shortcode('video', 'vntd_video');  