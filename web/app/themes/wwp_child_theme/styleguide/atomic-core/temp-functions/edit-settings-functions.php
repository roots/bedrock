<?php

function editStyleExt($old_stylesDir, $old_stylesExt, $stylesExt){

    $path = "../../$old_stylesDir";
    $dir = new DirectoryIterator($path);

    foreach ($dir as $fileinfo) {
        if ($fileinfo->isDir() && !$fileinfo->isDot()) {


            $dirs = $fileinfo->getFilename();


            foreach (glob("../../$old_stylesDir/$dirs/*.$old_stylesExt") as $filename) {

                $newname = basename($filename, ".$old_stylesExt").".$stylesExt";

                rename($filename, '../../'.$old_stylesDir.'/'.$dirs.'/'.$newname);

            }
        }
    }
}

function renameStyleDirSettings($old_stylesDir, $stylesDir){

    $oldDir = "../../$old_stylesDir";
    $newDir = "../../$stylesDir";

    sleep(1);
    rename($oldDir,$newDir);


}



function editStylesComment($old_stylesDir, $old_stylesExt, $stylesExt, $stylesDir){

    $path = "../../$old_stylesDir";
    $dir = new DirectoryIterator($path);

    foreach ($dir as $fileinfo) {
        if ($fileinfo->isDir() && !$fileinfo->isDot()) {


            $dirs = $fileinfo->getFilename();




            foreach (glob("../../$old_stylesDir/$dirs/*.$old_stylesExt") as $filename) {

                $filenameBase = basename("$filename", ".$old_stylesExt");



                $oldString = '/* '.$old_stylesDir.'/'.$dirs.'/'.$filenameBase.'.'.$old_stylesExt.' */';



                $newString = '/* '.$stylesDir.'/'.$dirs.'/'.$filenameBase.'.'.$stylesExt.' */';



                $contents = file_get_contents($filename);
                $contents = str_replace($oldString, $newString, $contents);

                file_put_contents($filename, $contents);

            }
        }
    }
}

function changeRootStylesExt($stylesDir, $old_stylesExt, $stylesExt){

    $path = "../../$stylesDir";

    $filename = "$path/main.$old_stylesExt";



    $newname = basename($filename, ".$old_stylesExt").".$stylesExt";



    $newname = "$path/$newname";


    rename($filename, $newname);
}






function editCompComment($old_compDir, $old_compExt, $compExt, $compDir){

    $path = "../../$old_compDir";
    $dir = new DirectoryIterator($path);

    foreach ($dir as $fileinfo) {
        if ($fileinfo->isDir() && !$fileinfo->isDot()) {


            $dirs = $fileinfo->getFilename();

           // var_dump($dirs);




            foreach (glob("../../$old_compDir/$dirs/*.$old_compExt") as $filename) {

                //var_dump($filename);

                $filenameBase = basename("$filename", ".$old_compExt");

                //var_dump($filenameBase);



                $oldString = '<!-- '.$old_compDir.'/'.$dirs.'/'.$filenameBase.'.'.$old_compExt.' -->';

                //var_dump($oldString);

                $newString = '<!-- '.$compDir.'/'.$dirs.'/'.$filenameBase.'.'.$compExt.' -->';

                //var_dump($newString);

                $contents = file_get_contents($filename);
                $contents = str_replace($oldString, $newString, $contents);

                file_put_contents($filename, $contents);

            }
        }
    }
}




function editCompExt($old_compDir, $old_compExt, $compExt){

    $path = "../../$old_compDir";
    $dir = new DirectoryIterator($path);

    foreach ($dir as $fileinfo) {
        if ($fileinfo->isDir() && !$fileinfo->isDot()) {


            $dirs = $fileinfo->getFilename();


            foreach (glob("../../$old_compDir/$dirs/*.$old_compExt") as $filename) {

                $newname = basename($filename, ".$old_compExt").".$compExt";

                rename($filename, '../../'.$old_compDir.'/'.$dirs.'/'.$newname);

            }
        }
    }
}


function renameCompDirSettings($old_compDir, $compDir){

    $oldDir = "../../$old_compDir";
    $newDir = "../../$compDir";
    sleep(1);
    rename($oldDir,$newDir);
}






















