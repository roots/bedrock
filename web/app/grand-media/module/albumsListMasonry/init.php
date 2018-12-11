<?php
global $wp;

$allsettings = array_merge($module['options'], $settings);
$allsettings['license'] = strtolower($gmGallery->options['license_key']);
$allsettings['post_url'] = remove_query_arg('gm' . $id, add_query_arg($_SERVER['QUERY_STRING'], '', home_url($wp->request)));

if(isset($_GET['gm' . $id])){
	$app_info = false;
} else{
	$app_info = array(
		'name' => $term->name,
		'description' => $term->description
	);
}
?>

<noscript class="module_GmediaAlbumsListMasonry">
	<p>JavaScript is not enabled in your browser</p>
</noscript>
<script type="text/javascript">
	function gMediaListINIT()
	{
		var id = 'gMediaGmediaAlbumsLis'+Math.floor((1 + Math.random()) * 0x10000);
		var dataDIVs = document.body.getElementsByClassName('module_GmediaAlbumsListMasonry');
		dataDIVs[dataDIVs.length-1].setAttribute('app-id', id);
		this[id] = {'settings':<?php echo json_encode($allsettings);?>, "appQuery":<?php echo json_encode($query);?>, "appApi":<?php echo json_encode(add_query_arg(array('gmedia-app' => 1, 'gmappversion' => 4, 'gmmodule' => 1), home_url('/'))); ?>, "appInfo":<?php echo json_encode($app_info); ?>};
	}
	gMediaListINIT();
 </script>