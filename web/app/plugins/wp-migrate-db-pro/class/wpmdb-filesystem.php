<?php

class WPMDB_Filesystem {

	private $wp_filesystem;
	private $credentials;
	private $use_filesystem = false;
	private $chmod_dir;
	private $chmod_file;

	/**
	 * Pass `true` when instantiating to skip using WP_Filesystem
	 *
	 * @param bool $force_no_fs
	 */
	public function __construct( $force_no_fs = false ) {
		if ( ! $force_no_fs && function_exists( 'request_filesystem_credentials' ) ) {
			if ( ( defined( 'WPMDB_WP_FILESYSTEM' ) && WPMDB_WP_FILESYSTEM ) || ! defined( 'WPMDB_WP_FILESYSTEM' ) ) {
				$this->maybe_init_wp_filesystem();
			}
		}

		// Set default permissions
		if ( defined( 'FS_CHMOD_DIR' ) ) {
			$this->chmod_dir = FS_CHMOD_DIR;
		} else {
			$this->chmod_dir = ( fileperms( ABSPATH ) & 0777 | 0755 );
		}

		if ( defined( 'FS_CHMOD_FILE' ) ) {
			$this->chmod_file = FS_CHMOD_FILE;
		} else {
			$this->chmod_file = ( fileperms( ABSPATH . 'index.php' ) & 0777 | 0644 );
		}
	}

	/**
	 * Getter for the instantiated WP_Filesystem
	 *
	 * @return WP_Filesystem|false
	 *
	 * This should be used carefully since $wp_filesystem won't always have a value.
	 */
	public function get_wp_filesystem() {
		if ( $this->use_filesystem ) {
			return $this->wp_filesystem;
		} else {
			return false;
		}
	}

	/**
	 * Is WP_Filesystem being used?
	 *
	 * @return bool
	 */
	public function using_wp_filesystem() {
		return $this->use_filesystem;
	}

	/**
	 * Attempts to use the correct path for the FS method being used
	 *
	 * @param string $abs_path
	 *
	 * @return string
	 */
	public function get_sanitized_path( $abs_path ) {
		if ( $this->using_wp_filesystem() ) {
			return str_replace( ABSPATH, $this->wp_filesystem->abspath(), $abs_path );
		}

		return $abs_path;
	}

	/**
	 * Attempt to initiate WP_Filesystem
	 *
	 * If this fails, $use_filesystem is set to false and all methods in this class should use native php fallbacks
	 * Thwarts `request_filesystem_credentials()` attempt to display a form for obtaining creds from users
	 *
	 * TODO: provide notice and input in wp-admin for users when this fails
	 */
	public function maybe_init_wp_filesystem() {
		ob_start();
		$this->credentials = request_filesystem_credentials( '', '', false, false, null );
		$ob_contents       = ob_get_contents();
		ob_end_clean();

		if ( wp_filesystem( $this->credentials ) ) {
			global $wp_filesystem;
			$this->wp_filesystem  = $wp_filesystem;
			$this->use_filesystem = true;
		}
	}

	/**
	 * Create file if not exists then set mtime and atime on file
	 *
	 * @param string $abs_path
	 * @param int    $time
	 * @param int    $atime
	 *
	 * @return bool
	 */
	public function touch( $abs_path, $time = 0, $atime = 0 ) {
		if ( 0 == $time ) {
			$time = time();
		}
		if ( 0 == $atime ) {
			$atime = time();
		}

		$return = @touch( $abs_path, $time, $atime );

		if ( ! $return && $this->use_filesystem ) {
			$abs_path = $this->get_sanitized_path( $abs_path );
			$return   = $this->wp_filesystem->touch( $abs_path, $time, $atime );
		}

		return $return;
	}

	/**
	 * file_put_contents with chmod
	 *
	 * @param string $abs_path
	 * @param string $contents
	 *
	 * @return bool
	 */
	public function put_contents( $abs_path, $contents ) {
		$return = @file_put_contents( $abs_path, $contents );
		$this->chmod( $abs_path );

		if ( ! $return && $this->use_filesystem ) {
			$abs_path = $this->get_sanitized_path( $abs_path );
			$return   = $this->wp_filesystem->put_contents( $abs_path, $contents, $this->chmod_file );
		}

		return (bool) $return;
	}

	/**
	 * Does the specified file or dir exist
	 *
	 * @param string $abs_path
	 *
	 * @return bool
	 */
	public function file_exists( $abs_path ) {
		$return = file_exists( $abs_path );

		if ( ! $return && $this->use_filesystem ) {
			$abs_path = $this->get_sanitized_path( $abs_path );
			$return   = $this->wp_filesystem->exists( $abs_path );
		}

		return (bool) $return;
	}

	/**
	 * Get a file's size
	 *
	 * @param string $abs_path
	 *
	 * @return int
	 */
	public function filesize( $abs_path ) {
		$return = filesize( $abs_path );

		if ( ! $return && $this->use_filesystem ) {
			$abs_path = $this->get_sanitized_path( $abs_path );
			$return   = $this->wp_filesystem->size( $abs_path );
		}

		return $return;
	}

