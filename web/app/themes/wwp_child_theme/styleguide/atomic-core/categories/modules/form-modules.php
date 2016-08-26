<div class="aa_fileFormGroup">
    <form id="form-create-file" class="aa_fileForm " action="/atomic-core/modules.php" method="post">
     
      <div class="inputGroup">
        <label class="aa_label">What's your component's name?</label>
        <input type="text" class="form-control" name="fileCreateName">
      </div>
        <label class="aa_label">Component description.</label>
        <textarea class="form-control" name="compNotes"></textarea>
        <label class="aa_label">Contextual background color.</label>
        <div class="bgColorWrap">
          <input class="bgColor" type="text" name="bgColor" value="" />
        </div>
        <button class="aa_btn aa_btn-pos" type="submit" >Add</button>
      <input type="hidden" name="compDir" value="modules"/>
      <input type="hidden" name="create" value="create"/>
    </form>
</div>