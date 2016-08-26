<?php
require '../../atomic-config.php';
require 'functions/functions.php';

$config = getConfig();
$scssDir = $config['preCssDir'];


$errors         = array();      // array to hold validation errors
$data           = array();      // array to pass back data

// validate the variables ======================================================
    // if any of these variables don't exist, add an error to our $errors array
    
    $dirName = test_input($_POST["dirName"]);
    
    
    
    $compFilePath = '../../components/'.$dirName.'';
    $scssFilePath = '../../'.$scssDir.'/'.$dirName.'';
    
    if (!file_exists($compFilePath) && !file_exists($scssFilePath) && $dirName != ""){
        $errors['exists'] = 'There is not a category named '.$dirName.'.';
    }
    elseif ($_POST['dirName'] == ""){
        $errors['name'] = 'Input is required.';
    }
        

// return a response ===========================================================

    // if there are any errors in our errors array, return a success boolean of false
    if ( ! empty($errors)) {
        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {
        
        // DO ALL YOUR FORM PROCESSING HERE




   
        deleteAtomicNavIncludeString($dirName);
        deleteCatPageFile($dirName);
        deleteAtomicCatDir($dirName);

        deleteCompDir($dirName);
        deleteCatScssImportString($dirName);
        deleteScssDir($dirName);
        





        
        // show a message of success and provide a true success variable
        $data['success'] = true;
        $data['message'] = 'Success!';
    }

    // return all our data to an AJAX call
    echo json_encode($data);
    

?>


