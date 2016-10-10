<?php
foreach ( $this->addons as $addon_basename => $addon ) :
	if ( false == $this->is_addon_outdated( $addon_basename ) || false == is_plugin_active( $addon_basename ) ) {
		continue;
	}
	$update_url = wp_nonce_url( network_admin_url( 'update.php?action=upgrade-plugin&plugin=' . urlencode( $addon_basename ) ), 'upgrade-plugin_' . $addon_basename );
	$addon_slug = current( explode( '/', $addon_basename ) );
	if ( isset( $GLOBALS['wpmdb_meta'][ $addon_slug ]['version'] ) ) {
		$version = ' (' . $GLOBALS['wpmdb_meta'][ $addon_slug ]['version'] . ')';
	} else {
		$version = '';
	}
	?>
	<div class="updated warning inline-message">
		<strong>Update Required</strong> &mdash;
		<?php printf( __( 'The version of the %1$s addon you have installed%2$s is out-of-date and will not work with this version WP Migrate DB Pro. <a href="%3$s">Update Now</a>', 'wp-migrate-db' ), $addon['name'], $version, $update_url ); ?>
	</div>
	<?php
endforeach;