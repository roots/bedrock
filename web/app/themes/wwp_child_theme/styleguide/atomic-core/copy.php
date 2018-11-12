<?php include("head.php"); ?>
<?php
/*$json = file_get_contents('db/data.json');
$data = json_decode($json, true);*/

require "fllat.php";
$compdb = new Fllat("compdb");
$catdb = new Fllat("catdb");


$comp_data = $compdb->select(array());
$cat_data = $catdb->select(array());


?>
    <body class="atoms">
    <script language="javascript" type="text/javascript">
        function resizeIframe(obj) {
            obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
        }
    </script>


<div class="grid-row atoms-container">
    <div class="atoms-side_show-small ">
        <span class="toggle-line"></span>
        <span class="toggle-line"></span>
        <span class="toggle-line"></span>
    </div>
    <div class="atoms-side_show ">
        <span class="js-showSide fa fa-arrow-right"></span>
    </div>
    <aside class="atoms-side">
    <div class="atoms-overflow">

    <div class="atoms-side_hide">
        <span class="js-hideSide fa fa-arrow-left"></span>
        <span class="js-hideTitle fa fa-header"></span>
        <span class="js-hideNotes fa fa-paragraph"></span>
        <span class="js-hideCode fa fa-code"></span>
    </div>

    <nav>
    <ul class="atoms-nav">


