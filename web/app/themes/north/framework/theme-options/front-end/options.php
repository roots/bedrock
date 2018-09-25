<?php
wp_enqueue_style('wp-color-picker');
wp_enqueue_script('wp-color-picker', '', '', '', true);
?>

<div class="wrap" id="of_container">

	<div id="of-popup-save" class="of-save-popup">
		<div class="of-save-save">Options Updated</div>
	</div>
	
	<div id="of-popup-reset" class="of-save-popup">
		<div class="of-save-reset">Options Reset</div>
	</div>
	
	<div id="of-popup-fail" class="of-save-popup">
		<div class="of-save-fail">Error!</div>
	</div>
	
	<span style="display: none;" id="hooks"><?php echo json_encode(of_get_header_classes_array()); ?></span>
	<input type="hidden" id="reset" value="<?php if(isset($_REQUEST['reset'])) echo $_REQUEST['reset']; ?>" />
	<input type="hidden" id="security" name="security" value="<?php echo wp_create_nonce('of_ajax_nonce'); ?>" />

	<form id="of_form" method="post" action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" enctype="multipart/form-data" >
		
		<div id="main">
		
			<div id="of-nav">
				<div class="panel-title">
					<img class="panel-logo" src="<?php echo get_template_directory_uri() . '/framework/theme-options/assets/images/logo_panel.png'; ?>" alt="<?php echo THEMENAME; ?>">
<!--					<h2><?php echo THEMENAME; ?></h2>-->
				</div>
				<ul>
				  <?php echo $options_machine->Menu ?>
				</ul>
			</div>
			
			<div id="panel-tab-title">
				<h3 class="panel-tab-title">
				General			
				</h3>
				<div class="panel-title-save">
				<img style="display:none" src="<?php echo ADMIN_DIR; ?>assets/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
				<button id="of_save" type="button" class="button-primary of-save"><?php _e('Save All Changes-All4Share.net', 'north');?></button>
				</div>
			</div>

			<div id="content" class="admin-form">
		  		<?php echo $options_machine->Inputs /* Settings */ ?>
		  	</div>
		  	
			<div class="clear"></div>
			
		</div>
		
		<div class="save_bar"> 
		
			<img style="display:none" src="<?php echo ADMIN_DIR; ?>assets/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
			<button id="of_save" type="button" class="button-primary of-save"><?php _e('Save All Changes', 'north');?></button>			
			<button id="of_reset" type="button" class="button submit-button reset-button" ><?php _e('Options Reset', 'north');?></button>
			<img style="display:none" src="<?php echo ADMIN_DIR; ?>assets/images/loading-bottom.gif" class="ajax-reset-loading-img ajax-loading-img-bottom" alt="Working..." />
			
		</div><!--.save_bar--> 
 
	</form>
	
	<div style="clear:both;"></div>

</div><!--wrap-->