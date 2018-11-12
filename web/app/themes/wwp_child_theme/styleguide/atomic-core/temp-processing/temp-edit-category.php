<?php
require '../temp-functions/functions.php';

include '../db-inc/dbinc.php';



$catName = $_POST["catName"];
$thisCat = $_POST["thisCat"];
$key = "category";

$errors         = array();
$data           = array();






if ($_POST['catName'] == ""){
    $errors['name'] = 'Input is required.';
}


if ( ! empty($errors)) {
    $data['success'] = false;
    $data['errors']  = $errors;
} else {





    dbUpdateItems($catdb, $key, $thisCat, $catName);
    dbUpdateItems($compdb, $key, $thisCat, $catName);
    renameCompDir($thisCat, $catName, $settingsArr);
    //update all comp file comment strings
    renameStyleDir($thisCat, $catName, $settingsArr);
    renameStylesRoot($catName, $thisCat, $settingsArr);
    //update all style file comment stings
    changeRootStylesImportString($catName, $thisCat, $settingsArr);






    editAllCompCommentStrings($thisCat, $catName, $settingsArr);





    editAllStyleCommentStrings($thisCat, $catName, $settingsArr);




    $data['success'] = true;
    $data['message'] = 'Success!';
}


echo json_encode($data);


