<?php
require '../temp-functions/functions.php';



include '../db-inc/dbinc.php';








$compDir = $_POST["compDir"];
$compExt = $_POST["compExt"];
$stylesExt = $_POST["stylesExt"];
$stylesDir = $_POST["stylesDir"];

$compDir = str_replace(array('.', ','), '' , $compDir);
$compExt = str_replace(array('.', ','), '' , $compExt);
$stylesExt = str_replace(array('.', ','), '' , $stylesExt);
$stylesDir = str_replace(array('.', ','), '' , $stylesDir);



$old_compDir = $_POST["old_compDir"];
$old_compExt = $_POST["old_compExt"];
$old_stylesExt = $_POST["old_stylesExt"];
$old_stylesDir = $_POST["old_stylesDir"];


$old_compDir = str_replace(array('.', ','), '' , $old_compDir);
$old_compExt = str_replace(array('.', ','), '' , $old_compExt);
$old_stylesExt = str_replace(array('.', ','), '' , $old_stylesExt);
$old_stylesDir = str_replace(array('.', ','), '' , $old_stylesDir);



$errors         = array();
$data           = array();



if ($_POST['compDir'] == "" || $_POST['compExt'] == "" || $_POST['stylesExt'] == "" || $_POST['stylesDir'] == "" ){
    $errors['name'] = 'Input is required.';
}


if ( ! empty($errors)) {
    $data['success'] = false;
    $data['errors']  = $errors;
} else {







    dbUpdateSettings($settingsdb, $compDir, $compExt, $stylesExt, $stylesDir);

    changeRootStylesExt($old_stylesDir, $old_stylesExt, $stylesExt);

    editStylesComment($old_stylesDir, $old_stylesExt, $stylesExt, $stylesDir);



    editStyleExt($old_stylesDir, $old_stylesExt, $stylesExt);
    renameStyleDirSettings($old_stylesDir, $stylesDir);





     editCompComment($old_compDir, $old_compExt, $compExt, $compDir);
    editCompExt($old_compDir, $old_compExt, $compExt);
    renameCompDirSettings($old_compDir, $compDir);















    $data['success'] = true;
    $data['message'] = 'Success!';
}


echo json_encode($data);


