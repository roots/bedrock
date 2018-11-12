<?php




function createCompFile($catName, $compName, $settingsArr)
{


    $compDir = $settingsArr[0]['component_directory'];
    $compExt = $settingsArr[0]['component_extension'];


    $myFile = fopen("../../$compDir/$catName/$compName.$compExt", 'x+') or die("can't open file");

    fclose($myFile);
}


function createJsFile($compName, $jsDir, $jsExt)
{
    fopen("../../$jsDir/$compName.$jsExt", "w");
}
function createJsComment($compName, $settingsArr)
{



    $jsDir = $settingsArr[0]['js_directory'];
    $jsExt = $settingsArr[0]['js_extension'];

    $commentString = '/* '.$jsDir.'/'.$compName.'.'.$jsExt.' */';
    $commentString = "\n$commentString\n";
    $fileHandle = fopen('../../'.$jsDir.'/'.$compName.'.'.$jsExt.'', 'w') or die("can't open file");
    fwrite($fileHandle, $commentString);
    fclose($fileHandle);
    file_put_contents('../../'.$jsDir.'/'.$compName.'.'.$jsExt.'', implode(PHP_EOL, file('../../'.$jsDir.'/'.$compName.'.'.$jsExt.'', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
}

function createCompComment($catName, $compName, $settingsArr)
{



    $compDir = $settingsArr[0]['component_directory'];
    $compExt = $settingsArr[0]['component_extension'];

    $commentString = '<!-- '.$compDir.'/'.$catName.'/'.$compName.'.'.$compExt.' -->';
    $commentString = "\n$commentString\n";
    $fileHandle = fopen('../../'.$compDir.'/'.$catName.'/'.$compName.'.'.$compExt.'', 'w') or die("can't open file");
    fwrite($fileHandle, $commentString);
    fclose($fileHandle);
    file_put_contents('../../'.$compDir.'/'.$catName.'/'.$compName.'.'.$compExt.'', implode(PHP_EOL, file('../../'.$compDir.'/'.$catName.'/'.$compName.'.'.$compExt.'', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
}



function createStylesFile($catName, $compName, $settingsArr)
{


    $stylesDir = $settingsArr[0]['styles_directory'];
    $stylesExt = $settingsArr[0]['styles_extension'];

    fopen("../../$stylesDir/$catName/_$compName.$stylesExt", 'x+') or die("can't open file");
}

function createStyleComment($catName, $compName, $settingsArr)
{



    $stylesDir = $settingsArr[0]['styles_directory'];
    $stylesExt = $settingsArr[0]['styles_extension'];


    $commentString = '/* '.$stylesDir.'/'.$catName.'/_'.$compName.'.'.$stylesExt.' */';
    $commentString = "\n$commentString\n";
    $fileHandle = fopen('../../'.$stylesDir.'/'.$catName.'/_'.$compName.'.'.$stylesExt.'', 'w') or die("can't open file");
    fwrite($fileHandle, $commentString);
    fclose($fileHandle);
    file_put_contents('../../'.$stylesDir.'/'.$catName.'/_'.$compName.'.'.$stylesExt.'', implode(PHP_EOL, file('../../'.$stylesDir.'/'.$catName.'/_'.$compName.'.'.$stylesExt.'', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
}



function writeStylesImport($catName, $compName, $settingsArr)
{



    $stylesDir = $settingsArr[0]['styles_directory'];
    $stylesExt = $settingsArr[0]['styles_extension'];

    //create @import string
    $importString = "@import " . '"_'.$compName.'";' ;
    $importString = "\n$importString\n";

    //open parent scss file and write @import string to it
    $fileHandle = fopen('../../'.$stylesDir.'/'.$catName.'/'.'_'.$catName.'.'.$stylesExt.'', 'a') or die("can't open file");
    fwrite($fileHandle, $importString);
    fclose($fileHandle);

    //remove any extra line breaks from file
    file_put_contents('../../'.$stylesDir.'/'.$catName.'/'.'_'.$catName.'.'.$stylesExt.'', implode(PHP_EOL, file('../../'.$stylesDir.'/'.$catName.'/'.'_'.$catName.'.'.$stylesExt.'', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
}













