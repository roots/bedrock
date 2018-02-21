<?php
/**
 * Settings Framework Screen
 *
 * @version 3.0
 * @since 5.0
 * @package EasySocialShareButtons
 * @author appscreo
 */

if (!function_exists('essb_display_status_message')) {
	function essb_display_status_message($title = '', $text = '', $icon = '', $additional_class = '') {
		echo '<div class="essb-header-status">';
		ESSBOptionsFramework::draw_hint($title, $text.'<span class="close-icon" onclick="essbCloseStatusMessage(this); return false;"><i class="fa fa-close"></i></span>', $icon, 'status '.$additional_class);
		echo '</div>';
	}
}

// Reset Settings
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

$rollback_settings = isset($_REQUEST['rollback_setup']) ? $_REQUEST['rollback_setup'] : '';
$rollback_key = isset($_REQUEST['rollback_key']) ? $_REQUEST['rollback_key'] : '';
if ($rollback_settings == 'true' && $rollback_key != '') {
	$history_container = get_option(ESSB5_SETTINGS_ROLLBACK);
	if (!is_array($history_container)) {
		$history_container = array();
	}
	
	if (isset($history_container[$rollback_key])) {
		$options_base = $history_container[$rollback_key];
		if ($options_base) {
			$essb_options = $options_base;
			$essb_admin_options = $options_base;
		}
		update_option ( ESSB3_OPTIONS_NAME, $essb_admin_options );
	}
}



global $essb_navigation_tabs, $essb_sidebar_sections, $essb_section_options;
global $current_tab;

global $essb_admin_options, $essb_options;
$essb_admin_options = get_option ( ESSB3_OPTIONS_NAME );
global $essb_networks;
$essb_networks = essb_available_social_networks ();

global $essb_admin_options_fanscounter;
$essb_admin_options_fanscounter = get_option ( ESSB3_OPTIONS_NAME_FANSCOUNTER );

if (! is_array ( $essb_admin_options_fanscounter )) {
	if (! class_exists ( 'ESSBSocialFollowersCounterHelper' )) {
		include_once (ESSB3_PLUGIN_ROOT . 'lib/modules/social-followers-counter/essb-social-followers-counter-helper.php');
	}

	$essb_admin_options_fanscounter = ESSBSocialFollowersCounterHelper::create_default_options_from_structure ( ESSBSocialFollowersCounterHelper::options_structure () );
	update_option ( ESSB3_OPTIONS_NAME_FANSCOUNTER, $essb_admin_options_fanscounter );
}

if (count ( $essb_navigation_tabs ) > 0) {
	$tab_1 = key ( $essb_navigation_tabs );
}

if ($tab_1 == '') {
	$tab_1 = 'social';
}

$current_tab = (empty ( $_GET ['tab'] )) ? $tab_1 : sanitize_text_field ( urldecode ( $_GET ['tab'] ) );
$active_settings_page = isset ( $_REQUEST ['page'] ) ? $_REQUEST ['page'] : '';
if (strpos ( $active_settings_page, 'essb_redirect_' ) !== false) {
	$options_page = str_replace ( 'essb_redirect_', '', $active_settings_page );
	if ($options_page != '') {
		$current_tab = $options_page;
	}
}


$tabs = $essb_navigation_tabs;
$section = $essb_sidebar_sections [$current_tab];
$options = $essb_section_options [$current_tab];



?>

<div class="essb-admin-panel">

