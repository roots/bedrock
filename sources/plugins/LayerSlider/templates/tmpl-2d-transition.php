<?php if(!defined('LS_ROOT_FILE')) { header('HTTP/1.0 403 Forbidden'); exit; } ?>
<script type="text/html" id="ls-2d-transition-template">
	<div class="ls-transition-item">
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
					<td><input type="text" name="duration" value="1000" data-help="<?php _e('The duration of the animation. This value is in millisecs, so the value 1000 measn 1 second.', 'LayerSlider') ?>"></td>
					<td class="right"><a href="http://easings.net/" target="_blank"><?php _e('Easing', 'LayerSlider') ?></a></td>
					<td>
						<select name="easing" data-help="<?php _e('The timing function of the animation. With this function you can manipulate the movement of the animated object. Please click on the link next to this select field to open easings.net for more information and real-time examples.', 'LayerSlider') ?>">
							<option>linear</option>
							<option>swing</option>
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
							<option>easeInElastic</option>
							<option>easeOutElastic</option>
							<option>easeInOutElastic</option>
							<option>easeInBack</option>
							<option>easeOutBack</option>
							<option>easeInOutBack</option>
							<option>easeInBounce</option>
							<option>easeOutBounce</option>
							<option>easeInOutBounce</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="right"><?php _e('Type', 'LayerSlider') ?></td>
					<td>
						<select name="type" data-help="<?php _e('The type of the animation, either slide, fade or both (mixed).', 'LayerSlider') ?>">
							<option value="slide"><?php _e('Slide', 'LayerSlider') ?></option>
							<option value="fade"><?php _e('Fade', 'LayerSlider') ?></option>
							<option value="mixed"><?php _e('Mixed', 'LayerSlider') ?></option>
						</select>
					</td>
					<td class="right"><?php _e('Direction', 'LayerSlider') ?></td>
					<td>
						<select name="direction" data-help="<?php _e('The direction of the slide or mixed animation if you\'ve chosen this type in the previous settings.', 'LayerSlider') ?>">
							<option value="top"><?php _e('Top', 'LayerSlider') ?></option>
							<option value="right"><?php _e('Right', 'LayerSlider') ?></option>
							<option value="bottom"><?php _e('Bottom', 'LayerSlider') ?></option>
							<option value="left"><?php _e('Left', 'LayerSlider') ?></option>
							<option value="random"><?php _e('Random', 'LayerSlider') ?></option>
							<option value="topleft"><?php _e('Top left', 'LayerSlider') ?></option>
							<option value="topright"><?php _e('Top right', 'LayerSlider') ?></option>
							<option value="bottomleft"><?php _e('Bottom left', 'LayerSlider') ?></option>
							<option value="bottomright"><?php _e('Bottom right', 'LayerSlider') ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="right"><?php _e('RotateX', 'LayerSlider') ?></td>
					<td><input type="text" name="rotateX" value="0" data-help="The initial rotation of the individual tiles which will be animated to the default (0deg) value around the X axis. You can use negatuve values."></td>
					<td class="right"><?php _e('RotateY', 'LayerSlider') ?></td>
					<td><input type="text" name="rotateY" value="0" data-help="The initial rotation of the individual tiles which will be animated to the default (0deg) value around the Y axis. You can use negatuve values."></td>
				</tr>
				<tr>
					<td class="right"><?php _e('RotateZ', 'LayerSlider') ?></td>
					<td><input type="text" name="rotate" value="0" data-help="The initial rotation of the individual tiles which will be animated to the default (0deg) value around the Z axis. You can use negatuve values."></td>
					<td class="right"><?php _e('Scale', 'LayerSlider') ?></td>
					<td><input type="text" name="scale" value="1.0" data-help="The initial scale of the individual tiles which will be animated to the default (1.0) value."></td>
				</tr>
			</tbody>
		</table>
	</div>
</script>