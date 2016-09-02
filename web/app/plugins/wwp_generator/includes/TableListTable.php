<?php

namespace WonderWp\Plugin\Generator;

use WonderWp\APlugin\ListTable as WwpListTable;

class TableListTable extends \WP_List_Table{

    private $_baseUrl;

    public function prepare_items()
    {
        global $wpdb;

        $tables = array_keys($wpdb->get_results( "SHOW TABLES",OBJECT_K ));
        if(!empty($tables)){ foreach($tables as $table){
            $this->items[] = array('table'=>$table);
        }}

        $this->_defineColumnHeaders();

        $this->_baseUrl = admin_url('/tools.php?page='.WWP_PLUGIN_GENERATOR_NAME);

        return $this;
    }

    protected function _defineColumnHeaders(){
        //Register the Columns
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
    }

    public function get_columns()
    {
        $columns =array(
            'table'=>'Table'
        );
        return $columns;
    }

    public function get_hidden_columns(){
        return array();
    }

    public function get_sortable_columns(){
        return array();
    }

    function get_bulk_actions() {
        $actions = array(
            'generate'    => __('Generate')
        );
        return $actions;
    }

    public function column_default($item, $column_name){
        if($column_name=='table'){ echo'<a href="'.$this->_baseUrl.'&action=pluginForm&table='.$item[$column_name].'">'; }
        echo !empty($item[$column_name]) ? $item[$column_name] : ' ' ;
        if($column_name=='table'){ echo'</a>'; }
    }

}