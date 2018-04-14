<div class="option-section backup-options" style="display: block;">
	<label for="create-backup" class="backup-checkbox checkbox-label">
		<input type="checkbox" id="create-backup" value="1" autocomplete="off" name="create_backup"<?php $this->maybe_checked( $loaded_profile['create_backup'] ); ?> />
		<span class="action-text pull"><?php _e( 'Backup the local database before replacing it', 'wp-migrate-db' ); ?></span>
		<span class="action-text push"><?php _e( 'Backup the remote database before replacing it', 'wp-migrate-db' ); ?></span>
		<span class="action-text find_replace"><?php _e( 'Backup the database before running the find &amp; replace', 'wp-migrate-db' ); ?></span>
		<span class="action-text import"><?php _e( 'Backup the database before running the import', 'wp-migrate-db' ); ?></span>
		<br/>
		<span class="option-description backup-description"><?php _e( 'An SQL file will be saved to', 'wp-migrate-db' ); ?> <span class="uploads-dir"><?php echo $this->get_short_uploads_dir(); ?></span></span>
	</label>

	<div class="indent-wrap expandable-content">
		<ul>
			<li>
				<label for="backup-only-with-prefix">
					<input type="radio" id="backup-only-with-prefix" value="backup_only_with_prefix" name="backup_option"<?php echo( $loaded_profile['backup_option'] == 'backup_only_with_prefix' ? ' checked="checked"' : '' ); ?> >
					<?php _e( 'Backup all tables with prefix', 'wp-migrate-db' ); ?> "<span class="backup-table-prefix"><?php echo $wpdb->base_prefix; ?></span>"
				</label>
			</li>
			<li>
				<label for="backup-selected">
					<input type="radio" id="backup-selected" value="backup_selected" name="backup_option"<?php echo( $loaded_profile['backup_option'] == 'backup_selected' ? ' checked="checked"' : '' ); ?> >
					<span class="action-text pull push find_replace"><?php _e( 'Backup only tables selected for migration', 'wp-migrate-db' ); ?></span>
					<span class="action-text import"><?php _e( 'Backup only the tables that will be replaced during the import', 'wp-migrate-db' ); ?></span>
				</label>
			</li>
			<li>
				<label for="backup-manual-select">
					<input type="radio" id="backup-manual-select" value="backup_manual_select" name="backup_option"<?php echo( $loaded_profile['backup_option'] == 'backup_manual_select' ? ' checked="checked"' : '' ); ?> >
					<?php _e( 'Backup only selected tables below', 'wp-migrate-db' ); ?>
				</label>
			</li>
		</ul>

		<div class="backup-tables-wrap select-wrap">
			<select multiple="multiple" name="select_backup[]" id="select-backup" class="multiselect">
				<?php foreach ( $this->get_table_sizes( 'backup' ) as $table => $size ) :
					$size = (int) $size * 1024;
					if ( ! empty( $loaded_profile['select_backup'] ) && in_array( $table, $loaded_profile['select_backup'] ) ) {
						printf( '<option value="%1$s" selected="selected">%1$s (%2$s)</option>', $table, size_format( $size ) );
					} else {
						printf( '<option value="%1$s">%1$s (%2$s)</option>', $table, size_format( $size ) );
					}
				endforeach; ?>
			</select>
			<br/>
			<a href="#" class="multiselect-select-all js-action-link"><?php _e( 'Select All', 'wp-migrate-db' ); ?></a>
			<span class="select-deselect-divider">/</span>
			<a href="#" class="multiselect-deselect-all js-action-link"><?php _e( 'Deselect All', 'wp-migrate-db' ); ?></a>
			<span class="select-deselect-divider">/</span>
			<a href="#" class="multiselect-invert-selection js-action-link"><?php _e( 'Invert Selection', 'wp-migrate-db' ); ?></a>
		</div>
	</div>

	<div class="backup-option-disabled inline-message error-notice notification-message" style="display: none;">
		<p>
			<strong><?php _e( 'Uploads Directory Not Writable', 'wp-migrate-db' ); ?></strong> &mdash;
			<span class="action-text pull find_replace"><?php _e( 'The backup option has been disabled because the local uploads directory is not writable:', 'wp-migrate-db' ); ?></span>
			<span class="action-text push"><?php _e( 'The backup option has been disabled because the remote uploads directory is not writable:', 'wp-migrate-db' ); ?></span>
		</p>

		<p><span class="upload-directory-location"><?php echo esc_html( $this->get_upload_info( 'path' ) ); ?></span></p>

		<p>
			<?php printf( '%s <a href="%s">%s »</a>',
				__( 'Please adjust the permissions on this directory.', 'wp-migrate-db' ),
				'https://deliciousbrains.com/wp-migrate-db-pro/doc/uploads-folder-permissions/?utm_campaign=error%2Bmessages&utm_source=MDB%2BPaid&utm_medium=insideplugin',
				__( 'More info', 'wp-migrate-db' ) ); ?>
		</p>
	</div>
</div>