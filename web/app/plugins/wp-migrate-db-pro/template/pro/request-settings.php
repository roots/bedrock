<tr class="wpmdb-setting-title">
	<td colspan="2"><h3><?php _e( 'Request Settings', 'wp-migrate-db' ); ?></h3></td>
</tr>

<tr>
	<td>
		<?php $this->template( 'checkbox', 'common', array( 'key' => 'verify_ssl' ) ); ?>
	</td>
	<td>
		<h4><?php _e( 'Certificate Verification', 'wp-migrate-db' ); ?> <a href="#" class="general-helper replace-guid-helper js-action-link"></a>
			<div class="ssl-verify-message helper-message">
				<?php _e( 'We disable SSL verification by default because a lot of people\'s environments are not setup for it to work. For example, with XAMPP, you have to manually enable OpenSSL by editing the php.ini. Without SSL verification, an HTTPS connection is vulnerable to a man-in-the-middle attack, so we do recommend you configure your environment and enable this.', 'wp-migrate-db' ); ?>
			</div>
			<span class="setting-status"></span>
		</h4>
		<p><?php _e( 'Verify the authenticity of the remote server’s TLS certificate. ', 'wp-migrate-db' ); ?></p>
	</td>
</tr>

<tr>
	<td colspan="2">
		<div class="slider-outer-wrapper max-request-size">
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
		</div>
	</td>
</tr>

<tr class="option-section">
	<td colspan="2">
		<div class="slider-outer-wrapper delay-between-requests">
			<div class="clearfix slider-label-wrapper">
				<div class="slider-label"><span><?php _e( 'Delay Between Requests', 'wp-migrate-db' ); ?></span>
					<a class="general-helper slider-helper js-action-link" href="#"></a>

					<div class="slider-message helper-message">
						<?php printf( __( 'Some servers have rate limits which the plugin can hit when performing migrations. If you\'re experiencing migration failures due to server rate limits, you should set this to one or more seconds to alleviate the problem.', 'wp-migrate-db' ) ); ?>
					</div>
				</div>
				<div class="amount"></div>
			</div>
			<div class="slider"></div>
		</div>
	</td>
</tr>