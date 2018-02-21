<?php

function essb_register_settings_metabox_optimize() {
	global $post;
	
	$essb_post_share_message = "";
	$essb_post_share_url = "";
	$essb_post_share_image = "";
	$essb_post_share_text = "";
	$essb_post_fb_url = "";
	$essb_post_plusone_url = "";
	
	$essb_post_og_desc = "";
	$essb_post_og_title = "";
	$essb_post_og_image = "";
	$essb_post_og_video = "";
	$essb_post_og_video_w = "";
	$essb_post_og_video_h = "";
	
	$essb_post_og_image1 = "";
	$essb_post_og_image2 = "";
	$essb_post_og_image3 = "";
	$essb_post_og_image4 = "";
	
	$essb_post_twitter_desc = "";
	$essb_post_twitter_title = "";
	$essb_post_twitter_image = "";
		
	$essb_post_twitter_hashtags = "";
	$essb_post_twitter_username = "";
	$essb_post_twitter_tweet = "";
	$essb_activate_sharerecovery = "";
	
	$essb_post_pin_image = "";
	
	$post_address = "";
	
	// the post is open into editor
	if (isset($_GET['action'])) {

		
		$custom = get_post_custom ( $post->ID );
		
		// custom post data sharing details
		$post_address = get_permalink ( $post->ID );
		
		$essb_post_share_message = isset ( $custom ["essb_post_share_message"] ) ? $custom ["essb_post_share_message"] [0] : "";
		$essb_post_share_url = isset ( $custom ["essb_post_share_url"] ) ? $custom ["essb_post_share_url"] [0] : "";
		$essb_post_share_image = isset ( $custom ["essb_post_share_image"] ) ? $custom ["essb_post_share_image"] [0] : "";
		$essb_post_share_text = isset ( $custom ["essb_post_share_text"] ) ? $custom ["essb_post_share_text"] [0] : "";
		$essb_post_fb_url = isset ( $custom ["essb_post_fb_url"] ) ? $custom ["essb_post_fb_url"] [0] : "";
		$essb_post_plusone_url = isset ( $custom ["essb_post_plusone_url"] ) ? $custom ["essb_post_plusone_url"] [0] : "";
		
		$essb_post_share_message = stripslashes ( $essb_post_share_message );
		$essb_post_share_text = stripslashes ( $essb_post_share_text );
		
		
		$essb_post_twitter_hashtags = isset ( $custom ['essb_post_twitter_hashtags'] ) ? $custom ['essb_post_twitter_hashtags'] [0] : "";
		$essb_post_twitter_username = isset ( $custom ['essb_post_twitter_username'] ) ? $custom ['essb_post_twitter_username'] [0] : "";
		$essb_post_twitter_tweet = isset ( $custom ['essb_post_twitter_tweet'] ) ? $custom ['essb_post_twitter_tweet'] [0] : "";
		$essb_activate_ga_campaign_tracking = isset($custom['essb_activate_ga_campaign_tracking']) ? $custom['essb_activate_ga_campaign_tracking'][0] : "";
		
		$essb_post_pin_image = isset ( $custom ["essb_post_pin_image"] ) ? $custom ["essb_post_pin_image"] [0] : "";
		
		$essb_activate_sharerecovery = isset($custom['essb_activate_sharerecovery']) ? $custom['essb_activate_sharerecovery'][0] : '';
			
		// post share optimizations
		$essb_post_og_desc = isset ( $custom ["essb_post_og_desc"] ) ? $custom ["essb_post_og_desc"] [0] : "";
		$essb_post_og_title = isset ( $custom ["essb_post_og_title"] ) ? $custom ["essb_post_og_title"] [0] : "";
		$essb_post_og_image = isset ( $custom ["essb_post_og_image"] ) ? $custom ["essb_post_og_image"] [0] : "";
		$essb_post_og_image1 = isset ( $custom ["essb_post_og_image1"] ) ? $custom ["essb_post_og_image1"] [0] : "";
		$essb_post_og_image2 = isset ( $custom ["essb_post_og_image2"] ) ? $custom ["essb_post_og_image2"] [0] : "";
		$essb_post_og_image3 = isset ( $custom ["essb_post_og_image3"] ) ? $custom ["essb_post_og_image3"] [0] : "";
		$essb_post_og_image4 = isset ( $custom ["essb_post_og_image4"] ) ? $custom ["essb_post_og_image4"] [0] : "";
		$essb_post_og_url = isset ( $custom ["essb_post_og_url"] ) ? $custom ["essb_post_og_url"] [0] : "";
		
		
		$essb_post_og_desc = stripslashes ( $essb_post_og_desc );
		$essb_post_og_title = stripslashes ( $essb_post_og_title );
		$essb_post_og_video = isset ( $custom ["essb_post_og_video"] ) ? $custom ["essb_post_og_video"] [0] : "";
		$essb_post_og_video_w = isset ( $custom ["essb_post_og_video_w"] ) ? $custom ["essb_post_og_video_w"] [0] : "";
		$essb_post_og_video_h = isset ( $custom ["essb_post_og_video_h"] ) ? $custom ["essb_post_og_video_h"] [0] : "";
		
		$essb_post_twitter_desc = isset ( $custom ["essb_post_twitter_desc"] ) ? $custom ["essb_post_twitter_desc"] [0] : "";
		$essb_post_twitter_title = isset ( $custom ["essb_post_twitter_title"] ) ? $custom ["essb_post_twitter_title"] [0] : "";
		$essb_post_twitter_image = isset ( $custom ["essb_post_twitter_image"] ) ? $custom ["essb_post_twitter_image"] [0] : "";
		$essb_post_twitter_desc = stripslashes ( $essb_post_twitter_desc );
		$essb_post_twitter_title = stripslashes ( $essb_post_twitter_title );
				
		$essb_post_og_author = isset($custom['essb_post_og_author']) ? $custom['essb_post_og_author'][0] : '';
		$essb_post_og_author = stripslashes($essb_post_og_author);
		
		// Metabox draw start
		ESSBMetaboxInterface::draw_form_start ( 'essb_social_share_optimize' );
		
		$sidebar_options = array();
		
		if (essb_options_bool_value('opengraph_tags') || essb_options_bool_value('twitter_card')) {
			$sidebar_options[] = array(
					'field_id' => 'opengraph',
					'title' => __('Sharing Optimization', 'essb'),
					'icon' => 'share-alt',
					'type' => 'menu_item',
					'action' => 'default',
					'default_child' => ''
			);
		}
		
		$sidebar_options[] = array(
				'field_id' => 'twittertag',
				'title' => __('Customize Tweet', 'essb'),
				'icon' => 'twitter',
				'type' => 'menu_item',
				'action' => 'default',
				'default_child' => ''
		);
		
		if (essb_option_bool_value('pinterest_sniff_disable')) {
			$sidebar_options[] = array(
					'field_id' => 'pinterest',
					'title' => __('Pinterest Image', 'essb'),
					'icon' => 'pinterest-p',
					'type' => 'menu_item',
					'action' => 'default',
					'default_child' => ''
			);
		}
		
		$sidebar_options[] = array(
				'field_id' => 'share',
				'title' => __('Share Message (Advanced)', 'essb'),
				'icon' => 'default',
				'type' => 'menu_item',
				'action' => 'default',
				'default_child' => ''
		);
				
		$sidebar_options[] = array(
				'field_id' => 'ga',
				'title' => __('GA Campaign Tracking Options', 'essb'),
				'icon' => 'pie-chart',
				'type' => 'menu_item',
				'action' => 'default',
				'default_child' => ''
		);
		
		if (defined('ESSB3_SHARED_COUNTER_RECOVERY')) {
			$sidebar_options[] = array(
					'field_id' => 'sharerecover',
					'title' => __('Share Recovery', 'essb'),
					'icon' => 'refresh',
					'type' => 'menu_item',
					'action' => 'default',
					'default_child' => ''
			);
		}
		
		if (defined('ESSB3_CACHED_COUNTERS')) {
			$sidebar_options[] = array(
					'field_id' => 'sharecounter',
					'title' => __('Social Shares', 'essb'),
					'icon' => 'sort-numeric-asc',
					'type' => 'menu_item',
					'action' => 'default',
					'default_child' => ''
			);
		}
		
		if (essb_option_bool_value('activate_fake')) {
			$sidebar_options[] = array(
					'field_id' => 'fakecounter',
					'title' => __('Fake/Dummy Share Counter', 'essb'),
					'icon' => 'magic',
					'type' => 'menu_item',
					'action' => 'default',
					'default_child' => ''
			);
		}
		
		ESSBMetaboxInterface::draw_first_menu_activate('sso');
		
		ESSBMetaboxInterface::draw_sidebar($sidebar_options, 'sso');
		ESSBMetaboxInterface::draw_content_start('300', 'sso');
		
		
		
		if (essb_options_bool_value('opengraph_tags') || essb_options_bool_value('twitter_card')) {
			ESSBMetaboxInterface::draw_content_section_start('opengraph');
	
			if (essb_options_bool_value('opengraph_tags')) {
				ESSBOptionsFramework::draw_panel_start(__('SOCIAL MEDIA MESSAGE', 'essb'), __('Customize default generate social sharing message that is filled from post data to grab your social media audience', 'essb'), 'fa21 ti-sharethis', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"), 'essb_metabox');
				
				ESSBOptionsFramework::draw_title(__('Social Media Image', 'essb'), __('Add an image that is optimized for maximum exposure on most social networks. We recommend 1200px by 628px', 'essb'), 'inner-row');
				ESSBOptionsFramework::draw_options_row_start_full('inner-row-small');
				ESSBOptionsFramework::draw_fileselect_image_field('essb_post_og_image', 'essb_metabox', $essb_post_og_image);
				ESSBOptionsFramework::draw_options_row_end();
				
				ESSBOptionsFramework::draw_title(__('Social Media Title', 'essb'), __('Add a title that will populate the open graph meta tag which will be used when users share your content onto most social networks. If nothing is provided here, we will use the post title as a backup. We recommend usage of titles that does not exceed 60 characters', 'essb'), 'inner-row');
				ESSBOptionsFramework::draw_options_row_start_full('inner-row-small');
				ESSBOptionsFramework::draw_input_field('essb_post_og_title', true, 'essb_metabox', $essb_post_og_title);
				ESSBOptionsFramework::draw_options_row_end();
				
		
				ESSBOptionsFramework::draw_title(__('Social Media Description', 'essb'), __('Add a description that will populate the open graph meta tag which will be used when users share your content onto most social networks.<span class="essb-inner-recommend">We recommend usage of description that does not exceed 160 characters</span>', 'essb'), 'inner-row');
				ESSBOptionsFramework::draw_options_row_start_full('inner-row-small');
				ESSBOptionsFramework::draw_textarea_field('essb_post_og_desc', 'essb_metabox', $essb_post_og_desc);
				ESSBOptionsFramework::draw_options_row_end();
				
				//$essb_post_og_url
				
				ESSBOptionsFramework::draw_options_row_start_full('inner-row-small');
				ESSBOptionsFramework::draw_hint(__('Did you know that Facebook has share data cache?', 'essb'), __('All changes that you made on site will not appear immediately unless you clear cache and make Facebook bot revisit your site. The quick way to do this is to use Easy Social Share Buttons top menu in WordPress bar where in Validation you will find link to test and update Facebook information. You can read more about this tool in this article <a href="http://appscreo.com/facebook-debugger-tool/" target="_blank">http://appscreo.com/facebook-debugger-tool/</a> in our blog. ', 'essb'), 'fa21 ti-info-alt');
				ESSBOptionsFramework::draw_options_row_end();

				ESSBOptionsFramework::draw_title(__('Customize Open Graph URL', 'essb'), __('Important! This field is needed only if you made a change in your URL structure and you need to customize og:url tag to preserve shares you have. Do not fill here anything unless you are completely sure you need it - not proper usage will lead to loose of your current social shares and comments.', 'essb'), 'inner-row');
				ESSBOptionsFramework::draw_options_row_start_full('inner-row-small');
				ESSBOptionsFramework::draw_input_field('essb_post_og_url', true, 'essb_metabox', $essb_post_og_url);
				ESSBOptionsFramework::draw_options_row_end();
				
				
				
				if (essb_option_bool_value('sso_multipleimages')) {
					ESSBOptionsFramework::draw_heading(__('Additional Facebook Images', 'essb'), '5');
					
					ESSBOptionsFramework::draw_title(__('Additional Social Media Image #1', 'essb'), __('Add an image that is optimized for maximum exposure on most social networks.<span class="essb-inner-recommend">We recommend 1200px by 628px</span>', 'essb'), 'inner-row');
					ESSBOptionsFramework::draw_options_row_start_full('inner-row-small');
					ESSBOptionsFramework::draw_fileselect_field('essb_post_og_image1', 'essb_metabox', $essb_post_og_image1);
					ESSBOptionsFramework::draw_options_row_end();
	
					ESSBOptionsFramework::draw_title(__('Additional Social Media Image #2', 'essb'), __('Add an image that is optimized for maximum exposure on most social networks.<span class="essb-inner-recommend">We recommend 1200px by 628px</span>', 'essb'), 'inner-row');
					ESSBOptionsFramework::draw_options_row_start_full('inner-row-small');
					ESSBOptionsFramework::draw_fileselect_field('essb_post_og_image2', 'essb_metabox', $essb_post_og_image2);
					ESSBOptionsFramework::draw_options_row_end();
					
					ESSBOptionsFramework::draw_title(__('Additional Social Media Image #3', 'essb'), __('Add an image that is optimized for maximum exposure on most social networks.<span class="essb-inner-recommend">We recommend 1200px by 628px</span>', 'essb'), 'inner-row');
					ESSBOptionsFramework::draw_options_row_start_full('inner-row-small');
					ESSBOptionsFramework::draw_fileselect_field('essb_post_og_image3', 'essb_metabox', $essb_post_og_image3);
					ESSBOptionsFramework::draw_options_row_end();
					
					ESSBOptionsFramework::draw_title(__('Additional Social Media Image #4', 'essb'), __('Add an image that is optimized for maximum exposure on most social networks.<span class="essb-inner-recommend">We recommend 1200px by 628px</span>', 'essb'), 'inner-row');
					ESSBOptionsFramework::draw_options_row_start_full('inner-row-small');
					ESSBOptionsFramework::draw_fileselect_field('essb_post_og_image4', 'essb_metabox', $essb_post_og_image4);
					ESSBOptionsFramework::draw_options_row_end();
				}
				
				ESSBOptionsFramework::draw_title(__('Article Author Profile', 'essb'), __('Add link to Facebook profile page of article author if you wish it to appear in shared information. Example: https://facebook.com/author', 'essb'), 'inner-row');
				ESSBOptionsFramework::draw_options_row_start_full('inner-row-small');
				ESSBOptionsFramework::draw_input_field('essb_post_og_author', true, 'essb_metabox', $essb_post_og_author);
				ESSBOptionsFramework::draw_options_row_end();
				
				
				ESSBOptionsFramework::draw_panel_end();
			}
			
			if (essb_options_bool_value('twitter_card')) {
				
				ESSBOptionsFramework::draw_panel_start(__('Personalize Twitter card data', 'essb'), __('Twitter card data will be filled with default social share message or with data from Social Share Optimization tags. Use this box in case you need special customizations that will work only for Twitter', 'essb'), 'fa21 ti-twitter', array("mode" => "toggle", "state" => "closed", "css_class" => "essb-auto-open"), 'essb_metabox');

				ESSBOptionsFramework::draw_options_row_start(__('Image', 'essb'), __('If an image is provided it will be used in share data', 'essb'));
				ESSBOptionsFramework::draw_fileselect_image_field('essb_post_twitter_image', 'essb_metabox', $essb_post_twitter_image);
				ESSBOptionsFramework::draw_options_row_end();
				
				ESSBOptionsFramework::draw_options_row_start(__('Title', 'essb'), __('Add a custom title for your post. This will be used to post on an user\'s wall when they like/share your post.', 'essb'));
				ESSBOptionsFramework::draw_input_field('essb_post_twitter_title', true, 'essb_metabox', $essb_post_twitter_title);
				ESSBOptionsFramework::draw_options_row_end();
				
				ESSBOptionsFramework::draw_options_row_start(__('Description', 'essb'), __('Add a custom description for your post. This will be used to post on an user\'s wall when they like/share your post.', 'essb'));
				ESSBOptionsFramework::draw_textarea_field('essb_post_twitter_desc', 'essb_metabox', $essb_post_twitter_desc);
				ESSBOptionsFramework::draw_options_row_end();
				ESSBOptionsFramework::draw_panel_end();
			}
			
			
			ESSBMetaboxInterface::draw_content_section_end();
		}
		
		ESSBMetaboxInterface::draw_content_section_start('twittertag');
		ESSBOptionsFramework::reset_row_status();
		ESSBOptionsFramework::draw_heading(__('Customize Tweet Message for this post', 'essb'), '5');
		
		ESSBOptionsFramework::draw_options_row_start(__('Hashtags', 'essb'), __('Set custom own tags for post or leave blank to use site defined', 'essb'));
		ESSBOptionsFramework::draw_input_field('essb_post_twitter_hashtags', true, 'essb_metabox', $essb_post_twitter_hashtags);
		ESSBOptionsFramework::draw_options_row_end();
		
		ESSBOptionsFramework::draw_options_row_start(__('Username', 'essb'), __('Change default user that will be mentioned into Tweet.', 'essb'));
		ESSBOptionsFramework::draw_input_field('essb_post_twitter_username', true, 'essb_metabox', $essb_post_twitter_username);
		ESSBOptionsFramework::draw_options_row_end();
		
		ESSBOptionsFramework::draw_options_row_start(__('Tweet', 'essb'), __('Default Tweet is generated from post title. In this field you can easy define own personalized Tweet for better social network reach.', 'essb'));
		ESSBOptionsFramework::draw_textarea_field('essb_post_twitter_tweet', 'essb_metabox', $essb_post_twitter_tweet);
		ESSBOptionsFramework::draw_options_row_end();
		
		ESSBMetaboxInterface::draw_content_section_end();
		
		if (essb_option_bool_value('pinterest_sniff_disable')) {
			ESSBMetaboxInterface::draw_content_section_start('pinterest');
			ESSBOptionsFramework::reset_row_status();
			ESSBOptionsFramework::draw_options_row_start(__('Change default Pinterest image', 'essb'), __('Choose personalized image that will be used to when you press Pinterest share button <span class="essb-inner-recommend">We recommend using an image that is formatted in a 2:3 aspect ratio like 735 x 1102.</span>', 'essb'));
			ESSBOptionsFramework::draw_fileselect_image_field('essb_post_pin_image', 'essb_metabox', $essb_post_pin_image);
			ESSBOptionsFramework::draw_options_row_end();
			ESSBMetaboxInterface::draw_content_section_end();
		}
		
		ESSBMetaboxInterface::draw_content_section_start('share');
		
		ESSBOptionsFramework::reset_row_status();
		ESSBOptionsFramework::draw_heading(__('Customize Share Message (Advanced)', 'essb'), '5');
		
		ESSBOptionsFramework::draw_hint('', __('Customize share message is an easy way to change the default shared information that is used by share buttons. Almost all social networks that plugin support uses URL as leading sharing parameter. This in brief means for you that when you setup custom share data you need to ensure that information is also available into social share optimization tags on the destination URL that plugin will share.<br/><br/>Please do not foget to fill all parameters for better results because few of social networks support almost all parameters and data for them will be taken from that screen if filled or from post default data if they are empty.', 'essb'));
		
		ESSBOptionsFramework::draw_options_row_start(__('URL', 'essb'), __('Provide custom URL to be shared.', 'essb'));
		ESSBOptionsFramework::draw_input_field('essb_post_share_url', true, 'essb_metabox', $essb_post_share_url);
		ESSBOptionsFramework::draw_options_row_end();
		
		ESSBOptionsFramework::draw_options_row_start(__('Message', 'essb'), __('Provide custom message to be shared (not all social networks support that option)', 'essb'));
		ESSBOptionsFramework::draw_input_field('essb_post_share_message', true, 'essb_metabox', $essb_post_share_message);
		ESSBOptionsFramework::draw_options_row_end();
		
		ESSBOptionsFramework::draw_options_row_start(__('Image', 'essb'), __('Custom image is support by Facebook when advanced sharing is enabled and Pinterest when sniff for images is disabled', 'essb'));
		ESSBOptionsFramework::draw_fileselect_field('essb_post_share_image', 'essb_metabox', $essb_post_share_image);
		ESSBOptionsFramework::draw_options_row_end();
		
		ESSBOptionsFramework::draw_options_row_start(__('Description', 'essb'), __('Custom description is support by Facebook when advanced sharing is enabled and Pinterest when sniff for images is disabled', 'essb'));
		ESSBOptionsFramework::draw_textarea_field('essb_post_share_text', 'essb_metabox', $essb_post_share_text);
		ESSBOptionsFramework::draw_options_row_end();
		ESSBMetaboxInterface::draw_content_section_end();
			
		
		ESSBMetaboxInterface::draw_content_section_start('ga');
		
		ESSBOptionsFramework::reset_row_status();
		ESSBOptionsFramework::draw_heading(__('Customize Google Analytics Campaign Tracking Options', 'essb'), '5');
		
		ESSBOptionsFramework::draw_options_row_start(__('Add Custom Google Analytics Campaign parameters to your URLs', 'essb'), __('Paste your custom campaign parameters in this field and they will be automatically added to shared addresses on social networks. Please note as social networks count shares via URL as unique key this option is not compatible with active social share counters as it will make the start from zero.', 'essb'));
		ESSBOptionsFramework::draw_input_field('essb_activate_ga_campaign_tracking', true, 'essb_metabox', $essb_activate_ga_campaign_tracking);
		ESSBOptionsFramework::draw_options_row_end();
		
		ESSBOptionsFramework::draw_options_row_start(__('', 'essb'), __('', 'essb'), '', '2', false);
		print "<span style='font-weight: 400;'>You can visit <a href='https://support.google.com/analytics/answer/1033867?hl=en' target='_blank'>this page</a> for more information on how to use and generate these parameters.
		To include the social network into parameters use the following code <b>{network}</b>. When that code is reached it will be replaced with the network name (example: facebook). An example campaign trakcing code include network will look like this utm_source=essb_settings&utm_medium=needhelp&utm_campaign={network} - in this configuration when you press Facebook button {network} will be replaced with facebook, if you press Twitter button it will be replaced with twitter.</span>";
		ESSBOptionsFramework::draw_options_row_end();
		
		ESSBMetaboxInterface::draw_content_section_end();
			
		if (defined('ESSB3_SHARED_COUNTER_RECOVERY')) {
			ESSBMetaboxInterface::draw_content_section_start('sharerecover');
		
			ESSBOptionsFramework::reset_row_status();
			ESSBOptionsFramework::draw_heading(__('Share Counter Recovery', 'essb'), '5');
		
			ESSBOptionsFramework::draw_options_row_start(__('Previous post url address', 'essb'), __('Provide custom previous url address of post if the automatic share counter recovery is not possible to guess the previous post address.', 'essb'));
			ESSBOptionsFramework::draw_input_field('essb_activate_sharerecovery', true, 'essb_metabox', $essb_activate_sharerecovery);
			ESSBOptionsFramework::draw_options_row_end();
		
			ESSBMetaboxInterface::draw_content_section_end();
		}
		
		if (defined('ESSB3_CACHED_COUNTERS')) {
			ESSBMetaboxInterface::draw_content_section_start('sharecounter');
			
			ESSBOptionsFramework::reset_row_status();

			print '<div class="essb-dashboard" style="padding-top: 10px;">';
			$listOfNetworks = essb_available_social_networks();
			foreach ($listOfNetworks as $key => $data) {
				$value = isset ( $custom ["essb_c_".$key] ) ? $custom ["essb_c_".$key] [0] : "";
				
				if (intval($value) != 0) {
					?>
					
					<div
						class="essb-stats-panel essb-stat-network shadow panel20 widget-color-<?php echo $key; ?>">
						<div class="essb-stats-panel-inner">
							<div class="essb-stats-panel-text">
								<i class="essb_icon_<?php echo $key; ?>"></i> <span
									class="details"><?php echo $data["name"]; ?></span>
							</div>
							<div class="essb-stats-panel-value"><?php echo ESSBSocialShareAnalyticsBackEnd::prettyPrintNumber($value); ?>
						</div>
						</div>
					</div>
					<?php 
				}
			}
			print '</div>';
			
			$essb_cache_expire = isset ( $custom ['essb_cache_expire'] ) ? $custom ['essb_cache_expire'] [0] : "";
			ESSBOptionsFramework::draw_options_row_start_full();
			if ($essb_cache_expire != '') {
				ESSBOptionsFramework::draw_title('Next counter update will be at '.date(DATE_RFC822, $essb_cache_expire), 'If you wish to make a manual counter update you can use the top Easy Social Share Buttons menu where you have link when post is opened');
			}
			else {
				ESSBOptionsFramework::draw_title('Counter update information is not available', 'Time of counter update will appear once first time such is made when you load post. If you wish to make a manual counter update you can use the top Easy Social Share Buttons menu where you have link when post is opened');
			}
			ESSBOptionsFramework::draw_options_row_end();
			
			ESSBMetaboxInterface::draw_content_section_end();
		}
		
		if (essb_option_bool_value('activate_fake')) {
			ESSBMetaboxInterface::draw_content_section_start('fakecounter');
		
			ESSBOptionsFramework::reset_row_status();
			ESSBOptionsFramework::draw_heading(__('Manage Fake/Dummy Share Counters', 'essb'), '5');
			ESSBOptionsFramework::draw_hint('', __('Using fields below you can manage your internal (fake, dummy) counters - change or set new values. If you choose a list of networks below you will see just them. Otherwise all networks will appear.', 'essb'));
				
			$listOfNetworks = essb_available_social_networks();
			
			$fake_networks = essb_option_value('fake_networks');
			if (!is_array($fake_networks)) {
				$fake_networks = array();
			}
			
			$minimal_fake = get_option('essb-fake');
			if (!is_array($minimal_fake)) {
				$minimal_fake = array();
			}
			
			foreach ($listOfNetworks as $key => $data) {
				
				if (count($fake_networks) > 0 && !in_array($key, $fake_networks)) {
					continue; 
				}
				
				$minimal_fake_shares = isset($minimal_fake['fake_'.$key]) ? $minimal_fake['fake_'.$key] : '0';
				
				$value = isset ( $custom ["essb_pc_".$key] ) ? $custom ["essb_pc_".$key] [0] : "";
				
				$desc = '';
				if (intval($value) < intval($minimal_fake_shares)) {
					$desc = 'The current value is lower than the global minial shares: '.$minimal_fake_shares.'. In this case the minimal value will appear in front till post value become greater';
				}
				
				ESSBOptionsFramework::draw_options_row_start($data["name"], $desc);
				ESSBOptionsFramework::draw_input_field("essb_pc_".$key, true, 'essb_metabox', $value);
				ESSBOptionsFramework::draw_options_row_end();
			}
			
		
			ESSBMetaboxInterface::draw_content_section_end();
		}
		
		ESSBMetaboxInterface::draw_content_end();
		ESSBMetaboxInterface::draw_form_end();
	}
}

function essb_register_settings_metabox_visual() {
	global $post;
	
	if (isset ( $_GET ['action'] )) {
	
		$custom = get_post_custom ( $post->ID );
		//$essb_post_share_message = isset ( $custom ["essb_post_share_message"] ) ? $custom ["essb_post_share_message"] [0] : "";
		
		$essb_post_button_style = isset ( $custom ["essb_post_button_style"] ) ? $custom ["essb_post_button_style"] [0] : "";
		$essb_post_template = isset ( $custom ["essb_post_template"] ) ? $custom ["essb_post_template"] [0] : "";
		$essb_post_counters = isset ( $custom ["essb_post_counters"] ) ? $custom ["essb_post_counters"] [0] : "";
		$essb_post_counter_pos = isset ( $custom ["essb_post_counter_pos"] ) ? $custom ["essb_post_counter_pos"] [0] : "";
		$essb_post_total_counter_pos = isset ( $custom ["essb_post_total_counter_pos"] ) ? $custom ["essb_post_total_counter_pos"] [0] : "";
		$essb_post_customizer = isset ( $custom ["essb_post_customizer"] ) ? $custom ["essb_post_customizer"] [0] : "";
		$essb_post_animations = isset ( $custom ["essb_post_animations"] ) ? $custom ["essb_post_animations"] [0] : "";
		$essb_post_optionsbp = isset ( $custom ["essb_post_optionsbp"] ) ? $custom ["essb_post_optionsbp"] [0] : "";
		$essb_post_content_position = isset ( $custom ["essb_post_content_position"] ) ? $custom ["essb_post_content_position"] [0] : "";
		
		foreach (essb_available_button_positions() as $position => $name) {
			$essb_post_button_position_{$position} = isset ( $custom ["essb_post_button_position_".$position] ) ? $custom ["essb_post_button_position_".$position] [0] : "";
		}
		
		$essb_post_native = isset ( $custom ["essb_post_native"] ) ? $custom ["essb_post_native"] [0] : "";
		$essb_post_native_skin = isset ( $custom ["essb_post_native_skin"] ) ? $custom ["essb_post_native_skin"] [0] : "";
		
		ESSBMetaboxInterface::draw_form_start ( 'essb_social_share_visual' );
		$sidebar_options = array();
		
		$sidebar_options[] = array(
				'field_id' => 'visual1',
				'title' => __('Button Style', 'essb'),
				'icon' => 'default',
				'type' => 'menu_item',
				'action' => 'default',
				'default_child' => ''
		);
		
		$sidebar_options[] = array(
				'field_id' => 'visual2',
				'title' => __('Button Display', 'essb'),
				'icon' => 'default',
				'type' => 'menu_item',
				'action' => 'default',
				'default_child' => ''
		);
		
		$sidebar_options[] = array(
				'field_id' => 'visual3',
				'title' => __('Native Buttons', 'essb'),
				'icon' => 'default',
				'type' => 'menu_item',
				'action' => 'default',
				'default_child' => ''
		);
		
		$converted_button_styles = essb_avaiable_button_style();
		$converted_button_styles[""] = "Default style from settings";
		
		$converted_counter_pos = essb_avaliable_counter_positions();
		$converted_counter_pos[""] = "Default value from settings";

		$converted_total_counter_pos = essb_avaiable_total_counter_position();
		$converted_total_counter_pos[""] = "Default value from settings";
		
		$converted_content_position = array();//$essb_avaliable_content_positions;
		$converted_content_position[""] = "Default value from settings";
		$converted_content_position["no"] = "No display inside content (deactivate content positions)";
		foreach (essb_avaliable_content_positions() as $position => $data) {
			$converted_content_position[$position] = $data["label"];
		}
		
		$animations_container = array ();
		$animations_container[""] = "Default value from settings";
		foreach (essb_available_animations() as $key => $text) {
			if ($key != '') {
				$animations_container[$key] = $text;
			}
			else {
				$animations_container['no'] = 'No amination';
			}
		}
		
		$yesno_object = array();
		$yesno_object[""] = "Default value from settings";
		$yesno_object["yes"] = "Yes";
		$yesno_object["no"] = "No";
		//$converted_button_styles = array_unshift($converted_button_styles, array("" => "Default value from settings"));
		
		ESSBMetaboxInterface::draw_first_menu_activate('visual');
		ESSBMetaboxInterface::draw_sidebar($sidebar_options, 'visual');
		ESSBMetaboxInterface::draw_content_start('300', 'visual');		
		
		ESSBMetaboxInterface::draw_content_section_start('visual1');
		ESSBMetaboxOptionsFramework::reset_row_status();
		ESSBMetaboxOptionsFramework::draw_heading(__('Button Style', 'essb'), '3');
		
		ESSBMetaboxOptionsFramework::draw_options_row_start(__('Button style', 'essb'), __('Change default button style.', 'essb'));
		ESSBMetaboxOptionsFramework::draw_select_field('essb_post_button_style', $converted_button_styles, false, 'essb_metabox', $essb_post_button_style);
		ESSBMetaboxOptionsFramework::draw_options_row_end();

		ESSBMetaboxOptionsFramework::draw_options_row_start(__('Template', 'essb'), __('Change default template.', 'essb'));
		ESSBMetaboxOptionsFramework::draw_select_field('essb_post_template', essb_available_tempaltes4(true), false, 'essb_metabox', $essb_post_template);
		ESSBMetaboxOptionsFramework::draw_options_row_end();

		ESSBMetaboxOptionsFramework::draw_options_row_start(__('Counters', 'essb'), __('', 'essb'));
		ESSBMetaboxOptionsFramework::draw_select_field('essb_post_counters', $yesno_object, false, 'essb_metabox', $essb_post_counters);
		ESSBMetaboxOptionsFramework::draw_options_row_end();

		ESSBMetaboxOptionsFramework::draw_options_row_start(__('Counter position', 'essb'), __('', 'essb'));
		ESSBMetaboxOptionsFramework::draw_select_field('essb_post_counter_pos', $converted_counter_pos, false, 'essb_metabox', $essb_post_counter_pos);
		ESSBMetaboxOptionsFramework::draw_options_row_end();
		
		ESSBMetaboxOptionsFramework::draw_options_row_start(__('Total counter position', 'essb'), __('', 'essb'));
		ESSBMetaboxOptionsFramework::draw_select_field('essb_post_total_counter_pos', $converted_total_counter_pos, false, 'essb_metabox', $essb_post_total_counter_pos);
		ESSBMetaboxOptionsFramework::draw_options_row_end();

		ESSBMetaboxOptionsFramework::draw_options_row_start(__('Activate style customizer', 'essb'), __('', 'essb'));
		ESSBMetaboxOptionsFramework::draw_select_field('essb_post_customizer', $yesno_object, false, 'essb_metabox', $essb_post_customizer);
		ESSBMetaboxOptionsFramework::draw_options_row_end();

		ESSBMetaboxOptionsFramework::draw_options_row_start(__('Activate animations', 'essb'), __('', 'essb'));
		ESSBMetaboxOptionsFramework::draw_select_field('essb_post_animations', $animations_container, false, 'essb_metabox', $essb_post_animations);
		ESSBMetaboxOptionsFramework::draw_options_row_end();
		
		ESSBMetaboxOptionsFramework::draw_options_row_start(__('Activate options by button position', 'essb'), __('', 'essb'));
		ESSBMetaboxOptionsFramework::draw_select_field('essb_post_optionsbp', $yesno_object, false, 'essb_metabox', $essb_post_optionsbp);
		ESSBMetaboxOptionsFramework::draw_options_row_end();
		
		ESSBMetaboxInterface::draw_content_section_end();
		
		ESSBMetaboxInterface::draw_content_section_start('visual2');
		ESSBMetaboxOptionsFramework::reset_row_status();
		ESSBMetaboxOptionsFramework::draw_heading(__('Button Position', 'essb'), '3');
		
		ESSBMetaboxOptionsFramework::draw_options_row_start(__('Content position', 'essb'), __('Change default content position', 'essb'));
		ESSBMetaboxOptionsFramework::draw_select_field('essb_post_content_position', $converted_content_position, false, 'essb_metabox', $essb_post_content_position);
		ESSBMetaboxOptionsFramework::draw_options_row_end();
		
		foreach (essb_available_button_positions() as $position => $name) {
			ESSBMetaboxOptionsFramework::draw_options_row_start(__('Activate '.$name["label"], 'essb'), __('Activate additional display position', 'essb'));
			ESSBMetaboxOptionsFramework::draw_select_field('essb_post_button_position_'.$position, $yesno_object, false, 'essb_metabox', $essb_post_button_position_{$position});
			ESSBMetaboxOptionsFramework::draw_options_row_end();			
		}
		
		ESSBMetaboxInterface::draw_content_section_end();

		ESSBMetaboxInterface::draw_content_section_start('visual3');
		ESSBMetaboxOptionsFramework::reset_row_status();
		ESSBMetaboxOptionsFramework::draw_heading(__('Native Buttons', 'essb'), '3');
		
		ESSBMetaboxOptionsFramework::draw_options_row_start(__('Activate native buttons', 'essb'), __('', 'essb'));
		ESSBMetaboxOptionsFramework::draw_select_field('essb_post_native', $yesno_object, false, 'essb_metabox', $essb_post_native);
		ESSBMetaboxOptionsFramework::draw_options_row_end();

		ESSBMetaboxOptionsFramework::draw_options_row_start(__('Activate native buttons skin', 'essb'), __('', 'essb'));
		ESSBMetaboxOptionsFramework::draw_select_field('essb_post_native_skin', $yesno_object, false, 'essb_metabox', $essb_post_native_skin);
		ESSBMetaboxOptionsFramework::draw_options_row_end();		
		
		ESSBMetaboxInterface::draw_content_section_end();
		
		ESSBMetaboxInterface::draw_content_end();
		ESSBMetaboxInterface::draw_form_end ();
		
	}
}

function essb_register_settings_metabox_onoff() {
	global $post;
	
	if (isset ( $_GET ['action'] )) {

		$custom = get_post_custom ( $post->ID );
		$essb_off = isset ( $custom ["essb_off"] ) ?  $custom ["essb_off"] [0]: "false";
		$essb_pc_twitter = isset ( $custom ["essb_pc_twitter"] ) ?  $custom ["essb_pc_twitter"] [0]: "";
		
		$twitter_counters = essb_option_value('twitter_counters');
		
		ESSBMetaboxInterface::draw_form_start ( 'essb_global_metabox' );
		
		ESSBOptionsFramework::draw_section_start ();
		
		ESSBOptionsFramework::draw_options_row_start_full('inner-row');
		ESSBOptionsFramework::draw_title( __( 'Turn off Easy Social Share Buttons', 'essb' ), __ ( 'Turn off automatic button display for that post/page of social share buttons', 'essb' ), 'inner-row' );
		ESSBOptionsFramework::draw_options_row_end ();
		
		ESSBOptionsFramework::draw_options_row_start_full('inner-row-small');
		ESSBOptionsFramework::draw_switch_field ( 'essb_off', 'essb_metabox', $essb_off, __ ( 'Yes', 'essb' ), __ ( 'No', 'essb' ) );
		ESSBOptionsFramework::draw_options_row_end ();

		if ($twitter_counters == "self") {
			ESSBOptionsFramework::draw_options_row_start_full('inner-row');
			ESSBOptionsFramework::draw_title ( __ ( 'Twitter Internal Share Counter', 'essb' ), __ ( 'Customize value of Twitter internal share counter', 'essb' ), 'inner-row' );
			ESSBOptionsFramework::draw_options_row_end ();
			
			ESSBOptionsFramework::draw_options_row_start_full('inner-row-small');
			ESSBOptionsFramework::draw_input_field('essb_pc_twitter', true, 'essb_metabox', $essb_pc_twitter);
			ESSBOptionsFramework::draw_options_row_end ();
		}
		
		
		ESSBOptionsFramework::draw_section_end ();
		
		ESSBMetaboxInterface::draw_form_end ();
	}
}



function essb_register_settings_metabox_stats() {
	global $post, $essb_networks;
	
	if (isset ( $_GET ['action'] )) {
	
		$post_id = $post->ID;
		ESSBSocialShareAnalyticsBackEnd::init_addional_settings();
		
		// overall stats by social network
		$overall_stats = ESSBSocialShareAnalyticsBackEnd::essb_stats_by_networks ('', $post_id);
		$position_stats = ESSBSocialShareAnalyticsBackEnd::essb_stats_by_position('', $post_id);
		
		// print_r($overall_stats);
		
		$calculated_total = 0;
		$networks_with_data = array ();
		
		if (isset ( $overall_stats )) {
			$cnt = 0;
			foreach ( $essb_networks as $k => $v ) {
		
				$calculated_total += intval ( $overall_stats->{$k} );
				if (intval ( $overall_stats->{$k} ) != 0) {
					$networks_with_data [$k] = $k;
				}
			}
		}
		
		$device_stats = ESSBSocialShareAnalyticsBackEnd::essb_stats_by_device ('', $post_id);
		
		$essb_date_to = "";
		$essb_date_from = "";
		
		if ($essb_date_to == '') {
			$essb_date_to = date ( "Y-m-d" );
		}
		
		if ($essb_date_from == '') {
			$essb_date_from = date ( "Y-m-d", strtotime ( date ( "Y-m-d", strtotime ( date ( "Y-m-d" ) ) ) . "-1 month" ) );
		}
		
		$sqlMonthsData = ESSBSocialShareAnalyticsBackEnd::essb_stats_by_networks_by_date_for_post($essb_date_from, $essb_date_to, $post_id);
		
		
		?>
		<div class="essb-dashboard essb-metabox-dashboard">
		<!--  dashboard type2  -->
	<!--  dashboard overall  -->
	<div class="essb-dashboard-panel">
		
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
		
	<!--  end dashboard 2 -->
		<div class="essb-dashboard-panel">
		<div class="essb-dashboard-panel-title">
			<h4>Social activity for the last 30 days</h4>

		</div>
		<div class="essb-dashboard-panel-content">
			<?php ESSBSocialShareAnalyticsBackEnd::essb_stat_admin_detail_by_month ($sqlMonthsData, $networks_with_data, '', 'Date'); ?>
			</div>
	</div>

	<div class="clear"></div>
		</div>
		<?php 
	}
}

?>