<?php

namespace WPMDB\Transfers;

class Receiver {

	public $wpmdb;
	public $remote;
	public $util;
	public $payload;
	public $tmpfile;
	public $tmpfile_path;

	protected $wpmdb_settings;

	function __construct(
		\WPMDB_Base $wpmdb,
		Files\Util $util,
		Files\Payload $payload,
		$remote_url = ''
	) {
		$this->wpmdb          = $wpmdb;
		$this->wpmdb_settings = $this->wpmdb->get( 'settings' );
		$this->remote         = $remote_url;
		$this->util           = $util;
		$this->payload        = $payload;
	}

	/**
	 * Set tmpfile class property to a stream handle to download payloads to
	 */
	public function set_tmp_file() {
		$this->tmpfile = apply_filters( 'wpmdb_transfers_stream_handle', tmpfile() );
	}

	/**
	 *
	 * Create a stream resource in the php://memory stream
	 *
	 * @param $content
	 *
	 * @return bool|resource
	 */
	public static function create_memory_stream( $content ) {
		$stream = fopen( 'php://memory', 'rb+' );
		fwrite( $stream, $content );
		rewind( $stream );

		return $stream;
	}

	/**
	 * @param $data
	 * @param $url
	 *
	 * @return \Requests_Response
	 * @throws \Exception
	 */
	public function send_request( $data, $url ) {
		$requests_options = $this->util->get_requests_options();

		$this->set_tmp_file();

		// @TODO if other Requests hooks on 'curl.before_send' are invoked, this won't get called
		$hooks = new \Requests_Hooks();
		$hooks->register( 'curl.before_send', function ( $handle ) {
			curl_setopt( $handle, CURLOPT_CONNECTTIMEOUT, 0 );
			curl_setopt( $handle, CURLOPT_TIMEOUT, 0 );

			$stream = $this->tmpfile;

			// Save payload directly to tmp file to get around memory limits
			curl_setopt( $handle, CURLOPT_FILE, $stream );
		} );

		$requests_options['hooks'] = $hooks;

		$options = apply_filters( 'wpmdb_transfers_requests_options', $requests_options );

		try {
			$response = \Requests::post( $url, array(), $data, $options );
		} catch ( \Exception $e ) {
			$this->util->catch_general_error( $e->getMessage() );
		}

		// Use Requests interface to get response information
		$code = $response->status_code;

		// @TODO handle 500 error on remote
		if ( 200 !== $code ) {
			throw new \Exception( sprintf( __( 'Remote server responded with %s and body of %s', 'wp-migrate-db' ), $code, $response->body ) );
		}

		return $response;
	}

	/**
	 * Where to store files as they're being transferred
	 *
	 * @return bool|mixed|void
	 */
	public static function get_temp_dir() {
		$temp_dir = trailingslashit( WP_CONTENT_DIR );

		return apply_filters( 'wpmdb_transfers_temp_dir', $temp_dir );
	}

	/**
	 * @param string $base
	 *
	 * @return array
	 */
	public function is_tmp_folder_writable( $base = 'themes' ) {
		$tmp          = self::get_temp_dir() . $base . '/tmp';
		$test_file    = $tmp . '/test.php';
		$renamed_file = $tmp . '/test-2.php';

		$return = [
			'status' => true,
		];

		if ( ! $this->wpmdb->filesystem->mkdir( $tmp ) ) {
			$message = sprintf( __( 'File transfer error - Unable to create a temporary folder. (%s)', 'wp-migrate-db' ), $tmp );
			$this->wpmdb->log_error( $message );

			return [
				'status'  => false,
				'message' => $message,
			];
		}

		if ( ! $this->wpmdb->filesystem->touch( $test_file ) ) {
			$message = sprintf( __( 'File transfer error - Unable to create a PHP file on the server. (%s)', 'wp-migrate-db' ), $test_file );
			$this->wpmdb->log_error( $message );

			return [
				'status'  => false,
				'message' => $message,
			];
		}

		if ( ! file_put_contents( $test_file, 'test' ) ) {
			$message = sprintf( __( 'File transfer error - Unable to update file contents using using PHP\'s file_put_contents() function. (%s)', 'wp-migrate-db' ), $test_file );
			$this->wpmdb->log_error( $message );

			return [
				'status'  => false,
				'message' => $message,
			];
		}

		if ( ! rename( $test_file, $renamed_file ) ) {
			$message = sprintf( __( 'File transfer error - Unable to move file to the correct location using PHP\'s rename() function. (%s)', 'wp-migrate-db' ), $renamed_file );
			$this->wpmdb->log_error( $message );

			return [
				'status'  => false,
				'message' => $message,
			];
		}

		//Clean up
		if ( ! $this->util->remove_tmp_folder( 'themes' ) ) {
			$message = sprintf( __( 'File transfer error - Unable to delete file using PHP\'s unlink() function. (%s)', 'wp-migrate-db' ), $renamed_file );
			$this->wpmdb->log_error( $message );

			return [
				'status'  => false,
				'message' => $message,
			];
		}

		return $return;
	}

	/**
	 * @param $stage
	 *
	 * @return bool|null
	 * @throws \Exception
	 */
	public function receive_post_data( $stage, $content ) {
		try {
			$stream = $this->payload->unpack_payload( $content );
		} catch ( \Exception $e ) {
			$this->util->catch_general_error( $e->getMessage() );
		}

		return $this->payload->process_payload( $stage, $stream );
	}

	/**
	 *
	 * Grabs the payload received from a remote (on a pull) and sends it to be processed
	 *
	 * @param $response
	 * @param $state_data
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function receive_stream_batch( $response, $state_data ) {
		$decoded_response = json_decode( $response->body );

		if ( isset( $decoded_response->wpmdb_error ) ) {
			throw new \Exception( $decoded_response->msg );
		}

		$handle = $this->tmpfile;
		stream_filter_prepend( $handle, 'zlib.inflate' );
		rewind( $handle );

		$meta = $this->payload->process_payload( $state_data['stage'], $handle, true );

		if ( ! $meta ) {
			throw new \Exception( __( 'Unable to process payload.', 'wp-migrate-db' ) );
		}

		fclose( $handle );

		return array( $response, $meta );
	}
}
