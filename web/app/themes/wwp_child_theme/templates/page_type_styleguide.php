<?php
/**
 * The template used for displaying page content
 *
 * @package    WordPress
 * @subpackage WonderWp_theme
 */
get_header();
?>
    <div id="post-<?php the_ID(); ?>" <?php post_class('page-' . $post->post_name); ?>
         data-name="<?php echo $post->post_name; ?>">
        <?php
        /** @var \WonderWp\Theme\Core\Service\ThemeViewService $themeViewService */
        $themeViewService = wwp_get_theme_service('view');
        $postThumb = $themeViewService->getFeaturedImage(get_the_ID());
        ?>
        <?php if (!empty($postThumb)) : ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->
        <?php endif; ?>

        <header class="entry-header <?php if (!empty($postThumb)) {
            echo 'hasPostThumb';
        } ?>">
            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
        </header><!-- .entry-header -->

        <main class="entry-content">

            <div class="container">

                <?php
                if (!empty($themeViewService) && is_object($themeViewService) && !\WonderWp\Functions\isAjax()) {
                    echo $themeViewService->getBreadcrumbs();
                }
                ?>

                <?php
                $excerpt = !empty($post->post_excerpt) ? $post->post_excerpt : null;
                if (!empty($excerpt)) {
                    //Allow shortcodes in excerpt
                    echo '<p class="excerpt">' . apply_filters('the_content', $excerpt) . '</p>';
                }
                ?>

                <h2>H2 - Lorem ipsum dolor sit amet, consectetur adipiscing elit</h2>
                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum
                    deleniti atque corrupti quos dolores <a href="/">Lien sur un texte id est laborum et dolorum
                        fuga. Et harum quidem rerum facilis est et expedita distinctio</a> et quas molestias excepturi
                    sint occaecati cupiditate non
                    provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum
                    fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis
                    est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis
                    voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis
                    aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non
                    recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus
                    maiores alias consequatur aut perferendis doloribus asperiores repellat <strong>Texte en gras Ornare
                        in elit placerat.</strong></p>

                <div class="two-cols">
                    <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum
                        deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non
                        provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et
                        dolorum
                        fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta
                        nobis
                        est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis
                        voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis
                        debitis
                        aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non
                        recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus
                        maiores alias consequatur aut perferendis doloribus asperiores repellat</p>
                    <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum
                        deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non
                        provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et
                        dolorum
                        fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta
                        nobis
                        est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis
                        voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis
                        debitis
                        aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non
                        recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus
                        maiores alias consequatur aut perferendis doloribus asperiores repellat</p>
                </div> <!--.two-cols-->

                <hr>

                <h3>H3 - Liste non ordonnée</h3>
                <ul>
                    <li>Nibh tortor urna id tempus rutrum, ullamcorper. Torquent massa sit erat</li>
                    <li>Nibh tortor urna id tempus rutrum, ullamcorper. Torquent massa sit erat</li>
                    <li>Nibh tortor urna id tempus rutrum, ullamcorper. Torquent massa sit erat</li>
                </ul>
                <h3>H3 - Liste ordonnée</h3>
                <ol>
                    <li>Nibh tortor urna id tempus rutrum, ullamcorper. Torquent massa sit erat</li>
                    <li>Nibh tortor urna id tempus rutrum, ullamcorper. Torquent massa sit erat</li>
                    <li>Nibh tortor urna id tempus rutrum, ullamcorper. Torquent massa sit erat</li>
                </ol>

                <hr>

                <h3>H3 - Citation</h3>
                <div class="blockquote-wrapper">
                    <blockquote>Lorem ipsum a felis donec porta vel ultrices metus morbi porta vel.</blockquote>
                    <span class="cite-name">Prénom Nom</span>
                    <span class="cite-function">Fonction</span>
                </div>

                <hr>
                <br>

                <h3>H3 - Utilisation des images</h3>

                <div>
                    <h4>H4 - Image pleine largeur avec légende</h4>
                    <div id="attachment_1741" class="wp-caption alignleft">
                        <img src="http://local.agglo-heraultmediterranee.net/app/uploads/2019/03/image-1280x420.png"
                             alt="" width="1280" height="420">
                        <p class="wp-caption-text">légende de l’image</p>
                    </div>
                </div>

                <div>
                <h4>H4 - Image en habillage à gauche ou à droite (ajouter les classes "alignleft" ou "alignright" de Wordpress. On peut ajouter la classe .clearfix au wrapper pour stopper le float.</h4>
                    <p><img class="alignleft" src="https://via.placeholder.com/350x350.png" alt="" width="350"
                            height="350">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis
                        praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint
                        occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi,
                        id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam
                        libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod
                        maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.
                        Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et
                        voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a
                        sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis
                        doloribus asperiores repellat</p>
                    <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis
                        praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint
                        occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi,
                        id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam
                        libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod
                        maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.
                        Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et
                        voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a
                        sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis
                        doloribus asperiores repellat</p>
                </div>
                <div>
                    <h4>H4 - Image en habillage à droite</h4>
                    <p class="clearfix"><img class="alignright" src="https://via.placeholder.com/350x350.png" alt="" width="350"
                            height="350">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis
                        praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint
                        occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi,
                        id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam
                        libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod
                        maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.
                        Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et
                        voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a
                        sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis
                        doloribus asperiores repellat</p>
                </div>

                <hr>

                <h3>H3 - Encadré</h3>
                <p class="encadre">Lorem ipsum Fusce ut consequat elit. Nibh tortor urna id tempus rutrum, ullamcorper.
                    Torquent massa
                    sit erat. Tortor per pharetra per lobortis neque lacinia odio. Nunc commodo faucibus metus lobortis
                    at
                    tempor
                    ultrices ipsum quam. In. Auctor taciti vel id Sed.
                </p>

            </div> <!--.container-->


        </main> <!--.entry-content-->

    </div> <!--#post--->

<?php
get_footer();
