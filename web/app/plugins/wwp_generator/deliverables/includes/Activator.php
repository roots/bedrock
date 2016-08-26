<?php

/**
 * Fired during plugin activation
 *
 * @link       http://digital.wonderful.fr
 * @since      1.0.0
 *
 * @package    Wonderwp
 * @subpackage Wonderwp/includes
 */

namespace __PLUGIN_NS__;

use WonderWp\APlugin\AbstractPluginActivator;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 * Mainly the table creation if need be
 *
 * @since      1.0.0
 * @package    Wonderwp
 * @subpackage Wonderwp/includes
 * @author     Wonderful <jeremy.desvaux@wonderful.fr>
 */
class __PLUGIN_ENTITY__Activator extends AbstractPluginActivator
{

    /**
     * Create table for entity
     */
    public function activate()
    {
        $this->_createTable('__PLUGIN_NS__\__PLUGIN_ENTITY__Entity');
    }

}
