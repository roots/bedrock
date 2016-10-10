<div class="videos">
	<h3><?php _ex( 'Videos', 'Tutorial videos', 'wp-migrate-db' ); ?></h3>

	<iframe class="video-viewer" style="display: none;" width="640" height="360" src="" frameborder="0" allowfullscreen></iframe>

	<ul>
		<?php foreach ( $videos as $id => $video ) : ?>
			<li class="video" data-video-id="<?php echo $id; ?>">
				<a href="//www.youtube.com/watch?v=<?php echo $id; ?>" target="_blank"><img src="//img.youtube.com/vi/<?php echo $id; ?>/0.jpg" alt=""/></a>

				<h4><?php echo $video['title']; ?></h4>

				<p>
					<?php echo $video['desc']; ?>
				</p>
			</li>
		<?php endforeach; ?>
	</ul>
</div>