<div class="support">
	<h3><?php _e( 'Email Support', 'wp-migrate-db' ); ?></h3>

	<div class="support-content">
		<?php if ( ! empty( $licence ) ) : ?>
			<p><?php _e( 'Fetching license details, please wait...', 'wp-migrate-db' ); ?></p>
		<?php else : ?>
			<p><?php _e( 'We couldn\'t find your license information. Please switch to the settings tab and enter your license.', 'wp-migrate-db' ); ?></p>
			<p><?php _e( 'Once completed, you may visit this tab to view your support details.', 'wp-migrate-db' ); ?></p>
		<?php endif; ?>
	</div>
</div>