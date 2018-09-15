<?php

/**
 * Class for working with ZIP archives to export
 * sliders with images and other attachments.
 *
 * @package LS_ExportUtil
 * @since 5.0.3
 * @author John Gera
 * @copyright Copyright (c) 2013  John Gera, George Krupa, and Kreatura Media Kft.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 */

class LS_ExportUtil {

	/**
	 * The managed ZipArchieve instance.
	 */
	private $zip;

	/**
	 * A temporary file in /wp-content/uploads/ to manipulate
	 * ZIPs on the fly without permanently saving to file system.
	 */
	private $file;


	/**
	 * Prepares a ZipArchieve instance and the file system
	 * to work with the class.
	 *
	 * @since 5.0.3
	 * @access public
	 * @return void
	 */
	public function __construct() {

		// Check for ZipArchieve
		if(class_exists('ZipArchive')) {

			// Temporary directory for file operations
			$upload_dir = wp_upload_dir();
			$tmp_dir = $upload_dir['basedir'];

			// Prepare ZIP to work with
			$this->file = tempnam($tmp_dir, "zip");
			$this->zip = new ZipArchive;
			$this->zip->open($this->file, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
		}
	}


	/**
	 * Adds slider settings .json file to ZIP
	 *
	 * @since 5.0.3
	 * @access public
	 * @param string $data Slider settings JSON
	 * @return void
	 */
	public function addSettings($data, $folder = '') {
		$folder = !empty($folder) ? $folder.'/' : '';
		$this->zip->addFromString($folder.'settings.json', $data);
	}


	/**
	 * Adds slider images to ZIP
	 *
	 * @since 5.0.3
	 * @access public
	 * @param string $path Image path to add
	 * @return void
	 */
	public function addImage($files, $folder = '') {

		// Check file
		if(empty($files)) { return false; }

		// Check file type
		if(!is_array($files)) { $files = array($files); }

		// Check folder
		$folder = is_string($folder) ? $folder.'/uploads/' : 'uploads/';

		// Add contents to ZIP
		foreach($files as $file) {
			if(!empty($file) && is_string($file)) {
				$this->zip->addFile($file,
					$folder.sanitize_file_name(basename($file))
				);
			}
		}
	}


	/**
	 * Closes all pending operations and downloads the ZIP file.
	 *
	 * @since 5.0.3
	 * @access public
	 * @return void
	 */
	public function download() {

		// Close ZIP operations
		$this->zip->close();

		// Set headers and to user
		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename="LayerSlider_Export_'.date('Y-m-d').'_at_'.date('H.i.s').'.zip"');
		header("Content-length: " . filesize($this->file));
		header('Pragma: no-cache');
		header('Expires: 0');
		readfile($this->file);

		// Remove temporary file
		unlink($this->file);
		die();
	}


	public function getImagesForSlider($data) {

		// Array to hold image URLs
		$images = array();

		// Slider Preview
		if( ! empty($data['meta'] ) && ! empty( $data['meta']['preview'] )) {
			$images[] = $data['meta']['preview'];
		}

		// Slider settings
		if(!empty($data['properties']['backgroundimage'])) {
			$images[] = $data['properties']['backgroundimage'];
		}

		if(!empty($data['properties']['yourlogo'])) {
			$images[] = $data['properties']['yourlogo'];
		}


		// Slides
		if(!empty($data['layers']) && is_array($data['layers'])) {
		foreach($data['layers'] as $slide) {

				if(!empty($slide['properties']['background'])) {
					$images[] = $slide['properties']['background']; }

				if(!empty($slide['properties']['thumbnail'])) {
					$images[] = $slide['properties']['thumbnail']; }

				// Layers
				if(!empty($slide['sublayers']) && is_array($slide['sublayers'])) {
					foreach($slide['sublayers'] as $layer) {

						if(!empty($layer['image'])) {
							$images[] = $layer['image']; }
					}
				}
			}
		}

		return $images;
	}



	public function fontsForSlider( $data ) {

		$ret = array();
		$usedFonts = array();
		$googleFonts = get_option('ls-google-fonts', array());

		if( !empty($data['layers']) && is_array($data['layers'])) {
			foreach($data['layers'] as $slide) {

				if( !empty($slide['sublayers']) && is_array($data['layers'])) {
					foreach($slide['sublayers'] as $layer) {

						if( !empty($layer['styles']) ) {

							// Ensure that magic quotes will not mess with JSON data
							if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
								$layer['styles'] = stripslashes($layer['styles']);
							}

							$styles = !empty($layer['styles']) ? json_decode(stripslashes($layer['styles']), true) : new stdClass;

							if( !empty($styles['font-family']) ) {
								$families = explode(',', $styles['font-family']);
								foreach( $families as $family ) {
									$family = trim( $family, " \"'\t\n\r\0\x0B");

									if( !empty($family) ) {
										$usedFonts[] = strtolower($family);
									}
								}
							}
						}
					}
				}
			}
		}

		foreach( $googleFonts as $font ) {
			list($family, $weights) = explode(':', $font['param']);
			$family = strtolower( str_replace('+', ' ', $family) );

			if( array_search($family, $usedFonts) !== false) {
				$font['admin'] = false;
				$ret[] = $font;
			}
		}

		return $ret;
	}


	public function getFSPaths($urls) {

		if(!empty($urls) && is_array($urls)) {

			$paths = array();

			foreach($urls as $url) {

				// Get URL relative to the uploads folder
				$urlPath = parse_url($url, PHP_URL_PATH);
				$urlPath = explode('/uploads/', $urlPath);
				$urlPath = $urlPath[1];

				// Get file path
				$filePath = WP_CONTENT_DIR .'/uploads/'.$urlPath;
				$filePath = realpath($filePath);

				// Add to array
				if(file_exists($filePath)) {
					$paths[] = $filePath;
				}
			}

			return $paths;
		}

		return array();
	}
}