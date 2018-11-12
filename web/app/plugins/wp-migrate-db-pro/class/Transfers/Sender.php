<?php

namespace WPMDB\Transfers;

class Sender {

	static $end_sig = '###WPMDB_EOF###';
	static $end_bucket = '###WPMDB_END_BUCKET###';
	static $start_payload = '###WPMDB_PAYLOAD###';
	static $end_payload = '###WPMDB_END_PAYLOAD###';
	static $start_meta = '###WPMDB_START_META###';
	static $end_meta = '###WPMDB_END_META###';
	static $start_bucket_meta = '####WPMDB_BUCKET_META####';
	static $end_bucket_meta = '###WPMDB_END_BUCKET_META###';

	public $wpmdb;
	public $util;
	public $payload;

	/**
	 * Sender constructor.
	 *
	 * @param \WPMDB_Base   $wpmdb
	 * @param Files\Util    $util
	 * @param Files\Payload $payload
	 */
	public function __construct(
		\WPMDB_Base $wpmdb,
		Files\Util $util,
		Files\Payload $payload
	) {
		$this->wpmdb   = $wpmdb;
		$this->util    = $util;
		$this->payload = $payload;
	}

	/**
	 * HTTP POST payload to remote site
	 *
	 * @param string $payload
	 * @param string $url
	 *
	 * @return \Requests_Response
	 */
	public function post_payload( $payload, $url = '' ) {
		$requests_options = $this->util->get_requests_options();
		$options          = apply_filters( 'wpmdb_transfers_requests_options', $requests_options );

		return \Requests::post( $url, array(), $payload, $options );
	}

	/**
	 * @param $state_data
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function respond_to_send_file( $state_data ) {
		if ( ! isset( $_POST['batch'] ) ) {
			throw new \Exception( __( '$_POST[\'batch\'] is empty.', 'wp-migrate-db' ) );
		}

		$batch = filter_var( $_POST['batch'], FILTER_SANITIZE_STRING );
		$batch = unserialize( str_rot13( base64_decode( $batch ) ) );

		if ( ! $batch || ! \is_array( $batch ) ) {
			throw new \Exception( __( 'Request for batch of files failed.', 'wp-migrate-db' ) );
		}

		$handle = $this->payload->create_payload( $batch, $state_data, $state_data['bottleneck'] );
		rewind( $handle );
		stream_filter_append( $handle, 'zlib.deflate', STREAM_FILTER_ALL );

		// Read payload line by line and send each line to the output buffer
		while ( ! feof( $handle ) ) {
			$buffer = fread( $handle, 10 * 10 * 10000 );
			echo $buffer;

			@ob_flush();
			flush();
		}

		fclose( $handle );
		exit;
	}

	protected function print_vars( $vars, $encode = true ) {
		foreach ( $vars as $key => $val ) {
			$this->print_var( $key, $val, $encode );
		}
	}

	protected function print_var( $key, $val, $encode = true ) {
		if ( $encode ) {
			$key .= '-encoded';
			$val = base64_encode( $val );
		}
		echo "[$key]$val\n";
	}

	protected function print_end() {
		echo "\n" . static::$end_sig;
	}
}
