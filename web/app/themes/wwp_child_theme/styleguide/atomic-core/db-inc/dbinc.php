<?php

require "../fllat.php";

$catdb = new Fllat("categories", "../../atomic-db");

$compdb = new Fllat("components", "../../atomic-db");


$settingsdb = new Fllat("settings", "../../atomic-db");

$settingsArr = $settingsdb->select(array());



$stylesDir = $settingsArr[0]['styles_directory'];
$compDir = $settingsArr[0]['component_directory'];


global $compdb;
global $catdb;

