<?php



function deleteScssImportString($catName, $fileName)
{

  $config = getConfig();
  $cssDir = $config['preCssDir'];
  $cssExt = $config['preCssExt'];

	$importString = "@import " . '"_'.$fileName.'";' ;
	//Place contents of file into variable
	$contents = file_get_contents('../../'.$cssDir.'/'.$catName.'/_'.$catName.'.'.$cssExt.'');
	$contents = str_replace($importString, "", $contents);
	$contents = file_put_contents('../../'.$cssDir.'/'.$catName.'/_'.$catName.'.'.$cssExt.'', $contents);
}


function deleteScssFile($catName, $fileName)
{        
	$config = getConfig();
	$cssDir = $config['preCssDir'];
    $cssExt = $config['preCssExt'];

	unlink('../../'.$cssDir.'/'.$catName.'/_'.$fileName.'.'.$cssExt.'');
}



function deleteCompIncludetString($catName, $compNotes, $fileName, $bgColor)
{
  $config = getConfig();
  $compExt = $config['compExt'];
  $cssDir = $config['preCssDir'];
  $cssExt = $config['preCssExt'];

  $includeString = '<div class="compWrap"><span id="'.$fileName.'" class="compTitle">'.$fileName.' <span class="js-hideAll fa fa-eye"></span></span><p class="compNotes">'.$compNotes.'</p><div class="component" style="background-color:'.$bgColor.'"><?php include("../components/'.$catName.'/'.$fileName.'.'.$compExt.''.'");?></div><div class="compCodeBox"> <ul class="nav nav-tabs" role="tablist"> <li role="presentation" class="active"><a href="#'.$fileName.'-markup" aria-controls="'.$fileName.'-markup" role="tab" data-toggle="tab">Markup</a></li><li role="presentation"><a href="#'.$fileName.'-css" aria-controls="'.$fileName.'-css" role="tab" data-toggle="tab">'.$cssDir.'</a></li></ul> <div class="tab-content"> <div role="tabpanel" class="tab-pane active markup-display" id="'.$fileName.'-markup"></div><div role="tabpanel" class="tab-pane" id="'.$fileName.'-css"><pre><code class="language-css"><?php include("../'.$cssDir.'/'.$catName.'/_'.$fileName.'.'.$cssExt .'");?></code></pre></div></div></div></div>';

  
 
  

	//Place contents of file into variable
	$contents = file_get_contents('../categories/'.$catName.'/'.$catName.'.php');
	
	$contents = str_replace($includeString, "", $contents);
	$contents = file_put_contents('../categories/'.$catName.'/'.$catName.'.php', $contents);
}


function deleteCompFile($catName, $fileName)
{
	$config = getConfig();
    $compExt = $config['compExt'];

	unlink('../../components/'.$catName.'/'.$fileName.'.'.$compExt.'');
}



function deleteAjaxCompFile($catName, $fileName)
{
	unlink('../categories/'.$catName.'/form-'.$fileName.'.php');
}

?>