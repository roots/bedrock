<div class="option-section table-options">
	<div class="header-expand-collapse clearfix">
		<div class="expand-collapse-arrow collapsed">&#x25BC;</div>
		<div class="option-heading tables-header"><?php _ex( 'Tables', 'Database tables', 'wp-migrate-db' ); ?></div>
	</div>

	<div class="indent-wrap expandable-content table-select-wrap" style="display: none;">

		<ul class="option-group table-migrate-options">
			<li class="action-text import">
				<label for="search-all-imported">
					<input id="search-all-imported" type="radio" value="search_all_imported" name="table_migrate_option"<?php echo ( $loaded_profile['table_migrate_option'] == 'search_all_imported' ? ' checked="checked"' : '' ); ?> />
					<span><?php _e( 'Run the find & replace all imported tables', 'wp-migrate-db' ); ?></span>
				</label>
			</li>
			<li>
				<label for="migrate-only-with-prefix">
					<input id="migrate-only-with-prefix" type="radio" value="migrate_only_with_prefix" name="table_migrate_option"<?php echo( $loaded_profile['table_migrate_option'] == 'migrate_only_with_prefix' ? ' checked="checked"' : '' ); ?> />
					<span class="action-text push pull savefile"><?php _e( 'Migrate all tables with prefix', 'wp-migrate-db' ); ?></span>
					<span class="action-text find_replace"><?php _e( 'Search in all tables with prefix', 'wp-migrate-db' ); ?></span>
					<span class="action-text import"><?php _e( 'Run the find & replace on all imported tables with prefix', 'wp-migrate-db' ); ?></span>
					 <span class="action-text find_replace push pull savefile import">
						 "<span class="table-prefix"><?php echo esc_html( $wpdb->base_prefix ); ?></span>"
					 </span>
				</label>
			</li>
			<li>
				<label for="migrate-selected">
					<input id="migrate-selected" class="show-multiselect" type="radio" value="migrate_select" name="table_migrate_option"<?php echo( $loaded_profile['table_migrate_option'] == 'migrate_select' ? ' checked="checked"' : '' ); ?> />
					<span class="action-text savefile push pull"><?php _e( 'Migrate only selected tables below', 'wp-migrate-db' ); ?></span>
					<span class="action-text find_replace"><?php _e( 'Search only in selected tables below', 'wp-migrate-db' ); ?></span>
					<span class="action-text import"><?php _e( 'Run the find & replace on the imported tables selected below', 'wp-migrate-db' ); ?></span>
				</label>
			</li>
		</ul>

		<div class="select-tables-wrap select-wrap">
			<select multiple="multiple" name="select_tables[]" id="select-tables" class="multiselect" autocomplete="off">
				<?php
				$table_sizes        = $this->get_table_sizes();
				$temp_prefix_length = strlen( $this->temp_prefix );
				foreach ( $this->get_tables() as $table ) :
					if( ! isset( $table_sizes[ $table ] ) || $this->temp_prefix === substr( $table, 0, $temp_prefix_length ) ) {
						continue;
					}
					$size = (int) $table_sizes[ $table ] * 1024;
					if ( ! empty( $loaded_profile['select_tables'] ) && in_array( $table, $loaded_profile['select_tables'] ) ) {
						printf( '<option value="%1$s" selected="selected">%1$s (%2$s)</option>', esc_html( $table ), size_format( $size ) );
					} else {
						printf( '<option value="%1$s">%1$s (%2$s)</option>', esc_html( $table ), size_format( $size ) );
					}
				endforeach;
				?>
			</select>
			<br/>
			<a href="#" class="multiselect-select-all js-action-link"><?php _e( 'Select All', 'wp-migrate-db' ); ?></a>
			<span class="select-deselect-divider">/</span>
			<a href="#" class="multiselect-deselect-all js-action-link"><?php _e( 'Deselect All', 'wp-migrate-db' ); ?></a>
			<span class="select-deselect-divider">/</span>
			<a href="#" class="multiselect-invert-selection js-action-link"><?php _e( 'Invert Selection', 'wp-migrate-db' ); ?></a>
		</div>
	</div>
</div>
