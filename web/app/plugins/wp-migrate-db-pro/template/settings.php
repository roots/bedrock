<div class="settings-tab content-tab">
	<form method="post" id="settings-form" action="#settings" autocomplete="off">
		<table class="form-table">
			<?php $this->template_part( array( 'connection_info', 'toggle_remote_requests', 'licence', 'request_settings', 'compatibility', 'max_request_size' ) ); ?>
		</table>
	</form>
</div> <!-- end .settings-tab -->