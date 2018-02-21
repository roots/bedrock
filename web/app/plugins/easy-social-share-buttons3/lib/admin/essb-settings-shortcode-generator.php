<?php

$active_shortcode = isset($_REQUEST['code']) ? $_REQUEST['code'] : 'easy-social-share';
$active_shortcode = sanitize_text_field($active_shortcode);

$scg = new ESSBShortcodeGenerator3();
$scg->activate($active_shortcode);

?>
<div class="essb-shortcode-wrapper">


		<div class="essb-shortcode-container essb-shortcode-select">
			<div class="essb-shortcode-title" style="margin-top: 20px;">Choose shortcode</div>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-social-share', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-social-share]<br/><span class="essb-shortcode-comment">Shortcode to display social share buttons</span></a>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-social-share-popup', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-social-share-popup]<br/><span class="essb-shortcode-comment">Shortcode to display buttons into popup</span></a>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-social-share-flyin', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-social-share-flyin]<br/><span class="essb-shortcode-comment">Shortcode to display buttons into flyin</span></a>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-social-like', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-social-like]<br/><span class="essb-shortcode-comment">Shortcode to display native social buttons</span></a>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-total-shares', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-total-shares]<br/><span class="essb-shortcode-comment">Shortcode to display total shares</span></a>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-profiles', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-profiles]<br/><span class="essb-shortcode-comment">Display links to social profiles</span></a>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-followers', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-followers]<br/><span class="essb-shortcode-comment">Display followers counter</span></a>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-total-followers', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-total-followers]<br/><span class="essb-shortcode-comment">Display total followers counter</span></a>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-popular-posts', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-popular-posts]<br/><span class="essb-shortcode-comment">Display popular posts</span></a>
			<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-subscribe', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-subscribe]<br/><span class="essb-shortcode-comment">Include subscribe form</span></a>
			
			<?php 
			
			if (defined('ESSB3_SFCE_VERSION')) {
				?>
				<a href="<?php echo esc_url(add_query_arg ( 'code', 'easy-multifans', 'admin.php?page=essb_redirect_shortcode&tab=shortcode' ));?>" class="essb-shortcode essb-shortcode-fixed">[easy-multifans]<br/><span class="essb-shortcode-comment">Display followers counter with extended options</span></a>
				<?php 
			}
			
			?>
			</div>

		<?php 
		
		$cmd = isset($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';
		$cmd = sanitize_text_field($cmd);
		if ($cmd == 'generate') {
			$options = isset($_REQUEST[$scg->optionsGroup]) ? $_REQUEST[$scg->optionsGroup]: array();
			
			echo '<div class="essb-shortcode-container">';
			
			$scg->generate($options);
			
			echo '</div>';
		}
		
		?>
	
		<form name="general_form" method="post"
		action="admin.php?page=essb_redirect_shortcode&tab=shortcode">
		<input type="hidden" id="cmd" name="cmd" value="generate" />
		<input type="hidden" id="code" name="code" value="<?php echo sanitize_text_field($active_shortcode); ?>"/>
 			<?php wp_nonce_field('essb'); ?>
			<div class="essb-options essb-options-shortcodegen">
			<div class="essb-options-header" id="essb-options-header">
				<div class="essb-options-title">
					Shortcode Generator<?php echo $scg->getTitleNavigation(); ?>
				</div>		
		<?php echo '<input type="Submit" name="Submit" value="' . __ ( 'Generate Shortcode', ESSB3_TEXT_DOMAIN ) . '" class="essb-btn essb-btn-red" />'; ?>
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

</div>
<script type="text/javascript">

jQuery(document).ready(function(){
    //essb_option_activate('1');
    jQuery('.essb-options-header').scrollToFixed( { marginTop: 30 } );
});

</script>