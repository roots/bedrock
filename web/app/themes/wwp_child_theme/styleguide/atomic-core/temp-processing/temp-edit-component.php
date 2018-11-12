<?php
require '../temp-functions/functions.php';


include '../db-inc/dbinc.php';





$newName = $_POST["newName"];
$catName = $_POST["catName"];
$compNotes = $_POST["compNotes"];
$bgColor = $_POST["bgColor"];
$dataColor = $_POST["dataColor"];
$create_js_file = $_POST["js_file"];
$hasJs = $_POST["hasJs"];
$oldName = $_POST["oldName"];


$jsDir = $settingsArr[0]['js_directory'];
$jsExt = $settingsArr[0]['js_extension'];



$errors = array();
$data = array();




if ($_POST['newName'] == "") {
    $errors['name'] = 'Input is required.';
}


if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {


    if( empty($bgColor) ){
        $bgColor = $dataColor;
    }
    else{
        $bgColor = $bgColor;
    }



    if($create_js_file == "true"){
        createJsFile($newName, $jsDir, $jsExt);
        createJsComment($newName, $settingsArr);

        $create_js_file = "true";

        $hasJs = "true";
    }


    if($hasJs == "true"){
        renameJsFile($newName, $oldName, $settingsArr);
        editJsCommentString($oldName, $newName, $settingsArr);
    }



    dbUpdateComp($compdb, $oldName, $newName, $catName, $bgColor, $compNotes, $hasJs);
    
    
    renameCompFile($catName, $newName, $oldName, $settingsArr);
    editCompCommentString($catName, $oldName, $newName, $settingsArr);
    renameStylesFile($catName, $newName, $oldName, $settingsArr);
    editStyleCommentString($catName, $oldName, $newName, $settingsArr);
    editStyleRootImportString($catName, $oldName, $newName, $settingsArr);
















    $data['success'] = true;
    $data['message'] = 'Success!';
}


echo json_encode($data);


