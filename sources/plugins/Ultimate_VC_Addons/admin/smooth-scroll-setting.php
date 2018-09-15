<?php
	if(isset($_GET['author']))
		$author = true;
	else
		$author = false;
	$author_extend = '';
	if($author)
		$author_extend = '&author';
?>

<div class="wrap about-wrap bsf-page-wrapper ultimate-smooth-scroll bend">
  <div class="wrap-container">
    <div class="bend-heading-section ultimate-header">
      <h1><?php _e( "Ultimate Addons Settings", "ultimate_vc" ); ?></h1>
      <h3><?php _e( "The smooth scroll will change the built-in scroll effect of browsers. It is mostly used in combination with parallax effects.", "ultimate_vc" ); ?></h3>
      <div class="bend-head-logo">
        <div class="bend-product-ver">
          <?php _e( "Version", "ultimate_vc" ); echo ' '.ULTIMATE_VERSION; ?>
        </div>
      </div>
    </div><!-- bend-heading section -->

    <div id="msg"></div>
    <div id="bsf-message"></div>

    <div class="bend-content-wrap">
      <div class="smile-settings-wrapper">
	        <h2 class="nav-tab-wrapper">
		    	<a href="<?php echo admin_url('admin.php?page=about-ultimate'.$author_extend); ?>" data-tab="about-ultimate" class="nav-tab"> <?php echo __('About','ultimate_vc'); ?> </a>
		    	<a href="<?php echo admin_url('admin.php?page=ultimate-dashboard'.$author_extend); ?>" data-tab="ultimate-modules" class="nav-tab"> <?php echo __('Modules','ultimate_vc'); ?> </a>
		    	<a href="<?php echo admin_url('admin.php?page=ultimate-smoothscroll'.$author_extend); ?>" data-tab="css-settings" class="nav-tab nav-tab-active"> <?php echo __('Smooth Scroll','ultimate_vc'); ?> </a>
		        <a href="<?php echo admin_url('admin.php?page=ultimate-scripts-and-styles'.$author_extend); ?>" data-tab="css-settings" class="nav-tab"> <?php echo __('Scripts and Styles','ultimate_vc'); ?> </a>
		        <?php if($author) : ?>
					<a href="<?php echo admin_url('admin.php?page=ultimate-debug-settings'); ?>" data-tab="ultimate-debug" class="nav-tab"> Debug </a>
				<?php endif; ?>
		    </h2>
      </div><!-- smile-settings-wrapper -->

      </hr>

	<div class="container ultimate-content">
        <div class="col-md-12">
		    <?php
			$ultimate_smooth_scroll = get_option('ultimate_smooth_scroll');
			$ultimate_smooth_scroll_options = get_option('ultimate_smooth_scroll_options');

			$checked = '';

			if($ultimate_smooth_scroll == "enable"){
				$ultimate_smooth_scroll_attr = 'checked="checked"';
			} else {
				$ultimate_smooth_scroll_attr = '';
			}

			?>
		    <div id="ultimate-settings" class="ult-tabs active-tab">
		    <form method="post" id="ultimate_settings">
		    	<input type="hidden" name="action" value="update_ultimate_options" />
		    	<table class="form-table">
		        	<tbody>
		                <tr valign="top">
		                	<th scope="row"><?php echo __("Smooth Scroll","ultimate_vc"); ?></th>
		                    <td>
		                    	<div class="onoffswitch">
			                    	<input type="checkbox" <?php echo $ultimate_smooth_scroll_attr; ?> id="ultimate_smooth_scroll" value="enable" class="onoffswitch-checkbox" name="ultimate_smooth_scroll" />
			                        <label class="onoffswitch-label" for="ultimate_smooth_scroll">
			                            <div class="onoffswitch-inner">
			                                <div class="onoffswitch-active">
			                                    <div class="onoffswitch-switch"><?php echo __('ON','ultimate_vc'); ?></div>
			                                </div>
			                                <div class="onoffswitch-inactive">
			                                    <div class="onoffswitch-switch"><?php echo __('OFF','ultimate_vc'); ?></div>
			                                </div>
			                            </div>
			                        </label>
		                        </div>
		                    </td>
		                </tr>
		                <tr class="ult-smooth-options" style="<?php echo ($ultimate_smooth_scroll !== 'enable') ? 'display:none' : '' ?>">
		                	<th><label>Step: </label></th>
		                	<td>
		                        <div id="ult-smooth-options" >
		                        	<div>
		                        		<input type="text" name="ultimate_smooth_scroll_options[step]" value="<?php echo (isset($ultimate_smooth_scroll_options['step'])) ? $ultimate_smooth_scroll_options['step'] : '' ?>" placeholder="80" />
		                        		<span class="dashicons dashicons-editor-help bsf-has-tip" title="The speed of the scrolling effect with a mouse wheel." data-position="right"></span>
		                        	</div>
		                        </div>
							</td>
		                </tr>
		                <tr class="ult-smooth-options" style="<?php echo ($ultimate_smooth_scroll !== 'enable') ? 'display:none' : '' ?>">
		                	<th><label>Scroll Speed: </label></th>
		                	<td>
		                		<div id="ult-smooth-options">
		                        	<div>
		                        		<input type="text" name="ultimate_smooth_scroll_options[speed]" value="<?php echo (isset($ultimate_smooth_scroll_options['speed'])) ? $ultimate_smooth_scroll_options['speed'] : '' ?>" placeholder="480" />
		                        		<span class="dashicons dashicons-editor-help bsf-has-tip" title="The speed of the scrolling effect." data-position="right"></span>
		                        	</div>
		                        </div>
		                	</td>
		                </tr>
		            </tbody>
		        </table>
		    </form>
			<p class="submit"><input type="submit" name="submit" id="submit-settings" class="button button-primary" value="<?php echo __("Save Changes","ultimate");?>"></p>
		    </div>
		</div> <!--col-md-12 -->
      </div> <!-- ultimate-content -->
    </div> <!-- bend-content-wrap -->
  </div> <!-- .wrap-container -->
