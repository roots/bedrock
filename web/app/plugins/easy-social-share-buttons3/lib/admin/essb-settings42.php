<?php

if (!function_exists('essb_display_status_message')) {
	function essb_display_status_message($title = '', $text = '', $icon = '', $additional_class = '') {
		echo '<div class="essb-header-status">';
		ESSBOptionsFramework::draw_hint($title, $text, $icon, 'status '.$additional_class);
		echo '</div>';		
	}
}

$is_for_firsttime = get_option ( ESSB3_FIRST_TIME_NAME );
if ($is_for_firsttime) {
	if ($is_for_firsttime == 'true') {
		include (ESSB3_PLUGIN_ROOT . 'lib/admin/essb-first-time.php');
		return;
	}
}

if (!defined('ESSB3_CACHED_COUNTERS')) {
	define('ESSB3_CACHED_COUNTERS', true);
	if (!class_exists('ESSBCachedCounters')) {
		include_once(ESSB3_PLUGIN_ROOT . 'lib/core/share-counters/essb-cached-counters.php');
	}
}

global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
global $essb_admin_options, $essb_options;
$essb_admin_options = get_option ( ESSB3_OPTIONS_NAME );
global $essb_networks;
$essb_networks = get_option ( ESSB3_NETWORK_LIST );
// if (! is_array ( $essb_networks )) {
$essb_networks = essb_available_social_networks ();

$purchase_code = ESSBOptionValuesHelper::options_value ( $essb_admin_options, 'purchase_code' );
// }

// print_r($essb_o;

