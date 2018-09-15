<?php

	if(!defined('LS_ROOT_FILE')) {
		header('HTTP/1.0 403 Forbidden');
		exit;
	}

	// Get screen options
	$lsScreenOptions = get_option('ls-screen-options', '0');
	$lsScreenOptions = ($lsScreenOptions == 0) ? array() : $lsScreenOptions;
	$lsScreenOptions = is_array($lsScreenOptions) ? $lsScreenOptions : unserialize($lsScreenOptions);

	// Defaults
	if(!isset($lsScreenOptions['showTooltips'])) { $lsScreenOptions['showTooltips'] = 'true'; }
	if(!isset($lsScreenOptions['numberOfSliders'])) { $lsScreenOptions['numberOfSliders'] = '25'; }

	// Get current page
	$curPage = (!empty($_GET['paged']) && is_numeric($_GET['paged'])) ? (int) $_GET['paged'] : 1;
	// $curPage = ($curPage >= $maxPage) ? $maxPage : $curPage;

	// Set filters
	$userFilters = false;
	$showAllSlider = false;

	$urlParamFilter = 'published';
	$urlParamOrder 	= 'date_c';
	$urlParamTerm 	= '';

	$filters = array(
		'orderby' => 'date_c',
		'order' => 'DESC',
		'page' => $curPage,
		'limit' => (int) $lsScreenOptions['numberOfSliders']
	);

	if( ! empty($_GET['filter']) && $_GET['filter'] === 'all' ) {
		$userFilters = true;
		$showAllSlider = true;
		$urlParamFilter = htmlentities($_GET['filter']);
		$filters['exclude'] = array();
	}

	if( ! empty($_GET['order']) ) {
		$userFilters = true;
		$urlParamOrder = $_GET['order'];
		$filters['orderby'] = htmlentities($_GET['order']);

		if( $_GET['order'] === 'name' ) {
			$filters['order'] = 'ASC';
		}
	}

	if( ! empty($_GET['term']) ) {
		$userFilters = true;
		$urlParamTerm = htmlentities($_GET['term']);
		$filters['where'] = "name LIKE '%".esc_sql($_GET['term'])."%' OR slug LIKE '%".esc_sql($_GET['term'])."%'";
	}

	// Find sliders
	$sliders = LS_Sliders::find($filters);

	// Pager
	$maxItem = LS_Sliders::$count;
	$maxPage = ceil($maxItem / (int) $lsScreenOptions['numberOfSliders']);
	$maxPage = $maxPage ? $maxPage : 1;

	$layout = get_user_meta(get_current_user_id(), 'ls-sliders-layout', true);

	// Custom capability
	$custom_capability = $custom_role = get_option('layerslider_custom_capability', 'manage_options');
	$default_capabilities = array('manage_network', 'manage_options', 'publish_pages', 'publish_posts', 'edit_posts');

	if(in_array($custom_capability, $default_capabilities)) {
		$custom_capability = '';
	} else {
		$custom_role = 'custom';
	}


	// Site activation
	$code 		= get_option('layerslider-purchase-code', '');
	$validity 	= get_option('layerslider-authorized-site', '0');
	$channel 	= get_option('layerslider-release-channel', 'stable');

	// Purchase code
	$codeFormatted = '';
	if(!empty($code)) {
		$start = substr($code, 0, -6);
		$end = substr($code, -6);
		$codeFormatted = preg_replace("/[a-zA-Z0-9]/", '●', $start) . $end;
		$codeFormatted = str_replace('-', ' ', $codeFormatted);
	}

	// Google Fonts
	$googleFonts 		= get_option('ls-google-fonts', array());
	$googleFontScripts 	= get_option('ls-google-font-scripts', array('latin', 'latin-ext'));


	// Template store data
	$lsStoreUpdate 		= get_option('ls-store-last-updated', 0);
	$lsStoreData 		= get_option('ls-store-data', false);
	$lsStoreInterval 	= ! empty($lsStoreData) ? DAY_IN_SECONDS : HOUR_IN_SECONDS;
	$lsStoreLastViewed 	= get_user_meta( get_current_user_id(), 'ls-store-last-viewed', true);

	// Update last visited date
	if( empty( $lsStoreLastViewed ) ) {
		$lsStoreLastViewed = time();
		update_user_meta(get_current_user_id(), 'ls-store-last-viewed', date('Y-m-d'));
	}

	// Update store data
	if( $lsStoreUpdate < time() - $lsStoreInterval ) {
		update_option('ls-store-last-updated', time());
		$data = wp_remote_retrieve_body(wp_remote_get(sprintf('%ssliders/', LS_REPO_BASE_URL, LS_MARKETPLACE_ID)));
		$lsStoreData = ! empty($data) ? json_decode($data, true) : array();
		update_option('ls-store-data', $lsStoreData, false);
	}

	$lsStoreHasUpdate = ( ! empty($lsStoreData['last_updated']) && $lsStoreLastViewed <  $lsStoreData['last_updated'] );

	// Notification messages
	$notifications = array(

		'cacheEmpty' => __('Successfully emptied LayerSlider caches.'),
		'updateStore' => __('Successfully updated the Template Store library.', 'LayerSlider'),

		'removeSelectError' => __('No sliders were selected to remove.', 'LayerSlider'),
		'removeSuccess' => __('The selected sliders were removed.', 'LayerSlider'),

		'duplicateSuccess' => __('The selected sliders were duplicated.', 'LayerSlider'),

		'deleteSelectError' => __('No sliders were selected.', 'LayerSlider'),
		'deleteSuccess' => __('The selected sliders were permanently deleted.', 'LayerSlider'),
		'mergeSelectError' => __('You need to select at least 2 sliders to merge them.', 'LayerSlider'),
		'mergeSuccess' => __('The selected items were merged together as a new slider.', 'LayerSlider'),
		'restoreSelectError' => __('No sliders were selected.', 'LayerSlider'),
		'restoreSuccess' => __('The selected sliders were restored.', 'LayerSlider'),

		'exportNotFound' => __('No sliders were found to export.', 'LayerSlider'),
		'exportSelectError' => __('No sliders were selected to export.', 'LayerSlider'),
		'exportZipError' => __('The PHP ZipArchive extension is required to import .zip files.', 'LayerSlider'),

		'importSelectError' => __('Choose a file to import sliders.', 'LayerSlider'),
		'importFailed' => __('The import file seems to be invalid or corrupted.', 'LayerSlider'),
		'importSuccess' => __('Your slider has been imported.', 'LayerSlider'),
		'permissionError' => __('Your account does not have the necessary permission you have chosen, and your settings have not been saved in order to prevent locking yourself out of the plugin.', 'LayerSlider'),
		'permissionSuccess' => __('Permission changes has been updated.', 'LayerSlider'),
		'googleFontsUpdated' => __('Your Google Fonts library has been updated.', 'LayerSlider'),
		'generalUpdated' => __('Your settings has been updated.', 'LayerSlider')
	);
