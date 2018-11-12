<?php
require '../temp-functions/functions.php';


include '../db-inc/dbinc.php';


$key = "component";

$catName = $_POST["catName"];
$compName = $_POST["compName"];
$hasJs = $_POST["hasJs"];


$errors = array();
$data = array();



if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {



    deleteDbRowByVal($compdb, $key, $compName);
    deleteCompFile($catName, $compName, $settingsArr);
    deleteStyleFile($catName, $compName, $settingsArr);
    deleteScssImportString($catName, $compName, $settingsArr);


    if($hasJs == "true"){
        deleteJsFile($compName, $settingsArr);
    }











    $data['success'] = true;
    $data['message'] = 'Success!';
}


echo json_encode($data);


