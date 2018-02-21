<?php
/**
 * Plugin Update Checker Library 2.0.0
 * http://w-shadow.com/
 * 
 * Copyright 2015 Janis Elsts
 * Released under the  MIT license. See license.txt for details.
 */

if ( !class_exists('PluginUpdateChecker_2_0') ):

/**
 * A custom plugin update checker. 
 * 
 * @author Janis Elsts
 * @copyright 2015
 * @version 2.0
 * @access public
 */
class PluginUpdateChecker_2_0 {
	public $metadataUrl = ''; //The URL of the plugin's metadata file.
	public $pluginAbsolutePath = ''; //Full path of the main plugin file.
	public $pluginFile = '';  //Plugin filename relative to the plugins directory. Many WP APIs use this to identify plugins.
	public $slug = '';        //Plugin slug.
	public $checkPeriod = 24; //How often to check for updates (in hours).
	public $optionName = '';  //Where to store the update info.
	public $muPluginFile = ''; //For MU plugins, the plugin filename relative to the mu-plugins directory.

	public $debugMode = false; //Set to TRUE to enable error reporting. Errors are raised using trigger_error()
                               //and should be logged to the standard PHP error log.

	public $throttleRedundantChecks = false; //Check less often if we already know that an update is available.
	public $throttledCheckPeriod = 72;

	private $cronHook = null;
	private $debugBarPlugin = null;
	private $cachedInstalledVersion = null;

	/**
	 * Class constructor.
	 *
	 * @param string $metadataUrl The URL of the plugin's metadata file.
	 * @param string $pluginFile Fully qualified path to the main plugin file.
	 * @param string $slug The plugin's 'slug'. If not specified, the filename part of $pluginFile sans '.php' will be used as the slug.
	 * @param integer $checkPeriod How often to check for updates (in hours). Defaults to checking every 12 hours. Set to 0 to disable automatic update checks.
	 * @param string $optionName Where to store book-keeping info about update checks. Defaults to 'external_updates-$slug'.
	 * @param string $muPluginFile Optional. The plugin filename relative to the mu-plugins directory.
	 */
	public function __construct($metadataUrl, $pluginFile, $slug = '', $checkPeriod = 12, $optionName = '', $muPluginFile = ''){
		$this->metadataUrl = $metadataUrl;
		$this->pluginAbsolutePath = $pluginFile;
		$this->pluginFile = plugin_basename($this->pluginAbsolutePath);
		$this->muPluginFile = $muPluginFile;
		$this->checkPeriod = $checkPeriod;
		$this->slug = $slug;
		$this->optionName = $optionName;
		$this->debugMode = defined('WP_DEBUG') && WP_DEBUG;

		//If no slug is specified, use the name of the main plugin file as the slug.
		//For example, 'my-cool-plugin/cool-plugin.php' becomes 'cool-plugin'.
		if ( empty($this->slug) ){
			$this->slug = basename($this->pluginFile, '.php');
		}
		
		if ( empty($this->optionName) ){
			$this->optionName = 'external_updates-' . $this->slug;
		}

		//Backwards compatibility: If the plugin is a mu-plugin but no $muPluginFile is specified, assume
		//it's the same as $pluginFile given that it's not in a subdirectory (WP only looks in the base dir).
		if ( empty($this->muPluginFile) && (strpbrk($this->pluginFile, '/\\') === false) && $this->isMuPlugin() ) {
			$this->muPluginFile = $this->pluginFile;
		}
		
		$this->installHooks();
	}
	
	/**
	 * Install the hooks required to run periodic update checks and inject update info 
	 * into WP data structures. 
	 * 
	 * @return void
	 */
	protected function installHooks(){
		//Override requests for plugin information
		add_filter('plugins_api', array($this, 'injectInfo'), 20, 3);
		
		//Insert our update info into the update array maintained by WP
		add_filter('site_transient_update_plugins', array($this,'injectUpdate')); //WP 3.0+
		add_filter('transient_update_plugins', array($this,'injectUpdate')); //WP 2.8+

		add_filter('plugin_row_meta', array($this, 'addCheckForUpdatesLink'), 10, 2);
		add_action('admin_init', array($this, 'handleManualCheck'));
		add_action('all_admin_notices', array($this, 'displayManualCheckResult'));

		//Clear the version number cache when something - anything - is upgraded or WP clears the update cache.
		add_filter('upgrader_post_install', array($this, 'clearCachedVersion'));
		add_action('delete_site_transient_update_plugins', array($this, 'clearCachedVersion'));

		//Set up the periodic update checks
		$this->cronHook = 'check_plugin_updates-' . $this->slug;
		if ( $this->checkPeriod > 0 ){
			
			//Trigger the check via Cron.
			//Try to use one of the default schedules if possible as it's less likely to conflict
			//with other plugins and their custom schedules.
			$defaultSchedules = array(
				1  => 'hourly',
				12 => 'twicedaily',
				24 => 'daily',
			);
			if ( array_key_exists($this->checkPeriod, $defaultSchedules) ) {
				$scheduleName = $defaultSchedules[$this->checkPeriod];
			} else {
				//Use a custom cron schedule.
				$scheduleName = 'every' . $this->checkPeriod . 'hours';
				add_filter('cron_schedules', array($this, '_addCustomSchedule'));
			}

			if ( !wp_next_scheduled($this->cronHook) && !defined('WP_INSTALLING') ) {
				wp_schedule_event(time(), $scheduleName, $this->cronHook);
			}
			add_action($this->cronHook, array($this, 'maybeCheckForUpdates'));
			
			register_deactivation_hook($this->pluginFile, array($this, '_removeUpdaterCron'));
			
			//In case Cron is disabled or unreliable, we also manually trigger 
			//the periodic checks while the user is browsing the Dashboard. 
			add_action( 'admin_init', array($this, 'maybeCheckForUpdates') );

			//Like WordPress itself, we check more often on certain pages.
			/** @see wp_update_plugins */
			add_action('load-update-core.php', array($this, 'maybeCheckForUpdates'));
			add_action('load-plugins.php', array($this, 'maybeCheckForUpdates'));
			add_action('load-update.php', array($this, 'maybeCheckForUpdates'));
			//This hook fires after a bulk update is complete.
			add_action('upgrader_process_complete', array($this, 'maybeCheckForUpdates'), 11, 0);

		} else {
			//Periodic checks are disabled.
			wp_clear_scheduled_hook($this->cronHook);
		}

		if ( did_action('plugins_loaded') ) {
			$this->initDebugBarPanel();
		} else {
			add_action('plugins_loaded', array($this, 'initDebugBarPanel'));
		}

		//Rename the update directory to be the same as the existing directory.
		add_filter('upgrader_source_selection', array($this, 'fixDirectoryName'), 10, 3);
	}
	
