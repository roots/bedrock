<?php
get_header(apply_filters('wwp-parcours-header',''));
// Start the loop.
while (have_posts()) : the_post();
    //Detail template
    echo do_shortcode('[wwpmodule slug=\'wwp-parcours\' action=\'detail\'  ]');
// End the loop.
endwhile;
get_footer(apply_filters('wwp-parcours-footer',''));
?>
