<?php
/**
 * Root admin screen - lists available themes and plugins
 */

use WonderWp\Plugin\Translator\Loco;

$themes = $values['themes'];
$plugins = $values['plugins'];
?>

<div class="wrap loco-admin loco-lists">

    <?php
    // Theme packages
    //
    if( $themes ):?>
        <div class="icon32 icon-appearance"><br /></div>
        <h2 class="dashicons-admin-appearance">
            <?php Loco::h( Loco::_x('Themes','Package list header') )?>
        </h2>
        <div class="loco-list loco-list-themes">
        <?php Loco::render( 'admin-list', array('items'=>$themes) ) ?>
        </div><?php
    endif;


    // Plugin packages
    //
    if( $plugins ):?>
        <div class="icon32 icon-plugins"><br /></div>
        <h2 class="dashicons-admin-plugins">
            <?php Loco::h( Loco::_x('Plugins','Package list header') )?>
        </h2>
        <div class="loco-list loco-list-plugins">
        <?php Loco::render( 'admin-list', array('items'=>$plugins) ) ?>
        </div><?php
    endif;
    ?>
</div>
