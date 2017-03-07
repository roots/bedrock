<?php

namespace WonderWp\Plugin\Newsletter;

use WonderWp\APlugin\ListTable as WwpListTable;

/**
 * Class NewsletterListTable
 * @package WonderWp\Plugin\Newsletter
 */
class NewsletterListTable extends WwpListTable{

    function prepare_items()
    {
        $passerelleClass = get_option("wwp-newsletter_passerelle");

        /** @var PasserelleInterface $passerelle */
        $passerelle = new $passerelleClass();
        $passerelle->syncListes();

        return parent::prepare_items(); // TODO: Change the autogenerated stub
    }

    /**
     * Compute the columns that are going to be used in the table,
     * if you don\'t want to use them all, just uncomment the foreach, and add to the array the name of all the cols you want to hide.
     * @return array $columns, the array of columns to use with the modules
     */
    function get_columns() {
        $cols = parent::get_columns();
        foreach(array('data') as $col) {
            unset($cols[$col]);
        }
        return $cols;
    }

}