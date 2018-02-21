<?php
function essb_load_social_api_code($network = '') {

	if (essb_is_plugin_deactivated_on()) {
		return;
	}

	if ($network == 'facebook') {
		$facebook_lang = "en_US";
		$user_defined_language_code = essb_option_value('facebook_like_button_lang');
		if (!empty($user_defined_language_code)) {
			$facebook_lang = $user_defined_language_code;
		}

		$facebook_appid = "";
		$facebook_async = essb_option_bool_value('facebook_like_button_api_async') ? 'true' : 'false';

		$chat_app_id = essb_option_value('fbmessenger_appid');
		if ($chat_app_id != '') {
			$facebook_appid = $chat_app_id;
		}
		
		
		essb_socialapi_generate_facebook_api_code($facebook_lang, $facebook_appid, $facebook_async);
	}
	if ($network == 'google') {
		essb_socialapi_generate_google_api_code();
	}
	if ($network == 'vk') {
		$vk_application = essb_option_value('vklikeappid');
		essb_socialapi_generate_vk_api_code($vk_application);
	}
	if ($network == "pinterest") {
		essb_socialapi_generate_pinterst_code();
	}
	if ($network == "twitter") {
		essb_socialapi_generate_twitter_code();
	}
}


function essb_socialapi_generate_twitter_code() {
	echo '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+\'://platform.twitter.com/widgets.js\';fjs.parentNode.insertBefore(js,fjs);}}(document, \'script\', \'twitter-wjs\');</script>';
}

function essb_socialapi_generate_pinterst_code() {

	echo '
	<script type="text/javascript">
	(function() {
	var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
	po.src = \'//assets.pinterest.com/js/pinit.js\';
	var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
})();
</script>';
}

function essb_socialapi_generate_vk_api_code($appid = '') {
	echo '<script type="text/javascript" src="//vk.com/js/api/openapi.js?115"></script>
	<script type="text/javascript">
	VK.init({apiId: '.$appid.', onlyWidgets: true});
	</script>';
}

function essb_socialapi_generate_google_api_code() {

	echo '
	<script type="text/javascript">
	(function() {
	var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
	po.src = \'https://apis.google.com/js/platform.js\';
	var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
})();
</script>';
}

function essb_socialapi_generate_facebook_api_code($lang = 'en_US', $app_id = '', $async_load = 'false') {
	if ($app_id != '') {
		$app_id = "&appId=".$app_id;
	}

	$js_async = "";
	if ($async_load == 'true') {
		$js_async = " js.async = true;";
	}

	echo '<div id="fb-root"></div>
	<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id; '.$js_async.'
	js.src = "//connect.facebook.net/'.$lang.'/sdk.js#version=v2.11&xfbml=1'.$app_id.'"
	fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>';
}