<style type="text/css">
	.notice, .error, .updated { display: none !important; }
	.essb-header-status .essb-options-hint-status { box-shadow: 0px 1px 10px 0px rgba(0,0,0,0.1); -webkit-box-shadow: 0px 1px 10px 0px rgba(0,0,0,0.1); }
	.essb-header-status .essb-options-hint-status .essb-options-hint-desc { font-size: 12px; }
	.essb-header-status .essb-flex-grid-c { padding-top: 0px; padding-bottom: 0px; }
	.essb-header-status { position: relative; }
	.essb-header-status .close-icon { position: absolute; top: 5px; right: 20px; font-size: 16px; cursor: pointer; }
	.essb-headbutton { font-size: 13px; border-radius: 0; border-bottom: 2px solid transparent; }
	.essb-headbutton:hover, .essb-headbutton.active { border-bottom: 2px solid #2B6A94; }

</style>

<!--  sweet alerts -->
<script src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/sweetalert.css">

<!--  code mirror include -->
<link rel=stylesheet href="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/codemirror.css">
<script src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/codemirror.js"></script>
<script src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/mode/xml/xml.js"></script>
<script src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/mode/javascript/javascript.js"></script>
<script src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/mode/css/css.js"></script>
<script src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/edit/matchbrackets.js"></script>
<script src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/edit/closebrackets.js"></script>
<script src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/edit/matchtags.js"></script>
<script src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/edit/closetag.js"></script>
<script src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/fold/foldcode.js"></script>
<script src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/fold/foldgutter.js"></script>
<script src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/fold/indent-fold.js"></script>
<script src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/fold/xml-fold.js"></script>
<script src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/fold/brace-fold.js"></script>
<script src="<?php echo ESSB3_PLUGIN_URL?>/assets/admin/codemirror/addon/fold/comment-fold.js"></script>

<!-- settings: start -->
<div class="wrap essb-settings-wrap essb-wrap-<?php echo $current_tab; ?>">
	<div id="essb-scroll-top"></div>

	<!-- settings panel: start -->
	<div class="essb-settings-panel">
		<!-- settings navigation: start -->
		<div class="essb-settings-panel-navigation">
			<ul class="essb-plugin-menu">
				<li><div class="essb-logo essb-logo32">
					<a href="<?php echo admin_url('admin.php?page=essb_options');?>" class="no-hover"><div class="essb-version-logo"><?php echo ESSB3_VERSION;?></div></a>
				</div></li>

				<!-- navigation components: start -->
				<?php
				$is_first = true;
				$tab_has_nomenu = false;
				foreach ( $tabs as $name => $label ) {
					$tab_sections = isset ( $essb_sidebar_sections [$name] ) ? $essb_sidebar_sections [$name] : array ();
					$hidden_tab = isset ( $tab_sections ['hide_in_navigation'] ) ? $tab_sections ['hide_in_navigation'] : false;
					if ($hidden_tab) {
						continue;
					}

					$icon = isset ( $tab_sections ['icon'] ) ? $tab_sections ['icon'] : '';
					$align = isset($tab_sections['align']) ? $tab_sections['align'] : '';

					$options_handler = ($is_first) ? "essb_options" : 'essb_redirect_' . $name;

					if (essb_show_welcome()) { $options_handler = 'essb_redirect_' . $name; }

					$tab_classes = ($current_tab == $name) ? 'active': '';
					$tab_classes .= ($align == 'right') ? ' tab-right' : '';

					echo '<li class="'.$tab_classes.' essb-tabid-'.$name.'"><a href="' . admin_url ( 'admin.php?page=' . $options_handler . '&tab=' . $name ) . '" class="essb-nav-tab ';
					if ($current_tab == $name)
						echo 'active';

					echo ' essb-tab-'.$name;

					echo '" title="'.$label.'">' . ($icon != '' ? '<i class="' . $icon . '"></i>' : '') . '<span>'.$label . '</span>'.($name == 'update' && !ESSBActivationManager::isActivated() && !ESSBActivationManager::isThemeIntegrated() ? '<span class="not-activated"></span>':'').'</a>';
					$is_first = false;

					if ($current_tab == $name) {
						ESSBOptionsInterface::draw_sidebar ( $section ['fields'] );
					}

					echo '</li>';

					if ($current_tab == $name) {
						$tab_has_nomenu = isset ( $tab_sections ['hide_menu'] ) ? $tab_sections ['hide_menu'] : false;
					}
				}

				?>
				<!-- navigation components: end -->
			</ul>

		</div>
		<!-- settings navigation: end -->

		<!-- settings options: start -->
		<div class="essb-settings-panel-options">

		<script type="text/javascript">

		var essb5_active_tag = "<?php echo $current_tab; ?>";
		
		</script>
		
		<?php

		$additional_buttons = '';
		
	

		$additional_buttons .= '<a href="'.admin_url ("admin.php?page=essb_redirect_modes&tab=modes").'"  text="' . __ ( 'Activate or Deactivate Plugin Features', 'essb' ) . '" class="essb-btn essb-btn-plain essb-btn-small essb-btn-noupper essb-headbutton'.($current_tab == 'modes' ? ' active': '').'" style="margin-right: 5px;" title="Change between different plugin working modes to make plugin fits best into your needs"><i class="fa fa-magic"></i>&nbsp;' . __ ( 'Switch Plugin Mode', 'essb' ) . '</a>';
		$additional_buttons .= '<a href="'.admin_url ("admin.php?page=essb_redirect_functions&tab=functions").'"  text="' . __ ( 'Activate or Deactivate Plugin Features', 'essb' ) . '" class="essb-btn essb-btn-plain essb-btn-small essb-btn-noupper essb-headbutton'.($current_tab == 'functions' ? ' active': '').'" style="margin-right: 5px;" title="Activate/deactivate functions of plugin"><i class="fa fa-cog"></i>&nbsp;' . __ ( 'Manage Plugin Features', 'essb' ) . '</a>';
		$additional_buttons .= '<a href="'.admin_url ("admin.php?page=essb_redirect_quick&tab=quick").'"  text="' . __ ( 'Quick Setup Wizard', 'essb' ) . '" class="essb-btn essb-btn-plain essb-btn-small essb-btn-noupper  essb-headbutton" style="margin-right: 5px;" title="Quick configuration wizard for the most common functions"><i class="fa fa-bolt"></i>&nbsp;' . __ ( 'Setup Wizard', 'essb' ) . '</a>';
		$additional_buttons .= '<a href="'.admin_url ("admin.php?page=essb_redirect_support&tab=support").'" text="' . __ ( 'Need Help? Click here to visit our support center', 'essb' ) . '" class="essb-btn essb-btn-plain essb-btn-small essb-btn-noupper  essb-headbutton" title="Need a hand working with plugin?"><i class="fa fa-question"></i>&nbsp;' . __ ( 'Need Help?', 'essb' ) . '</a>';


		if ($current_tab != 'analytics' && $current_tab != 'shortcode' && $current_tab != 'status' && $current_tab != 'welcome' &&
				$current_tab != 'extensions' && $current_tab != 'about' && $current_tab != 'quick' && $current_tab != 'support') {
			ESSBOptionsInterface::draw_form_start (false, '', $tab_has_nomenu);

			// drawing additional notifications based on user actions
			essb_settings5_status_notifications();
				
			
				//ESSBOptionsInterface::draw_sidebar ( $section ['fields'] );
			//$advanced_settings = '<a href="#" class="essb-btn essb-btn-right" style="margin-top: -8px;"><i class="fa fa-sliders" aria-hidden="true" style="margin-right: 5px;"></i>'.__('Advanced Settings', 'essb').'</a>';
			$advanced_settings = '';

			ESSBOptionsInterface::draw_header5 ( $section ['title'], $section ['hide_update_button'], $section ['wizard_tab'], $additional_buttons, $advanced_settings );
			
			
			ESSBOptionsInterface::draw_content ( $options );

			ESSBOptionsInterface::draw_form_end ();

			ESSBOptionsFramework::register_color_selector ();


		}
		else if ($current_tab == 'analytics') {
			ESSBOptionsInterface::draw_header5 ( $section ['title'], $section ['hide_update_button'], $section ['wizard_tab'], '', '' );
			include_once ESSB3_PLUGIN_ROOT . 'lib/modules/social-share-analytics/essb-social-share-analytics-backend-view.php';
		} else if ($current_tab == "shortcode") {
			include_once ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-structure5-shortcode.php';
		}
		else if ($current_tab == 'status') {
			include_once ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-structure5-status.php';
		}
		else if ($current_tab == 'about') {
			include_once ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-structure5-about.php';
		}
		else if ($current_tab == 'support') {
			include_once ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-structure5-support.php';
		}
		else if ($current_tab == 'welcome') {
			include_once ESSB3_PLUGIN_ROOT . 'lib/admin/admin-options/essb-welcome.php';
		}
		else if ($current_tab == 'extensions') {			
			ESSBOptionsInterface::draw_header5 ( $section ['title'], $section ['hide_update_button'], $section ['wizard_tab'], '', '' );
			include_once ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-structure5-addons.php';
		}
		else if ($current_tab == 'quick') {
			include_once ESSB3_PLUGIN_ROOT . 'lib/admin/settings/essb-structure5-wizard-helper.php';
		}
		?>

		<?php
		
		//essb_component_single_position_select(essb5_available_content_positions(), 'content_position');
		//essb_component_multi_position_select(essb_available_button_positions(), 'button_position');
		
		/*essb_component_network_selection();

		essb_component_network_selection('top');
		
		print "<div>General Selection</div>";
		essb_component_template_select();
		essb_component_buttonstyle_select();
		essb_component_counterpos_select();
		essb_component_totalcounterpos_select();

		print "<div>Position Selection</div>";
		essb_component_template_select('top');
		essb_component_buttonstyle_select('top');
		essb_component_counterpos_select('top');
		essb_component_totalcounterpos_select('top');
		
		$select_values = array('plus' => array('title' => 'Plus Icon', 'content' => '<i class="essb_icon_plus"></i>'),
				'dots' => array('title' => 'Dots Icon', 'content' => '<i class="essb_icon_dots"></i>'),
				'share' => array('title' => 'Share Icon', 'content' => '<i class="essb_icon_share"></i>'),
			    'mobile' => array('title' => 'Share Icon', 'content' => '<i class="fa fa-mobile"></i>', 'padding' => '12px 16px'),
				'mobile1' => array('title' => 'Share Icon', 'content' => '<i class="fa fa-desktop"></i>'),
				'mobile2' => array('title' => 'Share Icon', 'content' => '<i class="fa fa-tablet"></i>', 'padding' => '12px 13px'),
				'mobile3' => array('title' => 'Share Icon', 'content' => '<i class="ti-tag"></i>'),
				'text' => array('title' => 'Text Icon', 'content' => 'Text Value', 'isText' => true));
		
		essb_component_options_group_select('icon', $select_values, '', 'share');

		$select_values = array('auto' => array('title' => 'Automatic Width', 'content' => 'Automatic', 'isText'=>true),
				'fixed' => array('title' => 'Fixed Width', 'content' => 'Fixed', 'isText'=>true),
				'full' => array('title' => 'Full Width', 'content' => 'Full', 'isText'=>true),
				'flex' => array('title' => 'Fluid', 'content' => 'Fluid', 'isText'=>true),
				'columns' => array('title' => 'Columns', 'content' => 'Columns', 'isText'=>true),);
		
		essb_component_options_group_select('icon', $select_values, '');
		*/
		?>


		
		
		</div>
		
		<!-- settings-options: end; -->
	</div>
	<!-- settings panel: end; -->
</div>
<!-- settings: end -->


<!-- test -->
<div class="essb-helper-popup-overlay"></div>
<div class="essb-helper-popup" style="width: 400px; height: 400px; left: 150px; top: 150px;" id="essb-testpopup" data-width="auto" data-height="auto">
	<div class="essb-helper-popup-title">
		This is popup tittle
		<a href="#" class="essb-helper-popup-close"></a>
	</div>
	<div class="essb-helper-popup-content">
		asdaadasdadsa
	</div>
	<div class="essb-helper-popup-command">
		<a href="#" class="essb-btn essb-assign">Save Settings</a> <a href="#" class="essb-btn essb-assign-popupclose">Close Settings</a>
	</div>
</div>

<!-- Social Networks Selection -->
<div class="essb-helper-popup" id="essb-networkselect" data-width="800" data-height="auto">
	<div class="essb-helper-popup-title">
		Social Networks Selection
		<a href="#" class="essb-helper-popup-close"></a>
	</div>
	<div class="essb-helper-popup-content">

	</div>
	<div class="essb-helper-popup-command">
		<a href="#" class="essb-btn essb-btn-red" id="essb-button-confirm-select" data-close="#essb-networkselect"><i class="fa fa-check" aria-hidden="true" style="margin-right: 5px;"></i>Choose</a> <a href="#" class="essb-btn essb-assign-popupclose"><i class="fa fa-close" aria-hidden="true" style="margin-right: 5px;"></i>Close</a>
	</div>
</div>

<!-- Template Selection -->
<div class="essb-helper-popup" id="essb-templateselect" data-width="800" data-height="auto">
	<div class="essb-helper-popup-title">
		Template Selection
		<a href="#" class="essb-helper-popup-close"></a>
	</div>
	<div class="essb-helper-popup-content">
		<?php essb_component_base_template_selection('', 'style', 'style_text');?>
	</div>

</div>

<!-- Button Style Select -->
<div class="essb-helper-popup" id="essb-buttonstyleselect" data-width="800" data-height="auto">
	<div class="essb-helper-popup-title">
		Button Style
		<a href="#" class="essb-helper-popup-close"></a>
	</div>
	<div class="essb-helper-popup-content">
		<?php essb_component_base_button_style_selection('');?>
	</div>

</div>

<!-- Share Counter Position Select -->
<div class="essb-helper-popup" id="essb-counterposselect" data-width="800" data-height="auto">
	<div class="essb-helper-popup-title">
		Single Button Share Counter Style
		<a href="#" class="essb-helper-popup-close"></a>
	</div>
	<div class="essb-helper-popup-content">
		<?php essb_component_base_counter_position_selection('');?>
	</div>

</div>

<!-- Total Share Counter Position Select -->
<div class="essb-helper-popup" id="essb-totalcounterposselect" data-width="800" data-height="auto">
	<div class="essb-helper-popup-title">
		Single Button Share Counter Style
		<a href="#" class="essb-helper-popup-close"></a>
	</div>
	<div class="essb-helper-popup-content">
		<?php essb_component_base_total_counter_position_selection();?>
	</div>

</div>

<!-- Total Share Counter Position Select -->
<div class="essb-helper-popup" id="essb-animationsselect" data-width="800" data-height="auto">
	<div class="essb-helper-popup-title">
		Animations
		<a href="#" class="essb-helper-popup-close"></a>
	</div>
	<div class="essb-helper-popup-content">
		<?php essb_component_base_animation_selection();?>
	</div>

</div>

<?php 

$template_list = essb_available_tempaltes4();
$templates = array();

foreach ($template_list as $key => $name) {
	$templates[$key] = essb_template_folder($key);
}

?>

<script type="text/javascript">
var essbAdminSettings = {
		'networks': <?php echo json_encode(essb_available_social_networks()); ?>,
		'templates': <?php echo json_encode($templates); ?>
};

function essbCloseStatusMessage(sender) {
	jQuery(sender).closest('.essb-options-hint-status').fadeOut();
}
</script>

</div>

<?php
function essb_settings5_status_notifications() {
	global $essb_admin_options, $current_tab;
	
	$purge_cache = isset ( $_REQUEST ['purge-cache'] ) ? $_REQUEST ['purge-cache'] : '';
	$rebuild_resource = isset ( $_REQUEST ['rebuild-resource'] ) ? $_REQUEST ['rebuild-resource'] : '';
	
	$dismiss_addon = isset ( $_REQUEST ['dismiss'] ) ? $_REQUEST ['dismiss'] : '';
	if ($dismiss_addon == "true") {
		$dismiss_addon = isset ( $_REQUEST ['addon'] ) ? $_REQUEST ['addon'] : '';
		$addons = ESSBAddonsHelper::get_instance ();
	
		$addons->dismiss_addon_notice ( $dismiss_addon );
	}
	
	
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
	
	$cache_plugin_message = "";
	$reset_settings = isset ( $_REQUEST ['reset_settings'] ) ? $_REQUEST ['reset_settings'] : '';
	if (ESSBCacheDetector::is_cache_plugin_detected ()) {
		$cache_plugin_message = __(" Cache plugin detected running on site: ", "essb") . ESSBCacheDetector::cache_plugin_name ();
	}
	
	$settings_update = isset ( $_REQUEST ['settings-updated'] ) ? $_REQUEST ['settings-updated'] : '';
	if ($settings_update == "true") {
		essb_display_status_message(__('Options are saved!', 'essb'), 'Your new setup is ready to use. If you use cache plugin (example: W3 Total Cache, WP Super Cache, WP Rocket) or optimization plugin (example: Autoptimize, BWP Minify) it is highly recommended to clear cache or you may not see the changes. '.$cache_plugin_message, 'fa fa-info-circle', 'essb-status-update');
	
	}

	$settings_update = isset ( $_REQUEST ['wizard-updated'] ) ? $_REQUEST ['wizard-updated'] : '';
	if ($settings_update == "true") {
		essb_display_status_message(__('Your new settings are saved!', 'essb'), 'The initial setup of plugin via quick setup wizard is done. You can make additional adjustments using plugin menu, import ready made styles or just use it that way. If you use cache plugin (example: W3 Total Cache, WP Super Cache, WP Rocket) or optimization plugin (example: Autoptimize, BWP Minify) it is highly recommended to clear cache or you may not see the changes. '.$cache_plugin_message, 'fa fa-info-circle', 'essb-status-update');
	
	}
	
	$settings_imported = isset ( $_REQUEST ['settings-imported'] ) ? $_REQUEST ['settings-imported'] : '';
	if ($settings_imported == "true") {
		essb_display_status_message(__('Options are imported!', 'essb'), 'If you use cache plugin (example: W3 Total Cache, WP Super Cache, WP Rocket) or optimization plugin (example: Autoptimize, BWP Minify) it is highly recommended to clear cache or you may not see the changes. '.$cache_plugin_message, 'fa fa-info-circle');
	
	}
	if ($reset_settings == 'true') {
		essb_display_status_message(__('Options are reset to default!', 'essb'), 'If you use cache plugin (example: W3 Total Cache, WP Super Cache, WP Rocket) or optimization plugin (example: Autoptimize, BWP Minify) it is highly recommended to clear cache or you may not see the changes. '.$cache_plugin_message, 'fa fa-info-circle');
	
	}
	
	// cache is running
	$general_cache_active = ESSBOptionValuesHelper::options_bool_value ( $essb_admin_options, 'essb_cache' );
	$general_cache_active_static = ESSBOptionValuesHelper::options_bool_value ( $essb_admin_options, 'essb_cache_static' );
	$general_cache_active_static_js = ESSBOptionValuesHelper::options_bool_value ( $essb_admin_options, 'essb_cache_static_js' );
	$general_cache_mode = ESSBOptionValuesHelper::options_value ( $essb_admin_options, 'essb_cache_mode' );
	$is_cache_active = false;
	
	$general_precompiled_resources = ESSBOptionValuesHelper::options_bool_value ( $essb_admin_options, 'precompiled_resources' );
	
	$backup = isset ( $_REQUEST ['backup'] ) ? $_REQUEST ['backup'] : '';
	
	
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
	
	if ($is_cache_active) {
		$cache_clear_address = esc_url_raw ( add_query_arg ( array ('purge-cache' => 'true' ), essb_get_current_page_url () ) );
	
		$dismiss_addons_button = '<a href="' . $cache_clear_address . '"  text="' . __ ( 'Purge Cache', 'essb' ) . '" class="status_button float_right" style="margin-right: 5px;"><i class="fa fa-close"></i>&nbsp;' . __ ( 'Purge Cache', 'essb' ) . '</a>';
		essb_display_status_message(__('Plugin Cache is Running!', 'essb'), sprintf('%2$s %1$s', $dismiss_addons_button, $display_cache_mode), 'fa fa-database');
	}
	
	if ($general_precompiled_resources) {
		$cache_clear_address = esc_url_raw ( add_query_arg ( array ('rebuild-resource' => 'true' ), essb_get_current_page_url () ) );
	
		$dismiss_addons_button = '<a href="' . $cache_clear_address . '"  text="' . __ ( 'Rebuild Resources', 'essb' ) . '" class="status_button float_right" style="margin-right: 5px;"><i class="fa fa-close"></i>&nbsp;' . __ ( 'Rebuild Resources', 'essb' ) . '</a>';
		essb_display_status_message(__('Precompiled Resource Mode is Active!', 'essb'), sprintf('In precompiled mode plugin will load default setup into single static files that will run on entire site. %1$s', $dismiss_addons_button), 'fa fa-history');
	}
	
	if ($backup == 'true') {
		essb_display_status_message(__('Backup is ready!', 'essb'), 'Backup of your current settings is generated. Copy generated configuration string and save it on your computer. You can use it to restore settings or transfer them to other site.', 'fa fa-gear');
	}
	
	
	$rollback_settings = isset($_REQUEST['rollback_setup']) ? $_REQUEST['rollback_setup'] : '';
	$rollback_key = isset($_REQUEST['rollback_key']) ? $_REQUEST['rollback_key'] : '';
	if ($rollback_settings == 'true' && $rollback_key != '') {
		essb_display_status_message(__('Settings Rollback Completed!', 'essb'), 'Your setup from '.date(DATE_RFC822, $rollback_key).' is restored!', 'fa fa-gear');
		
	}
	
	if (essb_option_value('counter_mode') == '' && essb_option_value('show_counter')) {
		essb_display_status_message(__('Real time share counters warning!', 'essb'), __('You are using real time share counters update on your site. It is highly recommended to avoid that on a production site because you may cause overload of server or send too many requests to social API which will lead to missing share counters for a period of time', 'essb'), 'fa fa-exclamation-circle');
	}
		
	if ($purge_cache == 'true') {
		if (class_exists ( 'ESSBDynamicCache' )) {
			ESSBDynamicCache::flush ();
		}
		if (function_exists ( 'purge_essb_cache_static_cache' )) {
			purge_essb_cache_static_cache ();
		}
		essb_display_status_message(__('Cache is Cleared!', 'essb'), 'Build in cache of plugin is fully cleared!', 'fa fa-info-circle');
	
	}
	
	if ($rebuild_resource == "true") {
		if (class_exists ( 'ESSBPrecompiledResources' )) {
			ESSBPrecompiledResources::flush ();
		}
	}
	
	if (function_exists('essb3_apply_readymade_style')) {
		essb3_apply_readymade_style();
	}
}
?>

<?php 

$deactivate_ajaxsubmit = essb_option_bool_value('deactivate_ajaxsubmit');

if ($current_tab == 'developer') {
	$deactivate_ajaxsubmit = true;
}

if (!$deactivate_ajaxsubmit) {

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

	
});
	
