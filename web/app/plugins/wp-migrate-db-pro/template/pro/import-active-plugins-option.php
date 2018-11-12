<?php global $loaded_profile; ?>
<div class="option-section import-active-plugin-option" style="display: none;">
	<label for="import-keep-active-plugin" class="import-find-replace-checkbox checkbox-label">
		<input type="checkbox" id="import-keep-active-plugin" value="1" autocomplete="off" name="keep_active_plugins"<?php $this->maybe_checked( $loaded_profile['keep_active_plugins'] ); ?> />
		<?php _e( 'Do not import the "active plugins" setting', 'wp-migrate-db' ); ?>
	</label>
</div>