	/**
	 * Add our custom schedule to the array of Cron schedules used by WP.
	 * 
	 * @param array $schedules
	 * @return array
	 */
	public function _addCustomSchedule($schedules){
		if ( $this->checkPeriod && ($this->checkPeriod > 0) ){
			$scheduleName = 'every' . $this->checkPeriod . 'hours';
			$schedules[$scheduleName] = array(
				'interval' => $this->checkPeriod * 3600, 
				'display' => sprintf('Every %d hours', $this->checkPeriod),
			);
		}
		return $schedules;
	}

	/**
	 * Remove the scheduled cron event that the library uses to check for updates.
	 *
	 * @return void
	 */
	public function _removeUpdaterCron(){
		wp_clear_scheduled_hook($this->cronHook);
	}

	/**
	 * Get the name of the update checker's WP-cron hook. Mostly useful for debugging.
	 *
	 * @return string
	 */
	public function getCronHookName() {
		return $this->cronHook;
	}
	
	/**
	 * Retrieve plugin info from the configured API endpoint.
	 * 
	 * @uses wp_remote_get()
	 * 
	 * @param array $queryArgs Additional query arguments to append to the request. Optional.
	 * @return PluginInfo
	 */
	public function requestInfo($queryArgs = array()){
		//Query args to append to the URL. Plugins can add their own by using a filter callback (see addQueryArgFilter()).
		$installedVersion = $this->getInstalledVersion();
		$queryArgs['installed_version'] = ($installedVersion !== null) ? $installedVersion : '';
		$queryArgs = apply_filters('puc_request_info_query_args-'.$this->slug, $queryArgs);
		
		//Various options for the wp_remote_get() call. Plugins can filter these, too.
		$options = array(
			'timeout' => 10, //seconds
			'headers' => array(
				'Accept' => 'application/json'
			),
		);
		$options = apply_filters('puc_request_info_options-'.$this->slug, $options);
		
		//The plugin info should be at 'http://your-api.com/url/here/$slug/info.json'
		$url = $this->metadataUrl; 
		if ( !empty($queryArgs) ){
			$url = add_query_arg($queryArgs, $url);
		}
		
		$result = wp_remote_get(
			$url,
			$options
		);

		//Try to parse the response
		$pluginInfo = null;
		if ( !is_wp_error($result) && isset($result['response']['code']) && ($result['response']['code'] == 200) && !empty($result['body']) ){
			$pluginInfo = PluginInfo_2_0::fromJson($result['body'], $this->debugMode);
			$pluginInfo->filename = $this->pluginFile;
			$pluginInfo->slug = $this->slug;
		} else if ( $this->debugMode ) {
			$message = sprintf("The URL %s does not point to a valid plugin metadata file. ", $url);
			if ( is_wp_error($result) ) {
				$message .= "WP HTTP error: " . $result->get_error_message();
			} else if ( isset($result['response']['code']) ) {
				$message .= "HTTP response code is " . $result['response']['code'] . " (expected: 200)";
			} else {
				$message .= "wp_remote_get() returned an unexpected result.";
			}
			trigger_error($message, E_USER_WARNING);
		}

		$pluginInfo = apply_filters('puc_request_info_result-'.$this->slug, $pluginInfo, $result);
		return $pluginInfo;
	}

	/**
	 * Retrieve the latest update (if any) from the configured API endpoint.
	 *
	 * @uses PluginUpdateChecker::requestInfo()
	 *
	 * @return PluginUpdate An instance of PluginUpdate, or NULL when no updates are available.
	 */
	public function requestUpdate(){
		//For the sake of simplicity, this function just calls requestInfo() 
		//and transforms the result accordingly.
		$pluginInfo = $this->requestInfo(array('checking_for_updates' => '1'));
		if ( $pluginInfo == null ){
			return null;
		}
		return PluginUpdate_2_0::fromPluginInfo($pluginInfo);
	}
	
