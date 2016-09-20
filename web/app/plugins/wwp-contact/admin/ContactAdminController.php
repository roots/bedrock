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

namespace WonderWp\Plugin\Contact;

use WonderWp\APlugin\AbstractPluginBackendController;
use WonderWp\DI\Container;
use WonderWp\Templates\VueFrag;

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
class ContactAdminController extends AbstractPluginBackendController{

    public function getTabs()
    {
        $tabs = array(
            1 => array('action' => 'list', 'libelle' => 'Liste des messages'),
            2 => array('action' => 'listForms', 'libelle' => 'Gestion des formulaire')
        );
        return $tabs;
    }

    public function listFormsAction(){
        $container = Container::getInstance();

        $listTableInstance = new ContactFormListTable();
        $listTableInstance->setEntityName(ContactFormEntity::class);
        $listTableInstance->setTextDomain(WWP_CONTACT_TEXTDOMAIN);

        $tabs = $this->getTabs();

        $prefix = $this->_manager->getConfig('prefix');
        $vue = $container->offsetGet('wwp.views.baseAdmin');
        $vue->addFrag(new VueFrag($container->offsetGet($prefix . '.wwp.path.templates.frags.header'), array('title' => get_admin_page_title())));
        if (!empty($tabs)) {
            $vue->addFrag(new VueFrag($container->offsetGet($prefix . '.wwp.path.templates.frags.tabs'), array('tabs' => $tabs)));
        }
        $vue->addFrag(new VueFrag( $container->offsetGet($prefix.'.wwp.path.templates.frags.list'),array('listTableInstance'=>$listTableInstance)));
        $vue->addFrag(new VueFrag($container->offsetGet($prefix . '.wwp.path.templates.frags.footer')));
        $vue->render();
    }

    public function editContactFormAction(){
        $modelForm = new ContactFormForm();
        parent::editAction(ContactFormEntity::class,$modelForm);
    }

}
