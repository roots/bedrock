<?php
require 'functions/functions.php';

$config = getConfig();
$compExt = $config['compExt'];

$errors         = array();      // array to hold validation errors
$data           = array();      // array to pass back data

     // validate the variables ======================================================
    // if any of these variables don't exist, add an error to our $errors array
    

    
    $compDir = test_input($_POST["compDir"]);
    $fileCreateName = test_input($_POST["fileCreateName"]);
    $compNotes = test_input($_POST["compNotes"]);
    $bgColor = test_input($_POST["bgColor"]);
    
    
    $fileExists = '../../components/'.$compDir.'/'.$fileCreateName.'.'.$compExt.'';
    
    if (file_exists($fileExists) && $fileCreateName != ""){
        $errors['exists'] = 'A file named '.$fileCreateName.' already exists.';
    }
    
	elseif ($_POST['fileCreateName'] == ""){
        $errors['name'] = 'Name is required.';
    }
        

   

// return a response ===========================================================

    // if there are any errors in our errors array, return a success boolean of false
    if ( ! empty($errors)) {

        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

        // if there are no errors process our form, then return a message
        
        
        // DO ALL YOUR FORM PROCESSING HERE

        createScssFile($compDir, $fileCreateName );

        writeScssImportFile($compDir, $fileCreateName );
    
        createCompFile($compDir, $fileCreateName );
    
        createIncludeString($compDir, $compNotes, $fileCreateName, $bgColor );
    
        createAjaxIncludeAndCompFile($compDir, $fileCreateName);
        
        
        
        

        // show a message of success and provide a true success variable
        $data['success'] = true;
        $data['message'] = 'Success!';
    }

    // return all our data to an AJAX call
    echo json_encode($data);
    

?>


