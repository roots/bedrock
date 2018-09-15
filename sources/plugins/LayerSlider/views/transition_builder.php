<?php

	if(!defined('LS_ROOT_FILE')) {
		header('HTTP/1.0 403 Forbidden');
		exit;
	}

	// Custom transitions file
	$upload_dir = wp_upload_dir();
	$custom_trs = $upload_dir['basedir'] . '/layerslider.custom.transitions.js';
	$sample_trs = LS_ROOT_PATH.'/demos/transitions.js';

	// Get transition file
	if(file_exists($custom_trs)) { $data = file_get_contents($custom_trs); }
		elseif(file_exists($sample_trs)) { $data = file_get_contents($sample_trs); }

	// Get JSON data
	if(!empty($data)) {
		$data = substr($data, 35);
		$data = substr($data, 0, -1);
		$data = json_decode($data, true);
	}

	// Get screen options
	$lsScreenOptions = get_option('ls-screen-options', '0');
	$lsScreenOptions = ($lsScreenOptions == 0) ? array() : $lsScreenOptions;
	$lsScreenOptions = is_array($lsScreenOptions) ? $lsScreenOptions : unserialize($lsScreenOptions);

	// Defaults
	if(!isset($lsScreenOptions['showTooltips'])) {
		$lsScreenOptions['showTooltips'] = 'true';
	}

	// Function to convert array keys to property names
	function lsTrGetProperty($key) {
		switch ($key) {
			case 'scale3d': return 'Scale3D'; break;
			case 'rotateX': return 'RotateX'; break;
			case 'rotateY': return 'RotateY'; break;
			case 'x': return 'MoveX'; break;
			case 'y': return 'MoveY'; break;
			case 'delay': return 'Delay'; break;
			default: return $key; break;
		}
	}
?>

<div id="ls-screen-options" class="metabox-prefs hidden">
	<div id="screen-options-wrap" class="hidden">
		<form id="ls-screen-options-form" method="post">
			<h5><?php _e('Show on screen', 'LayerSlider') ?></h5>
			<label>
				<input type="checkbox" name="showTooltips"<?php echo $lsScreenOptions['showTooltips'] == 'true' ? ' checked="checked"' : ''?>> <?php _e('Tooltips', 'LayerSlider') ?>
			</label>
		</form>
	</div>
	<div id="screen-options-link-wrap" class="hide-if-no-js screen-meta-toggle">
		<button type="button" id="show-settings-link" class="button show-settings" aria-controls="screen-options-wrap" aria-expanded="false"><?php _e('Screen Options', 'LayerSlider') ?></button>
	</div>
</div>


<!-- Import sample markup of transitions -->
<?php include LS_ROOT_PATH . '/templates/tmpl-2d-transition.php'; ?>
<?php include LS_ROOT_PATH . '/templates/tmpl-3d-transition.php'; ?>

<!-- Import Transition Gallery markup -->
<?php include LS_ROOT_PATH . '/templates/tmpl-transition-gallery.php'; ?>

