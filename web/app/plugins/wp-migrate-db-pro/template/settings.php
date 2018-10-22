<div class="settings-tab content-tab">
	<form method="post" id="settings-form" action="#settings" autocomplete="off">
		<table class="form-table">
			<tbody class="settings">
			<?php $this->template_part( array(
				'connection_info',
				'toggle_remote_requests',
				'licence',
				'request_settings',
				'compatibility',
				'max_request_size',
			) ); ?>
			<?php do_action( 'wpmdb_additional_settings' ); ?>
			</tbody>
			<?php if ( $this->is_pro ): ?>
				<tbody class="settings-advanced">
				<tr class="wpmdb-setting-title">
					<th colspan="2"><h3><?php _e( 'Advanced Settings', 'wp-migrate-db' ); ?></h3></th>
				</tr>
				<?php do_action( 'wpmdb_additional_settings_advanced' ); ?>
				</tbody>
			<?php endif; ?>
		</table>
	</form>
</div> <!-- end .settings-tab -->