// reset plugin settings to default
$reset_settings = isset ( $_REQUEST ['reset_settings'] ) ? $_REQUEST ['reset_settings'] : '';
if ($reset_settings == 'true') {
	$essb_admin_options = array ();
	$essb_options = array ();
	
	$default_options = 'eyJidXR0b25fc3R5bGUiOiJidXR0b24iLCJzdHlsZSI6IjMyIiwiZnVsbHdpZHRoX3NoYXJlX2J1dHRvbnNfY29sdW1ucyI6IjEiLCJuZXR3b3JrcyI6WyJmYWNlYm9vayIsInR3aXR0ZXIiLCJnb29nbGUiLCJwaW50ZXJlc3QiLCJsaW5rZWRpbiJdLCJuZXR3b3Jrc19vcmRlciI6WyJmYWNlYm9vayIsInR3aXR0ZXIiLCJnb29nbGUiLCJwaW50ZXJlc3QiLCJsaW5rZWRpbiIsImRpZ2ciLCJkZWwiLCJzdHVtYmxldXBvbiIsInR1bWJsciIsInZrIiwicHJpbnQiLCJtYWlsIiwiZmxhdHRyIiwicmVkZGl0IiwiYnVmZmVyIiwibG92ZSIsIndlaWJvIiwicG9ja2V0IiwieGluZyIsIm9rIiwibXdwIiwibW9yZSIsIndoYXRzYXBwIiwibWVuZWFtZSIsImJsb2dnZXIiLCJhbWF6b24iLCJ5YWhvb21haWwiLCJnbWFpbCIsImFvbCIsIm5ld3N2aW5lIiwiaGFja2VybmV3cyIsImV2ZXJub3RlIiwibXlzcGFjZSIsIm1haWxydSIsInZpYWRlbyIsImxpbmUiLCJmbGlwYm9hcmQiLCJjb21tZW50cyIsInl1bW1seSIsInNtcyIsInZpYmVyIiwidGVsZWdyYW0iLCJzdWJzY3JpYmUiLCJza3lwZSIsIm1lc3NlbmdlciIsImtha2FvdGFsayIsInNoYXJlIl0sIm1vcmVfYnV0dG9uX2Z1bmMiOiIxIiwibW9yZV9idXR0b25faWNvbiI6InBsdXMiLCJ0d2l0dGVyX3NoYXJlc2hvcnRfc2VydmljZSI6IndwIiwibWFpbF9mdW5jdGlvbiI6ImZvcm0iLCJ3aGF0c2FwcF9zaGFyZXNob3J0X3NlcnZpY2UiOiJ3cCIsImZsYXR0cl9sYW5nIjoic3FfQUwiLCJjb3VudGVyX3BvcyI6InJpZ2h0bSIsImZvcmNlX2NvdW50ZXJzX2FkbWluX3R5cGUiOiJ3cCIsInRvdGFsX2NvdW50ZXJfcG9zIjoibGVmdGJpZyIsInVzZXJfbmV0d29ya19uYW1lX2ZhY2Vib29rIjoiRmFjZWJvb2siLCJ1c2VyX25ldHdvcmtfbmFtZV90d2l0dGVyIjoiVHdpdHRlciIsInVzZXJfbmV0d29ya19uYW1lX2dvb2dsZSI6Ikdvb2dsZSsiLCJ1c2VyX25ldHdvcmtfbmFtZV9waW50ZXJlc3QiOiJQaW50ZXJlc3QiLCJ1c2VyX25ldHdvcmtfbmFtZV9saW5rZWRpbiI6IkxpbmtlZEluIiwidXNlcl9uZXR3b3JrX25hbWVfZGlnZyI6IkRpZ2ciLCJ1c2VyX25ldHdvcmtfbmFtZV9kZWwiOiJEZWwiLCJ1c2VyX25ldHdvcmtfbmFtZV9zdHVtYmxldXBvbiI6IlN0dW1ibGVVcG9uIiwidXNlcl9uZXR3b3JrX25hbWVfdHVtYmxyIjoiVHVtYmxyIiwidXNlcl9uZXR3b3JrX25hbWVfdmsiOiJWS29udGFrdGUiLCJ1c2VyX25ldHdvcmtfbmFtZV9wcmludCI6IlByaW50IiwidXNlcl9uZXR3b3JrX25hbWVfbWFpbCI6IkVtYWlsIiwidXNlcl9uZXR3b3JrX25hbWVfZmxhdHRyIjoiRmxhdHRyIiwidXNlcl9uZXR3b3JrX25hbWVfcmVkZGl0IjoiUmVkZGl0IiwidXNlcl9uZXR3b3JrX25hbWVfYnVmZmVyIjoiQnVmZmVyIiwidXNlcl9uZXR3b3JrX25hbWVfbG92ZSI6IkxvdmUgVGhpcyIsInVzZXJfbmV0d29ya19uYW1lX3dlaWJvIjoiV2VpYm8iLCJ1c2VyX25ldHdvcmtfbmFtZV9wb2NrZXQiOiJQb2NrZXQiLCJ1c2VyX25ldHdvcmtfbmFtZV94aW5nIjoiWGluZyIsInVzZXJfbmV0d29ya19uYW1lX29rIjoiT2Rub2tsYXNzbmlraSIsInVzZXJfbmV0d29ya19uYW1lX213cCI6Ik1hbmFnZVdQLm9yZyIsInVzZXJfbmV0d29ya19uYW1lX21vcmUiOiJNb3JlIEJ1dHRvbiIsInVzZXJfbmV0d29ya19uYW1lX3doYXRzYXBwIjoiV2hhdHNBcHAiLCJ1c2VyX25ldHdvcmtfbmFtZV9tZW5lYW1lIjoiTWVuZWFtZSIsInVzZXJfbmV0d29ya19uYW1lX2Jsb2dnZXIiOiJCbG9nZ2VyIiwidXNlcl9uZXR3b3JrX25hbWVfYW1hem9uIjoiQW1hem9uIiwidXNlcl9uZXR3b3JrX25hbWVfeWFob29tYWlsIjoiWWFob28gTWFpbCIsInVzZXJfbmV0d29ya19uYW1lX2dtYWlsIjoiR21haWwiLCJ1c2VyX25ldHdvcmtfbmFtZV9hb2wiOiJBT0wiLCJ1c2VyX25ldHdvcmtfbmFtZV9uZXdzdmluZSI6Ik5ld3N2aW5lIiwidXNlcl9uZXR3b3JrX25hbWVfaGFja2VybmV3cyI6IkhhY2tlck5ld3MiLCJ1c2VyX25ldHdvcmtfbmFtZV9ldmVybm90ZSI6IkV2ZXJub3RlIiwidXNlcl9uZXR3b3JrX25hbWVfbXlzcGFjZSI6Ik15U3BhY2UiLCJ1c2VyX25ldHdvcmtfbmFtZV9tYWlscnUiOiJNYWlsLnJ1IiwidXNlcl9uZXR3b3JrX25hbWVfdmlhZGVvIjoiVmlhZGVvIiwidXNlcl9uZXR3b3JrX25hbWVfbGluZSI6IkxpbmUiLCJ1c2VyX25ldHdvcmtfbmFtZV9mbGlwYm9hcmQiOiJGbGlwYm9hcmQiLCJ1c2VyX25ldHdvcmtfbmFtZV9jb21tZW50cyI6IkNvbW1lbnRzIiwidXNlcl9uZXR3b3JrX25hbWVfeXVtbWx5IjoiWXVtbWx5IiwiZ2FfdHJhY2tpbmdfbW9kZSI6InNpbXBsZSIsInR3aXR0ZXJfY2FyZF90eXBlIjoic3VtbWFyeSIsIm5hdGl2ZV9vcmRlciI6WyJnb29nbGUiLCJ0d2l0dGVyIiwiZmFjZWJvb2siLCJsaW5rZWRpbiIsInBpbnRlcmVzdCIsInlvdXR1YmUiLCJtYW5hZ2V3cCIsInZrIl0sImZhY2Vib29rX2xpa2VfdHlwZSI6Imxpa2UiLCJnb29nbGVfbGlrZV90eXBlIjoicGx1cyIsInR3aXR0ZXJfdHdlZXQiOiJmb2xsb3ciLCJwaW50ZXJlc3RfbmF0aXZlX3R5cGUiOiJmb2xsb3ciLCJza2luX25hdGl2ZV9za2luIjoiZmxhdCIsInByb2ZpbGVzX2J1dHRvbl90eXBlIjoic3F1YXJlIiwicHJvZmlsZXNfYnV0dG9uX2ZpbGwiOiJmaWxsIiwicHJvZmlsZXNfYnV0dG9uX3NpemUiOiJzbWFsbCIsInByb2ZpbGVzX2Rpc3BsYXlfcG9zaXRpb24iOiJsZWZ0IiwicHJvZmlsZXNfb3JkZXIiOlsidHdpdHRlciIsImZhY2Vib29rIiwiZ29vZ2xlIiwicGludGVyZXN0IiwiZm91cnNxdWFyZSIsInlhaG9vIiwic2t5cGUiLCJ5ZWxwIiwiZmVlZGJ1cm5lciIsImxpbmtlZGluIiwidmlhZGVvIiwieGluZyIsIm15c3BhY2UiLCJzb3VuZGNsb3VkIiwic3BvdGlmeSIsImdyb292ZXNoYXJrIiwibGFzdGZtIiwieW91dHViZSIsInZpbWVvIiwiZGFpbHltb3Rpb24iLCJ2aW5lIiwiZmxpY2tyIiwiNTAwcHgiLCJpbnN0YWdyYW0iLCJ3b3JkcHJlc3MiLCJ0dW1ibHIiLCJibG9nZ2VyIiwidGVjaG5vcmF0aSIsInJlZGRpdCIsImRyaWJiYmxlIiwic3R1bWJsZXVwb24iLCJkaWdnIiwiZW52YXRvIiwiYmVoYW5jZSIsImRlbGljaW91cyIsImRldmlhbnRhcnQiLCJmb3Jyc3QiLCJwbGF5IiwiemVycGx5Iiwid2lraXBlZGlhIiwiYXBwbGUiLCJmbGF0dHIiLCJnaXRodWIiLCJjaGltZWluIiwiZnJpZW5kZmVlZCIsIm5ld3N2aW5lIiwiaWRlbnRpY2EiLCJiZWJvIiwienluZ2EiLCJzdGVhbSIsInhib3giLCJ3aW5kb3dzIiwib3V0bG9vayIsImNvZGVyd2FsbCIsInRyaXBhZHZpc29yIiwiYXBwbmV0IiwiZ29vZHJlYWRzIiwidHJpcGl0IiwibGFueXJkIiwic2xpZGVzaGFyZSIsImJ1ZmZlciIsInJzcyIsInZrb250YWt0ZSIsImRpc3F1cyIsImhvdXp6IiwibWFpbCIsInBhdHJlb24iLCJwYXlwYWwiLCJwbGF5c3RhdGlvbiIsInNtdWdtdWciLCJzd2FybSIsInRyaXBsZWoiLCJ5YW1tZXIiLCJzdGFja292ZXJmbG93IiwiZHJ1cGFsIiwib2Rub2tsYXNzbmlraSIsImFuZHJvaWQiLCJtZWV0dXAiLCJwZXJzb25hIl0sImFmdGVyY2xvc2VfdHlwZSI6ImZvbGxvdyIsImFmdGVyY2xvc2VfbGlrZV9jb2xzIjoib25lY29sIiwiZXNtbF90dGwiOiIxIiwiZXNtbF9wcm92aWRlciI6InNoYXJlZGNvdW50IiwiZXNtbF9hY2Nlc3MiOiJtYW5hZ2Vfb3B0aW9ucyIsInNob3J0dXJsX3R5cGUiOiJ3cCIsImRpc3BsYXlfaW5fdHlwZXMiOlsicG9zdCJdLCJkaXNwbGF5X2V4Y2VycHRfcG9zIjoidG9wIiwidG9wYmFyX2J1dHRvbnNfYWxpZ24iOiJsZWZ0IiwidG9wYmFyX2NvbnRlbnRhcmVhX3BvcyI6ImxlZnQiLCJib3R0b21iYXJfYnV0dG9uc19hbGlnbiI6ImxlZnQiLCJib3R0b21iYXJfY29udGVudGFyZWFfcG9zIjoibGVmdCIsImZseWluX3Bvc2l0aW9uIjoicmlnaHQiLCJzaXNfbmV0d29ya19vcmRlciI6WyJmYWNlYm9vayIsInR3aXR0ZXIiLCJnb29nbGUiLCJsaW5rZWRpbiIsInBpbnRlcmVzdCIsInR1bWJsciIsInJlZGRpdCIsImRpZ2ciLCJkZWxpY2lvdXMiLCJ2a29udGFrdGUiLCJvZG5va2xhc3NuaWtpIl0sInNpc19zdHlsZSI6ImZsYXQtc21hbGwiLCJzaXNfYWxpZ25feCI6ImxlZnQiLCJzaXNfYWxpZ25feSI6InRvcCIsInNpc19vcmllbnRhdGlvbiI6Imhvcml6b250YWwiLCJtb2JpbGVfc2hhcmVidXR0b25zYmFyX2NvdW50IjoiMiIsInNoYXJlYmFyX2NvdW50ZXJfcG9zIjoiaW5zaWRlIiwic2hhcmViYXJfdG90YWxfY291bnRlcl9wb3MiOiJiZWZvcmUiLCJzaGFyZWJhcl9uZXR3b3Jrc19vcmRlciI6WyJmYWNlYm9va3xGYWNlYm9vayIsInR3aXR0ZXJ8VHdpdHRlciIsImdvb2dsZXxHb29nbGUrIiwicGludGVyZXN0fFBpbnRlcmVzdCIsImxpbmtlZGlufExpbmtlZEluIiwiZGlnZ3xEaWdnIiwiZGVsfERlbCIsInN0dW1ibGV1cG9ufFN0dW1ibGVVcG9uIiwidHVtYmxyfFR1bWJsciIsInZrfFZLb250YWt0ZSIsInByaW50fFByaW50IiwibWFpbHxFbWFpbCIsImZsYXR0cnxGbGF0dHIiLCJyZWRkaXR8UmVkZGl0IiwiYnVmZmVyfEJ1ZmZlciIsImxvdmV8TG92ZSBUaGlzIiwid2VpYm98V2VpYm8iLCJwb2NrZXR8UG9ja2V0IiwieGluZ3xYaW5nIiwib2t8T2Rub2tsYXNzbmlraSIsIm13cHxNYW5hZ2VXUC5vcmciLCJtb3JlfE1vcmUgQnV0dG9uIiwid2hhdHNhcHB8V2hhdHNBcHAiLCJtZW5lYW1lfE1lbmVhbWUiLCJibG9nZ2VyfEJsb2dnZXIiLCJhbWF6b258QW1hem9uIiwieWFob29tYWlsfFlhaG9vIE1haWwiLCJnbWFpbHxHbWFpbCIsImFvbHxBT0wiLCJuZXdzdmluZXxOZXdzdmluZSIsImhhY2tlcm5ld3N8SGFja2VyTmV3cyIsImV2ZXJub3RlfEV2ZXJub3RlIiwibXlzcGFjZXxNeVNwYWNlIiwibWFpbHJ1fE1haWwucnUiLCJ2aWFkZW98VmlhZGVvIiwibGluZXxMaW5lIiwiZmxpcGJvYXJkfEZsaXBib2FyZCIsImNvbW1lbnRzfENvbW1lbnRzIiwieXVtbWx5fFl1bW1seSIsInNtc3xTTVMiLCJ2aWJlcnxWaWJlciIsInRlbGVncmFtfFRlbGVncmFtIiwic3Vic2NyaWJlfFN1YnNjcmliZSIsInNreXBlfFNreXBlIiwibWVzc2VuZ2VyfEZhY2Vib29rIE1lc3NlbmdlciIsImtha2FvdGFsa3xLYWthbyIsInNoYXJlfFNoYXJlIl0sInNoYXJlcG9pbnRfY291bnRlcl9wb3MiOiJpbnNpZGUiLCJzaGFyZXBvaW50X3RvdGFsX2NvdW50ZXJfcG9zIjoiYmVmb3JlIiwic2hhcmVwb2ludF9uZXR3b3Jrc19vcmRlciI6WyJmYWNlYm9va3xGYWNlYm9vayIsInR3aXR0ZXJ8VHdpdHRlciIsImdvb2dsZXxHb29nbGUrIiwicGludGVyZXN0fFBpbnRlcmVzdCIsImxpbmtlZGlufExpbmtlZEluIiwiZGlnZ3xEaWdnIiwiZGVsfERlbCIsInN0dW1ibGV1cG9ufFN0dW1ibGVVcG9uIiwidHVtYmxyfFR1bWJsciIsInZrfFZLb250YWt0ZSIsInByaW50fFByaW50IiwibWFpbHxFbWFpbCIsImZsYXR0cnxGbGF0dHIiLCJyZWRkaXR8UmVkZGl0IiwiYnVmZmVyfEJ1ZmZlciIsImxvdmV8TG92ZSBUaGlzIiwid2VpYm98V2VpYm8iLCJwb2NrZXR8UG9ja2V0IiwieGluZ3xYaW5nIiwib2t8T2Rub2tsYXNzbmlraSIsIm13cHxNYW5hZ2VXUC5vcmciLCJtb3JlfE1vcmUgQnV0dG9uIiwid2hhdHNhcHB8V2hhdHNBcHAiLCJtZW5lYW1lfE1lbmVhbWUiLCJibG9nZ2VyfEJsb2dnZXIiLCJhbWF6b258QW1hem9uIiwieWFob29tYWlsfFlhaG9vIE1haWwiLCJnbWFpbHxHbWFpbCIsImFvbHxBT0wiLCJuZXdzdmluZXxOZXdzdmluZSIsImhhY2tlcm5ld3N8SGFja2VyTmV3cyIsImV2ZXJub3RlfEV2ZXJub3RlIiwibXlzcGFjZXxNeVNwYWNlIiwibWFpbHJ1fE1haWwucnUiLCJ2aWFkZW98VmlhZGVvIiwibGluZXxMaW5lIiwiZmxpcGJvYXJkfEZsaXBib2FyZCIsImNvbW1lbnRzfENvbW1lbnRzIiwieXVtbWx5fFl1bW1seSIsInNtc3xTTVMiLCJ2aWJlcnxWaWJlciIsInRlbGVncmFtfFRlbGVncmFtIiwic3Vic2NyaWJlfFN1YnNjcmliZSIsInNreXBlfFNreXBlIiwibWVzc2VuZ2VyfEZhY2Vib29rIE1lc3NlbmdlciIsImtha2FvdGFsa3xLYWthbyIsInNoYXJlfFNoYXJlIl0sInNoYXJlYm90dG9tX25ldHdvcmtzX29yZGVyIjpbImZhY2Vib29rfEZhY2Vib29rIiwidHdpdHRlcnxUd2l0dGVyIiwiZ29vZ2xlfEdvb2dsZSsiLCJwaW50ZXJlc3R8UGludGVyZXN0IiwibGlua2VkaW58TGlua2VkSW4iLCJkaWdnfERpZ2ciLCJkZWx8RGVsIiwic3R1bWJsZXVwb258U3R1bWJsZVVwb24iLCJ0dW1ibHJ8VHVtYmxyIiwidmt8VktvbnRha3RlIiwicHJpbnR8UHJpbnQiLCJtYWlsfEVtYWlsIiwiZmxhdHRyfEZsYXR0ciIsInJlZGRpdHxSZWRkaXQiLCJidWZmZXJ8QnVmZmVyIiwibG92ZXxMb3ZlIFRoaXMiLCJ3ZWlib3xXZWlibyIsInBvY2tldHxQb2NrZXQiLCJ4aW5nfFhpbmciLCJva3xPZG5va2xhc3NuaWtpIiwibXdwfE1hbmFnZVdQLm9yZyIsIm1vcmV8TW9yZSBCdXR0b24iLCJ3aGF0c2FwcHxXaGF0c0FwcCIsIm1lbmVhbWV8TWVuZWFtZSIsImJsb2dnZXJ8QmxvZ2dlciIsImFtYXpvbnxBbWF6b24iLCJ5YWhvb21haWx8WWFob28gTWFpbCIsImdtYWlsfEdtYWlsIiwiYW9sfEFPTCIsIm5ld3N2aW5lfE5ld3N2aW5lIiwiaGFja2VybmV3c3xIYWNrZXJOZXdzIiwiZXZlcm5vdGV8RXZlcm5vdGUiLCJteXNwYWNlfE15U3BhY2UiLCJtYWlscnV8TWFpbC5ydSIsInZpYWRlb3xWaWFkZW8iLCJsaW5lfExpbmUiLCJmbGlwYm9hcmR8RmxpcGJvYXJkIiwiY29tbWVudHN8Q29tbWVudHMiLCJ5dW1tbHl8WXVtbWx5Iiwic21zfFNNUyIsInZpYmVyfFZpYmVyIiwidGVsZWdyYW18VGVsZWdyYW0iLCJzdWJzY3JpYmV8U3Vic2NyaWJlIiwic2t5cGV8U2t5cGUiLCJtZXNzZW5nZXJ8RmFjZWJvb2sgTWVzc2VuZ2VyIiwia2FrYW90YWxrfEtha2FvIiwic2hhcmV8U2hhcmUiXSwiY29udGVudF9wb3NpdGlvbiI6ImNvbnRlbnRfYm90dG9tIiwiZXNzYl9jYWNoZV9tb2RlIjoiZnVsbCIsInR1cm5vZmZfZXNzYl9hZHZhbmNlZF9ib3giOiJ0cnVlIiwiZXNzYl9hY2Nlc3MiOiJtYW5hZ2Vfb3B0aW9ucyIsImFwcGx5X2NsZWFuX2J1dHRvbnNfbWV0aG9kIjoiZGVmYXVsdCIsIm1haWxfc3ViamVjdCI6IlZpc2l0IHRoaXMgc2l0ZSAlJXNpdGV1cmwlJSIsIm1haWxfYm9keSI6IkhpLCB0aGlzIG1heSBiZSBpbnRlcmVzdGluZyB5b3U6ICUldGl0bGUlJSEgVGhpcyBpcyB0aGUgbGluazogJSVwZXJtYWxpbmslJSIsImZhY2Vib29rdG90YWwiOiJ0cnVlIiwiYWN0aXZhdGVfdG90YWxfY291bnRlcl90ZXh0Ijoic2hhcmVzIiwiZnVsbHdpZHRoX2FsaWduIjoibGVmdCIsInR3aXR0ZXJfbWVzc2FnZV9vcHRpbWl6ZV9tZXRob2QiOiIxIiwibWFpbF9mdW5jdGlvbl9jb21tYW5kIjoiaG9zdCIsIm1haWxfZnVuY3Rpb25fc2VjdXJpdHkiOiJsZXZlbDEiLCJ0d2l0dGVyX2NvdW50ZXJzIjoic2VsZiIsImNhY2hlX2NvdW50ZXJfcmVmcmVzaCI6IjEiLCJ0d2l0dGVyX3NoYXJlc2hvcnQiOiJ0cnVlIiwidXNlcl9uZXR3b3JrX25hbWVfc21zIjoiU01TIiwidXNlcl9uZXR3b3JrX25hbWVfdmliZXIiOiJWaWJlciIsInVzZXJfbmV0d29ya19uYW1lX3RlbGVncmFtIjoiVGVsZWdyYW0iLCJ1c2VyX25ldHdvcmtfbmFtZV9zdWJzY3JpYmUiOiJTdWJzY3JpYmUiLCJ1c2VyX25ldHdvcmtfbmFtZV9za3lwZSI6IlNreXBlIiwidXNlcl9uZXR3b3JrX25hbWVfbWVzc2VuZ2VyIjoiRmFjZWJvb2sgTWVzc2VuZ2VyIiwidXNlcl9uZXR3b3JrX25hbWVfa2FrYW90YWxrIjoiS2FrYW8iLCJ1c2VyX25ldHdvcmtfbmFtZV9zaGFyZSI6IlNoYXJlIiwic2hhcmVfYnV0dG9uX2Z1bmMiOiIxIiwic2hhcmVfYnV0dG9uX2NvdW50ZXIiOiJoaWRkZW4iLCJzdWJzY3JpYmVfZnVuY3Rpb24iOiJmb3JtIiwic3Vic2NyaWJlX29wdGluX2Rlc2lnbiI6ImRlc2lnbjEiLCJzdWJzY3JpYmVfb3B0aW5fZGVzaWduX3BvcHVwIjoiZGVzaWduMSIsImNvdW50ZXJfbW9kZSI6IjM2MCIsIm9wZW5ncmFwaF90YWdzIjoidHJ1ZSIsImFmZndwX2FjdGl2ZV9tb2RlIjoiaWQiLCJzaXNfcG9zaXRpb24iOiJ0b3AtbGVmdCIsImhlcm9zaGFyZV9zZWNvbmRfdHlwZSI6InRvcCIsInBvc3RiYXJfYnV0dG9uX3N0eWxlIjoicmVjb21tZW5kZWQiLCJwb3N0YmFyX2NvdW50ZXJfcG9zIjoiaGlkZGVuIiwicG9pbnRfcG9zaXRpb24iOiJib3R0b21yaWdodCIsInBvaW50X29wZW5fYXV0byI6Im5vIiwicG9pbnRfc3R5bGUiOiJzaW1wbGUiLCJwb2ludF9zaGFwZSI6InJvdW5kIiwicG9pbnRfYnV0dG9uX3N0eWxlIjoicmVjb21tZW5kZWQiLCJwb2ludF90ZW1wbGF0ZSI6IjYiLCJwb2ludF9jb3VudGVyX3BvcyI6Imluc2lkZSIsIm1vYmlsZV9uZXR3b3Jrc19vcmRlciI6WyJmYWNlYm9va3xGYWNlYm9vayIsInR3aXR0ZXJ8VHdpdHRlciIsImdvb2dsZXxHb29nbGUrIiwicGludGVyZXN0fFBpbnRlcmVzdCIsImxpbmtlZGlufExpbmtlZEluIiwiZGlnZ3xEaWdnIiwiZGVsfERlbCIsInN0dW1ibGV1cG9ufFN0dW1ibGVVcG9uIiwidHVtYmxyfFR1bWJsciIsInZrfFZLb250YWt0ZSIsInByaW50fFByaW50IiwibWFpbHxFbWFpbCIsImZsYXR0cnxGbGF0dHIiLCJyZWRkaXR8UmVkZGl0IiwiYnVmZmVyfEJ1ZmZlciIsImxvdmV8TG92ZSBUaGlzIiwid2VpYm98V2VpYm8iLCJwb2NrZXR8UG9ja2V0IiwieGluZ3xYaW5nIiwib2t8T2Rub2tsYXNzbmlraSIsIm13cHxNYW5hZ2VXUC5vcmciLCJtb3JlfE1vcmUgQnV0dG9uIiwid2hhdHNhcHB8V2hhdHNBcHAiLCJtZW5lYW1lfE1lbmVhbWUiLCJibG9nZ2VyfEJsb2dnZXIiLCJhbWF6b258QW1hem9uIiwieWFob29tYWlsfFlhaG9vIE1haWwiLCJnbWFpbHxHbWFpbCIsImFvbHxBT0wiLCJuZXdzdmluZXxOZXdzdmluZSIsImhhY2tlcm5ld3N8SGFja2VyTmV3cyIsImV2ZXJub3RlfEV2ZXJub3RlIiwibXlzcGFjZXxNeVNwYWNlIiwibWFpbHJ1fE1haWwucnUiLCJ2aWFkZW98VmlhZGVvIiwibGluZXxMaW5lIiwiZmxpcGJvYXJkfEZsaXBib2FyZCIsImNvbW1lbnRzfENvbW1lbnRzIiwieXVtbWx5fFl1bW1seSIsInNtc3xTTVMiLCJ2aWJlcnxWaWJlciIsInRlbGVncmFtfFRlbGVncmFtIiwic3Vic2NyaWJlfFN1YnNjcmliZSIsInNreXBlfFNreXBlIiwibWVzc2VuZ2VyfEZhY2Vib29rIE1lc3NlbmdlciIsImtha2FvdGFsa3xLYWthbyIsInNoYXJlfFNoYXJlIl0sImFmdGVyc2hhcmVfb3B0aW5fZGVzaWduIjoiZGVzaWduMSIsInNob3J0dXJsX2JpdGx5YXBpX3ZlcnNpb24iOiJwcmV2aW91cyIsInVzZV9taW5pZmllZF9jc3MiOiJ0cnVlIiwidXNlX21pbmlmaWVkX2pzIjoidHJ1ZSIsImxvYWRfanNfYXN5bmMiOiJ0cnVlIiwiY291bnRlcl9yZWNvdmVyX21vZGUiOiJ1bmNoYW5nZWQiLCJjb3VudGVyX3JlY292ZXJfcHJvdG9jb2wiOiJ1bmNoYW5nZWQifQ==';
	
	$options_base = ESSB_Manager::convert_ready_made_option ( $default_options );
	// print_r($options_base);
	if ($options_base) {
		$essb_options = $options_base;
		$essb_admin_options = $options_base;
	}
	update_option ( ESSB3_OPTIONS_NAME, $essb_admin_options );
}

