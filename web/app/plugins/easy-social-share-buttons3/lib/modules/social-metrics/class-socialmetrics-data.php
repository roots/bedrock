<?php

class ESSBSocialMetricsDataHolder {
	
	public $networks = array ();
	public $network_totals = array();
	public $past_network_totals = array();
	public $data = array ();
	public $top_content = array();
	public $trending_content = array();
	
	public function __construct() {
	
	}
	
	public function get_posts() {
		global $wpdb;
		
		$post_types = $this->get_post_types ();
		add_filter ( 'posts_where', array ($this, 'date_range_filter' ) );
		
		$querydata = new WP_Query ( array ('posts_per_page' => - 1, 'post_status' => 'publish', 'post_type' => $post_types ) );
		
		remove_filter ( 'posts_where', array ($this, 'date_range_filter' ) );
		
		$data = array ();
		
		// foreach ($querydata as $querydatum ) {
		if ($querydata->have_posts ()) {
			while ( $querydata->have_posts () ) {
				$querydata->the_post ();
				global $post;
				
				$item ['ID'] = $post->ID;
				$item ['post_title'] = $post->post_title;
				$item ['post_date'] = $post->post_date;
				$item ['metrics_data'] = get_post_meta ( $post->ID, "essb_metrics_data", true );
				$item ['permalink'] = get_permalink ( $post->ID );
			
				if (is_array($item['metrics_data'])) {
					$data[] = $item;
				}
			}
		
		}
		
		$this->data = $data;
		
		$this->prepare_networks();
	}
	
	public function prepare_networks() {		
		
		foreach ($this->data as $post_data) {
			if (count($post_data['metrics_data']) == 0) {
				continue;
			}
			
			$network_counts = array();
			
			$last_id = count($post_data['metrics_data']) - 1;
			if (is_array($post_data['metrics_data'][$last_id])) {
				foreach ($post_data['metrics_data'][$last_id] as $service => $value) {
					if ($service == 'total' || $service == 'date') { continue; }
					
					if (!in_array($service, $this->networks)) {
						$this->networks[] = $service;
						$this->network_totals[$service] = 0;
						$this->past_network_totals[$service] = 0;
						
						$this->top_content[$service] = array('value' => 0, 'title' => '', 'permalink' => '');
						$network_counts[$service] = array('current' => 0, 'past' => 0);
					}
					
					$this->network_totals[$service] += intval($value);
					$network_counts[$service]['current'] = intval($value);
					
					if (isset($this->top_content[$service])) {
						if ($value > $this->top_content[$service]['value']) {
							$this->top_content[$service]['title'] = $post_data['post_title'];
							$this->top_content[$service]['permalink'] = $post_data['permalink'];
							$this->top_content[$service]['value'] = $value;
						}
					}
				}
			}
			
			if (is_array($post_data['metrics_data'][0])) {
				foreach ($post_data['metrics_data'][0] as $service => $value) {
					if ($service == 'total' || $service == 'date') {
						continue;
					}
				
					if (!in_array($service, $this->networks)) {
						$this->networks[] = $service;
						$this->network_totals[$service] = 0;
						$this->past_network_totals[$service] = 0;
						$network_counts[$service] = array('current' => 0, 'past' => 0);
					}
				
					$this->past_network_totals[$service] += intval($value);
					$network_counts[$service]['past'] = intval($value);
				}
				
				foreach ($network_counts as $service => $data) {				
					$diff = intval(isset($data['current']) ? $data['current'] : 0) - intval(isset($data['past']) ? $data['past'] : 0);
					
					if (!isset($this->trending_content[$service])) {
						$this->trending_content[$service] = array('value' => 0, 'title' => '', 'permalink' => '');
					}
					
					if ($diff > $this->trending_content[$service]['value']) {
						$this->trending_content[$service]['title'] = $post_data['post_title'];
						$this->trending_content[$service]['permalink'] = $post_data['permalink'];
						$this->trending_content[$service]['value'] = $diff;
					}
				}
			}
		}
		
		$total = 0;
		foreach ($this->network_totals as $network => $value) {
			$total += intval($value);
		}
		
		$this->network_totals['total'] = $total;
		
		$total = 0;
		foreach ($this->past_network_totals as $network => $value) {
			$total += intval($value);
		}
		
		$this->past_network_totals['total'] = $total;
		
		arsort($this->network_totals);
		
		// creating trending posts
					$this->trending_content[$service] = array('value' => 0, 'title' => '', 'permalink' => '');
	}
	
