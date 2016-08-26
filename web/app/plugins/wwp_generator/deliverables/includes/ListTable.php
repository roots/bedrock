<?php

namespace __PLUGIN_NS__;

use WonderWp\APlugin\ListTable as WwpListTable;

/**
 * Class __PLUGIN_ENTITY__ListTable
 * @package __PLUGIN_NS__
 */
class __PLUGIN_ENTITY__ListTable extends WwpListTable{

    /**
     * Compute the columns that are going to be used in the table,
     * if you don\'t want to use them all, just uncomment the foreach, and add to the array the name of all the cols you want to hide.
     * @return array $columns, the array of columns to use with the modules
     */
    function get_columns() {
        $cols = parent::get_columns();
        /* foreach(array() as $col) {
            unset($cols[$col]);
        }*/
        return $cols;
    }

}