<?php
$cat_data = array_filter($cat_data, function($v) {
usort($cat_data , function($a, $b) {
    return $a['comp_sort_order'] - $b['comp_sort_order'];
});
foreach ($cat_data as $cat_value) {
    
}?>




        <li class="aa_dir ">
            <div class="aa_dir__dirNameGroup">
                <i class="aa_dir__dirNameGroup__icon  fa fa-folder-o"></i>
                <a class="aa_dir__dirNameGroup__name"
                   data-cat="<?php echo $cat_value['cat_name'] ?>"
                   href="atomic-core/?cat=<?php echo $cat_value['cat_name'] ?>"><?php echo $cat_value['cat_name'] ?></a>
            </div>
            <ul class="aa_fileSection">
                <li class="aa_addFileItem">
                    <a class="aa_addFile js_add-edit-c omponent aa_js-actionOpen aa_actionBtn"
                       href="atomic-core/temp-forms/temp-component-form.php"
                       data-cat="<?php echo $cat_value['cat_name'] ?>">
                        <span class="fa fa-plus"></span> Add Component</a>
                </li>




                <li class="aa_fileSection__file" data-comp="<?php echo $comp_value['comp_name'] ?>">
                    <a href="atomic-core/?cat=<?php echo $cat; ?>#<?php echo $comp_value['comp_name'] ?>"><?php echo $comp_value['comp_name'] ?></a>
                </li>



            </ul>
        </li>


    <?php } ?>




    </ul>
    <div class="catAdd"><a class="js_cat-add aa_js-actionOpen aa_actionBtn"
                           href="atomic-core/temp-forms/temp-category-form.php"><span
                class="fa fa-plus"></span> Add Category</a></div>
    </nav>


    </div>

    <div class="cat-form js-showContent"></div>


    </aside>


    <div class="atoms-main">
    <h1 id="modules" class="atomic-h1"><?php echo $_GET['cat']; ?> <a class="fa fa fa-pencil-square-o js_add-edit-component aa_js-actionOpen aa_actionBtn" href="atomic-core/temp-forms/temp-category-form.php">

        </a></h1>



    <?php
    $cat = $_GET['cat'];
    global $cat;
    $comp_data = array_filter($comp_data, function($v) {
        global $cat;
        return $v['comp_category'] == $cat;});
    usort($comp_data , function($a, $b) {
        return $a['comp_sort_order'] - $b['comp_sort_order'];
    });
    foreach ($comp_data as $comp_value) {
        ?>




        <div id="<?php echo $comp_value['comp_name'] ?>-container" class="compWrap">
            <p id="<?php echo $comp_value['comp_name'] ?>"
               class="content-editable compTitle">
                <span><?php echo $comp_value['comp_name'] ?></span>&nbsp;
                <span class="js-hideAll fa fa-eye"></span>&nbsp;
                <a class="fa fa fa-pencil-square-o js_add-edit-component aa_js-actionOpen aa_actionBtn"
                   href="atomic-core/temp-forms/temp-component-form.php"
                   data-cat="<?php echo $cat; ?>" data-comp="<?php echo $comp_value['comp_name'] ?>">

                </a>


            </p>

            <p class="compNotes" data-description="<?php echo $comp_value['comp_notes'] ?>"><?php echo $comp_value['comp_notes'] ?></p>

            <div class="component"
                 data-color="<?php echo $comp_value['comp_context_color'] ?>"
                 style="background-color:<?php echo $comp_value['comp_context_color'] ?>">


                <iframe class="partial-viewport"
                        src="atomic-core/partial.php?component=<?php echo $comp_value['comp_name'] ?>&category=<?php echo $cat; ?>"
                        sandbox="allow-same-origin allow-scripts  allow-modals" frameborder="0" scrolling="no"></iframe>


            </div>

            <div>
                <!-- Nav tabs -->
                <ul class="nav-atomic nav-tabs-atomic" role="tablist">
                    <li role="presentation" class="active"><a href="#<?php echo $comp_value['comp_name'] ?>-markup-tab"
                                                              aria-controls="home" role="tab"
                                                              data-toggle="tab">Markup</a></li>
                    <li role="presentation"><a href="#<?php echo $comp_value['comp_name'] ?>-styles-tab"
                                               aria-controls="profile"
                                               role="tab" data-toggle="tab">Styles</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="<?php echo $comp_value['comp_name'] ?>-markup-tab"
                    ">
                    <form class="atomic-editorWrap" data-editorFormComp="<?php echo $comp_value['comp_name'] ?>"
                          data-editorFormCat="<?php echo $cat; ?>" data-codeDest="components">
                        <div class="atomic-editorInner">
                            <div class="copyBtn copyBtn-markup" data-clipboard-text="">Copy</div>

                            <?php $markup_file_content = file_get_contents('../components/' . $cat . '/' . $comp_value['comp_name'] . '.php', true); ?>
                            <div class="atomic-editor"
                                 id="editor-markup-<?php echo $comp_value['comp_name'] ?>"><?= htmlspecialchars($markup_file_content, ENT_QUOTES); ?></div>

                            <input class="new-val-input" type="hidden"
                                   name="new-markup-val-<?php echo $comp_value['comp_name'] ?>"
                                   value=""/>
                        </div>
                        <div class="atomic-editor-footer">
                            <button type="submit" class="atomic-btns atomic-btn1">Save</button>
                            <span type="reset" class="js-close-editor atomic-btns atomic-btn2">Cancel</span>
                        </div>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane" id="<?php echo $comp_value['comp_name'] ?>-styles-tab">
                    <form class="atomic-editorWrap" data-editorFormComp="<?php echo $comp_value['comp_name'] ?>"
                          data-editorFormCat="<?php echo $cat; ?>" data-codeDest="scss">
                        <div class="atomic-editorInner">
                            <div class="copyBtn copyBtn-styles" data-clipboard-text="">Copy</div>


                            <?php $style_file_content = file_get_contents('../scss/' . $cat . '/_' . $comp_value['comp_name'] . '.scss', true); ?>

                            <div class="atomic-editor"
                                 id="editor-styles-<?php echo $comp_value['comp_name'] ?>"><?= htmlspecialchars($style_file_content, ENT_QUOTES); ?></div>

                            <input class="new-val-input" type="hidden"
                                   name="new-styles-val-<?php echo $comp_value['comp_name'] ?>" value=""/>
                        </div>
                        <div class="atomic-editor-footer">
                            <button type="submit" class="atomic-btns atomic-btn1">Save</button>
                            <span type="reset" class="js-close-editor atomic-btns atomic-btn2">Cancel</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        </div>
    <?php } ?>



    </div>
    </div>


    <div class="aa_js-actionDrawer aa_actionDrawer">
        <div class="aa_actionDrawer__wrap">
            <div class="aa_js-actionClose aa_actionDrawer__close"><i class="fa fa-times fa-3x"></i></div>
            <div id="js_actionDrawer__content" class="actionDrawer__content">


            </div>
        </div>
    </div>


    <?php include("footer.php"); ?>