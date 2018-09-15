<?php 

$lsPluginDefaults = array(
	
	// PATHS
	'paths' => array(
		'rootUrl' => plugins_url('', __FILE__),
		'skins' => plugins_url('', __FILE__).'/skins/',
		'transitions' => plugins_url('', __FILE__).'/demos/transitions.json'
	),

	'features' => array(
		'autoupdate' => true
	),

	// INTERFACE
	'interface' => array(

		'settings' => array(

		),

		'fonts' => array(

		),

		'news' => array(
			'display' => true,
			'collapsed' => false
		),

	),

	// Settings
	'settings' => array(
		'scriptsInFooter' => false,
		'conditionalScripts' => false,
		'concatenateOutput' => true,
		'cacheOutput' => false
	)
);

?>