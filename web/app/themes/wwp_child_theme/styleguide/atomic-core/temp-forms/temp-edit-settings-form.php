<?php

require "../fllat.php";



$settings = new Fllat("settings", "../../atomic-db");


$settings = $settings->select(array());

$compExt = $settings[0]['component_extension'];
$compDir = $settings[0]['component_directory'];

$stylesExt = $settings[0]['styles_extension'];
$stylesDir = $settings[0]['styles_directory'];


?>


<div class="aa_fileFormGroup">
    <form id="form-edit-settings" class="aa_fileForm"  method="post">
        <div class="inputGroup">
            <label class="aa_label">Edit style directory name</label>
            <input type="text" class="formInput" name="stylesDir" value="<?php echo $stylesDir ?>">
        </div>
        <div class="inputGroup">
            <label class="aa_label">Edit style file extension</label>
            <input type="text" class="formInput" name="stylesExt" value=".<?php echo $stylesExt ?>">
        </div>

        <div class="inputGroup">
            <label class="aa_label">Edit component file directory name</label>
            <input type="text" class="formInput" name="compDir" value="<?php echo $compDir ?>">
        </div>

        <div class="inputGroup">
            <label class="aa_label">Change markup file extension</label>
            <input type="text" class="formInput" name="compExt" value=".<?php echo $compExt ?>">
        </div>


        <button class="aa_btn aa_btn-full aa_btn-pos" type="submit" name="update_button" value="update">Update</button>
    </form>
</div>

