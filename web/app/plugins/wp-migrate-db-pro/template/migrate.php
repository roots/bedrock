<?php
global $wpdb;
global $loaded_profile;

if ( isset( $_GET['wpmdb-profile'] ) ) {
	$loaded_profile = $this->get_profile( $_GET['wpmdb-profile'] );
} else {
	$loaded_profile = $this->default_profile;
}
$is_default_profile = isset( $loaded_profile['default_profile'] );

$tracking_base = $this->is_pro ? 'MDB%2BPaid' : 'MDB%2BFree';

$convert_exclude_revisions   = false;
$convert_post_type_selection = false;
if ( ! $is_default_profile ) {
	if ( isset( $loaded_profile['exclude_revisions'] ) ) {
		$convert_exclude_revisions = true;
	}
	/* We used to provide users the option of selecting which post types they'd like to migrate.
	 * We found that our wording for this functionality was a little confusing so we switched it to instead read "Exclude Post Types"
	 * Once we made the switch we needed a way of inverting their saved post type selection to instead exclude the select post types.
	 * This was required to make their select compatible with the new "exclude" wording.
	 * This is easy enough for "push" and "export" saved profile as we know which post types exist on the local system and
	 * can easily invert the selection. Pull saved profiles is a little trickier.
	 * $this->maybe_update_profile() is used to update deprecated profile options to their new values.
	 * At the time of page request $this->maybe_update_profile() cannot be used to update a pull profile as we don't know which
	 * post types exist on the remote machine. As such we invert this selection later using the $convert_post_type_selection flag below.
	*/
	if ( isset( $loaded_profile['post_type_migrate_option'] ) && 'migrate_select_post_types' == $loaded_profile['post_type_migrate_option'] && 'pull' == $loaded_profile['action'] ) {
		$convert_post_type_selection = true;
	}
	$loaded_profile = $this->maybe_update_profile( $loaded_profile, $_GET['wpmdb-profile'] );
}

if ( false == $is_default_profile ) {
	$loaded_profile = wp_parse_args( $loaded_profile, $this->default_profile );
}
$loaded_profile     = wp_parse_args( $loaded_profile, $this->checkbox_options );
$breadcrumbs_params = array(
	'loaded_profile'     => $loaded_profile,
	'is_default_profile' => $is_default_profile,
);
?>
<script type='text/javascript'>
	var wpmdb_default_profile = <?php echo ( $is_default_profile ? 'true' : 'false' ); ?>;
	<?php if ( isset( $loaded_profile['select_tables'] ) && ! empty( $loaded_profile['select_tables'] ) ) : ?>
	var wpmdb_loaded_tables = <?php echo json_encode( $loaded_profile['select_tables'] ); ?>;
	<?php endif; ?>
	<?php if ( isset( $loaded_profile['select_post_types'] ) ) : ?>
	var wpmdb_loaded_post_types = <?php echo json_encode( $loaded_profile['select_post_types'] ); ?>;
	<?php endif; ?>
	<?php if ( isset( $loaded_profile['select_backup'] ) && ! empty( $loaded_profile['select_backup'] ) ) : ?>
	var wpmdb_loaded_tables_backup = <?php echo json_encode( $loaded_profile['select_backup'] ); ?>;
	<?php endif; ?>
	var wpmdb_convert_exclude_revisions = <?php echo ( $convert_exclude_revisions ? 'true' : 'false' ); ?>;
	var wpmdb_convert_post_type_selection = <?php echo ( $convert_post_type_selection ? '1' : '0' ); ?>;
</script>

