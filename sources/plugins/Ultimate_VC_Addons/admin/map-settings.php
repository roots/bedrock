<?php
	if(isset($_POST['submit-map-settings'])) {
		$map_key = $_POST['map_key'];
		$is_update = bsf_update_option('map_key', $map_key);
	}
?>

<div class="wrap about-wrap bsf-page-wrapper ultimate-about bend">
  <div class="wrap-container">
    <div class="bend-heading-section ultimate-header">
      <h1><?php _e( "Google Maps!", "ultimate_vc" ); ?></h1>
      <h3><?php _e( "The MAP API key will require for the domains which are created after June 22, 2016", "ultimate_vc" ); ?></h3>
      <div class="bend-head-logo">
        <div class="bend-product-ver">
          <?php _e( "Version", "ultimate_vc" ); echo ' '.ULTIMATE_VERSION; ?>
        </div>
      </div>
    </div><!-- bend-heading section -->

    <div class="container ultimate-content">
        	<div class="col-md-12">

				<div class="container bsf-grid-row bsf-grid-border-row">

						<div class="bsf-wrap-content">
				        	<form action="" method="post">
				        		<table class="form-table">
				        			<tr>
				        				<td><label><?php echo __('API Key', 'ultimate_vc'); ?></label></td>
				        				<td>
				        					<?php $map_key = bsf_get_option('map_key'); ?>
				        					<input type="text" name="map_key" value="<?php echo $map_key; ?>"/> <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank"><?php echo __('Get API Key', 'ultimate_vc'); ?></a> or <a href="http://bsf.io/google-map-api-key" target="_blank"><?php echo __('Read more here', 'ultimate_vc'); ?></a>
				        				</td>
				        			</tr>
				        		</table>
				        		<p class="submit"><input type="submit" name="submit-map-settings" id="submit-map-settings" class="button button-primary" value="<?php echo __('Save Changes', 'ultimate_vc'); ?>"></p>
				        	</form>
						</div><!--bsf wrap content-->

				</div><!--container end-->

        	</div><!--col-md-12-->
        </div><!-- .ultimate-content -->
    </div><!-- bend-content-wrap -->
  </div><!-- .wrap-container -->
</div><!-- .bend -->
