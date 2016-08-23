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

namespace WonderWp\Plugin\Newsletter;

use WonderWp\APlugin\AbstractPluginBackendController;

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
class NewsletterAdminController extends AbstractPluginBackendController{


	public function customizeMenus(){

		//Add entry under top-level functionalities menu
		add_submenu_page('wonderwp-modules', 'Newsletter', 'Newsletter', $this->getMinCapability(), 'wwp-newsletter', array($this,'route'));

	}

}
