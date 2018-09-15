<?php
	if(isset($_GET['author']))
		$author = true;
	else
		$author = false;
	$author_extend = '';
	if($author)
		$author_extend = '&author';
?>

<?php
    $ultimate_row = get_option('ultimate_row');
    if($ultimate_row == "enable"){
		$checked_row = 'checked="checked"';
	} else {
		$checked_row = '';
	}

	$ultimate_modules = get_option('ultimate_modules');
	$modules = array(
		'Ultimate_Animation' => 'Animation Block',
		'Ultimate_Buttons' => 'Advanced Buttons',
		'Ultimate_CountDown' => 'Count Down Timer',
		'Ultimate_Flip_Box' => 'Flip Boxes',
		'Ultimate_Google_Maps' => 'Google Maps',
		'Ultimate_Google_Trends' => 'Google Trends',
		'Ultimate_Headings' => 'Headings',
		'Ultimate_Icon_Timeline' => 'Timeline',
		'Ultimate_Info_Box' => 'Info Boxes',
		'Ultimate_Info_Circle' => 'Info Circle',
		'Ultimate_Info_List' => 'Info List',
		'Ultimate_Info_Tables' => 'Info Tables',
		'Ultimate_Interactive_Banners' => 'Interactive Banners',
		'Ultimate_Interactive_Banner_2' => 'Interactive Banners - 2',
		'Ultimate_Modals' => 'Modal Popups',
		'Ultimate_Pricing_Tables' => 'Price Box',
		'Ultimate_Spacer' => 'Spacer / Gap',
		'Ultimate_Stats_Counter' => 'Stats Counter',
		'Ultimate_Swatch_Book' => 'Swatch Book',
		'Ultimate_Icons' => 'Icons',
		'Ultimate_List_Icon' => 'List Icons',
		'Ultimate_Carousel'  => 'Advanced Carousel',
		'Ultimate_Fancy_Text'  => 'Fancy Text',
		'Ultimate_Hightlight_Box'  => 'Highlight Box',
		'Ultimate_Info_Banner' => 'Info Banner',
		'Ultimate_iHover'  => 'iHover',
		'Ultimate_Hotspot'  => 'Hotspot',
		'Ultimate_Video_Banner'  => 'Video Banner',
		'WooComposer' => 'WooComposer',
		'Ultimate_Dual_Button' => 'Dual Button',
		'Ultimate_link' => 'Creative Link',
		'Ultimate_Image_Separator' => 'Image Separator',
		'Ultimate_Content_Box' => 'Content Box',
		'Ultimate_Expandable_section' => 'Expandable Section',
		'Ultimate_Tab' =>'Advanced Tabs',
		'Ultimate_Team' =>'Ultimate Teams',
		'Ultimate_Sticky_Section' => 'Sticky Section',
		'Ultimate_Range_Slider' => 'Range Slider',
	);
?>