	/**
	 * Get the currently installed version of the plugin.
	 * 
	 * @return string Version number.
	 */
	public function getInstalledVersion(){
		if ( isset($this->cachedInstalledVersion) ) {
			return $this->cachedInstalledVersion;
		}

		$pluginHeader = $this->getPluginHeader();
		if ( isset($pluginHeader['Version']) ) {
			$this->cachedInstalledVersion = $pluginHeader['Version'];
			return $pluginHeader['Version'];
		} else {
			//This can happen if the filename points to something that is not a plugin.
			if ( $this->debugMode ) {
				trigger_error(
					sprintf(
						"Can't to read the Version header for '%s'. The filename is incorrect or is not a plugin.",
						$this->pluginFile
					),
					E_USER_WARNING
				);
			}
			return null;
		}
	}

	/**
	 * Get plugin's metadata from its file header.
	 *
	 * @return array
	 */
	protected function getPluginHeader() {
		if ( !is_file($this->pluginAbsolutePath) ) {
			//This can happen if the plugin filename is wrong.
			if ( $this->debugMode ) {
				trigger_error(
					sprintf(
						"Can't to read the plugin header for '%s'. The file does not exist.",
						$this->pluginFile
					),
					E_USER_WARNING
				);
			}
			return array();
		}

		if ( !function_exists('get_plugin_data') ){
			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		}
		return get_plugin_data($this->pluginAbsolutePath, false, false);
	}

	/**
	 * Check for plugin updates.
	 * The results are stored in the DB option specified in $optionName.
	 *
	 * @return PluginUpdate|null
	 */
	public function checkForUpdates(){
		$installedVersion = $this->getInstalledVersion();
		//Fail silently if we can't find the plugin or read its header.
		if ( $installedVersion === null ) {
			if ( $this->debugMode ) {
				trigger_error(
					sprintf('Skipping update check for %s - installed version unknown.', $this->pluginFile),
					E_USER_WARNING
				);
			}
			return null;
		}

		$state = $this->getUpdateState();
		if ( empty($state) ){
			$state = new StdClass;
			$state->lastCheck = 0;
			$state->checkedVersion = '';
			$state->update = null;
		}
		
		$state->lastCheck = time();
		$state->checkedVersion = $installedVersion;
		$this->setUpdateState($state); //Save before checking in case something goes wrong 
		
		$state->update = $this->requestUpdate();
		$this->setUpdateState($state);

		return $this->getUpdate();
	}
	
	/**
	 * Check for updates if the configured check interval has already elapsed.
	 * Will use a shorter check interval on certain admin pages like "Dashboard -> Updates" or when doing cron.
	 *
	 * You can override the default behaviour by using the "puc_check_now-$slug" filter.
	 * The filter callback will be passed three parameters:
	 *     - Current decision. TRUE = check updates now, FALSE = don't check now.
	 *     - Last check time as a Unix timestamp.
	 *     - Configured check period in hours.
	 * Return TRUE to check for updates immediately, or FALSE to cancel.
	 *
	 * This method is declared public because it's a hook callback. Calling it directly is not recommended.
	 */
	public function maybeCheckForUpdates(){
		if ( empty($this->checkPeriod) ){
			return;
		}

		$currentFilter = current_filter();
		if ( in_array($currentFilter, array('load-update-core.php', 'upgrader_process_complete')) ) {
			//Check more often when the user visits "Dashboard -> Updates" or does a bulk update.
			$timeout = 60;
		} else if ( in_array($currentFilter, array('load-plugins.php', 'load-update.php')) ) {
			//Also check more often on the "Plugins" page and /wp-admin/update.php.
			$timeout = 3600;
		} else if ( $this->throttleRedundantChecks && ($this->getUpdate() !== null) ) {
			//Check less frequently if it's already known that an update is available.
			$timeout = $this->throttledCheckPeriod * 3600;
		} else if ( defined('DOING_CRON') && constant('DOING_CRON') ) {
			//WordPress cron schedules are not exact, so lets do an update check even
			//if slightly less than $checkPeriod hours have elapsed since the last check.
			$cronFuzziness = 20 * 60;
			$timeout = $this->checkPeriod * 3600 - $cronFuzziness;
		} else {
			$timeout = $this->checkPeriod * 3600;
		}

		$state = $this->getUpdateState();
		$shouldCheck =
			empty($state) ||
			!isset($state->lastCheck) ||
			( (time() - $state->lastCheck) >= $timeout );

		//Let plugin authors substitute their own algorithm.
		$shouldCheck = apply_filters(
			'puc_check_now-' . $this->slug,
			$shouldCheck,
			(!empty($state) && isset($state->lastCheck)) ? $state->lastCheck : 0,
			$this->checkPeriod
		);

		if ( $shouldCheck ){
			$this->checkForUpdates();
		}
	}
	