$dismiss_welcome = isset($_REQUEST['dismiss-welcome']) ? $_REQUEST['dismiss-welcome'] : '';
if ($dismiss_welcome == 'true') {
	$essb_options['disable_welcome'] = 'true';
	update_option ( ESSB3_OPTIONS_NAME, $essb_options );
}


$full_counter_update = isset($_REQUEST['essb_clear_cached_counters']) ? $_REQUEST['essb_clear_cached_counters'] : '';
if ($full_counter_update == 'true') {
	delete_post_meta_by_key('essb_cache_expire');
}

global $essb_admin_options_fanscounter;
$essb_admin_options_fanscounter = get_option ( ESSB3_OPTIONS_NAME_FANSCOUNTER );

if (! is_array ( $essb_admin_options_fanscounter )) {
	if (! class_exists ( 'ESSBSocialFollowersCounterHelper' )) {
		include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-followers-counter/essb-social-followers-counter-helper.php');
	}
	
	$essb_admin_options_fanscounter = ESSBSocialFollowersCounterHelper::create_default_options_from_structure ( ESSBSocialFollowersCounterHelper::options_structure () );
	update_option ( ESSB3_OPTIONS_NAME_FANSCOUNTER, $essb_admin_options_fanscounter );
}

// print "options are:";
// print_r($essb_admin_options);

