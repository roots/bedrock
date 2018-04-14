<?php
	$licence = $this->get_licence_key();
	$is_pro = $this->is_pro ? 'MDB%2BPaid' : 'MDB%2BFree';
?>
<div class="addons-tab content-tab">
	<div class="addons-content">
		<?php if ( ! empty( $licence ) && $this->is_pro ) : ?>
			<p><?php _e( 'Fetching addon details, please wait...', 'wp-migrate-db' ); ?></p>
		<?php else : ?>

			<?php if ( $this->is_pro ) : ?>
				<p class="inline-message warning">
					<strong><?php _ex( 'Activate Your License', 'License must be activated to use addons', 'wp-migrate-db' ); ?></strong> &ndash; <?php _e( 'Please switch to the Settings tab and activate your license. If your license includes the addons below, you will be able to install them from here with one-click.', 'wp-migrate-db' ); ?>
				</p>
			<?php else: ?>
				<p class="inline-message warning">
					<strong><?php _ex( 'Get Addons', 'Addons are available with a developer license and better', 'wp-migrate-db' ); ?></strong> &ndash; <?php printf( __( 'The following addons are available with the WP Migrate DB Pro Developer license and better. Visit  <a href="%s" target="_blank">deliciousbrains.com</a> to purchase in just a few clicks.', 'wp-migrate-db' ), "https://deliciousbrains.com/wp-migrate-db-pro/?utm_campaign=WP%2BMigrate%2BDB%2BPro%2BUpgrade&utm_source=$is_pro&utm_medium=insideplugin" ); ?>
				</p>
			<?php endif; ?>

			<article class="addon wp-migrate-db-pro-media-files">
				<div class="desc">
					<h1><?php _e( 'Media Files', 'wp-migrate-db' ); ?></h1>
					<p><?php printf( __( 'Allows you to push and pull your files in the Media Library between two WordPress installs. It can compare both libraries and only migrate those missing or updated, or it can do a complete copy of one site\'s library to another. <a href="%s">More Details &rarr;</a>', 'wp-migrate-db' ), "https://deliciousbrains.com/wp-migrate-db-pro/doc/media-files-addon/?utm_campaign=addons%2Binstall&utm_source=$is_pro&utm_medium=insideplugin" ); ?></p>
				</div>
			</article>

			<article class="addon wp-migrate-db-pro-cli">
				<div class="desc">
					<h1><?php _e( 'CLI', 'wp-migrate-db' ); ?></h1>
					<p><?php printf( __( 'Integrates WP Migrate DB Pro with WP-CLI allowing you to run migrations from the command line: %s <a href="%s">More Details &rarr;</a>', 'wp-migrate-db' ), '<code>wp migratedb &lt;push|pull&gt; &lt;url&gt; &lt;secret-key&gt;</code> <code>[--find=&lt;strings&gt;] [--replace=&lt;strings&gt;] ...</code>', "https://deliciousbrains.com/wp-migrate-db-pro/doc/cli-addon/?utm_campaign=addons%2Binstall&utm_source=$is_pro&utm_medium=insideplugin" ); ?></p>
				</div>
			</article>

			<article class="addon wp-migrate-db-pro-multisite-tools">
				<div class="desc">
					<h1><?php _e( 'Multisite Tools', 'wp-migrate-db' ); ?></h1>
					<p><?php printf( __( 'Export a subsite as an SQL file that can then be imported as a single site install. <a href="%s">More Details &rarr;</a>', 'wp-migrate-db' ), "https://deliciousbrains.com/wp-migrate-db-pro/doc/multisite-tools-addon/?utm_campaign=addons%2Binstall&utm_source=$is_pro&utm_medium=insideplugin" ); ?></p>
				</div>
			</article>

		<?php endif; ?>
	</div>
</div>