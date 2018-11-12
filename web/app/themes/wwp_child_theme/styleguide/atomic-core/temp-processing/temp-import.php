<?php
require '../temp-functions/functions.php';



require "../fllat.php";

$catdb = new Fllat("categories", "../../atomic-db");
$compdb = new Fllat("components", "../../atomic-db");



$stylesDir = $settingsArr[0]['styles_directory'];
$compDir = $settingsArr[0]['component_directory'];


$errors         = array();
$success        = array();

$data           = array();






/*$filename = '../../'.$compDir.'/'.$catName.'';
$scssFilePath = '../../'.$stylesDir.'/'.$catName.'';

if (file_exists($filename) || file_exists($scssFilePath) && $catName != ""){
    $errors['exists'] = 'The category '.$catName .' already exists.';
}


if ($_POST['catName'] == ""){
    $errors['name'] = 'Input is required.';
}*/


if ( ! empty($errors)) {

    $data['success'] = false;
    $data['errors']  = $errors;
} else {



    $old_compDir = 'components';
    $old_compExt = 'php';


    $old_stylesDir = 'scss';
    $old_stylesExt = 'scss';






    importCompsDb($old_compDir, $old_compExt, $catdb, $compdb);


    importCheckRootStyleString($old_stylesDir, $old_stylesExt);


    importCheckMainRootStyleString($old_stylesDir, $old_stylesExt);


    /*$data['success']  = $errors;
    $success['imported'] = 'Import complete. Compile your scss.';*/


    $data['success'] = true;
    $data['message'] = 'Import successful. Compile your CSS and verify everything looks as it should.';



}


echo json_encode($data);