if (count ( $essb_navigation_tabs ) > 0) {
	
	$tab_1 = key ( $essb_navigation_tabs );
}

if ($tab_1 == '') {
	//if (essb_show_welcome()) {
	//	$tab_1 = "welcome";
	//}
	//else {
		$tab_1 = 'social';
	//}
}

global $current_tab;
$current_tab = (empty ( $_GET ['tab'] )) ? $tab_1 : sanitize_text_field ( urldecode ( $_GET ['tab'] ) );
$purge_cache = isset ( $_REQUEST ['purge-cache'] ) ? $_REQUEST ['purge-cache'] : '';
$rebuild_resource = isset ( $_REQUEST ['rebuild-resource'] ) ? $_REQUEST ['rebuild-resource'] : '';

$dismiss_addon = isset ( $_REQUEST ['dismiss'] ) ? $_REQUEST ['dismiss'] : '';
if ($dismiss_addon == "true") {
	$dismiss_addon = isset ( $_REQUEST ['addon'] ) ? $_REQUEST ['addon'] : '';
	$addons = ESSBAddonsHelper::get_instance ();
	
	$addons->dismiss_addon_notice ( $dismiss_addon );
}

$active_settings_page = isset ( $_REQUEST ['page'] ) ? $_REQUEST ['page'] : '';
if (strpos ( $active_settings_page, 'essb_redirect_' ) !== false) {
	$options_page = str_replace ( 'essb_redirect_', '', $active_settings_page );
	// print $options_page;
	// print admin_url ( 'admin.php?page=essb_options&tab=' . $options_page );
	if ($options_page != '') {
		$current_tab = $options_page;
	}
}


