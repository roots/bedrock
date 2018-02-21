<?php

if ( !class_exists('PluginUpdateCheckerPanel') && class_exists('Debug_Bar_Panel') ) {

/**
 * A Debug Bar panel for the plugin update checker.
 */
class PluginUpdateCheckerPanel extends Debug_Bar_Panel {
	/** @var PluginUpdateChecker */
	private $updateChecker;

	public function __construct($updateChecker) {
		$this->updateChecker = $updateChecker;
		$title = sprintf(
			'<span id="puc-debug-menu-link-%s">PUC (%s)</span>',
			esc_attr($this->updateChecker->slug),
			$this->updateChecker->slug
		);
		parent::Debug_Bar_Panel($title);
	}

	public function render() {
		printf(
			'<div class="puc-debug-bar-panel" id="puc-debug-bar-panel_%1$s" data-slug="%1$s" data-nonce="%2$s">',
			esc_attr($this->updateChecker->slug),
			esc_attr(wp_create_nonce('puc-ajax'))
		);

		$responseBox = '<div class="puc-ajax-response" style="display: none;"></div>';

		echo '<h3>Configuration</h3>';
		echo '<table class="puc-debug-data">';
		$this->row('Plugin file', htmlentities($this->updateChecker->pluginFile));
		$this->row('Slug', htmlentities($this->updateChecker->slug));
		$this->row('DB option', htmlentities($this->updateChecker->optionName));

		$requestInfoButton = '';
		if ( function_exists('get_submit_button') ) {
			$requestInfoButton = get_submit_button('Request Info', 'secondary', 'puc-request-info-button', false, array('id' => 'puc-request-info-button-' . $this->updateChecker->slug));
		}
		$this->row('Metadata URL', htmlentities($this->updateChecker->metadataUrl) . ' ' . $requestInfoButton . $responseBox);

		if ( $this->updateChecker->checkPeriod > 0 ) {
			$this->row('Automatic checks', 'Every ' . $this->updateChecker->checkPeriod . ' hours');
		} else {
			$this->row('Automatic checks', 'Disabled');
		}

		if ( isset($this->updateChecker->throttleRedundantChecks) ) {
			if ( $this->updateChecker->throttleRedundantChecks && ($this->updateChecker->checkPeriod > 0) ) {
				$this->row(
					'Throttling',
					sprintf(
						'Enabled. If an update is already available, check for updates every %1$d hours instead of every %2$d hours.',
						$this->updateChecker->throttledCheckPeriod,
						$this->updateChecker->checkPeriod
					)
				);
			} else {
				$this->row('Throttling', 'Disabled');
			}
		}
		echo '</table>';

		echo '<h3>Status</h3>';
		echo '<table class="puc-debug-data">';
		$state = $this->updateChecker->getUpdateState();
		$checkNowButton = '';
		if ( function_exists('get_submit_button')  ) {
			$checkNowButton = get_submit_button('Check Now', 'secondary', 'puc-check-now-button', false, array('id' => 'puc-check-now-button-' . $this->updateChecker->slug));
		}

		if ( isset($state, $state->lastCheck) ) {
			$this->row('Last check', $this->formatTimeWithDelta($state->lastCheck) . ' ' . $checkNowButton . $responseBox);
		} else {
			$this->row('Last check', 'Never');
		}

		$nextCheck = wp_next_scheduled($this->updateChecker->getCronHookName());
		$this->row('Next automatic check', $this->formatTimeWithDelta($nextCheck));

		if ( isset($state, $state->checkedVersion) ) {
			$this->row('Checked version', htmlentities($state->checkedVersion));
			$this->row('Cached update', $state->update);
		}
		$this->row('Update checker class', htmlentities(get_class($this->updateChecker)));
		echo '</table>';

		$update = $this->updateChecker->getUpdate();
		if ( $update !== null ) {
			echo '<h3>An Update Is Available</h3>';
			echo '<table class="puc-debug-data">';
			$fields = array('version', 'download_url', 'slug', 'homepage', 'upgrade_notice');
			foreach($fields as $field) {
				$this->row(ucwords(str_replace('_', ' ', $field)), htmlentities($update->$field));
			}
			echo '</table>';
		} else {
			echo '<h3>No updates currently available</h3>';
		}

		echo '</div>';
	}

	private function formatTimeWithDelta($unixTime) {
		if ( empty($unixTime) ) {
			return 'Never';
		}

		$delta = time() - $unixTime;
		$result = human_time_diff(time(), $unixTime);
		if ( $delta < 0 ) {
			$result = 'after ' . $result;
		} else {
			$result = $result . ' ago';
		}
		$result .= ' (' . $this->formatTimestamp($unixTime) . ')';
		return $result;
	}

	private function formatTimestamp($unixTime) {
		return gmdate('Y-m-d H:i:s', $unixTime + (get_option('gmt_offset') * 3600));
	}

	private function row($name, $value) {
		if ( is_object($value) || is_array($value) ) {
			$value = '<pre>' . htmlentities(print_r($value, true)) . '</pre>';
		} else if ($value === null) {
			$value = '<code>null</code>';
		}
		printf('<tr><th scope="row">%1$s</th> <td>%2$s</td></tr>', $name, $value);
	}
}

}
