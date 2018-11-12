<?php

namespace WPMDB\Transfers\Files;

use \WPMDB\Transfers\Receiver;
use \WPMDB\Transfers\Sender;
use \WPMDB\Queue\Manager;

/**
 * Class TransferManager
 *
 * @package WPMDB\Transfers\Files
 */
class TransferManager extends \WPMDB\Transfers\Abstracts\TransferManagerAbstract {

	/**
	 * TransferManager constructor.
	 *
	 * @param $wpmdb
	 */

	public $queueManager;
	public $payload;
	public $wpmdb;
	public $util;

	public function __construct(
		\WPMDB_Base $wpmdb,
		Manager $manager,
		Payload $payload,
		Util $util
	) {
		parent::__construct( $wpmdb, $manager, $payload, $util );
		$this->wpmdb        = $wpmdb;
		$this->queueManager = $manager;
		$this->payload      = $payload;
		$this->util         = $util;
	}

	/**
	 *
	 * Logic to handle pushes or pulls of files
	 *
	 * @param string $remote_url
	 * @param array  $processed  list of files to transfer
	 * @param array  $state_data MDB's array of $_POST[] items
	 *
	 * @see $this->ajax_initiate_file_migration
	 *
	 * @return mixed
	 */
	public function manage_file_transfer( $remote_url, $processed, $state_data ) {
		if ( 'pull' === $state_data['intent'] ) {
			return $this->handle_pull( $processed, $state_data, $remote_url );
		}

		return $this->handle_push( $processed, $state_data, $remote_url );
	}

	/**
	 * @param array  $processed
	 * @param array  $state_data
	 * @param string $remote_url
	 *
	 * @return array
	 */
	public function handle_push( $processed, $state_data, $remote_url ) {
		$actual_bottleneck = min(
			$state_data['site_details']['remote']['max_request_size'], // Slider on remote's settings tab
			$state_data['site_details']['remote']['transfer_bottleneck'] //Actual PHP values for post_max_size and max_upload_size
		);

		// Max of 1MB for post requests as we're chunking anyway
		$bottleneck = apply_filters( 'wpmdb_transfers_push_bottleneck', min( 1000000, $actual_bottleneck ) );

		// Remove 1KB from the bottleneck as some hosts have a 1MB bottleneck
		$bottleneck -= 1000;

		$batch      = [];
		$total_size = 0;

		// Get subset of files to combine into a payload
		foreach ( $processed as $key => $file ) {
			$batch[] = $file;

			// This is a loose enforcement, actual payload size limit is implemented in Payload::create_payload()
			if ( ( $total_size + $file['size'] ) >= $bottleneck ) {
				break;
			}

			$total_size += $file['size'];
		}

		list( $count, $sent, $handle, $chunked ) = $this->payload->create_payload( $batch, $state_data, $bottleneck );

		// If we're not chunking OR chunking is complete, remove file(s) from queue
		if ( empty( $chunked )
		     || isset( $chunked['file']['percent_transferred'] ) && 1 === (int) $chunked['file']['percent_transferred'] ) {
			$this->queueManager->delete_data_from_queue( $count );
		}

		$transfer_status = $this->attempt_post( $state_data, $remote_url, $handle );
		$code            = $transfer_status->status_code;

		if ( ! $transfer_status || 200 !== $code ) {
			return $this->util->fire_transfer_errors( sprintf( __( 'Payload transfer failed with code %s: %s', 'wp-migrate-db' ), $code, $transfer_status->body ) );
		}

		list( $total_sent, $sent_copy ) = $this->process_sent_data_push( $sent, $chunked );

		// Convert 'file data' to 'folder data', as that's how the UI/Client displays progress
		return $this->util->process_queue_data( $sent_copy, $state_data, $total_sent );
	}