<div class="wrap">

	<!-- Page title -->
	<h2>
		<?php _e('LayerSlider Transition Builder', 'LayerSlider') ?>
		<a href="?page=layerslider" class="add-new-h2"><?php _e('Back to the list', 'LayerSlider') ?></a>
	</h2>

	<?php if(isset($_GET['edited'])) : ?>
	<div class="updated"><?php _e('Your changes has been saved!', 'LayerSlider') ?></div>
	<?php  endif; ?>

	<!-- Editor box -->
	<form method="post" id="ls-tr-builder-form">
		<?php wp_nonce_field('save-user-transitions'); ?>
		<input type="hidden" name="ls-user-transitions" value="1">
		<input type="hidden" name="ls-transitions">


		<div class="ls-slider-settings ls-transition-settings">
			<div class="ls-box ls-settings">
				<div class="inner">
					<div class="ls-settings-sidebar ls-transitions-sidebar">
						<h3 class="subheader">
							<?php _e('2D Transitions', 'LayerSlider') ?>
							<a href="#" class="ls-import-transition">
								<span class="dashicons dashicons-update"></span>
								<?php _e('Import', 'LayerSlider') ?>
							</a>
							<a href="#" class="ls-add-transition">
								<span class="dashicons dashicons-plus"></span>
								<?php _e('Add New', 'LayerSlider') ?>
							</a>
						</h3>
						<ul class="2d" data-type="2d">
							<?php $hidenClass = '' ?>
							<?php if(!empty($data['t2d']) && is_array($data['t2d'])) : ?>
							<?php $hidenClass = 'ls-hidden' ?>
							<?php foreach($data['t2d'] as $tr) : ?>
							<li>
								<span class="dashicons dashicons-menu"></span>
								<input type="text" value="<?php echo htmlspecialchars(html_entity_decode($tr['name'])) ?>" placeholder="<?php _e('Type transition name', 'LayerSlider') ?>">
								<a href="#" title="Remove transition" class="dashicons dashicons-trash remove"></a>
							</li>
							<?php endforeach ?>
							<?php endif ?>
						</ul>
						<p class="ls-no-transition <?php echo $hidenClass ?>"><?php _e('No 2D transitions yet.', 'LayerSlider') ?></p>
						<h3 class="subheader">
							<?php _e('3D Transitions', 'LayerSlider') ?>
							<a href="#" class="ls-import-transition">
								<span class="dashicons dashicons-update"></span>
								<?php _e('Import', 'LayerSlider') ?>
							</a>
							<a href="#" class="ls-add-transition">
								<span class="dashicons dashicons-plus"></span>
								<?php _e('Add New', 'LayerSlider') ?>
							</a>
						</h3>
						<ul class="3d" data-type="3d">
							<?php $hidenClass = '' ?>
							<?php if(!empty($data['t3d']) && is_array($data['t3d'])) : ?>
							<?php $hidenClass = 'ls-hidden' ?>
							<?php foreach($data['t3d'] as $tr) : ?>
							<li>
								<span class="dashicons dashicons-menu"></span>
								<input type="text" value="<?php echo htmlspecialchars(html_entity_decode($tr['name'])) ?>" placeholder="<?php _e('Type transition name', 'LayerSlider') ?>">
								<a href="#" title="Remove transition" class="dashicons dashicons-trash remove"></a>
							</li>
							<?php endforeach ?>
							<?php endif ?>
						</ul>
						<p class="ls-no-transition <?php echo $hidenClass ?>"><?php _e('No 3D transitions yet.', 'LayerSlider') ?></p>
					</div>
					<div class="ls-settings-contents ls-transition-contents">
						<div class="ls-box ls-tr-builder">

							<div class="ls-tr-options clearfix">
								<div class="ls-builder-left ls-tr-list-3d">
									<?php if(!empty($data['t3d']) && is_array($data['t3d'])) : ?>
									<?php foreach($data['t3d'] as $key => $tr) : ?>
									<?php $activeClass = ($key == 0) ? ' active' : '' ?>
									<div class="ls-transition-item<?php echo $activeClass ?>">
										<table class="ls-box ls-tr-settings">
											<thead>
												<tr>
													<td colspan="2"><?php _e('Preview', 'LayerSlider') ?></td>
													<td colspan="2"><?php _e('Tiles', 'LayerSlider') ?></td>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td colspan="2">
														<div class="ls-builder-preview ls-transition-preview">
															<img src="<?php echo LS_ROOT_URL ?>/static/admin/img/sample_slide_1.png" alt="preview image">
														</div>
													</td>
													<td colspan="2">
														<table class="tiles">
															<tbody>
																<tr>
																	<?php $tr['rows'] = is_array($tr['rows']) ? implode(',', $tr['rows']) : $tr['rows']; ?>
																	<?php $tr['cols'] = is_array($tr['cols']) ? implode(',', $tr['cols']) : $tr['cols']; ?>
																	<td class="right"><?php _e('Rows', 'LayerSlider') ?></td>
																	<td><input type="text" name="rows" value="<?php echo $tr['rows'] ?>" data-help="<?php _e('<i>number</i> or <i>min,max</i> If you specify a value greater than 1, LayerSlider will cut your slide into tiles. You can specify here how many rows of your transition should have. If you specify two numbers separated with a comma, LayerSlider will use that as a range and pick a random number between your values.', 'LayerSlider') ?>"></td>
																	<td class="right"><?php _e('Cols', 'LayerSlider') ?></td>
																	<td><input type="text" name="cols" value="<?php echo $tr['cols'] ?>" data-help="<?php _e('<i>number</i> or <i>min,max</i> If you specify a value greater than 1, LayerSlider will cut your slide into tiles. You can specify here how many columns of your transition should have. If you specify two numbers separated with a comma, LayerSlider will use that as a range and pick a random number between your values.', 'LayerSlider') ?>"></td>
																</tr>
															</tbody>
															<tbody class="tile">
																<tr>
																	<td class="right"><?php _e('Delay', 'LayerSlider') ?></td>
																	<td><input type="text" name="delay" value="<?php echo $tr['tile']['delay'] ?>" data-help="<?php _e('You can apply a delay between the tiles and postpone their animation relative to each other.', 'LayerSlider') ?>"></td>
																	<td class="right"><?php _e('Sequence', 'LayerSlider') ?></td>
																	<td>
																		<select name="sequence" data-help="<?php _e('You can control the animation order of the tiles here.', 'LayerSlider') ?>">
																			<option value="forward"<?php echo ($tr['tile']['sequence'] == 'forward') ? ' selected="selected"' : '' ?>><?php _e('Forward', 'LayerSlider') ?></option>
																			<option value="reverse"<?php echo ($tr['tile']['sequence'] == 'reverse') ? ' selected="selected"' : '' ?>><?php _e('Reverse', 'LayerSlider') ?></option>
																			<option value="col-forward"<?php echo ($tr['tile']['sequence'] == 'col-forward') ? ' selected="selected"' : '' ?>><?php _e('Col-forward', 'LayerSlider') ?></option>
																			<option value="col-reverse"<?php echo ($tr['tile']['sequence'] == 'col-reverse') ? ' selected="selected"' : '' ?>><?php _e('Col-reverse', 'LayerSlider') ?></option>
																			<option value="random"<?php echo ($tr['tile']['sequence'] == 'random') ? ' selected="selected"' : '' ?>><?php _e('Random', 'LayerSlider') ?></option>
																		</select>
																	</td>
																</tr>
																<tr>
																	<td class="right"><?php _e('Depth', 'LayerSlider') ?></td>
																	<td colspan="3">
																		<label data-help="<?php _e('The script tries to identify the optimal depth for your rotated objects (tiles). With this option you can force your objects to have a large depth when performing 180 degree (and its multiplies) rotation.', 'LayerSlider') ?>">
																			<input type="checkbox" class="checkbox" name="depth" value="large"<?php echo isset($tr['tile']['depth']) ? ' checked="checked"' : '' ?>>
																			<?php _e('Large depth', 'LayerSlider') ?>
																		</label>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
											<?php
												$checkboxProp = isset($tr['before']) ? ' checked="checked"' : '';
												$collapseClass = !isset($tr['before']) ? ' ls-builder-collapsed' : '';
											?>
											<thead>
												<tr>
													<td colspan="4">
														<?php _e('Before animation', 'LayerSlider') ?>
														<p class="ls-builder-checkbox">
															<label><input type="checkbox"<?php echo $checkboxProp ?> class="ls-builder-collapse-toggle"> <?php _e('Enabled', 'LayerSlider') ?></label>
														</p>
													</td>
												</tr>
											</thead>
											<tbody class="before<?php echo $collapseClass ?>">
												<tr>
													<td class="right"><?php _e('Duration', 'LayerSlider') ?></td>
													<td><input type="text" name="duration" value="<?php echo isset($tr['before']['duration']) ? $tr['before']['duration'] : '1000' ?>" data-help="<?php _e('The duration of your animation. This value is in millisecs, so the value 1000 means 1 second.', 'LayerSlider') ?>"></td>
													<td class="right"><a href="http://easings.net/" target="_blank"><?php _e('Easing', 'LayerSlider') ?></a></td>
													<td>
														<?php $tr['before']['easing'] = isset($tr['before']['easing']) ? $tr['before']['easing'] : 'easeInOutBack' ?>
														<select name="easing" data-help="<?php _e('The timing function of the animation. With this function you can manipulate the movement of the animated object. Please click on the link next to this select field to open easings.net for more information and real-time examples.', 'LayerSlider') ?>">
															<option<?php echo ($tr['before']['easing'] == 'linear') ? ' selected="selected"' : '' ?>>linear</option>
															<option<?php echo ($tr['before']['easing'] == 'easeInQuad') ? ' selected="selected"' : '' ?>>easeInQuad</option>
															<option<?php echo ($tr['before']['easing'] == 'easeOutQuad') ? ' selected="selected"' : '' ?>>easeOutQuad</option>
															<option<?php echo ($tr['before']['easing'] == 'easeInOutQuad') ? ' selected="selected"' : '' ?>>easeInOutQuad</option>
															<option<?php echo ($tr['before']['easing'] == 'easeInCubic') ? ' selected="selected"' : '' ?>>easeInCubic</option>
															<option<?php echo ($tr['before']['easing'] == 'easeOutCubic') ? ' selected="selected"' : '' ?>>easeOutCubic</option>
															<option<?php echo ($tr['before']['easing'] == 'easeInOutCubic') ? ' selected="selected"' : '' ?>>easeInOutCubic</option>
															<option<?php echo ($tr['before']['easing'] == 'easeInQuart') ? ' selected="selected"' : '' ?>>easeInQuart</option>
															<option<?php echo ($tr['before']['easing'] == 'easeOutQuart') ? ' selected="selected"' : '' ?>>easeOutQuart</option>
															<option<?php echo ($tr['before']['easing'] == 'easeInOutQuart') ? ' selected="selected"' : '' ?>>easeInOutQuart</option>
															<option<?php echo ($tr['before']['easing'] == 'easeInQuint') ? ' selected="selected"' : '' ?>>easeInQuint</option>
															<option<?php echo ($tr['before']['easing'] == 'easeOutQuint') ? ' selected="selected"' : '' ?>>easeOutQuint</option>
															<option<?php echo ($tr['before']['easing'] == 'easeInOutQuint') ? ' selected="selected"' : '' ?>>easeInOutQuint</option>
															<option<?php echo ($tr['before']['easing'] == 'easeInSine') ? ' selected="selected"' : '' ?>>easeInSine</option>
															<option<?php echo ($tr['before']['easing'] == 'easeOutSine') ? ' selected="selected"' : '' ?>>easeOutSine</option>
															<option<?php echo ($tr['before']['easing'] == 'easeInOutSine') ? ' selected="selected"' : '' ?>>easeInOutSine</option>
															<option<?php echo ($tr['before']['easing'] == 'easeInExpo') ? ' selected="selected"' : '' ?>>easeInExpo</option>
															<option<?php echo ($tr['before']['easing'] == 'easeOutExpo') ? ' selected="selected"' : '' ?>>easeOutExpo</option>
															<option<?php echo ($tr['before']['easing'] == 'easeInOutExpo') ? ' selected="selected"' : '' ?>>easeInOutExpo</option>
															<option<?php echo ($tr['before']['easing'] == 'easeInCirc') ? ' selected="selected"' : '' ?>>easeInCirc</option>
															<option<?php echo ($tr['before']['easing'] == 'easeOutCirc') ? ' selected="selected"' : '' ?>>easeOutCirc</option>
															<option<?php echo ($tr['before']['easing'] == 'easeInOutCirc') ? ' selected="selected"' : '' ?>>easeInOutCirc</option>
															<option<?php echo ($tr['before']['easing'] == 'easeInBack') ? ' selected="selected"' : '' ?>>easeInBack</option>
															<option<?php echo ($tr['before']['easing'] == 'easeOutBack') ? ' selected="selected"' : '' ?>>easeOutBack</option>
															<option<?php echo ($tr['before']['easing'] == 'easeInOutBack') ? ' selected="selected"' : '' ?>>easeInOutBack</option>
														</select>
													</td>
												</tr>
												<tr class="transition">
													<td colspan="4">
														<ul class="ls-tr-tags">
															<?php if(isset($tr['before']['transition']) && !empty($tr['before']['transition'])) : ?>
															<?php foreach($tr['before']['transition'] as $pkey => $prop) : ?>
															<li>
																<p>
																	<span><?php echo lsTrGetProperty($pkey) ?></span>
																	<input type="text" name="<?php echo $pkey ?>" value="<?php echo $prop ?>">
																</p>
																<a href="#" class="dashicons dashicons-dismiss"></a>
															</li>
															<?php endforeach; ?>
															<?php endif; ?>
														</ul>
														<p class="ls-tr-add-property">
															<a href="#" class="ls-icon-tr-add"><i class="dashicons dashicons-plus"></i><?php _e('Add new', 'LayerSlider') ?></a>
															<select>
																<option value="scale3d,0.8"><?php _e('Scale3D', 'LayerSlider') ?></option>
																<option value="rotateX,90"><?php _e('RotateX', 'LayerSlider') ?></option>
																<option value="rotateY,90"><?php _e('RotateY', 'LayerSlider') ?></option>
																<option value="delay,200"><?php _e('Delay', 'LayerSlider') ?></option>
															</select>
														</p>
													</td>
												</tr>
											</tbody>
											<thead>
												<tr>
													<td colspan="4">
														<?php _e('Animation', 'LayerSlider') ?>
													</td>
												</tr>
											</thead>
											<tbody class="animation">
												<tr>
													<td class="right"><?php _e('Duration', 'LayerSlider') ?></td>
													<td><input type="text" name="duration" value="<?php echo $tr['animation']['duration'] ?>" data-help="<?php _e('The duration of your animation. This value is in millisecs, so the value 1000 means 1 second.', 'LayerSlider') ?>"></td>
													<td class="right"><a href="http://easings.net/" target="_blank"><?php _e('Easing', 'LayerSlider') ?></a></td>
													<td>
														<select name="easing" data-help="<?php _e('The timing function of the animation. With this function you can manipulate the movement of the animated object. Please click on the link next to this select field to open easings.net for more information and real-time examples.', 'LayerSlider') ?>">
															<option<?php echo ($tr['animation']['easing'] == 'linear') ? ' selected="selected"' : '' ?>>linear</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeInQuad') ? ' selected="selected"' : '' ?>>easeInQuad</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeOutQuad') ? ' selected="selected"' : '' ?>>easeOutQuad</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeInOutQuad') ? ' selected="selected"' : '' ?>>easeInOutQuad</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeInCubic') ? ' selected="selected"' : '' ?>>easeInCubic</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeOutCubic') ? ' selected="selected"' : '' ?>>easeOutCubic</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeInOutCubic') ? ' selected="selected"' : '' ?>>easeInOutCubic</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeInQuart') ? ' selected="selected"' : '' ?>>easeInQuart</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeOutQuart') ? ' selected="selected"' : '' ?>>easeOutQuart</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeInOutQuart') ? ' selected="selected"' : '' ?>>easeInOutQuart</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeInQuint') ? ' selected="selected"' : '' ?>>easeInQuint</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeOutQuint') ? ' selected="selected"' : '' ?>>easeOutQuint</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeInOutQuint') ? ' selected="selected"' : '' ?>>easeInOutQuint</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeInSine') ? ' selected="selected"' : '' ?>>easeInSine</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeOutSine') ? ' selected="selected"' : '' ?>>easeOutSine</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeInOutSine') ? ' selected="selected"' : '' ?>>easeInOutSine</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeInExpo') ? ' selected="selected"' : '' ?>>easeInExpo</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeOutExpo') ? ' selected="selected"' : '' ?>>easeOutExpo</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeInOutExpo') ? ' selected="selected"' : '' ?>>easeInOutExpo</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeInCirc') ? ' selected="selected"' : '' ?>>easeInCirc</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeOutCirc') ? ' selected="selected"' : '' ?>>easeOutCirc</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeInOutCirc') ? ' selected="selected"' : '' ?>>easeInOutCirc</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeInBack') ? ' selected="selected"' : '' ?>>easeInBack</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeOutBack') ? ' selected="selected"' : '' ?>>easeOutBack</option>
															<option<?php echo ($tr['animation']['easing'] == 'easeInOutBack') ? ' selected="selected"' : '' ?>>easeInOutBack</option>
														</select>
													</td>
												</tr>
												<tr>
													<td></td>
													<td></td>
													<td class="right"><?php _e('Direction', 'LayerSlider') ?></td>
													<td>
														<select name="direction" data-help="<?php _e('The direction of rotation.', 'LayerSlider') ?>">
															<option value="vertical"<?php echo ($tr['animation']['direction'] == 'vertical') ? ' selected="selected"' : '' ?>><?php _e('Vertical', 'LayerSlider'); ?></option>
															<option value="horizontal"<?php echo ($tr['animation']['direction'] == 'horizontal') ? ' selected="selected"' : '' ?>><?php _e('Horizontal', 'LayerSlider') ?></option>
														</select>
													</td>
												</tr>
												<tr class="transition">
													<td colspan="4">

														<ul class="ls-tr-tags">
															<?php if(isset($tr['animation']['transition']) && !empty($tr['animation']['transition'])) : ?>
															<?php foreach($tr['animation']['transition'] as $pkey => $prop) : ?>
															<li>
																<p>
																	<span><?php echo lsTrGetProperty($pkey) ?></span>
																	<input type="text" name="<?php echo $pkey ?>" value="<?php echo $prop ?>">
																</p>
																<a href="#" class="dashicons dashicons-dismiss"></a>
															</li>
															<?php endforeach; ?>
															<?php endif; ?>
														</ul>
														<p class="ls-tr-add-property">
															<a href="#" class="ls-icon-tr-add"><i class="dashicons dashicons-plus"></i><?php _e('Add new', 'LayerSlider') ?></a>
															<select>
																<option value="scale3d,0.8"><?php _e('Scale3D', 'LayerSlider') ?></option>
																<option value="rotateX,90"><?php _e('RotateX', 'LayerSlider') ?></option>
																<option value="rotateY,90"><?php _e('RotateY', 'LayerSlider') ?></option>
																<option value="delay,200"><?php _e('Delay', 'LayerSlider') ?></option>
															</select>
														</p>
													</td>
												</tr>
											</tbody>
											<?php
												$checkboxProp = isset($tr['after']) ? ' checked="checked"' : '';
												$collapseClass = !isset($tr['after']) ? ' ls-builder-collapsed' : '';
											?>
											<thead>
												<tr>
													<td colspan="4">
														<?php _e('After animation', 'LayerSlider') ?>
														<p class="ls-builder-checkbox">
															<label><input type="checkbox"<?php echo $checkboxProp ?> class="ls-builder-collapse-toggle"> <?php _e('Enabled', 'LayerSlider') ?></label>
														</p>
													</td>
												</tr>
											</thead>
											<tbody class="after<?php echo $collapseClass ?>">
												<tr>
													<td class="right"><?php _e('Duration', 'LayerSlider') ?></td>
													<td><input type="text" name="duration" value="<?php echo isset($tr['after']['duration']) ? $tr['after']['duration'] : '1000' ?>" data-help="<?php _e('The duration of your animation. This value is in millisecs, so the value 1000 means 1 second.', 'LayerSlider') ?>"></td>
													<td class="right"><a href="http://easings.net/" target="_blank"><?php _e('Easing', 'LayerSlider') ?></a></td>
													<td>
														<?php $tr['after']['easing'] = isset($tr['after']['easing']) ? $tr['after']['easing'] : 'easeInOutBack' ?>
														<select name="easing" data-help="<?php _e('The timing function of the animation. With this function you can manipulate the movement of the animated object. Please click on the link next to this select field to open easings.net for more information and real-time examples.', 'LayerSlider') ?>">
															<option<?php echo ($tr['after']['easing'] == 'linear') ? ' selected="selected"' : '' ?>>linear</option>
															<option<?php echo ($tr['after']['easing'] == 'easeInQuad') ? ' selected="selected"' : '' ?>>easeInQuad</option>
															<option<?php echo ($tr['after']['easing'] == 'easeOutQuad') ? ' selected="selected"' : '' ?>>easeOutQuad</option>
															<option<?php echo ($tr['after']['easing'] == 'easeInOutQuad') ? ' selected="selected"' : '' ?>>easeInOutQuad</option>
															<option<?php echo ($tr['after']['easing'] == 'easeInCubic') ? ' selected="selected"' : '' ?>>easeInCubic</option>
															<option<?php echo ($tr['after']['easing'] == 'easeOutCubic') ? ' selected="selected"' : '' ?>>easeOutCubic</option>
															<option<?php echo ($tr['after']['easing'] == 'easeInOutCubic') ? ' selected="selected"' : '' ?>>easeInOutCubic</option>
															<option<?php echo ($tr['after']['easing'] == 'easeInQuart') ? ' selected="selected"' : '' ?>>easeInQuart</option>
															<option<?php echo ($tr['after']['easing'] == 'easeOutQuart') ? ' selected="selected"' : '' ?>>easeOutQuart</option>
															<option<?php echo ($tr['after']['easing'] == 'easeInOutQuart') ? ' selected="selected"' : '' ?>>easeInOutQuart</option>
															<option<?php echo ($tr['after']['easing'] == 'easeInQuint') ? ' selected="selected"' : '' ?>>easeInQuint</option>
															<option<?php echo ($tr['after']['easing'] == 'easeOutQuint') ? ' selected="selected"' : '' ?>>easeOutQuint</option>
															<option<?php echo ($tr['after']['easing'] == 'easeInOutQuint') ? ' selected="selected"' : '' ?>>easeInOutQuint</option>
															<option<?php echo ($tr['after']['easing'] == 'easeInSine') ? ' selected="selected"' : '' ?>>easeInSine</option>
															<option<?php echo ($tr['after']['easing'] == 'easeOutSine') ? ' selected="selected"' : '' ?>>easeOutSine</option>
															<option<?php echo ($tr['after']['easing'] == 'easeInOutSine') ? ' selected="selected"' : '' ?>>easeInOutSine</option>
															<option<?php echo ($tr['after']['easing'] == 'easeInExpo') ? ' selected="selected"' : '' ?>>easeInExpo</option>
															<option<?php echo ($tr['after']['easing'] == 'easeOutExpo') ? ' selected="selected"' : '' ?>>easeOutExpo</option>
															<option<?php echo ($tr['after']['easing'] == 'easeInOutExpo') ? ' selected="selected"' : '' ?>>easeInOutExpo</option>
															<option<?php echo ($tr['after']['easing'] == 'easeInCirc') ? ' selected="selected"' : '' ?>>easeInCirc</option>
															<option<?php echo ($tr['after']['easing'] == 'easeOutCirc') ? ' selected="selected"' : '' ?>>easeOutCirc</option>
															<option<?php echo ($tr['after']['easing'] == 'easeInOutCirc') ? ' selected="selected"' : '' ?>>easeInOutCirc</option>
															<option<?php echo ($tr['after']['easing'] == 'easeInBack') ? ' selected="selected"' : '' ?>>easeInBack</option>
															<option<?php echo ($tr['after']['easing'] == 'easeOutBack') ? ' selected="selected"' : '' ?>>easeOutBack</option>
															<option<?php echo ($tr['after']['easing'] == 'easeInOutBack') ? ' selected="selected"' : '' ?>>easeInOutBack</option>
														</select>
													</td>
												</tr>
												<tr class="transition">
													<td colspan="4">
														<ul class="ls-tr-tags">
															<?php if(isset($tr['after']['transition']) && !empty($tr['after']['transition'])) : ?>
															<?php foreach($tr['after']['transition'] as $pkey => $prop) : ?>
															<li>
																<p>
																	<span><?php echo lsTrGetProperty($pkey) ?></span>
																	<input type="text" name="<?php echo $pkey ?>" value="<?php echo $prop ?>">
																</p>
																<a href="#" class="dashicons dashicons-dismiss"></a>
															</li>
															<?php endforeach; ?>
															<?php endif; ?>
														</ul>
														<p class="ls-tr-add-property">
															<a href="#" class="ls-icon-tr-add"><i class="dashicons dashicons-plus"></i><?php _e('Add new', 'LayerSlider') ?></a>
															<select>
																<option value="scale3d,0.8"><?php _e('Scale3D', 'LayerSlider') ?></option>
																<option value="rotateX,90"><?php _e('RotateX', 'LayerSlider') ?></option>
																<option value="rotateY,90"><?php _e('RotateY', 'LayerSlider') ?></option>
																<option value="delay,200"><?php _e('Delay', 'LayerSlider') ?></option>
															</select>
														</p>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<?php endforeach; ?>
									<?php endif; ?>
								</div>
								<div class="ls-builder-right ls-tr-list-2d">

									<?php if(!empty($data['t2d']) && is_array($data['t2d'])) : ?>
									<?php foreach($data['t2d'] as $key => $tr) : ?>
									<?php $activeClass = ($key == 0) ? ' active' : '' ?>
									<div class="ls-transition-item<?php echo $activeClass ?>">
										<table class="ls-box ls-tr-settings bottomborder">
											<thead>
												<tr>
													<td colspan="2"><?php _e('Preview', 'LayerSlider') ?></td>
													<td colspan="2"><?php _e('Tiles', 'LayerSlider') ?></td>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td colspan="2">
														<div class="ls-builder-preview ls-transition-preview">
															<img src="<?php echo LS_ROOT_URL ?>/static/admin/img/sample_slide_1.png" alt="preview image">
														</div>
													</td>
													<td colspan="2">
														<table class="tiles">
															<tbody>
																<tr>
																	<?php $tr['rows'] = is_array($tr['rows']) ? implode(',', $tr['rows']) : $tr['rows']; ?>
																	<?php $tr['cols'] = is_array($tr['cols']) ? implode(',', $tr['cols']) : $tr['cols']; ?>
																	<td class="right"><?php _e('Rows', 'LayerSlider') ?></td>
																	<td><input type="text" name="rows" value="<?php echo $tr['rows'] ?>" data-help="<?php _e('<i>number</i> or <i>min,max</i> If you specify a value greater than 1, LayerSlider will cut your slide into tiles. You can specify here how many rows of your transition should have. If you specify two numbers separated with a comma, LayerSlider will use that as a range and pick a random number between your values.', 'LayerSlider') ?>"></td>
																	<td class="right"><?php _e('Cols', 'LayerSlider') ?></td>
																	<td><input type="text" name="cols" value="<?php echo $tr['cols'] ?>" data-help="<?php _e('<i>number</i> or <i>min,max</i> If you specify a value greater than 1, LayerSlider will cut your slide into tiles. You can specify here how many columns of your transition should have. If you specify two numbers separated with a comma, LayerSlider will use that as a range and pick a random number between your values.', 'LayerSlider') ?>"></td>
																</tr>
															</tbody>
															<tbody class="tile">
																<tr>
																	<td class="right"><?php _e('Delay', 'LayerSlider') ?></td>
																	<td><input type="text" name="delay" value="<?php echo $tr['tile']['delay'] ?>" data-help="<?php _e('You can apply a delay between the tiles and postpone their animation relative to each other.', 'LayerSlider') ?>"></td>
																	<td class="right"><?php _e('Sequence', 'LayerSlider') ?></td>
																	<td>
																		<select name="sequence" data-help="<?php _e('You can control the animation order of the tiles here.', 'LayerSlider') ?>">
																			<option value="forward"<?php echo ($tr['tile']['sequence'] == 'forward') ? ' selected="selected"' : '' ?>><?php _e('Forward', 'LayerSlider') ?></option>
																			<option value="reverse"<?php echo ($tr['tile']['sequence'] == 'reverse') ? ' selected="selected"' : '' ?>><?php _e('Reverse', 'LayerSlider') ?></option>
																			<option value="col-forward"<?php echo ($tr['tile']['sequence'] == 'col-forward') ? ' selected="selected"' : '' ?>><?php _e('Col-forward', 'LayerSlider') ?></option>
																			<option value="col-reverse"<?php echo ($tr['tile']['sequence'] == 'col-reverse') ? ' selected="selected"' : '' ?>><?php _e('Col-reverse', 'LayerSlider') ?></option>
																			<option value="random"<?php echo ($tr['tile']['sequence'] == 'random') ? ' selected="selected"' : '' ?>><?php _e('Random', 'LayerSlider') ?></option>
																		</select>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
											<thead>
												<tr>
													<td colspan="4"><?php _e('Transition', 'LayerSlider') ?></td>
												</tr>
											</thead>
											<tbody class="transition">
												<tr>
													<td class="right"><?php _e('Duration', 'LayerSlider') ?></td>
													<td><input type="text" name="duration" value="<?php echo $tr['transition']['duration'] ?>" data-help="<?php _e('The duration of the animation. This value is in millisecs, so the value 1000 measn 1 second.', 'LayerSlider') ?>"></td>
													<td class="right"><a href="http://easings.net/" target="_blank"><?php _e('Easing', 'LayerSlider') ?></a></td>
													<td>
														<select name="easing" data-help="<?php _e('The timing function of the animation. With this function you can manipulate the movement of the animated object. Please click on the link next to this select field to open easings.net for more information and real-time examples.', 'LayerSlider') ?>">
															<option<?php echo ($tr['transition']['easing'] == 'linear') ? ' selected="selected"' : '' ?>>linear</option>
															<option<?php echo ($tr['transition']['easing'] == 'swing') ? ' selected="selected"' : '' ?>>swing</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInQuad') ? ' selected="selected"' : '' ?>>easeInQuad</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeOutQuad') ? ' selected="selected"' : '' ?>>easeOutQuad</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInOutQuad') ? ' selected="selected"' : '' ?>>easeInOutQuad</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInCubic') ? ' selected="selected"' : '' ?>>easeInCubic</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeOutCubic') ? ' selected="selected"' : '' ?>>easeOutCubic</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInOutCubic') ? ' selected="selected"' : '' ?>>easeInOutCubic</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInQuart') ? ' selected="selected"' : '' ?>>easeInQuart</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeOutQuart') ? ' selected="selected"' : '' ?>>easeOutQuart</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInOutQuart') ? ' selected="selected"' : '' ?>>easeInOutQuart</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInQuint') ? ' selected="selected"' : '' ?>>easeInQuint</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeOutQuint') ? ' selected="selected"' : '' ?>>easeOutQuint</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInOutQuint') ? ' selected="selected"' : '' ?>>easeInOutQuint</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInSine') ? ' selected="selected"' : '' ?>>easeInSine</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeOutSine') ? ' selected="selected"' : '' ?>>easeOutSine</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInOutSine') ? ' selected="selected"' : '' ?>>easeInOutSine</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInExpo') ? ' selected="selected"' : '' ?>>easeInExpo</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeOutExpo') ? ' selected="selected"' : '' ?>>easeOutExpo</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInOutExpo') ? ' selected="selected"' : '' ?>>easeInOutExpo</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInCirc') ? ' selected="selected"' : '' ?>>easeInCirc</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeOutCirc') ? ' selected="selected"' : '' ?>>easeOutCirc</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInOutCirc') ? ' selected="selected"' : '' ?>>easeInOutCirc</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInElastic') ? ' selected="selected"' : '' ?>>easeInElastic</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeOutElastic') ? ' selected="selected"' : '' ?>>easeOutElastic</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInOutElastic') ? ' selected="selected"' : '' ?>>easeInOutElastic</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInBack') ? ' selected="selected"' : '' ?>>easeInBack</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeOutBack') ? ' selected="selected"' : '' ?>>easeOutBack</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInOutBack') ? ' selected="selected"' : '' ?>>easeInOutBack</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInBounce') ? ' selected="selected"' : '' ?>>easeInBounce</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeOutBounce') ? ' selected="selected"' : '' ?>>easeOutBounce</option>
															<option<?php echo ($tr['transition']['easing'] == 'easeInOutBounce') ? 'selected="selected"' : '' ?>>easeInOutBounce</option>
														</select>
													</td>
												</tr>
												<tr>
													<td class="right"><?php _e('Type', 'LayerSlider') ?></td>
													<td>
														<select name="type" data-help="<?php _e('The type of the animation, either slide, fade or both (mixed).', 'LayerSlider') ?>">
															<option value="slide"<?php echo ($tr['transition']['type'] == 'slide') ? ' selected="selected"' : '' ?>><?php _e('Slide', 'LayerSlider') ?></option>
															<option value="fade"<?php echo ($tr['transition']['type'] == 'fade') ? ' selected="selected"' : '' ?>><?php _e('Fade', 'LayerSlider') ?></option>
															<option value="mixed"<?php echo ($tr['transition']['type'] == 'mixed') ? ' selected="selected"' : '' ?>><?php _e('Mixed', 'LayerSlider') ?></option>
														</select>
													</td>
													<td class="right"><?php _e('Direction', 'LayerSlider') ?></td>
													<td>
														<select name="direction" data-help="<?php _e('The direction of the slide or mixed animation if you\'ve chosen this type in the previous settings.', 'LayerSlider') ?>">
															<option value="top"<?php echo ($tr['transition']['direction'] == 'top') ? ' selected="selected"' : '' ?>><?php _e('Top', 'LayerSlider') ?></option>
															<option value="right"<?php echo ($tr['transition']['direction'] == 'right') ? ' selected="selected"' : '' ?>><?php _e('Right', 'LayerSlider') ?></option>
															<option value="bottom"<?php echo ($tr['transition']['direction'] == 'bottom') ? ' selected="selected"' : '' ?>><?php _e('Bottom', 'LayerSlider') ?></option>
															<option value="left"<?php echo ($tr['transition']['direction'] == 'left') ? ' selected="selected"' : '' ?>><?php _e('Left', 'LayerSlider') ?></option>
															<option value="random"<?php echo ($tr['transition']['direction'] == 'random') ? ' selected="selected"' : '' ?>><?php _e('Random', 'LayerSlider') ?></option>
															<option value="topleft"<?php echo ($tr['transition']['direction'] == 'topleft') ? ' selected="selected"' : '' ?>><?php _e('Top left', 'LayerSlider') ?></option>
															<option value="topright"<?php echo ($tr['transition']['direction'] == 'topright') ? ' selected="selected"' : '' ?>><?php _e('Top right', 'LayerSlider') ?></option>
															<option value="bottomleft"<?php echo ($tr['transition']['direction'] == 'bottomleft') ? ' selected="selected"' : '' ?>><?php _e('Bottom left', 'LayerSlider') ?></option>
															<option value="bottomright"<?php echo ($tr['transition']['direction'] == 'bottomright') ? ' selected="selected"' : '' ?>><?php _e('Bottom right', 'LayerSlider') ?></option>
														</select>
													</td>
												</tr>
												<tr>
													<td class="right"><?php _e('RotateX', 'LayerSlider') ?></td>
													<td><input type="text" name="rotateX" value="<?php echo !empty($tr['transition']['rotateX']) ? $tr['transition']['rotateX'] : '0' ?>" data-help="The initial rotation of the individual tiles which will be animated to the default (0deg) value around the X axis. You can use negatuve values."></td>
													<td class="right"><?php _e('RotateY', 'LayerSlider') ?></td>
													<td><input type="text" name="rotateY" value="<?php echo !empty($tr['transition']['rotateY']) ? $tr['transition']['rotateY'] : '0' ?>" data-help="The initial rotation of the individual tiles which will be animated to the default (0deg) value around the Y axis. You can use negatuve values."></td>
												</tr>
												<tr>
													<td class="right"><?php _e('RotateZ', 'LayerSlider') ?></td>
													<td><input type="text" name="rotate" value="<?php echo !empty($tr['transition']['rotate']) ? $tr['transition']['rotate'] : '0' ?>" data-help="The initial rotation of the individual tiles which will be animated to the default (0deg) value around the Z axis. You can use negatuve values."></td>
													<td class="right"><?php _e('Scale', 'LayerSlider') ?></td>
													<td><input type="text" name="scale" value="<?php echo !empty($tr['transition']['scale']) ? $tr['transition']['scale'] : '1.0' ?>" data-help="The initial scale of the individual tiles which will be animated to the default (1.0) value."></td>
												</tr>
											</tbody>
										</table>
									</div>
									<?php endforeach; ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>

		<div class="ls-publish">
			<?php if(is_writable($upload_dir['basedir'])) : ?>
			<button class="button button-primary button-hero"><?php _e('Save changes', 'LayerSlider') ?></button>
			<?php else : ?>
			<?php _e('Before you can save your changes, you need to make your "/wp-content/uploads" folder writable. See the <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">Codex</a>', 'LayerSlider') ?>
			<?php endif; ?>
		</div>
	</form>
</div>
<script type="text/javascript">
	var pluginPath = '<?php echo LS_ROOT_URL ?>/static/';
	var lsTrImgPath = '<?php echo LS_ROOT_URL ?>/static/admin/img/';
	var lsScreenOptions = <?php echo json_encode($lsScreenOptions) ?>;
</script>

<!-- Help menu WP Pointer -->
<?php
if(get_user_meta(get_current_user_id(), 'layerslider_builder_help_wp_pointer', true) != '1') {
add_user_meta(get_current_user_id(), 'layerslider_builder_help_wp_pointer', '1'); ?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#contextual-help-link-wrap').pointer({
			pointerClass : 'ls-help-pointer',
			pointerWidth : 320,
			content: '<h3><?php _e('Transition Builder documentation', 'LayerSlider') ?></h3><div class="inner"><?php _e('To get started with the LayerSlider WP Transition Builder, please read our online documentation by clicking on this help menu.', 'LayerSlider') ?></div>',
			position: {
				edge : 'top',
				align : 'right'
			}
		}).pointer('open');
	});
</script>
<?php } ?>
