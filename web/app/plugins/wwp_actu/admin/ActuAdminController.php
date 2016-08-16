<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://digital.wonderful.fr
 * @since      1.0.0
 *
 * @package    Wonderwp
 * @subpackage Wonderwp/admin
 */

namespace WonderWp\Plugin\Actu;

use WonderWp\APlugin\AbstractPluginBackendController;
use WonderWp\APlugin\VueFrag;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wonderwp
 * @subpackage Wonderwp/admin
 * @author     Wonderful <jeremy.desvaux@wonderful.fr>
 */
class ActuAdminController extends AbstractPluginBackendController{


	public function customizeMenus(){

		//Add entry under top-level functionalities menu
		add_submenu_page('wonderwp-modules', 'Actualités', 'Actualités', 'read', 'wwp_actu', array($this,'route'));

	}

}