	/**
	 * Get the contents of a file as a string
	 *
	 * @param string $abs_path
	 *
	 * @return string
	 */
	public function get_contents( $abs_path ) {
		$return = @file_get_contents( $abs_path );

		if ( ! $return && $this->use_filesystem ) {
			$abs_path = $this->get_sanitized_path( $abs_path );
			$return   = $this->wp_filesystem->get_contents( $abs_path );
		}

		return $return;
	}

	/**
	 * Delete a file
	 *
	 * @param string $abs_path
	 *
	 * @return bool
	 */
	public function unlink( $abs_path ) {
		$return = @unlink( $abs_path );

		if ( ! $return && $this->use_filesystem ) {
			$abs_path = $this->get_sanitized_path( $abs_path );
			$return   = $this->wp_filesystem->delete( $abs_path, false, false );
		}

		return $return;
	}

	/**
	 * chmod a file
	 *
	 * @param string $abs_path
	 * @param int    $perms
	 *
	 * @return bool
	 *
	 * Leave $perms blank to use $this->chmod_file/DIR or pass value like 0777
	 */
	public function chmod( $abs_path, $perms = null ) {
		if ( is_null( $perms ) ) {
			$perms = $this->is_file( $abs_path ) ? $this->chmod_file : $this->chmod_dir;
		}

		$return = @chmod( $abs_path, $perms );

		if ( ! $return && $this->use_filesystem ) {
			$abs_path = $this->get_sanitized_path( $abs_path );
			$return   = $this->wp_filesystem->chmod( $abs_path, $perms, false );
		}

		return $return;
	}

	/**
	 * Is the specified path a directory?
	 *
	 * @param string $abs_path
	 *
	 * @return bool
	 */
	public function is_dir( $abs_path ) {
		$return = is_dir( $abs_path );

		if ( ! $return && $this->use_filesystem ) {
			$abs_path = $this->get_sanitized_path( $abs_path );
			$return   = $this->wp_filesystem->is_dir( $abs_path );
		}

		return $return;
	}

	/**
	 * Is the specified path a file?
	 *
	 * @param string $abs_path
	 *
	 * @return bool
	 */
	public function is_file( $abs_path ) {
		$return = is_file( $abs_path );

		if ( ! $return && $this->use_filesystem ) {
			$abs_path = $this->get_sanitized_path( $abs_path );
			$return   = $this->wp_filesystem->is_file( $abs_path );
		}

		return $return;
	}

	/**
	 * Is the specified path readable
	 *
	 * @param string $abs_path
	 *
	 * @return bool
	 */
	public function is_readable( $abs_path ) {
		$return = is_readable( $abs_path );

		if ( ! $return && $this->use_filesystem ) {
			$abs_path = $this->get_sanitized_path( $abs_path );
			$return   = $this->wp_filesystem->is_readable( $abs_path );
		}

		return $return;
	}

	/**
	 * Is the specified path writable
	 *
	 * @param string $abs_path
	 *
	 * @return bool
	 */
	public function is_writable( $abs_path ) {
		$return = is_writable( $abs_path );

		if ( ! $return && $this->use_filesystem ) {
			$abs_path = $this->get_sanitized_path( $abs_path );
			$return   = $this->wp_filesystem->is_writable( $abs_path );
		}

		return $return;
	}

	/**
	 * Recursive mkdir
	 *
	 * @param string $abs_path
	 * @param int    $perms
	 *
	 * @return bool
	 */
	public function mkdir( $abs_path, $perms = null ) {
		if ( is_null( $perms ) ) {
			$perms = $this->chmod_dir;
		}

		if ( $this->is_dir( $abs_path ) ) {
			$this->chmod( $perms );

			return true;
		}

		try {
			$mkdirp = wp_mkdir_p( $abs_path );
		} catch ( Exception $e ) {
			$mkdirp = false;
		}

		if ( $mkdirp ) {
			$this->chmod( $perms );

			return true;
		}

		$return = @mkdir( $abs_path, $perms, true );

		if ( ! $return && $this->use_filesystem ) {
			$abs_path = $this->get_sanitized_path( $abs_path );

			if ( $this->is_dir( $abs_path ) ) {
				return true;
			}

			// WP_Filesystem doesn't offer a recursive mkdir()
			$abs_path = str_replace( '//', '/', $abs_path );
			$abs_path = rtrim( $abs_path, '/' );
			if ( empty( $abs_path ) ) {
				$abs_path = '/';
			}

			$dirs        = explode( '/', ltrim( $abs_path, '/' ) );
			$current_dir = '';

			foreach ( $dirs as $dir ) {
				$current_dir .= '/' . $dir;
				if ( ! $this->is_dir( $current_dir ) ) {
					$this->wp_filesystem->mkdir( $current_dir, $perms );
				}
			}

			$return = $this->is_dir( $abs_path );
		}

		return $return;
	}

