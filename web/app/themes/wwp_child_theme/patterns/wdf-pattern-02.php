<?php
/**
 * Title: WDF pattern 02
 * Slug: wwp_child_theme/patterns
 * Categories: featured
 * Description: custom pattern Wonderful
 * Block Types: core/post-content, core/paragraph
 */
?>

<!-- wp:group {"className":"bloc-test-2-cols","layout":{"type":"constrained"}} -->
    <!-- wp:columns {"verticalAlignment":null} -->

    <!-- wp:column {"width":"66.66%"} -->
        <!-- wp:heading -->
            <h2><?php echo __( 'Dignissimos ducimus qui blanditiis praesentium voluptatum', 'text-domain' ); ?></h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph -->
            <p><?php echo __( 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores.', 'text-domain' ); ?></p>
        <!-- /wp:paragraph -->

            <!-- wp:image {"id":1229,"width":635,"height":349,"sizeSlug":"full","linkDestination":"none"} -->
            <img src="https://local.wonderwp.com/app/uploads/2021/10/bus.jpg" alt="" class="wp-image-1229" style="width:635px;height:349px" width="635" height="349"/><figcaption class="wp-element-caption">Nam libero tempore, cum soluta nobis est eligendi optio</figcaption>
            <!-- /wp:image -->
    <!-- /wp:column -->

    <!-- wp:column {"verticalAlignment":"center","width":"33.33%"} -->
        <!-- wp:paragraph -->
            <p><?php echo __( 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores.', 'text-domain' ); ?></p>
        <!-- /wp:paragraph -->
    <!-- /wp:column -->

    <!-- /wp:columns -->
<!-- /wp:group -->
