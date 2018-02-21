<?php

if (!class_exists('ESSBShortcodeGenerator5')) {
	include_once (ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-shortcode-generator5.php');
}


$active_shortcode = isset($_REQUEST['code']) ? $_REQUEST['code'] : '';
$active_shortcode = sanitize_text_field($active_shortcode);

$ukey = isset($_REQUEST['ukey']) ? $_REQUEST['ukey'] : '';
$rukey = isset($_REQUEST['rukey']) ? $_REQUEST['rukey'] : '';

$scg = new ESSBShortcodeGenerator5();
$scg->activate($active_shortcode);

?>
<div class="essb-shortcode-wrapper">


		<div class="essb-shortcode-container essb-shortcode-select">
			<div class="essb-shortcode-title" style="margin-top: 20px; margin-bottom: 20px;">Generate New Shortcode</div>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-social-share', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-social-share]<br/><span class="essb-shortcode-comment">Display social share buttons</span></a>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-social-share-popup', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-social-share-popup]<br/><span class="essb-shortcode-comment">Display share buttons as pop up</span></a>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-social-share-flyin', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-social-share-flyin]<br/><span class="essb-shortcode-comment">Display share buttons as fly in</span></a>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-social-like', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-social-like]<br/><span class="essb-shortcode-comment">Display native social buttons</span></a>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-total-shares', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-total-shares]<br/><span class="essb-shortcode-comment">Display total shares (as number)</span></a>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-profiles', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-profiles]<br/><span class="essb-shortcode-comment">Display links to social profiles</span></a>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-followers', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-followers]<br/><span class="essb-shortcode-comment">Display followers counter</span></a>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-followers-layout', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-followers-layout]<br/><span class="essb-shortcode-comment">Display followers counter with custom layout</span></a>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-total-followers', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-total-followers]<br/><span class="essb-shortcode-comment">Display total followers counter (as number)</span></a>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-popular-posts', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-popular-posts]<br/><span class="essb-shortcode-comment">Display popular posts</span></a>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-subscribe', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-subscribe]<br/><span class="essb-shortcode-comment">Display build in subscribe form</span></a>
			
		</div>

		<?php if ($active_shortcode == '') { ?>
		<div class="essb-shortcode-container essb-shortcode-stored">
			<div class="essb-shortcode-title" style="margin-top: 20px; margin-bottom: 20px;">Stored Shortcodes</div>
			
			<?php 
				if ($rukey != '') {
					$scg->remove_stored_key($rukey);
				}
			
				$scg->generated_stored_shortcodes();
			?>
		
		</div>
		<?php } ?>

		<?php 
		
		$cmd = isset($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';
		$cmd = sanitize_text_field($cmd);
		if ($cmd == 'generate') {
			$options = isset($_REQUEST[$scg->optionsGroup]) ? $_REQUEST[$scg->optionsGroup]: array();
			
			echo '<div class="essb-shortcode-container">';
			
			$scg->generate($options);
			
			echo '</div>';
			
			$active_shortcode = '';
		}
		
		?>
		
		<?php 
		if ($active_shortcode != '') {
		?>
	
		<form name="general_form" method="post"
		action="admin.php?page=essb_redirect_shortcode&tab=shortcode">
		<input type="hidden" id="cmd" name="cmd" value="generate" />
		<input type="hidden" id="code" name="code" value="<?php echo sanitize_text_field($active_shortcode); ?>"/>
		<input type="hidden" id="ukey" name="ukey" value="<?php echo esc_attr($ukey); ?>"/>
 			<?php wp_nonce_field('essb'); ?>
			<div class="essb-options essb-options-shortcodegen">
			<div class="essb-options-header" id="essb-options-header">
				<div class="essb-options-title">
					Parameters for shortcode<?php echo $scg->getTitleNavigation(); ?>
				</div>		
		<?php echo '<input type="Submit" name="Submit" value="' . __ ( 'Generate Shortcode', 'essb' ) . '" class="essb-btn essb-btn-red essb-generate-shortcode" />'; ?>
	</div>
			<div class="essb-options-sidebar">
				<ul class="essb-options-group-menu">
					<?php 
					$scg->renderNavigation();
					?>
				</ul>
			</div>
			<div class="essb-options-container">
				<div id="essb-container-1" class="essb-data-container">

				<?php 
				
				$scg->render();
				
				?>

				</div>
			</div>
		</div>
	</form>
	<?php } ?>

</div>
<script type="text/javascript">

jQuery(document).ready(function(){
    //essb_option_activate('1');
    jQuery('.essb-options-header').scrollToFixed( { marginTop: 30 } );
});

</script>