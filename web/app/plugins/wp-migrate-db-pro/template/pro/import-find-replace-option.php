<?php global $loaded_profile; ?>
<div class="option-section import-find-replace-option" style="display: none;">
	<label for="import-find-replace" class="import-find-replace-checkbox checkbox-label">
		<input type="checkbox" id="import-find-replace" value="1" autocomplete="off" name="import_find_replace"<?php $this->maybe_checked( $loaded_profile['import_find_replace'] ); ?> />
		<?php _e( 'Run a find & replace on the import', 'wp-migrate-db' ); ?>
	</label>
</div>