<div class="migrate-tab content-tab">

	<form method="post" id="migrate-form" action="#migrate" enctype="multipart/form-data">

	<?php $this->template( 'breadcrumbs', 'common', $breadcrumbs_params ); ?>

	<div class="option-section">

		<ul class="option-group migrate-selection">
			<li>
				<label for="savefile">
					<input id="savefile" type="radio" value="savefile" name="action"<?php echo ( $loaded_profile['action'] == 'savefile' || ! $this->is_pro ) ? ' checked="checked"' : ''; ?> />
					<?php _e( 'Export File', 'wp-migrate-db' ); ?>
				</label>
				<ul>
					<li>
						<label for="save_computer">
							<input id="save_computer" type="checkbox" value="1" name="save_computer"<?php $this->maybe_checked( $loaded_profile['save_computer'] ); ?> />
							<?php _e( 'Save as file to your computer', 'wp-migrate-db' ); ?>
						</label>
					</li>
					<?php if ( $this->gzip() ) : ?>
						<li>
							<label for="gzip_file">
								<input id="gzip_file" type="checkbox" value="1" name="gzip_file"<?php $this->maybe_checked( $loaded_profile['gzip_file'] ); ?> />
								<?php _e( 'Compress file with gzip', 'wp-migrate-db' ); ?>
							</label>
						</li>
					<?php endif; ?>
				</ul>
			</li>
			<?php $this->template_part( array( 'import_radio_button', 'pull_push_radio_buttons' ), $loaded_profile ); ?>
			<li>
				<label for="find_replace">
					<input id="find_replace" type="radio" value="find_replace" name="action"<?php echo ( 'find_replace' === $loaded_profile['action'] ) ? ' checked="checked"' : ''; ?> />
					<?php _e( 'Find & Replace', 'wp-migrate-db' ); ?><span class="option-description"><?php _e( 'Run a find & replace on this site\'s db', 'wp-migrate-db' ); ?></span>
				</label>
			</li>
		</ul>

		<div class="connection-info-wrapper clearfix">
			<textarea class="pull-push-connection-info" name="connection_info" placeholder="<?php _e( 'Connection Info - Site URL &amp; Secret Key', 'wp-migrate-db' ); ?>"><?php echo esc_html( isset( $loaded_profile['connection_info'] ) ? $loaded_profile['connection_info'] : '' ); ?></textarea>
			<br/>

			<div class="basic-access-auth-wrapper clearfix">
				<input type="text" name="auth_username" class="auth-username auth-credentials" placeholder="Username" autocomplete="off"/>
				<input type="password" name="auth_password" class="auth-password auth-credentials" placeholder="Password" autocomplete="off"/>
			</div>
			<input class="button connect-button" type="submit" value="Connect" name="Connect" autocomplete="off"/>
		</div>

		<div class="notification-message warning-notice ssl-notice inline-message">
			<strong><?php _e( 'HTTPS Disabled', 'wp-migrate-db' ); ?></strong> &mdash; <?php _e( 'We couldn\'t connect over HTTPS but regular HTTP appears to be working so we\'ve switched to that. If you run a push or pull, your data will be transmitted unencrypted. Most people are fine with this, but just a heads up.', 'wp-migrate-db' ); ?>
		</div>

		<?php $this->template_part( array( 'invalid_licence_warning', 'unrecognized_import_file' ) ); ?>

	</div>

	<p class="connection-status"><?php _e( 'Please enter the connection information above to continue.', 'wp-migrate-db' ); ?></p>

	<?php $this->template_part( array( 'import_file_status', 'mst_required' ) ); ?>

	<div class="notification-message error-notice directory-permission-notice inline-message" style="display: none;">
		<p>
			<strong><?php _e( 'Uploads Directory Not Writable', 'wp-migrate-db' ); ?></strong> &mdash;
			<span class="action-text savefile"><?php _e( 'The Export feature is unavailable because the following directory is not writable:', 'wp-migrate-db' ); ?></span>
			<span class="action-text import"><?php _e( 'The Import feature is unavailable because the following directory is not writable:', 'wp-migrate-db' ); ?></span>
		</p>

		<p><?php echo esc_html( $this->get_upload_info( 'path' ) ); ?></p>

		<p>
			<?php printf( '%s <a href="%s">%s »</a>',
				__( 'Please adjust the permissions on this directory.', 'wp-migrate-db' ),
				'https://deliciousbrains.com/wp-migrate-db-pro/doc/uploads-folder-permissions/?utm_campaign=error%2Bmessages&utm_source=MDB%2BPaid&utm_medium=insideplugin',
				__( 'More info', 'wp-migrate-db' ) ); ?>
		</p>
	</div>

	<div class="step-two">

		<?php do_action( 'wpmdb_before_migration_options' ); ?>

		<?php $this->template_part( array( 'import_find_replace_option' ) ); ?>

		<div class="option-section find-replace-rows">
			<div class="header-wrapper clearfix">
				<div class="option-heading find-heading"><?php _ex( 'Find', 'Source text to be replaced', 'wp-migrate-db' ); ?></div>
				<div class="option-heading replace-heading"><?php _ex( 'Replace', 'Text to replace in source', 'wp-migrate-db' ); ?></div>
			</div>

			<table id="find-and-replace-sort" class="clearfix replace-fields">
				<tbody>
				<tr class="replace-row original-repeatable-field">
					<td class="sort-handle-col">
						<span class="sort-handle"></span>
					</td>
					<td class="old-replace-col">
						<input type="text" size="40" name="replace_old[]" class="code" placeholder="Old value" autocomplete="off" />
					</td>
					<td class="arrow-col" title="Copy Find to Replace">
						<span class="right-arrow">&rarr;</span>
					</td>
					<td class="replace-right-col">
						<input type="text" size="40" name="replace_new[]" class="code" placeholder="New value" autocomplete="off" />

					</td>
					<td class="row-action-buttons">
						<span class="replace-remove-row" data-profile-id="0"></span>
					</td>
				</tr>
				<?php if ( $is_default_profile ) : ?>
					<tr class="replace-row<?php echo ( $this->lock_url_find_replace_row ) ? ' pin' : ''; ?>">
						<td class="sort-handle-col">
							<span class="sort-handle"></span>
						</td>
						<td class="old-replace-col">
							<input type="text" size="40" name="replace_old[]" class="code" id="old-url" placeholder="Old URL" value="<?php echo esc_url( preg_replace( '#^https?:#', '', home_url() ) ); ?>" autocomplete="off"<?php echo ( $this->lock_url_find_replace_row ) ? ' readonly' : ''; ?> />
						</td>
						<td class="arrow-col" title="Copy Find to Replace">
							<span class="right-arrow">&rarr;</span>
						</td>
						<td class="replace-right-col">
							<input type="text" size="40" name="replace_new[]" class="code" id="new-url" placeholder="New URL" autocomplete="off" />
						</td>
						<td class="row-action-buttons">
							<?php $style = $this->lock_url_find_replace_row ? 'display: none;' : ''; ?>
							<span class="replace-remove-row" data-profile-id="0" style="<?php echo $style; ?>"></span>
							<a href="#" class="general-helper domain-replace-helper js-action-link"></a>
							<div class="domain-replace-info helper-message bottom">
								<?php printf( __( 'This find & replace will find the domain name of your remote site and replace it with the domain name of this site. We\'ve left out the protocol so that both http:// and https:// will be found and replaced. <a href="%s" target="_blank">Find & Replace Documentation</a>', 'wp-migrate-db' ), "https://deliciousbrains.com/wp-migrate-db-pro/doc/find-and-replace/?utm_campaign=support%2Bdocs&utm_source={$tracking_base}&utm_medium=insideplugin&utm_content=new%2Burl%2Bhelp%2Bbubble" ); ?>
							</div>
						</td>
					</tr>
					<tr class="replace-row">
						<td class="sort-handle-col">
							<span class="sort-handle"></span>
						</td>
						<td class="old-replace-col">
							<input type="text" size="40" name="replace_old[]" class="code" id="old-path" placeholder="Old file path" value="<?php echo esc_attr( $this->get_absolute_root_file_path() ); ?>" autocomplete="off" />
						</td>
						<td class="arrow-col" title="Copy Find to Replace">
							<span class="right-arrow">&rarr;</span>
						</td>
						<td class="replace-right-col">
							<input type="text" size="40" name="replace_new[]" class="code" id="new-path" placeholder="New file path" autocomplete="off" />
						</td>
						<td class="row-action-buttons">
							<span class="replace-remove-row" data-profile-id="0"></span>
							<a href="#" class="general-helper path-replace-helper js-action-link"></a>
							<div class="path-replace-info helper-message bottom">
								<?php printf( __( 'This find and replace is mostly for 3rd party plugins that store the website’s root file path in the database. This set of fields will ensure that these values are updated to the correct root file path during the migration. <a href="%s" target="_blank">Find & Replace Documentation</a>', 'wp-migrate-db' ), "https://deliciousbrains.com/wp-migrate-db-pro/doc/find-and-replace/?utm_campaign=support%2Bdocs&utm_source={$tracking_base}&utm_medium=insideplugin&utm_content=new%2Bfile%2Bpath%2Bhelp%2Bbubble" ); ?>
							</div>
						</td>
					</tr>
				<?php else :
					$i = 1;
					foreach ( $loaded_profile['replace_old'] as $replace_old ) : ?>
						<tr class="replace-row<?php echo ( 1 == $i && $this->lock_url_find_replace_row ) ? ' pin' : ''; ?>">
							<?php
							$replace_new = ( ! empty( $loaded_profile['replace_new'][ $i ] ) ) ? $loaded_profile['replace_new'][ $i ] : '';
							?>
							<td class="sort-handle-col">
								<span class="sort-handle"></span>
							</td>
							<td class="old-replace-col">
								<input type="text" size="40" name="replace_old[]" class="code" placeholder="Old value" value="<?php echo esc_attr( $replace_old ); ?>" autocomplete="off"<?php echo ( 1 == $i && $this->lock_url_find_replace_row ) ? ' readonly' : ''; ?> />
							</td>
							<td class="arrow-col" title="Copy Find to Replace">
								<span class="right-arrow">&rarr;</span>
							</td>
							<td class="replace-right-col">
								<input type="text" size="40" name="replace_new[]" class="code" placeholder="New value" value="<?php echo esc_attr( $replace_new ); ?>" autocomplete="off" />
							</td>
							<td class="row-action-buttons">
								<?php if ( ! $this->lock_url_find_replace_row || ( $this->lock_url_find_replace_row && $i != 1 ) ) : ?>
									<span class="replace-remove-row" data-profile-id="0"></span>
								<?php endif; ?>
							</td>
						</tr>
					<?php
					++$i;
					endforeach; ?>
				<?php endif; ?>
					<tr class="pin">
						<td colspan="4"><a class="button add-row">Add Row</a></td>
					</tr>
				</tbody>
			</table>

			<?php
			$new_url_missing_warning = __( '<strong>New URL Missing</strong> &mdash; Please enter the protocol-relative URL of the remote website in the "New URL" field or remove the whole row entirely. If you are unsure of what this URL should be, please consult <a href="%s" target="_blank">our documentation</a> on find and replace fields.', 'wp-migrate-db' );
			if ( $is_default_profile && $this->lock_url_find_replace_row ) {
				$new_url_missing_warning = __( '<strong>New URL Missing</strong> &mdash; Please enter the protocol-relative URL of the remote website in the "New URL" field. If you are unsure of what this URL should be, please consult <a href="%s" target="_blank">our documentation</a> on find and replace fields.', 'wp-migrate-db' );
			}
			?>
			<div id="new-url-missing-warning" class="warning inline-message missing-replace"><?php printf( $new_url_missing_warning, "https://deliciousbrains.com/wp-migrate-db-pro/doc/find-and-replace/?utm_campaign=support%2Bdocs&utm_source={$tracking_base}&utm_medium=insideplugin&utm_content=new%2Burl%2Bvalidation" ); ?></div>
			<div id="new-path-missing-warning" class="warning inline-message missing-replace"><?php printf( __( '<strong>New File Path Missing</strong> &mdash; Please enter the root file path of the remote website in the "New file path" field or remove the whole row entirely. If you are unsure of what the file path should be, please consult <a href="%s" target="_blank">our documentation</a> on find and replace fields.', 'wp-migrate-db' ), "https://deliciousbrains.com/wp-migrate-db-pro/doc/find-and-replace/?utm_campaign=support%2Bdocs&utm_source={$tracking_base}&utm_medium=insideplugin&utm_content=new%2Bfile%2Bpath%2Bvalidation" ); ?></div>

		</div>

		<?php $this->template_part( array( 'find_replace_options', 'select_tables', 'exclude_post_types' ), $loaded_profile ); ?>

		<div class="option-section advanced-options">
			<div class="header-expand-collapse clearfix">
				<div class="expand-collapse-arrow collapsed">&#x25BC;</div>
				<div class="option-heading tables-header"><?php _e( 'Advanced Options', 'wp-migrate-db' ); ?></div>
			</div>

			<div class="indent-wrap expandable-content">

				<ul>
					<li>
						<label for="replace-guids">
							<input id="replace-guids" type="checkbox" value="1" name="replace_guids"<?php $this->maybe_checked( $loaded_profile['replace_guids'] ); ?> />
							<?php _e( 'Replace GUIDs', 'wp-migrate-db' ); ?>
						</label>

						<a href="#" class="general-helper replace-guid-helper js-action-link"></a>

						<div class="replace-guids-info helper-message">
							<?php printf( __( 'Although the <a href="%s" target="_blank">WordPress Codex emphasizes</a> that GUIDs should not be changed, this is limited to sites that are already live. If the site has never been live, we recommend replacing the GUIDs. For example, you may be developing a new site locally at dev.somedomain.com and want to migrate the site live to somedomain.com.', 'wp-migrate-db' ), 'http://codex.wordpress.org/Changing_The_Site_URL#Important_GUID_Note' ); ?>
						</div>
					</li>
					<li>
						<label for="exclude-spam">
							<input id="exclude-spam" type="checkbox" autocomplete="off" value="1" name="exclude_spam"<?php $this->maybe_checked( $loaded_profile['exclude_spam'] ); ?> />
							<?php _e( 'Exclude spam comments', 'wp-migrate-db' ); ?>
						</label>
					</li>
					<li class="keep-active-plugins">
						<label for="keep-active-plugins">
							<input id="keep-active-plugins" type="checkbox" value="1" autocomplete="off" name="keep_active_plugins"<?php $this->maybe_checked( $loaded_profile['keep_active_plugins'] ); ?> />
							<?php _e( 'Do not migrate the \'active_plugins\' setting (i.e. which plugins are activated/deactivated)', 'wp-migrate-db' ); ?>
						</label>
					</li>
					<li>
						<label for="exclude-transients">
							<input id="exclude-transients" type="checkbox" value="1" autocomplete="off" name="exclude_transients"<?php $this->maybe_checked( $loaded_profile['exclude_transients'] ); ?> />
							Exclude <a href="https://codex.wordpress.org/Transients_API" target="_blank">transients</a> (temporary cached data)
						</label>
					</li>
					<li class="compatibility-older-mysql">
						<label for="compatibility-older-mysql">
							<input id="compatibility-older-mysql" type="checkbox" value="1" autocomplete="off" name="compatibility_older_mysql"<?php $this->maybe_checked( $loaded_profile['compatibility_older_mysql'] ); ?> />
							<?php _e( 'Compatible with older versions of MySQL (pre-5.5)', 'wp-migrate-db' ); ?>
						</label>
					</li>
					<?php $this->template_part( array( 'exclude_post_revisions' ), $loaded_profile ); ?>
				</ul>

			</div>
		</div>

		<?php $this->template_part( array( 'backup' ), $loaded_profile ); ?>

		<?php $this->template_part( array( 'import_active_plugins_option' ), $loaded_profile ); ?>

		<?php do_action( 'wpmdb_after_advanced_options' ); ?>

		<div class="option-section save-migration-profile-wrap">
			<label for="save-migration-profile" class="save-migration-profile checkbox-label">
				<input id="save-migration-profile" type="checkbox" value="1" name="save_migration_profile"<?php echo( ! $is_default_profile ? ' checked="checked"' : '' ); ?> />
				<?php _e( 'Save Migration Profile', 'wp-migrate-db' ); ?><span class="option-description"><?php _e( 'Save the above settings for the next time you do a similiar migration', 'wp-migrate-db' ); ?></span>
			</label>

			<div class="indent-wrap expandable-content">
				<ul class="option-group">
					<?php
					foreach ( $this->settings['profiles'] as $profile_id => $profile ) {
						++ $profile_id;
						?>
						<li>
							<span class="delete-profile" data-profile-id="<?php echo esc_attr( $profile_id ); ?>"></span>
							<label for="profile-<?php echo esc_attr( $profile_id ); ?>">
								<input id="profile-<?php echo esc_attr( $profile_id ); ?>" type="radio" value="<?php echo esc_attr( -- $profile_id ); ?>" name="save_migration_profile_option"<?php echo ( $loaded_profile['name'] == $profile['name'] ) ? ' checked="checked"' : ''; ?> />
								<?php echo esc_html( $profile['name'] ); ?>
							</label>
						</li>
					<?php
					}
					?>
					<li>
						<label for="create_new" class="create-new-label">
							<input id="create_new" type="radio" value="new" name="save_migration_profile_option"<?php echo( $is_default_profile ? ' checked="checked"' : '' ); ?> />
							<?php _e( 'Create new profile', 'wp-migrate-db' ); ?>
						</label>
						<input type="text" placeholder="e.g. Live Site" name="create_new_profile" class="create-new-profile"/>
					</li>
				</ul>
			</div>
		</div>

		<div class="notification-message warning-notice prefix-notice">
			<h4><?php _e( 'Warning: Different Table Prefixes', 'wp-migrate-db' ); ?></h4>

			<p class="action-text pull"><?php _e( 'Whoa! We\'ve detected that the database table prefix differs between installations. Clicking the Migrate button below will create new database tables in your local database with prefix "<span class="remote-prefix"></span>".', 'wp-migrate-db' ); ?></p>
			<p class="action-text push"><?php printf( __( 'Whoa! We\'ve detected that the database table prefix differs between installations. Clicking the Migrate button below will create new database tables in the remote database with prefix "%s".', 'wp-migrate-db' ), $wpdb->base_prefix ); ?></p>
			<p class="action-text import"><?php printf( __( 'Whoa! We\'ve detected that the database table prefix in the import file does not match the database prefix of this install. Clicking the Import button below will create new database tables with the prefix "%s".', 'wp-migrate-db' ),  '<span class="remote-prefix"></span>' ); ?></p>

			<p class="action-text pull"><?php printf( __( 'However, your local install is configured to use table prefix "%1$s" and will ignore the migrated tables. So, <b>AFTER</b> migration is complete, you will need to edit your local install\'s wp-config.php and change the "%1$s" variable to "<span class="remote-prefix"></span>".', 'wp-migrate-db' ), $wpdb->base_prefix, $wpdb->base_prefix ); ?></p>
			<p class="action-text push"><?php printf( __( 'However, your remote install is configured to use table prefix "<span class="remote-prefix"></span>" and will ignore the migrated tables. So, <b>AFTER</b> migration is complete, you will need to edit your remote install\'s wp-config.php and change the "<span class="remote-prefix"></span>" variable to "%s".', 'wp-migrate-db' ), $wpdb->base_prefix ); ?></p>
			<p class="action-text import"><?php printf( __( 'However, this install is configured to use the table prefix "%1$s" and will ignore the imported tables. So, <b>AFTER</b> the import is complete, you will need to edit this install\'s wp-config.php file and change the value of the "$table_prefix" variable to "%2$s".', 'wp-migrate-db' ), $wpdb->base_prefix, '<span class="remote-prefix"></span>' ); ?></p>

			<p class="action-text pull"><?php _e( 'This will allow your local install to use the migrated tables. Once you do this, you shouldn\'t have to do it again.', 'wp-migrate-db' ); ?></p>
			<p class="action-text push"><?php _e( 'This will allow your remote install to use the migrated tables. Once you do this, you shouldn\'t have to do it again.', 'wp-migrate-db' ); ?></p>
			<p class="action-text import"><?php _e ( 'That will allow this install to use the imported tables. Once you do this, you shouldn\'t have to do it again.', 'wp-migrate-db' ); ?></p>
		</div>

		<div class="notification-message warning-notice mixed-case-table-name-notice pull">
			<?php echo $this->mixed_case_table_name_warning( 'pull' ); ?>
		</div>

		<div class="notification-message warning-notice mixed-case-table-name-notice push">
			<?php echo $this->mixed_case_table_name_warning( 'push' ); ?>
		</div>

		<p class="migrate-db">
			<input type="hidden" class="remote-json-data" name="remote_json_data" autocomplete="off"/>
			<input class="button-primary migrate-db-button" type="submit" value="<?php echo esc_attr_x( 'Export', 'Download a copy of the database', 'wp-migrate-db' ); ?>" name="Submit" autocomplete="off"/>
			<input class="button save-settings-button" type="submit" value="<?php echo esc_attr_x( 'Save Profile', 'Save current migration settings', 'wp-migrate-db' ); ?>" name="submit_save_profile" autocomplete="off"/>
		</p>

	</div>

	</form>
	<?php $this->template( 'migrate-progress' ); ?>

	<?php $this->template_part( array( 'progress_upgrade' ) ); ?>

</div> <!-- end .migrate-tab -->