	function date_range_filter($where = '') {
		
		$range = (isset ( $_GET ['range'] )) ? $_GET ['range'] : '0';
		
		if ($range <= 0)
			return $where;
		
		$range_bottom = " AND post_date >= '" . date ( "Y-m-d", strtotime ( '-' . $range . ' month' ) );
		$range_top = "' AND post_date <= '" . date ( "Y-m-d" ) . "'";
		
		$where .= $range_bottom . $range_top;
		return $where;
	}
	
	public function get_post_types() {
		$types_to_track = array ();
		
		$pts = get_post_types ( array ('public' => true, 'show_ui' => true, '_builtin' => true ) );
		$cpts = get_post_types ( array ('public' => true, 'show_ui' => true, '_builtin' => false ) );
		
		// classical post type listing
		foreach ( $pts as $pt ) {
			
			$types_to_track [] = $pt;
		
		}
		
		// custom post types listing
		if (is_array ( $cpts ) && ! empty ( $cpts )) {
			foreach ( $cpts as $cpt ) {
				
				$types_to_track [] = $cpt;
			}
		}
		
		return $types_to_track;
	
	}
	
	public function network_name($key) {
		$all_networks = essb_available_social_networks();
		$name = '';
		
		foreach ($all_networks as $network => $data ) {
			$network_name = isset($data['name']) ? $data['name'] : $network;
			
			if ($network == $key) {
				$name = $network_name;
				break;
			}
		}
		
		return $name;
	}
	
	public function compare_value_change_class($past_value, $new_value) {
		$diff = intval($new_value) - intval($past_value);
		$result = '';
		
		if ($diff > 0) {
			$result = 'up-bg';
		}
		if ($diff < 0) {
			$result = 'down-bg';
		}
		
		return $result;
	}
	
	public function compare_value_change($past_value, $new_value, $plain_output = false) {
		$diff = intval($new_value) - intval($past_value);
		
		$result = '';
		
		if ($diff > 0) {
			$result = '<span class="diff up"><i class="fa fa-arrow-up"></i><span class="value">('.number_format($diff).')</span></span>';
		}
		if ($diff < 0) {
			$result = '<span class="diff down"><i class="fa fa-arrow-down"></i><span class="value">('.number_format($diff).')</span></span>';				
		}
		
		if ($diff == 0) {
			$result = '<span class="diff"><span class="value">(0)</span></span>';
		}
		
		if ($plain_output) {
			$result = number_format($diff);
		}
		
		return $result;
	}
	
	public function output_total_content() {
	
		echo '<table border="0" cellpadding="5" cellspacing="0" width="100%">';
		echo '<col width="20%"/>';
		echo '<col width="20%"/>';
		echo '<col width="60%"/>';
	
	
		foreach ($this->networks as $key) {
			if (!isset($this->top_content[$key])) {
				continue;
			}
			$single_value = $this->top_content[$key]['value'];
			$title = $this->top_content[$key]['title'];
			$permalink = $this->top_content[$key]['permalink'];
	
	
			echo '<tr>';
			echo '<td><i class="essb_status_icon essb_icon_'.$key.'"></i>'.$this->network_name($key).'</td>';
			echo '<td align="right"><strong>'.number_format($single_value).'</strong></td>';
			echo '<td><a href="'.$permalink.'" target="_blank">'.$title.'</a></td>';
			echo '</tr>';
		}
	
		echo '</table>';
	}
	
