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

namespace WonderWp\Plugin\Recette;

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
class RecetteAdminController extends AbstractPluginBackendController{

    /**
     * Create here the method to call for you different routes
     */

    public function getTabs()
    {
        $tabs = array(
            1 => array('action' => 'list', 'libelle' => 'Gestion des recettes'),
            2 => array('action' => 'listIngredients', 'libelle' => 'Gestion des ingrédients')
        );
        return $tabs;
    }

    public function listIngredientsAction(){
        $container = Container::getInstance();

        $listTableInstance = new IngredientListTable();
        $listTableInstance->setEntityName(Ingredient::class);
        $listTableInstance->setTextDomain(WWP_RECETTE_TEXTDOMAIN);

        parent::listAction($listTableInstance);
    }

    public function editIngredientAction(){
        $modelForm = new IngredientForm();
        parent::editAction(Ingredient::class,$modelForm);
    }

}