	/**
	 * Load the update checker state from the DB.
	 *  
	 * @return StdClass|null
	 */
	public function getUpdateState() {
		$state = get_site_option($this->optionName, null);
		if ( empty($state) || !is_object($state)) {
			$state = null;
		}

		if ( !empty($state) && isset($state->update) && is_object($state->update) ){
			$state->update = PluginUpdate_2_0::fromObject($state->update);
		}
		return $state;
	}
	
	
	/**
	 * Persist the update checker state to the DB.
	 * 
	 * @param StdClass $state
	 * @return void
	 */
	private function setUpdateState($state) {
		if ( isset($state->update) && is_object($state->update) && method_exists($state->update, 'toStdClass') ) {
			$update = $state->update; /** @var PluginUpdate $update */
			$state->update = $update->toStdClass();
		}
		update_site_option($this->optionName, $state);
	}

	/**
	 * Reset update checker state - i.e. last check time, cached update data and so on.
	 *
	 * Call this when your plugin is being uninstalled, or if you want to
	 * clear the update cache.
	 */
	public function resetUpdateState() {
		delete_site_option($this->optionName);
	}
	
	/**
	 * Intercept plugins_api() calls that request information about our plugin and 
	 * use the configured API endpoint to satisfy them. 
	 * 
	 * @see plugins_api()
	 * 
	 * @param mixed $result
	 * @param string $action
	 * @param array|object $args
	 * @return mixed
	 */
	public function injectInfo($result, $action = null, $args = null){
    	$relevant = ($action == 'plugin_information') && isset($args->slug) && (
			($args->slug == $this->slug) || ($args->slug == dirname($this->pluginFile))
		);
		if ( !$relevant ){
			return $result;
		}
		
		$pluginInfo = $this->requestInfo();
		$pluginInfo = apply_filters('puc_pre_inject_info-' . $this->slug, $pluginInfo);
		if ($pluginInfo){
			return $pluginInfo->toWpFormat();
		}
				
		return $result;
	}
	
	/**
	 * Insert the latest update (if any) into the update list maintained by WP.
	 * 
	 * @param StdClass $updates Update list.
	 * @return StdClass Modified update list.
	 */
	public function injectUpdate($updates){
		//Is there an update to insert?
		$update = $this->getUpdate();

		//No update notifications for mu-plugins unless explicitly enabled. The MU plugin file
		//is usually different from the main plugin file so the update wouldn't show up properly anyway.
		if ( !empty($update) && empty($this->muPluginFile) && $this->isMuPlugin() ) {
			$update = null;
		}

		if ( !empty($update) ) {
			//Let plugins filter the update info before it's passed on to WordPress.
			$update = apply_filters('puc_pre_inject_update-' . $this->slug, $update);
			if ( !is_object($updates) ) {
				$updates = new StdClass();
				$updates->response = array();
			}

			$wpUpdate = $update->toWpFormat();
			$pluginFile = $this->pluginFile;

			if ( $this->isMuPlugin() ) {
				//WP does not support automatic update installation for mu-plugins, but we can still display a notice.
				$wpUpdate->package = null;
				$pluginFile = $this->muPluginFile;
			}
			$updates->response[$pluginFile] = $wpUpdate;

		} else if ( isset($updates, $updates->response) ) {
			unset($updates->response[$this->pluginFile]);
			if ( !empty($this->muPluginFile) ) {
				unset($updates->response[$this->muPluginFile]);
			}
		}

		return $updates;
	}

