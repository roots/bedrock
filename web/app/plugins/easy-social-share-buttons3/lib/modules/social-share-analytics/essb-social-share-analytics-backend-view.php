<?php
global $essb_networks;
$mode = isset ( $_GET ["mode"] ) ? $_GET ["mode"] : "1";
$month = isset ( $_GET ['essb_month'] ) ? $_GET ['essb_month'] : '';
$date = isset ( $_GET ['date'] ) ? $_GET ['date'] : '';
$position = isset($_GET['position']) ? $_GET['position'] : '';

if (! essb_options_bool_value ( 'stats_active' )) {
	print "<h2>Social Share Analytics is not active. To activate it please go to Social Buttons -> Social Sharing -> Share Analytics and activte it";
	return;
}

ESSBSocialShareAnalyticsBackEnd::init_addional_settings ();

// overall stats by social network
if ($date != '' || $position != '') {
	$overall_stats = ESSBSocialShareAnalyticsBackEnd::essb_stats_by_networks ( '', '', $date, $position );
	$position_stats = ESSBSocialShareAnalyticsBackEnd::essb_stats_by_position ( '', '', $date, $position );
} else {
	$overall_stats = ESSBSocialShareAnalyticsBackEnd::essb_stats_by_networks ( $month );
	$position_stats = ESSBSocialShareAnalyticsBackEnd::essb_stats_by_position ( $month );

}

// print_r($overall_stats);

$calculated_total = 0;
$networks_with_data = array ();

if (isset ( $overall_stats )) {
	$cnt = 0;
	foreach ( $essb_networks as $k => $v ) {
		
		$calculated_total += intval ( $overall_stats->{$k} );
		if (intval ( $overall_stats->{$k} ) != 0) {
			$networks_with_data [$k] = $calculated_total;
		}
	}
}

$device_stats = ESSBSocialShareAnalyticsBackEnd::essb_stats_by_device ( $month, '', $date, $position );

$today = date ( 'Y-m-d' );
$today_month = date ( 'Y-m' );

$essb_date_to = "";
$essb_date_from = "";

if ($essb_date_to == '') {
	$essb_date_to = date ( "Y-m-d" );
}

if ($essb_date_from == '') {
	$essb_date_from = date ( "Y-m-d", strtotime ( date ( "Y-m-d", strtotime ( date ( "Y-m-d" ) ) ) . "-1 month" ) );
}

if ($mode == "1") {
	$sqlObject = ESSBSocialShareAnalyticsBackEnd::getDateRangeRecords ( $essb_date_from, $essb_date_to );
	// print_r($sqlObject);
	$dataPeriodObject = ESSBSocialShareAnalyticsBackEnd::sqlDateRangeRecordConvert ( $essb_date_from, $essb_date_to, $sqlObject );
	
	$sqlMonthsData = ESSBSocialShareAnalyticsBackEnd::essb_stats_by_networks_by_months ();
}

?>

