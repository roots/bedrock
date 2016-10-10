<tr class="wpmdb-setting-title">
	<td colspan="2"><h3><?php _e( 'Your License', 'wp-migrate-db' ); ?></h3></td>
</tr>
<tr class="licence-form option-section licence-wrap" method="post" action="#settings">
	<td colspan="2">
		<?php if ( $this->is_licence_constant() ) : ?>
			<p>
				<?php _e( 'The license key is currently defined in wp-config.php.', 'wp-migrate-db' ); ?>
			</p>
		<?php else : ?>
			<?php if ( ! empty( $licence ) ) :
				echo $this->get_formatted_masked_licence();
				?>
				<p class="licence-status"></p>
			<?php else : ?>
				<div class="licence-not-entered">
					<input type="text" class="licence-input" autocomplete="off"/>
					<button class="button register-licence" type="button"><?php _e( 'Activate License', 'wp-migrate-db' ); ?></button>
					<p class="licence-status"></p>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</td>
</tr>