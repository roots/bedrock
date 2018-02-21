<?php
/**
 * Draw information for popular posts inside Metrics based on last updated details
 */

$esml_data = new ESSBSocialMetricsDataHolder ();
$esml_data->get_posts();

?>

<style type="text/css">
.essb-version {
	background: rgba(0, 0, 0, 0.3);
	display: block;
	position: absolute;
	padding: 5px 0px;
	width: 100%;
	bottom: 0;
	left: 0;
	font-size: 12px;
	text-transform: uppercase;
}

.essb-page-welcome .wp-badge {
	padding-top: 70px;
	width: 100px;
	background-size: 48px;
	background-position: center 20px;
	border-radius: 5px;
	-webkit-border-radius: 5px;
}

.about-wrap { max-width: 100%; }
.about-wrap .wp-badge { right: 20px; }

.essb-welcome { margin-top: 10px; }

.essb-welcome-close { margin-bottom: 1em; }

.about-wrap h1 { font-size: 24px; font-weight: 600; }
.about-wrap .about-text { margin: 1em 180px 0 0; font-size: 16px; }

.essb_status_icon {
	font-size: 18px;
	line-height: 18px;
	padding: 5px; 
}

.up-bg {
	background-color: #D9F5BE !important;
}

.down-bg {
	background-color: #F3C9BF !important;
}

</style>

<div class="wrap essb-page-welcome about-wrap essb-wrap-welcome">
	<h1>Social Metrics by Easy Social Share Buttons for WordPress</h1>

	<div class="about-text">
		Social Metrics data provide details for shares over social networks you are using on your site. To collect and update data you need to have share counters working on site.
	</div>
	<div class="wp-badge essb-page-logo essb-logo">
		<span class="essb-version"><?php echo sprintf( __( 'Version %s', 'essb' ), ESSB3_VERSION )?></span>
	</div>
</div>

<div class="wrap">

	<div class="essb-clear"></div>

	<div class="essb-title-panel">
	<form id="easy-social-metrics-lite" method="get" action="admin.php?page=easy-social-metrics-lite">
	<input type="hidden" name="page" value="<?php echo sanitize_text_field($_REQUEST['page']) ?>" />
	<?php
	$range = (isset ( $_GET ['range'] )) ? $_GET ['range'] : 0;
	?>
	    			<label for="range">Show only:</label> <select name="range">
			<option value="1"
				<?php if ($range == 1) echo 'selected="selected"'; ?>>Items
				published within 1 Month</option>
			<option value="3"
				<?php if ($range == 3) echo 'selected="selected"'; ?>>Items
				published within 3 Months</option>
			<option value="6"
				<?php if ($range == 6) echo 'selected="selected"'; ?>>Items
				published within 6 Months</option>
			<option value="12"
				<?php if ($range == 12) echo 'selected="selected"'; ?>>Items
				published within 12 Months</option>
			<option value="0"
				<?php if ($range == 0) echo 'selected="selected"'; ?>>Items
				published anytime</option>
		</select>
	    					
	    					<?php do_action( 'esml_dashboard_query_options' ); // Allows developers to add additional sort options ?>
	    
	    					<input type="submit" name="filter" id="submit_filter"
			class="button" value="Filter"> 
	    			<?php
								?>
								</form>
	</div>

	<!-- dashboard start -->
	<div class="essb-dashboard">

		<div class="row">

			<div class="onecol">
				<div class="essb-dashboard-panel">
					<div class="essb-dashboard-panel-title">
						<h4><?php _e('Networks', 'essb'); ?></h4>
					</div>
					<div class="essb-dashboard-panel-content">
					<?php
					
					$esml_data->output_total_result_modern();

					?>
					</div>
				</div>
			</div>
			
			<div class="onecol">
				<div class="essb-dashboard-panel">
					<div class="essb-dashboard-panel-title">
						<h4>Trending Content by Social Network</h4>
					</div>
					<div class="essb-dashboard-panel-content">
					<?php
					$esml_data->output_trending_content();
					?>
					</div>
				</div>
			</div>

			<div class="onecol">
				<div class="essb-dashboard-panel">
					<div class="essb-dashboard-panel-title">
						<h4>Top Shared Content by Social Network</h4>
					</div>
					<div class="essb-dashboard-panel-content">
					<?php
					$esml_data->output_total_content();
					?>
					</div>
				</div>
			</div>

		</div>

		<div class="row">

			<div class="essb-dashboard-panel">
				<div class="essb-dashboard-panel-title">
					<h4>Post Details</h4>
				</div>
				<div class="essb-dashboard-panel-content">
					<?php
					
					$esml_data->output_main_result();
					
					?>
					</div>
			</div>
		</div>

	</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#esml-result').DataTable({ pageLength: 50});
} );
</script>

