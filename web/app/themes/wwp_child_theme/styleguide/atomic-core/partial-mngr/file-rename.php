<?php

require 'functions/functions.php';

$config = getConfig();
$compExt = $config['compExt'];

$errors         = array();      // array to hold validation errors
$data           = array();      // array to pass back data

// validate the variables ======================================================
    // if any of these variables don't exist, add an error to our $errors array
    

    
    $renameFileName = test_input($_POST["renameFileName"]);
    $catName = test_input($_POST["compDir"]);
    $oldName = test_input($_POST["oldName"]);
    $compNotes = test_input($_POST["compNotes"]);
    $bgColor = test_input($_POST["bgColor"]);

    
    $fileExists = '../../components/'.$catName.'/'.$renameFileName.'.'.$compExt.'';
    
    if (file_exists($fileExists) && $renameFileName != ""){
        $errors['exists'] = 'Please enter a unique component name.';
    }
    
    elseif ($_POST['renameFileName'] == ""){
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





        changeCommentString($catName, $renameFileName, $oldName);

        changeScssCommentString($catName, $renameFileName, $oldName);
        
        renameScssFile($catName, $renameFileName, $oldName);



        
        
        deleteScssImportString($catName, $oldName );
        
        writeScssImportFile($catName, $renameFileName );
        
        renameCompFile($catName, $renameFileName, $oldName);
        
        deleteCompIncludetString($catName, $compNotes, $oldName, $bgColor );
        
        createIncludeString($catName, $compNotes, $renameFileName, $bgColor );
        
        deleteAjaxCompFile($catName, $oldName);
        
        createAjaxIncludeAndCompFile($catName, $renameFileName);
        
        
        
        

        // show a message of success and provide a true success variable
        $data['success'] = true;
        $data['message'] = 'Success!';
    }

    // return all our data to an AJAX call
    echo json_encode($data);
    

?>

