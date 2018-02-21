<?php
/**
 * EasySocialShareButtons CoreExtender: Sharing
 *
 * @package   EasySocialShareButtons
 * @author    AppsCreo
 * @link      http://appscreo.com/
 * @copyright 2016 AppsCreo
 * @since 4.0
 *
 */

if (!function_exists('essb_sharing_prepare_mail')) {
	function essb_sharing_prepare_mail($post_share_details) {
		$base_subject = essb_option_value('mail_subject');
		$base_body = essb_option_value('mail_body');
		//print_r($post_share_details);
		
		if (isset($post_share_details['customized_mail'])) {
			$base_subject = $post_share_details['mail_subject'];
			$base_body = $post_share_details['mail_body'];
		}
		
		$base_subject = preg_replace(array('#%%title%%#', '#%%siteurl%%#', '#%%permalink%%#', '#%%image%%#', '#%%shorturl%%#'), array($post_share_details['title_plain'], get_site_url(), $post_share_details['url'], $post_share_details['image'], $post_share_details['short_url']), $base_subject);
		$base_body = preg_replace(array('#%%title%%#', '#%%siteurl%%#', '#%%permalink%%#', '#%%image%%#', '#%%shorturl%%#'), array($post_share_details['title_plain'], get_site_url(), $post_share_details['url'], $post_share_details['image'], $post_share_details['short_url']), $base_body);
			
		$post_share_details['mail_subject'] = $base_subject;
		$post_share_details['mail_body'] = $base_body;
			
		$ga_tracking = essb_option_value('activate_ga_campaign_tracking');
		if ($ga_tracking != '') {
			$post_share_details['mail_subject'] = str_replace('{network}', 'mail', $post_share_details['mail_subject']);
				
			$post_share_details['mail_body'] = str_replace('{title}', $post_share_details['title_plain'], $post_share_details['mail_body']);
			$post_share_details['mail_body'] = str_replace('{network}', 'mail', $post_share_details['mail_body']);
		}
		
		return $post_share_details;
	}
}