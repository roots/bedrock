<?php

if(!defined('LS_ROOT_FILE')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

// Attempt to workaround memory limit & execution time issues
@ini_set( 'max_execution_time', 0 );
@ini_set( 'memory_limit', '256M' );

$deleteLink = '';
if( !empty( $_GET['user'] ) ) {
	$deleteLink = wp_nonce_url('users.php?action=delete&amp;user='.(int)$_GET['user'], 'bulk-users' );
}

// Notification messages
$notifications = array(
	'debugAccountSuccess' 	=> __("Successfully created debug account. The credentials were sent to us via email. We will get back to you as soon as we've checked your site.", 'LayerSlider'),
	'debugAccountError' 	=> __('Debug account already exists. Please try again after removing it manually by clicking ', 'LayerSlider') . '<a href="'.$deleteLink.'">' .__('here', 'LayerSlider').'</a>.'
);

$authorized 	= get_option('layerslider-authorized-site', false);
$isAdmin 		= current_user_can('manage_options');
$debugCondition = $authorized && $isAdmin;

?><div class="wrap">
	<h2>
		<?php _e('System Status', 'LayerSlider') ?>
		<a href="<?php echo admin_url('?page=layerslider') ?>" class="add-new-h2"><?php _e('Back', 'LayerSlider') ?></a>
	</h2>

	<!-- Error messages -->
	<?php if(isset($_GET['message'])) : ?>
	<div class="ls-notification <?php echo isset($_GET['error']) ? 'error' : 'updated' ?>">
		<div><?php echo $notifications[ $_GET['message'] ] ?></div>
	</div>
	<?php endif; ?>
	<!-- End of error messages -->

	<!-- System Status -->
	<?php
		$latest 	= get_option('ls-latest-version', 0);
		$plugins 	= get_plugins();
		$cachePlugs = array();
		$timeout 	= (int) ini_get('max_execution_time');
		$memory 	= ini_get('memory_limit');
		$memoryB 	= str_replace(array('G', 'M', 'K'), array('000000000', '000000', '000'), $memory);
		$postMaxB 	= str_replace(array('G', 'M', 'K'), array('000000000', '000000', '000'), ini_get('post_max_size'));
		$uploadB 	= str_replace(array('G', 'M', 'K'), array('000000000', '000000', '000'), ini_get('upload_max_filesize'));
	?>
	<div class="ls-system-status">
		<ul>
			<li><?php _e('This page is intended to help you identifying possible issues and to display relevant debug information about your site.', 'LayerSlider') ?></li>
			<li><?php _e('Whenever a potential issues is detected, it will be marked with red or orange text describing the nature of that issue.', 'LayerSlider') ?></li>
			<li><?php _e('Please keep in mind that in most cases only your web hosting company can change server settings, thus you should contact them with the messages provided (if any).', 'LayerSlider') ?></li>
		</ul>
		<div class="ls-box km-tabs-inner">
			<table>
				<thead>
					<tr>
						<th colspan="4"><?php _e('Available Updates', 'LayerSlider') ?></th>
					</tr>
				</thead>
				<tbody>
					<tr class="<?php echo ! empty($authorized) ? '' : 'ls-warning' ?>">
						<td><?php _e('Auto-Updates:', 'LayerSlider') ?></td>
						<td><span class="dashicons <?php echo ! empty($authorized) ? 'dashicons-yes' : 'dashicons-warning' ?>"></span></td>
						<td><?php echo ! empty($authorized) ? __('Activated', 'LayerSlider') : __('Not set', 'LayerSlider') ?></td>
						<td>
							<?php if( ! $authorized ) : ?>
							<span><?php echo __("Authorize this site to receive LayerSlider updates.", 'LayerSlider'). ' <a href="https://support.kreaturamedia.com/docs/layersliderwp/documentation.html#updating" target="_blank">' . __('Click here to learn more', 'LayerSlider') . '</a>' ?></span>
							<?php endif ?>
						</td>
					</tr>
					<tr>
						<?php $test = version_compare(LS_PLUGIN_VERSION, $latest, '<'); ?>
						<td><?php _e('LayerSlider version:', 'LayerSlider') ?></td>
						<td><span class="dashicons <?php echo empty($test) ? 'dashicons-yes' : 'dashicons-warning' ?>"></span></td>
						<td><?php echo LS_PLUGIN_VERSION ?></td>
						<td>
							<?php if( $test ) : ?>
							<span><?php echo sprintf( __('Update to latest version (%1$s), as we are constantly working on new features, improvements and bug fixes.', 'LayerSlider'), $latest) ?></span>
							<?php endif ?>
						</td>
					</tr>
					<tr>
						<?php $test = true; ?>
						<td><?php _e('WordPress version:', 'LayerSlider') ?></td>
						<td><span class="dashicons <?php echo ! empty($test) ? 'dashicons-yes' : 'dashicons-warning' ?>"></span></td>
						<td><?php echo get_bloginfo('version') ?></td>
						<td></td>
					</tr>
				<tbody>
				<thead>
					<th colspan="4"><?php _e('Site Setup & Plugin Settings', 'LayerSlider') ?></th>
				</thead>
				<tbody>
					<?php $test = defined('WP_DEBUG') &&  WP_DEBUG; ?>
					<tr class="<?php echo ! empty($test) ? '' : 'ls-info' ?>">
						<td><?php _e('WP Debug Mode:', 'LayerSlider') ?></td>
						<td><span class="dashicons <?php echo ! empty($test) ? 'dashicons-yes' : 'dashicons-info' ?>"></span></td>
						<td><?php echo ! empty( $test ) ? _e('Enabled', 'LayerSlider') : _e('Disabled', 'LayerSlider') ?></td>
						<td>
							<?php if( ! $test ) : ?>
							<span>
								<?php echo __('If you experience any issue, we recommend enabling the WP Debug mode while debugging.', 'LayerSlider') ?>
								<?php echo '<a href="https://codex.wordpress.org/Debugging_in_WordPress#WP_DEBUG" target="_blank">'. __('Click here to learn more', 'LayerSlider') .'</a>' ?>
							</span>
							<?php endif ?>
						</td>
					</tr>
					<?php
						$uploads = wp_upload_dir();
						$uploadsDir = $uploads['basedir'];
						$test = file_exists($uploadsDir) && is_writable($uploadsDir);
					?>
					<tr>
						<td><?php _e('Uploads directory:', 'LayerSlider') ?></td>
						<td><span class="dashicons <?php echo ! empty($test) ? 'dashicons-yes' : 'dashicons-info' ?>"></span></td>
						<td><?php echo ! empty( $test ) ? _e('OK', 'LayerSlider') : _e('Unavailable', 'LayerSlider') ?></td>
						<td>
							<?php if( ! $test ) : ?>
							<span>
								<?php echo __('LayerSlider uses the uploads directory for image uploads, exporting/importing sliders, etc. Make sure that your /wp-content/uploads/ directory exists and has write permission.', 'LayerSlider') ?>
								<?php echo '<a href="http://www.wpbeginner.com/wp-tutorials/how-to-fix-image-upload-issue-in-wordpress/" target="_blank">'. __('Click here to learn more', 'LayerSlider') .'</a>' ?>
							</span>
							<?php endif ?>
						</td>
					</tr>

					<?php

						foreach($plugins as $key => $plugin) {
							if( stripos($plugin['Name'], 'cache') !== false ) {
								$cachePlugs[] = $plugin['Name'];
							}
						}

						$test = empty( $cachePlugs );
					?>
					<tr class="<?php echo $test ? '' : 'ls-warning' ?>">
						<td><?php _e('Cache plugins', 'LayerSlider') ?></td>
						<td><span class="dashicons <?php echo ! empty($test) ? 'dashicons-yes' : 'dashicons-warning' ?>"></span></td>
						<td><?php echo ! $test ? implode(', ', $cachePlugs) : __('Not found', 'LayerSlider') ?></td>
						<td>
							<?php if( ! $test ) : ?>
							<span><?php _e('The listed plugin(s) may prevent edits and other changes to show up on your site in real-time. Empty your caches if you experience any issue.') ?></span>
							<?php endif ?>
						</td>
					</tr>
					<tr>
						<?php $test = get_option('ls_use_custom_jquery', false); ?>
						<td><?php _e('jQuery Google CDN:', 'LayerSlider') ?></td>
						<td><span class="dashicons <?php echo empty($test) ? 'dashicons-yes' : 'dashicons-warning' ?>"></span></td>
						<td><?php echo ! empty($test) ? __('Enabled', 'LayerSlider') : __('Disabled', 'LayerSlider') ?></td>
						<td>
							<?php if( ! empty( $test ) ) : ?>
							<span><?php _e('Should be used in special cases only, as it can break otherwise functioning sites.', 'LayerSlider') ?></span>
							<?php endif ?>
						</td>
					</tr>
				</tbody>
				<thead>
					<tr>
						<th colspan="4"><?php _e('Server Settings', 'LayerSlider') ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<?php $test = version_compare(phpversion(), '5.3', '<'); ?>
						<td><?php _e('PHP Version:', 'LayerSlider') ?></td>
						<td><span class="dashicons <?php echo empty($test) ? 'dashicons-yes' : 'dashicons-warning' ?>"></span></td>
						<td><?php echo phpversion() ?></td>
						<td>
							<?php if( ! empty( $test ) ) : ?>
							<span><?php _e('LayerSlider requires PHP 5.3 or newer.', 'LayerSlider') ?></span>
							<?php endif ?>
						</td>
					</tr>
					<tr>
						<?php $test = $timeout > 0 && $timeout < 60; ?>
						<td><?php _e('PHP Time Limit:', 'LayerSlider') ?></td>
						<td><span class="dashicons <?php echo empty($test) ? 'dashicons-yes' : 'dashicons-warning' ?>"></span></td>
						<td><?php echo ! empty( $timeout ) ? $timeout.'s' : 'No limit' ?></td>
						<td>
							<?php if( $test ) : ?>
							<span><?php _e('PHP max. execution time should be set to at least 60 seconds or higher when importing large sliders.', 'LayerSlider') ?></span>
							<?php endif ?>
						</td>
					</tr>
					<tr>
						<?php $test = (int)$memory > 0 && $memoryB < 64 * 1024 * 1024; ?>
						<td><?php _e('PHP Memory Limit:', 'LayerSlider') ?></td>
						<td><span class="dashicons <?php echo empty($test) ? 'dashicons-yes' : 'dashicons-warning' ?>"></span></td>
						<td><?php echo $memory ?></td>
						<td>
							<?php if( $test ) : ?>
							<span><?php _e('PHP memory limit should be set to at least 64MB or higher when dealing with large sliders.', 'LayerSlider') ?></span>
							<?php endif ?>
						</td>

					</tr>
					<tr>
						<?php $test = $postMaxB < 16 * 1024 * 1024; ?>
						<td><?php _e('PHP Post Max Size:') ?></td>
						<td><span class="dashicons <?php echo empty($test) ? 'dashicons-yes' : 'dashicons-warning' ?>"></span></td>
						<td><?php echo ini_get('post_max_size') ?></td>
						<td>
							<?php if( $test ) : ?>
							<span><?php _e('Importing larger sliders could be problematic in some cases.', 'LayerSlider') ?></span>
							<?php endif ?>
						</td>
					</tr>
					<tr>
						<?php $test = $uploadB < 16 * 1024 * 1024; ?>
						<td><?php _e('PHP Max Upload Size:', 'LayerSlider') ?></td>
						<td><span class="dashicons <?php echo empty($test) ? 'dashicons-yes' : 'dashicons-warning' ?>"></span></td>
						<td><?php echo ini_get('upload_max_filesize') ?></td>
						<td>
							<?php if( $test ) : ?>
							<span><?php _e('Importing larger sliders could be problematic in some cases.', 'LayerSlider') ?></span>
							<?php endif ?>
						</td>
					</tr>

					<?php $test = extension_loaded('suhosin'); ?>
					<tr class="<?php echo empty($test) ? '' : 'ls-warning' ?>">
						<td><?php _e('Suhosin:', '') ?></td>
						<td><span class="dashicons <?php echo  empty($test) ? 'dashicons-yes' : 'dashicons-warning' ?>"></span></td>
						<td><?php echo $test ? __('Active', 'LayerSlider') : __('Not found', 'LayerSlider'); ?></td>
						<td>
							<?php if( $test ) : ?>
							<span><?php _e('Suhosin may override PHP server settings that are otherwise marked OK here. If you experience issues, please contact your web hosting company and ask them to verify the listed server settings above.', 'LayerSlider') ?></span>
							<?php endif ?>
						</td>
					</tr>
					<tr>
						<?php $test = class_exists('ZipArchive'); ?>
						<td><?php _e('PHP ZipArchive Extension:') ?></td>
						<td><span class="dashicons <?php echo ! empty($test) ? 'dashicons-yes' : 'dashicons-warning' ?>"></span></td>
						<td><?php echo $test ? __('Enabled', 'LayerSlider') : __('Disabled', 'LayerSlider'); ?></td>
						<td>
							<?php if( ! $test ) : ?>
							<span><?php _e('The PHP ZipArchive extension is needed to export/import sliders with images.', 'LayerSlider') ?></span>
							<?php endif ?>
						</td>
					</tr>
					<tr>
						<?php $test = class_exists('DOMDocument'); ?>
						<td><?php _e('PHP DOMDocument Extension:', 'LayerSlider') ?></td>
						<td><span class="dashicons <?php echo ! empty($test) ? 'dashicons-yes' : 'dashicons-warning' ?>"></span></td>
						<td><?php echo $test ? __('Enabled', 'LayerSlider') : __('Disabled', 'LayerSlider') ?></td>
						<td>
							<?php if( ! $test ) : ?>
							<span><?php _e('Front-end sliders and the slider builder interfaces relies on the PHP DOMDocument extension.') ?></span>
							<?php endif ?>
						</td>
					</tr>
					<tr>
						<?php $test = extension_loaded('mbstring'); ?>
						<td><?php _e('PHP Multibyte String Extension:', 'LayerSlider') ?></td>
						<td><span class="dashicons <?php echo ! empty($test) ? 'dashicons-yes' : 'dashicons-warning' ?>"></span></td>
						<td><?php echo $test ? __('Enabled', 'LayerSlider') : __('Disabled', 'LayerSlider') ?></td>
						<td>
							<?php if( ! $test ) : ?>
							<span><?php _e('The lack of PHP Multibyte String extension can lead to unexpected issues.') ?></span>
							<?php endif ?>
						</td>
					</tr>
					<tr>
						<?php
							$response = wp_remote_post('https://repository.kreaturamedia.com/v4/ping/' );
							$test = ( ! is_wp_error($response) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 );
						?>
						<td><?php _e('WP Remote functions:', 'LayerSlider') ?></td>
						<td><span class="dashicons <?php echo ! empty($test) ? 'dashicons-yes' : 'dashicons-warning' ?>"></span></td>
						<td><?php echo $test ? __('OK', 'LayerSlider') : __('Blocked', 'LayerSlider') ?></td>
						<td>
							<?php if( ! $test ) : ?>
							<span><?php _e('Failed to connect to our update server. This could cause issues with activating the Auto-Updates feature or serving plugin updates. It\'s most likely a web server configuration issue. Please contact your web host and ask them to allow external connection to the following domain: repository.kreaturamedia.com', 'LayerSlider') ?></span>
							<?php endif ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<script type="text/html" id="ls-phpinfo">
		<?php phpinfo(); ?>
	</script>

	<script type="text/html" id="ls-phpinfo-modal">
		<div id="ls-phpinfo-modal-window">
			<header class="header">
				<h1><?php _e('Advanced Debug Details', 'LayerSlider') ?></h1>
				<b class="dashicons dashicons-no"></b>
			</header>
				<iframe class="km-ui-modal-scrollable"></iframe>
		</div>
	</script>


	<script type="text/html" id="ls-erase-modal">
		<div id="ls-erase-modal-window">
			<header>
				<h1><?php _e('Erase All Plugin Data', 'LayerSlider') ?></h1>
				<b class="dashicons dashicons-no"></b>
			</header>
			<div class="km-ui-modal-scrollable">
				<form method="post" class="inner" onsubmit="return confirm('<?php _e('This action cannot be undone. All LayerSlider data will be permanently deleted and you will not be able to restore them afterwards. Please consider every possibility before deciding.\r\n\r\n Are you sure you want to continue?', 'LayerSlider') ?>');">
					<?php wp_nonce_field('erase_data'); ?>
					<p><?php _e('When you remove LayerSlider, it does not automatically delete your settings and sliders by default to prevent accidental data loss. You can use this utility if you really want to erase all data used by LayerSlider.', 'LayerSlider') ?></p>
					<p class="km-ui-font-dark"><?php _e('The following actions will be performed when you confirm your intention to erase all plugin data:', 'LayerSlider'); ?></p>

					<ul>
						<li><?php _e('Remove the <i>wp_layerslider</i> database table, which stores your sliders.', 'LayerSlider') ?></li>
						<li><?php _e('Remove the relevant entries from the <i>wp_options</i> database table, which stores plugin settings.', 'LayerSlider') ?></li>
						<li><?php _e('Remove the relevant entries from the <i>wp_usermeta</i> database table, which stores user associated plugin settings.', 'LayerSlider') ?></li>
						<li><?php _e('Remove files and folders created by LayerSlider from the <i>/wp-content/uploads</i> directory. This will not affect your own uploads in the Media Library.', 'LayerSlider') ?></li>
						<li><?php _e('Remove created LayerSlider Debug Account (if any)', 'LayerSlider') ?></li>
						<li><?php _e('Deactivate LayerSlider as a last step.') ?></li>
					</ul>
					<p><i><?php _e('The actions above will be performed on this blog only. If you have a multisite network and you are a network administrator, then an "Apply to all sites" checkbox will appear, which you can use to erase data from every site in your network if you choose so.', 'LayerSlider') ?></i></p>

					<p><?php _e('Please note: You CANNOT UNDO this action. Please CONSIDER EVERY POSSIBILITY before choosing to erase all plugin data, as you will not be able to restore data afterwards.', 'LayerSlider') ?></p>

					<?php if( is_multisite() && current_user_can('manage_network') ) : ?>
						<p class="center centered">
							<label><input type="checkbox" name="networkwide" onclick="return confirm('<?php _e('Are you sure you want to erase plugin data from every site in network?', 'LayerSlider') ?>');"> Apply to all sites in multisite network</label>
						</p>
					<?php endif ?>

					<button type="submit" name="ls-erase-plugin-data" class="button button-primary button-hero <?php echo $isAdmin ? '' : 'disabled' ?>" <?php echo $isAdmin ? '' : 'disabled' ?>>Erase Plugin Data</button>
					<?php if( ! $isAdmin ) : ?>
					<i class="ls-notice"><?php _e('You must be an administrator to use this feature.', 'LayerSlider') ?></i>
					<?php endif ?>
				</form>
			</div>
		</div>
	</script>


	<script type="text/html" id="ls-debug-account-modal">
		<div id="ls-debug-account-modal-window">
			<header>
				<h1><?php _e('Create Debug Account', 'LayerSlider') ?></h1>
				<b class="dashicons dashicons-no"></b>
			</header>
			<div class="km-ui-modal-scrollable">
				<p><?php _e("In some cases we may need to access the admin area of your site in order to find and fix issues you may experience. This tool is intended to automatically create a debug account, so you don't have to bother to manually perform the necessary steps.", 'LayerSlider') ?></p>
				<p class="dark"><?php _e('After your confirmation, the following actions will be performed on your site:', 'LayerSlider') ?></p>
				<ul>
					<li><?php _e('A new user account named <i><span class="dark">KreaturaSupport</span></i> will be created with a randomly generated secure password.', 'LayerSlider') ?></li>
					<li><?php _e('This newly created account will have administrator permissions in order to access key pages on the admin area (e.g. the LayerSlider menu)') ?></li>
					<li><?php _e("The login credentials for this account will be emailed to us (from your site's admin email address), so we can have a look and help you as fast as possible.", 'LayerSlider') ?></li>
					<li><?php _e("You can remove this account manually after we've managed to find a solution, or at any time if you change your mind.", 'LayerSlider') ?></li>
				</ul>
				<p><?php _e('Please note: this utility is intended to make your life easier. No action will be performed without your consent. If you feel uncomfortable using it, you can always create a debug account on your own or manually edit/remove the created one at any time.', 'LayerSlider') ?></p>
				<p class="dark"><strong><?php _e('This is not an error reporting tool. Make sure to contact our support team before using this utility!', 'LayerSlider') ?></strong></p>
				<a href="<?php echo $debugCondition ? wp_nonce_url('?page=ls-system-status&action=debug_account', 'debug_account') : '#' ?>" class="button button-primary button-hero <?php echo $debugCondition ? '' : 'disabled' ?>" onclick="return confirm('Please read the description carefully. Are you sure you want to proceed?');">I understand, create debug account</a>
				<?php if( ! $debugCondition ) : ?>
				<p class="notice center centered">
					<i class="ls-notice"><?php _e('To use this feature, you must be an administrator and have activated your site with a LayerSlider purchase code.', 'LayerSlider') ?></i>
				</p>
				<?php endif ?>
			</div>
		</div>
	</script>

	<button class="button button-hero button-primary ls-phpinfo-button"><?php _e('Show Advanced Details', 'LayerSlider') ?></button>
	<button class="button button-hero button-primary ls-debug-account-button"><?php _e('Create Debug Account', 'LayerSlider') ?></button>


	<button class="button button-hero button-primary ls-erase-button"><?php _e('Erase Plugin Data', 'LayerSlider') ?></button>


	<script>

		jQuery(document).ready(function() {
			jQuery('.ls-phpinfo-button').click(function() {

				var $modal 		= kmUI.modal.open( '#ls-phpinfo-modal', {
					width: 940,
					height: 2000
				}),
					$contents 	= jQuery( jQuery('#ls-phpinfo').text() );

				$modal.find('iframe').contents().find('html').html( $contents );
			});



			jQuery('.ls-debug-account-button').click(function() {
				kmUI.modal.open('#ls-debug-account-modal');
			});



			jQuery('.ls-erase-button').click(function() {
				kmUI.modal.open('#ls-erase-modal');
			});

		});
	</script>
</div>