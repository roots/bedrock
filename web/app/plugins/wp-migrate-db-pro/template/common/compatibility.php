<tr class="wpmdb-setting-title option-section compatibility-mode">
	<td colspan="2">

		<div class="header-expand-collapse clearfix" data-next=".compat-block" id="compatibility-header">
			<div class="expand-collapse-arrow collapsed">&#x25BC;</div>
			<div class="option-heading tables-header"><?php _e( 'Compatibility', 'wp-migrate-db' ); ?></div>
		</div>

		<div class="compatibility-mode-disabled"<?php if ( $this->compatibility_plugin_manager->is_muplugin_writable() ): ?> style="display: none;"<?php endif; ?>>
			<div class="inline-message error-notice notification-message">
				<?php printf( __( 'The compatibility plugin cannot be %s because the mu-plugin directory is not currently writable.  Please update the permissions of the mu-plugins folder:  <strong>%s</strong>', 'wp-migrate-db' ), ( $this->compatibility_plugin_manager->is_muplugin_installed() ? 'disabled' : 'enabled' ), $this->mu_plugin_dir );
				?>
			</div>
		</div>

		<div class="indent-wrap expandable-content compat-block">
			<table>

				<tr>
					<td><?php $this->template( 'checkbox', 'common', array(
							'key'      => 'plugin-compatibility',
							'value'    => $plugin_compatibility_checked,
							'disabled' => ! $this->compatibility_plugin_manager->is_muplugin_writable(),
						) ); ?></td>
					<td class="compatibility-mode-description">
						<h4>
							<?php _e( 'Plugins to Load for Migration Requests', 'wp-migrate-db' ); ?>

							<span class="setting-status"></span>
						</h4>

						<p class="has-margin"><?php printf( __( 'By default plugins are not loaded for migration requests. This enhances performance and reduces the likelihood of a third-party plugin interfering with migrations. To load certain plugins for migrations requests, select them below and save. <a href="%1$s" target="_blank">Learn More »</a>', 'wp-migrate-db' ), 'https://deliciousbrains.com/wp-migrate-db-pro/doc/compatibility-mode/' ); ?></p>
					</td>
				</tr>

				<tr class="plugin-compatibility-section">
					<td colspan="2">
						<div class="indent-wrap expandable-content plugin-compatibility-wrap select-wrap">
							<select autocomplete="off" class="multiselect" id="selected-plugins" name="selected_plugins[]" multiple="multiple">
								<?php
								$whitelist = array_flip( (array) $this->settings['whitelist_plugins'] );
								foreach ( get_plugins() as $key => $plugin ) {
									if ( 0 === strpos( $key, 'wp-migrate-db' ) ) {
										continue;
									}
									$selected = ( isset( $whitelist[ $key ] ) ) ? ' selected' : '';
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
								<span class="button plugin-compatibility-save"><?php _e( 'Save', 'wp-migrate-db' ); ?></span>
							</p>
						</div>
					</td>
				</tr>
			</table>

		</div>
	</td>
</tr>