	/**
	 * Delete a directory
	 *
	 * @param string $abs_path
	 * @param bool   $recursive
	 *
	 * @return bool
	 */
	public function rmdir( $abs_path, $recursive = false ) {
		if ( ! $this->is_dir( $abs_path ) ) {
			return false;
		}

		// taken from WP_Filesystem_Direct
		if ( ! $recursive ) {
			$return = @rmdir( $abs_path );
		} else {

			// At this point it's a folder, and we're in recursive mode
			$abs_path = trailingslashit( $abs_path );
			$filelist = $this->scandir( $abs_path );

			$return = true;
			if ( is_array( $filelist ) ) {
				foreach ( $filelist as $filename => $fileinfo ) {

					if ( 'd' === $fileinfo['type'] ) {
						$return = $this->rmdir( $abs_path . $filename, $recursive );
					} else {
						$return = $this->unlink( $abs_path . $filename );
					}
				}
			}

			if ( file_exists( $abs_path ) && ! @rmdir( $abs_path ) ) {
				$return = false;
			}
		}

		if ( ! $return && $this->use_filesystem ) {
			$abs_path = $this->get_sanitized_path( $abs_path );

			return $this->wp_filesystem->rmdir( $abs_path, $recursive );
		}

		return $return;

	}

	/**
	 * Get a list of files/folders under specified directory
	 *
	 * @param $abs_path
	 *
	 * @return array|bool
	 */
	public function scandir( $abs_path ) {

		$dirlist = @scandir( $abs_path );
		if ( false === $dirlist ) {
			if ( $this->use_filesystem ) {
				$abs_path = $this->get_sanitized_path( $abs_path );

				return $this->wp_filesystem->dirlist( $abs_path, true, false );
			}

			return false;
		}

		$return = array();

		// normalize return to look somewhat like the return value for WP_Filesystem::dirlist
		foreach ( $dirlist as $entry ) {
			if ( '.' === $entry || '..' === $entry ) {
				continue;
			}
			$return[ $entry ] = array(
				'name' => $entry,
				'type' => $this->is_dir( $abs_path . '/' . $entry ) ? 'd' : 'f',
			);
		}

		return $return;

	}

	/**
	 * Light wrapper for move_uploaded_file with chmod
	 *
	 * @param string $file
	 * @param string $destination
	 * @param int    $perms
	 *
	 * @return bool
	 *
	 * TODO: look into replicating more functionality from wp_handle_upload()
	 */
	public function move_uploaded_file( $file, $destination, $perms = null ) {
		$return = @move_uploaded_file( $file, $destination );

		if ( $return ) {
			$this->chmod( $destination, $perms );
		}

		return $return;
	}

	/**
	 * Copy a file
	 *
	 * @param string $source_abs_path
	 * @param string $destination_abs_path
	 * @param bool   $overwrite
	 * @param mixed    $perms
	 *
	 * @return bool
	 *
	 * Taken from WP_Filesystem_Direct
	 */
	public function copy( $source_abs_path, $destination_abs_path, $overwrite = true, $perms = false ) {

		// error if source file doesn't exist
		if ( ! $this->file_exists( $source_abs_path ) ) {
			return false;
		}

		if ( ! $overwrite && $this->file_exists( $destination_abs_path ) ) {
			return false;
		}

		$return = @copy( $source_abs_path, $destination_abs_path );
		if ( $perms && $return ) {
			$this->chmod( $destination_abs_path, $perms );
		}

		if ( ! $return && $this->use_filesystem ) {
			$source_abs_path      = $this->get_sanitized_path( $source_abs_path );
			$destination_abs_path = $this->get_sanitized_path( $destination_abs_path );
			$return               = $this->wp_filesystem->copy( $source_abs_path, $destination_abs_path, $overwrite, $perms );
		}

		return $return;
	}

	/**
	 * Move a file
	 *
	 * @param string $source_abs_path
	 * @param string $destination_abs_path
	 * @param bool   $overwrite
	 *
	 * @return bool
	 */
	public function move( $source_abs_path, $destination_abs_path, $overwrite = true ) {

		// error if source file doesn't exist
		if ( ! $this->file_exists( $source_abs_path ) ) {
			return false;
		}

		// Try using rename first. if that fails (for example, source is read only) try copy.
		// Taken in part from WP_Filesystem_Direct
		if ( ! $overwrite && $this->file_exists( $destination_abs_path ) ) {
			return false;
		} elseif ( @rename( $source_abs_path, $destination_abs_path ) ) {
			return true;
		} else {
			if ( $this->copy( $source_abs_path, $destination_abs_path, $overwrite ) && $this->file_exists( $destination_abs_path ) ) {
				$this->unlink( $source_abs_path );

				return true;
			} else {
				$return = false;
			}
		}

		if ( ! $return && $this->use_filesystem ) {
			$source_abs_path      = $this->get_sanitized_path( $source_abs_path );
			$destination_abs_path = $this->get_sanitized_path( $destination_abs_path );

			$return = $this->wp_filesystem->move( $source_abs_path, $destination_abs_path, $overwrite );
		}

		return $return;
	}
}
