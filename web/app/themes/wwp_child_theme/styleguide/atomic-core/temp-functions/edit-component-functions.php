<?php

function dbUpdateComp($db, $oldName, $newName, $catName, $bgColor, $compNotes, $hasJs){

    $selectDB = $db->select(array());

    for($i=count($selectDB)-1; $i>=0; $i--){

        if ($selectDB[$i]["component"] == $oldName && $selectDB[$i]["category"] == $catName) {
            $new_name = array("component" => $newName);
            $db->update($i, $new_name);

            $new_notes = array("description" => $compNotes);
            $db->update($i, $new_notes);

            $new_bg = array("backgroundColor" => $bgColor);
            $db->update($i, $new_bg);

            $new_js = array("has_js" => $hasJs);
            $db->update($i, $new_js);

        }
    }
}

function renameJsFile($newName, $oldName, $settingsArr){


    $jsDir = $settingsArr[0]['js_directory'];
    $jsExt = $settingsArr[0]['js_extension'];



    $old = "../../$jsDir/$oldName.$jsExt";
    $new = "../../$jsDir/$newName.$jsExt";

        rename($old,$new);





}

function editJsCommentString($oldName, $newName, $settingsArr)
{



    $jsDir = $settingsArr[0]['js_directory'];
    $jsExt = $settingsArr[0]['js_extension'];

  


        $oldString = '/* '.$jsDir.'/'.$oldName.'.'.$jsExt.' */';
        $newString = '/* '.$jsDir.'/'.$newName.'.'.$jsExt.' */';
        $contents = file_get_contents('../../'.$jsDir.'/'.$newName.'.'.$jsExt.'');
        $contents = str_replace($oldString, $newString , $contents);
        file_put_contents('../../'.$jsDir.'/'.$newName.'.'.$jsExt.'', $contents);



}


function renameCompFile($catName, $newName, $oldName, $settingsArr){


    $compDir = $settingsArr[0]['component_directory'];
    $compExt = $settingsArr[0]['component_extension'];

    $old = "../../$compDir/$catName/$oldName.$compExt";
    $new = "../../$compDir/$catName/$newName.$compExt";

    rename($old,$new);
}







function editCompCommentString($catName, $oldName, $newName, $settingsArr)
{



    $compDir = $settingsArr[0]['component_directory'];
    $compExt = $settingsArr[0]['component_extension'];

    $oldString = '<!-- '.$compDir.'/'.$catName.'/'.$oldName.'.'.$compExt.' -->';
    $newString = '<!-- '.$compDir.'/'.$catName.'/'.$newName.'.'.$compExt.' -->';


    $contents = file_get_contents('../../'.$compDir.'/'.$catName.'/'.$newName.'.'.$compExt.'');
    $contents = str_replace($oldString, $newString , $contents);
    file_put_contents('../../'.$compDir.'/'.$catName.'/'.$newName.'.'.$compExt.'', $contents);
}










function renameStylesFile($catName, $newName, $oldName, $settingsArr){



    $stylesDir = $settingsArr[0]['styles_directory'];
    $stylesExt = $settingsArr[0]['styles_extension'];

    $old = "../../$stylesDir/$catName/_$oldName.$stylesExt";
    $new = "../../$stylesDir/$catName/_$newName.$stylesExt";

    rename($old,$new);
}

function editStyleCommentString($catName, $oldName, $newName, $settingsArr)
{



    $stylesDir = $settingsArr[0]['styles_directory'];
    $stylesExt = $settingsArr[0]['styles_extension'];

    $oldString = '/* '.$stylesDir.'/'.$catName.'/_'.$oldName.'.'.$stylesExt.' */';
    $newString = '/* '.$stylesDir.'/'.$catName.'/_'.$newName.'.'.$stylesExt.' */';


    $contents = file_get_contents('../../'.$stylesDir.'/'.$catName.'/_'.$newName.'.'.$stylesExt.'');
    $contents = str_replace($oldString, $newString , $contents);
    file_put_contents('../../'.$stylesDir.'/'.$catName.'/_'.$newName.'.'.$stylesExt.'', $contents);
}




function editStyleRootImportString($catName, $oldName, $newName, $settingsArr)
{



    $stylesDir = $settingsArr[0]['styles_directory'];
    $stylesExt = $settingsArr[0]['styles_extension'];

    $oldString = '@import "_'.$oldName.'";';
    $newString = '@import "_'.$newName.'";';


    $contents = file_get_contents('../../'.$stylesDir.'/'.$catName.'/_'.$catName.'.'.$stylesExt.'');
    $contents = str_replace($oldString, $newString , $contents);
    file_put_contents('../../'.$stylesDir.'/'.$catName.'/_'.$catName.'.'.$stylesExt.'', $contents);
}




















