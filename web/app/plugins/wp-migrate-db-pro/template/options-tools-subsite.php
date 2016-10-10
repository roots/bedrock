<div class="wrap wpmdb">

	<?php /* This is a hack to get sitewide notices to appear above the visible title. https://github.com/deliciousbrains/wp-migrate-db-pro/issues/1436 */ ?>
	<h1 style="display:none;"></h1>
	
	<h1><?php echo esc_html( $this->get_plugin_title() ); ?></h1>
	
	<p><?php printf( esc_html__( '%1$s only runs at the Network Admin level. As there is no Tools menu in the Network Admin, the %2$s menu item is located under Settings.', 'wp-migrate-db' ), esc_html( $this->get_plugin_title() ), sprintf( '"<a href="%s">%s</a>"', esc_url( network_admin_url( 'settings.php?page=' . $this->core_slug ) ), esc_html( $this->get_plugin_title() ) ) ); ?></p>
</div>