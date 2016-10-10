<div class="updated warning inline-message">
	<p>
		<?php
		printf( __( 'We\'ve detected that <code>WP_HTTP_BLOCK_EXTERNAL</code> is enabled which will prevent WP Migrate DB Pro from functioning properly. You should either disable <code>WP_HTTP_BLOCK_EXTERNAL</code> or add any sites that you\'d like to migrate to or from with WP Migrate DB Pro to <code>WP_ACCESSIBLE_HOSTS</code> (api.deliciousbrains.com must be added to <code>WP_ACCESSIBLE_HOSTS</code> for the API to work). More information on this can be found <a href="%s" target="_blank">here</a>.', 'wp-migrate-db' ), 'https://deliciousbrains.com/wp-migrate-db-pro/doc/wp_http_block_external/' );
		?>
	</p>

	<?php
	/* translators: 1: Remind Me Later, 2: Dismiss */
	printf( _x( '%1$s | %2$s', 'Block External actions', 'wp-migrate-db' ), $reminder, $dismiss );
	?>
</div>
