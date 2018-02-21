<?php
if ( !class_exists('PucDebugBarPlugin') ) {

class PucDebugBarPlugin {
	/** @var PluginUpdateChecker */
	private $updateChecker;

	public function __construct($updateChecker) {
		$this->updateChecker = $updateChecker;

		add_filter('debug_bar_panels', array($this, 'addDebugBarPanel'));
		add_action('debug_bar_enqueue_scripts', array($this, 'enqueuePanelDependencies'));

		add_action('wp_ajax_puc_debug_check_now', array($this, 'ajaxCheckNow'));
		add_action('wp_ajax_puc_debug_request_info', array($this, 'ajaxRequestInfo'));
	}

	/**
	 * Register the PUC Debug Bar panel.
	 *
	 * @param array $panels
	 * @return array
	 */
	public function addDebugBarPanel($panels) {
		require_once dirname(__FILE__) . '/debug-bar-panel.php';
		if ( current_user_can('update_plugins') && class_exists('PluginUpdateCheckerPanel') ) {
			$panels[] = new PluginUpdateCheckerPanel($this->updateChecker);
		}
		return $panels;
	}

	/**
	 * Enqueue our Debug Bar scripts and styles.
	 */
	public function enqueuePanelDependencies() {
		wp_enqueue_style(
			'puc-debug-bar-style',
			plugins_url( "/css/puc-debug-bar.css", __FILE__ ),
			array('debug-bar'),
			'20130927'
		);

		wp_enqueue_script(
			'puc-debug-bar-js',
			plugins_url( "/js/debug-bar.js", __FILE__ ),
			array('jquery'),
			'20121026'
		);
	}

	/**
	 * Run an update check and output the result. Useful for making sure that
	 * the update checking process works as expected.
	 */
	public function ajaxCheckNow() {
		if ( $_POST['slug'] !== $this->updateChecker->slug ) {
			return;
		}
		$this->preAjaxReqest();
		$update = $this->updateChecker->checkForUpdates();
		if ( $update !== null ) {
			echo "An update is available:";
			echo '<pre>', htmlentities(print_r($update, true)), '</pre>';
		} else {
			echo 'No updates found.';
		}
		exit;
	}

	/**
	 * Request plugin info and output it.
	 */
	public function ajaxRequestInfo() {
		if ( $_POST['slug'] !== $this->updateChecker->slug ) {
			return;
		}
		$this->preAjaxReqest();
		$info = $this->updateChecker->requestInfo();
		if ( $info !== null ) {
			echo 'Successfully retrieved plugin info from the metadata URL:';
			echo '<pre>', htmlentities(print_r($info, true)), '</pre>';
		} else {
			echo 'Failed to retrieve plugin info from the metadata URL.';
		}
		exit;
	}

	/**
	 * Check access permissions and enable error display (for debugging).
	 */
	private function preAjaxReqest() {
		if ( !current_user_can('update_plugins') ) {
			die('Access denied');
		}
		check_ajax_referer('puc-ajax');

		error_reporting(E_ALL);
		@ini_set('display_errors','On');
	}
}

}