<?php
require '../temp-functions/functions.php';

include '../db-inc/dbinc.php';

$errors         = array();      // array to hold validation errors
$data           = array();      // array to pass back data
$compName = $_POST["compName"];
$catName = $_POST["catName"];
$newMarkupCode = $_POST["newMarkupCode"];
$newStylesCode = $_POST["newStylesCode"];
$newJsCode = $_POST["newJsCode"];






/*
if ($newCode == ""){
    $errors['name'] = 'No change detected';
}*/
// return a response ===========================================================
// if there are any errors in our errors array, return a success boolean of false
if ( ! empty($errors)) {
    // if there are items in our errors array, return those errors
    $data['success'] = false;
    $data['errors']  = $errors;
} else {


    function editorCodeUpdate($compName,$catName,$newMarkupCode, $newStylesCode, $newJsCode, $settingsArr){



        $compExt = $settingsArr[0]['component_extension'];
        $stylesExt = $settingsArr[0]['styles_extension'];
        $stylesDir = $settingsArr[0]['styles_directory'];
        $compDir = $settingsArr[0]['component_directory'];
        $jsDir = $settingsArr[0]['js_directory'];
        $jsExt = $settingsArr[0]['js_extension'];



        $compPath = '../../' . $compDir . '/' . $catName . '/'.$compName.'.'. $compExt .'';
        file_put_contents($compPath, $newMarkupCode);

        $stylesPath = '../../' . $stylesDir . '/' . $catName . '/_'.$compName.'.'. $stylesExt .'';
        file_put_contents($stylesPath, $newStylesCode);


        if($newJsCode == "noJs"){

        }
        else{
            $jsPath = '../../'.$jsDir.'/'.$compName.'.'.$jsExt.'';
            file_put_contents($jsPath, $newJsCode);
        }







    }
    editorCodeUpdate($compName,$catName,$newMarkupCode, $newStylesCode, $newJsCode, $settingsArr);
    // show a message of success and provide a true success variable
    $data['success'] = true;
    $data['message'] = 'Success!';
}
// return all our data to an AJAX call
echo json_encode($data);