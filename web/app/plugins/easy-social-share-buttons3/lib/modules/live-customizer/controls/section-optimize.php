<?php
if (!class_exists('ESSBLiveCustomizerControls')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/live-customizer/controls/controls.php');
}

$use_minified_css = essb_option_value('use_minified_css');
$use_minified_js = essb_option_value('use_minified_js');
$load_js_async = essb_option_value('load_js_async');
$precompiled_resources = essb_option_value('precompiled_resources');

?>
<div class="section-optimize">
<div class="row field">
	Use minified CSS files
</div>
<div class="row">
		<?php 
		ESSBLiveCustomizerControls::draw_switch_field2('use_minified_css', $use_minified_css, 'options', 'use_minified_css');
		?>
</div>
<div class="row description">
	This option will allow plugin use pre-minified version of styles. Recommended to be active.
</div>

<div class="row field">
	Use minified Javascript files
</div>
<div class="row">
		<?php 
		ESSBLiveCustomizerControls::draw_switch_field2('use_minified_js', $use_minified_js, 'options', 'use_minified_js');
		?>
</div>
<div class="row description">
	This option will allow plugin use pre-minified version of javascript files. Recommended to be active.
</div>

<div class="row field">
	Optimize load of all scripts
</div>
<div class="row">
		<?php 
		ESSBLiveCustomizerControls::draw_switch_field2('load_js_async', $load_js_async, 'options', 'load_js_async');
		?>
</div>
<div class="row description">
	Activate this option to allow optimized load of all scripts. Many cache pugins also has option for this and if you have such there is no need to activate ours too.
</div>


<div class="row field">
	Join all static resources into single file
</div>
<div class="row">
		<?php 
		ESSBLiveCustomizerControls::draw_switch_field2('precompiled_resources', $precompiled_resources, 'options', 'precompiled_resources');
		?>
</div>
<div class="row description">
	Very useful option that will collect and save all resources into single files. This mode is not suitable for complex layouts with different visual display settings by posts or advanced shortcode usage. In case you experience problems with plugin functionality after activation than please deactivate it.
	<br/>
	Note that cache plugins if you use such may also have such function - check first and if yours is such you does not need to activate this option.
</div>
	<div class="row">
		<a href="#" class="essb-composer-button essb-composer-blue essb-section-save" data-section="section-optimize"><i class="fa fa-save"></i> Save Settings</a>
	</div>
</div>

<script type="text/javascript">

function essbLiveCustomizerPostLoad() {


	jQuery('.essb-live-customizer .switch').change(function(){
	    jQuery(this).toggleClass('checked');

	    if (jQuery(this).hasClass('social_proof_enable')) {
		    if (jQuery(this).hasClass('checked'))
		    	jQuery('.avoid-negative-proof').fadeIn();
		    else
		    	jQuery('.avoid-negative-proof').fadeOut();
	    }
	  });
}
		
</script>