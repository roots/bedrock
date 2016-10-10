<?php if ( $this->is_pro ) return; ?>

<tr class="option-section slider-outer-wrapper max-request-size">
	<td colspan="2">
		<div class="clearfix slider-label-wrapper">
			<div class="slider-label"><span><?php _e( 'Maximum Request Size', 'wp-migrate-db' ); ?></span>
				<a class="general-helper slider-helper js-action-link" href="#"></a>

				<div class="slider-message helper-message">
					<?php printf( __( 'We\'ve detected that your server supports requests up to %s, but it\'s possible that your server has limitations that we could not detect. To be on the safe side, we set the default to 1 MB, but you can try throttling it up to get better performance. If you\'re getting a 413 error or having trouble with time outs, try throttling this setting down.', 'wp-migrate-db' ), size_format( $this->get_bottleneck( 'max' ) ) ); ?>
				</div>
			</div>
			<div class="amount"></div>
		</div>
		<div class="slider"></div>
	</td>
</tr>