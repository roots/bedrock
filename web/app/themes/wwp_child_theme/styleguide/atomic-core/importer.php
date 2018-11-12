<?php

include("head.php");

?>
<body class="atoms" xmlns="http://www.w3.org/1999/html">

<div class="pageHeader">

</div>
<div class="pageContent">
    <ol>
        <li>In this copy of Atomic Docs remove the components and scss folders.</li>
        <li>Copy the components and scss folders you would like to import into this copy of Atomic Docs.</li>
        <!--<li>Fill in the form below and submit. If you are importing from an old version of Atomic Docs keep the defaults.</li>-->
        <li>Click import.</li>
        <li>Compile your scss.</li>
        <li>Unfortunately the importer will not include any of your component descriptions or contextual background
            colors so you will need to add those manually.
        </li>
    </ol>
    <form id="importForm">
        <!--<div class="inputGroup">
            <label class="aa_label">Style directory name</label>
            <input type="text" class="form-control" name="stylesDir" value="scss">
        </div>
        <div class="inputGroup">
            <label class="aa_label">Edit style file extension</label>
            <input type="text" class="form-control" name="stylesExt" value=".scss">
        </div>

        <div class="inputGroup">
            <label class="aa_label">Edit component file directory name</label>
            <input type="text" class="form-control" name="compDir" value="components">
        </div>

        <div class="inputGroup">
            <label class="aa_label">Change markup file extension</label>
            <input type="text" class="form-control" name="compExt" value=".php">
        </div>-->
        <button class="aa_btn aa_btn-pos" type="submit">Import</button>
    </form>
</div>
<?php include("footer.php"); ?>
</body>





