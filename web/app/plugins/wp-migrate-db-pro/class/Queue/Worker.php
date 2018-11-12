<?php

namespace WPMDB\Queue;

use Exception;
use WPMDB\Queue\Connections\ConnectionInterface;
use WPMDB\Queue\Exceptions\WorkerAttemptsExceededException;

class Worker {

	/**
	 * @var ConnectionInterface
	 */
	protected $connection;

	/**
	 * @var int
	 */
	protected $attempts;

	/**
	 * Worker constructor.
	 *
	 * @param ConnectionInterface $connection
	 * @param int                 $attempts
	 */
	public function __construct( $connection, $attempts = 3 ) {
		$this->connection = $connection;
		$this->attempts   = $attempts;
	}

	/**
	 * Process a job on the queue.
	 *
	 * @return bool
	 */
	public function process() {
		$job = $this->connection->pop();

		if ( ! $job ) {
			return false;
		}

		$exception = null;

		try {
			$job->handle();
		} catch ( Exception $exception ) {
			$job->release();
		}

		if ( $job->attempts() >= $this->attempts ) {
			if ( empty( $exception ) ) {
				$exception = new WorkerAttemptsExceededException();
			}

			$job->fail();
		}

		if ( $job->failed() ) {
			$this->connection->failure( $job, $exception );
		} else if ( $job->released() ) {
			$this->connection->release( $job );
		} else {
			$this->connection->delete( $job );
		}

		return true;
	}

}
