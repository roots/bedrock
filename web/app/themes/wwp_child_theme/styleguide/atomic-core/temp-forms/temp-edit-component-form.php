<div class="aa_fileFormGroup">
    <form id="edit-comp-file" class="aa_fileForm" method="post">
        <div class="inputGroup">
            <label class="aa_label">Change name</label>
            <input type="text" class="formInput" name="compName">
        </div>
        <div class="inputGroup">
            <label class="aa_label">Change description.</label>
            <textarea class="formInput" name="compNotes"></textarea>
        </div>
        <div class="inputGroup">
            <label class="aa_label">Change contextual background color.</label>
            <div class="bgColorWrap">
                <input class="bgColor" type="text" name="bgColor" value=""/>
            </div>
        </div>

        <!--<div class="formGroup-check hasJs-checkbox">
            <input class="formInput-check" type="checkbox" id="js_file" name="js_file" value="true">
            <label for="js_file"><span></span>Add a javascript file</label>
        </div>-->
        <button class="aa_btn aa_btn-full aa_btn-pos" type="submit" name="update_button" value="update">Update</button>
    </form>
</div>

<form id="delete-comp-file">
    <button class="aa_btn aa_btn-full aa_btn-neg" type="submit" name="delete_button" value="delete" onclick="return confirm('Are you sure?')">Delete
        Component
    </button>
</form>

<div class="featureHints">
    <p><strong>Hint</strong></p>
    <p>To change the order the components appear on the page you can simply drag and drop them in the sidebar. You can
        also move them to a different category by dragging and dropping them into the desired category's component list.
        All changes will also be reflected in the project's file structure as well as the @import style strings order as
        well!</p>
</div>















