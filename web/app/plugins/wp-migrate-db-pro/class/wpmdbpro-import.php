<?php

/**
 * Class WPMDBPro_Import
 *
 * Handles importing a SQL file to the database
 */
class WPMDBPro_Import {

	/**
	 * Stores the chunk size used for imports
	 *
	 * @var int $chunk_size
	 */
	protected $chunk_size = 10000;

	/**
	 * State data for the migration
	 *
	 * @var array $state_data
	 */
	protected $state_data;

	/**
	 * Stores a reference to WPMDBPro
	 *
	 * @var object $wpmdbpro
	 */
	protected $wpmdbpro;

	public function __construct( $wpmdbpro ) {
		$this->wpmdbpro = $wpmdbpro;

		add_action( 'wp_ajax_wpmdb_get_import_info', array( $this, 'ajax_get_import_info' ) );
		add_action( 'wp_ajax_wpmdb_upload_file', array( $this, 'ajax_upload_file' ) );
		add_action( 'wp_ajax_wpmdb_prepare_import_file', array( $this, 'ajax_prepare_import_file' ) );
		add_action( 'wp_ajax_wpmdb_import_file', array( $this, 'ajax_import_file' ) );
		add_filter( 'wpmdb_preserved_options', array( $this, 'filter_preserved_options' ), 10, 2 );
		add_filter( 'wpmdb_preserved_options_data', array( $this, 'filter_preserved_options_data' ), 10, 2 );
	}
	
	/**
	 * Returns info about the import file.
	 *
	 * @return array|bool
	 */
	public function ajax_get_import_info() {
		$this->wpmdbpro->check_ajax_referer( 'import-file' );

		$data       = $this->decode_chunk( $_POST['file_data'] );
		$is_gzipped = false;

		if ( false !== $data && $this->str_is_gzipped( $data ) ) {
			if ( ! $this->wpmdbpro->gzip() ) {
				$error_msg = __( 'The server is not compatible with gzip, please decompress the import file and try again.', 'wp-migrate-db' );
				$return    = array( 'wpmdb_error' => 1, 'body' => $error_msg );
				$this->wpmdbpro->log_error( $error_msg );
				return $this->wpmdbpro->end_ajax( json_encode( $return ) );
			}

			$data       = WPMDB_Utils::gzdecode( $data );
			$is_gzipped = true;
		}

		if ( ! $data && ! $is_gzipped ) {
			$error_msg = __( 'Unable to read data from the import file', 'wp-migrate-db' );
			$return    = array( 'wpmdb_error' => 1, 'body' => $error_msg );
			$this->wpmdbpro->log_error( $error_msg );
			$result = $this->wpmdbpro->end_ajax( json_encode( $return ) );

			return $result;
		}

		$return = $this->parse_file_header( $data );
		$return['import_gzipped'] = $is_gzipped;

		return $this->wpmdbpro->end_ajax( json_encode( $return ) );
	}

	/**
	 * Parses info from the export file header.
	 *
	 * @param $data
	 *
	 * @return array
	 */
	public function parse_file_header( $data ) {
		$lines  = explode( PHP_EOL, $data );
		$return = array();

		if ( is_array( $lines ) && 10 <= count( $lines ) ) {
			if ( '# URL:' === substr( $lines[5], 0, 6 ) ) {
				$return['URL'] = substr( $lines[5], 7 );
			}

			if ( '# Path:' === substr( $lines[6], 0, 7 ) ) {
				$return['path'] = substr( $lines[6], 8 );
			}

			if ( '# Tables:' === substr( $lines[7], 0, 9 ) ) {
				$return['tables'] = explode( ', ', substr( $lines[7], 10 ) );
			}

			if ( '# Table Prefix:' === substr( $lines[8], 0, 15 ) ) {
				$return['prefix'] = substr( $lines[8], 16 );
			}

			if ( '# Post Types:' === substr( $lines[9], 0, 13 ) ) {
				$return['post_types'] =  explode( ', ', substr( $lines[9], 14 ) );
			}

			if ( '# Protocol:' === substr( $lines[10], 0, 11 ) ) {
				$return['protocol'] = substr( $lines[10], 12 );
			}

			if ( '# Multisite:' === substr( $lines[11], 0, 12 ) ) {
				$return['multisite'] = substr( $lines[11], 13 );
			}

			if ( '# Subsite Export:' === substr( $lines[12], 0, 17 ) ) {
				$return['subsite_export'] = substr( $lines[12], 18 );
			}
		}

		return $return;
	}

