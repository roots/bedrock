<script>
    $( ".atoms-container" ).addClass('clientMode');
    $( ".atoms-container" ).removeClass('editorMode');
</script>


<?php if (!empty($_GET['cat']) || !empty($_GET['search'])) { ?>

    <?php


    if (!empty($_GET['cat'])) {
        $cat = $_GET['cat'];
        global $cat;
        $i = 0;
        $compSelect = array_filter($compSelect, function ($v) {
            global $cat;
            return $v['category'] == $cat;
        });
    }


    if (!empty($_GET['search'])) {
        $search = $_GET['search'];
        global $search;

        $cat = $components -> get("category", "component", $_GET['search']);
        global $cat;

        $i = 0;

        $compSelect = array_filter($compSelect, function ($v) {
            global $search;
            return $v['component'] == $search;
        });
    }



    foreach ($compSelect as $component) {
        $i++
        ?>


        <script>
            var editormarkup_<?php echo $i; ?> = ace.edit("editor-markup-<?php echo $component['component'] ?>");
            editormarkup_<?php echo $i; ?>.setOptions({
                maxLines: Infinity,
                readOnly: true
            });

        </script>



        <script>
            var editoroutput_<?php echo $i; ?> = ace.edit("editor-output-<?php echo $component['component'] ?>");
            editoroutput_<?php echo $i; ?>.setOptions({
                maxLines: Infinity,
                readOnly: true
            });

        </script>


        <script>
            var editorstyles_<?php echo $i; ?> = ace.edit("editor-styles-<?php echo $component['component'] ?>");
            editorstyles_<?php echo $i; ?>.setOptions({
                maxLines: Infinity,
                readOnly: true
            });

        </script>

        <?php if ($component['has_js'] == "true") { ?>
            <script>
                var editorjs_<?php echo $i; ?> = ace.edit("editor-js-<?php echo $component['component'] ?>");
                editorjs_<?php echo $i; ?>.setOptions({
                    maxLines: Infinity,
                    readOnly: true
                });

            </script>
        <?php } ?>


    <?php } ?>

<?php } else { ?>
<?php } ?>