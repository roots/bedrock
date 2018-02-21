<?php
if (!function_exists('essb_rs_mailform_build')) {
	add_action('essb_rs_footer', 'essb_rs_mailform_build');
	
	function essb_rs_mailform_build() {
		global $post;
		
		$mail_salt_check = get_option(ESSB3_MAIL_SALT);
		
		$translate_mail_title = essb_option_value('translate_mail_title');
		$translate_mail_email = essb_option_value('translate_mail_email');
		$translate_mail_recipient = essb_option_value('translate_mail_recipient');
		$translate_mail_cancel = essb_option_value('translate_mail_cancel');
		$translate_mail_send = essb_option_value('translate_mail_send');
		$translate_mail_custom = essb_option_value('translate_mail_custom');
		
		$translate_mail_captcha = essb_option_value('translate_mail_captcha');
		
		$mail_popup_preview = essb_option_bool_value('mail_popup_preview');
		
		if ($translate_mail_title == '') $translate_mail_title = __('Send this to a friend', 'essb');
		if ($translate_mail_email == '') $translate_mail_email = __('Your email', 'essb');
		if ($translate_mail_recipient == '') $translate_mail_recipient = __('Recipient email', 'essb');
		if ($translate_mail_cancel == '') $translate_mail_cancel = __('Cancel', 'essb');
		if ($translate_mail_send == '') $translate_mail_send = __('Send', 'essb');
		if ($translate_mail_custom == '') $translate_mail_custom = __('Your message', 'essb');
		if ($translate_mail_captcha == '') $translate_mail_captcha = __('Fill captcha code', 'essb');
		
		$mail_captcha = essb_option_value('mail_captcha');
		$mail_popup_edit = essb_option_bool_value('mail_popup_edit');
		
		$code = '';
		
		$code .= '<div class="essb_mailform">';
		$code .= '<div class="essb_mailform_content">';
		$code .= '<p>'.$translate_mail_title.'</p>';
		$code .= '<label class="essb_mailform_content_label">'.$translate_mail_email.'</label>';
		$code .= '<input type="text" id="essb_mailform_from" class="essb_mailform_content_input" placeholder="'.$translate_mail_email.'"/>';
		$code .= '<label class="essb_mailform_content_label">'.$translate_mail_recipient.'</label>';
		$code .= '<input type="text" id="essb_mailform_to" class="essb_mailform_content_input" placeholder="'.$translate_mail_recipient.'"/>';
		
		if ($mail_popup_edit) {
			$code .= '<label class="essb_mailform_content_label">'.$translate_mail_custom.'</label>';
			$code .= '<textarea id="essb_mailform_custom" class="essb_mailform_content_input" placeholder="'.$translate_mail_custom.'"></textarea>';
				
		}
 		
		if ($mail_captcha != '') {
			$code .= '<label class="essb_mailform_content_label">'.$mail_captcha.'</label>';
			$code .= '<input type="text" id="essb_mailform_c" class="essb_mailform_content_input" placeholder="'.$translate_mail_captcha.'"/>';
		}
		
		if ($mail_popup_preview && isset($post)) {
			$message_body = essb_option_value('mail_body');
			$message_body = stripslashes($message_body);
				
			$url = get_permalink($post->ID);
			
			$base_post_url = $url;
				
			$site_url = get_site_url();
				
			$base_site_url = $site_url;
				
			$site_url = '<a href="'.$site_url.'">'.$site_url.'</a>';
			$url = '<a href="'.$url.'">'.$url.'</a>';
				
			$title = $post->post_title;
			$image = essb_core_get_post_featured_image($post->ID);
			$description = $post->post_excerpt;
				
			if ($image != '') {
				$image = '<img src="'.$image.'" />';
			}
			
			
			$parsed_address = parse_url($base_site_url);
				
			$message_body = preg_replace(array('#%%title%%#', '#%%siteurl%%#', '#%%permalink%%#', '#%%image%%#'), array($title, $site_url, $url, $image), $message_body);
				
			$message_body = str_replace("\r\n", "<br />", $message_body);
			
			$code .= '<div class="essb_mailform_preview">'.$message_body.'</div>';
		}
		
		$code .= '<div class="essb_mailform_content_buttons">';
		$code .= '<button id="essb_mailform_btn_submit" class="essb_mailform_content_button" onclick="essb_mailform_send();">'.$translate_mail_send.'</button>';
		$code .= '<button id="essb_mailform_btn_cancel" class="essb_mailform_content_button" onclick="essb_close_mailform(); return false;">'.$translate_mail_cancel.'</button>';
		$code .= '</div>';
		
		$code .= '<input type="hidden" id="essb_mail_salt" value="'.$mail_salt_check.'"/>';
		$code .= '<input type="hidden" id="essb_mail_instance" value=""/>';
		$code .= '<input type="hidden" id="essb_mail_post" value=""/>';
		
		$code .= '</div>';
		$code .= '</div>';
		$code .= '<div class="essb_mailform_shadow"></div>';

		echo $code;
	}
}

