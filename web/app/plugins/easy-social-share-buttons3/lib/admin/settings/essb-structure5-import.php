<?php

ESSBOptionsStructureHelper::menu_item('import', 'backup', __('Export Settings', 'essb'), 'download');
ESSBOptionsStructureHelper::menu_item('import', 'backupimport', __('Import Settings', 'essb'), 'upload');
ESSBOptionsStructureHelper::menu_item('import', 'rollback', __('Rollback Settings', 'essb'), 'upload');

ESSBOptionsStructureHelper::menu_item('import', 'backup2', __('Export Followers Settings', 'essb'), 'database');
ESSBOptionsStructureHelper::menu_item('import', 'backupimport2', __('Import Followers Settings', 'essb'), 'database');

//ESSBOptionsStructureHelper::menu_item('import', 'readymade', __('Apply Ready Made Style', 'essb'), 'square');
ESSBOptionsStructureHelper::field_heading('import', 'backup', 'heading5', __('Export Plugin Settings', 'essb'));
ESSBOptionsStructureHelper::field_func('import', 'backup', 'essb3_text_backup', __('Export plugin settings', 'essb'), '');
ESSBOptionsStructureHelper::field_func('import', 'backup', 'essb3_text_backup1', __('Save plugin settings to file', 'essb'), '');
ESSBOptionsStructureHelper::field_heading('import', 'backupimport', 'heading5', __('Import Plugin Settings', 'essb'));
ESSBOptionsStructureHelper::field_func('import', 'backupimport', 'essb3_text_backup_import', __('Import plugin settings', 'essb'), '');
ESSBOptionsStructureHelper::field_func('import', 'backupimport', 'essb3_text_backup_import1', __('Import plugin settings from file', 'essb'), '');

ESSBOptionsStructureHelper::field_heading('import', 'backup2', 'heading5', __('Export Followers Counter Settings', 'essb'));
ESSBOptionsStructureHelper::field_func('import', 'backup2', 'essb3_text_backup2', __('Export Followers Counter Settings', 'essb'), '');
ESSBOptionsStructureHelper::field_heading('import', 'backupimport2', 'heading5', __('Import Followers Counter Settings', 'essb'));
ESSBOptionsStructureHelper::field_func('import', 'backupimport2', 'essb3_text_backup_import2', __('Import Followers Counter Settings', 'essb'), '');

ESSBOptionsStructureHelper::title('import', 'rollback', __('Rollback previous configuration', 'essb'), __('Easy Social Share Buttons for WordPress stores last 10 saved settin configuration. In case you made a miskate in changing option you can easy return back to previous setup.', 'essb'));
ESSBOptionsStructureHelper::field_func('import', 'rollback', 'essb3_text_roolback', '', '');

function essb3_text_roolback() {
	$history_container = get_option(ESSB5_SETTINGS_ROLLBACK);
	
	echo '<style type="text/css">';
	echo '.essb-history-settings { cursor: pointer; border: 1px solid rgba(0,0,0,0.1); padding: 15px; font-size: 16px; font-weight: 600; margin-bottom: 15px; }';
	echo '.essb-history-settings:hover { box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.15); }';
	echo '</style>';
	
	if (!is_array($history_container)) {
		$history_container = array();
	}
	
	foreach ($history_container as $key => $data) {
		echo '<div class="essb-history-settings" onclick="essb_restore_settings(\''.$key.'\', \''.date(DATE_RFC822, $key).'\');">';
		echo '<span>'.date(DATE_RFC822, $key).'</span>';
		echo '</div>';
	}
	
	echo '<script type="text/javascript">';
	echo 'function essb_restore_settings(key, text) {
		if (!confirm("Are you sure you wish to restore back settings saved on "+text+"?")) return;
		location.href = "'.admin_url('admin.php?page=essb_redirect_import&tab=import&section=rollback&rollback_setup=true&rollback_key=').'"+key;
	}
	';
	echo '</script>';
}

