<?php



function deleteCompFile($catName, $fileName, $settingsArr)
{



    $compDir = $settingsArr[0]['component_directory'];
    $compExt = $settingsArr[0]['component_extension'];

    unlink('../../'.$compDir.'/'.$catName.'/'.$fileName.'.'.$compExt.'');
}




function deleteJsFile($fileName, $settingsArr)
{

  

    $jsDir = $settingsArr[0]['js_directory'];
    $jsExt = $settingsArr[0]['js_extension'];

    unlink('../../'.$jsDir.'/'.$fileName.'.'.$jsExt.'');
}



function deleteStyleFile($catName, $fileName, $settingsArr)
{
    

    $stylesDir = $settingsArr[0]['styles_directory'];
    $stylesExt = $settingsArr[0]['styles_extension'];

    unlink('../../'.$stylesDir.'/'.$catName.'/_'.$fileName.'.'.$stylesExt.'');
}



function deleteScssImportString($catName, $fileName, $settingsArr)
{



    $stylesDir = $settingsArr[0]['styles_directory'];
    $stylesExt = $settingsArr[0]['styles_extension'];

    $importString = "@import " . '"_'.$fileName.'";' ;

    $contents = file_get_contents('../../'.$stylesDir.'/'.$catName.'/_'.$catName.'.'.$stylesExt.'');
    $contents = str_replace($importString, "", $contents);
    file_put_contents('../../'.$stylesDir.'/'.$catName.'/_'.$catName.'.'.$stylesExt.'', $contents);


}


function deleteCatJsFile($jsDir, $jsExt, $compDir, $thisCat){


    $dir = '../../'.$compDir.'/'.$thisCat.'';

    foreach(glob($dir.'/*.*') as $file) {

        $basename = pathinfo($file, PATHINFO_FILENAME);

        $jsFile = $basename.'.'.$jsExt;


        $jsPath = "../../$jsDir/$jsFile";


        if(file_exists($jsPath)){

            unlink($jsPath);
        }

    }
}