	/**
	 * Rename the update directory to match the existing plugin directory.
	 *
	 * When WordPress installs a plugin or theme update, it assumes that the ZIP file will contain
	 * exactly one directory, and that the directory name will be the same as the directory where
	 * the plugin/theme is currently installed.
	 *
	 * GitHub and other repositories provide ZIP downloads, but they often use directory names like
	 * "project-branch" or "project-tag-hash". We need to change the name to the actual plugin folder.
	 *
	 * @param string $source The directory to copy to /wp-content/plugins. Usually a subdirectory of $remoteSource.
	 * @param string $remoteSource WordPress has extracted the update to this directory.
	 * @param WP_Upgrader $upgrader
	 * @return string|WP_Error
	 */
	function fixDirectoryName($source, $remoteSource, $upgrader) {
		global $wp_filesystem; /** @var WP_Filesystem_Base $wp_filesystem */

		//Basic sanity checks.
		if ( !isset($source, $remoteSource, $upgrader, $upgrader->skin, $wp_filesystem) ) {
			return $source;
		}

		//Figure out which plugin is being upgraded.
		$pluginFile = null;
		$skin = $upgrader->skin;
		if ( $skin instanceof Plugin_Upgrader_Skin ) {
			if ( isset($skin->plugin) && is_string($skin->plugin) && ($skin->plugin !== '') ) {
				$pluginFile = $skin->plugin;
			}
		} elseif ( $upgrader->skin instanceof Bulk_Plugin_Upgrader_Skin ) {
			//This case is tricky because Bulk_Plugin_Upgrader_Skin doesn't actually store the plugin
			//filename anywhere. Instead, it has the plugin headers in $plugin_info. So the best we can
			//do is compare those headers to the headers of installed plugins.
			if ( isset($skin->plugin_info) && is_array($skin->plugin_info) ) {
				if ( !function_exists('get_plugins') ){
					require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
				}

				$installedPlugins = get_plugins();
				$matches = array();
				foreach($installedPlugins as $pluginBasename => $headers) {
					$diff1 = array_diff_assoc($headers, $skin->plugin_info);
					$diff2 = array_diff_assoc($skin->plugin_info, $headers);
					if ( empty($diff1) && empty($diff2) ) {
						$matches[] = $pluginBasename;
					}
				}

				//It's possible (though very unlikely) that there could be two plugins with identical
				//headers. In that case, we can't unambiguously identify the plugin that's being upgraded.
				if ( count($matches) !== 1 ) {
					return $source;
				}

				$pluginFile = reset($matches);
			}
		}

		//If WordPress is upgrading anything other than our plugin, leave the directory name unchanged.
		if ( empty($pluginFile) || ($pluginFile !== $this->pluginFile) ) {
			return $source;
		}

		//Rename the source to match the existing plugin directory.
		$pluginDirectoryName = dirname($this->pluginFile);
		if ( ($pluginDirectoryName === '.') || ($pluginDirectoryName === '/') ) {
			return $source;
		}
		$correctedSource = trailingslashit($remoteSource) . $pluginDirectoryName . '/';
		if ( $source !== $correctedSource ) {
			//The update archive should contain a single directory that contains the rest of plugin files. Otherwise,
			//WordPress will try to copy the entire working directory ($source == $remoteSource). We can't rename
			//$remoteSource because that would break WordPress code that cleans up temporary files after update.
			$sourceFiles = $wp_filesystem->dirlist($remoteSource);
			if ( is_array($sourceFiles) ) {
				$sourceFiles = array_keys($sourceFiles);
				$firstFilePath = trailingslashit($remoteSource) . $sourceFiles[0];

				if ( (count($sourceFiles) > 1) || (!$wp_filesystem->is_dir($firstFilePath)) ) {
					return new WP_Error(
						'puc-incorrect-directory-structure',
						sprintf(
							'The directory structure of the update is incorrect. All plugin files should be inside ' .
							'a directory named <span class="code">%s</span>, not at the root of the ZIP file.',
							htmlentities($this->slug)
						)
					);
				}
			}

			$upgrader->skin->feedback(sprintf(
				'Renaming %s to %s&#8230;',
				'<span class="code">' . basename($source) . '</span>',
				'<span class="code">' . $pluginDirectoryName . '</span>'
			));

			if ( $wp_filesystem->move($source, $correctedSource, true) ) {
				$upgrader->skin->feedback('Plugin directory successfully renamed.');
				return $correctedSource;
			} else {
				return new WP_Error(
					'puc-rename-failed',
					'Unable to rename the update to match the existing plugin directory.'
				);
			}
		}

		return $source;
	}


	/**
	 * Get the details of the currently available update, if any.
	 *
	 * If no updates are available, or if the last known update version is below or equal
	 * to the currently installed version, this method will return NULL.
	 *
	 * Uses cached update data. To retrieve update information straight from
	 * the metadata URL, call requestUpdate() instead.
	 *
	 * @return PluginUpdate|null
	 */
	public function getUpdate() {
		$state = $this->getUpdateState(); /** @var StdClass $state */

		//Is there an update available insert?
		if ( !empty($state) && isset($state->update) && !empty($state->update) ){
			$update = $state->update;
			//Check if the update is actually newer than the currently installed version.
			$installedVersion = $this->getInstalledVersion();
			if ( ($installedVersion !== null) && version_compare($update->version, $installedVersion, '>') ){
				$update->filename = $this->pluginFile;
				return $update;
			}
		}
		return null;
	}

	/**
	 * Add a "Check for updates" link to the plugin row in the "Plugins" page. By default,
	 * the new link will appear after the "Visit plugin site" link.
	 *
	 * You can change the link text by using the "puc_manual_check_link-$slug" filter.
	 * Returning an empty string from the filter will disable the link.
	 *
	 * @param array $pluginMeta Array of meta links.
	 * @param string $pluginFile
	 * @return array
	 */
	public function addCheckForUpdatesLink($pluginMeta, $pluginFile) {
		$isRelevant = ($pluginFile == $this->pluginFile)
		              || (!empty($this->muPluginFile) && $pluginFile == $this->muPluginFile);

		if ( $isRelevant && current_user_can('update_plugins') ) {
			$linkUrl = wp_nonce_url(
				add_query_arg(
					array(
						'puc_check_for_updates' => 1,
						'puc_slug' => $this->slug,
					),
					is_network_admin() ? network_admin_url('plugins.php') : admin_url('plugins.php')
				),
				'puc_check_for_updates'
			);

			$linkText = apply_filters('puc_manual_check_link-' . $this->slug, 'Check for updates');
			if ( !empty($linkText) ) {
				$pluginMeta[] = sprintf('<a href="%s">%s</a>', esc_attr($linkUrl), $linkText);
			}
		}
		return $pluginMeta;
	}

	/**
	 * Check for updates when the user clicks the "Check for updates" link.
	 * @see self::addCheckForUpdatesLink()
	 *
	 * @return void
	 */
	public function handleManualCheck() {
		$shouldCheck =
			   isset($_GET['puc_check_for_updates'], $_GET['puc_slug'])
			&& $_GET['puc_slug'] == $this->slug
			&& current_user_can('update_plugins')
			&& check_admin_referer('puc_check_for_updates');

		if ( $shouldCheck ) {
			$update = $this->checkForUpdates();
			$status = ($update === null) ? 'no_update' : 'update_available';
			wp_redirect(add_query_arg(
					array(
					     'puc_update_check_result' => $status,
					     'puc_slug' => $this->slug,
					),
					is_network_admin() ? network_admin_url('plugins.php') : admin_url('plugins.php')
			));
		}
	}

