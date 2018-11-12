<?php

class WPMDB_Event_Logger {

	protected $wpmdb;

	public function register( $wpmdb ) {
		$this->wpmdb = $wpmdb;
		$settings    = $this->wpmdb->get( 'settings' );
		add_action( 'wpmdb_additional_settings_advanced', array( $this, 'template_toggle_usage_tracking' ) );
		if ( false !== $settings['allow_tracking'] ) {
			add_action( 'wpmdb_initiate_migration', array( $this, 'log_migration_event' ), 100 );
			add_action( 'wpmdb_notices', array( $this, 'template_notice_enable_usage_tracking' ) );
		}
	}

	public function log_migration_event() {
		$state_data = $this->wpmdb->get( 'state_data' );
		$settings   = $this->wpmdb->get( 'settings' );
		if ( true !== $settings['allow_tracking'] ) {
			return false;
		}

		$api_url = apply_filters( 'wpmdb_logging_endpoint_url', 'https://api2.deliciousbrains.com/event' );

		$log_data = array(
			'local_timestamp'                        => time(),
			'licence_key'                            => $this->wpmdb->get_licence_key(),
			'cli'                                    => $this->wpmdb->get( 'doing_cli_migration' ),
			'setting-compatibility_plugin_installed' => $this->wpmdb->filesystem->file_exists( $this->wpmdb->mu_plugin_dest ),
		);

		foreach ( $this->wpmdb->parse_migration_form_data( $state_data['form_data'] ) as $key => $val ) {
			if ( 'connection_info' === $key ) {
				continue;
			}
			$log_data[ 'profile-' . $key ] = $val;
		}

		foreach ( $settings as $key => $val ) {
			if ( 'profiles' === $key || 'key' === $key ) {
				continue;
			}
			$log_data[ 'setting-' . $key ] = $val;
		}

		foreach ( $GLOBALS['wpmdb_meta'] as $plugin => $arr ) {
			$log_data[ $plugin . '-active' ]  = true;
			$log_data[ $plugin . '-version' ] = $arr['version'];
		}

		foreach ( $state_data['site_details'] as $site => $info ) {
			$log_data[ $site . '-site_url' ] = $info['site_url'];
			$log_data[ $site . '-home_url' ] = $info['home_url'];
			$log_data[ $site . '-prefix' ]   = $info['prefix'];

			$log_data[ $site . '-is_multisite' ] = $info['is_multisite'];

			if ( isset( $info['subsites'] ) && is_array( $info['subsites'] ) ) {
				$log_data[ $site . '-subsite_count' ] = count( $info['subsites'] );
			}

			$log_data[ $site . '-is_subdomain_install' ] = $info['is_subdomain_install'];
		}

		$diagnostic_log = array();

		foreach ( $this->wpmdb->get_diagnostic_info() as $group_name => $data ) {
			foreach ( $data as $key => $val ) {
				if ( 0 === $key ) {
					continue 1;
				}
				$key_name = $group_name;
				if ( is_string( $key ) ) {
					$key_name .= "-{$key}";
				}
				$diagnostic_log[ $key_name ] = $val;
			}
		}

		$log_data['diagnostic_log'] = $diagnostic_log;

		foreach ( $log_data as $key => $val ) {
			if ( strstr( $key, 'count' ) || is_array( $val ) ) {
				continue;
			}
			if ( '1' === $val ) {
				$log_data[ $key ] = true;
				continue;
			}
			if ( '0' === $val ) {
				$log_data[ $key ] = false;
				continue;
			}
			if ( 'true' === $val ) {
				$log_data[ $key ] = true;
				continue;
			}
			if ( 'false' === $val ) {
				$log_data[ $key ] = false;
				continue;
			}
		}

		$remote_post_args = array(
			'blocking' => apply_filters( 'wpmdb_logging_blocking_requests', false ),
			'timeout'  => 60,
			'method'   => 'POST',
			'headers'  => array( 'Content-Type' => 'application/json' ),
			'body'     => json_encode( $log_data ),
		);

		$result = wp_remote_post( $api_url, $remote_post_args );
		if ( is_wp_error( $result ) || $result['response']['code'] >= 400 ) {
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				error_log( 'Error logging migration event' );
				error_log( print_r( $result, 1 ) );
			}
			$this->wpmdb->log_error( 'Error logging Migration event', $result );
		}

		return true;
	}

	public function template_notice_enable_usage_tracking() {
		$settings = $this->wpmdb->get( 'settings' );
		if ( 'boolean' !== gettype( $settings['allow_tracking'] ) ) {
			$this->wpmdb->template( 'notice-enable-usage-tracking', 'pro' );
		}
	}

	public function template_toggle_usage_tracking() {
		$this->wpmdb->template( 'toggle-usage-tracking', 'pro' );
	}
}
