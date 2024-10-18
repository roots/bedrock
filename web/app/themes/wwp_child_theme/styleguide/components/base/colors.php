<!-- components/base/colors.php -->
<?php
//Edit your color names here based on the ones you've entered in your sass variable $styleguide-colors
$colors = [
    'base',
    'background-base',
    'brand',
    'primary',
    'secondary',
    'tertiary',
    'quaternary',
    'grey',
    'verylightgrey',
    'lightgrey',
    'mediumgrey',
    'darkgrey'
];
?>

<?php
//Do not touch below
?>
<p>Sass colors must be defined in the variable $styleguide-colors in the scss/base/_colors.scss file.</p>
<p>If you see an undefined color in the list below, it means you haven't provided a correct value for this color yet in the $styleguide-colors variable.</p>
<div class="colors">
    <?php

    if (!empty($colors)) {
        foreach ($colors as $color) {
            echo '
            <div class="color background-' . $color . '">
                <span>var(--wp--preset--color--' . $color . ')</span>
            </div>';
        }
    }
    ?>
</div>
