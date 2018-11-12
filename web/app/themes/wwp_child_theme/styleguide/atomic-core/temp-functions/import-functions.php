<?php

function importCompsDb($old_compDir, $old_compExt, $catdb, $compdb){

    $path = "../../$old_compDir";
    $dir = new DirectoryIterator($path);

    $addCats = array(array("category" => "", "order" => ""));
    $catdb -> rw($addCats);
    $catdb -> rm(0);

    $addComps = array(array("component" => "", "category" => "", "description" => "", "backgroundColor" => "", "order" => ""));
    $compdb -> rw($addComps);
    $compdb -> rm(0);


    $i=0;

    foreach ($dir as $fileinfo) {
        if ($fileinfo->isDir() && !$fileinfo->isDot()) {

            $i++;

            $dirs = $fileinfo->getFilename();



            $addCats = array("category" => $dirs, "order" => "$i");
            $catdb -> add($addCats);





            $i2=0;
            foreach (glob("../../$old_compDir/$dirs/*.$old_compExt") as $filename) {

                $i2++;
                $filenameBase = basename("$filename", ".$old_compExt");


                $addComps = array("component" => "$filenameBase", "category" => "$dirs", "description" => "", "backgroundColor" => "", "order" => "$i2");
                $compdb -> add($addComps);



            }

        }
    }
}



function importCheckRootStyleString($old_stylesDir, $old_stylesExt){

    $path = "../../$old_stylesDir";
    $dir = new DirectoryIterator($path);



    foreach ($dir as $fileinfo) {
        if ($fileinfo->isDir() && !$fileinfo->isDot()) {


            $dirs = $fileinfo->getFilename();


            foreach (glob("../../$old_stylesDir/$dirs/_$dirs.$old_stylesExt") as $filename) {
                //$filenameBase = basename("$filename", "._$old_compExt");

                $oldString = '@import "_';
                $newString = '@import "';

                $contents = file_get_contents($filename);
                $contents = str_replace($oldString, $newString, $contents);

                file_put_contents($filename, $contents);

            }
            foreach (glob("../../$old_stylesDir/$dirs/_$dirs.$old_stylesExt") as $filename) {
                //$filenameBase = basename("$filename", "._$old_compExt");

                $oldString = '@import "';
                $newString = '@import "_';

                $contents = file_get_contents($filename);
                $contents = str_replace($oldString, $newString, $contents);

                file_put_contents($filename, $contents);

            }

        }
    }
}



function importCheckMainRootStyleString($old_stylesDir, $old_stylesExt){


    $path = "../../$old_stylesDir";

    $filename = "$path/main.$old_stylesExt";

    $oldString = '/_';
    $newString = '/';

    $contents = file_get_contents($filename);
    $contents = str_replace($oldString, $newString, $contents);

    file_put_contents($filename, $contents);



    $oldString = '/';
    $newString = '/_';

    $contents = file_get_contents($filename);
    $contents = str_replace($oldString, $newString, $contents);

    file_put_contents($filename, $contents);

}