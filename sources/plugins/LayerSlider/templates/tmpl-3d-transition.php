<?php if(!defined('LS_ROOT_FILE')) { header('HTTP/1.0 403 Forbidden'); exit; } ?>
<script type="text/html" id="ls-3d-transition-template">
	<div class="ls-transition-item">
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
									<td class="right"><?php _e('Rows', 'LayerSlider') ?></td>
									<td><input type="text" name="rows" value="1" data-help="<?php _e('<i>number</i> or <i>min,max</i> If you specify a value greater than 1, LayerSlider will cut your slide into tiles. You can specify here how many rows of your transition should have. If you specify two numbers separated with a comma, LayerSlider will use that as a range and pick a random number between your values.', 'LayerSlider') ?>"></td>
									<td class="right"><?php _e('Cols', 'LayerSlider') ?></td>
									<td><input type="text" name="cols" value="1" data-help="<?php _e('<i>number</i> or <i>min,max</i> If you specify a value greater than 1, LayerSlider will cut your slide into tiles. You can specify here how many columns of your transition should have. If you specify two numbers separated with a comma, LayerSlider will use that as a range and pick a random number between your values.', 'LayerSlider') ?>"></td>
								</tr>
							</tbody>
							<tbody class="tile">
								<tr>
									<td class="right"><?php _e('Delay', 'LayerSlider') ?></td>
									<td><input type="text" name="delay" value="75" data-help="<?php _e('You can apply a delay between the tiles and postpone their animation relative to each other.', 'LayerSlider') ?>"></td>
									<td class="right"><?php _e('Sequence', 'LayerSlider') ?></td>
									<td>
										<select name="sequence" data-help="<?php _e('You can control the animation order of the tiles here.', 'LayerSlider') ?>">
											<option value="forward"><?php _e('Forward', 'LayerSlider') ?></option>
											<option value="reverse"><?php _e('Reverse', 'LayerSlider') ?></option>
											<option value="col-forward"><?php _e('Col-forward', 'LayerSlider') ?></option>
											<option value="col-reverse"><?php _e('Col-reverse', 'LayerSlider') ?></option>
											<option value="random"><?php _e('Random', 'LayerSlider') ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="right"><?php _e('Depth', 'LayerSlider') ?></td>
									<td colspan="3">
										<label data-help="<?php _e('The script tries to identify the optimal depth for your rotated objects (tiles). With this option you can force your objects to have a large depth when performing 180 degree (and its multiplies) rotation.', 'LayerSlider') ?>">
											<input type="checkbox" class="checkbox" name="depth" value="large">
											<?php _e('Large depth', 'LayerSlider') ?>
										</label>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
			<thead>
				<tr>
					<td colspan="4">
						<?php _e('Before animation', 'LayerSlider') ?>
						<p class="ls-builder-checkbox">
							<label><input type="checkbox" class="ls-builder-collapse-toggle"> <?php _e('Enabled', 'LayerSlider') ?></label>
						</p>
					</td>
				</tr>
			</thead>
			<tbody class="before ls-builder-collapsed">
				<tr>
					<td class="right"><?php _e('Duration', 'LayerSlider') ?></td>
					<td><input type="text" name="duration" value="1000" data-help="<?php _e('The duration of your animation. This value is in millisecs, so the value 1000 means 1 second.', 'LayerSlider') ?>"></td>
					<td class="right"><a href="http://easings.net/" target="_blank"><?php _e('Easing', 'LayerSlider') ?></a></td>
					<td>
						<select name="easing" data-help="<?php _e('The timing function of the animation. With this function you can manipulate the movement of the animated object. Please click on the link next to this select field to open easings.net for more information and real-time examples.', 'LayerSlider') ?>">
							<option>linear</option>
							<option>easeInQuad</option>
							<option>easeOutQuad</option>
							<option>easeInOutQuad</option>
							<option>easeInCubic</option>
							<option>easeOutCubic</option>
							<option>easeInOutCubic</option>
							<option>easeInQuart</option>
							<option>easeOutQuart</option>
							<option>easeInOutQuart</option>
							<option>easeInQuint</option>
							<option>easeOutQuint</option>
							<option selected="selected">easeInOutQuint</option>
							<option>easeInSine</option>
							<option>easeOutSine</option>
							<option>easeInOutSine</option>
							<option>easeInExpo</option>
							<option>easeOutExpo</option>
							<option>easeInOutExpo</option>
							<option>easeInCirc</option>
							<option>easeOutCirc</option>
							<option>easeInOutCirc</option>
							<option>easeInBack</option>
							<option>easeOutBack</option>
							<option>easeInOutBack</option>
						</select>
					</td>
				</tr>
				<tr class="transition">
					<td colspan="4">
						<ul class="ls-tr-tags"></ul>
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
					<td><input type="text" name="duration" value="1000" data-help="<?php _e('The duration of your animation. This value is in millisecs, so the value 1000 means 1 second.', 'LayerSlider') ?>"></td>
					<td class="right"><a href="http://easings.net/" target="_blank"><?php _e('Easing', 'LayerSlider') ?></a></td>
					<td>
						<select name="easing" data-help="<?php _e('The timing function of the animation. With this function you can manipulate the movement of the animated object. Please click on the link next to this select field to open easings.net for more information and real-time examples.', 'LayerSlider') ?>">
							<option>linear</option>
							<option>easeInQuad</option>
							<option>easeOutQuad</option>
							<option>easeInOutQuad</option>
							<option>easeInCubic</option>
							<option>easeOutCubic</option>
							<option>easeInOutCubic</option>
							<option>easeInQuart</option>
							<option>easeOutQuart</option>
							<option>easeInOutQuart</option>
							<option>easeInQuint</option>
							<option>easeOutQuint</option>
							<option selected="selected">easeInOutQuint</option>
							<option>easeInSine</option>
							<option>easeOutSine</option>
							<option>easeInOutSine</option>
							<option>easeInExpo</option>
							<option>easeOutExpo</option>
							<option>easeInOutExpo</option>
							<option>easeInCirc</option>
							<option>easeOutCirc</option>
							<option>easeInOutCirc</option>
							<option>easeInBack</option>
							<option>easeOutBack</option>
							<option>easeInOutBack</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td class="right"><?php _e('Direction', 'LayerSlider') ?></td>
					<td>
						<select name="direction" data-help="<?php _e('The direction of rotation.', 'LayerSlider') ?>">
							<option value="vertical"><?php _e('Vertical', 'LayerSlider'); ?></option>
							<option value="horizontal" selected="selected"><?php _e('Horizontal', 'LayerSlider') ?></option>
						</select>
					</td>
				</tr>
				<tr class="transition">
					<td colspan="4">
						<ul class="ls-tr-tags">
							<li>
								<p>
									<span><?php _e('RotateX', 'LayerSlider') ?></span>
									<input type="text" name="rotateY" value="90">
								</p>
								<a href="#" class="dashicons dashicons-dismiss"></a>
							</li>
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
						<?php _e('After animation', 'LayerSlider') ?>
						<p class="ls-builder-checkbox">
							<label><input type="checkbox" class="ls-builder-collapse-toggle"> <?php _e('Enabled', 'LayerSlider') ?></label>
						</p>
					</td>
				</tr>
			</thead>
			<tbody class="after ls-builder-collapsed">
				<tr>
					<td class="right"><?php _e('Duration', 'LayerSlider') ?></td>
					<td><input type="text" name="duration" value="1000" data-help="<?php _e('The duration of your animation. This value is in millisecs, so the value 1000 means 1 second.', 'LayerSlider') ?>"></td>
					<td class="right"><a href="http://easings.net/" target="_blank"><?php _e('Easing', 'LayerSlider') ?></a></td>
					<td>
						<select name="easing" data-help="<?php _e('The timing function of the animation. With this function you can manipulate the movement of the animated object. Please click on the link next to this select field to open easings.net for more information and real-time examples.', 'LayerSlider') ?>">
							<option>linear</option>
							<option>easeInQuad</option>
							<option>easeOutQuad</option>
							<option>easeInOutQuad</option>
							<option>easeInCubic</option>
							<option>easeOutCubic</option>
							<option>easeInOutCubic</option>
							<option>easeInQuart</option>
							<option>easeOutQuart</option>
							<option>easeInOutQuart</option>
							<option>easeInQuint</option>
							<option>easeOutQuint</option>
							<option selected="selected">easeInOutQuint</option>
							<option>easeInSine</option>
							<option>easeOutSine</option>
							<option>easeInOutSine</option>
							<option>easeInExpo</option>
							<option>easeOutExpo</option>
							<option>easeInOutExpo</option>
							<option>easeInCirc</option>
							<option>easeOutCirc</option>
							<option>easeInOutCirc</option>
							<option>easeInBack</option>
							<option>easeOutBack</option>
							<option>easeInOutBack</option>
						</select>
					</td>
				</tr>
				<tr class="transition">
					<td colspan="4">
						<ul class="ls-tr-tags"></ul>
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
</script>