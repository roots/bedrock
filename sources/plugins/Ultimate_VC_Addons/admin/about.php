<?php
	if(isset($_GET['author']))
		$author = true;
	else
		$author = false;
	$author_extend = '';
	if($author)
		$author_extend = '&author';
?>

<div class="wrap about-wrap bsf-page-wrapper ultimate-about bend">
  <div class="wrap-container">
    <div class="bend-heading-section ultimate-header">
      <h1><?php _e( "Welcome to Ultimate!", "ultimate_vc" ); ?></h1>
      <h3><?php _e( "Ultimate Addons is installed and you are set to take your website design experience to the next level.", "ultimate_vc" ); ?></h3>
      <div class="bend-head-logo">
        <div class="bend-product-ver">
          <?php _e( "Version", "ultimate_vc" ); echo ' '.ULTIMATE_VERSION; ?>
        </div>
      </div>
    </div><!-- bend-heading section -->

    <div class="bend-content-wrap">
      <div class="smile-settings-wrapper">
        <h2 class="nav-tab-wrapper">
            <a href="<?php echo admin_url('admin.php?page=about-ultimate'.$author_extend); ?>" data-tab="about-ultimate" class="nav-tab nav-tab-active"> <?php echo __('About','ultimate_vc'); ?> </a>
	    	<a href="<?php echo admin_url('admin.php?page=ultimate-dashboard'.$author_extend); ?>" data-tab="ultimate-modules" class="nav-tab"> <?php echo __('Modules','ultimate_vc'); ?> </a>
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

        		<div class="bsf-wrap-title">
					<h2><?php echo __( 'How does Ultimate Addons Work?', 'ultimate_vc' ); ?></h2>
					<p><?php  _e('Ultimate is built exclusively as an addon for Visual Composer Page Builder. Just some of the features it brings on the table -','ultimate_vc'); ?></p>
				</div><!--bsf-wrap-title-->

				<div class="container bsf-grid-row bsf-grid-border-row">
					<div class="col-sm-6 col-lg-6">
						<div class="bsf-wrap-content">
							<div class="bsf-wrap-left-icon">
								<i class="dashicons dashicons-yes abt-icon-style"></i>
							</div><!--bsf-wrap-lefticon-->
							<div class="bsf-wrap-right-content">
								<h4 class="ult-addon-heading"><?php echo __('New Visual Composer Elements','ultimate_vc'); ?></h4>
								<p class="ult-addon-discription"><?php echo __('If you go to Visual Composer editor','ultimate_vc').', '.__('you will find a whole','ultimate_vc').' <a href="https://cloudup.com/ce1eKqH_PDp" target="_blank">'.__('new range of elements','ultimate_vc').'</a> '.__('there','ultimate_vc').'. '.__('Info Box, Fancy Text, Interactive Banner, Flip Box, Info Circle are just some of the popular ones.','ultimate_vc'); ?></p>
							</div><!--bsf-wrap-right-content-->
						</div><!--bsf wrap content-->
				  	</div><!--vc_col-sm-6-->

				    <div class="col-sm-6 col-lg-6 bsf-grid-right-column-border">
						<div class="bsf-wrap-content">
				        			<div class="bsf-wrap-left-icon">
										<i class="dashicons dashicons-admin-tools abt-icon"></i>
									</div><!--bsf-wrap-lefticon-->
								<div class="bsf-wrap-right-content">
										<h4 class="ult-addon-heading"><?php echo __('Row Features (Parallax / Video Background)','ultimate_vc'); ?></h4>
										<p class="ult-addon-discription"><?php echo __('Ever wanted those cool parallax effects on your site?','ultimate_vc').' '.__('Now','ultimate_vc').' <a href="https://cloudup.com/cwZLz6UYl9r" target="_blank">'.__('edit your row').'</a> '.__('and see what you\'ve got!','ultimate_vc').' '.__('Almost all kinds of parallax effects, video background, row separator and much more..','ultimate_vc'); ?></p>
								</div><!--bsf-wrap-right-content-->
						</div><!--bsf wrap content-->
				  	</div><!--vc_col-sm-6-->

				</div><!--container end-->

				<div class="container bsf-grid-row">
				    <div class="col-sm-6 col-lg-6 bsf-top-padding">
						<div class="bsf-wrap-content">
							<div class="bsf-wrap-left-icon">
								<i class="dashicons dashicons-update abt-icon"></i>
							</div><!--bsf-wrap-lefticon-->
							<div class="bsf-wrap-right-content">
								<h4 class="ult-addon-heading"><?php echo __('Font Icons','ultimate_vc'); ?></h4>
								<p class="ult-addon-discription"><?php echo __('We\'ve shipped about 360 useful icons that you can use in most of the Ultimate elements. However, should you wish to add any more - you can easily do that with the help of our popular Icon Font Manager.','ultimate_vc'); ?></p>
							</div><!--bsf-wrap-right-content-->
						</div><!--bsf wrap content-->
				  	</div><!--vc_col-sm-6-->

					<div class="col-sm-6 col-lg-6 bsf-grid-right-column-border bsf-top-padding">
						<div class="bsf-wrap-content">
				        		<div class="bsf-wrap-left-icon">
									<i class="dashicons dashicons-editor-spellcheck abt-icon"></i>
								</div><!--bsf-wrap-lefticon-->
									<div class="bsf-wrap-right-content">
										<h4 class="ult-addon-heading"><?php echo __('Google Fonts','ultimate_vc'); ?></h4>
										<p class="ult-addon-discription"><?php echo __('Bored of default fonts? Need some font freedom? We\'ve got you covered! Our built-in Google Fonts manager will help you shortlist the fonts of your choice and use them with any of Ultimate Addon elements.','ultimate_vc'); ?></p>
									</div><!--bsf-wrap-right-content-->
						</div><!--bsf wrap content-->
				  	</div><!--vc_col-sm-6-->
				</div><!--containner end-->

        	</div><!--col-md-12-->
        </div><!-- .ultimate-content -->
    </div><!-- bend-content-wrap -->
  </div><!-- .wrap-container -->
</div><!-- .bend -->
