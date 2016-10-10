<?php
if ( count( $this->settings['profiles'] ) > 0 ) :
	$profile_name = $is_default_profile ? _x( 'New Profile', 'Default profile loaded', 'wp-migrate-db' ) : $loaded_profile['name'];
	?>

	<div class="crumbs">

		<a class="crumb" href="<?php echo $this->plugin_base; ?>" class="return-to-profile-selection clearfix">
			<?php _e( 'Saved Profiles', 'wp-migrate-db' ); ?>
		</a>

		<span class="crumb"><?php echo esc_html( $profile_name ); ?></span>

	</div>

	<?php
endif;
