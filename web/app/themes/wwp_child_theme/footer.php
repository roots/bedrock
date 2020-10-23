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

<?php if (!\WonderWp\Functions\isAjax()): ?>

<div class="container-s">
    <?php do_action('wwp_before_footer'); ?>
</div>

<footer id="colophon" class="site-footer" role="contentinfo">

    <div class="container">

        <div class="footer-content">

            <a href="/" class="logo" aria-title="<?php echo trad('back.to.home', WWP_THEME_TEXTDOMAIN); ?>">
                <img src="/app/themes/wwp_child_theme/assets/raw/images/logo-site-white.svg" alt="Mon site - accueil">
            </a>

            <?php
            //Menu du footer
            //Pour fonctionner automatiquement, creer un footer appelé Footer fr_FR pour la france dans apparence/menus dans le BO
            $footerMenuName = 'Footer ' . get_locale();
            if (is_nav_menu($footerMenuName)) {
                echo '<nav role="navigation" aria-label="Menu secondaire">';
                wp_nav_menu(['menu' => $footerMenuName]);
                echo '</nav>';
            }
            ?>

            <?php
            //Reseaux sociaux
            $rs = new \WonderWp\Theme\Child\Components\ReseauxSociaux\ReseauxSociauxComponent();
            echo $rs->getMarkup();
            ?>

        </div><!-- .site-info -->

    </div>

</footer><!-- .site-footer -->

</div><!-- .site -->

<?php do_action('wwp_after_footer'); ?>

<?php wp_footer(); ?>

</body>
</html>
<?php endif; /* isAjax */ ?>
