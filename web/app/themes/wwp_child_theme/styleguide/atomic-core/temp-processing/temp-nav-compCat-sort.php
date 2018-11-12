<?php

require '../temp-functions/functions.php';

include '../db-inc/dbinc.php';

$errors = array();
$data = array();

$compName = $_POST["compName"];
$newCat = $_POST["newCat"];
$oldCat = $_POST["oldCat"];
$thisCompName = $_POST["thisCompName"];



$stylesDir = $settingsArr[0]['styles_directory'];
$stylesExt = $settingsArr[0]['styles_extension'];
$compDir = $settingsArr[0]['component_directory'];
$compExt = $settingsArr[0]['component_extension'];


$filename = '../../'.$compDir.'/'.$newCat.'/'.$thisCompName.'.'.$compExt.'';
$scssFilePath = '../../'.$stylesDir.'/'.$newCat.'/_'.$thisCompName.'.'.$stylesExt.'';

if (file_exists($filename) || file_exists($scssFilePath) && $catName != ""){
    $errors['exists'] = 'A component named '.$thisCompName .' already exists in the target location.';
}






if (!empty($errors)) {

    $data['success'] = false;
    $data['errors'] = $errors;
} else {






    navCatCompOrder($compdb, $compName, $newCat);
    stylesCompRootOrder($compName, $newCat, $settingsArr);
    deleteStylesImportString($thisCompName, $oldCat, $settingsArr);
    moveCompFile($oldCat, $thisCompName, $newCat, $settingsArr);
    moveStyleFile($oldCat, $thisCompName, $newCat, $settingsArr);

    editAllCompCommentStrings($oldCat, $newCat, $settingsArr);


    editAllStyleCommentStrings($oldCat, $newCat, $settingsArr);



    $data['success'] = true;
    $data['message'] = 'Success!';
}
// return all our data to an AJAX call
echo json_encode($data);








