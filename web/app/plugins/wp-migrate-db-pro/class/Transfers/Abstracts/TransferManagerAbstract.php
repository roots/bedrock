<?php

namespace WPMDB\Transfers\Abstracts;

use WPMDB\Queue\Manager;
use WPMDB\Transfers\Files\Payload;
use WPMDB\Transfers\Files\Util;

/**
 * Class TransferManagerAbstract
 *
 * @package WPMDB\Transfers\Abstracts
 */
abstract class TransferManagerAbstract {

	/**
	 * TransferManager constructor.
	 *
	 * @param $wpmdb
	 */

	public $queueManager;
	public $payload;
	public $wpmdb;
	public $util;

	public function __construct( \WPMDB_Base $wpmdb, Manager $manager, Payload $payload, Util $util ) {
		$this->wpmdb        = $wpmdb;
		$this->queueManager = $manager;
		$this->payload      = $payload;
		$this->util         = $util;
	}

	public function manage_transfer() {
	}

	public function post( $payload, $state_data, $action, $remote_url ) {
	}

	public function request( $file, $state_data, $action, $remote_url ) {
	}

	public function handle_push( $processed, $state_data, $remote_url ) {
	}

	public function handle_pull( $processed, $state_data, $remote_url ) {
	}

}
