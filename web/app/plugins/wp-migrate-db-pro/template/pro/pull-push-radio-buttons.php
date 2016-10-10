<li class="pull-list">
	<label for="pull"<?php echo ( $this->is_valid_licence() ) ? '' : ' class="disabled"'; ?>>
		<input id="pull" type="radio" value="pull" name="action"<?php echo ( $loaded_profile['action'] == 'pull' && $this->is_pro ) ? ' checked="checked"' : ''; ?><?php echo ( $this->is_valid_licence() ) ? '' : ' disabled="disabled"'; ?> />
		<?php _ex( 'Pull', 'Import data from remote database', 'wp-migrate-db' ); ?><span class="option-description"><?php _e( 'Replace this site\'s db with remote db', 'wp-migrate-db' ); ?></span>
	</label>
	<ul>
		<li></li>
	</ul>
</li>
<li class="push-list">
	<label for="push"<?php echo ( $this->is_valid_licence() ) ? '' : ' class="disabled"'; ?>>
		<input id="push" type="radio" value="push" name="action"<?php echo ( $loaded_profile['action'] == 'push' && $this->is_pro ) ? ' checked="checked"' : ''; ?><?php echo ( $this->is_valid_licence() ) ? '' : ' disabled="disabled"'; ?> />
		<?php _ex( 'Push', 'Export data to remote database', 'wp-migrate-db' ); ?><span class="option-description"><?php _e( 'Replace remote db with this site\'s db', 'wp-migrate-db' ); ?></span>
	</label>
	<ul>
		<li></li>
	</ul>
</li>