$tabs = $essb_navigation_tabs;
$section = $essb_sidebar_sections [$current_tab];
$options = $essb_section_options [$current_tab];

// cache is running
$general_cache_active = ESSBOptionValuesHelper::options_bool_value ( $essb_admin_options, 'essb_cache' );
$general_cache_active_static = ESSBOptionValuesHelper::options_bool_value ( $essb_admin_options, 'essb_cache_static' );
$general_cache_active_static_js = ESSBOptionValuesHelper::options_bool_value ( $essb_admin_options, 'essb_cache_static_js' );
$general_cache_mode = ESSBOptionValuesHelper::options_value ( $essb_admin_options, 'essb_cache_mode' );
$is_cache_active = false;

$general_precompiled_resources = ESSBOptionValuesHelper::options_bool_value ( $essb_admin_options, 'precompiled_resources' );

$display_cache_mode = "";
if ($general_cache_active) {
	if ($general_cache_mode == "full") {
		$display_cache_mode = __("Cache button render and dynamic resources", "essb");
	} else if ($general_cache_mode == "resource") {
		$display_cache_mode = __("Cache only dynamic resources", "essb");
	} else {
		$display_cache_mode = __("Cache only button render", "essb");
	}
	$is_cache_active = true;
}

if ($general_cache_active_static || $general_cache_active_static_js) {
	if ($display_cache_mode != '') {
		$display_cache_mode .= ", ";
	}
	$display_cache_mode .= __("Combine into sigle file all plugin static CSS files", "essb");
	$is_cache_active = true;
}

?>
<!--  sweet alerts -->
<script src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/sweetalert.min.js"></script> 
<link rel="stylesheet" type="text/css" href="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/sweetalert.css">
<!--  code mirror include -->


<link rel=stylesheet
	href="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/codemirror.css">
<script
	src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/codemirror.js"></script>
<script
	src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/mode/xml/xml.js"></script>
<script
	src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/mode/javascript/javascript.js"></script>
<script
	src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/mode/css/css.js"></script>
<script
	src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<script
	src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/edit/matchbrackets.js"></script>
<script
	src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/edit/closebrackets.js"></script>
<script
	src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/edit/matchtags.js"></script>
<script
	src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/edit/closetag.js"></script>
<script
	src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/fold/foldcode.js"></script>
<script
	src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/fold/foldgutter.js"></script>
<script
	src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/fold/indent-fold.js"></script>
<script
	src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/fold/xml-fold.js"></script>
<script
	src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/fold/brace-fold.js"></script>
<script
	src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/fold/comment-fold.js"></script>
	
	
<div class="wrap essb-settings-wrap essb-wrap-<?php echo $current_tab; ?>">

<?php

// admin check for activation

if (class_exists ( 'ESSBAdminActivate' )) {
	
	$dismissactivate = isset ( $_REQUEST ['dismissactivate'] ) ? $_REQUEST ['dismissactivate'] : '';
	if ($dismissactivate == "true") {
		ESSBAdminActivate::dismiss_notice ();
	} else {
		if (! ESSBAdminActivate::is_activated () && ESSBAdminActivate::should_display_notice ()) {
			ESSBAdminActivate::notice_activate ();
		}
	}
	
	ESSBAdminActivate::notice_manager();
	
	$deactivate_appscreo = essb_options_bool_value('deactivate_appscreo');
	if (!$deactivate_appscreo) {
		ESSBAdminActivate::notice_new_addons();
	}
}

if (class_exists('ESSBAddonsHelper')) {
	$essb_addons = ESSBAddonsHelper::get_instance ();
	$essb_addons->get_new_addons();
}

// @since 3.2.4
// Twitter Counter Recovery
if (ESSBTwitterCounterRecovery::recovery_called ()) {
	ESSBTwitterCounterRecovery::recovery_start ();
}

/*if (ESSB3_ADDONS_ACTIVE && class_exists ( 'ESSBAddonsHelper' )) {
	$addons = ESSBAddonsHelper::get_instance ();
	$new_addons = $addons->get_new_addons ();
	
	foreach ( $new_addons as $key => $data ) {
		$all_addons_button = '<a href="' . admin_url ( "admin.php?page=essb_addons" ) . '"  text="' . __ ( 'Extensions', 'essb' ) . '" class="status_button float_right" style="margin-right: 5px;"><i class="fa fa-gear"></i>&nbsp;' . __ ( 'View list of all extensions', 'essb' ) . '</a>';
		
		$dismiss_url = esc_url_raw ( add_query_arg ( array ('dismiss' => 'true', 'addon' => $key ), admin_url ( "admin.php?page=essb_options" ) ) );
		
		$dismiss_addons_button = '<a href="' . $dismiss_url . '"  text="' . __ ( 'Extensions', 'essb' ) . '" class="status_button float_right" style="margin-right: 5px;"><i class="fa fa-close"></i>&nbsp;' . __ ( 'Dismiss', 'essb' ) . '</a>';
		//printf ( '<div class="essb-information-box fade"><div class="icon orange"><i class="fa fa-cube"></i></div><div class="inner">New add-on for Easy Social Share Buttons for WordPress is available: <a href="%2$s" target="_blank"><b>%1$s</b></a> %4$s%3$s</div></div>', $data ['title'], $data ['url'], $all_addons_button, $dismiss_addons_button );
		ESSBOptionsFramework::draw_hint(__('New addon available!', 'essb'), sprintf('New add-on for Easy Social Share Buttons for WordPress is available: <a href="%2$s" target="_blank"><b>%1$s</b></a> %4$s%3$s', $data ['title'], $data ['url'], $all_addons_button, $dismiss_addons_button), 'fa fa-cube', 'status essb-status-addon');
	}
}*/

$cache_plugin_message = "";
if (ESSBCacheDetector::is_cache_plugin_detected ()) {
	$cache_plugin_message = __(" Cache plugin detected running on site: ", "essb") . ESSBCacheDetector::cache_plugin_name ();
}

