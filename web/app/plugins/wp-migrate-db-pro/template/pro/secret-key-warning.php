<div class="updated warning inline-message">
	<strong><?php _e( 'Improve Security', 'wp-migrate-db' ); ?></strong> &mdash;
	<?php printf( __( 'We have implemented a more secure method of secret key generation since your key was generated. We recommend you <a href="%s">visit the Settings tab</a> and reset your secret key.', 'wp-migrate-db' ), '#settings' ); ?>
	<br/>
	<?php
	/* translators: 1: Remind Me Later, 2: Dismiss */
	printf( _x( '%1$s | %2$s', 'Improve Security actions', 'wp-migrate-db' ), $reminder, $dismiss );
	?>
</div>
