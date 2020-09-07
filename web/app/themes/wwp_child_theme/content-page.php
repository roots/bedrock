<?php
/**
 * The template used for displaying page content
 *
 * @package    WordPress
 * @subpackage WonderWp_theme
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('page-' . $post->post_name); ?> data-name="<?php echo $post->post_name; ?>">
    <?php
    $postThumb = \WonderWp\Component\Media\Medias::getFeaturedImage(get_the_ID());
    ?>
    <?php if (!empty($postThumb)) : ?>
        <div class="post-thumbnail">
            <?php the_post_thumbnail('large',['loading'=>'eager','class'=>'no-lazy']); ?>
        </div><!-- .post-thumbnail -->
    <?php endif; ?>

    <header class="entry-header <?php if (!empty($postThumb)) {
        echo 'hasPostThumb';
    } ?>">
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

    </header><!-- .entry-header -->

    <div class="entry-content">
        <main class="main" role="main">

            <?php
            /** @var \WonderWp\Theme\Core\Service\ThemeViewService $viewService */
            $viewService = wwp_get_theme_service('view');
            if (!empty($viewService) && is_object($viewService)) {
                echo $viewService->getBreadcrumbs();
            } ?>

        <?php the_content(); ?>

        </main><!-- main -->
    </div><!-- .entry-content -->

    <?php edit_post_link(__('Edit', 'twentyfifteen'), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->'); ?>

</div><!-- #post-## -->