function essb3_text_backup() {
	global $essb_options;
	$goback = esc_url_raw(add_query_arg(array('backup' => 'true'), 'admin.php?page=essb_redirect_import&tab=import'));
	$is_backup = isset($_REQUEST['backup']) ? $_REQUEST['backup'] : '';

	$backup_string = '';
	if ($is_backup == 'true') {
		$backup_string = json_encode($essb_options);
	}

	$download_settings = "admin-ajax.php?action=essb_settings_save";

	?>
	
	<textarea id="essb_options_configuration" name="essb_backup[configuration]" class="input-element stretched" rows="15"><?php echo $backup_string; ?></textarea>
	<a href="<?php echo $goback; ?>" class="essb-btn essb-btn-blue">Export Settings</a>
	
	<?php 
}

function essb3_text_backup2() {
	global $essb_socialfans_options;
	$goback = esc_url_raw(add_query_arg(array('backup' => 'true'), 'admin.php?page=essb_redirect_import&tab=import&section=backup2'));
	$is_backup = isset($_REQUEST['backup']) ? $_REQUEST['backup'] : '';

	$backup_string = '';
	if ($is_backup == 'true') {
		$backup_string = json_encode($essb_socialfans_options);
	}

	$download_settings = "admin-ajax.php?action=essb_settings_save";

	?>
	
	<textarea id="essb_options_configuration" name="essb_backup[configuration]" class="input-element stretched" rows="15"><?php echo $backup_string; ?></textarea>
	<a href="<?php echo $goback; ?>" class="essb-btn essb-btn-blue">Export Settings</a>
	
	<?php 
}


function essb3_text_backup_import() {
	global $essb_options;
	$goback = esc_url_raw(add_query_arg(array('backup' => 'true'), 'admin.php?page=essb_redirect_import&tab=import'));
	$is_backup = isset($_REQUEST['backup']) ? $_REQUEST['backup'] : '';

	$backup_string = '';
	if ($is_backup == 'true') {
		$backup_string = json_encode($essb_options);
	}

	$download_settings = "admin-ajax.php?action=essb_settings_save";

	?>
	
	<textarea id="essb_options_configuration1" name="essb_backup[configuration1]" class="input-element stretched" rows="15"></textarea>
	<input type="Submit" name="Submit" value="Import Settings" class="essb-btn essb-btn-blue">
		<?php 
}

function essb3_text_backup_import2() {
	global $essb_options;
	$goback = esc_url_raw(add_query_arg(array('backup' => 'true'), 'admin.php?page=essb_redirect_import&tab=import'));
	$is_backup = isset($_REQUEST['backup']) ? $_REQUEST['backup'] : '';

	$backup_string = '';
	if ($is_backup == 'true') {
		$backup_string = json_encode($essb_options);
	}

	$download_settings = "admin-ajax.php?action=essb_settings_save";

	?>
	
	<textarea id="essb_options_configuration1" name="essb_backup2[configuration1]" class="input-element stretched" rows="15"></textarea>
	<input type="Submit" name="Submit" value="Import Settings" class="essb-btn essb-btn-blue">
		<?php 
}


function essb3_text_backup_import1() {
	global $essb_options;
	$goback = esc_url_raw(add_query_arg(array('backup' => 'true'), 'admin.php?page=essb_redirect_import&tab=import'));
	$is_backup = isset($_REQUEST['backup']) ? $_REQUEST['backup'] : '';

	$backup_string = '';
	if ($is_backup == 'true') {
		$backup_string = json_encode($essb_options);
	}

	$download_settings = "admin-ajax.php?action=essb_settings_save";

	?>
	
	<input type="file" name="essb_backup_file" class="essb-btn essb-btn-light"/>
	<input type="Submit" name="Submit" value="Import Settings From File" class="essb-btn essb-btn-orange">
		<?php 
}


function essb3_text_backup1() {
	global $essb_options;
	$goback = esc_url_raw(add_query_arg(array('backup' => 'true'), 'admin.php?page=essb_redirect_import&tab=import'));
	$is_backup = isset($_REQUEST['backup']) ? $_REQUEST['backup'] : '';

	$backup_string = '';
	if ($is_backup == 'true') {
		$backup_string = json_encode($essb_options);
	}

	$download_settings = "admin-ajax.php?action=essb_settings_save";

	?>
	
	<a href="<?php echo $download_settings; ?>" class="essb-btn essb-btn-orange">Save Plugin Settings To File</a>&nbsp;
	<?php 
}
