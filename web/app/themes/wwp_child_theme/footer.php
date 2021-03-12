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

        <div class="footer-content-top">
            <div class="container-l">

                <div class="first-col">
                    <?php
                    echo '<a href="/" class="logo" aria-label="' . trad('back.to.home', WWP_THEME_TEXTDOMAIN) . '"><img src="' . apply_filters('wwp-header-logo', '/app/themes/wwp_child_theme/assets/raw/images/logo-site-white.svg') . '" alt="Mon site - accueil"></a>'
                    ?>
                </div>

                <?php
                //Menu du footer
                //Pour fonctionner automatiquement, creer un footer appelé Footer fr_FR pour la france dans apparence/menus dans le BO
                $footerMenuName = 'Footer ' . get_locale();
                if (is_nav_menu($footerMenuName)) {
                    echo '<nav role="navigation" aria-label="Menu footer principal">';
                    wp_nav_menu(['menu' => $footerMenuName]);
                    echo '</nav>';
                }
                ?>

                <div class="third-col">
                    <?php
                    //Reseaux sociaux
                    $rs = new \WonderWp\Theme\Child\Components\ReseauxSociaux\ReseauxSociauxComponent();
                    echo $rs->getMarkup();
                    ?>
                </div>

            </div>
        </div>

        <div class="footer-content-bottom">
            <div class="container-l">

                <div class="first-col">
                    <address>
                        <span>Fédération des Aveugles<br> et Amblyopes de France</span>
                        <span>6 rue Gager Gabillot<br> 75015 PARIS</span>
                        <a href="tel:+33144429191">Tél. : 01 44 42 91 91</a>
                    </address>
                </div>

                <?php
                //Menu du footer
                $footerMenuName = 'Footer ' . get_locale() . ' 2';
                if (is_nav_menu($footerMenuName)) {
                    echo '<nav role="navigation" aria-label="Menu footer secondaire">';
                    wp_nav_menu(['menu' => $footerMenuName]);
                    echo '</nav>';
                }
                ?>

                <div class="third-col"></div>
            </div>
        </div>

        </div>

    </footer><!-- .site-footer -->

    </div><!-- .site -->

    <?php do_action('wwp_after_footer'); ?>

    <?php wp_footer(); ?>

    </body>
    </html>
<?php endif; /* isAjax */ ?>
