<?php

class ESSBSocialShareAnalyticsBackEnd {
	
	public static $positions = array();
	
	function __construct() {
	}
	
	public static function init_addional_settings() {
		$all_positions = essb5_available_content_positions();
		
		foreach ($all_positions as $key => $data) {
			$key = str_replace("content_", "", $key);
			
			if ($key == 'manual') {
				$key = 'shortcode';
			}
			
			self::$positions[] = $key;
		}
		
		$all_positions = essb5_available_button_positions();
		foreach ($all_positions as $key => $data) {
			self::$positions[] = $key;
		}
		
		$all_positions = essb5_available_button_positions_mobile();
		
		foreach ($all_positions as $key => $data) {
			if (!in_array($key, self::$positions)) {
				self::$positions[] = $key;
			}
		}
	}
	
	public static function install() {
		global $wpdb;
	
		$sql = "";
	
		$table_name = $wpdb->prefix . ESSB3_TRACKER_TABLE;
	
		$sql .= "CREATE TABLE $table_name (
		essb_id mediumint(9) NOT NULL AUTO_INCREMENT,
		essb_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		essb_blog_id VARCHAR(10) NOT NULL,
		essb_post_id VARCHAR(10) NOT NULL,
		essb_service VARCHAR(40) NOT NULL,
		essb_mobile VARCHAR(40) NOT NULL,
		essb_position VARCHAR(40) NOT NULL,
		essb_template VARCHAR(80) NOT NULL,
		essb_button VARCHAR(20) NOT NULL,
		UNIQUE KEY essb_id (essb_id)
		); ";	
	
