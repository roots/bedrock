<?php

namespace WonderWp\Plugin\EspaceRestreint;

use WonderWp\APlugin\ListTable as WwpListTable;

/**
 * Class MembreListTable
 * @package WonderWp\Plugin\EspaceRestreint
 */
class MembreListTable extends WwpListTable{

    /**
     * Compute the columns that are going to be used in the table,
     * if you don\'t want to use them all, just uncomment the foreach, and add to the array the name of all the cols you want to hide.
     * @return array $columns, the array of columns to use with the modules
     */
    function get_columns() {
        $cols = parent::get_columns();
        foreach(array('civilite','dob','adress','cp','city','country','children','password','codeParrain','consoPommes','registerNl') as $col) {
            unset($cols[$col]);
        }
        return $cols;
    }

}