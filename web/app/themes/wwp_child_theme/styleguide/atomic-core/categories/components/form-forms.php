<div class="aa_fileFormGroup">
<label class="aa_label js-showHide-trigger"><span class="fa fa-plus"></span> <span class="aa_label__file">Rename</span> forms</label>
<div class="showHide">
  <form id="form-rename-file"  class="aa_fileForm " action="/atomic-core/partial-mngr/file-rename.php" method="post">
      <div class="formInputGroup">
        <div class="inputBtnGroup">
          
          <button class="aa_btn aa_btn-pos" type="submit" >Rename</button>
          <div class="inputBtnGroup__inputWrap"><input type="text" class="form-control" name="renameFileName" value="forms" required></div>
        </div>     
      </div>
      <input type="hidden" name="compDir" value="components"/>
      <input type="hidden" name="rename" value="rename"/>
      <input type="hidden" name="oldName" value="forms"/>
    </form>
</div>
<label class="aa_label js-showHide-trigger"><span class="fa fa-plus"></span> Change the <span class="aa_label__file">description</span> for forms</label>
<div class="showHide">
   <form id="form-rename-notes"  class="aa_fileForm " action="/atomic-core/partial-mngr/notes-rename.php" method="post">
        <textarea class="form-control" name="compNotesNew"></textarea>        
        <button class="aa_btn aa_btn-pos" type="submit" >Update</button>
      <input type="hidden" name="compDir" value="components"/>
      <input type="hidden" name="fileName" value="forms"/>
      <input type="hidden" name="compNotes" value=""/>
      <input type="hidden" name="bgColor" value=""/>
    </form>
</div>
<label class="aa_label js-showHide-trigger"><span class="fa fa-plus"></span> Change the <span class="aa_label__file">contextual background color</span> for forms</label>
<div class="showHide">
   <form id="form-change-bgColor"  class="aa_fileForm " action="/atomic-core/partial-mngr/bgcolor-rename.php" method="post">
        
        <div class="bgColorWrap">
          <input class="bgColor" type="text" name="bgColorNew" value="" />
        </div>      
        <button class="aa_btn aa_btn-pos" type="submit" >Update</button>
      <input type="hidden" name="compDir" value="components"/>
      <input type="hidden" name="fileName" value="forms"/>
      <input type="hidden" name="compNotes" value=""/>
      <input type="hidden" name="bgColor" value=""/>
    </form>
</div>
<label class="aa_label js-showHide-trigger"><span class="fa fa-plus"></span> <span class="aa_label__file">Move</span>  forms</label>
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
                            
                            echo '<option value="';
                            echo $fileinfo->getFilename();
                            echo '">';          
                            echo $fileinfo->getFilename();
                            echo '</option>';  
                        }
                    }
                ?>
              </select>
            </div>
          </div>  
        </div>
      </div>
      <input type="hidden" name="compDir" value="components"/>
      <input type="hidden" name="fileMoveName" value="forms"/>
      <input type="hidden" name="moveFile" value="moveFile"/>
      <input type="hidden" name="compNotes" value=""/>
      <input type="hidden" name="bgColor" value=""/>
    </form>
</div>
<label class="aa_label js-showHide-trigger"><span class="fa fa-plus"></span> <span class="aa_label__file">Delete</span> forms</label>
<div class="showHide">
    <form id="form-delete-file" class="aa_fileForm " action="/atomic-core/partial-mngr/delete.php" method="post">
      <div class="formInputGroup">
        <div class="inputBtnGroup">
          <button class="aa_btn aa_btn-neg" type="submit" >Delete</button>
          <div class="inputBtnGroup__inputWrap"><input type="text" class="form-control" name="deleteFileName" placeholder="Must type forms to delete"></div>
        </div>  
      </div>
      <input type="hidden" name="compDir" value="components"/>
      <input type="hidden" name="delete" value="delete"/>
      <input type="hidden" name="compNotes" value=""/>
      <input type="hidden" name="bgColor" value=""/>
    </form>
</div>
</div>