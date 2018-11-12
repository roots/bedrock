<div class="aa_fileFormGroup">
    <form id="form-create-file" class="aa_fileForm"  method="post">
        <div class="inputGroup">
            <label class="aa_label">What's your component's name?</label>
            <input type="text" class="formInput" name="compName">
        </div>
        <div class="inputGroup">
            <label class="aa_label">Component description.</label>
            <textarea class="formInput" name="compNotes"></textarea>
        </div>
        <label class="aa_label">Contextual background color.</label>
        <div class="inputGroup">
            <input class="bgColor" type="text" name="bgColor" value=""/>
        </div>


        <!--<div class="formGroup-check">
            <input class="formInput-check" type="checkbox" id="js_file" name="js_file" value="true">
            <label for="js_file"><span></span>Add a javascript file</label>
        </div>-->



        <button class="aa_btn aa_btn-pos" type="submit">Add</button>
    </form>
</div>

<div class="featureHints">
    <p><strong>Hint</strong></p>
    <p>To change the order the components appear on the page you can simply drag and drop them in the sidebar. You can also move them to a different category by dragging and dropping them into the desired category's component list. All changes will also be reflected in the project's file structure as well as the @import style strings order as well!</p>
</div>