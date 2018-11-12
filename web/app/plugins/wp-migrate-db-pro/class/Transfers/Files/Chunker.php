<?php

namespace WPMDB\Transfers\Files;

/**
 * Class Chunker
 *
 * When pushing, large files need to be broken up so that a remote's `post_max_size` and `upload_max_filesize` aren't hit
 *
 * @package WPMDB\Transfers\Files
 */
class Chunker {

	public $wpmdb;
	public $util;

	/**
	 * @param \WPMDB_Base $wpmdb
	 * @param Util        $util
	 */
	public function __construct( \WPMDB_Base $wpmdb, Util $util ) {
		$this->wpmdb = $wpmdb;
		$this->util  = $util;
	}

	/**
	 * @param string $id
	 *
	 * @return string
	 */
	public static function get_chunk_path( $id ) {
		$chunk_path = apply_filters( 'wpmdb_tranfers_chunk_folder', WP_CONTENT_DIR . DIRECTORY_SEPARATOR );

		return $chunk_path . ".{$id}-tmpchunk";
	}

	/**
	 *
	 * Creates a temporary file at file path specified by self::get_chunk_path() and chucks $chunk_data into said file to be transferred to the remote
	 *
	 * @param array $chunk_data
	 * @param int   $chunk_size
	 * @param array $state_data
	 *
	 * @return string
	 */
	public function create_chunk( $chunk_data, $chunk_size, $state_data ) {
		$file_path     = $chunk_data['file_path'];
		$current_chunk = $chunk_data['chunk_number'];

		$chunk_path = self::get_chunk_path( $state_data['migration_state_id'] );

		$chunk_handle = fopen( $chunk_path, 'wb' );
		$file_handle  = fopen( $file_path, 'rb' );

		if ( 1 !== $current_chunk ) {
			$bytes_offset = $chunk_size * ( $current_chunk - 1 );
			fseek( $file_handle, $bytes_offset );
		}

		$file_data = fread( $file_handle, $chunk_size );

		fwrite( $chunk_handle, $file_data );
		fclose( $chunk_handle );

		return $chunk_path;
	}

	/**
	 * Checks if a file is too large to push
	 *
	 * @param array  $state_data
	 * @param int    $bottleneck
	 * @param string $file_path
	 * @param array  $file
	 * @param int    $chunks
	 *
	 * @return array|bool
	 */
	public function chunk_it( $state_data, $bottleneck, $file_path, $file, $chunks ) {
		$chunked = true;

		if ( 'pull' === $state_data['intent'] ) {
			return false;
		}

		//Check if we're currently chunking, existing chunk data stored as a option
		$chunk_option_name = 'wpmdb_file_chunk_' . $state_data['migration_state_id'];
		$chunk_option      = get_site_option( $chunk_option_name );

		// If we haven't sent a previous chunk
		if ( empty( $chunk_option ) ) {
			$chunk_data = $this->assemble_chunk_data( $chunked, $file, $file_path, $bottleneck, $chunks, 1 );
		} else {
			$chunk_data = $chunk_option;
		}

		// --- File chunking begins ---
		$chunked         = true;
		$file['chunked'] = true;

		// Actually creates the chunk of data and saves it to a `wp-content/.<ID>-tmpchunk` file
		list( $file_path, $file ) = $this->modify_file_data_for_chunk( $file, $chunk_data, $bottleneck, $state_data );

		// Get the size of the .<ID>-tmpchunk file in /wp-content
		$actual_chunk_size = filesize( $file_path );
		$data              = $this->assemble_chunk_data( $chunked, $file, $file_path, $actual_chunk_size, $chunks, $chunk_data['chunk_number'] );

		// Update chunk number after chunk has been created
		$chunk_data['chunk_number'] ++;

		// Record chunk data to DB for next iteration
		update_site_option( $chunk_option_name, $chunk_data );

		return $data;
	}

	/**
	 *
	 * Return a standard format array
	 *
	 * @param $chunked
	 * @param $file
	 * @param $file_path
	 *
	 * @return array
	 */
	public function assemble_chunk_data( $chunked, $file, $file_path, $chunk_size, $chunks, $chunk_number ) {
		$chunk_data = array(
			'chunked'      => $chunked,
			'file'         => $file,
			'file_path'    => $file_path,
			'chunk_size'   => $chunk_size,
			'chunks'       => $chunks,
			'chunk_number' => $chunk_number,
		);

		return $chunk_data;
	}

	/**
	 * @param $file
	 * @param $chunk_data
	 * @param $chunk_size
	 *
	 * @return array
	 */
	public function modify_file_data_for_chunk( $file, $chunk_data, $chunk_size, $state_data ) {
		$file_path                   = $this->create_chunk( $chunk_data, $chunk_size, $state_data );
		$file['chunk_path']          = $file_path;
		$file['chunks']              = $chunk_data['chunks'];
		$file['chunk_number']        = $chunk_data['chunk_number'];
		$file['percent_transferred'] = round( (int) $chunk_data['chunk_number'] / (int) $chunk_data['chunks'], 2 );
		$file['bytes_transferred']   = $chunk_size;

		return array( $file_path, $file );
	}
}
