<div class="debug">
	<h3><?php _e( 'Diagnostic Info &amp; Error Log', 'wp-migrate-db' ); ?></h3>
	<textarea class="debug-log-textarea" autocomplete="off" readonly></textarea>
	<a href="<?php echo network_admin_url( $this->plugin_base . '&nonce=' . WPMDB_Utils::create_nonce( 'wpmdb-download-log' ) . '&wpmdb-download-log=1' ); ?>" class="button"><?php _ex( 'Download', 'Download to your computer', 'wp-migrate-db' ); ?></a>
	<a class="button clear-log js-action-link"><?php _e( 'Clear Error Log', 'wp-migrate-db' ); ?></a>
</div>
