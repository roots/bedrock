<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 15:40
 */

namespace WonderWp\Plugin\Recette;


use WonderWp\APlugin\AbstractManager;
use WonderWp\DI\Container;
use WonderWp\Route\AbstractRouteService;

class RecetteRouteService extends AbstractRouteService
{
    public function getRoutes(){
        if(empty($this->_routes)) {
            $manager = Container::getInstance()->offsetGet('wwp-recette.Manager');
            $this->_routes = array(
                ['(.*)/arome/{arome}/typeplat/{typeplat}/instant/{instant}/pageno/{pageno}','index.php?pagename=$matches[1]&arome=$matches[2]&typeplat=$matches[3]&instant=$matches[4]&pageno=$matches[5]','GET'],
                ['(.*)/arome/{arome}/typeplat/{typeplat}/instant/{instant}','index.php?pagename=$matches[1]&arome=$matches[2]&typeplat=$matches[3]&instant=$matches[4]','GET'],

                ['(.*)/arome/{arome}/typeplat/{typeplat}/pageno/{pageno}','index.php?pagename=$matches[1]&arome=$matches[2]&typeplat=$matches[3]&pageno=$matches[4]','GET'],
                ['(.*)/arome/{arome}/typeplat/{typeplat}','index.php?pagename=$matches[1]&arome=$matches[2]&typeplat=$matches[3]','GET'],
                ['(.*)/arome/{arome}/instant/{instant}/pageno/{pageno}','index.php?pagename=$matches[1]&arome=$matches[2]&instant=$matches[3]&pageno=$matches[4]','GET'],
                ['(.*)/arome/{arome}/instant/{instant}','index.php?pagename=$matches[1]&arome=$matches[2]&instant=$matches[3]','GET'],
                ['(.*)/typeplat/{typeplat}/instant/{instant}/pageno/{pageno}','index.php?pagename=$matches[1]&typeplat=$matches[2]&instant=$matches[3]&pageno=$matches[4]','GET'],
                ['(.*)/typeplat/{typeplat}/instant/{instant}','index.php?pagename=$matches[1]&typeplat=$matches[2]&instant=$matches[3]','GET'],

                ['(.*)/arome/{arome}/pageno/{pageno}','index.php?pagename=$matches[1]&arome=$matches[2]&pageno=$matches[3]','GET'],
                ['(.*)/arome/{arome}','index.php?pagename=$matches[1]&arome=$matches[2]','GET'],
                ['(.*)/typeplat/{typeplat}/pageno/{pageno}','index.php?pagename=$matches[1]&typeplat=$matches[2]&pageno=$matches[3]','GET'],
                ['(.*)/typeplat/{typeplat}','index.php?pagename=$matches[1]&typeplat=$matches[2]','GET'],
                ['(.*)/instant/{instant}/pageno/{pageno}','index.php?pagename=$matches[1]&instant=$matches[2]&pageno=$matches[3]','GET'],
                ['(.*)/instant/{instant}','index.php?pagename=$matches[1]&instant=$matches[2]','GET'],

                ['recette/resetfilters/{previousRecettePageId}',array($manager->getController(AbstractManager::$PUBLICCONTROLLERTYPE),'resetFilters'),'GET'],
                ['recette/{recetteSlug}',array($manager->getController(AbstractManager::$PUBLICCONTROLLERTYPE),'recetteAction'),'GET']
            );
        }

        return $this->_routes;
    }
}