	/**
	 * Uploads the import file to the server.
	 *
	 * @return void
	 */
	public function ajax_upload_file() {
		$this->wpmdbpro->check_ajax_referer( 'import-file' );
		$this->state_data = $this->wpmdbpro->set_post_data();
		if ( ! empty( $this->state_data['form_data'] ) ) {
			$this->wpmdbpro->parse_migration_form_data( $this->state_data['form_data'] );
		}

		$file_data = $this->decode_chunk( $this->state_data['file_data'] );

		if ( false === $file_data ) {
			$error_msg = __( 'An error occurred while uploading the file.', 'wp-migrate-db' );
			$return    = array( 'wpmdb_error' => 1, 'body' => $error_msg );
			$this->wpmdbpro->log_error( $error_msg );

			return $this->wpmdbpro->end_ajax( json_encode( $return ) );
		}

		// Store the data in the file.
		$fp = fopen( $this->state_data['import_path'], 'a' );
		fwrite( $fp, $file_data );
		fclose( $fp );
	}

	/**
	 * Prepares for import of a SQL file.
	 *
	 * @return mixed
	 */
	public function ajax_prepare_import_file() {
		$this->wpmdbpro->check_ajax_referer( 'import-file' );
		$this->state_data = $this->wpmdbpro->set_post_data();

		$file = $this->state_data['import_path'];

		if ( $this->file_is_gzipped( $file ) ) {

			$file = $this->decompress_file( $this->state_data['import_path'] );

			if ( false === $file ) {
				$error_msg = __( 'An error occurred while decompressing the import file.', 'wp-migrate-db' );
				$return    = array( 'wpmdb_error' => 1, 'body' => $error_msg );
				$this->wpmdbpro->log_error( $error_msg );
				$result = $this->wpmdbpro->end_ajax( json_encode( $return ) );

				return $result;
			}
		}

		$return = array(
			'num_chunks'  => $this->get_num_chunks_in_file( $file ),
			'import_file' => $file,
			'import_size' => $this->wpmdbpro->filesystem->filesize( $file ),
		);

		return $this->wpmdbpro->end_ajax( json_encode( $return ) );
	}

	/**
	 * Handles AJAX requests to import a SQL file.
	 *
	 * @return mixed
	 */
	public function ajax_import_file() {
		$this->wpmdbpro->check_ajax_referer( 'import-file' );
		$this->state_data = $this->wpmdbpro->set_post_data();

		$file          = $this->state_data['import_file'];
		$chunk         = isset( $this->state_data['chunk'] ) ? $this->state_data['chunk'] : 0;
		$num_chunks    = isset( $this->state_data['num_chunks'] ) ? $this->state_data['num_chunks'] : $this->get_num_chunks_in_file( $file );
		$current_query = isset( $this->state_data['current_query'] ) ? base64_decode( $this->state_data['current_query'] ) : '';

		$import = $this->import_chunk( $file, $chunk, $current_query );

		if ( is_wp_error( $import ) ) {
			$error_msg = $import->get_error_message();
			$return    = array( 'wpmdb_error' => 1, 'body' => $error_msg );
			$this->wpmdbpro->log_error( $error_msg );

			return $this->wpmdbpro->end_ajax( json_encode( $return ) );
		}

		$return = array(
			'chunk'         => ++$chunk,
			'num_chunks'    => $num_chunks,
			'current_query' => base64_encode( $import['current_query'] ),
		);

		// Return updated table sizes
		if ( $chunk >= $num_chunks ) {

			$this->wpmdbpro->delete_export_file( $this->state_data['import_filename'], true );

			if ( 'true' === $this->state_data['import_info']['import_gzipped'] ) {
				$this->wpmdbpro->delete_export_file( $this->state_data['import_filename'], false );
			}

			$return['table_sizes'] = $this->wpmdbpro->get_table_sizes();
			$return['table_rows']  = $this->wpmdbpro->get_table_row_count();
		}

		return $this->wpmdbpro->end_ajax( json_encode( $return ) );
	}

