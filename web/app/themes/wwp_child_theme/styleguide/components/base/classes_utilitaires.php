<!-- components/base/classes_utilitaires.php -->

<?php
$sizes      = ['s', 'm', 'l', 'xl', 'xxl'];
$spaces     = ['m', 'p'];
$directions = ['t', 'r', 'b', 'l'];

foreach ($sizes as $size) {
    $classes = [];
    foreach ($spaces as $space) {
        foreach ($directions as $direction) {
            $classes[] = $space . $direction . $size;
        }
    }
    $block = '
<div class="utilities-previewer-wrap">
    <div class="utilities-previewer previewer-size-' . $size . ' ' . implode(' ', $classes) . '">
        <div class="utilities-previewer-inner">';
    foreach ($classes as $class) {
        $block .= '<code class="' . $class . '-preview">.' . $class . '</code> ';
    }
    $block .= '
        </div>
    </div>
</div><br />';

    echo $block;
}
?>