	/**
	 * Display the results of a manual update check.
	 * @see self::handleManualCheck()
	 *
	 * You can change the result message by using the "puc_manual_check_message-$slug" filter.
	 */
	public function displayManualCheckResult() {
		if ( isset($_GET['puc_update_check_result'], $_GET['puc_slug']) && ($_GET['puc_slug'] == $this->slug) ) {
			$status = strval($_GET['puc_update_check_result']);
			if ( $status == 'no_update' ) {
				$message = 'This plugin is up to date.';
			} else if ( $status == 'update_available' ) {
				$message = 'A new version of this plugin is available.';
			} else {
				$message = sprintf('Unknown update checker status "%s"', htmlentities($status));
			}
			printf(
				'<div class="updated"><p>%s</p></div>',
				apply_filters('puc_manual_check_message-' . $this->slug, $message, $status)
			);
		}
	}

	/**
	 * Check if the plugin file is inside the mu-plugins directory.
	 *
	 * @return bool
	 */
	protected function isMuPlugin() {
		static $cachedResult = null;

		if ( $cachedResult === null ) {
			//Convert both paths to the canonical form before comparison.
			$muPluginDir = realpath(WPMU_PLUGIN_DIR);
			$pluginPath  = realpath($this->pluginAbsolutePath);

			$cachedResult = (strpos($pluginPath, $muPluginDir) === 0);
		}

		return $cachedResult;
	}

	/**
	 * Clear the cached plugin version. This method can be set up as a filter (hook) and will
	 * return the filter argument unmodified.
	 *
	 * @param mixed $filterArgument
	 * @return mixed
	 */
	public function clearCachedVersion($filterArgument = null) {
		$this->cachedInstalledVersion = null;
		return $filterArgument;
	}

	/**
	 * Register a callback for filtering query arguments. 
	 * 
	 * The callback function should take one argument - an associative array of query arguments.
	 * It should return a modified array of query arguments.
	 * 
	 * @uses add_filter() This method is a convenience wrapper for add_filter().
	 * 
	 * @param callable $callback
	 * @return void
	 */
	public function addQueryArgFilter($callback){
		add_filter('puc_request_info_query_args-'.$this->slug, $callback);
	}
	
	/**
	 * Register a callback for filtering arguments passed to wp_remote_get().
	 * 
	 * The callback function should take one argument - an associative array of arguments -
	 * and return a modified array or arguments. See the WP documentation on wp_remote_get()
	 * for details on what arguments are available and how they work. 
	 * 
	 * @uses add_filter() This method is a convenience wrapper for add_filter().
	 * 
	 * @param callable $callback
	 * @return void
	 */
	public function addHttpRequestArgFilter($callback){
		add_filter('puc_request_info_options-'.$this->slug, $callback);
	}
	
	/**
	 * Register a callback for filtering the plugin info retrieved from the external API.
	 * 
	 * The callback function should take two arguments. If the plugin info was retrieved 
	 * successfully, the first argument passed will be an instance of  PluginInfo. Otherwise, 
	 * it will be NULL. The second argument will be the corresponding return value of 
	 * wp_remote_get (see WP docs for details).
	 *  
	 * The callback function should return a new or modified instance of PluginInfo or NULL.
	 * 
	 * @uses add_filter() This method is a convenience wrapper for add_filter().
	 * 
	 * @param callable $callback
	 * @return void
	 */
	public function addResultFilter($callback){
		add_filter('puc_request_info_result-'.$this->slug, $callback, 10, 2);
	}

	/**
	 * Register a callback for one of the update checker filters.
	 *
	 * Identical to add_filter(), except it automatically adds the "puc_" prefix
	 * and the "-$plugin_slug" suffix to the filter name. For example, "request_info_result"
	 * becomes "puc_request_info_result-your_plugin_slug".
	 *
	 * @param string $tag
	 * @param callable $callback
	 * @param int $priority
	 * @param int $acceptedArgs
	 */
	public function addFilter($tag, $callback, $priority = 10, $acceptedArgs = 1) {
		add_filter('puc_' . $tag . '-' . $this->slug, $callback, $priority, $acceptedArgs);
	}

	/**
	 * Initialize the update checker Debug Bar plugin/add-on thingy.
	 */
	public function initDebugBarPanel() {
		if ( class_exists('Debug_Bar') ) {
			require_once dirname(__FILE__) . '/debug-bar-plugin.php';
			$this->debugBarPlugin = new PucDebugBarPlugin($this);
		}
	}
}

endif;

if ( !class_exists('PluginInfo_2_0') ):

/**
 * A container class for holding and transforming various plugin metadata.
 * 
 * @author Janis Elsts
 * @copyright 2015
 * @version 2.0
 * @access public
 */
class PluginInfo_2_0 {
	//Most fields map directly to the contents of the plugin's info.json file.
	//See the relevant docs for a description of their meaning.  
	public $name;
	public $slug;
	public $version;
	public $homepage;
	public $sections;
	public $banners;
	public $download_url;

	public $author;
	public $author_homepage;
	
