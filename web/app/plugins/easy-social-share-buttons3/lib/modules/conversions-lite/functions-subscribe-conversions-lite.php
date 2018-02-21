<?php

if (!function_exists('essb_conversion_network_name')) {
function essb_conversion_network_name($key = '') {
	$all_networks = essb_available_social_networks();
	$r = '';
	
	foreach ($all_networks as $network => $data) {
		if ($network == $key) {
			$r = isset($data['name']) ? $data['name'] : '';
		}
	}
	
	if ($r == '') {
		$r = $key;
	}
	
	return $r;
}
}

if (!function_exists('essb_subscribe_conversion_position_name')) {
function essb_subscribe_conversion_position_name($position) {
	
	$r = '';
	
	if ($position == 'shortcode') {
		$r = __('Shortcode', 'essb');
	}
	
	if ($position == 'widget') {
		$r = __('Widget', 'essb');
	}
	
	if ($position == 'belowcontent') {
		$r = __('Subscribe Form Below Content', 'essb');
	}
	
	
	if (strpos($position, 'flyout') !== false) {
		$position_data = explode('-', $position);
		
		$r = __('Subscribers Flyout', 'essb');
		if ($position_data[1] == 'time') {
			$r .= ': Timed delay';
		}
		if ($position_data[1] == 'scroll') {
			$r .= ': On scroll';
		}
		if ($position_data[1] == 'exit') {
			$r .= ': Exit intent';
		}
	}

	if (strpos($position, 'booster') !== false) {
		$position_data = explode('-', $position);
	
		$r = __('Subscribers Booster', 'essb');
		if ($position_data[1] == 'time') {
			$r .= ': Timed delay';
		}
		if ($position_data[1] == 'scroll') {
			$r .= ': On scroll';
		}
		if ($position_data[1] == 'exit') {
			$r .= ': Exit intent';
		}
	}
	
	
	if ($r == '') {
		$r = $position;
	}
	
	return $r;
}
}

if (!function_exists('essb_data_sorter')) {
function essb_data_sorter($a, $b) {
	$c1 = isset($a['clicks']) ? $a['clicks'] : 0;
	$c2 = isset($b['clicks']) ? $b['clicks'] : 0;
	
	$v1 = isset($a['views']) ? $a['views'] : 0;
	$v2 = isset($b['views']) ? $b['views'] : 0;
	
	if ($v1 != 0) {
		$x = $c1 * 100 / $v1;
	}
	else {
		$x = 0;
	}
	
	if ($v2 != 0) {
		$y = $c2 * 100 / $v2;
	}
	else {
		$y = 0;
	}
	
	if ($x == $y) {
		return 0;
	}
	return ($x < $y) ? 1 : -1;
}
}

