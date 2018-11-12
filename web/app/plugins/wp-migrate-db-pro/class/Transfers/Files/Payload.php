<?php

namespace WPMDB\Transfers\Files;

use \WPMDB\Transfers\Receiver;
use \WPMDB\Transfers\Sender;

/**
 * Class Payload
 *
 * @package WPMDB\Transfers\Files
 */
class Payload {

	/**
	 * @var \WPMDB_Base
	 */
	public $wpmdb;
	/**
	 * @var Util
	 */
	public $util;
	/**
	 * @var Chunker
	 */
	public $chunker;

	/**
	 * @param \WPMDB_Base $wpmdb
	 * @param Util        $util
	 * @param Chunker     $chunker
	 */
	public function __construct(
		\WPMDB_Base $wpmdb,
		Util $util,
		Chunker $chunker
	) {
		$this->wpmdb   = $wpmdb;
		$this->util    = $util;
		$this->chunker = $chunker;
	}

	/**
	 *
	 * Create a payload string based on an array of file data
	 *
	 * Write string to $stream resource
	 *
	 * @param array    $file
	 * @param array    $meta_data
	 * @param resource $stream
	 * @param string   $file_path
	 * @param bool     $chunked
	 *
	 * @return null
	 * @throws \Exception
	 */
	public function assemble_payload( $file, $meta_data, &$stream, $file_path ) {

		if ( ! file_exists( $file['absolute_path'] ) ) {
			throw new \Exception( sprintf( __( 'File does not exist - %s', 'wp-migrate-db' ), $file['absolute_path'] ) );
		}

		$file_name         = $file['name'];
		$file['type']      = 'file';
		$file['md5']       = md5_file( $file['absolute_path'] );
		$file['encoded']   = true;
		$meta_data['file'] = $file + $meta_data['file'];

		$content = Sender::$start_meta . $file_name . "\n";
		$content .= serialize( $meta_data ) . "\n";
		$content .= Sender::$end_meta . $file_name . "\n";
		$content .= Sender::$start_payload . $file_name . "\n";

		// Write first chunk of content to the payload
		fwrite( $stream, $content );

		$file_stream = fopen( $file_path, 'rb' );

		// Skirts memory limits by copying stream to stream - writes directly to stream
		stream_copy_to_stream( $file_stream, $stream );

		$content = "\n" . Sender::$end_payload . $file_name;
		$content .= "\n" . Sender::$end_sig . "\n";

		fwrite( $stream, $content );

		return null;
	}

	/**
	 * @param array  $file_list
	 * @param array  $state_data
	 * @param string $bottleneck
	 *
	 * @return resource|array
	 */
	public function create_payload( $file_list, $state_data, $bottleneck ) {
		/*
		 * Other options to use if large files aren't downloading are:
		 * 	$membuffer = 54 * 1024 * 1024; // 54MB
		 * 	$handle = apply_filters( 'wpmdb_transfers_payload_handle', fopen( 'php://temp/maxmemory:'. $membuffer ) );
		 *
		 * OR
		 *
		 * $handle = apply_filters( 'wpmdb_transfers_payload_handle', fopen( WP_CONTENT_DIR . '/.payload', 'wb+' ) );
		 */
		$handle = apply_filters( 'wpmdb_transfers_payload_handle', tmpfile() );

		$count    = 0;
		$sent     = [];
		$chunked  = [];
		$chunking = false;
		$chunks   = 0;

		foreach ( $file_list AS $key => $file ) {

			// Info on fopen() stream
			$fstat = fstat( $handle );

			$added_size = $fstat['size'] + $file['size'];

			// If the filesize is less than the bottleneck and adding the file to the payload would push it over the $bottleneck
			// OR the payload already has stuff in it and the next file is a file larger than the bottleneck
			if ( ( $file['size'] < $bottleneck && $added_size >= $bottleneck )
			     || ( 0 !== $fstat['size'] && $file['size'] >= $bottleneck ) ) {
				break;
			}

			$data = [
				'file'  => $file,
				'stage' => $state_data['stage'],
			];

			$file_path = $file['absolute_path'];
			$file_size = filesize( $file_path );

			//Push and file is too large
			if ( $file_size >= $bottleneck && 'push' === $state_data['intent'] ) {
				$chunks   = ceil( $file_size / $bottleneck );
				$chunking = true;
			}

			list( $chunked, $file, $file_path ) = $this->maybe_get_chunk_data( $state_data, $bottleneck, $chunking, $file_path, $file, $chunks );

			try {
				$this->assemble_payload( $file, $data, $handle, $file_path );
			} catch ( \Exception $e ) {
				$this->util->catch_general_error( $e->getMessage() );
			}

			$sent[] = $file;
			$count ++;
		}

		if ( 'pull' === $state_data['intent'] ) {
			$handle = $this->assemble_payload_metadata( $count, $sent, $handle );
		}

		fwrite( $handle, "\n" . Sender::$end_bucket );

		if ( 'push' === $state_data['intent'] ) {
			return array( $count, $sent, $handle, $chunked );
		}

		return $handle;
	}

