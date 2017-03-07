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

namespace WonderWp\Plugin\Translator;

use Doctrine\ORM\EntityManager;
use Pimple\Container as PContainer;
use WonderWp\APlugin\AbstractPluginBackendController;
use WonderWp\DI\Container;
use WonderWp\HttpFoundation\Request;
use WonderWp\Templates\Views\VueFrag;

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
class TranslatorAdminController extends AbstractPluginBackendController
{


    public function customizeMenus()
    {

        //Add top-level translation menu
        $page_title = 'Gestion des traductions';
        $menu_title = 'Traductions';
        $menu_slug = 'wonderwp-trads';
        $function = array($this, 'route');
        add_menu_page($page_title, $menu_title, 'read', $menu_slug, $function, 'dashicons-translation', 20);

        //Add entry under top-level functionalities menu
        //add_submenu_page('wonderwp-modules', 'FAQ', 'FAQ', 'read', 'wwp_faq', array($this,'route'));

    }

    public function getTabs()
    {
        $tabs = array(
            1 => array('action' => 'list', 'libelle' => 'Gestion des langues'),
            2 => array('action' => 'listTrads', 'libelle' => 'Traductions des clés')
        );
        return $tabs;
    }


    public function listTradsAction()
    {
        $container = Container::getInstance();

        // @var WP_Theme $theme
        $themes = array();
        $exclude = array('twentyfifteen');
        foreach (wp_get_themes(array('allowed' => true)) as $name => $theme) {
            if (!in_array($name, $exclude)) {
                $package = LocoPackage::get($name, 'theme') and
                $name = $package->get_name();
                $themes[$name] = $package;
            }
        }
        // @var array $plugin
        $plugins = array();
        $exclude = array('cms-tree-page-view/index.php', 'debug-bar/debug-bar.php');
        foreach (get_plugins() as $plugin_file => $plugin) {
            if (!in_array($plugin_file, $exclude)) {
                $package = LocoPackage::get($plugin_file, 'plugin') and
                $plugins[] = $package;
            }
        }

        $notifications = $this->flashesToNotifications();

        $prefix = $this->_manager->getConfig('prefix');
        $vue = $container->offsetGet('wwp.views.baseAdmin')
            ->registerFrags($prefix, array(
                new VueFrag($container->offsetGet($prefix . '.wwp.path.templates.frags.header')),
                new VueFrag($container->offsetGet($prefix . '.wwp.path.templates.frags.tabs')),
                new VueFrag(__DIR__ . '/pages/TranslatorView.php'),
                new VueFrag($container->offsetGet($prefix . '.wwp.path.templates.frags.footer'))
            ))
            ->render([
                'title' => get_admin_page_title(),
                'tabs' => $this->getTabs(),
                'themes' => $themes, 'plugins' => $plugins,
                'notifications' => $notifications
            ]);
    }

    public function fscheckAction()
    {

        // most actions except root listing define a single package by name and type
        $package = null;
        if (isset($_GET['name']) && isset($_GET['type'])) {
            $package = LocoPackage::get($_GET['name'], $_GET['type']);
        }

        $args = array(
            'title' => get_admin_page_title(),
            'tabs'=>$this->getTabs()
        );

        if (isset($_GET['fscheck'])) {
            $args = $args + $package->meta() + compact('package');
        }

        $container = Container::getInstance();
        $prefix = $this->_manager->getConfig('prefix');
        $vue = $container->offsetGet('wwp.views.baseAdmin')
            ->registerFrags($prefix,[
                new VueFrag($container->offsetGet($prefix . '.wwp.path.templates.frags.header')),
                new VueFrag($container->offsetGet($prefix . '.wwp.path.templates.frags.tabs')),
                new VueFrag(__DIR__ . '/pages/admin-fscheck.tpl.php'),
                new VueFrag($container->offsetGet($prefix . '.wwp.path.templates.frags.footer'))
            ])
            ->render($args);
    }

    public function editTradsAction()
    {

        $request = Request::getInstance();
        $container = Container::getInstance();

        $path = $request->get('poedit');
        $name = $request->get('name');
        $type = $request->get('type');

        /*
         * Load up available languages
         */
        /** @var $em EntityManager */
        $em = $container->offsetGet('entityManager');
        $prefix = $this->_manager->getConfig('prefix');
        $entityName = $this->_manager->getConfig('entityName');
        $repository = $em->getRepository($entityName);
        $languages = $repository->findAll();

        /** @var $getTextService TranslatorGetTextService */
        $getTextService = $this->_manager->getService('getText');

        $translationFiles = $getTextService->locateFiles($path, $name, $type);

        if ($request->getMethod() == 'POST') {
            $postedData = $request->request->all();
            $getTextService->persistTranslations($translationFiles, $postedData);
        }

        $editionTable = $getTextService->prepareTranslationTable($translationFiles, $languages);

        $vue = $container->offsetGet('wwp.views.baseAdmin')
            ->registerFrags($prefix,[
                new VueFrag($container->offsetGet($prefix . '.wwp.path.templates.frags.header')),
                new VueFrag($container->offsetGet($prefix . '.wwp.path.templates.frags.tabs')),
                new VueFrag(__DIR__ . '/pages/admin-editionTable.tpl.php'),
                new VueFrag($container->offsetGet($prefix . '.wwp.path.templates.frags.footer'))
            ])
            ->render([
                'title' => get_admin_page_title(),
                'tabs'=>$this->getTabs(),
                'editionTable' => $editionTable
            ]);

    }
}