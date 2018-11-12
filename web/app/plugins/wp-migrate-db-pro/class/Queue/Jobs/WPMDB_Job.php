<?php

namespace WPMDB\Queue\Jobs;

/**
 * Class WPMDB_Job
 *
 * @package WPMDB\Queue\Jobs
 */
class WPMDB_Job extends \WPMDB\Queue\Job {

	public $file;

	public function __construct( $file ) {
		$this->file = $file;
	}

	/**
	 * Handle job logic.
	 */
	public function handle() {
		return true;
	}

}