	/**
	 * @param array  $state_data
	 * @param int    $bottleneck
	 * @param bool   $chunking
	 * @param string $file_path
	 * @param array  $file
	 * @param int    $chunks
	 *
	 * @return array
	 */
	public function maybe_get_chunk_data( $state_data, $bottleneck, $chunking, $file_path, $file, $chunks ) {
		if ( ! $chunking ) {
			return array( false, $file, $file_path );
		}
		// Checks if current migration is a 'push' and if the file is too large to transfer
		$chunked = $this->chunker->chunk_it( $state_data, $bottleneck, $file_path, $file, $chunks );

		if ( $chunked && false !== $chunked['chunked'] ) {
			$file      = $chunked['file'];
			$file_path = $chunked['file_path'];
		}

		if ( (int) $chunked['chunk_number'] === (int) $chunked['chunks'] ) {
			$chunk_option_name = 'wpmdb_file_chunk_' . $state_data['migration_state_id'];
			delete_site_option( $chunk_option_name );
			$file['chunking_done'] = true;
		}

		return array( $chunked, $file, $file_path );
	}

	/**
	 *
	 * Read payload line by line and parse out contents
	 *
	 * @param   string  $stage
	 * @param  resource $stream
	 * @param bool      $return
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function process_payload( $stage, $stream, $return = false ) {
		$is_meta        = false;
		$is_payload     = false;
		$end_payload    = false;
		$is_bucket_meta = false;
		$bucket_meta    = false;

		while ( ( $line = fgets( $stream ) ) !== false ) {

			if ( false !== strpos( $line, Sender::$start_meta ) ) {
				$is_meta = true;
				continue;
			}

			if ( $is_meta ) {
				$meta    = unserialize( $line );
				$is_meta = false;
				continue;
			}

			if ( false !== strpos( $line, Sender::$start_payload ) ) {
				$is_payload = true;

				list( $dest, $handle ) = $this->get_handle_from_metadata( $stage, $meta );
				continue;
			}

			if ( $is_payload ) {

				/**
				 * Since we're in a large while loop we need to check if a file's payload
				 * has been read entirely. Files are added to the payload line by line so they
				 * need to read line by line. Sender::$end_payload is the deliminator to say that
				 * a file's contents ends _within_ the payload.
				 */
				if ( false !== strpos( $line, Sender::$end_payload ) ) {

					// Trim trailing newline from end of the created file, thanks fgets()...
					$stat = fstat( $handle );
					ftruncate( $handle, $stat['size'] - 1 );

					fclose( $handle );

					$is_payload  = false;
					$end_payload = true;
					continue;
				}

