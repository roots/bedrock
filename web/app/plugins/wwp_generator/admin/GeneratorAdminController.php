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

namespace WonderWp\Plugin\Generator;

use Doctrine\ORM\EntityManager;
use Pimple\Container as PContainer;
use WonderWp\APlugin\AbstractPluginBackendController;
use WonderWp\DI\Container;
use WonderWp\HttpFoundation\Request;
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
class GeneratorAdminController extends AbstractPluginBackendController
{

    public function pluginFormAction(){
        $request = Request::getInstance();
        $container = Container::getInstance();

        $table = $request->get('table');

        if(!empty($table)){
            /** @var PluginGenerator $generator */
            $generator = $this->_manager->getService('Generator');
            $generator->setTable($table);

            $data = $request->request->all();
            if(empty($data['table'])){ $data['table'] = $table; }
            $form = $generator->getPluginForm($data);

            $errors = array();
            if ($request->getMethod() == 'POST') {
                $formValidator = $container->offsetGet('wwp.forms.formValidator');
                //Form Validation
                $formValidator->setFormInstance($form);
                /*$data = array(
                    'table' => 'nllist',
                    'name' => 'wwp Newsletter',
                    'desc' => 'Module permettant de donner la possibilité à vos utilisateurs de s\'inscrire à des newsletter',
                    'namespace' => 'WonderWp\Plugin\Newsletter',
                    'entityname' => 'Newsletter'
                );*/
                $errors = $formValidator->validate($data);
                if(empty($errors)){
                    $generator->setData($data);
                    $generator->generate();
                }
            }

            //Form View
            /* @var $formView \WonderWp\Forms\FormViewInterface */
            $formView = $container->offsetGet('wwp.forms.formView');
            $formView->setFormInstance($form);

            $prefix = $this->_manager->getConfig('prefix');
            $vue = $container->offsetGet('wwp.basePlugin.backendView');
            $vue->addFrag(new VueFrag( $container->offsetGet($prefix.'.wwp.path.templates.frags.header'),array('title'=>get_admin_page_title())));
            if(!empty($tabs)){ $vue->addFrag(new VueFrag( $container->offsetGet($prefix.'.wwp.path.templates.frags.tabs'),array('tabs'=>$tabs))); }
            $vue->addFrag(new VueFrag( $container->offsetGet($prefix.'.wwp.path.templates.frags.edit'),array('formView'=>$formView, 'formSubmitted'=>($request->getMethod() == 'POST'), 'formValid'=>(empty($errors)))));
            $vue->addFrag(new VueFrag( $container->offsetGet($prefix.'.wwp.path.templates.frags.footer')));
            $vue->render();
        }
    }
}