	public function output_trending_content() {
	
		echo '<table border="0" cellpadding="5" cellspacing="0" width="100%">';
		echo '<col width="20%"/>';
		echo '<col width="20%"/>';
		echo '<col width="60%"/>';
	
	
		foreach ($this->networks as $key) {
			if (!isset($this->trending_content[$key])) {
				continue;
			}
			$single_value = $this->trending_content[$key]['value'];
			$title = $this->trending_content[$key]['title'];
			$permalink = $this->trending_content[$key]['permalink'];
	
	
			echo '<tr>';
			echo '<td><i class="essb_status_icon essb_icon_'.$key.'"></i>'.$this->network_name($key).'</td>';
			echo '<td align="right"><strong>'.number_format($single_value).'</strong></td>';
			echo '<td><a href="'.$permalink.'" target="_blank">'.$title.'</a></td>';
			echo '</tr>';
		}
	
		echo '</table>';
	}
	
	public function output_total_result_modern() {
		$total = $this->network_totals['total'];
		$past_total = $this->past_network_totals['total'];

		$key = 'total';
		?>
		
				<div
						class="essb-stats-panel essb-stat-network shadow panel20 widget-color-<?php echo $key; ?>">
						<div class="essb-stats-panel-inner">
							<div class="essb-stats-panel-text">
								<i class="essb_icon_share"></i> <span
									class="details"><?php echo 'Total'; echo ' '; echo $this->compare_value_change($past_total, $total); ?><br /> <span
									class="percent" style="visibility: hidden;">100%</span></span>
							</div>
							<div class="essb-stats-panel-value"><?php echo number_format($total); ?>
						</div>
						</div>
						<div class="essb-stats-panel-graph">

							<div class="graph widget-color-white" style="visibility: hidden; width: <?php echo 100;?>%;"></div>

						</div>
					</div>
		
		
		<?php 
		
		foreach ($this->network_totals as $key => $value) {
				
			if ($key == 'total') {
				continue;
			}
				
			$past_value = isset($this->past_network_totals[$key]) ? $this->past_network_totals[$key] : 0;
				
			$single_value = $value;
		
			if ($total != 0) {
				$display_percent = number_format($single_value * 100 / $total, 2);
				$percent = number_format($single_value * 100 / $total);
			}
			else {
				$display_percent = "0.00";
				$percent = "0";
			}
		
			if (intval($percent) == 0 && intval($single_value) != 0) {
				$percent = 1;
			}
			
		?>
		<div
						class="essb-stats-panel essb-stat-network shadow panel20 widget-color-<?php echo $key; ?>">
						<div class="essb-stats-panel-inner">
							<div class="essb-stats-panel-text">
								<i class="essb_icon_<?php echo $key; ?>"></i> <span
									class="details"><?php echo $this->network_name($key); echo ' '; echo $this->compare_value_change($past_value, $value); ?><br /> <span
									class="percent"><?php echo $percent;?> %</span></span>
							</div>
							<div class="essb-stats-panel-value"><?php echo number_format($value); ?>
						</div>
						</div>
						<div class="essb-stats-panel-graph">

							<div class="graph widget-color-white" style="width: <?php echo $percent;?>%;"></div>

						</div>
					</div>
		<?php 
		}
	}
	
	public function output_total_results() {			
		
		$total = $this->network_totals['total'];
		$past_total = $this->past_network_totals['total'];
		
		echo '<table border="0" cellpadding="3" cellspacing="0" width="100%">';
		echo '<col width="30%"/>';
		echo '<col width="30%"/>';
		echo '<col width="40%"/>';
			
		echo '<tr>';
		echo '<td><strong>TOTAL:</strong></td>';
		echo '<td align="right"><strong>'.number_format($total). $this->compare_value_change($past_total, $total) . '</strong></td>';
		echo '<td>&nbsp;</td>';
		echo '</tr>';
			
	
		foreach ($this->network_totals as $key => $value) {
			
			if ($key == 'total') { continue; }
			
			$past_value = isset($this->past_network_totals[$key]) ? $this->past_network_totals[$key] : 0;
			
			$single_value = $value;
	
			if ($total != 0) {
				$display_percent = number_format($single_value * 100 / $total, 2);
				$percent = number_format($single_value * 100 / $total);
			}
			else {
				$display_percent = "0.00";
				$percent = "0";
			}
	
			if (intval($percent) == 0 && intval($single_value) != 0) {
				$percent = 1;
			}
	
			echo '<tr>';
			echo '<td><i class="essb_icon_'.$key.'"></i>'.$this->network_name($key).' <span style="background-color: #2980b9; padding: 2px 5px; color: #fff; font-size: 10px; border-radius: 3px;">'.$display_percent.' %</span></td>';
			echo '<td align="right"><strong>'.number_format($single_value). $this->compare_value_change($past_value, $value) .'</strong></td>';
			echo '<td><div style="background-color: #2980b9; display: block; height: 24px; width:'.$percent.'%;">&nbsp;</div></td>';
			echo '</tr>';
		}
			
		echo '</table>';
	}
	
