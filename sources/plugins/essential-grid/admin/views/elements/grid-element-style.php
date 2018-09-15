<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2016 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();

wp_enqueue_script($this->plugin_slug . '-essential-grid-script', EG_PLUGIN_URL.'public/assets/js/jquery.themepunch.essential.min.js', array('jquery'), Essential_Grid::VERSION );
wp_enqueue_style($this->plugin_slug .'-admin-settings-styles', EG_PLUGIN_URL.'public/assets/css/settings.css', array(), Essential_Grid::VERSION );
?>

<div id="eg-element-settings-wrap">
	 <form id="">
        <div class="postbox eg-postbox"><h3><span><?php _e('Element Settings', EG_TEXTDOMAIN); ?></span><div class="postbox-arrow"></div></h3>
            <div class="inside padding-10">
            	<div id="eg-element-settings-tabs">
					 <ul>
						<li><a href="#eg-element-source"><?php _e('Source', EG_TEXTDOMAIN); ?></a></li>
						<li><a href="#eg-element-style"><?php _e('Style', EG_TEXTDOMAIN); ?></a></li>
						<li><a href="#eg-element-animation"><?php _e('Animation', EG_TEXTDOMAIN); ?></a></li>
					</ul>
					<!-- THE ELEMENT SOURCE SETTING -->
					<div id="eg-element-source">
						<div id="dz-source" data-sort="5">
							 <p>
								<label><?php _e('Source', EG_TEXTDOMAIN); ?></label>
								<select name="element-source" style="width:180px">
									<?php
									foreach($element_type as $el_cat => $el_type){
										?>
										<option value="<?php echo $el_cat; ?>"><?php echo ucwords($el_cat); ?></option>
										<?php
									}
									?>
								</select>
							 </p>
							 <p>
								<label><?php _e('Element', EG_TEXTDOMAIN); ?></label>
								<?php
								foreach($element_type as $el_cat => $el_type){
									?>
									<select name="element-source-<?php echo $el_cat; ?>" style="width:180px" class="elements-select-wrap">
										<?php
										foreach($el_type as $ty_name => $ty_values){
											?><option value="<?php echo $ty_name; ?>"><?php echo $ty_values['name']; ?></option><?php
										}
										?>
									</select>
									<?php
								}
								?>
							 </p>
							</div>
					</div>
					
					<!-- THE ELEMENT STYLE SETTINGS -->
					<div id="eg-element-style">
						<p id="dz-float" data-sort="10">
					<label><?php _e('Float Element', EG_TEXTDOMAIN); ?></label>
					<input class="input-settings-small element-setting firstinput" type="checkbox" name="element-float" />
				</p>
				<p id="dz-font-size" data-sort="20">
					<label><?php _e('Font Size', EG_TEXTDOMAIN); ?></label>
					<span id="element-font-size" class="slider-settings"></span>
					<input class="input-settings-small element-setting" type="text" name="element-font-size" value="6" /> px
				</p>
				<p id="dz-background-color" data-sort="30">
					<label><?php _e('Background Color', EG_TEXTDOMAIN); ?></label>
					<input class="element-setting" name="element-background-color" type="text" id="element-background-color" value="" data-default-color="#ffffff">
				</p>
				<p id="dz-padding" data-sort="40">
					<label><?php _e('Paddings', EG_TEXTDOMAIN); ?></label>
					<span id="element-padding" class="slider-settings"></span>
					<input class="input-settings-small element-setting" type="text" name="element-padding" value="0" /> px
				</p>
				<p id="dz-margin" data-sort="60">
					<label><?php _e('Margin', EG_TEXTDOMAIN); ?></label>
					<span id="element-margin" class="slider-settings"></span>
					<input class="input-settings-small element-setting" type="text" name="element-margin" value="0" /> px
				</p>
				<p id="dz-border" data-sort="70">
					<label><?php _e('Border', EG_TEXTDOMAIN); ?></label>
					<span id="element-border" class="slider-settings"></span>
					<input class="input-settings-small element-setting" type="text" name="element-border" value="0" /> px
				</p>
				<p id="dz-height" data-sort="80">
					<label><?php _e('Height', EG_TEXTDOMAIN); ?></label>
					<span id="element-height" class="slider-settings"></span>
					<input class="input-settings-small element-setting" type="text" name="element-height" value="0" /> px
				</p>
				<p id="dz-hideunder" data-sort="90">
					<label><?php _e('Hide Under Width', EG_TEXTDOMAIN); ?></label>
					<input class="input-settings-small element-setting firstinput" type="text" name="element-hideunder" value="0" /> px
				</p>
				
				<p id="dz-shadow" data-sort="100">
					<label><?php _e('Shadow', EG_TEXTDOMAIN); ?></label>
				</p>
			
					</div>
					
					<!-- THE ELEMENT ANIMATION SETTINGS -->
					<div id="eg-element-animation">
						<p id="dz-delay" data-sort="50">
							<label><?php _e('Delay', EG_TEXTDOMAIN); ?></label>
							<span id="element-delay" class="slider-settings"></span>
							<input class="input-settings-small element-setting" type="text" name="element-delay" value="0" />
						</p>
						<p id="dz-transition" data-sort="90">
							<label><?php _e('Transition', EG_TEXTDOMAIN); ?></label>
							<select name="element-transition">
								<?php
								foreach($transitions as $handle => $name){
									?>
									<option value="<?php echo $handle; ?>"><?php echo $name; ?></option>
									<?php
								}
								?>
							</select>
						</p>
					</div>
				</div>
				
					<p id="dz-delete" data-sort="9999">
					<a id="element-delete-button" class="button-primary revred" href="javascript:void(0);"><i class="eg-icon-trash"></i> <?php _e('Delete', EG_TEXTDOMAIN); ?></a>
					<a id="element-save-as-button" class="button-primary revgreen" href="javascript:void(0);"><i class="eg-icon-save"></i> <?php _e('Save', EG_TEXTDOMAIN); ?></a>
				<p>
            </div>
        </div>
    </form>
</div>