		require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
				dbDelta ( $sql );
	}
	
	public static function essb_stats_by_networks($month = '', $post_id = '', $date = '', $position = '') {
		global $wpdb, $essb_options, $essb_networks;
				
		$query = "";
		$table_name = $wpdb->prefix . ESSB3_TRACKER_TABLE;
		//foreach($essb_networks as $k => $v) {
		$query .= "SELECT COUNT( essb_post_id ) AS cnt";
		
		foreach($essb_networks as $k => $v) {
			if ($k == "facebook") {
				$query .= ",SUM( IF( essb_service =  '".$k."' OR essb_service =  'facebook_advanced', 1, 0 ) ) AS ".$k;
			}
			else if ($k == "print") {
				$query .= ",SUM( IF( essb_service =  '".$k."' OR essb_service =  'print_friendly', 1, 0 ) ) AS ".$k;
			}
			else {
				$query .= ",SUM( IF( essb_service =  '".$k."', 1, 0 ) ) AS ".$k;
			}
			
		}
		
		$query .= " FROM  ".$table_name;
		
		if ($month != '') {
			$query .= " WHERE DATE_FORMAT( essb_date,  \"%Y-%m\" ) = '".$month."'";
		}
		if ($date != '') {
			$query .= " WHERE DATE_FORMAT( essb_date,  \"%Y-%m-%d\" ) = '".$date."'";
		}
		if ($position != '') {
			$query .= " WHERE essb_position = '".$position."'";
		}
		
		if ($post_id != '') {
			$query .= " WHERE essb_post_id='".$post_id."'";
		}
		
		$query .= " ORDER BY cnt DESC";		
		
		$network_stats = $wpdb->get_row ( $query );
		
		return $network_stats;
	}
	
	public static function essb_stats_by_position($month = '', $post_id = '', $date = '', $position = '') {
		global $wpdb, $essb_options, $essb_networks;
		
		$query = "";
		$table_name = $wpdb->prefix . ESSB3_TRACKER_TABLE;
		//foreach($essb_networks as $k => $v) {
		$query .= "SELECT COUNT( essb_post_id ) AS cnt";
		
		foreach(self::$positions as $k) {
			$query .= ",SUM( IF( essb_position =  '".$k."', 1, 0 ) ) AS position_".$k;
		}
		
		$query .= " FROM  ".$table_name;
		
		if ($month != '') {
			$query .= " WHERE DATE_FORMAT( essb_date,  \"%Y-%m\" ) = '".$month."'";
		}
		
		if ($date != '') {
			$query .= " WHERE DATE_FORMAT( essb_date,  \"%Y-%m-%d\" ) = '".$date."'";
		}
		if ($position != '') {
			$query .= " WHERE essb_position = '".$position."'";
		}
		
		if ($post_id != '') {
			$query .= " WHERE essb_post_id='".$post_id."'";
		}
		
		$query .= " ORDER BY cnt DESC";
		
		$network_stats = $wpdb->get_row ( $query );
		
		//print $query;
		
		return $network_stats;
		
	}
	
	public static function essb_stats_by_device($month = '', $post_id = '', $date = '', $position = '') {
		global $wpdb, $essb_options, $essb_networks;
		
		$query = "";
		$table_name = $wpdb->prefix . ESSB3_TRACKER_TABLE;
		//foreach($essb_networks as $k => $v) {
		$query .= "SELECT COUNT( essb_post_id ) AS cnt";
		
		
		$query .= ",SUM( IF( essb_mobile =  'true', 1, 0 ) ) AS mobile";
		$query .= ",SUM( IF( essb_mobile =  'false', 1, 0 ) ) AS desktop";
		
		
		$query .= " FROM  ".$table_name . "
		WHERE essb_service != 'sidebar-close' ";
		if ($month != '') {
			$query .= " AND DATE_FORMAT( essb_date,  \"%Y-%m\" ) = '".$month."'";
		}
		if ($date != '') {
			$query .= " AND DATE_FORMAT( essb_date,  \"%Y-%m-%d\" ) = '".$date."'";
		}
		if ($position != '') {
			$query .= " AND essb_position = '".$position."'";
		}
		if ($post_id != '') {
			$query .= " AND essb_post_id='".$post_id."'";
		}
		
		$query .= " ORDER BY cnt DESC";
		
		$network_stats = $wpdb->get_row ( $query );
		
		return $network_stats;
	}
	
	public static function prettyPrintNumber($number) {
		if (! is_numeric ( $number )) {
			return $number;
		}
	
		if ($number >= 1000000) {
			return round ( ($number / 1000) / 1000, 1 ) . "M";
		}
	
		elseif ($number >= 100000) {
			return round ( $number / 1000, 0 ) . "k";
		}
	
		else {
			return @number_format ( $number );
		}
	}
	
	public static function getDateRangeRecords($fromDate, $toDate) {
	
		global $wpdb, $blog_id;
		$table_name = $wpdb->prefix . ESSB3_TRACKER_TABLE;
		$toDate = date ( "Y-m-d", strtotime ( date ( "Y-m-d", strtotime ( $toDate ) ) . "+1 day" ) );
	
		$table_name = $wpdb->prefix . ESSB3_TRACKER_TABLE;
		$query_date_stats = 'SELECT DATE_FORMAT(essb_date, "%Y-%m-%d") AS essb_date, COUNT( essb_post_id ) AS cnt FROM '.$table_name.' WHERE essb_date BETWEEN "'.$fromDate.'" AND "'.$toDate.'" GROUP BY DATE_FORMAT(essb_date, "%Y-%m-%d") ORDER BY essb_date DESC';
	
		return $wpdb->get_results($query_date_stats);
	}
	
	public static function sqlDateRangeRecordConvert($fromDate, $toDate, $object) {
		$exist_dates = array ();
	
		foreach ( $object as $single ) {
			$date = $single->essb_date;
	
			$total = $single->cnt;
	
			if (! isset ( $exist_dates [$date] )) {
				$exist_dates [$date] = 0;
			}
	
			$exist_dates [$date] += $total;
		}
	
		$output = array ();
	
		while ( $fromDate <= $toDate ) {
			if (isset ( $exist_dates [$fromDate] )) {
				$output [$fromDate] = $exist_dates [$fromDate];
			} else {
				$output [$fromDate] = '0';
			}
	
			$fromDate = date ( 'Y-m-d', strtotime ( $fromDate . ' +1 day' ) );
	
		}
	
		return $output;
	}
	
	public static function essb_stats_by_networks_by_months() {
		global $wpdb, $essb_networks;
		$table_name = $wpdb->prefix . ESSB3_TRACKER_TABLE;	
	
		$query = "";
	
		//foreach($essb_networks as $k => $v) {
		$query .= "SELECT COUNT( essb_post_id ) AS cnt";
	
		foreach($essb_networks as $k => $v) {
			//$query .= ",SUM( IF( essb_service =  '".$k."', 1, 0 ) ) AS ".$k;
			if ($k == "facebook") {
				$query .= ",SUM( IF( essb_service =  '".$k."' OR essb_service =  'facebook_advanced', 1, 0 ) ) AS ".$k;
			}
			else if ($k == "print") {
				$query .= ",SUM( IF( essb_service =  '".$k."' OR essb_service =  'print_friendly', 1, 0 ) ) AS ".$k;
			}
			else {
				$query .= ",SUM( IF( essb_service =  '".$k."', 1, 0 ) ) AS ".$k;
			}
		}
	
		$query .= ", DATE_FORMAT( essb_date,  \"%Y-%m\" ) AS month FROM  ".$table_name . "
		GROUP BY month ORDER BY month DESC ";
	
		//print $query;
	
		$network_stats = $wpdb->get_results ( $query );
	
		return $network_stats;
	}
	
	public static function essb_stats_by_networks_by_date_for_post($fromDate, $toDate, $post_id) {
		global $wpdb, $essb_networks;
		$table_name = $wpdb->prefix . ESSB3_TRACKER_TABLE;
		$toDate = date ( "Y-m-d", strtotime ( date ( "Y-m-d", strtotime ( $toDate ) ) . "+1 day" ) );
		
		$query = "";
	
		//foreach($essb_networks as $k => $v) {
		$query .= "SELECT COUNT( essb_post_id ) AS cnt";
	
		foreach($essb_networks as $k => $v) {
			//$query .= ",SUM( IF( essb_service =  '".$k."', 1, 0 ) ) AS ".$k;
			if ($k == "facebook") {
				$query .= ",SUM( IF( essb_service =  '".$k."' OR essb_service =  'facebook_advanced', 1, 0 ) ) AS ".$k;
			}
			else if ($k == "print") {
				$query .= ",SUM( IF( essb_service =  '".$k."' OR essb_service =  'print_friendly', 1, 0 ) ) AS ".$k;
			}
			else {
				$query .= ",SUM( IF( essb_service =  '".$k."', 1, 0 ) ) AS ".$k;
			}
		}
	
		$query .= ", DATE_FORMAT( essb_date,  \"%Y-%m-%d\" ) AS month FROM  ".$table_name . "
		WHERE essb_post_id='".$post_id."' AND essb_date BETWEEN '".$fromDate."' AND '".$toDate."' 
		GROUP BY DATE_FORMAT( essb_date,  \"%Y-%m-%d\" ) ORDER BY essb_date DESC ";
	
		//print $query;
	
		$network_stats = $wpdb->get_results ( $query );
	
		return $network_stats;
	}
	
	public static function essb_stat_admin_detail_by_month($post_stats, $networks_with_data, $month = '', $month_title = 'Month') {
		global $wpdb, $essb_networks;
	
		//print_r($post_stats);
	
		$table_name = $wpdb->prefix . ESSB3_TRACKER_TABLE;	
	
		
	
		print '<table border="0" cellpadding="5" cellspacing="0" width="100%" class="post-table display hover row-border stripe" id="table-month">';
	
		print "<thead>";
		print "<tr>";
	
		print "<th class=\"sub2\">".$month_title."</th>";
		print "<th class=\"sub2\">Total</th>";
	
		foreach($essb_networks as $k => $v) {
	
			if (isset($networks_with_data[$k])) {
					
				print "<th class=\"sub2\">".$v['name']."</th>";
					
			}
		}
	
		print "</tr>";
		print "</thead>";
		print "<tbody>";
		if (isset($post_stats)) {
			$cnt = 0;
			foreach ( $post_stats as $rec ) {
				//print_r($rec);
				$cnt++;
					
				$class= "";
					
				if ($cnt % 2 == 0) {
					$class = "odd table-border-bottom";
				} else { $class= "even table-border-bottom";
				}
					
				print "<tr class=\"".$class."\">";
					
				if ($month_title == 'Date') {
					print "<td>".$rec->month.'</td>';
				}
				else {
					print "<td><a href=\"admin.php?page=essb_redirect_analytics&tab=analytics&mode=2&essb_month=".$rec->month."\">".$rec->month.'</a></td>';
				}
				print "<td align=\"right\" class=\"bold\">".$rec->cnt.'</td>';
	
				foreach($essb_networks as $k => $v) {
					if (isset($networks_with_data[$k])) {
						print "<td align=\"right\">".$rec->{$k}.'</td>';
					}
				}
	
				print "</tr>";
	
			}
		}
	
		print "</tbody>";
		print "</table>";
	}

	public static function essb_stat_admin_detail_by_post($month = '', $networks_with_data, $limit = '', $date = '', $position = '') {
		global $wpdb, $essb_networks;
		$table_name = $wpdb->prefix . ESSB3_TRACKER_TABLE;

		$query = "";
		//foreach($essb_networks as $k => $v) {
		$query .= "SELECT essb_post_id, COUNT( essb_post_id ) AS cnt";
	
		foreach($essb_networks as $k => $v) {
			//$query .= ",SUM( IF( essb_service =  '".$k."', 1, 0 ) ) AS ".$k;
			if ($k == "facebook") {
				$query .= ",SUM( IF( essb_service =  '".$k."' OR essb_service =  'facebook_advanced', 1, 0 ) ) AS ".$k;
			}
			else if ($k == "print") {
				$query .= ",SUM( IF( essb_service =  '".$k."' OR essb_service =  'print_friendly', 1, 0 ) ) AS ".$k;
			}
			else {
				$query .= ",SUM( IF( essb_service =  '".$k."', 1, 0 ) ) AS ".$k;
			}
		}
	
		if ($month == '' && $date == '' && $position == '') {
			$query .= " FROM  ".$table_name . "
			GROUP BY essb_post_id
			ORDER BY cnt DESC ";
		}
		else {
			if ($date != '') {
				$query .= " FROM  ".$table_name . "
				WHERE DATE_FORMAT( essb_date,  \"%Y-%m-%d\" ) = '".$date."'
				GROUP BY essb_post_id
				ORDER BY cnt DESC ";
				
			}
			else if ($position != '') {
				$query .= " FROM  ".$table_name . "
				WHERE essb_position = '".$position."'
				GROUP BY essb_post_id
				ORDER BY cnt DESC ";
			}
  			else {
				$query .= " FROM  ".$table_name . "
				WHERE DATE_FORMAT( essb_date,  \"%Y-%m\" ) = '".$month."'
				GROUP BY essb_post_id
				ORDER BY cnt DESC ";
			}
		}
	
		//print $query;
		$post_stats = $wpdb->get_results ( $query );
	
		print '<table border="0" cellpadding="5" cellspacing="0" width="100%" class="post-table display hover row-border stripe" id="table-posts">';
	
		print "<thead>";
		print "<tr>";
	
		print "<th class=\"sub2\">Post/Page</th>";
		print "<th class=\"sub2\">Total</th>";
	
		foreach($essb_networks as $k => $v) {
				
			if (isset($networks_with_data[$k])) {
					
				print "<th class=\"sub2\">".$v['name']."</th>";
					
			}
		}
	
		print "</tr>";
		print "</thead>";
		print "<tbody>";
		if (isset($post_stats)) {
			$cnt = 0;
			foreach ( $post_stats as $rec ) {
					
				$cnt++;
					
				$class= "";
					
				if ($cnt % 2 == 0) {
					$class = "odd table-border-bottom";
				} else { $class= "even table-border-bottom";
				}
					
				print "<tr class=\"".$class."\">";
					
				print "<td><a href=\"".get_permalink($rec->essb_post_id)."\">".get_the_title($rec->essb_post_id).'</a></td>';
				print "<td align=\"right\" class=\"bold\">".$rec->cnt.'</td>';
	
				foreach($essb_networks as $k => $v) {
					if (isset($networks_with_data[$k])) {
						print "<td align=\"right\">".$rec->{$k}.'</td>';
					}
				}
	
				print "</tr>";
	
				if (intval($limit) != 0) {
					if (intval($limit) < $cnt) {
						break;
					}
				}
			}
		}
	
		print "</tbody>";
		print "</table>";
	}
	
	public static function keyObjectToMorrisLineGraph($chart_id, $object, $series_label = 'Total Value:') {
		$output = "";
	
		$output .= "Morris.Line({
		element: '" . $chart_id . "',
		data: [";
	
		$is_passedOne = false;
		foreach ( $object as $key => $value ) {
			if ($value == 0 && !$is_passedOne) {
				$is_passedOne = true;
				continue;
			}
			$is_passedOne = true;
	
			$output .= "{ y: '" . $key . "', a: '" . $value . "' },";
	
		}
	
		$output .= "],
		xkey: 'y',
		ykeys: ['a'],
		hideHover: true,
		hoverCallback: function (index, options, content, row) {
  return '<span style=\'font-size:14px;\'><b>'+row.y+'</b></span><br/><span style=\'font-size:14px; color: #3498db;\'>Social activity for date: <b>'+row.a+'</b> clicks<br/><b style=\"cursor: pointer; color: #333;\" onclick=\"essb_analytics_date_report(\''+row.y+'\'); return false;\" title=\"Activate detailed date report\">Double click here to see detailed date report</b></span>';
},
		labels: ['" . $series_label . "'],
		lineColors: ['#3498db']
	});";
	
		$output = str_replace ( ',]', ']', $output );
	
		return $output;
	}
	
	public static function generate_bar_graph_month($month) {
		global $wpdb;
		$table_name = $wpdb->prefix . ESSB3_TRACKER_TABLE;
		//cal_days_in_month(CAL_GREGORIAN, 8, 2003);
		$month_arr = explode("-", $month);
		if (!function_exists('cal_days_in_month')) { 
			function cal_days_in_month($calendar, $month, $year) {
				return date('t', mktime(0, 0, 0, $month, 1, $year));
			}
		}
		$days_in_mon = cal_days_in_month(CAL_GREGORIAN, intval($month_arr[1]), intval($month_arr[0]));
	
		$query = "";
	
		$query_date_stats = "SELECT DATE_FORMAT(essb_date, \"%Y-%m-%d\") AS essb_date, COUNT( essb_post_id ) AS cnt FROM ".$table_name." GROUP BY DATE_FORMAT(essb_date, \"%Y-%m-%d\") ORDER BY essb_date DESC";
		$date_stats = $wpdb->get_results ( $query_date_stats );
	
		$graph_data = "";
	
		if (isset($date_stats)) {
			foreach ( $date_stats as $rec ) {
				$date = $rec->essb_date;
				$result_array[$date] = $rec;
			}
		}
	
	
		$report_html = "";
		
		for ($i=1;$i<=intval($days_in_mon);$i++) {
	
			if ($graph_data != "") {
				$graph_data .= ",";
			}
	
			$day = strval($i);
			if ($i < 10) {
				$day = "0".strval($i);
			}
	
			$today = $month . "-" . $day;
			if (isset($result_array[$today])) {
				//print "exist " . $today;
				$rec = $result_array[$today];
				$graph_data .= "{ y: '".$today."', a:".intval($rec->cnt)."}";
				$report_html .= '<div class="day-value"><a href="#" onclick="essb_analytics_date_report(\''.$today.'\'); return false;">'.$today.' <span class="value">('.intval($rec->cnt).')</span></a></div>';
			}
			else {
				$graph_data .= "{ y: '".$today."', a:".intval(0)."}";
			}
	
		}
	
		print "
		<div id=\"bar-by-dates\"></div>
		<div class=\"date-reports essb-title5\"><div>Start detailed report for date</div></div><div class=\"date-reports-dates\">".$report_html."</div>
		<script type=\"text/javascript\">
		Morris.Bar({
		element: 'bar-by-dates',
		data: [
		".$graph_data."
		],
		xkey: 'y',
		ykeys: ['a'],
		labels: ['Total']
	});
	
	</script>
	";
	}
}

?>