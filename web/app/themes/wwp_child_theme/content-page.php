<?php
/**
 * The template used for displaying page content
 *
 * @package    WordPress
 * @subpackage WonderWp_theme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('page-' . $post->post_name); ?> data-name="<?php echo $post->post_name; ?>">
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

    <div class="entry-content">
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

            <?php
            do_action('wwp-header-add-infos', $post);

            ?>

            <?php if (is_home() || is_front_page()) {
                the_content();
            } else {
            $content = $post->post_content;
            $content = apply_filters('the_content', $content);
            $content = str_replace(']]>', ']]&gt;', $content);

            echo '<div class="content-wrapper">

                <div class="content">' . $content . '</div>
                
                <div class="aside">';
                    $ssComponent = new \WonderWp\Theme\Core\Component\SocialShareComponent();
                    echo $ssComponent->getMarkup([
                        'title' => $post->post_title,
                        'toLoad' => ['facebook', 'twitter', 'email'],
                    ]);
                    ?>
                    <div class="sticky-aside">
                        <div class="social">
                            <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fagglohm&tabs=timeline&width=245&height=600&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=false&appId=861795953942578"
                                    width="240" height="600" style="border:none;overflow:hidden"
                                    allow="encrypted-media"></iframe>
                        </div><!--social-->
                    </div><!--sticky-aside-->
                </div><!--aside-->

            </div><!--content-wrapper-->

    <?php
        }
    ?>

    </div><!--container-->

    <?php
    wp_link_pages([
        'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'twentyfifteen') . '</span>',
        'after' => '</div>',
        'link_before' => '<span>',
        'link_after' => '</span>',
        'pagelink' => '<span class="screen-reader-text">' . __('Page', 'twentyfifteen') . ' </span>%',
        'separator' => '<span class="screen-reader-text">, </span>',
    ]);
    ?>

    </div><!-- .entry-content -->

    <?php edit_post_link(__('Edit', 'twentyfifteen'), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->'); ?>

</article><!-- #post-## -->
