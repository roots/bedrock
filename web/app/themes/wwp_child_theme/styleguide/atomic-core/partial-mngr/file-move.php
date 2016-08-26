<?php
require '../../atomic-config.php';
require 'functions/functions.php';

$config = getConfig();
$compExt = $config['compExt'];

$errors         = array();      // array to hold validation errors
$data           = array();      // array to pass back data

// validate the variables ======================================================
    // if any of these variables don't exist, add an error to our $errors array
    

    
    $fileMoveName = test_input($_POST["fileMoveName"]);
    $compDir = test_input($_POST["compDir"]);
    $newDir = test_input($_POST["newDir"]);
    $compNotes = test_input($_POST["compNotes"]);
    $bgColor = test_input($_POST["bgColor"]);
    
    
    
    
    $fileExists = '../../components/'.$newDir.'/'.$fileMoveName.'.'.$compExt.'';
    
    if (file_exists($fileExists) && $fileMoveName != ""){
        $errors['exists'] = 'A file named '.$fileMoveName .' already exists in that destination.';
    }
    
    /*elseif ($_POST['renameFileName'] == ""){
        $errors['name'] = 'Name is required.';
    }*/



// return a response ===========================================================

    // if there are any errors in our errors array, return a success boolean of false
    if ( ! empty($errors)) {

        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

        // if there are no errors process our form, then return a message
        
        
        // DO ALL YOUR FORM PROCESSING HERE

        moveChangeCommentString($compDir, $fileMoveName, $newDir);

        moveScssChangeCommentString($compDir, $fileMoveName, $newDir);

        moveScssFile($compDir, $fileMoveName, $newDir);
        
        deleteScssImportString($compDir, $fileMoveName );
        
        writeScssImportFile($newDir, $fileMoveName );
        
        moveCompFile($compDir, $fileMoveName, $newDir);
        
        
        deleteCompIncludetString ($compDir, $compNotes, $fileMoveName, $bgColor );
        
        createIncludeString($newDir, $compNotes, $fileMoveName, $bgColor );
        
        
        
        deleteAjaxCompFile($compDir, $fileMoveName);
        
        createAjaxIncludeAndCompFile($newDir, $fileMoveName);
        




        
        

        // show a message of success and provide a true success variable
        $data['success'] = true;
        $data['message'] = 'Success!';
    }

    // return all our data to an AJAX call
    echo json_encode($data);
    

?>







<?php



/*if (!empty($_POST['moveFile'])){


  $fileName = test_input($_POST["fileName"]);
  $catName = test_input($_POST["compDir"]);
  $newDir = test_input($_POST["newDir"]);



    moveChangeCommentString($catName, $fileName, $newDir);

    moveScssFile($catName, $fileName, $newDir);
    
    deleteScssImportString($catName, $fileName );
    
    writeScssImportFile($newDir, $fileName );
    
    moveCompFile($catName, $fileName, $newDir);
    
    deleteCompIncludetString($catName, $fileName );
    
    createIncludeString($newDir, $fileName );
    
    deleteAjaxCompFile($catName, $fileName);
    
    createAjaxIncludeAndCompFile($newDir, $fileName);
    
    
    header("location: http://127.0.0.1/atomic-docs/atomic-core/$newDir.php");

  }*/


?>