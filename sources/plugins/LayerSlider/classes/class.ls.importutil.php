<?php

/**
 * Class for working with ZIP archives to import
 * sliders with images and other attachments.
 *
 * @package LS_ImportUtil
 * @since 5.0.3
 * @author John Gera
 * @copyright Copyright (c) 2013  John Gera, George Krupa, and Kreatura Media Kft.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 */

class LS_ImportUtil {

	public $lastImportId;

	/**
	 * The managed ZipArchieve instance.
	 */
	private $zip;

	/**
	 * Target folders
	 */
	private $uploadsDir, $targetDir, $targetURL, $tmpDir;

	// Imported images
	private $imported = array();


	// Accepts $_FILES
	public function __construct($archive, $name = null) {

		// Attempt to workaround memory limit & execution time issues
		@ini_set( 'max_execution_time', 0 );
		@ini_set( 'memory_limit', '256M' );

		if(empty($name)) {
			$name = $archive;
		}

		// TODO: check file extension to support old import method
		$type = wp_check_filetype(basename($name), array(
			'zip' => 'application/zip',
			'json' => 'application/json'
		));

		// Check for ZIP
		if(!empty($type['ext']) && $type['ext'] == 'zip') {
			if(class_exists('ZipArchive')) {

				// Remove previous uploads (if any)
				$this->cleanup();

				// Extract ZIP
				$this->zip = new ZipArchive;
				if($this->zip->open($archive)) {
					if($this->unpack($archive)) {

						// Uploaded folders
						foreach(glob($this->tmpDir.'/*', GLOB_ONLYDIR) as $key => $dir) {

							$this->imported = array();

							if(!isset($_POST['skip_images'])) {
								$this->uploadMedia($dir);
							}

							if(file_exists($dir.'/settings.json')) {
								$this->lastImportId = $this->addSlider($dir.'/settings.json');
							}
						}

						// Finishing up
						$this->cleanup();
						return true;
					}

					// Close ZIP
					$this->zip->close();
				}
			} else {
				header('Location: admin.php?page=layerslider&error=1&message=exportZipError');
				die();
			}


		// Check for JSON
		} elseif(!empty($type['ext']) && $type['ext'] == 'json') {

			// Get decoded file data
			$data = file_get_contents($archive);
			if($decoded = base64_decode($data, true)) {
				if(!$parsed = json_decode($decoded, true)) {
					$parsed = unserialize($decoded);
				}

			// Since v5.1.1
			} else {
				$parsed = array(json_decode($data, true));
			}

			// Iterate over imported sliders
			if(is_array($parsed)) {

				// Import sliders
				foreach($parsed as $item) {

					// Fix for export issue in v4.6.4
					if(is_string($item)) { $item = json_decode($item, true); }

					$this->lastImportId = LS_Sliders::add($item['properties']['title'], $item);
				}
			}
		}

		// Return false otherwise
		return false;
	}



	public function unpack($archive) {

		// Get uploads folder
		$uploads = wp_upload_dir();

		// Check if /uploads dir is writable
		if(is_writable($uploads['basedir'])) {

			// Get target folders
			$this->uploadsDir 	= $uploads['basedir'];
			$this->targetDir 	= $targetDir = $uploads['basedir'].'/layerslider';
			$this->targetURL 	= $uploads['baseurl'].'/layerslider';
			$this->tmpDir 		= $tmpDir = $uploads['basedir'].'/layerslider/tmp';

			// Create necessary folders under /uploads
			if( ! file_exists( $targetDir ) ) { mkdir($targetDir, 0755); }
			if( ! file_exists( $targetDir ) ) { mkdir($targetDir, 0755); }

			// Unpack archive
			if($this->zip->extractTo($tmpDir)) {
				return true;
			}
		}

		return false;
	}




	public function uploadMedia($dir = null) {

		// Check provided data
		if(empty($dir) || !is_string($dir) || !file_exists($dir.'/uploads')) {
			return false;
		}

		// Create folder if it isn't exists already
		$targetDir = $this->targetDir . '/' . basename($dir);
		if( ! file_exists( $targetDir ) ) { mkdir($targetDir, 0755); }

		// Include image.php for media library upload
		require_once(ABSPATH.'wp-admin/includes/image.php');

		// Iterate through directory
		foreach(glob($dir.'/uploads/*') as $filePath) {

			$fileName 	= sanitize_file_name(basename($filePath));
			$targetFile = $targetDir.'/'.$fileName;
			$targetURL 	= $this->targetURL.'/'.basename($dir).'/'.$fileName;

			// Validate media
			$filetype = wp_check_filetype($fileName, null);
			if(!empty($filetype['ext']) && $filetype['ext'] != 'php') {

				// New upload
				if( ! $attach_id = $this->attachIDForURL( $targetURL, $targetFile ) ) {

					// Move item to place
					rename($filePath, $targetFile);

					// Upload to media library
					$attachment = array(
						'guid' => $targetFile,
						'post_mime_type' => $filetype['type'],
						'post_title' => preg_replace( '/\.[^.]+$/', '', $fileName),
						'post_content' => '',
						'post_status' => 'inherit'
					);

					$attach_id = wp_insert_attachment($attachment, $targetFile, 37);
					if($attach_data = wp_generate_attachment_metadata($attach_id, $targetFile)) {
						wp_update_attachment_metadata($attach_id, $attach_data);
					}

					$this->imported[$fileName] = array(
						'id' => $attach_id,
						'url' => $this->targetURL.'/'.basename($dir).'/'.$fileName
					);

				// Already uploaded
				} else {

					$this->imported[$fileName] = array(
						'id' => $attach_id,
						'url' => $targetURL
					);
				}
			}
		}

		return true;
	}