function essb_subscribe_conversions_dashboard_report() {
	$reset_conversion = isset($_REQUEST['reset_subscribe_conversion']) ? $_REQUEST['reset_subscribe_conversion'] : '';
	
	$conversions_data = get_option('essb-subscribe-conversions-lite');
	
	if ($reset_conversion == 'true') {
		$conversions_data = array();
		update_option('essb-subscribe-conversions-lite', $conversions_data);
		
		echo '<script type="text/javascript">';
		echo 'location.href = "admin.php?page=essb_redirect_conversions&section=subscribe&subsection";';
		echo '</script>';
	}
	
	if (!is_array($conversions_data)) {
		$conversions_data = array();
	}
	
	
	$total_views = 0;
	$total_clicks = 0;
	
	if (isset($conversions_data['totals'])) {
		if (isset($conversions_data['totals']['positions'])) {
			foreach ($conversions_data['totals']['positions'] as $key => $data) {
				$total_views += isset($data['views']) ? intval($data['views']) : 0;
				$total_clicks += isset($data['clicks']) ? intval($data['clicks']) : 0;
			}
		}
	}
	
	
	if (intval($total_views) > 0) {
		$total_percent = $total_clicks * 100 / $total_views;
	}
	else {
		$total_percent = 0;
	}
	
	if (is_nan($total_percent)) {
		$total_percent = 0;
	}
	
	?>
	<style type="text/css">
		.overall-total { padding: 30px 25px; position: relative; }
		.overall-total .total-value { width: 25%; margin: 0 padding: 10px; display: inline-block; text-align: center; vertical-align: top; position: relative; }
		.overall-total .total-value .percent { font-size: 64px; font-weight: 700; line-height: 64px; }
		.overall-total .total-value .text { font-size: 13px; font-weight: 600; text-transform: uppercase; }
		.overall-total .icon-heading { color: #2C82C9; position: absolute; bottom: -30px; left: 0px; font-size: 120px; opacity: 0.1; }
		.overall-total .total-value.left { text-align: left; }
		.overall-total .total-value .title { font-size: 18px; font-weight: 600; margin-bottom: 15px; }
		.conversion-wrap { padding: 40px; }
		.conversion-title { margin: 0; margin-top: 40px; }
		.conversion-title i { font-size: 21px; line-height: 32px; }
		.conversion-title span { font-size: 21px; line-height: 32px; margin-left: 10px; }
		.conversion-row { padding: 10px; background: rgba(0,0,0,0.01); margin-bottom: 3px;  }
		.conversion-row.first { box-shadow: 0 1px 10px 0 rgba(0,0,0,0.1); background: #fff; }
		.conversion-row > div { display: inline-block; }
		.conversion-row .conversion-heading { width: 40%; font-weight: 400; }
		.conversion-row .conversion-heading span { font-size: 18px; width: 24px; height: 18px; float: left; display: block; }
		.conversion-row .conversion-value { width: 20%; text-align: center; font-weight: 600; }
		.conversion-row.headings { background: #fff; font-weight: 700; text-align: center; }
		.conversion-wrap .essb-section-tabs-single { border-right: 0px !important; }
		.conversion-wrap .essb-section-tabs-navigation ul { border-right: 0px !important; }
		
		.overall-total .desc.summary { margin-top: 30px; font-size: 14px; }
		
		.conversion-wrap .essb-section-tabs-single { font-weight: bold !important; font-size: 14px; }
		.conversion-wrap .essb-section-tabs-single.active, .conversion-wrap .essb-section-tabs-single:hover {
			background-color: #fafafa !important;
			border-radius: 4px;
			box-shadow: 0 1px 10px 0 rgba(0,0,0,0.15);
		}
		
		.conversion-wrap .essb-section-tabs-container .conversion-title { margin-top: 0px !important; }
		.reset-row { padding-bottom: 20px; text-align: right; }
	</style>
	<?php 
	
	$best_position = array('key' => '', 'value' => 0);
	$best_network = array('key' => '', 'value' => 0);
	
	if (isset($conversions_data['totals']) && isset($conversions_data['totals']['positions'])) {
		
		foreach ($conversions_data['totals']['positions'] as $key => $data) {
			if ($key == '') continue;
				
			$single_views = isset($data['views']) ? intval($data['views']) : 0;
			$single_clicks = isset($data['clicks']) ? intval($data['clicks']) : 0;
				
			$single_percent = $single_clicks * 100 / $single_views;
			
			if ($best_position['key'] == '') {
				$best_position['key'] = $key;
				$best_position['value'] = $single_percent;
			}
			else {
				if ($best_position['value'] < $single_percent) {
					$best_position['key'] = $key;
					$best_position['value'] = $single_percent;
				}
			}
				
			
		}
	
	
	}

	if (isset($conversions_data['totals']) && isset($conversions_data['totals']['networks'])) {
	
		foreach ($conversions_data['totals']['networks'] as $key => $data) {
			if ($key == '') continue;
	
			$single_views = isset($data['views']) ? intval($data['views']) : 0;
			$single_clicks = isset($data['clicks']) ? intval($data['clicks']) : 0;
	
			$single_percent = $single_clicks * 100 / $single_views;
				
			if ($best_network['key'] == '') {
				$best_network['key'] = $key;
				$best_network['value'] = $single_percent;
			}
			else {
				if ($best_network['value'] < $single_percent) {
					$best_network['key'] = $key;
					$best_network['value'] = $single_percent;
				}
			}
	
				
		}
	
	
	}
	
	echo '<div class="reset-row">';
	echo '<script type="text/javascript">';
	echo 'function essb_reset_confirmation() {
	var redirect_url = "admin.php?page=essb_redirect_conversions&section=subscribe&subsection&reset_subscribe_conversion=true";
	if (confirm("Are you sure you wish to reset conversion data?\r\nThis action cannot be undone - all current stored data will be permanently erased.")) location.href = redirect_url;
	}
	';
	echo '</script>';
	
	echo '<a href="#" class="essb-btn essb-btn-red" onclick="essb_reset_confirmation(); return false;">'.__('Reset Stored Conversion Data', 'essb').'</a>';
	
	echo '</div>';
	
	echo '<div class="essb-options-hint-glow overall-total">';
	
	echo '<div class="total-value left">';
	echo '<div class="title">Welcome to Subscribe Conversions Lite</div>';
	echo '<div class="desc">The smart way to optimize your subscribe forms on site without being a social media expert.</div>';
	
	
	echo '<div class="icon-heading">';
	echo '<i class="ti-stats-up"></i>';
	echo '</div>';
	echo '</div>';
	
	echo '<div class="total-value">';
	echo '<div class="percent">';
	echo $total_views;
	echo '</div>';
	echo '<div class="text">Views</div>';
	echo '</div>';

	echo '<div class="total-value">';
	echo '<div class="percent">';
	echo $total_clicks;
	echo '</div>';
	echo '<div class="text">Conversions</div>';
	echo '</div>';
	
	
	echo '<div class="total-value">';
	echo '<div class="percent">';
	echo number_format($total_percent, 1).'%';
	echo '</div>';
	echo '<div class="text">Conversion Rate</div>';
	echo '</div>';
	
	if ($best_position['key'] != '') {
		echo '<div class="desc summary">Did you know that your best social sharing button display position is <b>'. essb_subscribe_conversion_position_name($best_position['key']).'</b> with <b>'.number_format($best_position['value'], 1).'%</b> conversion rate.';
		echo '</div>';
	}
	
	
	echo '</div>';
	
	echo '<div class="clear"></div>';
	
	echo '<div class="conversion-wrap">';
	
	echo '<h2 style="border-bottom: 1px solid #ccc; padding-bottom: 10px;">Overall Performance</h2>';
	
	echo '<div class="conversion-title">';
	echo '<i class="ti-layout"></i><span>Positions</span>';
	echo '</div>';
	
	echo '<div class="conversion-row headings">';
	echo '<div class="conversion-heading"></div>';
	echo '<div class="conversion-value">Views</div>';
	echo '<div class="conversion-value">Conversions</div>';
	echo '<div class="conversion-value">Conversion Rate</div>';
	echo '</div>';
	
	if (isset($conversions_data['totals']) && isset($conversions_data['totals']['positions'])) {
		
		uasort($conversions_data['totals']['positions'], 'essb_data_sorter');
		
		$is_first = true;
		
		foreach ($conversions_data['totals']['positions'] as $key => $data) {
			if ($key == '') continue;
			
			$single_views = isset($data['views']) ? intval($data['views']) : 0;
			$single_clicks = isset($data['clicks']) ? intval($data['clicks']) : 0;
			
			$single_percent = $single_clicks * 100 / $single_views;
			
			echo '<div class="conversion-row '.($is_first ? 'first': '').'">';
			echo '<div class="conversion-heading">'.essb_subscribe_conversion_position_name($key).'</div>';
			echo '<div class="conversion-value">'.$single_views.'</div>';
			echo '<div class="conversion-value">'.$single_clicks.'</div>';
			echo '<div class="conversion-value">'.number_format($single_percent, 1).'%</div>';
			echo '</div>';
			
			$is_first = false;
		}
		
		
	}
		
	
	echo '<div class="conversion-wrap">';
	echo '<h2 style="border-bottom: 1px solid #ccc; padding-bottom: 10px;">Historical Performance For The Past 7 Days</h2>';
	
	if (isset($conversions_data['dates'])) {
		$dates = array();		
		
		foreach ($conversions_data['dates'] as $key => $data) {
			$dates[] = $key;
		}
		
		$dates = array_reverse($dates);		
		
		ESSBOptionsFramework::draw_tabs_start($dates, array('element_id' => 'dates', 'active_tab' => 'dates-0', 'vertical' => 'true'));
		
		$count = 0;
		foreach ($dates as $key_date) {
			$data_date = isset($conversions_data['dates'][$key_date]) ? $conversions_data['dates'][$key_date] : array();
			 
			ESSBOptionsFramework::draw_tab_start(array('element_id' => 'dates-'.$count, 'active' => ($count == 0 ? 'true' : 'false')));
			
			
			echo '<div class="conversion-title">';
			echo '<i class="ti-layout"></i><span>Positions</span>';
			echo '</div>';
			
			echo '<div class="conversion-row headings">';
			echo '<div class="conversion-heading"></div>';
			echo '<div class="conversion-value">Views</div>';
			echo '<div class="conversion-value">Conversions</div>';
			echo '<div class="conversion-value">Conversion Rate</div>';
			echo '</div>';
			
			if (isset($data_date['positions'])) {
			
				uasort($data_date['positions'], 'essb_data_sorter');
				
				$is_first = true;
			
				foreach ($data_date['positions'] as $key => $data) {
					if ($key == '') continue;
						
					$single_views = isset($data['views']) ? intval($data['views']) : 0;
					$single_clicks = isset($data['clicks']) ? intval($data['clicks']) : 0;
						
					$single_percent = $single_clicks * 100 / $single_views;
						
					echo '<div class="conversion-row '.($is_first ? 'first': '').'">';
					echo '<div class="conversion-heading">'.essb_subscribe_conversion_position_name($key).'</div>';
					echo '<div class="conversion-value">'.$single_views.'</div>';
					echo '<div class="conversion-value">'.$single_clicks.'</div>';
					echo '<div class="conversion-value">'.number_format($single_percent, 1).'%</div>';
					echo '</div>';
					
					$is_first = false;
						
				}
			
			
			}
			
			
			
			
			ESSBOptionsFramework::draw_tab_end();
			$count++;
		}
		
		
		ESSBOptionsFramework::draw_tabs_end();
		
		echo '</div>';
	}
	
	echo '</div>';	
	
}