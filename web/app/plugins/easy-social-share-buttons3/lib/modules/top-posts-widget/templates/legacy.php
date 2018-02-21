<?php
?>

<?php if ($instance['before_posts']) : ?>
  <div class="esmp-before">
    <?php echo wpautop($instance['before_posts']); ?>
  </div>
<?php endif; ?>

<?php if ($esmp_query->have_posts()) : ?>

  <ul>

  <?php while ($esmp_query->have_posts()) : $esmp_query->the_post(); ?>

    <?php $current_post = ($post->ID == $current_post_id && is_single()) ? 'current-post-item' : ''; ?>

    <li class="<?php echo ($post->ID == $current_post_id && is_single())?'current-post-item':'' ?>">

      <?php if (current_theme_supports('post-thumbnails') && $instance['show_thumbnail'] && has_post_thumbnail()) : ?>
        <div class="esmp-image">
          <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <?php the_post_thumbnail($instance['thumb_size']); ?>
          </a>
        </div>
      <?php endif; ?>

      <div class="esmp-content">

        <?php if (get_the_title() && $instance['show_title']) : ?>
          <p class="post-title">
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
              <?php the_title(); ?>
            </a>
          </p>
        <?php endif; ?>

        <?php if ($instance['show_date']) : ?>
          <p class="post-date">
            <?php the_time($instance['date_format']); ?>
          </p>
        <?php endif; ?>

        <?php if ($instance['show_author']) : ?>
          <p class="post-author">
            <span class="post-author-label"><?php _e('By', 'esmp'); ?>:</span>
            <?php the_author_posts_link(); ?>
          </p>
        <?php endif; ?>

        <?php if ($instance['show_comments']) : ?>
          <p class="post-comments">
            <?php comments_number(__('No responses', 'esmp'), __('One response', 'esmp'), __('% responses', 'esmp')); ?>
          </p>
        <?php endif; ?>

        <?php if ($instance['show_excerpt']) : ?>
          <?php
          $linkmore = '';
          if ($instance['show_readmore']) {
            $linkmore = ' <a href="'.get_permalink().'" class="more-link">'.$excerpt_readmore.'</a>';
          }
          ?>
          <p class="post-excerpt"><?php echo get_the_excerpt() . $linkmore; ?></p>
        <?php endif; ?>

        <?php if ($instance['show_content']) : ?>
          <p class="post-content"><?php the_content() ?></p>
        <?php endif; ?>

        <?php
        $categories = get_the_term_list($post->ID, 'category', '', ', ');
        if ($instance['show_cats'] && $categories) :
        ?>
          <p class="post-cats">
            <span class="post-cats-label"><?php _e('Categories', 'esmp'); ?>:</span>
            <span class="post-cats-list"><?php echo $categories; ?></span>
          </p>
        <?php endif; ?>

        <?php
        $tags = get_the_term_list($post->ID, 'post_tag', '', ', ');
        if ($instance['show_tags'] && $tags) :
        ?>
          <p class="post-tags">
            <span class="post-tags-label"><?php _e('Tags', 'esmp'); ?>:</span>
            <span class="post-tags-list"><?php echo $tags; ?></span>
          </p>
        <?php endif; ?>

        <?php if ($custom_fields) {
          $custom_field_name = explode(',', $custom_fields);
          foreach ($custom_field_name as $name) { 
            $name = trim($name);
            $custom_field_values = get_post_meta($post->ID, $name, true);
            if ($custom_field_values) {
              echo '<p class="post-meta post-meta-'.$name.'">';
              if (!is_array($custom_field_values)) {
                echo $custom_field_values;
              } else {
                $last_value = end($custom_field_values);
                foreach ($custom_field_values as $value) {
                  echo $value;
                  if ($value != $last_value) echo ', ';
                }
              }
              echo '</p>';
            }
          } 
        } ?>

      </div>

    </li>

  <?php endwhile; ?>
  
  </ul>

<?php else : ?>

  <p><?php _e('No posts found.', 'esmp'); ?></p>

<?php endif; ?>

<?php if ($instance['after_posts']) : ?>
  <div class="esmp-after">
    <?php echo wpautop($instance['after_posts']); ?>
  </div>
<?php endif; ?>