</div> <!-- .bend -->

<script type="text/javascript">

var submit_btn = jQuery("#submit-settings");
submit_btn.bind('click',function(e){
	e.preventDefault();
	var data = jQuery("#ultimate_settings").serialize();
	console.log(data);
	jQuery.ajax({
		url: ajaxurl,
		data: data,
		dataType: 'html',
		type: 'post',
		success: function(result){
			result = jQuery.trim(result);
			console.log(result);
			if(result == "success"){
				jQuery("#msg").html('<div class="updated"><p><?php echo __('Settings updated successfully!','ultimate_vc'); ?></p></div>');
			} else {
				jQuery("#msg").html('<div class="error"><p><?php echo __('No settings were updated.','ultimate_vc'); ?></p></div>');
			}
		}
	});
});

jQuery(document).ready(function(e) {

	jQuery('.onoffswitch').on('onUltimateSwitchClick',function(){
		setTimeout(function(){
			var is_smooth_scroll = (jQuery('#ultimate_smooth_scroll').is(':checked')) ? true : false;
			var is_smooth_scroll_compatible = (jQuery('#ultimate_smooth_scroll_compatible').is(':checked')) ? true : false;
			if(is_smooth_scroll) {
				if(!is_smooth_scroll_compatible) {
					jQuery('.ult-smooth-options').fadeIn(200);
				}
				else {
					jQuery('.ult-smooth-options').fadeOut(200);
				}
			}
			else {
				jQuery('.ult-smooth-options').fadeOut(200);
			}
		},300);
	});

	jQuery('.onoffswitch').click(function(){
		$switch = jQuery(this);
		setTimeout(function(){
			if($switch.find('.onoffswitch-checkbox').is(':checked'))
				$switch.find('.onoffswitch-checkbox').attr('checked',false);
			else
				$switch.find('.onoffswitch-checkbox').attr('checked',true);
			$switch.trigger('onUltimateSwitchClick');
		},300);

	});
});
</script>
<style type="text/css">
/*On Off Checkbox Switch*/
.onoffswitch {
	position: relative;
	width: 95px;
	display: inline-block;
	float: left;
	margin-right: 15px;
	-webkit-user-select:none;
	-moz-user-select:none;
	-ms-user-select: none;
}
.onoffswitch-checkbox {
	display: none !important;
}
.onoffswitch-label {
	display: block;
	overflow: hidden;
	cursor: pointer;
	border: 0px solid #999999;
	border-radius: 0px;
}
.onoffswitch-inner {
	width: 200%;
	margin-left: -100%;
	-moz-transition: margin 0.3s ease-in 0s;
	-webkit-transition: margin 0.3s ease-in 0s;
	-o-transition: margin 0.3s ease-in 0s;
	transition: margin 0.3s ease-in 0s;
}
.rtl .onoffswitch-inner{
	margin: 0;
}
.rtl .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
	margin-right: -100%;
	margin-left:auto;
}
.onoffswitch-inner > div {
	float: left;
	position: relative;
	width: 50%;
	height: 24px;
	padding: 0;
	line-height: 24px;
	font-size: 12px;
	color: white;
	font-weight: bold;
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
	box-sizing: border-box;
}
.onoffswitch-inner .onoffswitch-active {
	padding-left: 15px;
	background-color: #CCCCCC;
	color: #FFFFFF;
}
.onoffswitch-inner .onoffswitch-inactive {
	padding-right: 15px;
	background-color: #CCCCCC;
	color: #FFFFFF;
	text-align: right;
}
.onoffswitch-switch {
	/*width: 50px;*/
	width:35px;
	margin: 0px;
	text-align: center;
	border: 0px solid #999999;
	border-radius: 0px;
	position: absolute;
	top: 0;
	bottom: 0;
}
.onoffswitch-active .onoffswitch-switch {
	background: #3F9CC7;
	left: 0;
}
.onoffswitch-inactive .onoffswitch-switch {
	background: #7D7D7D;
	right: 0;
}
.onoffswitch-active .onoffswitch-switch:before {
	content: " ";
	position: absolute;
	top: 0;
	/*left: 50px;*/
	left:35px;
	border-style: solid;
	border-color: #3F9CC7 transparent transparent #3F9CC7;
	/*border-width: 12px 8px;*/
	border-width: 15px;
}
.onoffswitch-inactive .onoffswitch-switch:before {
	content: " ";
	position: absolute;
	top: 0;
	/*right: 50px;*/
	right:35px;
	border-style: solid;
	border-color: transparent #7D7D7D #7D7D7D transparent;
	/*border-width: 12px 8px;*/
	border-width: 50px;
}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
	margin-left: 0;
}
#ultimate-settings, #ultimate-modules, .ult-tabs{ display:none; }
#ultimate-settings.active-tab, #ultimate-modules.active-tab, .ult-tabs.active-tab{ display:block; }
.ult-badge {
	padding-bottom: 10px;
	height: 170px;
	width: 150px;
	position: absolute;
	border-radius: 3px;
	top: 0;
	right: 0;
}
div#msg > .updated, div#msg > .error { display:block !important;}
div#msg {
	position: absolute;
	left: 20px;
	top: 140px;
	max-width: 30%;
}
.onoffswitch-inner:before,
.onoffswitch-inner:after {
    display:none
}
.onoffswitch-switch {
    height: initial !important;
	color: white !important;
}
</style>
