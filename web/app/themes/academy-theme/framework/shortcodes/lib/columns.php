<?php

// - - - - - - - - - -
// Columns
// - - - - - - - - - -

function vntd_one_half($atts, $content=null) {
	extract(shortcode_atts(array("last" => ''), $atts));
	
	if(($atts[0] == 'last')) {
		$first_class = " vntd-span-last";
		$last = '<div class="vntd-clearcols"></div>';
	}
	
	return '<div class="vntd-span6'.$first_class.'">'.$content.'</div>'.$last;
}

function vntd_one_third($atts, $content=null) {
	extract(shortcode_atts(array("last" => ''), $atts));
	
	if(($atts[0] == 'last')) {
		$first_class = " vntd-span-last";
		$last = '<div class="vntd-clearcols"></div>';
	}
	
	return vntd_do_shortcode('<div class="vntd-span4'.$first_class.'">'.$content.'</div>').$last;
}

function vntd_one_fourth($atts, $content=null) {
	extract(shortcode_atts(array("last" => ''), $atts));
	
	if(($atts[0] == 'last')) {
		$first_class = " vntd-span-last";
		$last = '<div class="vntd-clearcols"></div>';
	}
	
	return '<div class="vntd-span3'.$first_class.'">'.vntd_do_shortcode($content).'</div>'.$last;
}

function vntd_one_fifth($atts, $content=null) {
	extract(shortcode_atts(array("last" => ''), $atts));
	
	if(($atts[0] == 'last')) {
		$first_class = " vntd-span-last";
		$last = '<div class="vntd-clearcols"></div>';
	}
	
	return '<div class="vntd-span24'.$first_class.'">'.vntd_do_shortcode($content).'</div>'.$last;
}

function vntd_two_third($atts, $content=null) {
	extract(shortcode_atts(array("last" => ''), $atts));
	
	if(($atts[0] == 'last')) {
		$first_class = " vntd-span-last";
		$last = '<div class="vntd-clearcols"></div>';
	}
	
	return '<div class="vntd-span8'.$first_class.'">'.vntd_do_shortcode($content).'</div>'.$last;
}

function vntd_three_fourth($atts, $content=null) {
	extract(shortcode_atts(array("last" => ''), $atts));
	
	if(($atts[0] == 'last')) {
		$first_class = " vntd-span-last";
		$last = '<div class="vntd-clearcols"></div>';
	}
	
	return '<div class="vntd-span9'.$first_class.'">'.vntd_do_shortcode($content).'</div>'.$last;
}

add_shortcode('one_half', 'vntd_one_half');
add_shortcode('one_third', 'vntd_one_third');
add_shortcode('one_fourth', 'vntd_one_fourth');
add_shortcode('one_fifth', 'vntd_one_fifth');
add_shortcode('two_third', 'vntd_two_third');
add_shortcode('three_fourth', 'vntd_three_fourth');

// Shortcode init

function vntd_sc_columns()
{
	add_action('cs_init_bilder', 'vntd_columns_init_info');
	add_action('cs_init_shortcode','vntd_columns_init_bilder');
}

add_action('wp_cs_init','vntd_sc_columns');


// Shortcode Builder


function vntd_columns_init_info()
{
	cs_show_bilder(
		'columns',
		'Columns',
		'',
		''
	);
}

function vntd_columns_init_bilder($id)
{
	if($id == 'columns'):
		$out = '';
		ob_start(); 
		vntd_columns_builder();
		$out .= ob_get_contents(); 
		ob_end_clean();
		cs_show_shortcode($id,$out,'columns');
	endif;
}
	
function vntd_columns_builder()
{

?>

<div>
<div class="columns-right cs-c-right">
	<input type="hidden" data-cs-name="block" value="true">
	<div class="cs-settings admin-form">
		<div class="caretta-cf">
			<label>Select column layout</label>
				<select name="layout" data-cs-name="layout" class="select select-layout">
					<option value="layout_1" selected="selected">1/2 + 1/2</option>
					<option value="layout_2">1/3 + 1/3 + 1/3</option>		
					<option value="layout_3">2/3 + 1/3</option>	
					<option value="layout_4">1/3 + 2/3</option>			
					<option value="layout_5">1/4 + 1/4 + 1/4 + 1/4</option>
					<option value="layout_6">3/4 + 1/4</option>
					<option value="layout_7">1/4 + 3/4</option>
					<option value="layout_8">1/4 + 1/2 + 1/4</option>
					<option value="layout_9">1/5 + 1/5 + 1/5 + 1/5 + 1/5</option>
				</select>
		</div>
	</div>
	
</div>
<div class="columns-left cs-c-left">
	

	<script type="text/javascript">
	
	(function($){
	
		function ColumnsCallback(){
			console.log('Columns Callback');
		}
		
		carretaSetData('columns','callback',ColumnsCallback);
		
		function StyleSelect() {
		    
		    $('.select-layout').change(function() {			
		    	
		    	$('.layout-preview').empty();
		    	
		    	switch($(this).val()){
		    		case "layout_1":
		    			var layout = '<div class="column one-half">1/2</div><div class="column one-half">1/2</div>';
		    			break;
		    		case "layout_2":
		    			var layout = '<div class="column one-third">1/3</div><div class="column one-third">1/3</div><div class="column one-third">1/3</div>';
		    			break;
		    		case "layout_3":
		    			var layout = '<div class="column two-third">2/3</div><div class="column one-third">1/3</div>';
		    			break;
		    		case "layout_4":
		    			var layout = '<div class="column one-third">1/3</div><div class="column two-third">2/3</div>';
		    			break;
		    		case "layout_5":
		    			var layout = '<div class="column one-fourth">1/4</div><div class="column one-fourth">1/4</div><div class="column one-fourth">1/4</div><div class="column one-fourth">1/4</div>';
		    			break;
		    		case "layout_6":
		    			var layout = '<div class="column three-fourth">3/4</div><div class="column one-fourth">1/4</div>';
		    			break;
		    		case "layout_7":
		    			var layout = '<div class="column one-fourth">1/4</div><div class="column three-fourth">3/4</div>';
		    			break;
		    		case "layout_8":
		    			var layout = '<div class="column one-fourth">1/4</div><div class="column one-half">1/2</div><div class="column one-fourth">1/4</div>';
		    			break;
		    		case "layout_9":
		    			var layout = '<div class="column one-fifth">1/5</div><div class="column one-fifth">1/5</div><div class="column one-fifth">1/5</div><div class="column one-fifth">1/5</div><div class="column one-fifth">1/5</div>';
		    			break;
		    	}
		    	
		    	$('.layout-preview').append(layout);
		    	
		    });	
		}
		
		StyleSelect();

		
	})(jQuery)
	
	
	</script>
	
	
	</script>
	
	<style type="text/css">
		.column {
			float: left;
			box-sizing: border-box;
			margin-left: -1px;
			border: 1px solid #CCC;
			text-align: center;
			padding: 50px;
		}
		
		.one-half { width: 50%;	}
		.one-third { width: 33%; }
		.two-third { width: 66.5%; }
		.one-fourth { width: 25%; }
		.three-fourth { width: 75%; }
		.one-fifth { width: 20%; }

	</style>

	<div class="layout-preview">
		<div class="column one-half">
		1/2
		</div>		
		<div class="column one-half">
		1/2
		</div>
	</div>
	
</div>

<br clear="both"/>
</div>
<?php			
}
 