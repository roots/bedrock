<?php




function createScssCatDirAndFile($catName, $settingsArr)
{

    
    $stylesDir = $settingsArr[0]['styles_directory'];
    $stylesExt = $settingsArr[0]['styles_extension'];



    mkdir("../../$stylesDir/$catName");
    $fileHandle = fopen("../../$stylesDir/$catName/_$catName.$stylesExt", 'x+') or die("can't open file");
}





function createStringForMainScssFile($catName, $settingsArr)
{


    
    $stylesDir = $settingsArr[0]['styles_directory'];
    $stylesExt = $settingsArr[0]['styles_extension'];

    $includeString ='@import "'.$catName.'/_'.$catName.'";';

    $includeString = "\n$includeString\n";

    $fileHandle = fopen('../../'.$stylesDir.'/main.'.$stylesExt.'', 'a') or die("can't open file");
    fwrite($fileHandle, $includeString);

    file_put_contents('../../'.$stylesDir.'/main.'.$stylesExt.'', implode(PHP_EOL, file('../../'.$stylesDir.'/main.'.$stylesExt.'', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
}





function createCompCatDir($catName, $settingsArr)
{


    $compDir = $settingsArr[0]['component_directory'];

    mkdir("../../$compDir/$catName");
}












