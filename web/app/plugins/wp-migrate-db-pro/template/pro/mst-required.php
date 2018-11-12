<div class="notification-message mst-required error-notice inline-message">
	<?php
		$local       = __( 'single site', 'wp-migrate-db' );
		$remote      = __( 'multisite', 'wp-migrate-db' );
		$action      = '';
		$msg         = '';
		$plugin_file = 'wp-migrate-db-pro-multisite-tools/wp-migrate-db-pro-multisite-tools.php';
		$plugin_ids  = array_keys( get_plugins() );
		$mst_addon   = sprintf( '<a href="%s">%s</a>',
			'https://deliciousbrains.com/wp-migrate-db-pro/doc/multisite-tools-addon/',
			__( 'Multisite tools addon', 'wp-migrate-db' )
		);
		$import_msg  = sprintf( __( 'It looks like the file you are trying to import is from a multisite install and this install is a single site. To run this type of import you\'ll need to use the %s to export a subsite as a single site. <a href="%s" target="_blank">Learn more »</a>', 'wp-migrate-db'),
			$mst_addon,
			'https://deliciousbrains.com/wp-migrate-db-pro/doc/multisite-tools-addon/#export-subsite'
		);

		if ( is_multisite() ) {
			$local      = __( 'multisite', 'wp-migrate-db' );
			$remote     = __( 'single site', 'wp-migrate-db' );
			$import_msg = sprintf( __( 'It looks like the file you are trying to import is from a single site install and this install is a multisite. This type of migration isn\'t currently supported. <a href="%s" target="_blank">Learn more »</a>', 'wp-migrate-db' ),
				'https://deliciousbrains.com/wp-migrate-db-pro/doc/multisite-tools-addon/'
			);
		}

		if ( in_array( $plugin_file, $plugin_ids ) ) {
			if ( ! is_plugin_active( $plugin_file ) ) {
				$url    = wp_nonce_url( network_admin_url( 'plugins.php?action=activate&amp;plugin=wp-migrate-db-pro-multisite-tools/wp-migrate-db-pro-multisite-tools.php' ), 'activate-plugin_wp-migrate-db-pro-multisite-tools/wp-migrate-db-pro-multisite-tools.php' );
				$action = sprintf( '[<a href="%s">%s</a>]', $url, __( 'Activate', 'wp-migrate-db' ) );
			} else {
				$msg = sprintf( __( 'It looks like the remote site is a %s install and this install is a %s. To run this type of migration you\'ll need the %s activated on the <strong>remote</strong> site.', 'wp-migrate-db' ),
					$remote,
					$local,
					$mst_addon
				);
			}
		} else {
			$license_response = get_site_transient( 'wpmdb_licence_response' );

			if ( $license_response ) {
				$license_response = json_decode( $license_response );

				if ( '0' !== $license_response->addons_available ) {
					$url    = wp_nonce_url( network_admin_url( 'update.php?action=install-plugin&plugin=wp-migrate-db-pro-multisite-tools' ), 'install-plugin_wp-migrate-db-pro-multisite-tools' );
					$action = sprintf ( '[<a href="%s">%s</a>]', $url, __( 'Install', 'wp-migrate-db' ) );
				} else {
					$url    = 'https://deliciousbrains.com/my-account/?utm_campaign=support%2Bdocs&utm_source=MDB%2BPaid&utm_medium=insideplugin';
					$action = sprintf( '[<a href="%s" target="_blank">%s</a>]', $url, __( 'Upgrade your license', 'wp-migrate-db' ) );
				}
			}
		}

		if ( '' === $msg ) {
			$msg = sprintf( __( 'It looks like the remote site is a %s install and this install is a %s. To run this type of migration you\'ll need the %s. %s', 'wp-migrate-db' ),
				$remote,
				$local,
				$mst_addon,
				$action
			);
		}

		$msg = '<span class="action-text push pull">' . $msg . '</span><span class="action-text import"> ' . $import_msg . ' </span>';

		printf( '<strong>%s</strong> &mdash; %s',
			__( 'Multisite Tools Addon Needed', 'wp-migrate-db' ),
			$msg
		);
	?>
</div>