$backup = isset ( $_REQUEST ['backup'] ) ? $_REQUEST ['backup'] : '';
$settings_update = isset ( $_REQUEST ['settings-updated'] ) ? $_REQUEST ['settings-updated'] : '';
if ($settings_update == "true") {
	// printf('<div class="updated" style="padding: 10px;">%1$s</div>', __('Easy
	// Social Share Buttons options are saved!', 'essb'));
	//printf ( '<div class="essb-information-box"><div class="icon"><i class="fa fa-info-circle"></i></div><div class="inner"><b>%1$s</b></div></div>', __ ( 'Easy Social Share Buttons options are saved!' . $cache_plugin_message, 'essb' ) );
	//ESSBOptionsFramework::draw_hint(__('Options are saved!', 'essb'), 'Your new setup is ready to use. If you use cache plugin (example: W3 Total Cache, WP Super Cache, WP Rocket) or optimization plugin (example: Autoptimize, BWP Minify) it is highly recommended to clear cache or you may not see the changes. '.$cache_plugin_message, 'fa fa-info-circle', 'status essb-status-update');
	essb_display_status_message(__('Options are saved!', 'essb'), 'Your new setup is ready to use. If you use cache plugin (example: W3 Total Cache, WP Super Cache, WP Rocket) or optimization plugin (example: Autoptimize, BWP Minify) it is highly recommended to clear cache or you may not see the changes. '.$cache_plugin_message, 'fa fa-info-circle', 'essb-status-update');
	
}
$settings_imported = isset ( $_REQUEST ['settings-imported'] ) ? $_REQUEST ['settings-imported'] : '';
if ($settings_imported == "true") {
	// printf('<div class="updated" style="padding: 10px;">%1$s</div>', __('Easy
	// Social Share Buttons options are saved!', 'essb'));
	//printf ( '<div class="essb-information-box"><div class="icon"><i class="fa fa-info-circle"></i></div><div class="inner">%1$s</div></div>', __ ( 'Easy Social Share Buttons options are imported!' . $cache_plugin_message, 'essb' ) );
	//ESSBOptionsFramework::draw_hint(__('Options are imported!', 'essb'), 'If you use cache plugin (example: W3 Total Cache, WP Super Cache, WP Rocket) or optimization plugin (example: Autoptimize, BWP Minify) it is highly recommended to clear cache or you may not see the changes. '.$cache_plugin_message, 'fa fa-info-circle', 'status');
	essb_display_status_message(__('Options are imported!', 'essb'), 'If you use cache plugin (example: W3 Total Cache, WP Super Cache, WP Rocket) or optimization plugin (example: Autoptimize, BWP Minify) it is highly recommended to clear cache or you may not see the changes. '.$cache_plugin_message, 'fa fa-info-circle');
	
}
if ($reset_settings == 'true') {
	//printf ( '<div class="essb-information-box"><div class="icon"><i class="fa fa-gear"></i></div><div class="inner">%1$s</div></div>', __ ( 'Plugin settings are restored to default.' . $cache_plugin_message, 'essb' ) );
	//ESSBOptionsFramework::draw_hint(__('Options are reset to default!', 'essb'), 'If you use cache plugin (example: W3 Total Cache, WP Super Cache, WP Rocket) or optimization plugin (example: Autoptimize, BWP Minify) it is highly recommended to clear cache or you may not see the changes. '.$cache_plugin_message, 'fa fa-info-circle', 'status');
	essb_display_status_message(__('Options are reset to default!', 'essb'), 'If you use cache plugin (example: W3 Total Cache, WP Super Cache, WP Rocket) or optimization plugin (example: Autoptimize, BWP Minify) it is highly recommended to clear cache or you may not see the changes. '.$cache_plugin_message, 'fa fa-info-circle');
	
}

if ($is_cache_active) {
	$cache_clear_address = esc_url_raw ( add_query_arg ( array ('purge-cache' => 'true' ), essb_get_current_page_url () ) );
	
	//printf ( '<div class="essb-information-box"><div class="icon blue"><i class="fa fa-database"></i></div><div class="inner">%1$s: <b>%2$s</b><a href="%3$s" class="button float_right">%4$s</a></div></div>', __ ( 'Easy Social Share Buttons cache is running:', 'essb' ), $display_cache_mode, $cache_clear_address, __ ( 'Purge Cache', 'essb' ) );
	$dismiss_addons_button = '<a href="' . $cache_clear_address . '"  text="' . __ ( 'Purge Cache', 'essb' ) . '" class="status_button float_right" style="margin-right: 5px;"><i class="fa fa-close"></i>&nbsp;' . __ ( 'Purge Cache', 'essb' ) . '</a>';
	//ESSBOptionsFramework::draw_hint(__('Plugin Cache is Running!', 'essb'), sprintf('%2$s %1$s', $dismiss_addons_button, $display_cache_mode), 'fa fa-database', 'status');
	essb_display_status_message(__('Plugin Cache is Running!', 'essb'), sprintf('%2$s %1$s', $dismiss_addons_button, $display_cache_mode), 'fa fa-database');
}

if ($general_precompiled_resources) {
	$cache_clear_address = esc_url_raw ( add_query_arg ( array ('rebuild-resource' => 'true' ), essb_get_current_page_url () ) );
	
	//printf ( '<div class="essb-information-box"><div class="icon blue"><i class="fa fa-history"></i></div><div class="inner"><b>%1$s</b><a href="%2$s" class="button float_right">%3$s</a></div></div>', __ ( 'Easy Social Share Buttons is using precompiled static resources', 'essb' ), $cache_clear_address, __ ( 'Rebuild resources', 'essb' ) );
		$dismiss_addons_button = '<a href="' . $cache_clear_address . '"  text="' . __ ( 'Rebuild Resources', 'essb' ) . '" class="status_button float_right" style="margin-right: 5px;"><i class="fa fa-close"></i>&nbsp;' . __ ( 'Rebuild Resources', 'essb' ) . '</a>';
		//ESSBOptionsFramework::draw_hint(__('Precompiled Resource Mode is Active!', 'essb'), sprintf('In precompiled mode plugin will load default setup into single static files that will run on entire site. %1$s', $dismiss_addons_button), 'fa fa-history', 'status');
		essb_display_status_message(__('Precompiled Resource Mode is Active!', 'essb'), sprintf('In precompiled mode plugin will load default setup into single static files that will run on entire site. %1$s', $dismiss_addons_button), 'fa fa-history');
}

if ($backup == 'true') {
	//printf ( '<div class="essb-information-box"><div class="icon"><i class="fa fa-gear"></i></div><div class="inner">%1$s</div></div>', __ ( 'Backup of your current settings is generated. Copy generated configuration string and save it on your computer. You can use it to restore settings or transfer them to other site.', 'essb' ) );
	//ESSBOptionsFramework::draw_hint(__('Backup is ready!', 'essb'), 'Backup of your current settings is generated. Copy generated configuration string and save it on your computer. You can use it to restore settings or transfer them to other site.', 'fa fa-gear', 'status');
	essb_display_status_message(__('Backup is ready!', 'essb'), 'Backup of your current settings is generated. Copy generated configuration string and save it on your computer. You can use it to restore settings or transfer them to other site.', 'fa fa-gear');
}

if ($purge_cache == 'true') {
	if (class_exists ( 'ESSBDynamicCache' )) {
		ESSBDynamicCache::flush ();
	}
	if (function_exists ( 'purge_essb_cache_static_cache' )) {
		purge_essb_cache_static_cache ();
	}
	//printf ( '<div class="essb-information-box"><div class="icon"><i class="fa fa-info-circle"></i></div><div class="inner">%1$s</div></div>', __ ( 'Easy Social Share Buttons for WordPress Cache is purged!', 'essb' ) );
	//ESSBOptionsFramework::draw_hint(__('Cache is Cleared!', 'essb'), 'Build in cache of plugin is fully cleared!', 'fa fa-info-circle', 'status');
	essb_display_status_message(__('Cache is Cleared!', 'essb'), 'Build in cache of plugin is fully cleared!', 'fa fa-info-circle');
		
}

if ($rebuild_resource == "true") {
	if (class_exists ( 'ESSBPrecompiledResources' )) {
		ESSBPrecompiledResources::flush ();
	}
}

if ($current_tab == "analytics") {
	$settings_url = esc_url_raw ( get_admin_url () . 'admin.php?page=essb_options&tab=social&section=sharing&subsection=sharing-6' );
	if (! essb_options_bool_value('stats_active')) {
		printf ( '<div class="essb-information-box"><div class="icon orange"><i class="fa fa-info-circle"></i></div><div class="inner">%1$s<a href="%2$s" class="button float_right">%3$s</a></div></div>', __ ( 'Statistics function in not activated!', 'essb' ), $settings_url, __ ( 'Click here to go to settings and activte it', 'essb' ) );
	}
}

