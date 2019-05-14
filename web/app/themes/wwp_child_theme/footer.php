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
        <?php
        //Menu du footer
        //Pour fonctionner automatiquement, creer un footer appele Footer fr_FR pour la france dans apparence/menus dans le BO
        $footerMenuName = 'Footer ' . get_locale();
        if (is_nav_menu($footerMenuName)) {
            wp_nav_menu(['menu' => $footerMenuName]);
        }
        ?>
        <?php
        //Liens vers les reseaux sociaux
        //Decommenter les 2 lignes suivantes si vous souhaitez afficher le composant des liens vers les profils sociaux adminstres depuis le BO
        //$rs = new \WonderWp\Theme\Child\Components\ReseauxSociaux\ReseauxSociauxComponent();
        //echo $rs->getMarkup();
        ?>
    </div><!-- .site-info -->
</footer><!-- .site-footer -->

</div><!-- .site -->

<?php do_action('wwp_after_footer'); ?>

<?php wp_footer(); ?>

</body>
</html>
