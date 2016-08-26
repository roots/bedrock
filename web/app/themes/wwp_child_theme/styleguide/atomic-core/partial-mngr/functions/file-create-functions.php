<?php

function createScssFile($catName, $fileName)
{
  $config = getConfig();
  $cssDir = $config['preCssDir'];
  $cssExt = $config['preCssExt'];

  $commentString = '/*'.$cssDir.'/'.$catName.'/_'.$fileName.'.'.$cssExt.'*/';
  $commentString = "$commentString\n\n";
  
  $fileHandle = fopen('../../'.$cssDir.'/'.$catName.'/'.'_'.$fileName.'.'.$cssExt.'', 'x+') or die("can't open file");
  fwrite($fileHandle, $commentString);
  fwrite($fileHandle, ".".$fileName."{\n\n}");
  fclose($fileHandle);
}


function writeScssImportFile($catName, $fileName)
{
  $config = getConfig();
  $cssDir = $config['preCssDir'];
  $cssExt = $config['preCssExt'];
  
  //create @import string
  $importString = "@import " . '"_'.$fileName.'";' ;
  $importString = "\n$importString\n";
  
  //open parent scss file and write @import string to it
  $fileHandle = fopen('../../'.$cssDir.'/'.$catName.'/'.'_'.$catName.'.'.$cssExt.'', 'a') or die("can't open file");
  fwrite($fileHandle, $importString);
  fclose($fileHandle);   
  
  //remove any extra line breaks from file
  file_put_contents('../../'.$cssDir.'/'.$catName.'/'.'_'.$catName.'.'.$cssExt.'', implode(PHP_EOL, file('../../'.$cssDir.'/'.$catName.'/'.'_'.$catName.'.'.$cssExt.'', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));       
}



//creates component file
function createCompFile($catName, $fileName)
{
  
  $config = getConfig();
  $compExt = $config['compExt'];
  
  
  $commentString = '<!--components/'.$catName.'/'.$fileName.'.'.$compExt.'-->';
  $commentString = "\n$commentString\n";
  
  $fileHandle = fopen('../../components/'.$catName.'/'.$fileName.'.'.$compExt.'', 'x+') or die("can't open file");
  fwrite($fileHandle, $commentString);
  fclose($fileHandle);
  
  file_put_contents('../../components/'.$catName.'/'.$fileName.'.'.$compExt.'', implode(PHP_EOL, file('../../components/'.$catName.'/'.$fileName.'.'.$compExt.'', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
}



//creates include string and writes to component parent file
function createIncludeString($catName, $compNotes, $fileName, $bgColor)
{
  
  $config = getConfig();
  $compExt = $config['compExt'];
  $cssDir = $config['preCssDir'];
  $cssExt = $config['preCssExt'];

  $includeString = '<div class="compWrap"><span id="'.$fileName.'" class="compTitle">'.$fileName.' <span class="js-hideAll fa fa-eye"></span></span><p class="compNotes">'.$compNotes.'</p><div class="component" style="background-color:'.$bgColor.'"><?php include("../components/'.$catName.'/'.$fileName.'.'.$compExt.''.'");?></div><div class="compCodeBox"> <ul class="nav nav-tabs" role="tablist"> <li role="presentation" class="active"><a href="#'.$fileName.'-markup" aria-controls="'.$fileName.'-markup" role="tab" data-toggle="tab">Markup</a></li><li role="presentation"><a href="#'.$fileName.'-css" aria-controls="'.$fileName.'-css" role="tab" data-toggle="tab">'.$cssDir.'</a></li></ul> <div class="tab-content"> <div role="tabpanel" class="tab-pane active markup-display" id="'.$fileName.'-markup"></div><div role="tabpanel" class="tab-pane" id="'.$fileName.'-css"><pre><code class="language-css"><?php include("../'.$cssDir.'/'.$catName.'/_'.$fileName.'.'.$cssExt .'");?></code></pre></div></div></div></div>';

  $includeString = "\n$includeString\n";
  
  $fileHandle = fopen('../categories/'.$catName.'/'.$catName.'.php', 'a') or die("can't open file");
  fwrite($fileHandle, $includeString);
  
  file_put_contents('../categories/'.$catName.'/'.$catName.'.php', implode(PHP_EOL, file('../categories/'.$catName.'/'.$catName.'.php', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
  
}




//creates ajax form file
function createAjaxIncludeAndCompFile($catName, $fileName)
{
  
  $includeString = 
'<div class="aa_fileFormGroup">

<label class="aa_label js-showHide-trigger"><span class="fa fa-plus"></span> <span class="aa_label__file">Rename</span> '.$fileName. '</label>
<div class="showHide">
  <form id="form-rename-file"  class="aa_fileForm " action="/atomic-core/partial-mngr/file-rename.php" method="post">
      <div class="formInputGroup">

        <div class="inputBtnGroup">
          
          <button class="aa_btn aa_btn-pos" type="submit" >Rename</button>
          <div class="inputBtnGroup__inputWrap"><input type="text" class="form-control" name="renameFileName" value="' .$fileName.'" required></div>

        </div>     

      </div>
      <input type="hidden" name="compDir" value="'.$catName.'"/>
      <input type="hidden" name="rename" value="rename"/>
      <input type="hidden" name="oldName" value="'.$fileName.'"/>
    </form>
</div>


<label class="aa_label js-showHide-trigger"><span class="fa fa-plus"></span> Change the <span class="aa_label__file">description</span> for '.$fileName. '</label>
<div class="showHide">
   <form id="form-rename-notes"  class="aa_fileForm " action="/atomic-core/partial-mngr/notes-rename.php" method="post">
        <textarea class="form-control" name="compNotesNew"></textarea>        

        <button class="aa_btn aa_btn-pos" type="submit" >Update</button>

      <input type="hidden" name="compDir" value="' .$catName.'"/>
      <input type="hidden" name="fileName" value="'.$fileName.'"/>
      <input type="hidden" name="compNotes" value=""/>
      <input type="hidden" name="bgColor" value=""/>
    </form>
</div>




<label class="aa_label js-showHide-trigger"><span class="fa fa-plus"></span> Change the <span class="aa_label__file">contextual background color</span> for '.$fileName. '</label>
<div class="showHide">
   <form id="form-change-bgColor"  class="aa_fileForm " action="/atomic-core/partial-mngr/bgcolor-rename.php" method="post">
        
        <div class="bgColorWrap">
          <input class="bgColor" type="text" name="bgColorNew" value="" />
        </div>      

        <button class="aa_btn aa_btn-pos" type="submit" >Update</button>

      <input type="hidden" name="compDir" value="' .$catName.'"/>
      <input type="hidden" name="fileName" value="'.$fileName.'"/>
      <input type="hidden" name="compNotes" value=""/>
      <input type="hidden" name="bgColor" value=""/>
    </form>
</div>




<label class="aa_label js-showHide-trigger"><span class="fa fa-plus"></span> <span class="aa_label__file">Move</span>  '.$fileName.'</label>
<div class="showHide">
  <form id="form-file-move" class="aa_fileForm " action="/atomic-core/partial-mngr/file-move.php" method="post">
      <div class="formGroup">
        <div class="formInputGroup">
          <div class="inputBtnGroup">
            <button class="aa_btn aa_btn-pos" type="submit">Move</button>
            <div class="inputBtnGroup__inputWrap u-bgWhite">
              <select id="newDir" class="form-control" >
                <?php
                    $path = "../../../components";
                    $dir = new DirectoryIterator($path);
                  
                    foreach ($dir as $fileinfo) {
                        if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                            
                            echo \'<option value="\';
                            echo $fileinfo->getFilename();
                            echo \'">\';          
                            echo $fileinfo->getFilename();
                            echo \'</option>\';  
                        }
                    }
                ?>
              </select>
            </div>
          </div>  
        </div>
      </div>
      <input type="hidden" name="compDir" value="'.$catName.'"/>
      <input type="hidden" name="fileMoveName" value="'.$fileName.'"/>
      <input type="hidden" name="moveFile" value="moveFile"/>
      <input type="hidden" name="compNotes" value=""/>
      <input type="hidden" name="bgColor" value=""/>
    </form>
</div>





<label class="aa_label js-showHide-trigger"><span class="fa fa-plus"></span> <span class="aa_label__file">Delete</span> '.$fileName.'</label>
<div class="showHide">
    <form id="form-delete-file" class="aa_fileForm " action="/atomic-core/partial-mngr/delete.php" method="post">
      <div class="formInputGroup">
        <div class="inputBtnGroup">
          <button class="aa_btn aa_btn-neg" type="submit" >Delete</button>
          <div class="inputBtnGroup__inputWrap"><input type="text" class="form-control" name="deleteFileName" placeholder="Must type '.$fileName.' to delete"></div>
        </div>  
      </div>
      <input type="hidden" name="compDir" value="'.$catName.'"/>
      <input type="hidden" name="delete" value="delete"/>
      <input type="hidden" name="compNotes" value=""/>
      <input type="hidden" name="bgColor" value=""/>
    </form>
</div>

</div>'   
;

  $includeString = "\n$includeString\n";
  
  $fileHandle = fopen('../categories/'.$catName.'/form-'.$fileName.'.php', 'x+') or die("can't open file");
  fwrite($fileHandle, $includeString);
  
  file_put_contents('../categories/'.$catName.'/form-'.$fileName.'.php', implode(PHP_EOL, file('../categories/'.$catName.'/form-'.$fileName.'.php', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
  
}


?>