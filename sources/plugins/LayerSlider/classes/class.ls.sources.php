<?php

class LS_Sources {

	// handle => path
	public static $skins = array();
	public static $sliders = array();
	public static $transitions = array();

	private function __construct() {

	}

	/**
	 * Adds the skins from the directory provided, so
	 * users can select them in the slider settings.
	 *
	 * @since 5.3.0
	 * @access public
	 * @param string $path Path to directory that holds your skins. It's assumed to be a direct skin folder if it contains a skin.css file.
	 * @return void
	 */
	public static function addSkins($path) {

		$skinsPath = $skins = array();
		$path = rtrim($path, '/\\');

		// It's a direct skin folder
		if(file_exists($path.'/skin.css')) {
			$skinsPath = array($path);

		}  else { // Get all children if it's a parent directory
			$skinsPath = glob($path.'/*', GLOB_ONLYDIR);
		}

		// Iterate over the skins
		foreach($skinsPath as $key => $path) {

			// Exclude non-valid skins
			if( !file_exists($path.'/skin.css') ) { continue; }

			// Gather skin data
			$handle = strtolower(basename($path));
			$skins[$handle] = array(
				'name' => $handle,
				'handle' => $handle,
				'dir' => $path,
				'file' => $path.DIRECTORY_SEPARATOR.'skin.css'
			);

			// Get skin info (if any)
			if(file_exists($path.'/info.json')) {
				$skins[$handle]['info'] = json_decode(file_get_contents($path.'/info.json'), true);
				$skins[$handle]['name'] = $skins[$handle]['info']['name'];
			}
		}

		self::$skins = array_merge(self::$skins, $skins);
		ksort( self::$skins );
	}



	/**
	 * Removes a previously added skin by its folder name as being $handle.
	 *
	 * @since 5.3.0
	 * @access public
	 * @param string $skin The name of the skin/folder
	 * @return void
	 */
	public static function removeSkin($handle) {
		unset( self::$skins[ strtolower($handle) ] );
	}



	/**
	 * Returns skin information by its folder name as being $handle.
	 *
	 * @since 5.3.0
	 * @access public
	 * @param string $skin The name of the skin/folder
	 * @return array Skin details
	 */
	public static function getSkin($handle) {
		return self::$skins[ strtolower($handle) ];
	}



	/**
	 * Returns all skins.
	 *
	 * @since 5.3.0
	 * @access public
	 * @return array Array of all skins
	 */
	public static function getSkins() {
		return self::$skins;
	}



	/**
	 * Returns the directory path of a skin by its folder name as being $handle
	 *
	 * @since 5.3.0
	 * @access public
	 * @param string $skin The name of the skin/folder
	 * @return string Path for the skin's directory
	 */
	public static function pathForSkin($handle) {
		return self::$skins[ strtolower($handle) ]['dir'] . DIRECTORY_SEPARATOR;
	}



	/**
	 * Returns the directory path of a skin by its folder name as being $handle
	 *
	 * @since 5.3.0
	 * @access public
	 * @param string $skin The name of the skin/folder
	 * @return string URL for the skin's directory
	 */
	public static function urlForSkin($handle) {
		$path = self::$skins[ strtolower($handle) ]['dir'];
		$url = content_url() . str_replace(realpath(WP_CONTENT_DIR), '', realpath($path)).'/';
		return str_replace('\\', '/', $url);
	}




	// ---------------------------------------------




	/**
	 * Adds an exported ZIP to the list of importable sample sliders.
	 *
	 * @since 5.3.0
	 * @access public
	 * @param string $path Path to the .zip file
	 * @return void
	 */
	public static function addDemoSlider( $path ) {

		$slidersPath = $sliders = array();
		$path = rtrim($path, '/\\');

		// It's a direct slider folder
		if(file_exists($path.'/slider.zip')) {
			$slidersPath = array($path);

		}  else { // Get all children if it's a parent directory
			$slidersPath = glob($path.'/*', GLOB_ONLYDIR);
		}

		// Iterate over the sliders
		if( ! empty( $slidersPath ) ) {
			foreach($slidersPath as $key => $path) {

				// Exclude non-valid demo sliders
				if( !file_exists($path.'/slider.zip') ) { continue; }

				// Gather slider data
				$handle = strtolower(basename($path));
				$sliders[$handle] = array(
					'name' => $handle,
					'handle' => $handle,
					'dir' => $path,
					'file' => $path.DIRECTORY_SEPARATOR.'slider.zip',
					'bundled' => true,
				);

				// Get skin info (if any)
				if(file_exists($path.'/info.json')) {
					$sliders[$handle]['info'] = json_decode(file_get_contents($path.'/info.json'), true);
					$sliders[$handle]['name'] = $sliders[$handle]['info']['name'];

					$sliders[$handle]['groups'] = 'free,bundled,';
					if( ! empty( $sliders[$handle]['info']['groups'] ) ) {
						$sliders[$handle]['groups'] .= $sliders[$handle]['info']['groups'];
					}

					$sliders[$handle]['url'] = '#';
					if( ! empty($sliders[$handle]['info']['url']) ) {
						$sliders[$handle]['url'] = $sliders[$handle]['info']['url'];
					}
				}

				// Get preview (if any)
				if(file_exists($path.'/preview.png')) {
					$url = content_url() . str_replace(realpath(WP_CONTENT_DIR), '', $path).'/preview.png';
					$sliders[$handle]['preview'] = str_replace('\\', '/', $url);
				}
			}
		}

		if( ! empty( $sliders ) ) {
			self::$sliders = array_merge(self::$sliders, $sliders);
			ksort( self::$sliders );
		}
	}


	/**
	 * Removes a previously added demo slider export by its folder name as being $handle
	 *
	 * @since 5.3.0
	 * @access public
	 * @param string $path Path to the .zip file
	 * @return void
	 */
	public static function removeDemoSlider( $handle ) {
		unset( self::$sliders[ strtolower($handle) ] );
	}



	/**
	 * Retrieves a previously added demo slider by its folder name as being $handle
	 *
 	 * @since 5.3.0
	 * @access public
	 * @param string $path Path to the .zip file
	 * @return array Array of previously added demo slider paths
	 */
	public static function getDemoSlider( $handle ) {
		return self::$sliders[ strtolower($handle) ];
	}



	/**
	 * Retrieves all demo sliders added previously.
	 *
 	 * @since 5.3.0
	 * @access public
	 * @param string $path Path to the .zip file
	 * @return array Array of previously added demo slider paths
	 */
	public static function getDemoSliders() {
		return self::$sliders;
	}


	/**
	 * Returns the directory path of a previously added demo slider export by its folder name as being $handle
	 *
	 * @since 5.3.0
	 * @access public
	 * @param string $path Path to the .zip file
	 * @return string Path to the .zip file
	 */
	public static function pathForDemoSlider( $handle ) {
		return self::$sliders[ strtolower($handle) ]['dir'] . DIRECTORY_SEPARATOR;
	}



	// ---------------------------------------------
}

?>