if (!function_exists('essb_rs_mailform_code')) {
	add_filter('essb_js_buffer_footer', 'essb_rs_mailform_code');
	
	function essb_rs_mailform_code($buffer) {
		$code = "";
		
		$code .= '		
var essb_mailform_opened = false;
function essb_open_mailform(unique_id) {
	jQuery.fn.extend({
		center: function () {
			return this.each(function() {
				var top = (jQuery(window).height() - jQuery(this).outerHeight()) / 2;
				var left = (jQuery(window).width() - jQuery(this).outerWidth()) / 2;
				jQuery(this).css({position:\'fixed\', margin:0, top: (top > 0 ? top : 0)+\'px\', left: (left > 0 ? left : 0)+\'px\'});
			});
		}
	});
		
	if (essb_mailform_opened) {
		essb_close_mailform(unique_id);
		return;
	}
		
	var sender_element = jQuery(".essb_"+unique_id);
	if (!sender_element.length) return;
	
	var sender_post_id = jQuery(sender_element).attr("data-essb-postid") || "";
	
	jQuery("#essb_mail_instance").val(unique_id);
	jQuery("#essb_mail_post").val(sender_post_id);
	
	var win_width = jQuery( window ).width();
	var win_height = jQuery(window).height();
	var doc_height = jQuery(\'document\').height();
		
	var base_width = 300;
	if (win_width < base_width) { base_width = win_width - 30; }
	var height_correction = 20;
		
	var element_class = ".essb_mailform";
	var element_class_shadow = ".essb_mailform_shadow";
		
	jQuery(element_class).css( { width: base_width+\'px\'});
		
	var popup_height = jQuery(element_class).outerHeight();
	if (popup_height > (win_height - 30)) {		
		jQuery(element_class).css( { height: (win_height - height_correction)+\'px\'});
	}
	
	jQuery("#essb_mailform_from").val("");
	jQuery("#essb_mailform_to").val("");
	if (jQuery("#essb_mailform_c").length)
		jQuery("#essb_mailform_c").val("");
		
	jQuery(element_class_shadow).css( { height: (win_height)+\'px\'});
	jQuery(element_class).center();
	jQuery(element_class).slideDown(200);
	jQuery(element_class_shadow).fadeIn(200);
	essb_mailform_opened = true;
	essb.tracking_only("", "mail", unique_id);
};
		
function essb_close_mailform() {
	var element_class = ".essb_mailform";
	var element_class_shadow = ".essb_mailform_shadow";
	jQuery(element_class).fadeOut(200);
	jQuery(element_class_shadow).fadeOut(200);
	essb_mailform_opened = false;
};		

function essb_mailform_send() {
	var sender_email = jQuery("#essb_mailform_from").val();
	var recepient_email = jQuery("#essb_mailform_to").val();
	var captcha_validate = jQuery("#essb_mailform_c").length ? true : false;
	var captcha = captcha_validate ? jQuery("#essb_mailform_c").val() : "";
	var custom_message = jQuery("#essb_mailform_custom").length ? jQuery("#essb_mailform_custom").val() : "";
	
	if (sender_email == "" || recepient_email == "" || (captcha == "" && captcha_validate)) {
		alert("Please fill all fields in form!");
		return;
	}
	
	var mail_salt = jQuery("#essb_mail_salt").val();
	var instance_post_id = jQuery("#essb_mail_post").val();
	
	console.log("mail salt = " + mail_salt);
	
	if (typeof(essb_settings) != "undefined") {
		jQuery.post(essb_settings.ajax_url, {
			"action": "essb_mail_action",
			"post_id": instance_post_id,
			"from": sender_email,
			"to": recepient_email,
			"c": captcha,
			"cu": custom_message,
			"salt": mail_salt,
			"nonce": essb_settings.essb3_nonce
			}, function (data) { if (data) {
				console.log(data);
				alert(data["message"]);
				
				if (data["code"] == "1") essb_close_mailform();
		}},\'json\');
	}
};
		
		';
		
		$code = trim(preg_replace('/\s+/', ' ', $code));
		
		return $buffer.$code;
	}
}