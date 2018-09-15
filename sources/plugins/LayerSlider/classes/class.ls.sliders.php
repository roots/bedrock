<?php

class LS_Sliders {

	/**
	 * @var array $results Array containing the result of the last DB query
	 * @access public
	 */
	public static $results = array();



	/**
	 * @var int $count Count of found sliders in the last DB query
	 * @access public
	 */
	public static $count = null;



	/**
	 * Private constructor to prevent instantiate static class
	 *
	 * @since 5.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {

	}



	/**
	 * Returns the count of found sliders in the last DB query
	 *
	 * @since 5.0.0
	 * @access public
	 * @return int Count of found sliders in the last DB query
	 */
	public static function count() {
		return self::$count;
	}



	/**
	 * Find sliders with the provided filters
	 *
	 * @since 5.0.0
	 * @access public
	 * @param mixed $args Find any slider with the provided filters
	 * @return mixed Array on success, false otherwise
	 */
	public static function find($args = array()) {

		// Find by slider ID
		if(is_numeric($args) && intval($args) == $args) {
			return self::_getById( (int) $args );

		// Random slider
		} elseif($args === 'random') {
			return self::_getRandom();

		// Find by slider slug
		} elseif(is_string($args)) {
			return self::_getBySlug($args);

		// Find by list of slider IDs
		} elseif(is_array($args) && isset($args[0]) && is_numeric($args[0])) {
			return self::_getByIds($args);

		// Find by query
		} else {

			// Defaults
			$defaults = array(
				'columns' => '*',
				'where' => '',
				'exclude' => array('removed'),
				'orderby' => 'date_c',
				'order' => 'DESC',
				'limit' => 10,
				'page' => 1,
				'data' => true
			);

			// User data
			foreach($defaults as $key => $val) {
				if(!isset($args[$key])) { $args[$key] = $val; }
			}

			// Escape user data
			foreach($args as $key => $val) {
				if( $key !== 'where' ) {
					$args[$key] = esc_sql($val);
				}
			}

			// Exclude
			if(!empty($args['exclude'])) {
				if(in_array('hidden', $args['exclude'])) {
					$exclude[] = "flag_hidden = '0'"; }

				if(in_array('removed', $args['exclude'])) {
					$exclude[] = "flag_deleted = '0'"; }

				$args['exclude'] = implode(' AND ', $exclude);
			}

			// Where
			$where = '';
			if(!empty($args['where']) && !empty($args['exclude'])) {
				$where = "WHERE ({$args['exclude']}) AND ({$args['where']}) ";

			} elseif(!empty($args['where'])) {
				$where = "WHERE {$args['where']} ";

			} elseif(!empty($args['exclude'])) {
				$where = "WHERE {$args['exclude']} ";
			}

			// Some adjustments
			$args['limit'] = ($args['limit'] * $args['page'] - $args['limit']).', '.$args['limit'];

			// Build the query
			global $wpdb;
			$table = $wpdb->prefix.LS_DB_TABLE;
			$sliders = $wpdb->get_results("SELECT SQL_CALC_FOUND_ROWS {$args['columns']} FROM $table $where
									ORDER BY {$args['orderby']} {$args['order']} LIMIT {$args['limit']}", ARRAY_A);

			// Set counter
			$found = $wpdb->get_col("SELECT FOUND_ROWS()");
			self::$count = (int) $found[0];

			// Return original value on error
			if(!is_array($sliders)) { return $sliders; };

			// Parse slider data
			if($args['data']) {
				foreach($sliders as $key => $val) {
					$sliders[$key]['data'] = json_decode($val['data'], true);
				}
			}

			// Return sliders
			return $sliders;
		}
	}



	/**
	 * Add slider with the provided name and optional slider data
	 *
	 * @since 5.0.0
	 * @access public
	 * @param string $title The title of the slider to create
	 * @param array $data The settings of the slider to create
	 * @return int The slider database ID inserted
	 */
	public static function add($title = 'Unnamed', $data = array(), $slug = '') {

		global $wpdb;

		// Slider data
		$data = !empty($data) ? $data : array(
			'properties' => array('title' => $title, 'new' => true),
			'layers' => array(array()),
		);

		// Fix WP 4.2 issue with longer varchars
		// than the column length
		if(strlen($title) > 99) {
			$title = substr($title, 0, (99-strlen($title)) );
		}

		// Insert slider, WPDB will escape data automatically
		$wpdb->insert($wpdb->prefix.LS_DB_TABLE, array(
			'author' => get_current_user_id(),
			'name' => $title,
			'slug' => $slug,
			'data' => json_encode($data),
			'date_c' => time(),
			'date_m' => time()
		), array(
			'%d', '%s', '%s', '%s', '%d', '%d'
		));

		// Return insert database ID
		return $wpdb->insert_id;
	}



	/**
	 * Updates sliders
	 *
	 * @since 5.2.0
	 * @access public
	 * @param int $id The database ID of the slider to be updated
	 * @param string $title The new title of the slider
	 * @param array $data The new settings of the slider
	 * @return bool Returns true on success, false otherwise
	 */
	public static function update($id = 0, $title = 'Unnamed', $data = array(), $slug = '') {

		global $wpdb;

		// Slider data
		$data = !empty($data) ? $data : array(
			'properties' => array('title' => $title),
			'layers' => array(array()),
		);

		// Fix WP 4.2 issue with longer varchars
		// than the column length
		if(strlen($title) > 99) {
			$title = substr($title, 0, (99-strlen($title)) );
		}

		// Status
		$status = 0;
		if( empty($data['properties']['status']) || $data['properties']['status'] === 'false') {
			$status = 1;
		}

		// Schedule
		$schedule = array('schedule_start' => 0, 'schedule_end' => 0);
		foreach($schedule as $key => $val) {
			if( ! empty($data['properties'][$key]) ) {
				if( is_numeric($data['properties'][$key]) ) {
					$schedule[$key] = (int) $data['properties'][$key];
				} else {
					$tz = date_default_timezone_get();
					date_default_timezone_set( get_option('timezone_string') );
					$schedule[$key] = (int) strtotime($data['properties'][$key]);
					date_default_timezone_set( $tz );
				}
			}
		}



		// Insert slider, WPDB will escape data automatically
		$wpdb->update($wpdb->prefix.LS_DB_TABLE, array(
				'name' => $title,
				'slug' => $slug,
				'data' => json_encode($data),
				'schedule_start' => $schedule['schedule_start'],
				'schedule_end' => $schedule['schedule_end'],
				'date_m' => time(),
				'flag_hidden' => $status
			),
			array('id' => $id),
			array('%s', '%s', '%s', '%d', '%d', '%d', '%d')
		);

		// Return insert database ID
		return true;
	}


	/**
	 * Marking a slider as removed without deleting it
	 * with its database ID.
	 *
	 * @since 5.0.0
	 * @access public
	 * @param int $id The database ID if the slider to remove
	 * @return bool Returns true on success, false otherwise
	 */
	public static function remove($id = null) {

		// Check ID
		if(!is_int($id)) { return false; }

		// Remove
		global $wpdb;
		$wpdb->update($wpdb->prefix.LS_DB_TABLE,
			array('flag_deleted' => 1),
			array('id' => $id),
			'%d', '%d'
		);

		return true;
	}


	/**
	 * Delete a slider by its database ID
	 *
	 * @since 5.0.0
	 * @access public
	 * @param int $id The database ID if the slider to delete
	 * @return bool Returns true on success, false otherwise
	 */
	public static function delete($id = null) {

		// Check ID
		if(!is_int($id)) { return false; }

		// Delete
		global $wpdb;
		$wpdb->delete($wpdb->prefix.LS_DB_TABLE, array('id' => $id), '%d');

		return true;
	}



	/**
	 * Restore a slider marked as removed previously by its database ID.
	 *
	 * @since 5.0.0
	 * @access public
	 * @param int $id The database ID if the slider to restore
	 * @return bool Returns true on success, false otherwise
	 */
	public static function restore($id = null) {

		// Check ID
		if(!is_int($id)) { return false; }

		// Remove
		global $wpdb;
		$wpdb->update($wpdb->prefix.LS_DB_TABLE,
			array('flag_deleted' => 0),
			array('id' => $id),
			'%d', '%d'
		);

		return true;
	}




	private static function _getById($id = null) {

		// Check ID
		if(!is_int($id)) { return false; }

		// Get Sliders
		global $wpdb;
		$table = $wpdb->prefix.LS_DB_TABLE;
		$result = $wpdb->get_row("SELECT * FROM $table WHERE id = '$id' ORDER BY id DESC LIMIT 1", ARRAY_A);

		// Check return value
		if(!is_array($result)) { return false; }

		// Return result
		$result['data'] = json_decode($result['data'], true);
		return $result;
	}



	private static function _getByIds($ids = null) {

		// Check ID
		if(!is_array($ids)) { return false; }

		// DB stuff
		global $wpdb;
		$table = $wpdb->prefix.LS_DB_TABLE;
		$limit = count($ids);

		// Collect IDs
		if(is_array($ids) && !empty($ids)) {
			$tmp = array();
			foreach($ids as $id) {
				$tmp[] = 'id = \''.intval($id).'\'';
			}
			$ids = implode(' OR ', $tmp);
			unset($tmp);
		}

		// Make the call
		$result = $wpdb->get_results("SELECT * FROM $table WHERE $ids ORDER BY id DESC LIMIT $limit", ARRAY_A);

		// Decode slider data
		if(is_array($result) && !empty($result)) {
			foreach($result as $key => $slider) {
				$result[$key]['data'] = json_decode($slider['data'], true);
			}

			return $result;

		// Failed query
		} else {
			return false;
		}
	}





	private static function _getBySlug($slug) {

		// Check slug
		if(empty($slug)) { return false; }
			else { $slug = esc_sql($slug); }

		// Get DB stuff
		global $wpdb;
		$table = $wpdb->prefix.LS_DB_TABLE;

		// Make the call
		$result = $wpdb->get_row("SELECT * FROM $table WHERE slug = '$slug' ORDER BY id DESC LIMIT 1", ARRAY_A);

		// Check return value
		if(!is_array($result)) { return false; }

		// Return result
		$result['data'] = json_decode($result['data'], true);
		return $result;
	}



	private static function _getRandom() {

		// Get DB stuff
		global $wpdb;
		$table = $wpdb->prefix.LS_DB_TABLE;

		// Make the call
		$result = $wpdb->get_row("SELECT * FROM $table WHERE flag_hidden = '0' AND flag_deleted = '0' ORDER BY RAND() LIMIT 1", ARRAY_A);

		// Check return value
		if(!is_array($result)) { return false; }

		// Return result
		$result['data'] = json_decode($result['data'], true);
		return $result;
	}
}
