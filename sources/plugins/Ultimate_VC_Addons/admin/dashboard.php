<?php
	if(isset($_GET['deregister-licence']))
	{
		delete_option('ultimate_license_activation');
	}
?>
<div class="wrap ultimate_updater">
  <h1><?php echo __("Brainstorm Force","ultimate_vc"); ?></h1>
  	<p class="ultimate_updater_text">
		<?php 
			$ultimate_step = get_option('ultimate_next_step');
			if($ultimate_step == 2 || $ultimate_step == 3) :
				echo __('Thank you for choosing Brainstorm Force. You are awesome!','ultimate_vc');
			else :
				echo __('Thank you for choosing Brainstorm Force. Please take a moment to register yourself as doing so will allow us to provide you support & lifetime updates. We look forward to having you as a part of our community and serve your web design needs.','ultimate_vc');
			endif;
		?>
	</p>
  <div class="updater-title-logo"></div>
  <div id="msg"></div>
  <div id="bsf-message"></div>
  <div id="poststuff">
    <div id="post-body" class="metabox-holder columns-2">
      <div id="post-body-content" class="postbox-container">
        <div id="normal-sortables" class="meta-box-sortables ui-sortable">
          <div id="plugin_activation" class="postbox ">
          	<?php
				if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1')
				{
					?>
					<div class="overlay-bg"></div>
					<div class="running-localhost">
					<h2><?php echo __('Looks like you are working on local setup.','ultimate_vc') ?> <br/> <?php echo __('Don\'t worry about registering your purchase & license.','ultimate_vc'); ?></h2>
					</div>
					<?php
				}
			if(isset($_GET['action']) && $_GET['action']==='upgrade') {
				Ultimate_Admin_Area::upgradeFromMarketplace();
			} else {
				
			?>
            <h3 class="hndle">
            	<span class="dashicons-before dashicons-admin-network" style="padding-right: 5px;"></span>
                <?php
					if($ultimate_step == 2)
						$title = __('Signup For Support','ultimate_vc');
					else if($ultimate_step == 3)
						$title = __('Manage Registration and Support','ultimate_vc');
					else
						$title = __('Register Your License','ultimate_vc');
				?>
                
            	<span><?php echo $title ?></span>
            </h3>
            <?php 
				require_once('updater/updater.php');
			}?>
          </div>
        </div>
      </div>
      <div id="postbox-container-1" class="postbox-container updater-sidebar">
        <div id="normal-sortables" class="meta-box-sortables ui-sortable">
          <div id="plugin_activation_sidebar" class="postbox ">
            <h3 class="hndle">
            	<span class="dashicons-before dashicons-admin-post" style="padding-right: 5px;"></span>
                <span>Important Links</span>
            </h3>
            <div class="inside">
            	<div class="main" style="text-align: center;">
            		<ul class="sidebar-link-list">
	            		<!--<li><a href="https://www.brainstormforce.com/support/forums/forum/ultimate-addons/" target="_blank" class="bsf-sidebar-link">Visit Support Forum</a></li>-->
						<li><a href="https://www.brainstormforce.com/demos/ultimate/" target="_blank" class="bsf-sidebar-link">Ultimate Addons Website</a></li>
						<li><a href="https://www.youtube.com/user/TheBrainstormForce/videos" target="_blank" class="bsf-sidebar-link"><?php echo __('Video Tutorials & Documentation','ultimate_vc'); ?></a></li>
						<li><a href="http://brainstormforce.com/support" target="_blank" class="bsf-sidebar-link"><?php echo __('Request Support','ultimate_vc'); ?></a></li>
                        <li><a href="https://www.brainstormforce.com/support/wp-admin/admin.php?page=site-registration" target="_blank" class="bsf-sidebar-link"><?php echo __('Manage License Registrations','ultimate_vc') ?></a></li>
					</ul>
					<ul class="sidebar-social-list">
						<li><a href="https://www.facebook.com/brainstormforce" target="_blank" class="bsf-social-link"><span class="dashicons dashicons-facebook"></span></a></li>
						<li><a href="https://www.youtube.com/user/TheBrainstormForce/videos" target="_blank" class="bsf-social-link"><span class="dashicons dashicons-video-alt3"></span></a></li>
						<li><a href="http://codecanyon.net/user/BrainstormForce/portfolio?WT.ac=item_portfolio&WT.z_author=BrainstormForce" target="_blank" class="bsf-social-link"><span class="dashicons dashicons-portfolio"></span></a></li>
					</ul>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.tooltip {
	display:none;
	position:absolute;
	border:1px solid #333;
	background-color:#161616;
	border-radius:5px;
	padding:10px;
	color:#fff;
	font-size:12px Arial;
}
</style>
<script type="text/javascript">
jQuery(document).ready(function() {
	// Tooltip only Text
	jQuery('.masterTooltip').hover(function(){
			// Hover over code
			var title = jQuery(this).attr('title');
			jQuery(this).data('tipText', title).removeAttr('title');
			jQuery('<p class="tooltip"></p>')
			.html(title)
			.appendTo('body')
			.fadeIn('slow');
	}, function() {
			// Hover out code
			jQuery(this).attr('title', jQuery(this).data('tipText'));
			jQuery('.tooltip').remove();
	}).mousemove(function(e) {
			var mousex = e.pageX + 20; //Get X coordinates
			var mousey = e.pageY + 10; //Get Y coordinates
			jQuery('.tooltip')
			.css({ top: mousey, left: mousex })
	});
});
</script>