<tr class="wpmdb-setting-title">
	<td colspan="2"><h3><?php _e( 'Connection Info', 'wp-migrate-db' ); ?></h3></td>
</tr>
<tr class="option-section connecton-info-wrap">
	<td colspan="2">
		<textarea id="connection_info" class="connection-info" readonly><?php echo $connection_info; ?></textarea>

		<div class="reset-button-wrap clearfix"><a class="button reset-api-key js-action-link"><?php _e( 'Reset Secret Key', 'wp-migrate-db' ); ?></a></div>
	</td>
</tr>