	/**
	 * Gets the file data from the base64 encoded chunk
	 *
	 * @param string $data
	 *
	 * @return string|bool
	 */
	public function decode_chunk( $data ) {
		$data = explode( ';base64,', $data );

		if ( ! is_array( $data ) || ! isset( $data[1] ) ) {
			return false;
		}

		$data = base64_decode( $data[1] );
		if ( ! $data ) {
			return false;
		}

		return $data;
	}

	/**
	 * Gets the SplFileObject for the provided file
	 *
	 * @param string $file
	 * @param int    $line
	 *
	 * @return object SplFileObject|WP_Error
	 */
	public function get_file_object( $file, $line = 0 ) {
		if ( ! $this->wpmdbpro->filesystem->file_exists( $file ) || ! $this->wpmdbpro->filesystem->is_readable( $file ) ) {
			return new WP_Error( 'invalid_import_file', __( 'The import file could not be read.', 'wp-migrate-db' ) );
		}

		$file = new SplFileObject( $file );
		$file->seek( $line );

		return $file;
	}

	/**
	 * Returns the number of chunks in a SQL file
	 *
	 * @param $file
	 *
	 * @return int|object WP_Error
	 */
	public function get_num_chunks_in_file( $file ) {
		$file = $this->get_file_object( $file, PHP_INT_MAX );

		if ( is_wp_error( $file ) ) {
			return $file;
		}

		$lines = $file->key();

		return ceil( $lines / $this->chunk_size );
	}

	/**
	 * Imports a chunk of a provided SQL file into the database
	 *
	 * @param string $file
	 * @param int    $chunk
	 * @param string $current_query
	 *
	 * @return array|object WP_Error
	 */
	public function import_chunk( $file, $chunk = 0, $current_query = '' ) {
		global $wpdb;

		$start = $chunk * $this->chunk_size;
		$start = ( $start > 0 ) ? $start - 1 : $start;
		$lines = 0;
		$file  = $this->get_file_object( $file, $start );

		if ( is_wp_error( $file ) ) {
			return $file;
		}

		while ( ! $file->eof() ) {
			$line = trim( $file->fgets() );
			$lines++;

			if ( $lines > $this->chunk_size ) {
				// Bail if we've exceeded the chunk size
				return array(
					'import_complete' => false,
					'current_query'   => $current_query,
				);
			}

			if ( empty( $line ) || '' === $line ) {
				// Skip empty/new lines
				continue;
			}

			if ( '--' === substr( $line, 0, 2 ) ||
			     '/* ' === substr( $line, 0, 3 ) ||
			     '#' === substr( $line, 0, 1 )
			) {
				// Skip if it's a comment
				continue;
			}

			if ( preg_match( '/\/\*![0-9]{5} SET (.*)\*\/;/', $line, $matches ) ) {
				// Skip user and system defined MySQL variables
				continue;
			}

			$current_query .= $line;

			if ( ';' !== substr( $line, -1, 1 ) ) {
				// Doesn't have a semicolon at the end, not the end of the query
				continue;
			}

			// Run the query
			ob_start();
			$wpdb->show_errors();

			$current_query = $this->convert_to_temp_query( $current_query );
			if ( false === $wpdb->query( $current_query ) ) {
				$error               = ob_get_clean();
				$error_msg           = sprintf( __( 'Failed to import the SQL query: %s', 'wp-migrate-db' ), esc_html( $error ) );
				$return              = new WP_Error( 'import_sql_execution_failed', $error_msg );

				$invalid_text = $this->wpmdbpro->maybe_strip_invalid_text_and_retry( $current_query, 'import' );
				if ( false !== $invalid_text ) {
					$return = $invalid_text;
				}

				if ( is_wp_error( $return ) ) {
					return $return;
				}
			}

			ob_end_clean();

			// Reset the temp variable
			$current_query = '';
		}

		return array( 'import_complete' => true, 'current_query' => $current_query );
	}

