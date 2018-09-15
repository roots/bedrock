<?php

// Activation events
add_action('admin_init', 'layerslider_activation_redirect');

// Activation and de-activation hooks
add_action('admin_init', 'layerslider_activation_routine');
register_activation_hook(LS_ROOT_FILE, 'layerslider_activation');
register_deactivation_hook(LS_ROOT_FILE, 'layerslider_deactivation_scripts');
register_uninstall_hook(LS_ROOT_FILE, 'layerslider_uninstall_scripts');


// Update handler
if(get_option('ls-plugin-version', '1.0.0') !== LS_PLUGIN_VERSION) {
	update_option('ls-plugin-version', LS_PLUGIN_VERSION);
	layerslider_update_scripts();
}

// Redirect to LayerSlider's main admin page after plugin activation.
// Should not trigger on multisite bulk activation or after upgrading
// the plugin to a newer versions.
function layerslider_activation_redirect() {
	if(get_option('layerslider_do_activation_redirect', false)) {
		delete_option('layerslider_do_activation_redirect');
		if(isset($_GET['activate']) && !isset($_GET['activate-multi'])) {
			wp_redirect(admin_url('admin.php?page=ls-about'));
		}
	}
}

function layerslider_activation( ) {

	// Plugin activation routines should take care of this, but
	// call DB scripts anyway to avoid user intervention issues
	// like partially removing the plugin by only deleting the
	// database table.
	layerslider_create_db_table();

	// Call "activated" hook
	if( has_action('layerslider_activated') ) {
		do_action('layerslider_activated');
	}

	// Redirect to LS's admin page after activation
	update_option('layerslider_do_activation_redirect', 1);
}

function layerslider_activation_routine( ) {

	// Bail out early if everything is up-to-date
	// and there is nothing to be done.
	if( ! version_compare( get_option('ls-db-version', '1.0.0'), LS_DB_VERSION, '<' ) ) {
		return;
	}

	// Update database
	layerslider_create_db_table();
	update_option('ls-db-version', '6.0.0');

	// Fresh installation
	if( ! get_option('ls-installed') ) {
		update_option('ls-installed', 1);

		// Set pre-defined Google Fonts
		update_option('ls-google-fonts', array(
			array( 'param' => 'Lato:100,300,regular,700,900', 'admin' => false ),
			array( 'param' => 'Open+Sans:300', 'admin' => false ),
			array( 'param' => 'Indie+Flower:regular', 'admin' => false ),
			array( 'param' => 'Oswald:300,regular,700', 'admin' => false )
		));

		// Call "installed" hook
		if(has_action('layerslider_installed')) {
			do_action('layerslider_installed');
		}
	}

	// Install date
	if( ! get_option('ls-date-installed', 0) ) {
		update_option('ls-date-installed', time());
	}
}

function layerslider_update_scripts() {

	// Update database
	layerslider_activation_routine();

	if(has_action('layerslider_updated')) {
		do_action('layerslider_updated');
	}
}


function layerslider_create_db_table() {

	global $wpdb;
	$charset_collate = '';
	$table_name = $wpdb->prefix . "layerslider";

	// Get DB collate
	if( ! empty($wpdb->charset) ) {
		$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
	}

	if( ! empty($wpdb->collate) ) {
		$charset_collate .= " COLLATE $wpdb->collate";
	}

	// Building the query
	$sql = "CREATE TABLE $table_name (
			  id int(10) NOT NULL AUTO_INCREMENT,
			  author int(10) NOT NULL DEFAULT 0,
			  name varchar(100) DEFAULT '',
			  slug varchar(100) DEFAULT '',
			  data mediumtext NOT NULL,
			  date_c int(10) NOT NULL,
			  date_m int(10) NOT NULL,
			  schedule_start int(10) NOT NULL DEFAULT 0,
			  schedule_end int(10) NOT NULL DEFAULT 0,
			  flag_hidden tinyint(1) NOT NULL DEFAULT 0,
			  flag_deleted tinyint(1) NOT NULL DEFAULT 0,
			  PRIMARY KEY  (id)
			) $charset_collate;";

	// Execute the query
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}


function layerslider_deactivation_scripts() {

	// Remove capability option, so a user can restore
	// his access to the plugin if set the wrong capability
	// delete_option('layerslider_custom_capability');

	// Remove the help pointer entry to remind a user for the
	// help menu when start to use the plugin again
	delete_user_meta(get_current_user_id(), 'layerslider_help_wp_pointer');

	// Call user hooks
	if(has_action('layerslider_deactivated')) {
		do_action('layerslider_deactivated');
	}
}

function layerslider_uninstall_scripts() {

	// Call user hooks
	update_option('ls-installed', 0);
	if(has_action('layerslider_uninstalled')) {
		do_action('layerslider_uninstalled');
	}
}

?>
