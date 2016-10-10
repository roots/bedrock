<tr class="wpmdb-setting-title">
	<td colspan="2"><h3><?php _e( 'Compatibility', 'wp-migrate-db' ); ?></h3></td>
</tr>

<tr>
	<td><?php $this->template( 'checkbox', 'common', array( 'key' => 'plugin-compatibility', 'value' => $plugin_compatibility_checked ) ); ?></td>
	<td>
		<h4>
			<?php _e( 'Plugin Compatibility Mode', 'wp-migrate-db' ); ?> <a href="#" class="general-helper plugin-compatibility-helper js-action-link"></a>
			<div class="plugin-compatibility-message helper-message bottom">
				<?php _e( 'Some plugins add a lot of overhead to each request, requiring extra memory and CPU. And some plugins even interfere with migrations and cause them to fail. We recommend only loading plugins that affect migration requests, for example a plugin that hooks into WP Migrate DB.', 'wp-migrate-db' ); ?></br>
			</div>
			<span class="setting-status"></span>
		</h4>
		<p><?php _e( 'Avoid plugin conflicts and improve performance by not loading plugins for migration requests.', 'wp-migrate-db' ); ?></p>
	</td>
</tr>

<tr class="plugin-compatibility-section">
	<td colspan="2">
		<div class="indent-wrap expandable-content plugin-compatibility-wrap select-wrap">
			<select autocomplete="off" class="multiselect" id="selected-plugins" name="selected_plugins[]" multiple="multiple">
				<?php
				$blacklist = array_flip( (array) $this->settings['blacklist_plugins'] );
				foreach ( get_plugins() as $key => $plugin ) {
					if ( 0 === strpos( $key, 'wp-migrate-db' ) ) {
						continue;
					}
					$selected = ( isset( $blacklist[ $key ] ) ) ? ' selected' : '';
					printf( '<option value="%s"%s>%s</option>', $key, $selected, $plugin['Name'] );
				}
				?>
			</select>
			<br>
			<a class="multiselect-select-all js-action-link" href="#"><?php _e( 'Select All', 'wp-migrate-db' ); ?></a>
			<span class="select-deselect-divider">/</span>
			<a class="multiselect-deselect-all js-action-link" href="#"><?php _e( 'Deselect All', 'wp-migrate-db' ); ?></a>
			<span class="select-deselect-divider">/</span>
			<a class="multiselect-invert-selection js-action-link" href="#"><?php _e( 'Invert Selection', 'wp-migrate-db' ); ?></a>

			<p>
				<span class="button plugin-compatibility-save"><?php _e( 'Save Changes', 'wp-migrate-db' ); ?></span>
			</p>
		</div>
	</td>
</tr>
