<?php

class ESSBTwitterCounterRecovery {
	
	public static function recovery_called() {
		global $_REQUEST;
		
		$recover_from = isset($_REQUEST['recover_from']) ? $_REQUEST['recover_from'] : '';
		
		if (!empty($recover_from)) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public static function recovery_start() {
		global $_REQUEST;
		
		$recover_from = isset($_REQUEST['recover_from']) ? $_REQUEST['recover_from'] : '';
		$recover_twitter = isset($_REQUEST['recover_twitter']) ? $_REQUEST['recover_twitter'] : '';
		
		$recover_from_text = "";
		
		switch ($recover_from) {
			case "minimal":
				if (intval($recover_twitter) != 0) {
					self::recover_minimal_value($recover_twitter);
					$recover_from_text = "Minimal share counter value";
				}
				break;
			case "metrics":
				self::recover_metrics_value($recover_twitter);
				$recover_from_text = "Metrics Lite";
				break;
			case "analytics":
				self::recover_analytics_value($recover_twitter);
				$recover_from_text = "Social Share Analytics";
				break;
		}
		
		if (!empty($recover_from_text)) {
			printf ( '<div class="essb-information-box"><div class="icon"><i class="fa fa-info-circle"></i></div><div class="inner">%1$s</div></div>', __ ( 'Twitter share counter recovery is completed. Data is loaded from: <b>'.$recover_from_text.'</b>', ESSB3_TEXT_DOMAIN ) );
		}
		
	}
	
	public static function recover_minimal_value($minimal_value = '') {
		if (intval($minimal_value) == 0) { return; }
		
		global $wpdb;
		$post_types = array();
		$pts	 = get_post_types( array('show_ui' => true, '_builtin' => true) );
		$cpts	 = get_post_types( array('show_ui' => true, '_builtin' => false) );
		
		foreach ( $pts as $pt ) {
			$post_types[] = $pt;
		}

		foreach ( $cpts as $pt ) {
			$post_types[] = $pt;
		}
		
		$querydata = new WP_Query ( array ('posts_per_page' => - 1, 'post_status' => 'publish', 'post_type' => $post_types ) );
		
		if ($querydata->have_posts ()) {
			while ( $querydata->have_posts () ) {
				$querydata->the_post ();
				global $post;
				$post_id = $post->ID;
				
				update_post_meta ( $post_id, 'essb_pc_twitter', $minimal_value );
			}
		}
	}
	
	public static function recover_metrics_value($minimal_value = '') {
		global $wpdb;
		$post_types = array();
		$pts	 = get_post_types( array('show_ui' => true, '_builtin' => true) );
		$cpts	 = get_post_types( array('show_ui' => true, '_builtin' => false) );
		
		foreach ( $pts as $pt ) {
			$post_types[] = $pt;
		}
		
		foreach ( $cpts as $pt ) {
			$post_types[] = $pt;
		}
		
		$querydata = new WP_Query ( array ('posts_per_page' => - 1, 'post_status' => 'publish', 'post_type' => $post_types ) );
		
		if ($querydata->have_posts ()) {
			while ( $querydata->have_posts () ) {
				$querydata->the_post ();
				global $post;
				$post_id = $post->ID;
		
				$metrics_value = get_post_meta ( $post_id, "esml_socialcount_twitter", true );
				
				if (intval($metrics_value) < intval($minimal_value)) {
					$metrics_value = $minimal_value;
				}
				
				if (!empty($metrics_value)) {
					update_post_meta ( $post_id, 'essb_pc_twitter', $metrics_value );
				}
				
			}
		}
	}
	
	public static function recover_analytics_value($minimal_value = '') {
		global $wpdb;
		$post_types = array();
		$pts	 = get_post_types( array('show_ui' => true, '_builtin' => true) );
		$cpts	 = get_post_types( array('show_ui' => true, '_builtin' => false) );
		
		foreach ( $pts as $pt ) {
			$post_types[] = $pt;
		}
		
		foreach ( $cpts as $pt ) {
			$post_types[] = $pt;
		}
		
		$data_from_analytics = self::analytics_data_by_posts();
		
		$querydata = new WP_Query ( array ('posts_per_page' => - 1, 'post_status' => 'publish', 'post_type' => $post_types ) );
		
		if ($querydata->have_posts ()) {
			while ( $querydata->have_posts () ) {
				$querydata->the_post ();
				global $post;
				$post_id = $post->ID;
		
				$metrics_value = isset($data_from_analytics[$post_id]) ? $data_from_analytics[$post_id] : "";
		
				if (intval($metrics_value) < intval($minimal_value)) {
					$metrics_value = $minimal_value;
				}
		
				if (!empty($metrics_value)) {
					update_post_meta ( $post_id, 'essb_pc_twitter', $metrics_value );
				}
			}
		}
	}
	
	public static function analytics_data_by_posts() {
		global $wpdb, $essb_networks;
		$table_name = $wpdb->prefix . ESSB3_TRACKER_TABLE;
		
		$use_this_networks = array("twitter" => "Twitter");
		
		$query = "";
		//foreach($essb_networks as $k => $v) {
		$query .= "SELECT essb_post_id, COUNT( essb_post_id ) AS cnt";
		
		foreach($use_this_networks as $k => $v) {
			$query .= ",SUM( IF( essb_service =  '".$k."', 1, 0 ) ) AS ".$k;
		}
		
		$query .= " FROM  ".$table_name . "
			GROUP BY essb_post_id
			ORDER BY cnt DESC ";
		
		$post_stats = $wpdb->get_results ( $query );
		
		$result = array();
		
		if (isset($post_stats)) {
		
			foreach ( $post_stats as $rec ) {
				$post_id = $rec->essb_post_id;
				$counter = $rec->twitter;
				
				$result[$post_id] = $counter;
			}
		}
			
		
		return $result;
	}
	
}

?>