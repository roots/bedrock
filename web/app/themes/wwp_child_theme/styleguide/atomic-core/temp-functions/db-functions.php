<?php

function addCatDbItem($catName, $catdb){

    $categories = $catdb->select(array());

    $i=count($categories);


    $newCat = array("category" => $catName, "order" => $i+1);
    $catdb -> add($newCat);


}

function addCompDbItem($compName, $catName, $compNotes, $bgColor, $js_file, $db){


    $dbSelect = $db->select(array());
    $i=count($dbSelect);


    $newComp = array("component" => $compName, "category" => $catName, "description" => $compNotes, "backgroundColor" => $bgColor, "order" => -$i+1, "has_js" => $js_file);
    $db -> add($newComp);
}



function deleteDbRowByVal($db, $key, $value){

    $selectDB = $db->select(array());

    for($i=count($selectDB)-1; $i>=0; $i--){

        if ($selectDB[$i][$key] == $value) {
            $db ->rm($i);
        }
    }
}


function dbUpdateItems($db, $key, $oldValue, $update_value){

    $selectDB = $db->select(array());

    for($i=count($selectDB)-1; $i>=0; $i--){

        if ($selectDB[$i][$key] == $oldValue) {
            $new_value = array($key => $update_value);
            $db->update($i, $new_value);
        }
    }
}




function dbUpdateCompJs($db, $compName, $hasJs){

    $selectDB = $db->select(array());

    for($i=count($selectDB)-1; $i>=0; $i--){

        if ($selectDB[$i]["component"] == $compName) {

            $new_js = array("has_js" => $hasJs);
            $db->update($i, $new_js);

        }
    }
}







function dbUpdateSettings($settings, $compDir, $compExt, $stylesExt, $stylesDir){


    $new_compDir = array("component_directory" => $compDir);
    $settings->update(0, $new_compDir);

    $new_compExt = array("component_extension" => $compExt);
    $settings->update(0, $new_compExt);

    $new_stylesExt = array("styles_extension" => $stylesExt);
    $settings->update(0, $new_stylesExt);

    $new_stylesDir = array("styles_directory" => $stylesDir);
    $settings->update(0, $new_stylesDir);

}