	public $requires;
	public $tested;
	public $upgrade_notice;
	
	public $rating;
	public $num_ratings;
	public $downloaded;
	public $last_updated;
	
	public $id = 0; //The native WP.org API returns numeric plugin IDs, but they're not used for anything.

	public $filename; //Plugin filename relative to the plugins directory.
		
	/**
	 * Create a new instance of PluginInfo from JSON-encoded plugin info 
	 * returned by an external update API.
	 * 
	 * @param string $json Valid JSON string representing plugin info.
	 * @param bool $triggerErrors
	 * @return PluginInfo|null New instance of PluginInfo, or NULL on error.
	 */
	public static function fromJson($json, $triggerErrors = false){
		/** @var StdClass $apiResponse */
		$apiResponse = json_decode($json);
		if ( empty($apiResponse) || !is_object($apiResponse) ){
			if ( $triggerErrors ) {
				trigger_error(
					"Failed to parse plugin metadata. Try validating your .json file with http://jsonlint.com/",
					E_USER_NOTICE
				);
			}
			return null;
		}
		
		//Very, very basic validation.
		$valid = isset($apiResponse->name) && !empty($apiResponse->name) && isset($apiResponse->version) && !empty($apiResponse->version);
		if ( !$valid ){
			if ( $triggerErrors ) {
				trigger_error(
					"The plugin metadata file does not contain the required 'name' and/or 'version' keys.",
					E_USER_NOTICE
				);
			}
			return null;
		}
		
		$info = new self();
		foreach(get_object_vars($apiResponse) as $key => $value){
			$info->$key = $value;
		}
		
		return $info;		
	}
	
	/**
	 * Transform plugin info into the format used by the native WordPress.org API
	 * 
	 * @return object
	 */
	public function toWpFormat(){
		$info = new StdClass;
		
		//The custom update API is built so that many fields have the same name and format
		//as those returned by the native WordPress.org API. These can be assigned directly. 
		$sameFormat = array(
			'name', 'slug', 'version', 'requires', 'tested', 'rating', 'upgrade_notice',
			'num_ratings', 'downloaded', 'homepage', 'last_updated',
		);
		foreach($sameFormat as $field){
			if ( isset($this->$field) ) {
				$info->$field = $this->$field;
			} else {
				$info->$field = null;
			}
		}

		//Other fields need to be renamed and/or transformed.
		$info->download_link = $this->download_url;
		
		if ( !empty($this->author_homepage) ){
			$info->author = sprintf('<a href="%s">%s</a>', $this->author_homepage, $this->author);
		} else {
			$info->author = $this->author;
		}
		
		if ( is_object($this->sections) ){
			$info->sections = get_object_vars($this->sections);
		} elseif ( is_array($this->sections) ) {
			$info->sections = $this->sections;
		} else {
			$info->sections = array('description' => '');
		}

		if ( !empty($this->banners) ) {
			//WP expects an array with two keys: "high" and "low". Both are optional.
			//Docs: https://wordpress.org/plugins/about/faq/#banners
			$info->banners = is_object($this->banners) ? get_object_vars($this->banners) : $this->banners;
			$info->banners = array_intersect_key($info->banners, array('high' => true, 'low' => true));
		}

		return $info;
	}
}
	
endif;

if ( !class_exists('PluginUpdate_2_0') ):

/**
 * A simple container class for holding information about an available update.
 * 
 * @author Janis Elsts
 * @copyright 2015
 * @version 2.0
 * @access public
 */
class PluginUpdate_2_0 {
	public $id = 0;
	public $slug;
	public $version;
	public $homepage;
	public $download_url;
	public $upgrade_notice;
	public $filename; //Plugin filename relative to the plugins directory.

	private static $fields = array('id', 'slug', 'version', 'homepage', 'download_url', 'upgrade_notice', 'filename');
	
	/**
	 * Create a new instance of PluginUpdate from its JSON-encoded representation.
	 * 
	 * @param string $json
	 * @param bool $triggerErrors
	 * @return PluginUpdate|null
	 */
	public static function fromJson($json, $triggerErrors = false){
		//Since update-related information is simply a subset of the full plugin info,
		//we can parse the update JSON as if it was a plugin info string, then copy over
		//the parts that we care about.
		$pluginInfo = PluginInfo_2_0::fromJson($json, $triggerErrors);
		if ( $pluginInfo != null ) {
			return self::fromPluginInfo($pluginInfo);
		} else {
			return null;
		}
	}

	/**
	 * Create a new instance of PluginUpdate based on an instance of PluginInfo.
	 * Basically, this just copies a subset of fields from one object to another.
	 * 
	 * @param PluginInfo $info
	 * @return PluginUpdate
	 */
	public static function fromPluginInfo($info){
		return self::fromObject($info);
	}
	
	/**
	 * Create a new instance of PluginUpdate by copying the necessary fields from 
	 * another object.
	 *  
	 * @param StdClass|PluginInfo|PluginUpdate $object The source object.
	 * @return PluginUpdate The new copy.
	 */
	public static function fromObject($object) {
		$update = new self();
		$fields = self::$fields;
		if (!empty($object->slug)) $fields = apply_filters('puc_retain_fields-'.$object->slug, $fields);
		foreach($fields as $field){
			if (property_exists($object, $field)) {
				$update->$field = $object->$field;
			}
		}
		return $update;
	}
	