?>
<div id="ls-screen-options" class="metabox-prefs hidden">
	<div id="screen-options-wrap" class="hidden">
		<form id="ls-screen-options-form" method="post" novalidate>
			<h5><?php _e('Show on screen', 'LayerSlider') ?></h5>
			<label><input type="checkbox" name="showTooltips"<?php echo $lsScreenOptions['showTooltips'] == 'true' ? ' checked="checked"' : ''?>> <?php _e('Tooltips', 'LayerSlider') ?></label><br><br>

			<?php _e('Show me', 'LayerSlider') ?> <input type="number" name="numberOfSliders" min="8" step="4" value="<?php echo $lsScreenOptions['numberOfSliders'] ?>"> <?php _e('sliders per page', 'LayerSlider') ?>
			<button class="button"><?php _e('Apply', 'LayerSlider') ?></button>
		</form>
	</div>
	<div id="screen-options-link-wrap" class="hide-if-no-js screen-meta-toggle">
		<button type="button" id="show-settings-link" class="button show-settings" aria-controls="screen-options-wrap" aria-expanded="false"><?php _e('Screen Options', 'LayerSlider') ?></button>
	</div>
</div>


<div id="ls-guides" class="metabox-prefs">
	<div id="ls-guides-wrap" class="hidden">
		<h5><?php _e('Interactive guides coming soon!') ?></h5>
		<p><?php _e("Interactive step-by-step tutorial guides will shortly arrive to help you get started using LayerSlider.", 'LayerSlider') ?></p>
	</div>
	<div id="show-guides-link-wrap" class="hide-if-no-js screen-meta-toggle">
		<button type="button" id="show-guides-link" class="button show-settings" aria-controls="ls-guides-wrap" aria-expanded="false"><?php _e('Guides', 'LayerSlider') ?></button>
	</div>
</div>

<!-- WP hack to place notification at the top of page -->
<div class="wrap ls-wp-hack">
	<h2></h2>

	<!-- Error messages -->
	<?php if(isset($_GET['message'])) : ?>
	<div class="ls-notification <?php echo isset($_GET['error']) ? 'error' : 'updated' ?>">
		<div><?php echo $notifications[ $_GET['message'] ] ?></div>
	</div>
	<?php endif; ?>
	<!-- End of error messages -->
</div>

