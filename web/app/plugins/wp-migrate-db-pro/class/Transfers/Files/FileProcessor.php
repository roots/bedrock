<?php

namespace WPMDB\Transfers\Files;

/**
 * Class FileProcessor
 *
 * @package WPMDB\Transfers\Files
 */
class FileProcessor {

	public $wpmdb;
	public $filesystem;

	/**
	 * FileProcessor constructor.
	 *
	 * @param \WPMDB_Base       $wpmdb
	 * @param \WPMDB_Filesystem $filesystem
	 */
	public function __construct(
		\WPMDB_Base $wpmdb,
		\WPMDB_Filesystem $filesystem
	) {
		$this->wpmdb      = $wpmdb;
		$this->filesystem = $filesystem;
	}

	/**
	 * Given an array of directory paths, loops over each dir and returns an array of files and metadata
	 *
	 * @param $directories
	 * @param $abs_path
	 *
	 * @return array
	 */
	public function get_local_files( $directories, $abs_path, $excludes = array(), $stage ) {
		$count          = 0;
		$total_size     = 0;
		$files          = [];
		$manifest       = [];
		$is_single      = false;
		$filtered_files = [];

		foreach ( $directories as $directory ) {
			$file_size = 0;

			if ( ! $this->filesystem->file_exists( $directory ) ) {
				continue;
			}

			if ( ! $this->filesystem->is_dir( $directory ) ) {
				$is_single = true;
			}

			$nice_name = $this->get_item_nice_name( $stage, $directory, $is_single );

			// Plugins that are single files need to have their meta data added individually
			if ( $is_single ) {
				$files_in_directory[] = $directory;
				list( $file_size, $filtered_files, $files, $count ) = $this->handle_single_file_plugin( $abs_path, $directory, $file_size, $files, $count, $nice_name );
				$total_size += $file_size;
				$is_single = false;
				continue;
			}

			$files_in_directory = $this->get_files_by_path( $directory );

			foreach ( $files_in_directory as $key => $file ) {
				if ( ! $this->check_file_against_excludes( $file, $excludes ) ) {
					unset( $files_in_directory[ $key ] );
					continue;
				}

				$file_size  += $file['size'];
				$total_size += $file['size'];
				$manifest[] = $file['subpath'];
			}

			$filtered_files      = $this->filter_folder_data( $files_in_directory, $file_size, $directory, $nice_name );
			$files[ $directory ] = $filtered_files;
		}

		$count += \count( $files_in_directory );

		$return = [
			'meta'  => [
				'count'    => $count,
				'size'     => $total_size,
				'manifest' => $manifest,
			],
			'files' => $files,
		];

		return $return;
	}

	/**
	 * @param array  $file
	 * @param string $excludes
	 *
	 * @return bool
	 */
	public function check_file_against_excludes( $file, $excludes ) {
		if ( empty( $excludes ) ) {
			return true;
		}

		$testMatch = Excludes::shouldExcludeFile( $file['absolute_path'], $excludes );

		if ( ! empty( $testMatch['exclude'] ) ) {
			return false;
		}

		return true;
	}

	/**
	 * @param string $directory
	 *
	 * @return array|bool
	 */
	public function get_files_by_path( $directory ) {
		// @TODO potentially filter this list
		$files = $this->wpmdb->filesystem->scandir_recursive( $directory );

		return $files;
	}

	/**
	 * @param array $files_in_directory
	 * @param int   $size
	 *
	 * @return array
	 */
	public function filter_folder_data( $files_in_directory, $size, $folder_path, $nice_name ) {
		$filtered_files = [];

		foreach ( $files_in_directory as $key => $files ) {
			$filtered_files[ $key ]                    = $files;
			$filtered_files[ $key ]['folder_size']     = $size;
			$filtered_files[ $key ]['folder_abs_path'] = $folder_path;
			$filtered_files[ $key ]['nice_name']       = $nice_name;
		}

		return $filtered_files;
	}

	/**
	 * @param string $abs_path
	 * @param string $directory
	 * @param int    $size
	 * @param array  $files
	 * @param int    $count
	 *
	 * @return array
	 */
	public function handle_single_file_plugin( $abs_path, $directory, $size, $files, $count, $nice_name ) {
		$file_info = $this->filesystem->get_file_info( str_replace( $this->wpmdb->slash_one_direction( $abs_path . DIRECTORY_SEPARATOR ), '', $directory ), $abs_path );
		$size      += $file_info['size'];

		$filtered_files                            = $this->filter_folder_data( [ $file_info ], $size, $directory, $nice_name );
		$files[ $directory ][ $file_info['name'] ] = $filtered_files[0];
		++ $count;

		return array( $size, $filtered_files, $files, $count );
	}

	/**
	 * @param string $stage
	 * @param array  $directory
	 * @param bool   $is_single
	 *
	 * @return string
	 */
	public function get_item_nice_name( $stage, $directory, $is_single = false ) {
		$directory_info = 'themes' === $stage ? wp_get_themes() : get_plugins();
		$exploded       = explode( DIRECTORY_SEPARATOR, $directory );
		$directory_key  = $exploded[ count( $exploded ) - 1 ];
		$nice_name      = '';

		if ( 'themes' === $stage ) {
			if ( isset( $directory_info[ $directory_key ] ) ) {
				$nice_name = html_entity_decode( $directory_info[ $directory_key ]->Name );
			}
		} else {
			foreach ( $directory_info AS $key => $info ) {
				$pattern = '/^' . $directory_key;

				if ( ! $is_single ) {
					$pattern .= '(\/|\\\)'; // Account for Windows slashes
				}

				$pattern .= '/';

				if ( 1 === preg_match( $pattern, $key ) ) {
					$nice_name = html_entity_decode( $info['Name'] );
					break;
				}
			}
		}

		return $nice_name;
	}
}