	/**
	 * Create an instance of StdClass that can later be converted back to 
	 * a PluginUpdate. Useful for serialization and caching, as it avoids
	 * the "incomplete object" problem if the cached value is loaded before
	 * this class.
	 * 
	 * @return StdClass
	 */
	public function toStdClass() {
		$object = new StdClass();
		$fields = self::$fields;
		if (!empty($this->slug)) $fields = apply_filters('puc_retain_fields-'.$this->slug, $fields);
		foreach($fields as $field){
			if (property_exists($this, $field)) {
				$object->$field = $this->$field;
			}
		}
		return $object;
	}
	
	
	/**
	 * Transform the update into the format used by WordPress native plugin API.
	 * 
	 * @return object
	 */
	public function toWpFormat(){
		$update = new StdClass;

		$update->id = $this->id;
		$update->slug = $this->slug;
		$update->new_version = $this->version;
		$update->url = $this->homepage;
		$update->package = $this->download_url;
		$update->plugin = $this->filename;

		if ( !empty($this->upgrade_notice) ){
			$update->upgrade_notice = $this->upgrade_notice;
		}
		
		return $update;
	}
}
	
endif;

if ( !class_exists('PucFactory') ):

/**
 * A factory that builds instances of other classes from this library.
 *
 * When multiple versions of the same class have been loaded (e.g. PluginUpdateChecker 1.2
 * and 1.3), this factory will always use the latest available version. Register class
 * versions by calling {@link PucFactory::addVersion()}.
 *
 * At the moment it can only build instances of the PluginUpdateChecker class. Other classes
 * are intended mainly for internal use and refer directly to specific implementations. If you
 * want to instantiate one of them anyway, you can use {@link PucFactory::getLatestClassVersion()}
 * to get the class name and then create it with <code>new $class(...)</code>.
 */
class PucFactory {
	protected static $classVersions = array();
	protected static $sorted = false;

	/**
	 * Create a new instance of PluginUpdateChecker.
	 *
	 * @see PluginUpdateChecker::__construct()
	 *
	 * @param $metadataUrl
	 * @param $pluginFile
	 * @param string $slug
	 * @param int $checkPeriod
	 * @param string $optionName
	 * @param string $muPluginFile
	 * @return PluginUpdateChecker
	 */
	public static function buildUpdateChecker($metadataUrl, $pluginFile, $slug = '', $checkPeriod = 12, $optionName = '', $muPluginFile = '') {
		$class = self::getLatestClassVersion('PluginUpdateChecker');
		return new $class($metadataUrl, $pluginFile, $slug, $checkPeriod, $optionName, $muPluginFile);
	}

	/**
	 * Get the specific class name for the latest available version of a class.
	 *
	 * @param string $class
	 * @return string|null
	 */
	public static function getLatestClassVersion($class) {
		if ( !self::$sorted ) {
			self::sortVersions();
		}

		if ( isset(self::$classVersions[$class]) ) {
			return reset(self::$classVersions[$class]);
		} else {
			return null;
		}
	}

	/**
	 * Sort available class versions in descending order (i.e. newest first).
	 */
	protected static function sortVersions() {
		foreach ( self::$classVersions as $class => $versions ) {
			uksort($versions, array(__CLASS__, 'compareVersions'));
			self::$classVersions[$class] = $versions;
		}
		self::$sorted = true;
	}

	protected static function compareVersions($a, $b) {
		return -version_compare($a, $b);
	}

	/**
	 * Register a version of a class.
	 *
	 * @access private This method is only for internal use by the library.
	 *
	 * @param string $generalClass Class name without version numbers, e.g. 'PluginUpdateChecker'.
	 * @param string $versionedClass Actual class name, e.g. 'PluginUpdateChecker_1_2'.
	 * @param string $version Version number, e.g. '1.2'.
	 */
	public static function addVersion($generalClass, $versionedClass, $version) {
		if ( !isset(self::$classVersions[$generalClass]) ) {
			self::$classVersions[$generalClass] = array();
		}
		self::$classVersions[$generalClass][$version] = $versionedClass;
		self::$sorted = false;
	}
}

endif;

require_once(dirname(__FILE__) . '/github-checker.php');

//Register classes defined in this file with the factory.
PucFactory::addVersion('PluginUpdateChecker', 'PluginUpdateChecker_2_0', '2.0');
PucFactory::addVersion('PluginUpdate', 'PluginUpdate_2_0', '2.0');
PucFactory::addVersion('PluginInfo', 'PluginInfo_2_0', '2.0');
PucFactory::addVersion('PucGitHubChecker', 'PucGitHubChecker_2_0', '2.0');

/**
 * Create non-versioned variants of the update checker classes. This allows for backwards
 * compatibility with versions that did not use a factory, and it simplifies doc-comments.
 */
if ( !class_exists('PluginUpdateChecker') ) {
	class PluginUpdateChecker extends PluginUpdateChecker_2_0 { }
}

if ( !class_exists('PluginUpdate') ) {
	class PluginUpdate extends PluginUpdate_2_0 {}
}

if ( !class_exists('PluginInfo') ) {
	class PluginInfo extends PluginInfo_2_0 {}
}
