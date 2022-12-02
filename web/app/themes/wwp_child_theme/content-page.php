<?php
/**
 * The template used for displaying page content
 *
 * @package    WordPress
 * @subpackage WonderWp_theme
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('page-' . $post->post_name); ?>
     data-name="<?php echo $post->post_name; ?>">
    <?php
    $postThumb = \WonderWp\Component\Media\Medias::getFeaturedImage(get_the_ID());
    ?>

    <header class="entry-header <?php if (!empty($postThumb)) {
        echo 'hasPostThumb';
    } ?>">
        <?php if (!empty($postThumb)) : ?>
            <figure class="post-thumbnail">
                <?php the_post_thumbnail('large', ['loading' => 'eager', 'class' => 'no-lazy']); ?>
            </figure>
        <?php endif; ?>
        <?php
        if (!\WonderWp\Functions\isAjax()) {
            /** @var \WonderWp\Theme\Core\Service\ThemeViewService $viewService */
            $viewService = wwp_get_theme_service('view');
            if (!empty($viewService) && is_object($viewService)) {
                echo $viewService->getBreadcrumbs();
            }
        } ?>
        <div class="entry-title-wrapper">
            <div class="container">
                <?php echo '<h1 class="entry-title">' . str_replace(' | ', '<br>', get_the_title()) . '</h1>'; ?>
                <?php
                $excerpt = !empty($post->post_excerpt) ? $post->post_excerpt : null;
                if (!empty($excerpt)) {
                    //Allow shortcodes in excerpt
                    echo '<div class="excerpt">' . apply_filters('the_excerpt', $excerpt) . '</div>';
                }
                ?>
            </div>
        </div>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <main class="main" role="main">

            <?php the_content(); ?>

        </main><!-- main -->
    </div><!-- .entry-content -->

    <?php edit_post_link(__('Edit', 'twentyfifteen'), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->'); ?>

</div><!-- #post-## -->