	public function deleteDir($dir) {
		if(!file_exists($dir)) return true;
		if(!is_dir($dir)) return unlink($dir);
		foreach(scandir($dir) as $item) {
			if($item == '.' || $item == '..') continue;
			if(!$this->deleteDir($dir.DIRECTORY_SEPARATOR.$item)) return false;
		}
		return rmdir($dir);
	}




	public function addSlider($file) {

		// Get slider data and title
		$data = json_decode(file_get_contents($file), true);
		$title = $data['properties']['title'];
		$slug = !empty($data['properties']['slug']) ? $data['properties']['slug'] : '';

		// Import Google Fonts used in slider
		if( isset( $data['googlefonts'] ) ) {
			$this->addGoogleFonts( $data );
			unset( $data['googlefonts'] );
		}

		// Slider Preview
		if( ! empty($data['meta']) && ! empty($data['meta']['preview']) ) {
			$data['meta']['preview'] = $this->attachURLForImage( $data['meta']['preview'] );
		}

		// Slider settings
		if(!empty($data['properties']['backgroundimage'])) {
			$data['properties']['backgroundimage'] = $this->attachURLForImage(
				$data['properties']['backgroundimage']
			);
		}

		if(!empty($data['properties']['yourlogo'])) {
			$data['properties']['yourlogoId'] = $this->attachIDForImage($data['properties']['yourlogo']);
			$data['properties']['yourlogo'] = $this->attachURLForImage($data['properties']['yourlogo']);
		}


		// Slides
		if(!empty($data['layers']) && is_array($data['layers'])) {
		foreach($data['layers'] as &$slide) {

			if(!empty($slide['properties']['background'])) {
				$slide['properties']['backgroundId'] = $this->attachIDForImage($slide['properties']['background']);
				$slide['properties']['background'] = $this->attachURLForImage($slide['properties']['background']);
			}

			if(!empty($slide['properties']['thumbnail'])) {
				$slide['properties']['thumbnailId'] = $this->attachIDForImage($slide['properties']['thumbnail']);
				$slide['properties']['thumbnail'] = $this->attachURLForImage($slide['properties']['thumbnail']);
			}

			// Layers
			if(!empty($slide['sublayers']) && is_array($slide['sublayers'])) {
			foreach($slide['sublayers'] as &$layer) {

				if( ! empty($layer['image']) ) {
					$layer['imageId'] = $this->attachIDForImage($layer['image']);
					$layer['image'] = $this->attachURLForImage($layer['image']);
				}
			}}
		}}

		// Add slider
		return LS_Sliders::add($title, $data, $slug);
	}



	public function addGoogleFonts( $data ) {

		// Get current Google Fonts
		$googleFonts = get_option('ls-google-fonts', array());
		$fontNames = array();


		// Gather used font names
		foreach( $googleFonts as $item ) {
			$font = explode(':', $item['param']);
			$fontNames[ $font[0] ] = $item;
		}

		// Merge google fonts
		foreach( $data['googlefonts'] as $font ) {

			// If no font-weight is specified, default to regular 400
			// since Google Fonts do exactly this as well.
			if( mb_substr(trim($font['param']), -1) !== ':' ) {
				$font['param'] .= ':400';
			}

			list($family, $weights) = explode(':', $font['param']);

			// New font, just add
			if( ! isset($fontNames[$family]) ) {
				$fontNames[$family] = $font;

			// Existing font, merge variants
			} else {

				$w = array();

				foreach( explode(',', $weights) as $weight ) {
					$w[$weight] = true;
				}

				// If no font-weight is specified, default to regular 400
				// since Google Fonts do exactly this as well.
				if( mb_substr(trim($fontNames[ $family ]['param']), -1) !== ':' ) {
					$fontNames[ $family ]['param'] .= ':400';
				}

				list($family, $weights) = explode(':', $fontNames[ $family ]['param']);
				foreach( explode(',', $weights) as $weight ) {
					$w[$weight] = true;
				}

				$fontNames[ $family ] = $font;
				$fontNames[ $family ]['param'] = $family .':'. implode(',', array_keys($w));
			}
		}

		// Update Google Fonts
		$googleFonts = array();
		foreach( $fontNames as $font ) {
			$googleFonts[] = $font;
		}

		update_option('ls-google-fonts', $googleFonts);
	}



	public function attachURLForImage($file = '') {

		if( isset($this->imported[ basename($file) ]) ) {
			return $this->imported[ basename($file) ]['url'];
		}

		return $file;
	}


	public function attachIDForImage($file = '') {

		if( isset($this->imported[ basename($file) ]) ) {
			return $this->imported[ basename($file) ]['id'];
		}

		return '';
	}

	public function attachIDForURL( $url, $path ) {

		// Attempt to retrieve the post ID from the built in
		// attachment_url_to_postid() WP function when available.
		if( function_exists('attachment_url_to_postid') ) {
			if( $attachID = attachment_url_to_postid( $url ) ) {
				return $attachID;
			}
		}

		global $wpdb;

		if( empty( $this->uploadsDir ) ) {
			$uploads = wp_upload_dir();
			$this->uploadsDir = trailingslashit($uploads['basedir']);
		}

		$imgPath  = explode( parse_url( $this->uploadsDir, PHP_URL_PATH ), $path );
		$attachs = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}posts WHERE guid RLIKE %s;", $imgPath[1] ) );


		return ! empty( $attachs[0] ) ? $attachs[0] : 0;
	}

	public function cleanup() {
		$this->deleteDir($this->tmpDir);
	}
}
?>