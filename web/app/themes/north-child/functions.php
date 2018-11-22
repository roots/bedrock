<?php
//
// Your code goes below!
//

add_action( 'wp_enqueue_scripts', 'vntd_north_child_styles' );
function vntd_north_child_styles() {
    wp_enqueue_style( 'vntd-child-style', get_stylesheet_uri(), array( 'theme-styles' ) );
}