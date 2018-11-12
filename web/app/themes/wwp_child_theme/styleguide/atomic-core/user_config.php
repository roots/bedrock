<?php


function getConfig($path_to_db)
{


    $settings = new Fllat("settings", "$path_to_db/atomic-db");
    $settings = $settings->select(array());

    return $settings;




}

