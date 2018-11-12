<tr>
	<td><?php $this->template( 'checkbox', 'common', array( 'key' => 'allow_tracking' ) ); ?></td>
	<td>
		<h4>
			<?php _e( 'Securely Share Data', 'wp-migrate-db' ); ?> <a class="general-helper data-sharing-helper js-action-link" href="#"></a>
			<div class="data-sharing-message helper-message">
				<?php _e( 'We will use data about your migrations to make better-informed decisions about the future of WP Migrate DB Pro and provide you with better support.', 'wp-migrate-db' ); ?>
			</div>
			<span class="setting-status"></span>
		</h4>
		<p><?php _e( 'Help us continue to make WP Migrate DB Pro better by securely sharing usage data with us.', 'wp-migrate-db' ); ?></p>
	</td>
</tr>
