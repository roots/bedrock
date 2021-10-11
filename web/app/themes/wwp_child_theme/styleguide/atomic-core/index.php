<?php

include("head.php");

require "fllat.php";

$components = new Fllat("components", "../atomic-db");
$categories = new Fllat("categories", "../atomic-db");

$settings = new Fllat("settings", "../atomic-db");


$compSelect = $components->select(array());
$categories = $categories->select(array());
$settings = $settings->select(array());


?>
<body id="atomsWrap" class="atoms no-touch" xmlns="http://www.w3.org/1999/html">


<div id="search-list" class="searchWindow">


    <div class="atoms-overflow">


        <i class="fa fa-times fa-3x js_searchWindow__close searchWindow__close"></i>

        <div class="SearchContent">

            <div class="searchInputWrap">
                <input type="text" class="fuzzy-search searchInput" placeholder="Search Components"/>
            </div>


            <ul class="list searchList">


                <?php

                usort($categories, function ($a, $b) {
                    return $a['order'] - $b['order'];
                });
                foreach ($categories as $category) {
                    global $category
                    ?>


                    <!--<h2 data-searchcat="<?php /*echo $category['category'] */ ?>"><?php /*echo $category['category'] */ ?></h2>-->


                    <?php

                    $filtered = array_filter($compSelect, function ($v) {
                        global $category;
                        return $v['category'] == $category['category'];
                    });
                    usort($filtered, function ($a, $b) {
                        return $a['order'] - $b['order'];
                    });
                    ?>
                    <?php foreach ($filtered as $component) { ?>

                        <li>
                            <a class="name"
                               href="atomic-core/?cat=<?php echo $category['category'] ?>#<?php echo $component['component'] ?>"><?php echo $component['component'] ?></a>
                        </li>


                    <?php } ?>


                <?php } ?>
            </ul>

        </div>

    </div>
</div>


