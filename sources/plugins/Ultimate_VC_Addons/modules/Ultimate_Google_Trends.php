<?php
/*
* Add-on Name: Ultimate Google Trends
* Add-on URI: https://www.brainstormforce.com
*/
if(!class_exists("Ultimate_Google_Trends")){
	class Ultimate_Google_Trends{
		function __construct(){
			add_action("init",array($this,"google_trends_init"));
			add_shortcode("ultimate_google_trends",array($this,"display_ultimate_trends"));
		}
		function google_trends_init(){
			if ( function_exists('vc_map'))
			{
				vc_map( array(
					"name" => __("Google Trends", "ultimate_vc"),
					"base" => "ultimate_google_trends",
					"class" => "vc_google_trends",
					"controls" => "full",
					"show_settings_on_create" => true,
					"icon" => "vc_google_trends",
					"description" => __("Display Google Trends to show insights.", "ultimate_vc"),
					"category" => "Ultimate VC Addons",
					"params" => array(
						/*array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Compare", "smile"),
							"param_name" => "search_by",
							"admin_label" => true,
							"value" => array(
								__("Multiple Search Terms", "smile") => "q",
								//__("Search Term at Location", "smile") => "geo",
								//__("Search Term over Time Range", "smile") => "date"
							)
						),*/
						array(
							"type" => "textarea",
							"class" => "",
							"heading" => __("Comparison Terms", "ultimate_vc"),
							"param_name" => "gtrend_query",
							"value" => "",
							"description" => __("Enter maximum 5 terms separated by comma. Example:","ultimate_vc")." <em>".__("Google, Facebook, LinkedIn","ultimate_vc")."</em>",
							//"dependency" => Array("element" => "search_by","value" => array("q")),
						),
						/*array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Comparison Term", "smile"),
							"param_name" => "gtrend_query_2",
							"value" => "",
							"description" => __("Enter single term. Example: <em>Love</em>", "smile"),
							"dependency" => Array("element" => "search_by","value" => array("geo","date")),
						),*/
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Location", "ultimate_vc"),
							"param_name" => "location_by",
							"admin_label" => true,
							"value" => array(
								__("Worldwide", "ultimate_vc") => "",
								__("Argentina", "ultimate_vc") => "AR",
								__("Australia", "ultimate_vc") => "AU",
								__("Austria", "ultimate_vc") => "AT",
								__("Bangladesh", "ultimate_vc") => "BD",
								__("Belgium", "ultimate_vc") => "BE",
								__("Brazil", "ultimate_vc") => "BR",
								__("Bulgaria", "ultimate_vc") => "BG",
								__("Canada", "ultimate_vc") => "CA",
								__("Chile", "ultimate_vc") => "CL",
								__("China", "ultimate_vc") => "CN",
								__("Colombia", "ultimate_vc") => "CO",
								__("Costa Rica", "ultimate_vc") => "CR",
								__("Croatia", "ultimate_vc") => "HR",
								__("Czech Republic", "ultimate_vc") => "CZ",
								__("Denmark", "ultimate_vc") => "DK",
								__("Dominican Republic", "ultimate_vc") => "DO",
								__("Ecuador", "ultimate_vc") => "EC",
								__("Egypt", "ultimate_vc") => "EG",
								__("El Salvador", "ultimate_vc") => "SV",
								__("Estonia", "ultimate_vc") => "EE",
								__("Finland", "ultimate_vc") => "FI",
								__("France", "ultimate_vc") => "FR",
								__("Germany", "ultimate_vc") => "DE",
								__("Ghana", "ultimate_vc") => "GH",
								__("Greece",'ultimate_vc') => "GR",
								__("Guatemala", "ultimate_vc") => "GT",
								__("Honduras", "ultimate_vc") => "HN",
								__("Hong Kong", "ultimate_vc") => "HK",
								__("Hungary", "ultimate_vc") => "HU",
								__("India", "ultimate_vc") => "IN",
								__("Indonesia", "ultimate_vc") => "ID",
								__("Ireland", "ultimate_vc") => "IE",
								__("Israel", "ultimate_vc") => "IL",
								__("Italy", "ultimate_vc") => "IT",
								__("Japan", "ultimate_vc") => "JP",
								__("Kenya", "ultimate_vc") => "KE",
								__("Latvia", "ultimate_vc") => "LV",
								__("Lithuania", "ultimate_vc") => "LT",
								__("Malaysia", "ultimate_vc") => "MY",
								__("Mexico", "ultimate_vc") => "MX",
								__("Netherlands", "ultimate_vc") => "NL",
								__("New Zealand", "ultimate_vc") => "NZ",
								__("Nigeria", "ultimate_vc") => "NG",
								__("Norway", "ultimate_vc") => "NO",
								__("Pakistan", "ultimate_vc") => "PK",
								__("Panama", "ultimate_vc") => "PA",
								__("Peru", "ultimate_vc") => "PE",
								__("Philippines", "ultimate_vc") => "PH",
								__("Poland", "ultimate_vc") => "PL",
								__("Portugal", "ultimate_vc") => "PT",
								__("Puerto Rico", "ultimate_vc") => "PR",
								__("Romania", "ultimate_vc") => "RO",
								__("Russia", "ultimate_vc") => "RU",
								__("Saudi Arabia", "ultimate_vc") => "SA",
								__("Senegal", "ultimate_vc") => "SN",
								__("Serbia", "ultimate_vc") => "RS",
								__("Singapore", "ultimate_vc") => "SG",
								__("Slovakia", "ultimate_vc") => "SK",
								__("Slovenia", "ultimate_vc") => "SI",
								__("South Africa", "ultimate_vc") => "ZA",
								__("South Korea", "ultimate_vc") => "KR",
								__("Spain", "ultimate_vc") => "ES",
								__("Sweden", "ultimate_vc") => "SE",
								__("Switzerland", "ultimate_vc") => "CH",
								__("Taiwan", "ultimate_vc") => "TW",
								__("Thailand", "ultimate_vc") => "TH",
								__("Turkey", "ultimate_vc") => "TR",
								__("Uganda", "ultimate_vc") => "UG",
								__("Ukraine", "ultimate_vc") => "UA",
								__("United Arab Emirates", "ultimate_vc") => "AE",
								__("United Kingdom", "ultimate_vc") => "GB",
								__("United States", "ultimate_vc") => "US",
								__("Uruguay", "ultimate_vc") => "UY",
								__("Venezuela", "ultimate_vc") => "VE",
								__("Vietnam", "ultimate_vc") => "VN",
							)
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Graph type", "ultimate_vc"),
							"param_name" => "graph_type",
							"admin_label" => true,
							"value" => array(__("Interest over time", "ultimate_vc") => "TIMESERIES_GRAPH_0", __("Interest over time with average", "ultimate_vc") => "TIMESERIES_GRAPH_AVERAGES_CHART", __("Regional interest in map", "ultimate_vc") => "GEO_MAP_0_0", __("Regional interest in table", "ultimate_vc") => "GEO_TABLE_0_0", __("Related searches (Topics)", "ultimate_vc") => "TOP_ENTITIES_0_0", __("Related searches (Queries)", "ultimate_vc") => "TOP_QUERIES_0_0"),
							//"dependency" => Array("element" => "search_by","value" => array("q"))
						),
						/*array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Graph type", "smile"),
							"param_name" => "graph_type_2",
							"admin_label" => true,
							"value" => array(__("Top Entities", "smile") => "TOP_ENTITIES_0_0", __("Top Queries", "smile") => "TOP_QUERIES_0_0"),
							"dependency" => Array("element" => "search_by","value" => array("geo", "date"))
						),*/
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Frame Width (optional)", "ultimate_vc"),
							"param_name" => "gtrend_width",
							"value" => "",
							"description" => __("For Example: 500", "ultimate_vc")
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Frame Height (optional)", "ultimate_vc"),
							"param_name" => "gtrend_height",
							"value" => "",
							"description" => __("For Example: 350", "ultimate_vc")
						),
						array(
								"type" => "textfield",
								"heading" => __("Extra class name", "ultimate_vc"),
								"param_name" => "el_class",
								"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "ultimate_vc")
						),
						array(
							"type" => "ult_param_heading",
							"text" => "<span style='display: block;'><a href='http://bsf.io/skwuz' target='_blank'>".__("Watch Video Tutorial","ultimate_vc")." &nbsp; <span class='dashicons dashicons-video-alt3' style='font-size:30px;vertical-align: middle;color: #e52d27;'></span></a></span>",
							"param_name" => "notification",
							'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
						),
						array(
					            'type' => 'css_editor',
					            'heading' => __( 'Css', 'ultimate_vc' ),
					            'param_name' => 'css_gtrend_design',
					            'group' => __( 'Design ', 'ultimate_vc' ),
					            'edit_field_class' => 'vc_col-sm-12 vc_column no-vc-background no-vc-border creative_link_css_editor',
					        ),
					)
				));
			}
		}
		function display_ultimate_trends($atts,$content = null){
			$width = $height = $graph_type = $graph_type_2 = $search_by = $location_by = $gtrend_query = $gtrend_query_2 = $el_class = '';
			$css_design_style = '';
			extract(shortcode_atts(array(
				//"id" => "map",
				"gtrend_width" => "",
				"gtrend_height" => "",
				"graph_type" => "TIMESERIES_GRAPH_0",
				"graph_type_2" => "",
				"search_by" => "q",
				"location_by" => "",
				"gtrend_query" => "",
				"gtrend_query_2" => "",
				"el_class" => "",
				"css_gtrend_design" => "",
			), $atts));
			$vc_version = (defined('WPB_VC_VERSION')) ? WPB_VC_VERSION : 0;
			$is_vc_49_plus = (version_compare(4.9, $vc_version, '<=')) ? 'ult-adjust-bottom-margin' : '';
			
			$css_design_style = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css_gtrend_design, ' ' ), "ultimate_google_trends", $atts );
 			$css_design_style = esc_attr( $css_design_style );
			
			if($search_by === 'q')
			{
				$graph_type_new = $graph_type;
				$gtrend_query_new = $gtrend_query;
			}
			else
			{
				$graph_type_new = $graph_type_2;
				$gtrend_query_new = $gtrend_query_2;
			}
			if($gtrend_width != '')
			{
				$width = $gtrend_width;
				$width = '&amp;w='.$width;
			}
			if($gtrend_height != '')
			{
				$height = $gtrend_height;
				$height = '&amp;h='.$height;
			}
			$id = uniqid('vc-trends-');
			$output = '<div id="'.$id.'" class="ultimate-google-trends '.$is_vc_49_plus.' '.$el_class.' '.$css_design_style.'">
				<script type="text/javascript" src="//www.google.com/trends/embed.js?hl=en-US&amp;q='.$gtrend_query_new.'&cmpt='.$search_by.'&amp;geo='.$location_by.'&amp;content=1&amp;cid='.$graph_type_new.'&amp;export=5'.$width.$height.'"></script>
			</div>';
			return $output;
		}
	}
	new Ultimate_Google_Trends;
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_ultimate_google_trends extends WPBakeryShortCode {
		}
	}

}