	/**
	 * @param array  $processed
	 * @param array  $state_data
	 * @param string $remote_url
	 *
	 * @return array
	 */
	public function handle_pull( $processed, $state_data, $remote_url ) {
		$bottleneck = apply_filters( 'wpmdb_transfers_pull_bottleneck', 2500000 ); //2.5 MB default
		$batch      = [];
		$total_size = 0;
		$count      = 0;

		// Assign bottleneck to state data so remote can use it when assembling the payload
		$state_data['bottleneck'] = $bottleneck;

		foreach ( $processed AS $key => $file ) {
			if ( $file['size'] > $bottleneck ) {
				$batch[] = $file;
				break;
			}

			$batch[] = $file;
			$count ++;

			$total_size += $file['size'];
		}

		try {
			list( $resp, $meta ) = $this->request_batch( base64_encode( str_rot13( serialize( $batch ) ) ), $state_data, 'wpmdb_transfers_send_file', $remote_url );
		} catch ( \Exception $e ) {
			$this->util->catch_general_error( $e->getMessage() );
		}

		//Delete data from queue
		$this->queueManager->delete_data_from_queue( $meta['count'] );

		$total_sent = 0;

		foreach ( $meta['sent'] as $sent ) {
			$total_sent += $sent['size'];
		}

		// Convert 'file data' to 'folder data', as that's how the UI/Client displays progress
		return $this->util->process_queue_data( $meta['sent'], $state_data, $total_sent );
	}

	/**
	 * @param string $payload
	 * @param array  $state_data
	 * @param string $action
	 * @param string $remote_url
	 *
	 * @return \Requests_Response
	 * @throws \Exception
	 */
	public function post( $payload, $state_data, $action, $remote_url ) {

		$data = [
			'action'          => $action,
			'remote_state_id' => $state_data['remote_state_id'],
			'intent'          => $state_data['intent'],
			'stage'           => $state_data['stage'],
		];

		$sig_data = $data;

		$data['sig']     = $this->wpmdb->create_signature( $sig_data, $state_data['key'] );
		$data['content'] = $payload;
		$ajax_url        = trailingslashit( $remote_url ) . 'wp-admin/admin-ajax.php';

		$sender   = new Sender( $this->wpmdb, $this->util, $this->payload );
		$response = $sender->post_payload( $data, $ajax_url );

		$decoded = json_decode( $response->body );

		if ( isset( $decoded->wpmdb_error ) ) {
			throw new \Exception( $decoded->msg );
		}

		// Returns response directly
		return $response;
	}

	/**
	 * @param string $batch
	 * @param array  $state_data
	 * @param string $action
	 * @param string $remote_url
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function request_batch( $batch, $state_data, $action, $remote_url ) {
		$data = [
			'action'          => $action,
			'remote_state_id' => $state_data['remote_state_id'],
			'intent'          => $state_data['intent'],
			'stage'           => $state_data['stage'],
			'bottleneck'      => $state_data['bottleneck'],
		];

		$sig_data      = $data;
		$data['sig']   = $this->wpmdb->create_signature( $sig_data, $state_data['key'] );
		$ajax_url      = trailingslashit( $remote_url ) . 'wp-admin/admin-ajax.php';
		$data['batch'] = $batch;

		$receiver = new Receiver( $this->wpmdb, $this->util, $this->payload, $remote_url );

		try {
			$response = $receiver->send_request( $data, $ajax_url );
		} catch ( \Exception $e ) {
			$this->util->catch_general_error( $e->getMessage() );
		}

		return $receiver->receive_stream_batch( $response, $state_data );
	}

	/**
	 * @param array $sent
	 * @param array $chunked
	 *
	 * @return array
	 */
	public function process_sent_data_push( $sent, $chunked ) {
		$total_sent = 0;
		$filtered   = [];

		foreach ( $sent as $files_sent ) {
			$item_size = $files_sent['size'];

			if ( isset( $chunked['chunked'] ) && $chunked['chunked'] ) {
				$item_size = $chunked['chunk_size'];
			}

			$total_sent               += $item_size;
			$files_sent['chunk_size'] = $item_size;
			$filtered[]               = $files_sent;
		}

		return array( $total_sent, $filtered );
	}

	/**
	 * @param array    $state_data
	 * @param string   $remote_url
	 * @param resource $handle
	 *
	 * @return \Requests_Response
	 */
	public function attempt_post( $state_data, $remote_url, $handle ) {
		rewind( $handle );
		$stream_contents = base64_encode( gzencode( stream_get_contents( $handle ) ) );

		try {
			$transfer_status = $this->post( $stream_contents, $state_data, 'wpmdb_transfers_receive_file', $remote_url );
		} catch ( \Exception $e ) {
			$this->util->catch_general_error( $e->getMessage() );
		}

		return $transfer_status;
	}
}