if (function_exists('essb3_apply_readymade_style')) {
	essb3_apply_readymade_style();
}
?>



	<div id="essb-scroll-top"></div>
	<div class="essb-tabs">
		<!-- new navigation -->
		<div class="essb-plugin-menu">
		
			<ul class="essb-plugin-menu-main">
				<li><div class="essb-logo essb-logo32">
				
				<a href="<?php echo admin_url('admin.php?page=essb_options');?>" class="no-hover"><div class="essb-version-logo"><?php echo ESSB3_VERSION;?></div></a>
				</div></li>
				 <?php
				$is_first = true;
				$tab_has_nomenu = false;
				foreach ( $tabs as $name => $label ) {
					$tab_sections = isset ( $essb_sidebar_sections [$name] ) ? $essb_sidebar_sections [$name] : array ();
					//print_r($tab_sections);
					$hidden_tab = isset ( $tab_sections ['hide_in_navigation'] ) ? $tab_sections ['hide_in_navigation'] : false;
					if ($hidden_tab) {
						continue;
					}
					
					$icon = isset ( $tab_sections ['icon'] ) ? $tab_sections ['icon'] : '';
					$align = isset($tab_sections['align']) ? $tab_sections['align'] : '';
					
					$options_handler = ($is_first) ? "essb_options" : 'essb_redirect_' . $name;
					
					if (essb_show_welcome()) { $options_handler = 'essb_redirect_' . $name; }
					
					echo '<li '.($align == 'right' ? 'class="tab-right"' : '').'><a href="' . admin_url ( 'admin.php?page=' . $options_handler . '&tab=' . $name ) . '" class="essb-nav-tab ';
					if ($current_tab == $name)
						echo 'active';
					
					echo ' essb-tab-'.$name;
					
					echo '" title="'.$label.'">' . ($icon != '' ? '<i class="' . $icon . '"></i>' : '') . '<span>'.$label . '</span>'.($name == 'update' && !ESSBActivationManager::isActivated() && !ESSBActivationManager::isThemeIntegrated() ? '<span class="not-activated"></span>':'').'</a></li>';
					$is_first = false;
					
					if ($current_tab == $name) {
						$tab_has_nomenu = isset ( $tab_sections ['hide_menu'] ) ? $tab_sections ['hide_menu'] : false;
					}
				}
				
				?>
			</ul>
		
		</div>
	
		<div class="essb-tabs-title essb-tabs-title42">
			<div class="essb-tabs-version">
				<div class="essb-text-afterlogo">
					<p class="essb-tabs-control">
						<a
							href="<?php echo admin_url ("admin.php?page=essb_about"); ?>" class="essb-tab-button">What's new in this version</a></strong>&nbsp;&nbsp;<strong><a
							href="http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476?ref=appscreo"
							target="_blank" class="essb-tab-button">Plugin Homepage</a></strong>&nbsp;&nbsp;<strong><a
							href="http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476?ref=appscreo"
							target="_blank" class="essb-tab-button" id="essb-check-forupdate">Check for update</a></strong>
					</p>
					
				</div>
			</div>
			<div class="essb-title-panel-buttons">
	<?php if (ESSB3_ADDONS_ACTIVE) { ?>
		<?php echo '<a href="'.admin_url ("admin.php?page=essb_addons").'"  text="' . __ ( 'Extensions', 'essb' ) . '" class="essb-btn essb-btn-orange" style="margin-right: 5px;"><i class="fa fa-gear"></i>&nbsp;' . __ ( 'Extensions', 'essb' ) . '</a>'; ?>
	<?php  } ?>
	<?php echo '<a href="'.admin_url ("admin.php?page=essb_redirect_quick&tab=quick").'"  text="' . __ ( 'Quick Setup Wizard', 'essb' ) . '" class="essb-btn essb-btn-red" style="margin-right: 5px;"><i class="fa fa-bolt"></i>&nbsp;' . __ ( 'Quick Setup Wizard', 'essb' ) . '</a>'; ?>
	<?php echo '<a href="'.admin_url ("admin.php?page=essb_redirect_readymade&tab=readymade").'"  text="' . __ ( 'Ready Made Styles', 'essb' ) . '" class="essb-btn essb-btn-green" style="margin-right: 5px;"><i class="fa fa-bolt"></i>&nbsp;' . __ ( 'Apply Ready Made Styles', 'essb' ) . '</a>'; ?>
	<?php echo '<a href="http://support.creoworx.com" target="_blank" text="' . __ ( 'Need Help? Click here to visit our support center', 'essb' ) . '" class="essb-btn essb-btn-light float_right"><i class="fa fa-question"></i>&nbsp;' . __ ( 'Get Support', 'essb' ) . '</a>'; ?>
	</div>
		</div>

	</div>

	
	<?php
	
	if ($current_tab != 'analytics' && $current_tab != 'shortcode' && $current_tab != 'status' && $current_tab != 'welcome') {
		ESSBOptionsInterface::draw_form_start (false, '', $tab_has_nomenu);
		
		ESSBOptionsInterface::draw_sidebar ( $section ['fields'] );
		ESSBOptionsInterface::draw_header ( $section ['title'], $section ['hide_update_button'], $section ['wizard_tab'] );
		ESSBOptionsInterface::draw_content ( $options );
		
		ESSBOptionsInterface::draw_form_end ();
		
		ESSBOptionsFramework::register_color_selector ();
		
		?>					
		
		<?php
	} else if ($current_tab == 'analytics') {
		include_once ESSB3_PLUGIN_ROOT . 'lib/modules/social-share-analytics/essb-social-share-analytics-backend-view.php';
	} else if ($current_tab == "shortcode") {
		include_once ESSB3_PLUGIN_ROOT . 'lib/admin/essb-settings-shortcode-generator.php';
	}
	else if ($current_tab == 'status') {
		include_once ESSB3_PLUGIN_ROOT . 'lib/admin/essb-settings-system-status.php';
		
	}
	else if ($current_tab == 'welcome') {
		include_once ESSB3_PLUGIN_ROOT . 'lib/admin/admin-options/essb-welcome.php';
	}
	?>
	
</div>

<?php 

if (!essb_options_bool_value('deactivate_ajaxsubmit')) {

?>

<style type="text/css">
.preloader {
  position: fixed;
  width: 64px;
  height: 64px;
  border: 6px solid #fff;
  border-radius: 100%;
}
.preloader:before,
.preloader:after {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  margin: -0.2rem 0 0 -0.2rem;
  border-bottom: 6px solid #fff;
  border-radius: 10px;
  -webkit-transform-origin: 3px center;
}
.preloader:before {
/* hour hand */
  width: 30%;
  -webkit-animation: hour 10s linear infinite;
}
.preloader:after {
/* minute hand */
  width: 40%;
  background-color: #2085e6;
  -webkit-animation: minute 1s linear infinite;
}
@-webkit-keyframes hour {
  100% {
    -webkit-transform: rotate(360deg);
  }
}
@-webkit-keyframes minute {
  100% {
    -webkit-transform: rotate(360deg);
  }
}
/* for demo purposes only — not required */
.preloader {
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
}

.preloader-holder {
	position: fixed;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  z-index: 1000;
  top: 0;
  left: 0;
}

.preloader-message {
	position: fixed;
	font-size: 32px;
	line-height: 32px;
	font-family: 'Open Sans', sans-serif;
	font-weight: bold;
	top: calc(50% + 56px);
	bottom: 0;
	left: 0;
	margin: 0;
	text-align: center;
	margin: auto;
	width: 400px;
	right: 0;
	color: #fff;
}

.preloader-holder { display: none; }
.sweet-alert h2 {
	letter-spacing: -0.5px;
	color: #303133;
	font-size: 24px;
	font-weight: 700;
}

.sweet-alert p {
	font-size: 14px;
	color: #303133;
	font-weight: 400;
}

.sweet-alert button {
	font-size: 14px;
	font-weight: 700;
}

.sweet-overlay { 
background-color: rgba(0, 0, 0, 0.7);
}

.search-holder {
		position: fixed;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.97);
  z-index: 100000;
  top: 0;
  left: 0;
  display: none;
  color: #212121;
  padding-left: 100px;
  padding-right: 100px;
}

.search-holder-close {
	position: fixed;
	top: 30px;
	right: 30px;
	font-size: 24px;
	line-height: 24px;
	color: #212121;
	cursor: pointer;
}

.search-container .search-control {
	width: 600px;
	padding: 0 10% 0 10px;
	background: transparent;
	border: none;
	color: #2B6A94;
	font-size: 38px;
	outline: none;
	box-shadow: none;
	font-weight: 600;
	border-bottom: 2px solid #d0d0d0;
	letter-spacing: -0.03em;
}

