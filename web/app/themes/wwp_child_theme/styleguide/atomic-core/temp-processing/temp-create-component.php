<?php
require '../temp-functions/functions.php';



include '../db-inc/dbinc.php';


$errors = array();
$data = array();


$catName = test_input($_POST["catName"]);
$compName = test_input($_POST["compName"]);
$compNotes = test_input($_POST["compNotes"]);
$bgColor = test_input($_POST["bgColor"]);

$js_file = test_input($_POST["js_file"]);




$stylesDir = $settingsArr[0]['styles_directory'];
$stylesExt = $settingsArr[0]['styles_extension'];
$compDir = $settingsArr[0]['component_directory'];
$compExt = $settingsArr[0]['component_extension'];
$jsDir = $settingsArr[0]['js_directory'];
$jsExt = $settingsArr[0]['js_extension'];


$filename = '../../'.$compDir.'/'.$catName.'/'.$compName.'.'.$compExt.'';
$scssFilePath = '../../'.$stylesDir.'/'.$catName.'/_'.$compName.'.'.$stylesExt.'';

if (file_exists($filename) || file_exists($scssFilePath) && $catName != ""){
    $errors['exists'] = 'The component '.$compName.' already exists.';
}




if ($_POST['compName'] == ""){
    $errors['name'] = 'Component name is required.';
}


// return a response ===========================================================

// if there are any errors in our errors array, return a success boolean of false
if (!empty($errors)) {

    // if there are items in our errors array, return those errors
    $data['success'] = false;
    $data['errors'] = $errors;
} else {







    addCompDbItem($compName, $catName, $compNotes, $bgColor, $js_file, $compdb);
    createCompFile($catName, $compName, $settingsArr);
    createCompComment($catName, $compName, $settingsArr);
    createStylesFile($catName, $compName, $settingsArr);
    createStyleComment($catName, $compName, $settingsArr);
    writeStylesImport($catName, $compName, $settingsArr);





    $data['success'] = true;
    $data['message'] = 'Success!';
}

echo json_encode($data);








/*
<?php

require '../temp-functions/functions.php';



include '../db-inc/dbinc.php';


$errors = array();
$data = array();


$catName = test_input($_POST["catName"]);
$compName = test_input($_POST["compName"]);
$compNotes = test_input($_POST["compNotes"]);
$bgColor = test_input($_POST["bgColor"]);

$js_file = test_input($_POST["js_file"]);




$stylesDir = $settingsArr[0]['styles_directory'];
$stylesExt = $settingsArr[0]['styles_extension'];
$compDir = $settingsArr[0]['component_directory'];
$compExt = $settingsArr[0]['component_extension'];
$jsDir = $settingsArr[0]['js_directory'];
$jsExt = $settingsArr[0]['js_extension'];


$filename = '../../'.$compDir.'/'.$catName.'/'.$compName.'.'.$compExt.'';
$scssFilePath = '../../'.$stylesDir.'/'.$catName.'/_'.$compName.'.'.$stylesExt.'';

if (file_exists($filename) || file_exists($scssFilePath) && $catName != ""){
    $errors['exists'] = 'The component '.$compName.' already exists.';
}




if ($_POST['compName'] == ""){
    $errors['name'] = 'Component name is required.';
}


// return a response ===========================================================

// if there are any errors in our errors array, return a success boolean of false
if (!empty($errors)) {

    // if there are items in our errors array, return those errors
    $data['success'] = false;
    $data['errors'] = $errors;
} else {



    if($js_file == "true"){

        createJsFile($compName, $jsDir, $jsExt);
        createJsComment($compName, $settingsArr);


    }



    addCompDbItem($compName, $catName, $compNotes, $bgColor, $js_file, $compdb);
    createCompFile($catName, $compName, $settingsArr);
    createCompComment($catName, $compName, $settingsArr);
    createStylesFile($catName, $compName, $settingsArr);
    createStyleComment($catName, $compName, $settingsArr);
    writeStylesImport($catName, $compName, $settingsArr);





    $data['success'] = true;
    $data['message'] = 'Success!';
}

echo json_encode($data);
*/

