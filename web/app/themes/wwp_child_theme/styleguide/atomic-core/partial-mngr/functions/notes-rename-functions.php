<?php
function changeIncludeString($compDir, $compNotes, $compNotesNew, $fileName, $bgColor)
{	

	$config = getConfig();
	$compExt = $config['compExt'];
	$cssDir = $config['preCssDir'];
  $cssExt = $config['preCssExt'];



    $oldString = '<div class="compWrap"><span id="'.$fileName.'" class="compTitle">'.$fileName.' <span class="js-hideAll fa fa-eye"></span></span><p class="compNotes">'.$compNotes.'</p><div class="component" style="background-color:'.$bgColor.'"><?php include("../components/'.$compDir.'/'.$fileName.'.'.$compExt.''.'");?></div><div class="compCodeBox"> <ul class="nav nav-tabs" role="tablist"> <li role="presentation" class="active"><a href="#'.$fileName.'-markup" aria-controls="'.$fileName.'-markup" role="tab" data-toggle="tab">Markup</a></li><li role="presentation"><a href="#'.$fileName.'-css" aria-controls="'.$fileName.'-css" role="tab" data-toggle="tab">'.$cssDir.'</a></li></ul> <div class="tab-content"> <div role="tabpanel" class="tab-pane active markup-display" id="'.$fileName.'-markup"></div><div role="tabpanel" class="tab-pane" id="'.$fileName.'-css"><pre><code class="language-css"><?php include("../'.$cssDir.'/'.$compDir.'/_'.$fileName.'.'.$cssExt .'");?></code></pre></div></div></div></div>';

    $newString = '<div class="compWrap"><span id="'.$fileName.'" class="compTitle">'.$fileName.' <span class="js-hideAll fa fa-eye"></span></span><p class="compNotes">'.$compNotesNew.'</p><div class="component" style="background-color:'.$bgColor.'"><?php include("../components/'.$compDir.'/'.$fileName.'.'.$compExt.''.'");?></div><div class="compCodeBox"> <ul class="nav nav-tabs" role="tablist"> <li role="presentation" class="active"><a href="#'.$fileName.'-markup" aria-controls="'.$fileName.'-markup" role="tab" data-toggle="tab">Markup</a></li><li role="presentation"><a href="#'.$fileName.'-css" aria-controls="'.$fileName.'-css" role="tab" data-toggle="tab">'.$cssDir.'</a></li></ul> <div class="tab-content"> <div role="tabpanel" class="tab-pane active markup-display" id="'.$fileName.'-markup"></div><div role="tabpanel" class="tab-pane" id="'.$fileName.'-css"><pre><code class="language-css"><?php include("../'.$cssDir.'/'.$compDir.'/_'.$fileName.'.'.$cssExt .'");?></code></pre></div></div></div></div>';

	//Place contents of file into variable
	$contents = file_get_contents('../categories/'.$compDir.'/'.$compDir.'.php');
	$contents = str_replace($oldString, $newString , $contents);
	$contents = file_put_contents('../categories/'.$compDir.'/'.$compDir.'.php', $contents);
    

}
?>
