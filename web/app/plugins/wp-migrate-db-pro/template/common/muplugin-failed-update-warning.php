<div class="below-title warning inline-message">
	<?php
	_e( '<strong>Compatibility Plugin Update Failed</strong> &mdash; ', 'wp-migrate-db' );
	_e( 'We could not update the Compatibility Mode plugin because the mu-plugins folder is not writable. Please update the permissions of the mu-plugins folder to enable Compatibility Mode. ', 'wp-migrate-db' );

	echo $dismiss;
	?>
</div>