</script>
<?php } ?>

<?php 
/** 
 * Detect first time run to suggest visitor run a plugin wizard 
 */

$is_for_firsttime = get_option ( ESSB3_FIRST_TIME_NAME );
if (!$is_for_firsttime) { $is_for_firsttime = 'false'; }	

if ($current_tab != 'about' && $is_for_firsttime == 'true') {
	
	// first time wizard displayed
	update_option(ESSB3_FIRST_TIME_NAME, 'false');
	
	?>

	<style type="text/css">
	
	.essb-firsttime {
		background: #2b6a94; /* Old browsers */
		background: -moz-linear-gradient(top, #2b6a94 0%, #23577a 100%); /* FF3.6-15 */
		background: -webkit-linear-gradient(top, #2b6a94 0%,#23577a 100%); /* Chrome10-25,Safari5.1-6 */
		background: linear-gradient(to bottom, #2b6a94 0%,#23577a 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2b6a94', endColorstr='#23577a',GradientType=0 ); /* IE6-9 */
		color: #fff;
		width: 800px;
		position: fixed;
		z-index: 2000;
		display: none;
		left: 0;
		top: 0;
		border-radius: 10px;
	}
	
.essb-firsttime .essb-logo {	
	display: block;
	width: 72px;
	height: 72px;
	background-size: 72px;
	margin: 0 auto;
	margin-top: 16px;
	margin-bottom: 20px;
	position: relative;
}

.essb-firsttime .essb-logo a:hover {
	background: none;
	background-color: transparent;
	color: #fff;
}

.essb-firsttime .essb-logo .essb-version-logo {
	background-color: #e74c3c;
	padding: 2px 4px;
	border-radius: 5px;
	position: absolute;
	top: -10px;
	right: -5px;
	font-weight: bold;
	font-size: 11px;
}

.essb-firsttime .about-text { font-size: 15px; text-align: center; }

.essb-firsttime h1 { color: #fff; font-size: 21px; text-align: center; }

.essb-firsttime .essb-firsttime-inner { padding: 40px; }

.essb-firsttime-button {
		font-weight: 600;
		border-radius: 4px;
		padding: 0px 25px;
		line-height: 40px;
		color: #fff;
		font-size: 14px;
		display: inline-block;
		text-decoration: none;
		cursor: pointer;
	}
	
	.essb-firsttime-button-default {
		background-color: #3498db;
	}
	.essb-firsttime-button-default:hover, .essb-firsttime-button-default:active, .essb-firsttime-button-default:focus {
		background-color: #2c8ac8;
		color: #fff;
		text-decoration: none !important;
	}

		.essb-firsttime-button-color1 {
		background-color: #BB3658;
	}
	
	.essb-firsttime-button-color2 {
		background-color: #FD5B03;
}
	
	.essb-firsttime-button-color3 {
		background-color: #2ebf99;
}

	.essb-firsttime-button-color1:hover, .essb-firsttime-button-color1:active, .essb-firsttime-button-color1:focus {
		background-color: #7E3661;
		color: #fff;
		text-decoration: none !important;
	}

		.essb-firsttime-button-color2:hover, .essb-firsttime-button-color2:active, .essb-firsttime-button-color2:focus {
		background-color: #F04903;
		color: #fff;
		text-decoration: none !important;
	}
	
	.essb-firsttime-button-transparent {
		text-decoration: underline;
	}
	
	.essb-firsttime-button-transparent:hover, .essb-firsttime-button-transparent:focus, .essb-firsttime-button-transparent:active {
		color: #fff;
		text-decoration: none;
}

.essb-firsttime-button-color3:hover, .essb-firsttime-button-color3:active, .essb-firsttime-button-color3:focus {
		background-color: #27a483;
		color: #fff;
		text-decoration: none !important;
	}
	
	
	.essb-firsttime .actions { text-align: center; margin-top: 30px; }
	.essb-firsttime .actions .essb-firsttime-button { margin-right: 10px; }
	
	.essb-firsttime-holder {
	position: fixed;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  z-index: 1000;
  top: 0;
  left: 0;
  display: none;
}
	
	.essb-firsttime-notice {
		font-size: 12px;
		margin-top: 5px;
		text-align: center;
}

	</style>
	
	<div class="essb-firsttime-holder"></div>
	
	<div class="essb-firsttime">
		<div class="essb-firsttime-inner">
			<div class="essb-logo essb-logo32">
				<div class="essb-version-logo"><?php echo ESSB3_VERSION; ?></div>
			</div>
			
			<h1><?php echo sprintf( __( 'Welcome to Easy Social Share Buttons for WordPress', 'essb' ), preg_replace( '/^(\d+)(\.\d+)?(\.\d)?/', '$1$2', ESSB3_VERSION ) ) ?></h1>

			<div class="about-text">
				<?php _e( 'Thank you for choosing the best social sharing plugin for WordPress. You are about to use most powerful social media plugin for WordPress ever - get ready to increase your social shares, followers and mail list subscribers. We hope you enjoy it!', 'essb' )?>
			</div>
			
			<div class="actions">
				<a href="<?php echo admin_url('admin.php?page=essb_redirect_modes&tab=modes');?>" class="essb-firsttime-button essb-firsttime-button-color2">Switch Plugin Modes</a>
				<a href="<?php echo admin_url('admin.php?page=essb_redirect_functions&tab=functions');?>" class="essb-firsttime-button essb-firsttime-button-color3">Personalize Active Modules</a>
			</div>
			
			<div class="actions">
				<a href="<?php echo admin_url('admin.php?page=essb_redirect_quick&tab=quick');?>" class="essb-firsttime-button essb-firsttime-button-default">Run Setup Wizard</a>				
				<a href="https://docs.socialsharingplugin.com" target="_blank" class="essb-firsttime-button essb-firsttime-button-color1">Visit Knowledge Base</a>
				<a href="http://support.creoworx.com" target="_blank" class="essb-firsttime-button essb-firsttime-button-color2">Need Help? Visit Our Support System</a>
				</div>
			<div class="actions" style="margin-top: 10px">
				<a href="" class="essb-firsttime-button essb-firsttime-button-transparent essb-close-firsttime">Close this screen</a>
			</div>
			<div class="essb-firsttime-notice">
				This welcome screen will show only once
			</div>
		</div>
	</div>
	
	<script type="text/javascript">

	jQuery(document).ready(function($){
		jQuery.fn.extend({
	        centerWithAdminBarWelcome: function () {
	            return this.each(function() {
	                var top = (jQuery(window).height() - jQuery(this).outerHeight()) / 2;
	                var left = (jQuery(window).width() - jQuery(this).outerWidth()) / 2;
	                
	                if (jQuery('#adminmenuwrap').length)
	                	left = left + (jQuery('#adminmenuwrap').width() / 2);
	                
	                jQuery(this).css({position:'fixed', margin:0, top: (top > 0 ? top : 0)+'px', left: (left > 0 ? left : 0)+'px'});
	            });
	        }
	    }); 
		
		
		$('.essb-firsttime').centerWithAdminBarWelcome();
		
		$('.essb-firsttime-holder').fadeIn(200);
		$('.essb-firsttime').fadeIn(400);

		$('.essb-close-firsttime').click(function(e){
			e.preventDefault();

			$('.essb-firsttime-holder').fadeOut(400);
			$('.essb-firsttime').fadeOut(400);
		});
	});
	</script>
	<?php 
}

?>