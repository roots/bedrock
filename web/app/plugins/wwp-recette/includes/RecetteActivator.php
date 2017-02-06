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

namespace WonderWp\Plugin\Recette;

use Doctrine\ORM\EntityManager;
use WonderWp\APlugin\AbstractPluginActivator;
use WonderWp\DI\Container;

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
class RecetteActivator extends AbstractPluginActivator
{

    /**
     * Create table for entity
     */
    public function activate()
    {
        $this->createTable(RecetteEntity::class);
        $this->createTable(RecetteMeta::class);
        $this->createTable(RecetteEtape::class);
        $this->createTable(Ingredient::class);
        $this->createTable(IngredientTrad::class);

        $this->insertData();
    }

    public function insertData(){
        $container = Container::getInstance();
        /** @var EntityManager $entityManager */
        $entityManager = $container->offsetGet('entityManager');
        //$this->_insertIngredients($entityManager);
    }

    private function _insertIngredients(EntityManager $em){

        $ingredients = array(
            ['pomme-pink'],
            ['amandes'],
            ['avoine'],
            ['graine-courges'],
            ['graine-tournesol'],
            ['cranberries'],
            ['sucre-roux'],
            ['cannelle'],
            ['vanille'],
            ['miel'],
            ['jus-de-fruit'],
            ['huile'],
            ['beurre'],
            ['citron'],
            ['framboise'],
            ['pavot']
        );

        $em->persist();
        $em->flush();

    }

}
