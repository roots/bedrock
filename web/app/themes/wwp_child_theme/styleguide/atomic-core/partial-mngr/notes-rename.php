<?php
require '../../atomic-config.php';
require 'functions/functions.php';

$config = getConfig();
$compExt = $config['compExt'];

$errors         = array();      // array to hold validation errors
$data           = array();      // array to pass back data

// validate the variables ======================================================
    // if any of these variables don't exist, add an error to our $errors array
    


    
    $compDir = test_input($_POST["compDir"]);
    $compNotes = test_input($_POST["compNotes"]);
    $compNotesNew = test_input($_POST["compNotesNew"]);
    $fileName = test_input($_POST["fileName"]);
    $bgColor = test_input($_POST["bgColor"]);
    



// return a response ===========================================================

    // if there are any errors in our errors array, return a success boolean of false
    if ( ! empty($errors)) {

        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

        // if there are no errors process our form, then return a message
        
        
        // DO ALL YOUR FORM PROCESSING HERE




        changeIncludeString($compDir, $compNotes, $compNotesNew, $fileName, $bgColor);
        
        
        
        

        // show a message of success and provide a true success variable
        $data['success'] = true;
        $data['message'] = 'Success!';
    }

    // return all our data to an AJAX call
    echo json_encode($data);
    

?>