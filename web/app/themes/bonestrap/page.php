<?php get_header(); ?>

	<div id="content">

		<div id="inner-content" class="container clearfix">

		    <div id="main" class="row clearfix">

          <div class="col-sm-8">

				    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

					    <header class="page-header">

						    <h1><?php the_title(); ?></h1>

					    </header> <!-- end article header -->

					    <section class="entry-content clearfix">
						    <?php the_content(); ?>
						  </section> <!-- end article section -->

					    <footer class="article-footer">
                <?php the_tags('<span class="tags">' . __('Tags:', 'bonestheme') . '</span> ', ', ', ''); ?>

					    </footer> <!-- end article footer -->

				    </article> <!-- end article -->

				    <?php endwhile; else : ?>

              <article id="post-not-found" class="hentry clearfix">
              	<header class="page-header">
              		<h1>Page not found.</h1>
              	</header>
              	<section class="entry-content">
              		<p>Go back to the <a href="/">homepage</a>.</p>
              	</section>
              </article>

				    <?php endif; ?>
          </div>

          <div class="col-sm-4">
            <?php get_sidebar(); ?>
          </div>

				</div> <!-- end #main -->

		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>
