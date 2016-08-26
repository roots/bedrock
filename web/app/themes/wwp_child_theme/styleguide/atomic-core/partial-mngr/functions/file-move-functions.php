<?php

function moveScssFile($catName, $fileName, $newDir)
{	
	$config = getConfig();
	$cssDir = $config['preCssDir'];
    $cssExt = $config['preCssExt'];

    rename ("../../$cssDir/$catName/_$fileName.$cssExt", "../../$cssDir/$newDir/_$fileName.$cssExt");
}


function moveScssChangeCommentString($catName, $fileName, $newDir)
{	

	$config = getConfig();
	$cssDir = $config['preCssDir'];
    $cssExt = $config['preCssExt'];

    $oldString = '/*'.$cssDir.'/'.$catName.'/_'.$fileName.'.'.$cssExt.'*/';
    $newString = '/*'.$cssDir.'/'.$newDir.'/_'.$fileName.'.'.$cssExt.'*/';

	//Place contents of file into variable
	$contents = file_get_contents('../../'.$cssDir.'/'.$catName.'/_'.$fileName.'.'.$cssExt.'');
	$contents = str_replace($oldString, $newString , $contents);
	$contents = file_put_contents('../../'.$cssDir.'/'.$catName.'/_'.$fileName.'.'.$cssExt.'', $contents);

}





function moveCompFile($catName, $fileName, $newDir)
{	
	$config = getConfig();
	$compExt = $config['compExt'];

    rename ("../../components/$catName/$fileName.$compExt", "../../components/$newDir/$fileName.$compExt");
}

function moveAjaxFile($catName, $fileName, $newDir)
{	
    rename ("../categories/$catName/form-$fileName.php", "../categories/$newDir/form-$fileName.php");
}


function moveChangeCommentString($catName, $fileName, $newDir)
{	

	$config = getConfig();
	$compExt = $config['compExt'];

    $oldString = '<!--components/'.$catName.'/'.$fileName.'.'.$compExt.'-->';
    $newString = '<!--components/'.$newDir.'/'.$fileName.'.'.$compExt.'-->';

	//Place contents of file into variable
	$contents = file_get_contents('../../components/'.$catName.'/'.$fileName.'.'.$compExt.'');
	$contents = str_replace($oldString, $newString , $contents);
	$contents = file_put_contents('../../components/'.$catName.'/'.$fileName.'.'.$compExt.'', $contents);

}



?>
