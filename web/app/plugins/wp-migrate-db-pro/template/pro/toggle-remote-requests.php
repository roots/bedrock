<tr class="wpmdb-setting-title">
	<td colspan="2"><h3><?php _e( 'Permissions', 'wp-migrate-db' ); ?></h3></td>
</tr>

<tr>
	<td><?php $this->template( 'checkbox', 'common', array( 'key' => 'allow_pull' ) ); ?></td>
	<td>
		<h4><?php _e( 'Pull', 'wp-migrate-db' ); ?> <span class="setting-status"></span></h4>
		<p><?php _e( 'Process requests to pull data from this install, copying it elsewhere.', 'wp-migrate-db' ); ?></p>
	</td>
</tr>

<tr class="option-section">
	<td><?php $this->template( 'checkbox', 'common', array( 'key' => 'allow_push' ) ); ?></td>
	<td>
		<h4><?php _e( 'Push', 'wp-migrate-db' ); ?> <span class="setting-status"></span></h4>
		<p><?php _e( 'Process requests to push data to this install, overwriting its data.', 'wp-migrate-db' ); ?></p>
	</td>
</tr>