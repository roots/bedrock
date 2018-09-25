<?php

/**
 * Theme Admin Dynamic Stylesheet
 *
 * @package North
 * @since 1.0
 *
 */
 
header("Content-type: text/css;");

$current_url = dirname(__FILE__);
$wp_content_pos = strpos($current_url, 'wp-content');
$wp_content = substr($current_url, 0, $wp_content_pos);

require_once($wp_content . 'wp-load.php');

global $smof_data;
$prefix = "vntd_";

echo '.color-accent { color: '.$smof_data[$prefix.'accent_color'].'; }';

?>