<div class="progress-content progress-overlay-container">
	<span class="close-progress-content close-progress-content-button">&times;</span>

	<div class="progress-wrapper-primary">
		<div class="progress-info-wrapper clearfix">
			<h2 class="progress-title"><?php _e( 'Please wait while migration is running…', 'wp-migrate-db' ); ?></h2>
			<div class="progress-text"><?php _e( 'Establishing Connection', 'wp-migrate-db' ); ?></div>
			<span class="timer">00:00:00</span>
		</div>

	</div>

	<div class="stage-tabs"></div>
	<div class="migration-progress-stages"></div>

	<div class="migration-controls">
		<span class="pause-resume button"><?php _ex( 'Pause', 'Temporarily stop migrating', 'wp-migrate-db' ); ?></span>
		<span class="cancel button"><?php _ex( 'Cancel', 'Stop the migration', 'wp-migrate-db' ); ?></span>
		<span class="pause-before-finalize">
			<input id="pause-before-finalize" type="checkbox" name="pause_before_finalize" value="1" />
			<label id="pause-before-finalize-label" for="pause-before-finalize">
				<?php _e( 'Pause before replacing migrated tables', 'wp-migrate-db' ); ?>
			</label>
		</span>
	</div>
</div> <!-- end .progress-content -->