<div class="grid-row atoms-container editorMode">
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

            <div class="logo">

            </div>

            <div class="atoms-side_hide">
                <span class="js-hideSide navIcon navIcon-left fa fa-arrow-left"></span>
                <span class="navIcon js_searchTrigger  fa fa-search "></span>
                <span class="js-hideCode navIcon fa fa-code"></span>
                <a class="js-edit-settings navIcon navIcon-settings fa fa-gear aa_js-actionOpen aa_actionBtn"
                   href="atomic-core/temp-forms/temp-edit-settings-form.php"></a>

                <!--<span class="js-hideTitle fa fa-header"></span>
                <span class="js-hideNotes fa fa-paragraph"></span>-->

            </div>

            <nav>
                <ul class="atoms-nav">


                    <?php

                    usort($categories, function ($a, $b) {
                        return $a['order'] - $b['order'];
                    });
                    foreach ($categories as $category) {
                        global $category
                        ?>


                        <?php if (isset($_GET['cat'])) { ?>
                            <li class="aa_dir <?php if ($category['category'] == $_GET['cat']) { ?>active<?php } ?>" data-navitem="<?php echo $category['category'] ?>">
                        <?php } else { ?>
                            <li class="aa_dir" data-navitem="<?php echo $category['category'] ?>">
                        <?php } ?>


                        <div class="aa_dir__dirNameGroup">
                            <i class="aa_dir__dirNameGroup__icon  fa fa-folder-o"></i>
                            <a class="aa_dir__dirNameGroup__name"
                               data-cat="<?php echo $category['category'] ?>"
                               href="atomic-core/?cat=<?php echo $category['category'] ?>"><?php echo $category['category'] ?></a>
                        </div>



















                        <ul class="aa_fileSection fileSection-<?php echo $category['category'] ?>">
                            <li class="aa_addFileItem">
                                <a class="aa_addFile js_add-component aa_js-actionOpen aa_actionBtn"
                                   href="atomic-core/temp-forms/temp-create-component-form.php"
                                   data-cat="<?php echo $category['category'] ?>">
                                    <span class="fa fa-plus"></span> Add Component</a>
                            </li>


                            <?php

                            $filtered = array_filter($compSelect, function ($v) {
                                global $category;
                                return $v['category'] == $category['category'];
                            });
                            usort($filtered, function ($a, $b) {
                                return $a['order'] - $b['order'];
                            });
                            ?>
                            <?php foreach ($filtered as $component) { ?>

                                <li class="aa_fileSection__file" data-comp="<?php echo $component['component'] ?>"
                                    data-cat="<?php echo $category['category'] ?>" draggable="false">
                                    <a href="atomic-core/?cat=<?php echo $category['category'] ?>#<?php echo $component['component'] ?>"><?php echo $component['component'] ?></a>
                                </li>


                            <?php } ?>

                        </ul>
                        </li>


                    <?php } ?>


                </ul>
                <div class="catAdd"><a class="js_cat-add aa_js-actionOpen aa_actionBtn"
                                       href="atomic-core/temp-forms/temp-category-form.php"><span
                            class="fa fa-folder-o"></span> Add Category</a></div>
            </nav>


        </div>

        <div class="cat-form js-showContent"></div>


    </aside>


    <div class="atoms-main">

        <div class="se-pre-con">
            <div class="se-pre-con-inner"></div>
        </div>

        <?php if (!empty($_GET['cat']) || !empty($_GET['search'])) { ?>


            <?php if (!empty($_GET['cat'])) { ?>
                <h1 id="modules" class="atomic-h1"><?php echo $_GET['cat']; ?> <a
                        class="fa fa fa-pencil-square-o js_cat-edit aa_js-actionOpen aa_actionBtn"
                        href="atomic-core/temp-forms/temp-edit-category-form.php"
                        data-cat="<?php echo $_GET['cat']; ?>">
                    </a>
                </h1>
            <?php } ?>

            <?php if (!empty($_GET['search'])) { ?>
                <?php
                $cat = $components->get("category", "component", $_GET['search']);
                ?>


                <?php if (!empty($cat)) { ?>
                    <h1 id="modules" class="atomic-h1">The <a
                            href="atomic-core/?cat=<?php echo $cat ?>#<?php echo $_GET['search']; ?>"> <?php echo $_GET['search']; ?></a>
                        component was found in the
                        <a href="atomic-core/?cat=<?php echo $cat ?>"><?php echo $cat ?></a> category.</h1>
                <?php } ?>

                <?php if (empty($cat)) { ?>
                    <h1 id="modules" class="atomic-h1">Sorry, no results found for "<?php echo $_GET['search']; ?>
                        ".</h1>
                <?php } ?>


            <?php } ?>


            <?php


            if (!empty($_GET['cat'])) {
                $cat = $_GET['cat'];
                global $cat;
                $compSelect = array_filter($compSelect, function ($v) {
                    global $cat;
                    return $v['category'] == $cat;
                });
            }

            if (!empty($_GET['search'])) {
                $search = $_GET['search'];
                global $search;

                $cat = $components->get("category", "component", $_GET['search']);
                global $cat;

                $compSelect = array_filter($compSelect, function ($v) {
                    global $search;
                    return $v['component'] == $search;
                });
            }

            usort($compSelect, function ($a, $b) {
                return $a['order'] - $b['order'];
            });
            foreach ($compSelect as $component) {
                foreach ($settings as $setting)
                    ?>


                    <div id="<?php echo $component['component'] ?>-container" class="compWrap"
                                                                              data-hasjs="<?php echo $component['has_js'] ?>">
                <p id="<?php echo $component['component'] ?>"
                   class="content-editable compTitle">
                    <span><?php echo $component['component'] ?></span>&nbsp;
                    <span class="js-hideAll fa fa-eye"></span>&nbsp;
                    <a class="fa fa fa-pencil-square-o js_edit-component aa_js-actionOpen aa_actionBtn"
                       href="atomic-core/temp-forms/temp-edit-component-form.php"
                       data-cat="<?php echo $cat; ?>" data-comp="<?php echo $component['component'] ?>">
                    </a>
                </p>
                <p class="compNotes"
                   data-description="<?php echo $component['description'] ?>"><?php echo $component['description'] ?></p>
                <div class="component <?php if ($component['backgroundColor']) { ?>componentHasBg<?php } ?>"
                     data-color="<?php echo $component['backgroundColor'] ?>"
                     style="background-color:<?php echo $component['backgroundColor'] ?>">


                    <?php
                    $componentFile = '../' . $setting['component_directory'] . '/' . $cat . '/' . $component['component'] . '.' . $setting['component_extension'];

                    if(file_exists($componentFile)){
                        require($componentFile);
                    }
                    else {
                        echo 'Component does not exist';
                    }
                    ?>


                </div>

                <div class="codeBlocks grid-row">
                    <!-- Nav tabs -->
                    <ul class="nav-atomic nav-tabs-atomic" role="tablist">
                        <li role="presentation" class="active"><a
                                href="#<?php echo $component['component'] ?>-markup-tab"
                                aria-controls="home" role="tab"
                                data-toggle="tab"><i class="fa fa-code" aria-hidden="true"></i> Markup</a></li>


                        <li role="presentation"><a
                                href="#<?php echo $component['component'] ?>-output-tab"
                                aria-controls="home" role="tab"
                                data-toggle="tab"><i class="fa fa-eye" aria-hidden="true"></i> Output</a></li>


                        <li role="presentation"><a href="#<?php echo $component['component'] ?>-styles-tab"
                                                   aria-controls="profile"
                                                   role="tab" data-toggle="tab">{ } Styles</a></li>


                        <?php if ($component['has_js'] == "true") { ?>
                            <li role="presentation"><a href="#<?php echo $component['component'] ?>-js-tab"
                                                       aria-controls="profile"
                                                       role="tab" data-toggle="tab">( ) Javascript</a></li>
                        <?php } else { ?>

                            <form method="post" class="formGroup-check tabForm form-create-jsfile" action="atomic-core/temp-processing/temp-create-jsfile.php">
                                <input class="formInput-check js-input" type="checkbox"  id="js_file-<?php echo $component['component'] ?>">
                                <label for="js_file-<?php echo $component['component'] ?>"><span></span>Add a javascript file</label>
                                <input type="hidden" name="catVal" value="<?php echo $_GET['cat']; ?>">
                                <input type="hidden" name="jsName" value="<?php echo $component['component'] ?>">

                            </form>




                        <?php } ?>




                        <li class="expandItem">
                            <a href="#" class="js-expand"><i class="fa fa-arrows-v" aria-hidden="true"></i> Expand</a>
                        </li>


                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">


                        <div role="tabpanel" class="tab-pane active"
                             id="<?php echo $component['component'] ?>-markup-tab">
                            <form class="atomic-editorWrap" data-editorFormComp="<?php echo $component['component'] ?>"
                                  data-editorFormCat="<?php echo $cat; ?>"
                                  data-codeDest="<?php echo $setting['component_directory'] ?>">
                                <div  class="js-copyBtn copyBtn copyBtn-markup" data-clipboard-text="" data-copy-target="<?php echo $component['component'] ?>-markup-val"><i class="fa fa-clone" aria-hidden="true"></i> Copy</div>

                                <div class="atomic-editorInner" id="<?php echo $component['component'] ?>-editorInner" >

                                    <div class="copyBtn copyBtn-edit js-copyBtn-edit">Edit</div>
                                    <?php $markup_file_content = file_get_contents('../' . $setting['component_directory'] . '/' . $cat . '/' . $component['component'] . '.' . $setting['component_extension'] . '', true); ?>
                                    <div class="atomic-editor"
                                         id="editor-markup-<?php echo $component['component'] ?>"><?= htmlspecialchars($markup_file_content, ENT_QUOTES); ?></div>
                                    <input id="<?php echo $component['component'] ?>-markup-val" class="new-val-input" type="hidden"
                                           name="new-markup-val-<?php echo $component['component'] ?>"
                                           value=""/>
                                </div>
                                <div class="atomic-editor-footer">
                                    <button type="submit" class="atomic-btns atomic-btn1"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                                    <span type="reset" class="js-close-editor atomic-btns atomic-btn2"><i class="fa fa-ban" aria-hidden="true"></i> Cancel</span>
                                </div>
                            </form>
                        </div>


                        <div role="tabpanel" class="tab-pane"
                             id="<?php echo $component['component'] ?>-output-tab">
                            <form class="atomic-editorWrap" data-editorFormComp="<?php echo $component['component'] ?>"
                                  data-editorFormCat="<?php echo $cat; ?>"
                                  data-codeDest="<?php echo $setting['component_directory'] ?>">
                                <div class="js-copyBtn copyBtn copyBtn-output" data-clipboard-text="" data-copy-target="<?php echo $component['component'] ?>-new-val"><i class="fa fa-clone" aria-hidden="true"></i> Copy</div>
                                <div class="atomic-editorInner">

                                    <div class="atomic-editor atomic-editor-output"
                                         id="editor-output-<?php echo $component['component'] ?>"></div>
                                </div>
                            </form>
                        </div>


                        <div role="tabpanel" class="tab-pane" id="<?php echo $component['component'] ?>-styles-tab">
                            <form class="atomic-editorWrap" data-editorFormComp="<?php echo $component['component'] ?>"
                                  data-editorFormCat="<?php echo $cat; ?>"
                                  data-codeDest="<?php echo $setting['styles_directory'] ?>">
                                <div class="js-copyBtn copyBtn copyBtn-styles" data-clipboard-text="" data-copy-target="<?php echo $component['component'] ?>-style-val"><i class="fa fa-clone" aria-hidden="true"></i> Copy</div>
                                <div class="atomic-editorInner">

                                    <div class="copyBtn copyBtn-edit js-copyBtn-edit">Edit</div>

                                    <?php $style_file_content = file_get_contents('../' . $setting['styles_directory'] . '/' . $cat . '/_' . $component['component'] . '.' . $setting['styles_extension'] . '', true); ?>

                                    <div class="atomic-editor"
                                         id="editor-styles-<?php echo $component['component'] ?>"><?= htmlspecialchars($style_file_content, ENT_QUOTES); ?></div>

                                    <input id="<?php echo $component['component'] ?>-style-val" class="new-val-input" type="hidden"
                                           name="new-styles-val-<?php echo $component['component'] ?>" value=""/>
                                </div>
                                <div class="atomic-editor-footer">
                                    <button type="submit" class="atomic-btns atomic-btn1"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                                    <span type="reset" class="js-close-editor atomic-btns atomic-btn2"><i class="fa fa-ban" aria-hidden="true"></i> Cancel</span>
                                </div>
                            </form>
                        </div>


                        <?php if ($component['has_js'] == "true") { ?>

                            <div role="tabpanel" class="tab-pane" id="<?php echo $component['component'] ?>-js-tab">
                                <form class="atomic-editorWrap"
                                      data-editorFormComp="<?php echo $component['component'] ?>"
                                      data-editorFormCat="<?php echo $cat; ?>"
                                      data-codeDest="<?php echo $setting['js_directory'] ?>">
                                    <div class="js-copyBtn copyBtn copyBtn-js" data-clipboard-text="" data-copy-target="<?php echo $component['component'] ?>-js-val"><i class="fa fa-clone" aria-hidden="true"></i> Copy</div>
                                    <div class="atomic-editorInner">

                                        <div class="copyBtn copyBtn-edit js-copyBtn-edit">Edit</div>

                                        <?php $style_file_content = file_get_contents('../' . $setting['js_directory'] . '/' . $component['component'] . '.' . $setting['js_extension'] . '', true); ?>

                                        <div class="atomic-editor"
                                             id="editor-js-<?php echo $component['component'] ?>"><?= htmlspecialchars($style_file_content, ENT_QUOTES); ?></div>

                                        <input id="<?php echo $component['component'] ?>-js-val" class="new-val-input" type="hidden"
                                               name="new-js-val-<?php echo $component['component'] ?>" value=""/>
                                    </div>
                                    <div class="atomic-editor-footer">
                                        <button type="submit" class="atomic-btns atomic-btn1"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                                        <span type="reset" class="js-close-editor atomic-btns atomic-btn2"><i class="fa fa-ban" aria-hidden="true"></i> Cancel</span>
                                    </div>
                                </form>
                            </div>

                        <?php } ?>


                    </div>
                </div>

                </div>

            <?php } ?>

        <?php } else { ?>


            <div class="pageContent">

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

<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/2.0.0/lazysizes.min.js"></script>-->
<?php include("footer.php"); ?>


