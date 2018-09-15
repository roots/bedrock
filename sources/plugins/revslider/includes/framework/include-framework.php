<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

$folderIncludes = dirname(__FILE__)."/";

require_once($folderIncludes . 'functions.class.php');
require_once($folderIncludes . 'functions-wordpress.class.php');
require_once($folderIncludes . 'db.class.php');
require_once($folderIncludes . 'cssparser.class.php');
require_once($folderIncludes . 'wpml.class.php');
require_once($folderIncludes . 'woocommerce.class.php');
require_once($folderIncludes . 'em-integration.class.php');
require_once($folderIncludes . 'aq-resizer.class.php');
require_once($folderIncludes . 'plugin-update.class.php');
require_once($folderIncludes . 'addon-admin.class.php');

?>