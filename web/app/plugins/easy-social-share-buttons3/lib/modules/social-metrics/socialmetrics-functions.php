<?php
function essb_sm_store_data($post_id, $counter_data = array()) {
	$data_update = essb_option_value('esml_history');
	if ($data_update == '') {
		$data_update = '1';
	}
	
	$data_update = intval($data_update);
	
	$previous_data = get_post_meta($post_id, 'essb_metrics_data', true);
	if (!is_array($previous_data)) {
		$previous_data = array();
	}
	
	// logging date inside snippet
	$log_date = date('Y-m-d');
	
	$has_record = essb_sm_has_record($previous_data, $log_date);
	
	if ($has_record == -1) {
		$counter_data['date'] = $log_date;
		$previous_data[] = $counter_data;		
	}
	else {
		$previous_data[$has_record] = essb_sm_merge_data($previous_data[$has_record], $counter_data);
	}
	
	if (count($previous_data) > $data_update) {
		$previous_data = array_shift($previous_data);
	}
	
	update_post_meta($post_id, 'essb_metrics_data', $previous_data);
}

function essb_sm_merge_data($previous_data, $current_data) {
	foreach ($current_data as $key => $value) {
		$previous_data[$key] = $value;
	}
	
	return $previous_data;
}

function essb_sm_has_record($data, $date) {
	$position = -1;
	$count = 0;
	foreach ($data as $date_record) {
		$current_date = isset($date_record['date']) ? $date_record['date'] : '';
		
		if ($current_date == $date) {
			$position = $count;
		}
		
		$count++;
	}
	
	return $position;
}