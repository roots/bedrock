<?php
if(!defined('WP_USE_THEMES')){ define('WP_USE_THEMES', false); }
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp/wp-blog-header.php' );
require_once( get_stylesheet_directory().'/functions.php' );
//require_once( get_theme_root().'/functions.php' );

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js atomsWrap"> <!--<![endif]-->
<head>
		<base href="../">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title></title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">

       	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet'>
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">

		<link rel="stylesheet" href="css/knacss/knacss.css">
		
		<link rel="stylesheet" href="atomic-core/css/main.css">

		<link rel="stylesheet" href="css/main.css">

		<link rel="stylesheet" href="css/wdf-atomic.css">		
    
        <link rel="stylesheet" href="atomic-core/font-awesome/css/font-awesome.min.css">


		<?php
			$filename = '../atomic-head.php';
			if (file_exists($filename)) {
			    include ("../atomic-head.php"); 
			}
		?>
</head>