	public function create_array_total($data) {
		$total = 0;
		
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				if ($key == 'total' || $key == 'date') { continue; }
				
				$total += intval($value);
			}
		}
		
		return $total;
	}
	
	public function output_main_result() {
		echo '<table id="esml-result" class="display hover row-border stripe" cellspacing="0" width="100%">';
		echo '<thead>';
		echo '<tr>';
		echo '<th rowspan="2">Post</th>';
		echo '<th colspan="2">Total</th>';

		foreach ($this->networks as $key) {
			echo '<th colspan="2">'.$this->network_name($key).'</th>';
		}
		
		echo '</tr>';
		
		echo '<tr>';
		
		echo '<th><i class="fa fa-share-alt"></i></th>';
		echo '<th><i class="fa fa-line-chart"></i></th>';
		
		foreach ($this->networks as $key) {
			echo '<th><i class="fa fa-share-alt"></i></th>';
			echo '<th><i class="fa fa-line-chart"></i></th>';
		}
		echo '</tr>';
		
		
		
		echo '</thead>';
	
		echo '<tbody>';
	
		foreach ($this->data as $item) {
			if (count($item['metrics_data']) == 0) {
				continue;
			}
			
			$last_id = count($item['metrics_data']) - 1;
			$data = $item['metrics_data'][$last_id];
			
			$past_data = $item['metrics_data'][0];
			
			$total = $this->create_array_total($data);
			$past_total = $this->create_array_total($past_data);
			
			if (intval($total) == 0) {
				continue;
			}
			
			echo '<tr>';
			echo '<td><a href="'.$item['permalink'].'" target="_blank">'.$item['post_title'].'</a><br/><span class="esml-navigation-item">(id:'.$item['ID'].', last update: '.$data['date'].') '.sprintf('<a href="post.php?post=%s&action=edit">Open edit post to see historical data</a>',$item['ID'],'edit',$item['ID']) .'</span></td>';
			echo '<td align="right">'.number_format($total).'</td>';
			echo '<td align="right">'.$this->compare_value_change($past_total, $total, true).'</td>';
				
			foreach ($this->networks as $key) {
				$current_value = isset($data[$key]) ? $data[$key] : 0;
				$past_value = isset($past_data[$key]) ? $past_data[$key] : 0;

				echo '<td align="right">'.number_format($current_value).'</td>';
				echo '<td align="right" class="'.$this->compare_value_change_class($past_value, $current_value).'">'.$this->compare_value_change($past_value, $current_value, true).'</td>';
				
			}
			
			echo '</tr>';
		}
		
		/*foreach ($this->data_report as $item) {
				
			$total_value = number_format(intval($item['esml_socialcount_total']));
				
			$item_actions = sprintf('<a href="post.php?post=%s&action=edit">Edit Post</a>',$item['ID'],'edit',$item['ID']) .
			'&nbsp;<a href="'.esc_url(add_query_arg( 'esml_sync_now', $item['ID'])).'">Update Stats</a>&nbsp;' .
			sprintf('Updated %s',EasySocialMetricsLite::timeago($item['esml_socialcount_LAST_UPDATED']));
				
			echo '<tr>';
				
			echo '<td>';
			printf('%1$s <br/><span class="esml-navigation-item">(id:%2$s) %3$s</span>',
					 $item['post_title'],
					 $item['ID'],
					 $item_actions);
			echo '</td>';
			echo '<td align="right">'.$total_value.'</td>';
				
			foreach ($this->services as $key => $text) {
				if ($key == "diggs") {
					continue;
				}
				echo '<td align="right">'.number_format(intval($item['esml_socialcount_'.$key])).'</td>';
			}
				
			echo '</tr>';
		}*/
	
		echo '</tbody>';
	
		echo '</table>';
	}
}