<div class="wrap about-wrap bsf-page-wrapper ultimate-modules bend">
  <div class="wrap-container">
    <div class="bend-heading-section ultimate-header">
      <h1><?php _e( "Ultimate Addons Settings", "ultimate_vc" ); ?></h1>
      <h3><?php _e( "Ultimate Addons is designed in a very modular fashion so that most the features would be independent of each other. For any reason, should you wish to disable some features, you can do it very easily below.", "ultimate_vc" ); ?></h3>
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
	    	<a href="<?php echo admin_url('admin.php?page=ultimate-dashboard'.$author_extend); ?>" data-tab="ultimate-modules" class="nav-tab nav-tab-active"> <?php echo __('Modules','ultimate_vc'); ?> </a>
	    	<a href="<?php echo admin_url('admin.php?page=ultimate-smoothscroll'.$author_extend); ?>" data-tab="css-settings" class="nav-tab"> <?php echo __('Smooth Scroll','ultimate_vc'); ?> </a>
	        <a href="<?php echo admin_url('admin.php?page=ultimate-scripts-and-styles'.$author_extend); ?>" data-tab="css-settings" class="nav-tab"> <?php echo __('Scripts and Styles','ultimate_vc'); ?> </a>
	        <?php if($author) : ?>
				<a href="<?php echo admin_url('admin.php?page=ultimate-debug-settings'); ?>" data-tab="ultimate-debug" class="nav-tab"> Debug </a>
			<?php endif; ?>
	    </h2>
      </div><!-- smile-settings-wrapper -->

      </hr>

	<div class="container ultimate-content">
        <div class="col-md-12">
		    <div id="ultimate-modules" class="ult-tabs active-tab">
		    	<br/>
			    <div>
				    <input type="checkbox" id="ult-all-modules-toggle" data-all="<?php echo count($modules) ?>" value="checkall" /> <label for="ult-all-modules-toggle"><?php echo __('Enable/Disable All', 'ultimate_vc') ?></label>
				</div>
			    <form method="post" id="ultimate_modules">
			    	<input type="hidden" name="action" value="update_ultimate_modules" />
			    	<table class="form-table">
			        	<tbody>
			            	<?php
								$i = 1;
								$checked_items = 0;
								foreach($modules as $module => $label){
									if(is_array($ultimate_modules) && !empty($ultimate_modules)){
										if(in_array(strtolower($module),$ultimate_modules)){
											$checked = 'checked="checked"';
											$checked_items++;
										} else {
											$checked = '';
										}
									}
									if(($i % 2) == 1){
									?>
									<tr valign="top" style="border-bottom: 1px solid #ddd;">
									<?php } ?>
										<th scope="row"><?php echo $label; ?></th>
										<td>
										<div class="onoffswitch">
											<input type="checkbox" <?php echo $checked; ?> class="onoffswitch-checkbox" value="<?php echo strtolower($module); ?>" id="<?php echo strtolower($module); ?>" name="ultimate_modules[]" />

											<label class="onoffswitch-label" for="<?php echo strtolower($module); ?>">
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
									<?php if(($i % 2) == 1){ ?>
									<!-- </tr> -->
									<?php } ?>
			                <?php $i++; } ?>
			                <tr valign="top" style="border-bottom: 1px solid #ddd;">
			                	<th scope="row"><?php echo __("Row backgrounds","ultimate_vc"); ?></th>
			                    <td> <div class="onoffswitch">
			                    <input type="checkbox" <?php echo $checked_row; ?> id="ultimate_row" value="enable" class="onoffswitch-checkbox" name="ultimate_row" />
			                         <label class="onoffswitch-label" for="ultimate_row">
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
								<th></th><td></td>
			                </tr>
			            </tbody>
			        </table>
			    </form>
				<p class="submit"><input type="submit" name="submit" id="submit-modules" class="button button-primary" value="<?php echo __("Save Changes","ultimate_vc");?>"></p>
		    </div> <!-- #ultimate-modules -->
		</div> <!--col-md-12 -->
      </div> <!-- ultimate-content -->
    </div> <!-- bend-content-wrap -->
  </div> <!-- .wrap-container -->
</div> <!-- .bend -->

<script type="text/javascript">
var submit_btn = jQuery("#submit-modules");
submit_btn.bind('click',function(e){
	e.preventDefault();
	var data = jQuery("#ultimate_modules").serialize();
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
				jQuery('html,body').animate({ scrollTop: 0 }, 300);
			} else {
				jQuery("#msg").html('<div class="error"><p><?php echo __('No settings were updated.','ultimate_vc'); ?></p></div>');
				jQuery('html,body').animate({ scrollTop: 0 }, 300);
			}
		}
	});
});

jQuery(document).ready(function(e) {

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

	var checked_items = <?php echo $checked_items ?>;
	var all_modules = parseInt(jQuery('#ult-all-modules-toggle').data('all'));
	if(checked_items === all_modules) {
		jQuery('#ult-all-modules-toggle').attr('checked',true);
	}

	jQuery('#ult-all-modules-toggle').click(function(){
		var is_check = (jQuery(this).is(':checked')) ? true : false;
		jQuery('.onoffswitch').trigger('click').find('.onoffswitch-checkbox').attr('checked',is_check);
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
