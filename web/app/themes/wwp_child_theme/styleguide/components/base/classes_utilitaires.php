<!-- components/base/classes_utilitaires.php -->
<p class="subtitle">Marges internes et externes</p>
<p>Toutes les classes utilitaires son listées dans le fichier : <code>/web/app/themes/wwp_child_theme/assets/raw/scss/_utilities.scss</code></p>
<p>Elles apportent des fonctionnalités au niveau de :</p>
<ul>
    <li>Marges internes et externes (en rem) : <code>.mtl</code></li>
    <li>Largeurs (en pourcentage) : <code>.w50</code></li>
    <li>Tailles de fonts (en em) : <code>.u-big</code></li>
    <li>Orientation layout (flexbox) : <code>.flex-center</code></li>
    <li>Gouttières de colonnes <code>.has-gutter-xxl</code></li>
</ul>
<p>IMPORTANT : ne pas ajouter de styles media querries pour mobile, utiliser les classes .XXX--mobile</p>

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

<hr>
