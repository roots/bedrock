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

<?php do_action('wwp_before_footer'); ?>

<footer id="colophon" class="site-footer">
    <div class="footer-content">
        <?php wp_nav_menu(['theme_location' => 'footer-menu']); ?>
    </div><!-- .site-info -->
</footer><!-- .site-footer -->

</div><!-- .site -->

<?php do_action('wwp_after_footer'); ?>

<?php wp_footer(); ?>

</body>
</html>
