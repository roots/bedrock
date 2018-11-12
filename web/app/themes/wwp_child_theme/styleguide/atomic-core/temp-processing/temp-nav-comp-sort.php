<?php

require '../temp-functions/functions.php';

include '../db-inc/dbinc.php';

$errors = array();
$data = array();

$compName = $_POST["compName"];
$catName = $_POST["currentCat"];





if (!empty($errors)) {

    $data['success'] = false;
    $data['errors'] = $errors;
} else {



    stylesCompRootOrder($compName, $catName, $settingsArr);

    navCompOrder($compdb, $compName);


    $data['success'] = true;
    $data['message'] = 'Success!';
}
// return all our data to an AJAX call
echo json_encode($data);








