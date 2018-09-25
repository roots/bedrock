<?php

// Shortcode init

function vntd_progressbar()
{
	add_action('cs_init_bilder', 'vntd_progressbar_init_info');
	add_action('cs_init_shortcode','vntd_progressbar_init_bilder');
}

//add_action('wp_cs_init','vntd_progressbar');


// Shortcode Builder


function vntd_progressbar_init_info()
{
	cs_show_bilder(
		'progress_bar',
		'Progress Bar',
		'Just a progress bar. What else can I say?',
		''
	);
}

function vntd_progressbar_init_bilder($id)
{
	if($id == 'progress_bar'):
		$out = '';
		ob_start(); 
		vntd_progressbar_builder();
		$out .= ob_get_contents(); 
		ob_end_clean();
		cs_show_shortcode($id,$out,"short");
	endif;
}
	
function vntd_progressbar_builder()
{

?>
	
<script type="text/javascript">

(function($){

	function ProgressCallback(){
		console.log('Progress Callback');
	}
	
	carretaSetData('progress','callback',ProgressCallback);
	
	$('.of-color').each(function(){  	 		
		
	  	$(this).wpColorPicker({
	  		change: function(event, ui) {
	  			var dep = $(this).data('dependency');
	  			if(dep) {
	  				$("."+dep).css('background-color',ui.color.toString());
	  			}
	  		}
	  	});
	  	
	});
	
	
	function live_update(){
	
		$('input[name=percentage]').on('keyup change', function() {
			$('.progress').css("width",$(this).val()+"%");
		});	
		
		$('input[name=title]').on('keyup change', function() {
			$('.progress-title').text($(this).val());
		});	
		
		$('input[name=value]').on('keyup change', function() {
			$('.progress').text($(this).val());
		});		
		
		$('.select-style').change(function() {			
			if($(this).val()=="animated"){				
				$('.progress-strips').show();
			} else {
				$('.progress-strips').hide();
			}
		});
	}
	
	live_update();
	
	// Color
	
	$('.select-color').change(function() {	
		$('.progress').removeClass (function (index, css) {
		    return (css.match (/\bbar-color-\S+/g) || []).join(' ');
		});
		if($(this).val()=="custom"){		
			$('.bar-color-picker').slideDown();				
		} else {
			$('.progress').css("background-color", "");
			$('.bar-color-picker').slideUp();
			$('.progress').addClass("bar-color-"+$(this).val());
		}
	});

	
})(jQuery)


</script>

<style>

.bar-color-picker {
	display: none;
}

.bar-color-theme {
	background-color: <?php global $smof_data; echo $smof_data['vntd_leading_color']; ?> !important;
}

.bar-color-blue {
	background-color: #5CBBF5 !important;
}


.bar-color-red {
	background-color: #F14E4E !important;
}


.bar-color-orange {
	background-color: #FFBB3D !important;
}


.bar-color-green {
	background-color: #91D53B !important;
}


.bar-color-dark {
	background-color: #666 !important;
}

</style>

<div>
<div class="progress-bar-right cs-c-right">
	<div class="cs-settings admin-form">
		<div class="caretta-cf">
			<label>Title</label>
			<input type="text" name="title" value="WordPress" data-cs-name="title"/>
		</div>
		<div class="caretta-cf">
			<label>Value</label>
			<input type="text" name="value" value="80%" data-cs-name="value"/>
		</div>
		<div class="caretta-cf">
			<label>Percentage</label>
			<input type="text" name="progress" value="80" data-cs-name="progress"/>
		</div>
		<div class="caretta-cf">
			<label>Style</label>
				<select name="target" data-cs-name="style" class="select select-style">
					<option value="" selected="selected">Default</option>
					<option value="animated">Animated</option>
				</select>
		</div>
		<div class="caretta-cf">
			<label>Background Color</label>
			<select name="color" data-cs-name="color" class="select select-color">
				<option value="theme" selected="selected">Theme's Color</option>
				<option value="blue">Blue</option>					
				<option value="green">Green</option>
				<option value="orange">Orange</option>	
				<option value="red">Red</option>	
				<option value="dark">Dark</option>
				<option value="custom">Custom</option>			
			</select>
			<div class="bar-color-picker">
				<input name="custom_color" class="of-color" data-cs-name="custom_color" type="text" data-dependency="progress" data-default-color="#aaa" />
			</div>
		</div>
	</div>
	
</div>
<div class="progress-bar-left cs-c-left">
	
	<h3>Preview:</h3>
	<div class="shortcode-preview">
		
		<div class="vntd-pbar">
			<div class="vntd-pbar-labels"><span class="vntd-pbar-title">My Skill</span><span class="vntd-pbar-value">'.$value.$unit.'</span></div><div class="vntd-pbar-content"><span class="vntd-pbar-cover vntd-bgcolor-orange"></span></div>
			<div
			
		</div>
		
	</div>
	
</div>

<br clear="both"/>
</div>
<?php			
}


function vntd_progress_bar($atts){
	extract(shortcode_atts(array(
		"title" => '',
		"value" => '',
		"unit" => '',
		"color" => 'accent',
		"animated" => ''
	), $atts));
	
	if(strpos($color,'#') !== false) {
		$extra_styling = 'style="background-color:'.$color.' !important"';
	}
	
	if($animated == "yes") {
		$animated_class = ' vntd-pbar-animated';
	}

	return '<div class="vntd-pbar" data-progress="'.$value.'"><div class="vntd-pbar-labels"><span class="vntd-pbar-title">'.$title.'</span><span class="vntd-pbar-value">'.$value.$unit.'</span></div><div class="vntd-pbar-content"><span class="vntd-pbar-cover vntd-bgcolor-'.$color.$animated_class.'"'.$extra_styling.'></span></div></div>';
}
remove_shortcode('progress_bar');
add_shortcode('progress_bar', 'vntd_progress_bar');