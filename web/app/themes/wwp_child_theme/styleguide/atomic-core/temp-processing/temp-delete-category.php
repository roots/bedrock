<?php
require '../temp-functions/functions.php';


include '../db-inc/dbinc.php';



$catName = $_POST["catName"];
$thisCat = $_POST["thisCat"];
$key = "category";




$settingsdb = $settingsdb->select(array());

$jsDir = $settingsdb[0]['js_directory'];
$jsExt = $settingsdb[0]['js_extension'];
$compDir = $settingsdb[0]['component_directory'];
$compExt = $settingsdb[0]['component_extension'];







$errors         = array();
$data           = array();


if ($catName !== $thisCat){
    $errors['different'] = 'You did not spell <span class="u_textUnderline">'.$thisCat .' </span>correctly.';
}



if ($_POST['catName'] == ""){
    $errors['name'] = 'Input is required.';
}


if ( ! empty($errors)) {
    $data['success'] = false;
    $data['errors']  = $errors;
} else {




    

    deleteCatJsFile($jsDir, $jsExt, $compDir, $thisCat);

    deleteCompDir($catName, $settingsArr);
    deleteScssDir($catName, $settingsArr);
    deleteCatStylesImportString($catName, $settingsArr);
    deleteDbRowByVal($compdb, $key, $catName);
    deleteDbRowByVal($catdb, $key, $catName);











    $data['success'] = true;
    $data['message'] = 'Success!';
}


echo json_encode($data);