<div class="wrap" id="ls-list-page">
	<h2><?php _e('Your Sliders', 'LayerSlider') ?></h2>

	<!-- Beta version -->
	<?php include LS_ROOT_PATH . '/templates/tmpl-beta-feedback.php'; ?>

	<!-- Add slider template -->
	<?php include LS_ROOT_PATH . '/templates/tmpl-add-slider-list.php'; ?>
	<?php include LS_ROOT_PATH . '/templates/tmpl-add-slider-grid.php'; ?>

	<!-- Import sample sliders template -->
	<?php include LS_ROOT_PATH . '/templates/tmpl-import-templates.php'; ?>

	<!-- Importing template -->
	<?php include LS_ROOT_PATH . '/templates/tmpl-importing.php'; ?>

	<!-- Import sample sliders template -->
	<?php include LS_ROOT_PATH . '/templates/tmpl-upload-sliders.php'; ?>

	<!-- Embed slider template -->
	<?php include LS_ROOT_PATH . '/templates/tmpl-embed-slider.php'; ?>

	<!-- Share sheet template -->
	<?php include LS_ROOT_PATH . '/templates/tmpl-share-sheet.php'; ?>



	<!-- Slider Filters -->
	<form method="get" id="ls-slider-filters">
		<input type="hidden" name="page" value="layerslider">
		<div class="layout">
			<a href="?page=layerslider&amp;action=layout&amp;type=list" data-help="<?php _e('List View', 'LayerSlider') ?>" class="dashicons dashicons-list-view"></a>
			<a href="?page=layerslider&amp;action=layout&amp;type=grid" data-help="<?php _e('Grid View', 'LayerSlider') ?>" class="dashicons dashicons-grid-view"></a>
		</div>
		<div class="filter">
			<?php _e('Show', 'LayerSlider') ?>
			<select name="filter">
				<option value="published"><?php _e('published', 'LayerSlider') ?></option>
				<option value="all" <?php echo $showAllSlider ? 'selected' : '' ?>><?php _e('all', 'LayerSlider') ?></option>
			</select>
			<?php _e('sliders', 'LayerSlider') ?>
		</div>
		<div class="sort">
			<?php _e('Sort by', 'LayerSlider') ?>
			<select name="order">
				<option value="name" <?php echo ($filters['orderby'] === 'name') ? 'selected' : '' ?>><?php _e('name', 'LayerSlider') ?></option>
				<option value="date_c" <?php echo ($filters['orderby'] === 'date_c') ? 'selected' : '' ?>><?php _e('date created', 'LayerSlider') ?></option>
				<option value="date_m" <?php echo ($filters['orderby'] === 'date_m') ? 'selected' : '' ?>><?php _e('date modified', 'LayerSlider') ?></option>
				<option value="schedule_start" <?php echo ($filters['orderby'] === 'schedule_start') ? 'selected' : '' ?>><?php _e('date scheduled', 'LayerSlider') ?></option>
			</select>
		</div>

		<div class="right">
			<input type="search" name="term" placeholder="<?php _e('Filter by name', 'LayerSlider') ?>" value="<?php echo ! empty($_GET['term']) ? htmlentities($_GET['term']) : '' ?>">
			<button class="button"><?php _e('Search', 'LayerSlider') ?></button>
		</div>
	</form>

	<form method="post" class="ls-slider-list-form">
		<input type="hidden" name="ls-bulk-action" value="1">
		<?php wp_nonce_field('bulk-action'); ?>

		<div>

			<!-- List View -->
			<?php if( $layout === 'list' ) : ?>
			<div class="ls-sliders-list">

				<a class="button import-templates <?php echo $lsStoreHasUpdate ? 'has-updates' : '' ?>" href="#" id="ls-import-samples-button">
					<i class="import dashicons dashicons-star-filled"></i>
					<span><?php _e('Template Store', 'LayerSlider') ?></span>
				</a>

				<a class="button" href="#" id="ls-import-button">
					<i class="import dashicons dashicons-upload"></i>
					<span><?php _e('Import Sliders', 'LayerSlider') ?></span>
				</a>

				<a class="button" href="#" id="ls-add-slider-button">
					<i class="add dashicons dashicons-plus"></i>
					<span><?php _e('Add New Slider', 'LayerSlider') ?></span>
				</a>

				<?php if( ! empty($sliders) ) : ?>
				<div class="ls-box">
					<table>
						<thead class="header">
							<tr>
								<td></td>
								<td><?php _e('ID', 'LayerSlider') ?></td>
								<td class="preview-td"><?php _e('Slider preview', 'LayerSlider') ?></td>
								<td><?php _e('Name', 'LayerSlider') ?></td>
								<td class="center"><?php _e('Shortcode', 'LayerSlider') ?></td>
								<td><?php _e('Slides', 'LayerSlider') ?></td>
								<td><?php _e('Created', 'LayerSlider') ?></td>
								<td><?php _e('Modified', 'LayerSlider') ?></td>
								<td></td>
							</tr>
						</thead>
						<tbody>
							<?php foreach($sliders as $key => $item) :
								$class = ($item['flag_deleted'] == '1') ? ' dimmed' : '';
								$preview = apply_filters('ls_preview_for_slider', $item );
							?>
							<tr class="slider-item<?php echo $class ?>" data-id="<?php echo $item['id'] ?>" data-slug="<?php echo htmlentities($item['slug']) ?>">
								<td><input type="checkbox" name="sliders[]" value="<?php echo $item['id'] ?>"></td>
								<td><span><?php echo $item['id'] ?></span></td>
								<td class="preview-td">
									<a class="preview" style="background-image: url(<?php echo  ! empty( $preview ) ? $preview : LS_ROOT_URL . '/static/admin/img/blank.gif' ?>);" href="?page=layerslider&action=edit&id=<?php echo $item['id'] ?>">

									</a>
								</td>
								<td class="name">
									<a href="?page=layerslider&action=edit&id=<?php echo $item['id'] ?>">
										<?php echo apply_filters('ls_slider_title', stripslashes($item['name']), 40) ?>
									</a>
								</td>
								<td class="center"><input type="text" class="ls-shortcode" value="[layerslider id=&quot;<?php echo !empty($item['slug']) ? $item['slug'] : $item['id'] ?>&quot;]" readonly></td>
								<td><span><?php echo isset($item['data']['layers']) ? count($item['data']['layers']) : 0 ?></span></td>
								<td><span><?php echo date('d/m/y', $item['date_c']) ?></span></td>
								<td><span><?php echo human_time_diff($item['date_m']) ?> <?php _e('ago', 'LayerSlider') ?></span></td>
								<td class="center">
									<?php if(!$item['flag_deleted']) : ?>
									<span class="slider-actions dashicons dashicons-arrow-down-alt2"
										data-id="<?php echo $item['id'] ?>"
										data-slug="<?php echo htmlentities($item['slug']) ?>"
										data-export-url="<?php echo wp_nonce_url('?page=layerslider&action=export&id='.$item['id'], 'export-sliders') ?>"
										data-duplicate-url="<?php echo wp_nonce_url('?page=layerslider&action=duplicate&id='.$item['id'], 'duplicate_'.$item['id']) ?>"
										data-remove-url="<?php echo wp_nonce_url('?page=layerslider&action=remove&id='.$item['id'], 'remove_'.$item['id']) ?>">
									</span>
									<?php else : ?>
									<a href="<?php echo wp_nonce_url('?page=layerslider&action=restore&id='.$item['id'], 'restore_'.$item['id']) ?>">
										<span class="dashicons dashicons-backup" data-help="<?php _e('Restore removed slider', 'LayerSlider') ?>"></span>
									</a>
									<?php endif; ?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>

					<!-- Slider actions template -->
					<div id="ls-slider-actions-template" class="ls-pointer ls-box ls-hidden">
						<span class="ls-mce-arrow"></span>
						<ul class="inner">
							<li>
								<a href="#" class="embed">
									<i class="dashicons dashicons-plus"></i>
									<?php _e('Embed Slider', 'LayerSlider') ?>
								</a>
							</li>
							<li>
								<a href="#">
									<i class="dashicons dashicons-share-alt2"></i>
									<?php _e('Export', 'LayerSlider') ?>
								</a>
							</li>
							<li>
								<a href="#">
									<i class="dashicons dashicons-admin-page"></i>
									<?php _e('Duplicate', 'LayerSlider') ?>
								</a>
							</li>
							<li>
								<a href="#" class="remove">
									<i class="dashicons dashicons-trash"></i>
									<?php _e('Remove', 'LayerSlider') ?>
								</a>
							</li>
						</ul>
					</div>
					<!-- End of Slider actions template -->
				</div>
				<?php endif ?>
			</div>
			<?php else : ?>

			<!-- Slider List -->
			<div class="ls-sliders-grid clearfix">

				<div class="slider-item hero import-templates <?php echo $lsStoreHasUpdate ? 'has-updates' : '' ?>">
					<div class="slider-item-wrapper">
						<a href="#" id="ls-import-samples-button" class="preview import-templates <?php echo $lsStoreHasUpdate ? 'has-updates' : '' ?>">
							<i class="import dashicons dashicons-star-filled"></i>
							<span><?php _e('Template Store', 'LayerSlider') ?></span>
						</a>
					</div>
				</div>
				<div class="slider-item hero">
					<div class="slider-item-wrapper">
						<a href="#" id="ls-import-button" class="preview">
							<i class="import dashicons dashicons-upload"></i>
							<span><?php _e('Import Sliders', 'LayerSlider') ?></span>
						</a>
					</div>
				</div>
				<div class="slider-item hero">
					<div class="slider-item-wrapper">
						<a href="#" id="ls-add-slider-button" class="preview">
							<i class="add dashicons dashicons-plus"></i>
							<span><?php _e('Add New Slider', 'LayerSlider') ?></span>
						</a>
					</div>
				</div>
				<?php if( ! empty($sliders) ) : ?>
				<?php
					foreach($sliders as $key => $item) :
					$class = ($item['flag_deleted'] == '1') ? 'dimmed' : '';
					$preview = apply_filters('ls_preview_for_slider', $item );
				?>
				<div class="slider-item <?php echo $class ?>">
					<div class="slider-item-wrapper">
						<input type="checkbox" name="sliders[]" class="checkbox ls-hover" value="<?php echo $item['id'] ?>">
						<?php if(!$item['flag_deleted']) : ?>
						<span class="ls-hover slider-actions dashicons dashicons-arrow-down-alt2"></span>
						<?php else : ?>
						<a href="<?php echo wp_nonce_url('?page=layerslider&action=restore&id='.$item['id'], 'restore_'.$item['id']) ?>">
							<span class="ls-hover dashicons dashicons-backup" data-help="<?php _e('Restore removed slider', 'LayerSlider') ?>"></span>
						</a>
						<?php endif; ?>
						<a class="preview" style="background-image: url(<?php echo  ! empty( $preview ) ? $preview : LS_ROOT_URL . '/static/admin/img/blank.gif' ?>);" href="?page=layerslider&action=edit&id=<?php echo $item['id'] ?>">
							<?php if( empty( $preview ) ) : ?>
							<div class="no-preview">
								<h5><?php _e('No Preview', 'LayerSlider') ?></h5>
								<small><?php _e('Previews are automatically generated from slide images in sliders.') ?></small>
							</div>
							<?php endif ?>
						</a>
						<div class="info">
							<div class="name">
								<?php echo apply_filters('ls_slider_title', stripslashes($item['name']), 40) ?>
							</div>
						</div>

						<ul class="slider-actions-sheet ls-hidden">
							<li>
								<a href="#" class="embed" data-id="<?php echo $item['id'] ?>" data-slug="<?php echo htmlentities($item['slug']) ?>">
									<i class="dashicons dashicons-plus"></i>
									<?php _e('Embed Slider', 'LayerSlider') ?>
								</a>
							</li>
							<li>
								<a href="<?php echo wp_nonce_url('?page=layerslider&action=export&id='.$item['id'], 'export-sliders') ?>">
									<i class="dashicons dashicons-share-alt2"></i>
									<?php _e('Export', 'LayerSlider') ?>
								</a>
							</li>
							<li>
								<a href="<?php echo wp_nonce_url('?page=layerslider&action=duplicate&id='.$item['id'], 'duplicate_'.$item['id']) ?>">
									<i class="dashicons dashicons-admin-page"></i>
									<?php _e('Duplicate', 'LayerSlider') ?>
								</a>
							</li>
							<li>
								<a href="<?php echo wp_nonce_url('?page=layerslider&action=remove&id='.$item['id'], 'remove_'.$item['id']) ?>" class="remove">
									<i class="dashicons dashicons-trash"></i>
									<?php _e('Remove', 'LayerSlider') ?>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<?php endif ?>
			<?php endif ?>


			<!-- No Slider Notification -->
			<?php if( empty($sliders ) ) : ?>
			<div id="ls-no-sliders">
				<div class="ls-notification-info">
					<i class="dashicons dashicons-info"></i>
					<?php if( $userFilters ) : ?>
					<span><?php _e('No sliders found with the current filters set. <a href="?page=layerslider">Click here</a> to reset filters.', 'LayerSlider') ?></span>
					<?php else : ?>
					<span><?php _e('Add a new slider or import one of our templates to get started using LayerSlider.', 'LayerSlider') ?></span>
					<?php endif ?>
				</div>
			</div>
			<?php endif ?>
		</div>



		<?php if( ! empty($sliders ) ) : ?>
		<div>
			<div class="ls-bulk-actions">
				<select name="action">
					<option value="0"><?php _e('Bulk Actions', 'LayerSlider') ?></option>
					<option value="export"><?php _e('Export selected', 'LayerSlider') ?></option>
					<option value="remove"><?php _e('Remove selected', 'LayerSlider') ?></option>
					<option value="delete"><?php _e('Delete permanently', 'LayerSlider') ?></option>
					<?php if( $showAllSlider ) : ?>
					<option value="restore"><?php _e('Restore selected', 'LayerSlider') ?></option>
					<?php endif; ?>
					<option value="merge"><?php _e('Merge selected as new', 'LayerSlider') ?></option>
				</select>
				<button class="button"><?php _e('Apply', 'LayerSlider') ?></button>
			</div>
			<div class="ls-pagination bottom">
				<div class="tablenav-pages">
					<span class="displaying-num"><?php echo $maxItem ?> <?php _e('items', 'LayerSlider') ?></span>
					<span class="pagination-links">
						<a class="button first-page<?php echo ($curPage <= 1) ? ' disabled' : ''; ?>" title="Go to the first page" href="admin.php?page=layerslider&amp;filter=<?php echo $urlParamFilter ?>&amp;term=<?php echo $urlParamTerm ?>&amp;order=<?php echo $urlParamOrder ?>">«</a>
						<a class="button prev-page <?php echo ($curPage <= 1) ? ' disabled' : ''; ?>" title="Go to the previous page" href="admin.php?page=layerslider&amp;paged=<?php echo ($curPage-1) ?>&amp;filter=<?php echo $urlParamFilter ?>&amp;term=<?php echo $urlParamTerm ?>&amp;order=<?php echo $urlParamOrder ?>">‹</a>

						<span class="total-pages"><?php echo $curPage ?> of <?php echo $maxPage ?></span>

						<a class="button next-page <?php echo ($curPage >= $maxPage) ? ' disabled' : ''; ?>" title="Go to the next page" href="admin.php?page=layerslider&amp;paged=<?php echo ($curPage+1) ?>&amp;filter=<?php echo $urlParamFilter ?>&amp;term=<?php echo $urlParamTerm ?>&amp;order=<?php echo $urlParamOrder ?>">›</a>
						<a class="button last-page <?php echo ($curPage >= $maxPage) ? ' disabled' : ''; ?>" title="Go to the last page" href="admin.php?page=layerslider&amp;paged=<?php echo $maxPage ?>&amp;filter=<?php echo $urlParamFilter ?>&amp;term=<?php echo $urlParamTerm ?>&amp;order=<?php echo $urlParamOrder ?>">»</a>
					</span>
				</div>
			</div>
		</div>
		<?php endif ?>
	</form>



	<div class="columns clearfix">

		<!-- Product Activation -->
		<div class="half">
			<div class="ls-box ls-product-banner ls-auto-update <?php echo  $validity ? 'active' : '' ?>">
				<div class="header medium">
					<h2><?php _e('Product Activation', 'LayerSlider') ?></h2>
					<figure class="status <?php echo $validity ? 'activated' : 'not-activated' ?>">

						<span>
							<i class="dashicons dashicons-warning"></i>
							<?php _e('Not Activated', 'LayerSlider') ?>
						</span>

						<span>
							<i class="dashicons dashicons-yes"></i>
							<?php _e('Activated', 'LayerSlider') ?>
						</span>

					</figure>
				</div>
				<div class="inner guide">
					<p>
						<?php if( ! $validity ) : ?>
						<?php _e('Unlock all these features by activating your site.', 'LayerSlider') ?>
						<a target="_blank" href="https://support.kreaturamedia.com/docs/layersliderwp/documentation.html#activation"><?php _e('Click here to learn more', 'LayerSlider') ?></a>
						<?php else : ?>
						<?php _e('You have successfully activated your site to receive all these features:', 'LayerSlider') ?>
						<?php endif ?>
					</p>
					<ul>
						<li>
							<i class="dashicons dashicons-update"></i>
							<strong><?php _e('Automatic Updates', 'LayerSlider') ?></strong>
							<small><?php _e('Always receive the latest LayerSlider version.', 'LayerSlider') ?></small>
						</li>
						<li>
							<i class="dashicons dashicons-editor-help"></i>
							<strong><?php _e('Product Support', 'LayerSlider') ?></strong>
							<small><?php _e('Direct help from our Support Team.', 'LayerSlider') ?></small>
						</li>
						<li>
							<i class="dashicons dashicons-star-filled"></i>
							<strong><?php _e('Exclusive Features', 'LayerSlider') ?></strong>
							<small><?php _e('Unlock exclusive and early-access features.', 'LayerSlider') ?></small>
						</li>
						<li>
							<i class="dashicons dashicons-store"></i>
							<strong><?php _e('Premium Slider Templates', 'LayerSlider') ?></strong>
							<small><?php _e('Access more templates to get started with projects. ', 'LayerSlider') ?></small>
						</li>
					</ul>

					<button class="button-activation button button-primary button-hero"><?php _e('Activate Now', 'LayerSlider') ?></button>
				</div>
				<form method="post" class="inner">
					<input type="hidden" name="action" value="layerslider_authorize_site">

					<div class="main-controls">
						<span class="enter"><?php _e('Enter your purchase code: ', 'LayerSlider') ?></span>
						<a target="_blank" class="button button-small where-button" href="https://support.kreaturamedia.com/docs/layersliderwp/documentation.html#activation-purchase-code"><?php _e("Where's my purchase code?", "LayerSlider") ?></a>

						<div class="key">
							<input type="text" name="purchase_code" value="<?php echo $codeFormatted ?>" placeholder="e.g. bc8e2b24-3f8c-4b21-8b4b-90d57a38e3c7">
						</div>
						<p>
							<?php if( $GLOBALS['lsAutoUpdateBox'] == false ) {
								_e("It seems you've received LayerSlider by a theme. Please note, the activation only works if you've purchased LayerSlider directly from Kreatura. <a href=\"http://codecanyon.net/cart/add_items?ref=kreatura&amp;item_ids=1362246\" target=\"_blank\">Purchase a license</a> or read our <a href=\"https://support.kreaturamedia.com/docs/layersliderwp/documentation.html#activation\" target=\"_blank\">activation guide</a>.", "LayerSlider");
							} else {
								_e('If you experience any issue or need further information, please read our <a href="https://support.kreaturamedia.com/docs/layersliderwp/documentation.html#activation" target="_blank">activation guide</a>.', 'LayerSlider');
							} ?>
						</p>

						<button class="button button-primary button-hero button-save"><?php _e('Activate Now', 'LayerSlider') ?></button>
						<a target="_blank" class="button button-hero purchase-button" href="http://codecanyon.net/cart/add_items?ref=kreatura&amp;item_ids=1362246"><?php _e('Purchase license', 'LayerSlider') ?></a>
					</div>
					<div class="sub-options">

						<button class="button button-secondary button-save"><?php _e('Update', 'LayerSlider') ?></button>
						<div class="channel">
							<?php _e('Release channel:', 'LayerSlider') ?>
							<label><input type="radio" name="channel" value="stable" <?php echo ($channel === 'stable') ? 'checked="checked"' : ''?>> <?php _e('Stable', 'LayerSlider') ?></label>
							<label data-help="<?php _e('Although pre-release versions meant to work properly, they might contain unknown issues, and are not recommended for sites in production.', 'LayerSlider') ?>">
								<input type="radio" name="channel" value="beta" <?php echo ($channel === 'beta') ? 'checked="checked"' : ''?>> <?php _e('Beta', 'LayerSlider') ?>
							</label>
						</div>

						<p class="note">
							<?php _e('Thank you for purchasing LayerSlider! Your site is activated to receive automatic updates and to access all premium content & features.', 'LayerSlider') ?>
						</p>

						<div class="controls">
							<a href="update-core.php"><?php _e('Check for updates', 'LayerSlider') ?></a>
							<a href="#" class="ls-deauthorize"><?php _e('Deactivate this site', 'LayerSlider') ?></a>
							<!-- <a href="<?php echo LS_REPO_BASE_URL.'download?domain='.base64_encode($_SERVER['SERVER_NAME']).'&channel='.$channel.'&code='.base64_encode($code) ?>" class="dl-link"><?php _e('Download install file', 'LayerSlider') ?></a> -->
							<span></span>
						</div>
					</div>
				</form>
			</div>
		</div>

		<!-- Product Support  -->
		<div class="half">
			<div class="ls-box ls-product-banner ls-product-support">
				<div class="header medium">
					<h2><?php _e('Product Support', 'LayerSlider') ?></h2>
				</div>
				<div class="inner">
					<ul>
						<li>
							<i class="dashicons dashicons-book"></i>
							<strong><?php _e('Read the documentation', 'LayerSlider') ?></strong>
							<small><?php _e('Get started with using LayerSlider.', 'LayerSlider') ?></small>
						</li>
						<li>
							<i class="dashicons dashicons-sos"></i>
							<strong><?php _e('Browse the FAQs', 'LayerSlider') ?></strong>
							<small><?php _e('Find answers for common questions.', 'LayerSlider') ?></small>
						</li>
						<li>
							<i class="dashicons <?php echo $validity ? 'dashicons-groups' : 'dashicons-lock' ?>"></i>
							<strong><?php _e('Direct Support', 'LayerSlider') ?></strong>
							<small><?php _e('Get in touch with our Support Team.', 'LayerSlider') ?></small>

							<?php if( ! $validity ) : ?>
							<a class="unlock button button-small">
								<?php _e('Unlock Now', 'LayerSlider') ?>
							</a>
							<?php endif ?>
						</li>
					</ul>
					<a href="https://support.kreaturamedia.com/faq/4/layerslider-for-wordpress/" target="_blank" class="button"><?php _e('Visit our Support Center') ?></a>
				</div>
			</div>
		</div>
	</div>


	<div class="columns clearfix">

		<!-- Kreatura Newsletter -->
		<div class="half">
			<div class="ls-box ls-product-banner ls-newsletter">
				<div class="header medium">
					<h2><?php _e('Kreatura Newsletter', 'LayerSlider') ?></h2>
				</div>
				<div class="inner">
					<ul>
						<li>
							<i class="dashicons dashicons-megaphone"></i>
							<strong><?php _e('Stay Updated', 'LayerSlider') ?></strong>
							<small><?php _e('News about the latest features and other product info.', 'LayerSlider') ?></small>
						</li>
						<li>
							<i class="dashicons dashicons-heart"></i>
							<strong><?php _e('Sneak Peak on Product Updates', 'LayerSlider') ?></strong>
							<small><?php _e('Access to all the cool new features before anyone else.', 'LayerSlider') ?></small>
						</li>
						<li>
							<i class="dashicons dashicons-smiley"></i>
							<strong><?php _e('Provide Feedback', 'LayerSlider') ?></strong>
							<small><?php _e('Participate in various programs and help us improving LayerSlider.', 'LayerSlider') ?></small>
						</li>
					</ul>
					<form method="post" action="https://kreaturamedia.com/newsletter/" target="_blank">
						<input type="hidden" name="code" value="<?php echo $code ?>">
						<input type="hidden" name="item" value="<?php echo LS_MARKETPLACE_ID ?>">
						<div class="email"><input type="text" name="email" placeholder="<?php _e('Enter your email address', 'LayerSlider') ?>"></div>
						<button class="button"><?php _e('Subscribe', 'LayerSlider') ?></button>
					</form>
				</div>
			</div>
		</div>
	</div>



	<div class="km-tabs ls-plugin-settings-tabs">
		<a href="#" class="active"><?php _e('Permissions', 'LayerSlider') ?></a>
		<a href="#"><?php _e('Google Fonts', 'LayerSlider') ?></a>
		<a href="#"><?php _e('Advanced', 'LayerSlider') ?></a>
		<a href="#"><?php _e('System Status', 'LayerSlider') ?></a>
	</div>
	<div class="km-tabs-content ls-plugin-settings">


		<!-- Permissions -->
		<div class="active">
			<figure><?php _e('Allow non-admin users to change plugin settings and manage your sliders', 'LayerSlider') ?></figure>
			<form method="post" class="ls-box km-tabs-inner" id="ls-permission-form">
				<?php wp_nonce_field('save-access-permissions'); ?>
				<input type="hidden" name="ls-access-permission" value="1">
				<div class="inner">
					<?php _e('Choose a role', 'LayerSlider') ?>
					<select name="custom_role">
						<?php if( is_multisite() ) : ?>
						<option value="manage_network" <?php echo ($custom_role == 'manage_network') ? 'selected="selected"' : '' ?>> <?php _e('Super Admin', 'LayerSlider') ?></option>
						<?php endif; ?>
						<option value="manage_options" <?php echo ($custom_role == 'manage_options') ? 'selected="selected"' : '' ?>> <?php _e('Admin', 'LayerSlider') ?></option>
						<option value="publish_pages" <?php echo ($custom_role == 'publish_pages') ? 'selected="selected"' : '' ?>> <?php _e('Editor, Admin', 'LayerSlider') ?></option>
						<option value="publish_posts" <?php echo ($custom_role == 'publish_posts') ? 'selected="selected"' : '' ?>> <?php _e('Author, Editor, Admin', 'LayerSlider') ?></option>
						<option value="edit_posts" <?php echo ($custom_role == 'edit_posts') ? 'selected="selected"' : '' ?>> <?php _e('Contributor, Author, Editor, Admin', 'LayerSlider') ?></option>
						<option value="custom" <?php echo ($custom_role == 'custom') ? 'selected="selected"' : '' ?>> <?php _e('Custom', 'LayerSlider') ?></option>
					</select>

					<i><?php _e('or', 'LayerSlider') ?></i> <?php _e('enter a custom capability', 'LayerSlider') ?>
					<input type="text" name="custom_capability" value="<?php echo $custom_capability ?>" placeholder="Enter custom capability">

					<p><?php _e('You can specify a custom capability if none of the pre-defined roles match your needs. You can find all the available capabilities on', 'LayerSlider') ?> <a href="http://codex.wordpress.org/Roles_and_Capabilities#Capability_vs._Role_Table" target="_blank"><?php _e('this page', 'LayerSlider') ?></a>.</p>
				</div>
				<div class="footer">
					<button class="button"><?php _e('Update', 'LayerSlider') ?></button>
				</div>
			</form>
		</div>


		<!-- Google Fonts -->
		<div>
			<figure><?php _e('Choose from hundreds of custom fonts faces provided by Google Fonts', 'LayerSlider') ?></figure>
			<form method="post" class="ls-box km-tabs-inner ls-google-fonts">
				<?php wp_nonce_field('save-google-fonts'); ?>
				<input type="hidden" name="ls-save-google-fonts" value="1">

				<!-- Google Fonts list -->
				<div class="inner">
					<ul class="ls-font-list">
						<li class="ls-hidden">
							<a href="#" class="remove dashicons dashicons-dismiss" title="Remove this font"></a>
							<input type="text" data-name="urlParams" readonly>
							<input type="checkbox" data-name="onlyOnAdmin">
							<?php _e('Load only on admin interface', 'LayerSlider') ?>
						</li>
						<?php if(is_array($googleFonts) && !empty($googleFonts)) : ?>
						<?php foreach($googleFonts as $item) : ?>
						<li>
							<a href="#" class="remove dashicons dashicons-dismiss" title="Remove this font"></a>
							<input type="text" data-name="urlParams" value="<?php echo htmlspecialchars($item['param']) ?>" readonly>
							<input type="checkbox" data-name="onlyOnAdmin" <?php echo $item['admin'] ? ' checked="checked"' : '' ?>>
							<?php _e('Load only on admin interface', 'LayerSlider') ?>
						</li>
						<?php endforeach ?>
						<?php else : ?>
						<li class="ls-notice"><?php _e("You haven't added any Google font to your library yet.", "LayerSlider") ?></li>
						<?php endif ?>
					</ul>
				</div>
				<div class="inner ls-font-search">

					<input type="text" placeholder="<?php _e('Enter a font name to add to your collection', 'LayerSlider') ?>">
					<button class="button"><?php _e('Search', 'LayerSlider') ?></button>

					<!-- Google Fonts search pointer -->
					<div class="ls-box ls-pointer">
						<h3 class="header"><?php _e('Choose a font family', 'LayerSlider') ?></h3>
						<div class="fonts">
							<ul class="inner"></ul>
						</div>
						<div class="variants">
							<ul class="inner"></ul>
							<div class="inner">
								<button class="button add-font"><?php _e('Add font', 'LayerSlider') ?></button>
								<button class="button right"><?php _e('Back to results', 'LayerSlider') ?></button>
							</div>
						</div>
					</div>
				</div>

				<!-- Google Fonts search bar -->
				<div class="inner footer">
					<button type="submit" class="button"><?php _e('Save changes', 'LayerSlider') ?></button>
					<?php
						$scripts = array(
							'cyrillic' => __('Cyrillic', 'LayerSlider'),
							'cyrillic-ext' => __('Cyrillic Extended', 'LayerSlider'),
							'devanagari' => __('Devanagari', 'LayerSlider'),
							'greek' => __('Greek', 'LayerSlider'),
							'greek-ext' => __('Greek Extended', 'LayerSlider'),
							'khmer' => __('Khmer', 'LayerSlider'),
							'latin' => __('Latin', 'LayerSlider'),
							'latin-ext' => __('Latin Extended', 'LayerSlider'),
							'vietnamese' => __('Vietnamese', 'LayerSlider')
						);
					?>
					<div class="right">
						<div>
							<select>
								<option><?php _e('Select new', 'LayerSlider') ?></option>
								<?php foreach($scripts as $key => $val) : ?>
								<option value="<?php echo $key ?>"><?php echo $val ?></option>
								<?php endforeach ?>
							</select>
						</div>
						<ul class="ls-google-font-scripts">
							<li class="ls-hidden">
								<span></span>
								<a href="#" class="dashicons dashicons-dismiss" title="<?php _e('Remove character set', 'LayerSlider') ?>"></a>
								<input type="hidden" name="scripts[]" value="">
							</li>
							<?php if(!empty($googleFontScripts) && is_array($googleFontScripts)) : ?>
							<?php foreach($googleFontScripts as $item) : ?>
							<li>
								<span><?php echo $scripts[$item] ?></span>
								<a href="#" class="dashicons dashicons-dismiss" title="<?php _e('Remove character set', 'LayerSlider') ?>"></a>
								<input type="hidden" name="scripts[]" value="<?php echo $item ?>">
							</li>
							<?php endforeach ?>
							<?php else : ?>
							<li>
								<span>Latin</span>
								<a href="#" class="dashicons dashicons-dismiss" title="<?php _e('Remove character set', 'LayerSlider') ?>"></a>
								<input type="hidden" name="scripts[]" value="latin">
							</li>
							<?php endif ?>
						</ul>
						<div><?php _e('Use character sets:', 'LayerSlider') ?></div>
					</div>
				</div>

			</form>
		</div>

		<!-- Advanced -->
		<div class="ls-global-settings">
			<figure>
				<?php _e('Troubleshooting &amp; Advanced Settings', 'LayerSlider') ?>
				<span class="warning"><?php _e("Don't change these options without experience, incorrect settings might break your site.", "LayerSlider") ?></span>
			</figure>
			<form method="post" class="ls-box km-tabs-inner">
				<?php wp_nonce_field('save-advanced-settings'); ?>
				<input type="hidden" name="ls-save-advanced-settings">

				<table>
					<tr class="ls-cache-options">
						<td><?php _e('Use slider markup caching', 'LayerSlider') ?></td>
						<td><input type="checkbox" name="use_cache" <?php echo get_option('ls_use_cache', true) ? 'checked="checked"' : '' ?>></td>
						<td class="desc">
							<?php _e('Enabled caching can drastically increase the plugin performance and spare your server from unnecessary load.', 'LayerSlider') ?>
							<a href="<?php echo wp_nonce_url('?page=layerslider&action=empty_caches', 'empty_caches') ?>" class="button button-small"><?php _e('Empty caches') ?></a>
						</td>
					</tr>
					<tr>
						<td><?php _e("Include scripts in the footer", "LayerSlider") ?></td>
						<td><input type="checkbox" name="include_at_footer" <?php echo get_option('ls_include_at_footer', false) ? 'checked="checked"' : '' ?>></td>
						<td class="desc"><?php _e("Including resources in the footer can improve load times and solve other type of issues. Outdated themes might not support this method.", "LayerSlider") ?></td>
					</tr>
					<tr>
						<td><?php _e("Conditional script loading", "LayerSlider") ?></td>
						<td><input type="checkbox" name="conditional_script_loading" <?php echo get_option('ls_conditional_script_loading', false) ? 'checked="checked"' : '' ?>></td>
						<td class="desc"><?php _e("Increase your site's performance by loading resources only when necessary. Outdated themes might not support this method.", "LayerSlider") ?></td>
					</tr>
					<tr>
						<td><?php _e('Concatenate output', 'LayerSlider') ?></td>
						<td><input type="checkbox" name="concatenate_output" <?php echo get_option('ls_concatenate_output', false) ? 'checked="checked"' : '' ?>></td>
						<td class="desc"><?php _e("Concatenating the plugin's output could solve issues caused by custom filters your theme might use.", "LayerSlider") ?></td>
					</tr>
					<tr>
						<td><?php _e('Use Google CDN version of jQuery', 'LayerSlider') ?></td>
						<td><input type="checkbox" name="use_custom_jquery" <?php echo get_option('ls_use_custom_jquery', false) ? 'checked="checked"' : '' ?>></td>
						<td class="desc"><?php _e('This option will likely solve "Old jQuery" issues, but can easily have other side effects. Use it only when it is necessary.', 'LayerSlider') ?></td>
					</tr>
					<tr>
						<td><?php _e('Put JS includes to body', 'LayerSlider') ?></td>
						<td><input type="checkbox" name="put_js_to_body" <?php echo get_option('ls_put_js_to_body', false) ? 'checked="checked"' : '' ?>></td>
						<td class="desc"><?php _e('This is the most common workaround for jQuery related issues, and is recommended when you experience problems with jQuery.', 'LayerSlider') ?></td>
					</tr>
					<tr>
						<td><?php _e('Scripts priority', 'LayerSlider') ?></td>
						<td><input name="scripts_priority" value="<?php echo get_option('ls_scripts_priority', 3) ?>" placeholder="3"></td>
						<td class="desc"><?php _e('Used to specify the order in which scripts are loaded. Lower numbers correspond with earlier execution.', 'LayerSlider') ?></td>
					</tr>
				</table>
				<div class="footer">
					<button type="submit" class="button"><?php _e('Save changes', 'LayerSlider') ?></button>
				</div>
			</form>
		</div>

		<!-- System Status -->
		<div class="ls-system-status">
			<figure>
				<?php _e('This section is intended to help you identify possible issues and display relevant debug information about your site.', 'LayerSlider') ?>
			</figure>
			<div class="ls-box km-tabs-inner">
				<div class="inner">
					<a class="ls-link" href="<?php echo admin_url('admin.php?page=ls-system-status') ?>">
						<?php _e('Click here to check System Status') ?>
					</a>
					<p class="center">
						<?php _e('System Status is intended to help you identifying possible issues and to display relevant debug information about your site. <br>It also provides tools to list every server settings, easily set up a debug account or to erase all plugin data.', 'LayerSlider') ?>
					</p>
				</div>
			</div>
		</div>
	</div>


	<div class="ls-box ls-news">
		<div class="header medium">
			<h2><?php _e('LayerSlider News', 'LayerSlider') ?></h2>
			<div class="filters">
				<span><?php _e('Filter:', 'LayerSlider') ?></span>
				<ul>
					<li class="active" data-page="all"><?php _e('All', 'LayerSlider') ?></li>
					<li data-page="announcements"><?php _e('Announcements', 'LayerSlider') ?></li>
					<li data-page="changes"><?php _e('Release log', 'LayerSlider') ?></li>
					<li data-page="betas"><?php _e('Beta versions', 'LayerSlider') ?></li>
				</ul>
			</div>
			<div class="ls-version"<?php _e('>You have version', 'LayerSlider') ?> <?php echo LS_PLUGIN_VERSION ?> <?php _e('installed', 'LayerSlider') ?></div>
		</div>
		<div>
			<iframe src="https://news.kreaturamedia.com/layerslider/"></iframe>
		</div>
	</div>
</div>

<!-- Help menu WP Pointer -->
<?php
if(get_user_meta(get_current_user_id(), 'layerslider_help_wp_pointer', true) != '1') {
add_user_meta(get_current_user_id(), 'layerslider_help_wp_pointer', '1'); ?>
<script type="text/javascript">

	// Help
	jQuery(document).ready(function() {
		jQuery('#contextual-help-link-wrap').pointer({
			pointerClass : 'ls-help-pointer',
			pointerWidth : 320,
			content: '<h3><?php _e('The documentation is here', 'LayerSlider') ?></h3><div class="inner"><?php _e('Open this help menu to quickly access to our online documentation.', 'LayerSlider') ?></div>',
			position: {
				edge : 'top',
				align : 'right'
			}
		}).pointer('open');
	});
</script>
<?php } ?>
<script type="text/javascript">
	var lsScreenOptions = <?php echo json_encode($lsScreenOptions) ?>;
</script>
