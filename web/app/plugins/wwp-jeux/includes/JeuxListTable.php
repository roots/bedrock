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
        foreach(array('visuel','contenu','pageDotation','pageReglement','pageGagnants','pageJeux') as $col) {
            unset($cols[$col]);
        }
        return $cols;
    }

    public function column_default($item, $column_name)
    {
        switch($column_name) {
            case'mecaniqueGain':
                $val = $this->_getItemVal($item, $column_name);
                $frags = explode('\\',$val);
                echo end($frags);
                break;
            default:
                parent::column_default($item, $column_name);
                break;
        }
    }

}