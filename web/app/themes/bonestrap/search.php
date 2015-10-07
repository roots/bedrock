<?php get_header(); ?>

  <div id="content">

    <div id="inner-content" class="container clearfix">

      <div id="main" class="row clearfix">

        <div class="col-sm-8">

          <h1 class="archive-title"><span><?php _e('Search Results for:', 'bonestraptheme'); ?></span> <?php echo esc_attr(get_search_query()); ?></h1>

          <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

          <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

            <header class="article-header">

              <h3 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
              <p class="byline vcard"><?php
                printf(__('Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'bonestraptheme'), get_the_time('Y-m-j'), get_the_time(__('F jS, Y', 'bonestraptheme')), bonestrap_get_the_author_posts_link(), get_the_category_list(', '));
              ?></p>

            </header> <!-- end article header -->

            <section class="entry-content clearfix">

              <?php the_post_thumbnail( 'bones-thumb-300' ); ?>

              <?php the_excerpt(); ?>

            </section> <!-- end article section -->

            <footer class="article-footer">

            </footer> <!-- end article footer -->

          </article> <!-- end article -->

          <?php endwhile; ?>

              <?php if (function_exists('bonestrap_page_navi')) { ?>
                <?php bonestrap_page_navi(); ?>
              <?php } else { ?>
                <nav class="wp-prev-next">
                  <ul class="clearfix">
                    <li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', "bonestraptheme")) ?></li>
                    <li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', "bonestraptheme")) ?></li>
                  </ul>
                </nav>
              <?php } ?>

          <?php else : ?>

              <article id="post-not-found" class="hentry clearfix">
                <header class="article-header">
                  <h1><?php _e("Oops, Post Not Found!", "bonestraptheme"); ?></h1>
                </header>
                <section class="entry-content">
                  <p><?php _e("Uh Oh. Something is missing. Try double checking things.", "bonestraptheme"); ?></p>
                </section>
                <footer class="article-footer">
                    <p><?php _e("This is the error message in the archive.php template.", "bonestraptheme"); ?></p>
                </footer>
              </article>

          <?php endif; ?>
        </div> <!-- end column -->

        <div class="col-sm-4">
          <?php get_sidebar(); ?>
        </div>

      </div> <!-- end #main -->

    </div> <!-- end #inner-content -->

  </div> <!-- end #content -->

<?php get_footer(); ?>

