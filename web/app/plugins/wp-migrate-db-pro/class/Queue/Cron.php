<?php

namespace WPMDB\Queue;

class Cron {

	/**
	 * @var string
	 */
	protected $id;

	/**
	 * @var Worker
	 */
	protected $worker;

	/**
	 * @var int
	 */
	protected $interval;

	/**
	 * Timestamp of when processing the queue started.
	 *
	 * @var int
	 */
	protected $start_time;

	/**
	 * Cron constructor.
	 *
	 * @param string $id
	 * @param Worker $worker
	 * @param int    $interval
	 */
	public function __construct( $id, $worker, $interval ) {
		$this->id       = strtolower( str_replace( '\\', '_', $id ) );
		$this->worker   = $worker;
		$this->interval = $interval;
	}

	/**
	 * Is the cron queue worker enabled?
	 *
	 * @return bool
	 */
	protected function is_enabled() {
		if ( defined( 'DISABLE_WP_QUEUE_CRON' ) && DISABLE_WP_QUEUE_CRON ) {
			return false;
		}

		return true;
	}

	/**
	 * Init cron class.
	 *
	 * @return bool
	 */
	public function init() {
		if ( ! $this->is_enabled() ) {
			return false;
		}

		add_filter( 'cron_schedules', array( $this, 'schedule_cron' ) );
		add_action( $this->id, array( $this, 'cron_worker' ) );

		if ( ! wp_next_scheduled( $this->id ) ) {
			// Schedule health check
			wp_schedule_event( time(), $this->id, $this->id );
		}

		return true;
	}

	/**
	 * Add interval to cron schedules.
	 *
	 * @param array $schedules
	 *
	 * @return array
	 */
	public function schedule_cron( $schedules ) {
		$schedules[ $this->id ] = array(
			'interval' => MINUTE_IN_SECONDS * $this->interval,
			'display'  => sprintf( __( 'Every %d Minutes' ), $this->interval ),
		);

		return $schedules;
	}

	/**
	 * Process any jobs in the queue.
	 */
	public function cron_worker() {
		if ( $this->is_worker_locked() ) {
			return;
		}

		$this->start_time = time();

		$this->lock_worker();

		while ( ! $this->time_exceeded() && ! $this->memory_exceeded() ) {
			if ( ! $this->worker->process() ) {
				break;
			}
		}

		$this->unlock_worker();
	}

	/**
	 * Is the cron worker locked?
	 *
	 * @return bool
	 */
	protected function is_worker_locked() {
		return (bool) get_site_transient( $this->id );
	}

	/**
	 * Lock the cron worker.
	 */
	protected function lock_worker() {
		set_site_transient( $this->id, time(), 300 );
	}

	/**
	 * Unlock the cron worker.
	 */
	protected function unlock_worker() {
		delete_site_transient( $this->id );
	}

	/**
	 * Memory exceeded
	 *
	 * Ensures the worker process never exceeds 80%
	 * of the maximum allowed PHP memory.
	 *
	 * @return bool
	 */
	protected function memory_exceeded() {
		$memory_limit   = $this->get_memory_limit() * 0.8; // 80% of max memory
		$current_memory = memory_get_usage( true );
		$return         = false;

		if ( $current_memory >= $memory_limit ) {
			$return = true;
		}

		return apply_filters( 'wp_queue_cron_memory_exceeded', $return );
	}

	/**
	 * Get memory limit.
	 *
	 * @return int
	 */
	protected function get_memory_limit() {
		if ( function_exists( 'ini_get' ) ) {
			$memory_limit = ini_get( 'memory_limit' );
		} else {
			$memory_limit = '256M';
		}

		if ( ! $memory_limit || - 1 == $memory_limit ) {
			// Unlimited, set to 1GB
			$memory_limit = '1000M';
		}

		return intval( $memory_limit ) * 1024 * 1024;
	}

	/**
	 * Time exceeded
	 *
	 * Ensures the worker never exceeds a sensible time limit (20s by default).
	 * A timeout limit of 30s is common on shared hosting.
	 *
	 * @return bool
	 */
	protected function time_exceeded() {
		$finish = $this->start_time + apply_filters( 'wp_queue_cron_time_limit', 20 ); // 20 seconds
		$return = false;

		if ( time() >= $finish ) {
			$return = true;
		}

		return apply_filters( 'wp_queue_cron_time_exceeded', $return );
	}
}