				$this->create_file_by_line( $line, $handle, $meta['file'] );
			}

			if ( $end_payload ) {

				if ( isset( $meta['file']['chunked'] ) && false !== $meta['file']['chunked'] ) {
					if ( isset( $meta['file']['chunks'], $meta['file']['chunk_number'] ) && ( (int) $meta['file']['chunks'] === (int) $meta['file']['chunk_number'] ) ) {
						$this->verify_file_from_payload( $dest, $meta );
					}
				} else {
					$this->verify_file_from_payload( $dest, $meta );
				}


				$end_payload = false;
				continue;
			}

			/**
			 * Bucket meta is information about what's in the payload.
			 *
			 * Presently this includes a count of how many files it contains and
			 * file information from WPMDB_Filesystem::get_file_info() about each file within
			 *
			 */
			if ( false !== strpos( $line, Sender::$start_bucket_meta ) ) {
				$is_bucket_meta = true;
				continue;
			}

			if ( $is_bucket_meta ) {
				$bucket_meta    = unserialize( $line );
				$is_bucket_meta = false;
				continue;
			}

			if ( false !== strpos( $line, Sender::$end_bucket ) ) {
				if ( ! $return ) {
					return $this->wpmdb->end_ajax( json_encode( $bucket_meta ) );
				}

				return $bucket_meta;
			}
		}

		return false;
	}

	/**
	 * @param $dest
	 * @param $meta
	 *
	 * @throws \Exception
	 */
	public function verify_file_from_payload( $dest, $meta ) {

		// Verify size of file matches what it's supposed to be
		if ( ! $this->util->verify_file( $dest, (int) $meta['file']['size'] ) ) {
			$msg = sprintf( __( 'File size of source and destination do not match: <br>%s<br>Destination size: %s, Local size: %s', 'wp-migrate-db' ), $dest, filesize( $dest ), $meta['file']['size'] );
			throw new \Exception( $msg );
		}

		$md5 = md5_file( $dest );

		if ( $meta['file']['md5'] !== $md5 ) {
			$msg = sprintf( __( "File MD5's do not match for file: %s \nLocal MD5: %s Remote MD5: %s", 'wp-migrate-db' ), \dirname( $dest ), $md5, $meta['file']['md5'] );

			throw new \Exception( $msg );
		}
	}

	/**
	 *
	 * Give a line of data from fgets() write to a previously created resource(stream).
	 *
	 * @param $line
	 * @param $handle
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function create_file_by_line( $line, $handle, $file_data ) {
		if ( ! $bytes = fwrite( $handle, $line ) ) {
			error_log( 'Could not write line to file. ' . print_r( $file_data, true ) );
			throw new \Exception( sprintf( __( 'Could not write line to file. File name: %s', 'wp-migrate-db' ), $file_data['name'] ) );
		}

		return false;
	}

	/**
	 * @param $stage
	 * @param $meta
	 *
	 * @return string
	 */
	public function assemble_filepath_from_payload( $stage, $meta ) {
		$dest = Receiver::get_temp_dir()
		        . $stage . DIRECTORY_SEPARATOR
		        . 'tmp'
		        . $this->wpmdb->slash_one_direction( $meta['file']['relative_path'] );

		return $dest;
	}

	/**
	 * @param $content
	 *
	 * @return bool|resource
	 * @throws \Exception
	 */
	public function unpack_payload( $content ) {
		if ( ! $content ) {
			throw new \Exception( __( 'Failed to unpack payload.', 'wp-migrate-db' ) );
		}

		$stream = Receiver::create_memory_stream( gzdecode( base64_decode( $content ) ) );

		if ( ! $stream ) {
			throw new \Exception( __( 'Failed to create stream from payload.', 'wp-migrate-db' ) );
		}

		return $stream;
	}

	/**
	 * @param $stage
	 * @param $meta
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function get_handle_from_metadata( $stage, $meta ) {
		$dest = $this->assemble_filepath_from_payload( $stage, $meta );

		$dirname = \dirname( $dest );

		if ( ! is_dir( $dirname ) ) {
			if ( ! $this->wpmdb->filesystem->mkdir( $dirname ) ) {
				$msg = sprintf( __( 'Could not create directory: %s', 'wp-migrate-db' ), dirname( $dest ) );
				throw new \Exception( $msg );
			}
		}
		$mode = isset( $meta['file']['chunked'] ) ? 'ab' : 'wb';

		$handle = fopen( $dest, $mode );

		return array( $dest, $handle );
	}

	/**
	 * @param $count
	 * @param $sent
	 * @param $handle
	 *
	 * @return resource
	 */
	public function assemble_payload_metadata( $count, $sent, $handle ) {
		// Information about what's in the payload, number of files and an array of file data about the files included
		$bucket_meta = serialize( compact( 'count', 'sent' ) );

		$bucket_meta_content = Sender::$start_bucket_meta . "\n";
		$bucket_meta_content .= $bucket_meta . "\n";
		$bucket_meta_content .= Sender::$end_bucket_meta;

		fwrite( $handle, $bucket_meta_content );

		return $handle;
	}
}