<div class="essb-dashboard">
<?php if ($mode == '1') { ?>
	<!--  dashboard overall  -->
	<div class="essb-dashboard-panel">
		<div class="essb-dashboard-panel-title">
			<h4><?php echo __('Total clicks on share buttons', 'essb'); ?></h4>
		</div>
		<div class="essb-dashboard-panel-content">

			<div class="row">
				<div class="oneforth">
					<div class="essb-stats-panel shadow panel100 total">
						<div class="essb-stats-panel-inner">
							<div class="essb-stats-panel-text">
								<div class="essb-stats-panel-text1">
									<strong>
								<?php echo __('Total clicks on share buttons', 'essb'); ?></strong>
								</div>
								<div class="essb-stats-panel-devices">
								<?php
	
	if (isset ( $device_stats )) {
		$desktop = $device_stats->desktop;
		$mobile = $device_stats->mobile;
		
		if ($calculated_total != 0) {
			$percentd = $desktop * 100 / $calculated_total;
		} else {
			$percentd = 0;
		}
		$print_percentd = round ( $percentd, 2 );
		$percentd = round ( $percentd );
		
		if ($percentd > 90) {
			$percentd -= 2;
		}
		
		if ($calculated_total != 0) {
			$percentm = $mobile * 100 / $calculated_total;
		} else {
			$percentm = 0;
		}
		$print_percentm = round ( $percentm, 2 );
		$percentm = round ( $percentm );
		if ($percentm > 90) {
			$percentm -= 2;
		}
	}
	
	?>
				<div class="essb-stats-device-position total-values">
										<div class="inline left">
											<div class="essb-stats-device-icon">
												<i class="ti-desktop"></i>
											</div>
											<div class="essb-stats-device-info">
												<span class="text-title">
						<?php echo __('Desktop', 'essb'); ?></span> <span class="value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($desktop); ?></span>
												<span class="percent"><?php echo $print_percentd;?> %</span>
											</div>
										</div>
										<div class="inline right">
											<div class="essb-stats-device-icon"
												style="margin-left: 20px;">
												<i class="ti-mobile"></i>
											</div>
											<div class="essb-stats-device-info">
												<span class="text-title">
						<?php echo __('Mobile', 'essb'); ?></span> <span class="value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($mobile); ?></span>
												<span class="percent"><?php echo $print_percentm;?> %</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="essb-stats-panel-value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($calculated_total); ?>
						</div>
						</div>




					</div> <!--  end stat panel overall -->
					<!-- Most popular position and social network -->
					<?php 
					$best_position_value = 0;
					$best_position_key = "";
					
					$best_network_value = 0;
					$best_network_key = "";
					
					if (isset ( $overall_stats )) {
						foreach ( ESSBSocialShareAnalyticsBackEnd::$positions as $k ) {
								
							$key = "position_" . $k;
								
							$single = intval ( $position_stats->{$key} );
							
							if ($single > $best_position_value) {
								$best_position_value = $single;
								$best_position_key = $k;
							}
						}
						
						foreach ( $essb_networks as $k => $v ) {
								
							$single = intval ( $overall_stats->{$k} );
							
							if ($single > $best_network_value) {
								$best_network_value = $single;
								$best_network_key = $v["name"];
							}
						}
					}
					
					?>
					
					<div class="essb-most-popular">
						<div class="essb-most-popular-position">
							<div class="twocols">
								<?php echo __('Most popular social network:', 'essb');?>
							</div>
							<div class="twocols">
								<strong><?php echo $best_network_key; ?></strong> (<?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($best_network_value); ?>)
							</div>
						
						</div>
					<div class="essb-most-popular-position">
							<div class="twocols">
								<?php echo __('Most popular position:', 'essb');?>
							</div>
							<div class="twocols">
								<strong><?php echo strtoupper($best_position_key); ?></strong> (<?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($best_position_value); ?>)
							</div>
						
						</div>
					</div>
					
				</div>
				<!-- end left -->
				<!-- start right -->
				<div class="threeforth">
					<!-- begin stats by displayed position -->
<?php
	
	if (isset ( $overall_stats )) {
		$cnt = 0;
		foreach ( ESSBSocialShareAnalyticsBackEnd::$positions as $k ) {
			
			$key = "position_" . $k;
			
			$single = intval ( $position_stats->{$key} );
			
			if ($single > 0) {
				if ($calculated_total != 0) {
					$percent = $single * 100 / $calculated_total;
				} else {
					$percent = 0;
				}
				$print_percent = round ( $percent, 2 );
				$percent = round ( $percent );
				?>
			
			<div class="essb-stats-panel shadow panel20" onclick="essb_analytics_position_report('<?php echo $k; ?>'); return false;" style="cursor: pointer;" title="Click on position to see best performing network and content">
						<div class="essb-stats-panel-inner">
							<div class="essb-stats-panel-text"><?php echo $k; ?> <span
									class="percent"><?php echo $print_percent;?> %</span>
							</div>
							<div class="essb-stats-panel-value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($single); ?>
						</div>
						</div>
						<div class="essb-stats-panel-graph">

							<div class="graph widget-color-ok" style="width: <?php echo $percent;?>%;"></div>

						</div>
					</div>
									
									<?php
			}
		}
	}
	
	?>					
				</div>



				<div class="row">
					<div class="essb-title5">
						<div>Clicks by social networks</div>
					</div>


					
<?php
	
	if (isset ( $overall_stats )) {
		$cnt = 0;
		foreach ( $essb_networks as $k => $v ) {
			
			$single = intval ( $overall_stats->{$k} );
			
			if ($single > 0) {
				$percent = $single * 100 / $calculated_total;
				$print_percent = round ( $percent, 2 );
				$percent = round ( $percent );
				?>
			
			<div
						class="essb-stats-panel essb-stat-network shadow panel20 widget-color-<?php echo $k; ?>">
						<div class="essb-stats-panel-inner">
							<div class="essb-stats-panel-text">
								<i class="essb_icon_<?php echo $k; ?>"></i> <span
									class="details"><?php echo $v["name"]; ?><br /> <span
									class="percent"><?php echo $print_percent;?> %</span></span>
							</div>
							<div class="essb-stats-panel-value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($single); ?>
						</div>
						</div>
						<div class="essb-stats-panel-graph">

							<div class="graph widget-color-white" style="width: <?php echo $percent;?>%;"></div>

						</div>
					</div>
									
									<?php
			}
		}
	}
	
	?>
				</div>

			</div>



		</div>
	</div>
	<div class="clear"></div>

	<div class="essb-dashboard-panel">
		<div class="essb-dashboard-panel-title">
			<h4>Social clicks dynamics for the last 30 days</h4>
		</div>
		<div class="essb-dashboard-panel-content" id="essb-changes-graph"
			style="height: 300px;"></div>
	</div>

	<div class="clear"></div>

	<div class="essb-dashboard-panel">
		<div class="essb-dashboard-panel-title">
			<h4>Social clicks by months</h4>

		</div>
		<div class="essb-dashboard-panel-content">
			<?php ESSBSocialShareAnalyticsBackEnd::essb_stat_admin_detail_by_month ($sqlMonthsData, $networks_with_data); ?>
			</div>
	</div>

	<div class="clear"></div>

	<div class="essb-dashboard-panel">
		<div class="essb-dashboard-panel-title">
			<h4>Leading posts in social actions</h4>
			<button class="button-primary"
				style="float: right; margin-top: -22px;"
				onclick="window.location='admin.php?page=essb_redirect_analytics&tab=analytics&mode=3';">Full
				content report</button>
		</div>
		<div class="essb-dashboard-panel-content">
			<?php ESSBSocialShareAnalyticsBackEnd::essb_stat_admin_detail_by_post ('', $networks_with_data, 20); ?>
			</div>
	</div>
	
	<?php } ?>
	
	<?php if ($mode == '2') { ?>
	
	<?php if ($month != '') { ?>
	
		<!--  dashboard overall  -->
	<div class="essb-dashboard-panel">
		<div class="essb-dashboard-panel-title">
			<h4><?php echo __('Stat data for month: ', 'essb'); ?><?php echo $month;?></h4>
		</div>
		<div class="essb-dashboard-panel-content">

			<div class="row">
				<div class="oneforth">
					<div class="essb-stats-panel shadow panel100 total">
						<div class="essb-stats-panel-inner">
							<div class="essb-stats-panel-text">
								<div class="essb-stats-panel-text1">
									<strong>
								<?php echo __('Total clicks on share buttons', 'essb'); ?></strong>
								</div>
								<div class="essb-stats-panel-devices">
								<?php
	
	if (isset ( $device_stats )) {
		$desktop = $device_stats->desktop;
		$mobile = $device_stats->mobile;
		
		if ($calculated_total != 0) {
			$percentd = $desktop * 100 / $calculated_total;
		} else {
			$percentd = 0;
		}
		$print_percentd = round ( $percentd, 2 );
		$percentd = round ( $percentd );
		
		if ($percentd > 90) {
			$percentd -= 2;
		}
		
		if ($calculated_total != 0) {
			$percentm = $mobile * 100 / $calculated_total;
		} else {
			$percentm = 0;
		}
		$print_percentm = round ( $percentm, 2 );
		$percentm = round ( $percentm );
		if ($percentm > 90) {
			$percentm -= 2;
		}
	}
	
	?>
				<div class="essb-stats-device-position total-values">
										<div class="inline left">
											<div class="essb-stats-device-icon">
												<i class="ti-desktop"></i>
											</div>
											<div class="essb-stats-device-info">
												<span class="text-title">
						<?php echo __('Desktop', 'essb'); ?></span> <span class="value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($desktop); ?></span>
												<span class="percent"><?php echo $print_percentd;?> %</span>
											</div>
										</div>
										<div class="inline right">
											<div class="essb-stats-device-icon"
												style="margin-left: 20px;">
												<i class="ti-mobile"></i>
											</div>
											<div class="essb-stats-device-info">
												<span class="text-title">
						<?php echo __('Mobile', 'essb'); ?></span> <span class="value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($mobile); ?></span>
												<span class="percent"><?php echo $print_percentm;?> %</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="essb-stats-panel-value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($calculated_total); ?>
						</div>
						</div>




					</div> <!--  end stat panel overall -->
					<!-- Most popular position and social network -->
					<?php 
					$best_position_value = 0;
					$best_position_key = "";
					
					$best_network_value = 0;
					$best_network_key = "";
					
					if (isset ( $overall_stats )) {
						foreach ( ESSBSocialShareAnalyticsBackEnd::$positions as $k ) {
								
							$key = "position_" . $k;
								
							$single = intval ( $position_stats->{$key} );
							
							if ($single > $best_position_value) {
								$best_position_value = $single;
								$best_position_key = $k;
							}
						}
						
						foreach ( $essb_networks as $k => $v ) {
								
							$single = intval ( $overall_stats->{$k} );
							
							if ($single > $best_network_value) {
								$best_network_value = $single;
								$best_network_key = $v["name"];
							}
						}
					}
					
					?>
					
					<div class="essb-most-popular">
						<div class="essb-most-popular-position">
							<div class="twocols">
								<?php echo __('Most popular social network:', 'essb');?>
							</div>
							<div class="twocols">
								<strong><?php echo $best_network_key; ?></strong> (<?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($best_network_value); ?>)
							</div>
						
						</div>
					<div class="essb-most-popular-position">
							<div class="twocols">
								<?php echo __('Most popular position:', 'essb');?>
							</div>
							<div class="twocols">
								<strong><?php echo strtoupper($best_position_key); ?></strong> (<?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($best_position_value); ?>)
							</div>
						
						</div>
					</div>
					
				</div>
				<!-- end left -->
				<!-- start right -->
				<div class="threeforth">
					<!-- begin stats by displayed position -->
<?php
	
	if (isset ( $overall_stats )) {
		$cnt = 0;
		foreach ( ESSBSocialShareAnalyticsBackEnd::$positions as $k ) {
			
			$key = "position_" . $k;
			
			$single = intval ( $position_stats->{$key} );
			
			if ($single > 0) {
				if ($calculated_total != 0) {
					$percent = $single * 100 / $calculated_total;
				} else {
					$percent = 0;
				}
				$print_percent = round ( $percent, 2 );
				$percent = round ( $percent );
				?>
			
			<div class="essb-stats-panel shadow panel20">
						<div class="essb-stats-panel-inner">
							<div class="essb-stats-panel-text"><?php echo $k; ?> <span
									class="percent"><?php echo $print_percent;?> %</span>
							</div>
							<div class="essb-stats-panel-value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($single); ?>
						</div>
						</div>
						<div class="essb-stats-panel-graph">

							<div class="graph widget-color-ok" style="width: <?php echo $percent;?>%;"></div>

						</div>
					</div>
									
									<?php
			}
		}
	}
	
	?>					
				</div>



				<div class="row">
					<div class="essb-title5">
						<div>Clicks by social networks</div>
					</div>


					
<?php
	
	if (isset ( $overall_stats )) {
		$cnt = 0;
		foreach ( $essb_networks as $k => $v ) {
			
			$single = intval ( $overall_stats->{$k} );
			
			if ($single > 0) {
				$percent = $single * 100 / $calculated_total;
				$print_percent = round ( $percent, 2 );
				$percent = round ( $percent );
				?>
			
			<div
						class="essb-stats-panel essb-stat-network shadow panel20 widget-color-<?php echo $k; ?>">
						<div class="essb-stats-panel-inner">
							<div class="essb-stats-panel-text">
								<i class="essb_icon_<?php echo $k; ?>"></i> <span
									class="details"><?php echo $v["name"]; ?><br /> <span
									class="percent"><?php echo $print_percent;?> %</span></span>
							</div>
							<div class="essb-stats-panel-value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($single); ?>
						</div>
						</div>
						<div class="essb-stats-panel-graph">

							<div class="graph widget-color-white" style="width: <?php echo $percent;?>%;"></div>

						</div>
					</div>
									
									<?php
			}
		}
	}
	
	?>
				</div>

			</div>



		</div>
	</div>
	
	<div class="clear"></div>


	<div class="essb-dashboard-panel">
		<div class="essb-dashboard-panel-title">
			<h4>Activity by date of month</h4>
		</div>
		<div class="essb-dashboard-panel-content">
			<?php ESSBSocialShareAnalyticsBackEnd::generate_bar_graph_month($month, $networks_with_data);?>
			</div>
	</div>

	<div class="essb-dashboard-panel">
		<div class="essb-dashboard-panel-title">
			<h4>Content details for this month</h4>
		</div>
		<div class="essb-dashboard-panel-content">
			<?php ESSBSocialShareAnalyticsBackEnd::essb_stat_admin_detail_by_post( $month, $networks_with_data );?>
			</div>
	</div>
	
			
		
		<?php } ?>
	
	<?php } ?>
	
	<?php if ($mode == '3') { ?>
	<div class="essb-dashboard-panel">
		<div class="essb-dashboard-panel-title">
			<h4>Full social activity content report</h4>
		</div>
		<div class="essb-dashboard-panel-content">
			<?php ESSBSocialShareAnalyticsBackEnd::essb_stat_admin_detail_by_post( '', $networks_with_data );?>
			</div>
	</div>
	<?php } ?>
	
	<?php if ($mode == '4') { ?>
	
	<?php if ($date != '') { ?>
	
		<!--  dashboard overall  -->
	<div class="essb-dashboard-panel">
		<div class="essb-dashboard-panel-title">
			<h4><?php echo __('Stat data for date: ', 'essb'); ?><?php echo $date;?></h4>
		</div>
		<div class="essb-dashboard-panel-content">

			<div class="row">
				<div class="oneforth">
					<div class="essb-stats-panel shadow panel100 total">
						<div class="essb-stats-panel-inner">
							<div class="essb-stats-panel-text">
								<div class="essb-stats-panel-text1">
									<strong>
								<?php echo __('Total clicks on share buttons', 'essb'); ?></strong>
								</div>
								<div class="essb-stats-panel-devices">
								<?php
	
	if (isset ( $device_stats )) {
		$desktop = $device_stats->desktop;
		$mobile = $device_stats->mobile;
		
		if ($calculated_total != 0) {
			$percentd = $desktop * 100 / $calculated_total;
		} else {
			$percentd = 0;
		}
		$print_percentd = round ( $percentd, 2 );
		$percentd = round ( $percentd );
		
		if ($percentd > 90) {
			$percentd -= 2;
		}
		
		if ($calculated_total != 0) {
			$percentm = $mobile * 100 / $calculated_total;
		} else {
			$percentm = 0;
		}
		$print_percentm = round ( $percentm, 2 );
		$percentm = round ( $percentm );
		if ($percentm > 90) {
			$percentm -= 2;
		}
	}
	
	?>
				<div class="essb-stats-device-position total-values">
										<div class="inline left">
											<div class="essb-stats-device-icon">
												<i class="ti-desktop"></i>
											</div>
											<div class="essb-stats-device-info">
												<span class="text-title">
						<?php echo __('Desktop', 'essb'); ?></span> <span class="value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($desktop); ?></span>
												<span class="percent"><?php echo $print_percentd;?> %</span>
											</div>
										</div>
										<div class="inline right">
											<div class="essb-stats-device-icon"
												style="margin-left: 20px;">
												<i class="ti-mobile"></i>
											</div>
											<div class="essb-stats-device-info">
												<span class="text-title">
						<?php echo __('Mobile', 'essb'); ?></span> <span class="value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($mobile); ?></span>
												<span class="percent"><?php echo $print_percentm;?> %</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="essb-stats-panel-value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($calculated_total); ?>
						</div>
						</div>




					</div> <!--  end stat panel overall -->
					<!-- Most popular position and social network -->
					<?php 
					$best_position_value = 0;
					$best_position_key = "";
					
					$best_network_value = 0;
					$best_network_key = "";
					
					if (isset ( $overall_stats )) {
						foreach ( ESSBSocialShareAnalyticsBackEnd::$positions as $k ) {
								
							$key = "position_" . $k;
								
							$single = intval ( $position_stats->{$key} );
							
							if ($single > $best_position_value) {
								$best_position_value = $single;
								$best_position_key = $k;
							}
						}
						
						foreach ( $essb_networks as $k => $v ) {
								
							$single = intval ( $overall_stats->{$k} );
							
							if ($single > $best_network_value) {
								$best_network_value = $single;
								$best_network_key = $v["name"];
							}
						}
					}
					
					?>
					
					<div class="essb-most-popular">
						<div class="essb-most-popular-position">
							<div class="twocols">
								<?php echo __('Most popular social network:', 'essb');?>
							</div>
							<div class="twocols">
								<strong><?php echo $best_network_key; ?></strong> (<?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($best_network_value); ?>)
							</div>
						
						</div>
					<div class="essb-most-popular-position">
							<div class="twocols">
								<?php echo __('Most popular position:', 'essb');?>
							</div>
							<div class="twocols">
								<strong><?php echo strtoupper($best_position_key); ?></strong> (<?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($best_position_value); ?>)
							</div>
						
						</div>
					</div>
					
				</div>
				<!-- end left -->
				<!-- start right -->
				<div class="threeforth">
					<!-- begin stats by displayed position -->
<?php
	
	if (isset ( $overall_stats )) {
		$cnt = 0;
		foreach ( ESSBSocialShareAnalyticsBackEnd::$positions as $k ) {
			
			$key = "position_" . $k;
			
			$single = intval ( $position_stats->{$key} );
			
			if ($single > 0) {
				if ($calculated_total != 0) {
					$percent = $single * 100 / $calculated_total;
				} else {
					$percent = 0;
				}
				$print_percent = round ( $percent, 2 );
				$percent = round ( $percent );
				?>
			
			<div class="essb-stats-panel shadow panel20">
						<div class="essb-stats-panel-inner">
							<div class="essb-stats-panel-text"><?php echo $k; ?> <span
									class="percent"><?php echo $print_percent;?> %</span>
							</div>
							<div class="essb-stats-panel-value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($single); ?>
						</div>
						</div>
						<div class="essb-stats-panel-graph">

							<div class="graph widget-color-ok" style="width: <?php echo $percent;?>%;"></div>

						</div>
					</div>
									
									<?php
			}
		}
	}
	
	?>					
				</div>



				<div class="row">
					<div class="essb-title5">
						<div>Clicks by social networks</div>
					</div>


					
<?php
	
	if (isset ( $overall_stats )) {
		$cnt = 0;
		foreach ( $essb_networks as $k => $v ) {
			
			$single = intval ( $overall_stats->{$k} );
			
			if ($single > 0) {
				$percent = $single * 100 / $calculated_total;
				$print_percent = round ( $percent, 2 );
				$percent = round ( $percent );
				?>
			
			<div
						class="essb-stats-panel essb-stat-network shadow panel20 widget-color-<?php echo $k; ?>">
						<div class="essb-stats-panel-inner">
							<div class="essb-stats-panel-text">
								<i class="essb_icon_<?php echo $k; ?>"></i> <span
									class="details"><?php echo $v["name"]; ?><br /> <span
									class="percent"><?php echo $print_percent;?> %</span></span>
							</div>
							<div class="essb-stats-panel-value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($single); ?>
						</div>
						</div>
						<div class="essb-stats-panel-graph">

							<div class="graph widget-color-white" style="width: <?php echo $percent;?>%;"></div>

						</div>
					</div>
									
									<?php
			}
		}
	}
	
	?>
				</div>

			</div>



		</div>
	</div>
	
	<div class="clear"></div>




	<div class="essb-dashboard-panel">
		<div class="essb-dashboard-panel-title">
			<h4>Content details for this date</h4>
		</div>
		<div class="essb-dashboard-panel-content">
			<?php ESSBSocialShareAnalyticsBackEnd::essb_stat_admin_detail_by_post( '', $networks_with_data, '', $date );?>
			</div>
	</div>
	
			
		
		<?php } ?>
	
	<?php } ?>

	
	
	<?php if ($mode == '5') { ?>
	
	<?php if ($position != '') { ?>
	
		<!--  dashboard overall  -->
	<div class="essb-dashboard-panel">
		<div class="essb-dashboard-panel-title">
			<h4><?php echo __('Stat data for date: ', 'essb'); ?><?php echo $date;?></h4>
		</div>
		<div class="essb-dashboard-panel-content">

			<div class="row">
				<div class="oneforth">
					<div class="essb-stats-panel shadow panel100 total">
						<div class="essb-stats-panel-inner">
							<div class="essb-stats-panel-text">
								<div class="essb-stats-panel-text1">
									<strong>
								<?php echo __('Total clicks on share buttons', 'essb'); ?></strong>
								</div>
								<div class="essb-stats-panel-devices">
								<?php
	
	if (isset ( $device_stats )) {
		$desktop = $device_stats->desktop;
		$mobile = $device_stats->mobile;
		
		if ($calculated_total != 0) {
			$percentd = $desktop * 100 / $calculated_total;
		} else {
			$percentd = 0;
		}
		$print_percentd = round ( $percentd, 2 );
		$percentd = round ( $percentd );
		
		if ($percentd > 90) {
			$percentd -= 2;
		}
		
		if ($calculated_total != 0) {
			$percentm = $mobile * 100 / $calculated_total;
		} else {
			$percentm = 0;
		}
		$print_percentm = round ( $percentm, 2 );
		$percentm = round ( $percentm );
		if ($percentm > 90) {
			$percentm -= 2;
		}
	}
	
	?>
				<div class="essb-stats-device-position total-values">
										<div class="inline left">
											<div class="essb-stats-device-icon">
												<i class="ti-desktop"></i>
											</div>
											<div class="essb-stats-device-info">
												<span class="text-title">
						<?php echo __('Desktop', 'essb'); ?></span> <span class="value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($desktop); ?></span>
												<span class="percent"><?php echo $print_percentd;?> %</span>
											</div>
										</div>
										<div class="inline right">
											<div class="essb-stats-device-icon"
												style="margin-left: 20px;">
												<i class="ti-mobile"></i>
											</div>
											<div class="essb-stats-device-info">
												<span class="text-title">
						<?php echo __('Mobile', 'essb'); ?></span> <span class="value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($mobile); ?></span>
												<span class="percent"><?php echo $print_percentm;?> %</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="essb-stats-panel-value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($calculated_total); ?>
						</div>
						</div>




					</div> <!--  end stat panel overall -->
					<!-- Most popular position and social network -->
					<?php 
					$best_position_value = 0;
					$best_position_key = "";
					
					$best_network_value = 0;
					$best_network_key = "";
					
					if (isset ( $overall_stats )) {
						foreach ( ESSBSocialShareAnalyticsBackEnd::$positions as $k ) {
								
							$key = "position_" . $k;
								
							$single = intval ( $position_stats->{$key} );
							
							if ($single > $best_position_value) {
								$best_position_value = $single;
								$best_position_key = $k;
							}
						}
						
						foreach ( $essb_networks as $k => $v ) {
								
							$single = intval ( $overall_stats->{$k} );
							
							if ($single > $best_network_value) {
								$best_network_value = $single;
								$best_network_key = $v["name"];
							}
						}
					}
					
					?>
					
					<div class="essb-most-popular">
						<div class="essb-most-popular-position">
							<div class="twocols">
								<?php echo __('Most popular social network:', 'essb');?>
							</div>
							<div class="twocols">
								<strong><?php echo $best_network_key; ?></strong> (<?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($best_network_value); ?>)
							</div>
						
						</div>
					<div class="essb-most-popular-position">
							<div class="twocols">
								<?php echo __('Most popular position:', 'essb');?>
							</div>
							<div class="twocols">
								<strong><?php echo strtoupper($best_position_key); ?></strong> (<?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($best_position_value); ?>)
							</div>
						
						</div>
					</div>
					
				</div>
				<!-- end left -->
				<!-- start right -->
				<div class="threeforth">
					<!-- begin stats by displayed position -->
<?php
	
	if (isset ( $overall_stats )) {
		$cnt = 0;
		foreach ( ESSBSocialShareAnalyticsBackEnd::$positions as $k ) {
			
			$key = "position_" . $k;
			
			$single = intval ( $position_stats->{$key} );
			
			if ($single > 0) {
				if ($calculated_total != 0) {
					$percent = $single * 100 / $calculated_total;
				} else {
					$percent = 0;
				}
				$print_percent = round ( $percent, 2 );
				$percent = round ( $percent );
				?>
			
			<div class="essb-stats-panel shadow panel20">
						<div class="essb-stats-panel-inner">
							<div class="essb-stats-panel-text"><?php echo $k; ?> <span
									class="percent"><?php echo $print_percent;?> %</span>
							</div>
							<div class="essb-stats-panel-value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($single); ?>
						</div>
						</div>
						<div class="essb-stats-panel-graph">

							<div class="graph widget-color-ok" style="width: <?php echo $percent;?>%;"></div>

						</div>
					</div>
									
									<?php
			}
		}
	}
	
	?>					
				</div>



				<div class="row">
					<div class="essb-title5">
						<div>Clicks by social networks</div>
					</div>


					
<?php
	
	if (isset ( $overall_stats )) {
		$cnt = 0;
		foreach ( $essb_networks as $k => $v ) {
			
			$single = intval ( $overall_stats->{$k} );
			
			if ($single > 0) {
				$percent = $single * 100 / $calculated_total;
				$print_percent = round ( $percent, 2 );
				$percent = round ( $percent );
				?>
			
			<div
						class="essb-stats-panel essb-stat-network shadow panel20 widget-color-<?php echo $k; ?>">
						<div class="essb-stats-panel-inner">
							<div class="essb-stats-panel-text">
								<i class="essb_icon_<?php echo $k; ?>"></i> <span
									class="details"><?php echo $v["name"]; ?><br /> <span
									class="percent"><?php echo $print_percent;?> %</span></span>
							</div>
							<div class="essb-stats-panel-value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($single); ?>
						</div>
						</div>
						<div class="essb-stats-panel-graph">

							<div class="graph widget-color-white" style="width: <?php echo $percent;?>%;"></div>

						</div>
					</div>
									
									<?php
			}
		}
	}
	
	?>
				</div>

			</div>



		</div>
	</div>
	
	<div class="clear"></div>




	<div class="essb-dashboard-panel">
		<div class="essb-dashboard-panel-title">
			<h4>Content details for this position</h4>
		</div>
		<div class="essb-dashboard-panel-content">
			<?php ESSBSocialShareAnalyticsBackEnd::essb_stat_admin_detail_by_post( '', $networks_with_data, '', $date, $position );?>
			</div>
	</div>
	
			
		
		<?php } ?>
	
	<?php } ?>
</div>

<script type="text/javascript">
jQuery(document).ready(function($){
      <?php
						if ($mode == "1") {
							echo ESSBSocialShareAnalyticsBackEnd::keyObjectToMorrisLineGraph ( 'essb-changes-graph', $dataPeriodObject, 'Social activity' );
						}
						?>
						if (jQuery("#table-month").length)
						jQuery('#table-month').DataTable({ pageLength: 50, scrollX: true, order: [[0, 'desc']], fixedColumns: true});

						if (jQuery("#table-posts").length)
							jQuery('#table-posts').DataTable({ pageLength: 50, scrollX: true, order: [[1, 'desc']], fixedColumns: true});
});

var essb_analytics_date_report = function(date) {

	window.location='admin.php?page=essb_redirect_analytics&tab=analytics&mode=4&date='+date;

}

var essb_analytics_position_report = function(position) {

	window.location='admin.php?page=essb_redirect_analytics&tab=analytics&mode=5&position='+position;

}
	
</script>