.search-container .search-control::-webkit-input-placeholder { /* Chrome/Opera/Safari */
  color: #ccc;
}
.search-container .search-control::-moz-placeholder { /* Firefox 19+ */
  color: #ccc;
}
.search-container .search-control:-ms-input-placeholder { /* IE 10+ */
  color: #ccc;
}
.search-container .search-control:-moz-placeholder { /* Firefox 18- */
  color: #ccc;
}
.search-container .search-control:focus, .search-container .search-control:active {
	outline: none;
	box-shadow: none;
}

.search-container {
	margin-top: 60px;
	position: relative;
	max-width: 900px;
	margin: 0 auto;
	padding-top: 60px;
}

.search-container-form {
	max-width: 700px;
	
}

.search-container .search-icon {
	font-size: 24px;
}

.search-container .search-results {
	overflow-y: scroll;
	margin-top: 25px;
	overflow-x: hidden;
	padding-right: 10px;
}

.search-container .search-results .tab-row h3 {
	background: #2B6A94;
	text-transform: uppercase;
	color: #fff;
	margin: 0;
	padding: 10px;
	font-size: 14px;
	font-weight: 600;
}

.search-container .search-results .section-row h4 {
	background: rgba(0,0,0,0.05);
	text-transform: uppercase;
	color: #212121;
	padding: 10px;
	font-size: 14px;
	font-weight: 600;
}

.search-container .search-results .result-row {
	display: flex;
	padding: 10px;
	border-bottom: 1px solid rgba(0,0,0,0.04);
	width: 100%;
	cursor: pointer;
}

.search-container .search-results .result-row:hover {
	background: #33bbf1;
	color: #fff;
}

.search-container .search-results .result-row .parameter {
	width: 75%;
	padding-left: 10px;
	padding-right: 10px;
	display: inline-block;
	vertical-align: top;
}

.search-container .search-results .result-row .value {
	width: 25%;
	padding-left: 10px;
	padding-right: 10px;
	display: inline-block;
	vertical-align: top;
}

.search-container .search-results .result-row .parameter span {
	clear: both;
	font-size: 12px;
	display: block;
}

.essb-scroll-effect::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
}

.essb-scroll-effect::-webkit-scrollbar
{
	width: 10px;
	background-color: #F5F5F5;
}

.essb-scroll-effect::-webkit-scrollbar-thumb
{
	background-color: #0ae;
	
	background-image: -webkit-gradient(linear, 0 0, 0 100%,
	                   color-stop(.5, rgba(255, 255, 255, .2)),
					   color-stop(.5, transparent), to(transparent));
}

</style>

<div class="preloader-holder">
<div class="preloader"></div>
<div class="preloader-message">Please Wait a Moment ...</div>
</div>

<div class="search-holder">
	<div class="search-holder-close">
		<i class="ti-close"></i>
	</div>
	<div class="search-container">
		<div class="search-container-form">
			<input type="text" class="search-control" placeholder="Search..."/>
			<a href="#" class="search-icon">
				<i class="fa fa-search"></i>
			</a>
		</div>
		
		<div class="search-results essb-scroll-effect">
		</div>
	</div>
</div>

<script type="text/javascript">

	// assign ajax submit on form
jQuery(document).ready(function($){
	if ($('#essb-btn-update').length && $('#essb_options_form').length) {
		var frmSettings = $('#essb_options_form');

		$(frmSettings).submit(function (e) {
			if (typeof(essb_disable_ajax_submit) == "undefined") essb_disable_ajax_submit = false;
			if (!essb_disable_ajax_submit) {
		        e.preventDefault();

				// updating codemirror before save
				$('.is-code-editor').each(function(){
					var elementId = $(this).attr('data-editor-key') || '';
					if (typeof(loadedEditorControls[elementId] != 'undefined')) {
						try {
							loadedEditorControls[elementId].save();
						}
						catch (e) {
						}
					}
				});		        
				
				$.ajax({
		            type: frmSettings.attr('method'),
		            url: frmSettings.attr('action'),
		            data: frmSettings.serialize(),
		            success: function (data) {
		                $('.preloader-holder').fadeOut(400);
		                swal("Your settings are saved!", "Your new setup is ready to use. If you use cache plugin (example: W3 Total Cache, WP Super Cache, WP Rocket) or optimization plugin (example: Autoptimize, BWP Minify) it is highly recommended to clear cache or you may not see the changes.", "success")

		            }
		        });

			}
		});
	


		$('#essb-btn-update').on('click', function(e) {
			$('.preloader-holder').fadeIn(100);
		});
	}

	if ($('#essb-check-forupdate').length) {
		$('#essb-check-forupdate').click(function(e) {
			e.preventDefault();

			$('.preloader-holder').fadeIn(100);
			var plugin_is_activated = <?php if (ESSBActivationManager::isActivated()) { echo 'true'; } else { echo 'false'; }?>;
			var version_api = '<?php echo ESSBActivationManager::getApiUrl('api')?>version.php'; 
			$.ajax({
				type: "GET",
		        url: version_api,
		        data: {},
		        success: function (data) {
		        	$('.preloader-holder').fadeOut(400);
	                console.log(data);
	                if (typeof(data) == "string")
	                	data = JSON.parse(data);
	                
	                var code = data['code'] || '';
	                var version = data['version'] || '';

	                if (code == '200') {
	                	$.ajax({
	    		            type: "POST",
	    		            url: "<?php echo admin_url("admin-ajax.php");?>",
	    		            data: { 'action': 'essb_process_activation', 'activation_state': 'version_check', 'version': version},
	    		            success: function (data) {
	    		            	console.log(data);
	    		            	 if (typeof(data) == "string")
	    			                	data = JSON.parse(data);

	 			                var code = data['code'] || '';
	 			                if (code != '') {
		 			                if (plugin_is_activated) {
		 			                	swal("New version " + code + " is available!", "Visit updates screen to proceed with plugin update", "success");
		 			                }
		 			                else {
	 			                		swal("New version " + code + " is available!", "Activate plugin to unlock automatic updates", "success");
		 			                }
	 			                }
	 			                else {
	 			                	swal("", "You are running latest version of plugin!", "");
	 			                }
	    		            }
	                	});
	                }
		        },
		        error: function() {
		        	$('.preloader-holder').fadeOut(400);
		        	swal("Connection Error!", "A problem occured when connection to update server. Please try again later or check the what is new page for our latest release", "error");
		        }
			});
		});
	}

	// search button
	if ($('#essb-search-button').length) {
		$('#essb-search-button').click(function(e) {
			e.preventDefault();

			console.log('search pressed');

			$('.search-results').hide();
			$('.search-holder').fadeIn(100);

			$('.search-control').focus();

			var height = $( window ).height();
			$('.search-results').css('height', (height-160)+'px');
		});
		
	}

	if ($('.search-holder-close').length) {
		$('.search-holder-close').click(function(e) {
			e.preventDefault();

			console.log('search pressed');
			$('.search-holder').fadeOut();
		});
		
	}

	if ($('.search-control').length) {
	$('.search-control').keypress(function (e) {
		  if (e.which == 13) {
			  $('.search-icon').click();
		    return false;    //<---- Add this line
		  }
		});
	}
	//.search-icon
	if ($('.search-icon').length) {
		$('.search-icon').click(function(e) {
			e.preventDefault();

			console.log('search pressed');

			var search = $('.search-control').val();

			$.ajax({
	            type: "POST",
	            url: "<?php echo admin_url("admin-ajax.php");?>",
	            data: { 'action': 'essb_process_search', 'search': search},
	            success: function (data) {
	            	$('.search-results').html(data);
	            	$('.search-results').show();

	            	$('.search-container .search-results .result-row').click(function(e){
	        			e.preventDefault();

	        			var tab = $(this).attr('data-tab'),
	        				section = $(this).attr('data-section'),
	        				subsection = $(this).attr('data-subsection') || '',
	        				field = $(this).attr('data-param');

        				console.log('tab = ' + tab + ', section = ' + section + ', field = ' + field);
	        			var baseURL = "<?php echo admin_url ( 'admin.php?page=');?>";
	        			var socialTab = "<?php if (essb_show_welcome()) { echo 'essb_redirect_social'; } else { echo 'essb_options'; } ?>";

	        			var tab_key = (tab == 'social') ? socialTab : 'essb_redirect_'+tab;

	        			window.location.href = baseURL + tab_key+'&section='+section+'&subsection='+subsection+'&param='+field;
	        			
	        		});
		             
	            }
        	});
		});
		
	}
});
	
</script>
<?php } ?>