<?php
/**
 * Standard ultimate posts widget template
 *
 * @version     2.0.0
 */
?>

<?php if ($instance['before_posts']) : ?>
  <div class="esmp-before">
    <?php echo wpautop($instance['before_posts']); ?>
  </div>
<?php endif; ?>

<div class="esmp-posts hfeed">

  <?php if ($esmp_query->have_posts()) : ?>

      <?php while ($esmp_query->have_posts()) : $esmp_query->the_post(); ?>

      	<?php $total_esmp = get_post_meta($post->ID, 'esml_socialcount_TOTAL', true);
      	
      	$total_esmp = intval($total_esmp);
      	
      	if ($total_esmp == 0) {
      		continue;
      	}
      	?>
      
        <?php $current_post = ($post->ID == $current_post_id && is_single()) ? 'active' : ''; ?>

        <article >

          <header>

            <?php if (current_theme_supports('post-thumbnails') && $instance['show_thumbnail'] && has_post_thumbnail()) : ?>
              <div class="entry-image">
                <a href="<?php the_permalink(); ?>" rel="bookmark">
                  <?php the_post_thumbnail($instance['thumb_size']); ?>
                </a>
              </div>
            <?php endif; ?>

            <?php if (get_the_title() && $instance['show_title']) : ?>
              <h4 class="entry-title">
                <a href="<?php the_permalink(); ?>" rel="bookmark">
                  <?php the_title(); ?>
                </a>
              </h4>
            <?php endif; ?>
            
            <?php
            if ($instance['show_total_score'] || $instance['show_detailed_score']) :
            ?>
              <div class="entry-social-score">
				<?php 
				if ($instance['show_total_score']):
				$total_esmp = get_post_meta($post->ID, 'esml_socialcount_TOTAL', true);
				?>
				
				<?php 
				
				echo '<span class="entry-social">';
				echo '<i class="essb-icon-share"></i>';
				echo '<span class="social-value social-total-value">'.$total_esmp.'</span>';
				echo '</span>';
				
				?>
								
				<?php 
				
				endif;
				?>
				
				<?php 
				if ($instance['show_detailed_score']):
				//$current_post_data =  get_post_meta($post->ID, "esmp_data", true);
				//$data = unserialize($current_post_data);
				$data = array();
				$services = array(
						'facebook'   => 'Facebook',
						'twitter'    => 'Twitter',
						'googleplus' => 'Google Plus',
						'linkedin'   => 'LinkedIn',
						'pinterest'  => 'Pinterest',
						'diggs'      => 'Digg.com',
						'delicious'	 => 'Delicious',
						'stumbleupon'=> 'Stumble Upon'
				);
				
				foreach ($services as $key => $name) {
					$data[$key] =  get_post_meta($post->ID, "esml_socialcount_".$key, true);
				}
								
				foreach ($data as $key => $value) {
					echo '<span class="entry-social">';
					echo '<i class="essb-icon-'.$key.'"></i>';
					echo '<span class="social-value">'.(isset($value) ? $value : 0).'</span>';
					echo '</span>';
				}
				
				?>
				
				<?php
				endif;
				?>
              </div>
            <?php endif; ?>
            

            <?php if ($instance['show_date'] || $instance['show_author'] || $instance['show_comments']) : ?>

              <div class="entry-meta">

                <?php if ($instance['show_date']) : ?>
                  <time class="published" datetime="<?php echo get_the_time('c'); ?>"><?php echo get_the_time($instance['date_format']); ?></time>
                <?php endif; ?>

                <?php if ($instance['show_date'] && $instance['show_author']) : ?>
                  <span class="sep"><?php _e('|', 'esmp'); ?></span>
                <?php endif; ?>

                <?php if ($instance['show_author']) : ?>
                  <span class="author vcard">
                    <?php echo __('By', 'esmp'); ?>
                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn">
                      <?php echo get_the_author(); ?>
                    </a>
                  </span>
                <?php endif; ?>

                <?php if ($instance['show_author'] && $instance['show_comments']) : ?>
                  <span class="sep"><?php _e('|', 'esmp'); ?></span>
                <?php endif; ?>

                <?php if ($instance['show_comments']) : ?>
                  <a class="comments" href="<?php comments_link(); ?>">
                    <?php comments_number(__('No comments', 'esmp'), __('One comment', 'esmp'), __('% comments', 'esmp')); ?>
                  </a>
                <?php endif; ?>

              </div>

            <?php endif; ?>

          </header>

          <?php if ($instance['show_excerpt']) : ?>
            <div class="entry-summary">
              <p>
                <?php echo get_the_excerpt(); ?>
                <?php if ($instance['show_readmore']) : ?>
                  <a href="<?php the_permalink(); ?>" class="more-link"><?php echo $instance['excerpt_readmore']; ?></a>
                <?php endif; ?>
              </p>
            </div>
          <?php elseif ($instance['show_content']) : ?>
            <div class="entry-content">
              <?php the_content() ?>
            </div>
          <?php endif; ?>

          <footer>

            <?php
            $categories = get_the_term_list($post->ID, 'category', '', ', ');
            if ($instance['show_cats'] && $categories) :
            ?>
              <div class="entry-categories">
                <strong class="entry-cats-label"><?php _e('Posted in', 'esmp'); ?>:</strong>
                <span class="entry-cats-list"><?php echo $categories; ?></span>
              </div>
            <?php endif; ?>

            <?php
            $tags = get_the_term_list($post->ID, 'post_tag', '', ', ');
            if ($instance['show_tags'] && $tags) :
            ?>
              <div class="entry-tags">
                <strong class="entry-tags-label"><?php _e('Tagged', 'esmp'); ?>:</strong>
                <span class="entry-tags-list"><?php echo $tags; ?></span>
              </div>
            <?php endif; ?>
                        
            <?php if ($custom_fields) : ?>
              <?php $custom_field_name = explode(',', $custom_fields); ?>
              <div class="entry-custom-fields">
                <?php foreach ($custom_field_name as $name) :
                  $name = trim($name);
                  $custom_field_values = get_post_meta($post->ID, $name, true);
                  if ($custom_field_values) : ?>
                    <div class="custom-field custom-field-<?php echo $name; ?>">
                      <?php
                      if (!is_array($custom_field_values)) {
                        echo $custom_field_values;
                      } else {
                        $last_value = end($custom_field_values);
                        foreach ($custom_field_values as $value) {
                          echo $value;
                          if ($value != $last_value) echo ', ';
                        }
                      }
                      ?>
                    </div>
                  <?php endif;
                endforeach; ?>
              </div>
            <?php endif; ?>

          </footer>

        </article>

      <?php endwhile; ?>

  <?php else : ?>

    <p class="esmp-not-found">
      <?php _e('No posts found.', 'esmp'); ?>
    </p>

  <?php endif; ?>

</div>

<?php if ($instance['after_posts']) : ?>
  <div class="esmp-after">
    <?php echo wpautop($instance['after_posts']); ?>
  </div>
<?php endif; ?>