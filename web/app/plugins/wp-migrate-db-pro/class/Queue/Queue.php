<?php

namespace WPMDB\Queue;

use WPMDB\Queue\Connections\ConnectionInterface;

class Queue {

	/**
	 * @var ConnectionInterface
	 */
	protected $connection;

	/**
	 * @var Cron
	 */
	protected $cron;

	/**
	 * Queue constructor.
	 *
	 * @param ConnectionInterface $connection
	 */
	public function __construct( ConnectionInterface $connection ) {
		$this->connection = $connection;
	}

	/**
	 * Push a job onto the queue;
	 *
	 * @param Job $job
	 * @param int $delay
	 *
	 * @return bool|int
	 */
	public function push( Job $job, $delay = 0 ) {
		return $this->connection->push( $job, $delay );
	}

	/**
	 * Create a cron worker.
	 *
	 * @param int $attempts
	 * @param int $interval
	 *
	 * @return Cron
	 */
	public function cron( $attempts = 3, $interval = 5 ) {
		if ( is_null( $this->cron ) ) {
			$this->cron	= new Cron( get_class( $this->connection ), $this->worker( $attempts ), $interval );
			$this->cron->init();
		}

		return $this->cron;
	}

	/**
	 * Create a new worker.
	 *
	 * @param int $attempts
	 *
	 * @return Worker
	 */
	public function worker( $attempts ) {
		return new Worker( $this->connection, $attempts );
	}
}
