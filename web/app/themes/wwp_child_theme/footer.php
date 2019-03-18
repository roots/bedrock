<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package    WordPress
 * @subpackage WonderWp_theme
 */

?>

</div><!-- .site-content -->

<div class="container-s">
    <?php do_action('wwp_before_footer'); ?>
</div>

<footer id="colophon" class="site-footer">
    <div class="footer-content">

    </div><!-- .site-info -->
</footer><!-- .site-footer -->

</div><!-- .site -->

<?php do_action('wwp_after_footer'); ?>

<?php wp_footer(); ?>

</body>
</html>