	/**
	 * Decompress a file
	 *
	 * @param  string $file The file to decompress
	 * @param  string $dest The destination of the decompressed file
	 *
	 * @return string|boolean
	 */
	public function decompress_file( $file, $dest = '' ) {
		$error = false;

		if ( ! $this->wpmdbpro->filesystem->file_exists( $file ) || ! $this->wpmdbpro->filesystem->is_readable( $file ) ) {
			return $error;
		}

		$tmp_file = wp_tempnam();

		if ( '' === $dest ) {
			$dest = ( '.gz' === substr( $file, -3 ) ) ? substr( $file, 0, -3 ) : $file;
		}

		if ( $fp_in = gzopen( $file, 'rb' ) ) {

			if ( $fp_out = fopen( $tmp_file, 'w' ) ) {

				while ( ! gzeof( $fp_in ) ) {
					$string = gzread( $fp_in, '4096' );
					fwrite( $fp_out, $string, strlen( $string ) );
				}

				fclose( $fp_out );

				$this->wpmdbpro->filesystem->move( $tmp_file, $dest );
			} else {
				$error = true;
			}

			gzclose( $fp_in );
		} else {
			$error = true;
		}

		if ( $error ) {
			return false;
		}

		return $dest;
	}

	/**
	 * Converts a query to run on temporary tables
	 *
	 * @param $query
	 *
	 * @return string
	 */
	public function convert_to_temp_query( $query ) {
		$temp_prefix = $this->wpmdbpro->get( 'temp_prefix' );

		if ( substr( $query, 0, 13 ) === 'INSERT INTO `' ) {
			$query = WPMDB_Utils::str_replace_first( 'INSERT INTO `', 'INSERT INTO `' . $temp_prefix, $query );
		} elseif ( substr( $query, 0, 14 ) === 'CREATE TABLE `' ) {
			$query = WPMDB_Utils::str_replace_first( 'CREATE TABLE `', 'CREATE TABLE `' . $temp_prefix, $query );
		} elseif ( substr( $query, 0, 22 ) === 'DROP TABLE IF EXISTS `' ) {
			$query = WPMDB_Utils::str_replace_first( 'DROP TABLE IF EXISTS `', 'DROP TABLE IF EXISTS `' . $temp_prefix, $query );
		} elseif ( substr( $query, 0, 13 ) === 'LOCK TABLES `' ) {
			$query = WPMDB_Utils::str_replace_first( 'LOCK TABLES `', 'LOCK TABLES `' . $temp_prefix, $query );
		} elseif ( substr( $query, 0, 13 ) === 'ALTER TABLE `' || substr( $query, 9, 13 ) === 'ALTER TABLE `' ) {
			$query = WPMDB_Utils::str_replace_first( 'ALTER TABLE `', 'ALTER TABLE `' . $temp_prefix, $query );
		}

		return $query;
	}

	/**
	 * Checks if a string is compressed via gzip
	 *
	 * @param string $string
	 *
	 * @return bool
	 */
	public function str_is_gzipped( $string ) {
		$is_gzipped = false;
		$tmp_file   = wp_tempnam();

		$fh = fopen( $tmp_file, 'a' );
		fwrite( $fh, $string );


		if ( $this->file_is_gzipped( $tmp_file ) ) {
			$is_gzipped = true;
		}

		$this->wpmdbpro->filesystem->unlink( $tmp_file );

		return $is_gzipped;
	}

	/**
	 * Checks if the provided file is gzipped
	 *
	 * @param string $file
	 *
	 * @return bool
	 */
	public function file_is_gzipped( $file ) {
		$is_gzipped = false;

		if ( ! $this->wpmdbpro->filesystem->is_file( $file ) ) {
			return $is_gzipped;
		}

		$content_type = mime_content_type( $file );

		if ( in_array( $content_type, array( 'application/x-gzip', 'application/gzip' ) ) ) {
			$is_gzipped = true;
		}

		return $is_gzipped;
	}

	/**
	 * Maybe change options keys to be preserved.
	 *
	 * @param array  $preserved_options
	 * @param string $intent
	 *
	 * @return array
	 */
	public function filter_preserved_options( $preserved_options, $intent = '' ) {
		if ( 'import' === $intent ) {
			$preserved_options = $this->wpmdbpro->preserve_active_plugins_option( $preserved_options );
		}

		return $preserved_options;
	}

	/**
	 * Maybe preserve the WPMDB plugins if they aren't already preserved.
	 *
	 * @param array  $preserved_options_data
	 * @param string $intent
	 *
	 * @return array
	 */
	public function filter_preserved_options_data( $preserved_options_data, $intent = '' ) {
		if ( 'import' === $intent ) {
			$preserved_options_data = $this->wpmdbpro->preserve_wpmdb_plugins( $preserved_options_data );
		}

		return $preserved_options_data;
	}
}
