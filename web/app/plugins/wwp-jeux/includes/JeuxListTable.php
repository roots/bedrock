<?php

namespace WonderWp\Plugin\Jeux;

use WonderWp\APlugin\ListTable as WwpListTable;

/**
 * Class JeuxListTable
 * @package WonderWp\Plugin\Jeux
 */
class JeuxListTable extends WwpListTable{

    /**
     * Compute the columns that are going to be used in the table,
     * if you don\'t want to use them all, just uncomment the foreach, and add to the array the name of all the cols you want to hide.
     * @return array $columns, the array of columns to use with the modules
     */
    function get_columns() {
        $cols = parent::get_columns();
        foreach(array('visuel','contenu','pageDotation','pageReglement','pageGagnants') as $col) {
            unset($cols[$col]);
        }
        return $cols;
    }

}