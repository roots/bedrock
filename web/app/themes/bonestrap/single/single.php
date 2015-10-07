<?php get_header(); ?>

	<div id="content">

		<div id="inner-content" class="container clearfix">

		    <div id="main" class="row clearfix">

          <div class="col-sm-8">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

							<header class="page-header">

								<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
	              <p class="byline vcard"><?php
	                printf(__('Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&amp;</span> filed under %4$s.', 'bonestheme'), get_the_time('Y-m-j'), get_the_time(__('F js, Y', 'bonestheme')), bones_get_the_author_posts_link(), get_the_category_list(', '));
	              ?></p>

							</header> <!-- end article header -->

							<section class="entry-content clearfix" itemprop="articleBody">
								<?php the_content(); ?>
							</section> <!-- end article section -->

							<footer class="article-footer">
								<?php the_tags('<p class="tags"><span class="tags-title">' . __('Tags:', 'bonestheme') . '</span> ', ', ', '</p>'); ?>

							</footer> <!-- end article footer -->

							<?php comments_template(); ?>

						</article> <!-- end article -->

					<?php endwhile; ?>

					<?php else : ?>

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
