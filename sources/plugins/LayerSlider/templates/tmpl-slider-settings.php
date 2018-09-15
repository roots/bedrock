<?php if(!defined('LS_ROOT_FILE')) { header('HTTP/1.0 403 Forbidden'); exit; } ?>

<?php

	$sDefs  =& $lsDefaults['slider'];
	$sProps =& $slider['properties'];
?>

<!-- Slider title -->
<div class="ls-slider-titlewrap">
	<?php $sliderName = !empty($sProps['title']) ? htmlspecialchars(stripslashes($sProps['title'])) : ''; ?>
	<input type="text" name="title" value="<?php echo $sliderName ?>" id="title" autocomplete="off" placeholder="<?php _e('Type your slider name here', 'LayerSlider') ?>">
	<div class="ls-slider-slug">
		<?php _e('Slider slug', 'LayerSlider') ?>:<input type="text" name="slug" value="<?php echo !empty($sProps['slug']) ? $sProps['slug'] : '' ?>" autocomplete="off" placeholder="<?php _e('e.g. homepageslider', 'LayerSlider') ?>" data-help="Set a custom slider identifier to use in shortcodes instead of the database ID. Needs to be unique, and can contain only alphanumeric characters. This setting is optional.">
	</div>
</div>

<!-- Slider settings -->
<div class="ls-box ls-settings">
	<h3 class="header medium">
		<?php _e('Slider Settings', 'LayerSlider') ?>
		<div class="ls-slider-settings-advanced">
			<?php _e('Show advanced settings', 'LayerSlider') ?> <input type="checkbox" data-toggleitems=".ls-settings-contents .ls-advanced">
		</div>
	</h3>
	<div class="inner">
		<ul class="ls-settings-sidebar">
			<li data-deeplink="publish"><i class="dashicons dashicons-calendar-alt"></i><?php _e('Publish', 'LayerSlider') ?></li>
			<li data-deeplink="layout" class="active"><i class="dashicons dashicons-editor-distractionfree"></i><?php _e('Layout', 'LayerSlider') ?></li>
			<li data-deeplink="mobile"><i class="dashicons dashicons-smartphone"></i><?php _e('Mobile', 'LayerSlider') ?></li>
			<li data-deeplink="slideshow"><i class="dashicons dashicons-editor-video"></i><?php _e('Slideshow', 'LayerSlider') ?></li>
			<li data-deeplink="appearance"><i class="dashicons dashicons-admin-appearance"></i><?php _e('Appearance', 'LayerSlider') ?></li>
			<li data-deeplink="navigation"><i class="dashicons dashicons-image-flip-horizontal"></i><?php _e('Navigation Area', 'LayerSlider') ?></li>
			<li data-deeplink="thumbnav"><i class="dashicons dashicons-screenoptions"></i><?php _e('Thumbnail Navigation', 'LayerSlider') ?></li>
			<li data-deeplink="videos"><i class="dashicons dashicons-video-alt3"></i><?php _e('Videos', 'LayerSlider') ?></li>
			<li data-deeplink="yourlogo"><i class="dashicons dashicons-admin-post"></i><?php _e('YourLogo', 'LayerSlider') ?></li>
			<li data-deeplink="transition"><i class="dashicons dashicons-admin-settings"></i><?php _e('Default Options', 'LayerSlider') ?></li>
			<li data-deeplink="misc"><i class="dashicons dashicons-admin-generic"></i><?php _e('Misc', 'LayerSlider') ?></li>
		</ul>
		<div class="ls-settings-contents">
			<table>

				<!-- Publish -->
				<tbody>
					<tr><th colspan="2"><?php echo $sDefs['status']['name'] ?></th></tr>
					<tr>
						<td colspan="2" class="hero">
							<p>
								<?php lsGetCheckbox($sDefs['status'], $sProps, array('class' => 'hero ls-publish-checkbox')); ?>
								<?php echo $sDefs['status']['desc'] ?>
							</p>
						</td>
					</tr>
					<tr>
						<th class="half"><?php echo $sDefs['scheduleStart']['name'] ?></th>
						<th class="half"><?php echo $sDefs['scheduleEnd']['name'] ?></th>
					</tr>
					<tr>
						<td class="half">
							<div class="ls-datepicker-wrapper">
								<label><?php _e('Interpreted as:', 'LayerSlider') ?> <span></span></label>
								<?php lsGetInput($sDefs['scheduleStart'], $sProps, array('class' => 'ls-datepicker-input', 'data-schedule-key' => 'schedule_start')); ?>
							</div>
						</td>
						<td class="half">
							<div class="ls-datepicker-wrapper">
								<label><?php _e('Interpreted as:', 'LayerSlider') ?> <span></span></label>
								<?php lsGetInput($sDefs['scheduleEnd'], $sProps, array('class' => 'ls-datepicker-input', 'data-schedule-key' => 'schedule_end')); ?>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="hero">
							<div class="ls-schedule-desc"><?php echo $sDefs['scheduleStart']['desc'] ?></div>
						</td>
					</tr>
				</tbody>

				<!-- Layout -->
				<tbody class="active">
					<tr><th colspan="3"><?php _e('Slider type & dimensions', 'LayerSlider') ?></th></tr>
					<tr>
						<td colspan="3" class="ls-slider-dimensions">

							<?php lsGetInput($sDefs['type'], $sProps); ?>
							<div data-type="fixedsize">
								<img src="<?php echo LS_ROOT_URL.'/static/admin/img/layout-fixed.png' ?>">
								<span><?php _e('Fixed size', 'LayerSlider') ?></span>
							</div>

							<div data-type="responsive">
								<img src="<?php echo LS_ROOT_URL.'/static/admin/img/layout-responsive.png' ?>">
								<span><?php _e('Responsive', 'LayerSlider') ?></span>
							</div>

							<div data-type="fullwidth">
								<img src="<?php echo LS_ROOT_URL.'/static/admin/img/layout-full-width.png' ?>">
								<span><?php _e('Full width', 'LayerSlider') ?></span>
							</div>

							<div data-type="fullsize">
								<img src="<?php echo LS_ROOT_URL.'/static/admin/img/layout-full-screen.png' ?>">
								<span><?php _e('Full size', 'LayerSlider') ?></span>
							</div>
						</td>
					</tr>

					<?php
					lsOptionRow('input', $sDefs['width'], $sProps );
					lsOptionRow('input', $sDefs['height'], $sProps );
					lsOptionRow('input', $sDefs['maxWidth'], $sProps );
					lsOptionRow('input', $sDefs['responsiveUnder'], $sProps, array(), 'full-width-row' );
					lsOptionRow('select', $sDefs['fullSizeMode'], $sProps, array(), 'full-size-row' );
					lsOptionRow('checkbox', $sDefs['fitScreenWidth'], $sProps, array(), 'full-width-row full-size-row' );
					lsOptionRow('checkbox', $sDefs['allowFullscreen'], $sProps )
					?>

					<tr class="ls-advanced ls-hidden"><th colspan="3"><?php _e('Other settings', 'LayerSlider') ?></th></tr>
					<?php lsOptionRow('input', $sDefs['maxRatio'], $sProps ); ?>
					<tr class="ls-advanced ls-hidden">
						<td style="vertical-align: top; padding-top: 10px;">
							<div>
								<i class="dashicons dashicons-flag" data-help="Advanced option"></i>
								<?php echo $sDefs['insertMethod']['name'] ?>
							</div>
						</td>
						<td>
							<?php
								lsGetSelect($sDefs['insertMethod'], $sProps);
								lsGetInput($sDefs['insertSelector'], $sProps);
							?>
						</td>
						<td class="desc"><?php echo $sDefs['insertMethod']['desc'] ?></td>
					</tr>
					<?php
					lsOptionRow('select', $sDefs['clipSlideTransition'], $sProps );
					lsOptionRow('checkbox', $sDefs['preventSliderClip'], $sProps, array(), 'full-width-row full-size-row' );
					?>
				</tbody>


				<!-- Mobile -->
				<tbody>
					<?php
					lsOptionRow('checkbox', $sDefs['hideOnMobile'], $sProps );
					lsOptionRow('input', $sDefs['hideUnder'], $sProps );
					lsOptionRow('input', $sDefs['hideOver'], $sProps );
					lsOptionRow('checkbox', $sDefs['slideOnSwipe'], $sProps );
					lsOptionRow('checkbox', $sDefs['optimizeForMobile'], $sProps );
					?>
				</tbody>

				<!-- Slideshow -->
				<tbody>
					<tr><th colspan="3"><?php _e('Slideshow behavior', 'LayerSlider') ?></th></tr>
					<tr>
						<td><?php echo $sDefs['firstSlide']['name'] ?></td>
						<td><?php lsGetInput($sDefs['firstSlide'], $sProps) ?></td>
						<td class="desc"><?php echo $sDefs['firstSlide']['desc'] ?></td>
					</tr>
					<?php
					lsOptionRow('checkbox', $sDefs['autoStart'], $sProps );
					lsOptionRow('checkbox', $sDefs['pauseLayers'], $sProps );
					lsOptionRow('checkbox', $sDefs['startInViewport'], $sProps );
					lsOptionRow('select', $sDefs['pauseOnHover'], $sProps );
					?>
					<tr><th colspan="3"><?php _e('Slideshow navigation', 'LayerSlider') ?></th></tr>
					<?php
					lsOptionRow('checkbox', $sDefs['keybNavigation'], $sProps );
					lsOptionRow('checkbox', $sDefs['touchNavigation'], $sProps );
					?>
					<tr><th colspan="3"><?php _e('Play by Scroll', 'LayerSlider') ?></th></tr>
					<?php
					lsOptionRow('checkbox', $sDefs['playByScroll'], $sProps );
					lsOptionRow('input', $sDefs['playByScrollSpeed'], $sProps );
					?>
					<tr><th colspan="3"><?php _e('Cycles', 'LayerSlider') ?></th></tr>
					<?php
					lsOptionRow('input', $sDefs['loops'], $sProps );
					lsOptionRow('checkbox', $sDefs['forceLoopNumber'], $sProps );
					?>
					<tr><th colspan="3"><?php _e('Other settings', 'LayerSlider') ?></th></tr>
					<?php
					lsOptionRow('checkbox', $sDefs['twoWaySlideshow'], $sProps );
					lsOptionRow('checkbox', $sDefs['shuffle'], $sProps );
					?>
				</tbody>

				<!-- Appearance -->
				<tbody>
					<tr><th colspan="3"><?php _e('Slider appearance', 'LayerSlider') ?></th></tr>
					<tr>
						<td><?php _e('Skin', 'LayerSlider') ?></td>
						<td>
							<select name="skin">
								<?php $sProps['skin'] = empty($sProps['skin']) ? $sDefs['skin']['value'] : $sProps['skin'] ?>
								<?php $skins = LS_Sources::getSkins(); ?>
								<?php foreach($skins as $skin) : ?>
								<?php $selected = ($skin['handle'] == $sProps['skin']) ? ' selected="selected"' : '' ?>
								<option value="<?php echo $skin['handle'] ?>"<?php echo $selected ?>>
									<?php
									echo $skin['name'];
									if(!empty($skin['info']['note'])) { echo ' - ' . $skin['info']['note']; }
									?>
								</option>
								<?php endforeach; ?>
							</select>
						</td>
						<td class="desc"><?php echo $sDefs['skin']['desc'] ?></td>
					</tr>
					<?php
					lsOptionRow('input', $sDefs['sliderFadeInDuration'], $sProps );
					?>
					<tr>
						<td><?php _e('Custom slider CSS', 'LayerSlider') ?></td>
						<td colspan="2"><textarea name="sliderstyle" cols="30" rows="10"><?php echo !empty($sProps['sliderstyle']) ? $sProps['sliderstyle'] : $sDefs['sliderStyle']['value'] ?></textarea></td>
					</tr>

					<tr><th colspan="3"><?php _e('Slider global background', 'LayerSlider') ?></th></tr>
					<?php
					lsOptionRow('input', $sDefs['globalBGColor'], $sProps, array('class' => 'input ls-colorpicker minicolors-input') );
					?>
					<tr>
						<td><?php _e('Background image', 'LayerSlider') ?></td>
						<td>
							<?php $bgImage = !empty($sProps['backgroundimage']) ? $sProps['backgroundimage'] : null; ?>
							<?php $bgImageId = !empty($sProps['backgroundimageId']) ? $sProps['backgroundimageId'] : null; ?>
							<input type="hidden" name="backgroundimageId" value="<?php echo !empty($sProps['backgroundimageId']) ? $sProps['backgroundimageId'] : '' ?>">
							<input type="hidden" name="backgroundimage" value="<?php echo !empty($sProps['backgroundimage']) ? $sProps['backgroundimage'] : '' ?>">
							<div class="ls-image ls-global-background ls-upload">
								<div><img src="<?php echo apply_filters('ls_get_thumbnail', $bgImageId, $bgImage) ?>" alt=""></div>
								<a href="#" class="dashicons dashicons-dismiss"></a>
							</div>
						</td>
						<td class="desc"><?php echo $sDefs['globalBGImage']['desc'] ?></td>
					</tr>
					<?php
					lsOptionRow('select', $sDefs['globalBGRepeat'], $sProps );
					lsOptionRow('select', $sDefs['globalBGAttachment'], $sProps );
					lsOptionRow('input', $sDefs['globalBGPosition'], $sProps, array('class' => 'input') );
					?>
					<tr>
						<td><?php echo $sDefs['globalBGSize']['name'] ?></td>
						<td><?php lsGetInput($sDefs['globalBGSize'], $sProps, array('class' => 'input')) ?></div>
						</td>
						<td class="desc"><?php echo $sDefs['globalBGSize']['desc'] ?></td>
					</tr>

				</tbody>

				<!-- Navigation Area -->
				<tbody>
					<tr><th colspan="3"><?php _e('Show navigation buttons', 'LayerSlider') ?></th></tr>
					<?php
					lsOptionRow('checkbox', $sDefs['navPrevNextButtons'], $sProps );
					lsOptionRow('checkbox', $sDefs['navStartStopButtons'], $sProps );
					lsOptionRow('checkbox', $sDefs['navSlideButtons'], $sProps );
					?>
					<tr><th colspan="3"><?php _e('Navigation buttons on hover', 'LayerSlider') ?></th></tr>
					<?php
					lsOptionRow('checkbox', $sDefs['hoverPrevNextButtons'], $sProps );
					lsOptionRow('checkbox', $sDefs['hoverSlideButtons'], $sProps );
					?>
					<tr><th colspan="3"><?php _e('Slideshow timers', 'LayerSlider') ?></th></tr>
					<?php
					lsOptionRow('checkbox', $sDefs['barTimer'], $sProps );
					lsOptionRow('checkbox', $sDefs['circleTimer'], $sProps );
					lsOptionRow('checkbox', $sDefs['slideBarTimer'], $sProps );
					?>
				</tbody>

				<!-- Thumbnail navigation -->
				<tbody>
					<tr><th colspan="3"><?php _e('Appearance', 'LayerSlider') ?></th></tr>
					<?php
					lsOptionRow('select', $sDefs['thumbnailNavigation'], $sProps );
					lsOptionRow('input', $sDefs['thumbnailAreaWidth'], $sProps );
					?>
					<tr><th colspan="3"><?php _e('Thumbnail dimensions', 'LayerSlider') ?></th></tr>
					<?php
					lsOptionRow('input', $sDefs['thumbnailWidth'], $sProps );
					lsOptionRow('input', $sDefs['thumbnailHeight'], $sProps );
					?>
					<tr><th colspan="3"><?php _e('Thumbnail appearance', 'LayerSlider') ?></th></tr>
					<?php
					lsOptionRow('input', $sDefs['thumbnailActiveOpacity'], $sProps );
					lsOptionRow('input', $sDefs['thumbnailInactiveOpacity'], $sProps );
					?>
				</tbody>

				<!-- Videos -->
				<tbody>
					<?php
					lsOptionRow('checkbox', $sDefs['autoPlayVideos'], $sProps );
					lsOptionRow('select', $sDefs['autoPauseSlideshow'], $sProps );
					lsOptionRow('select', $sDefs['youtubePreviewQuality'], $sProps );
					?>
				</tbody>


				<!-- YourLogo -->
				<tbody>
					<tr>
						<td><?php echo $sDefs['yourLogoImage']['name'] ?></td>
						<td>
							<?php $sProps['yourlogo'] = !empty($sProps['yourlogo']) ? $sProps['yourlogo'] : null; ?>
							<?php $sProps['yourlogoId'] = !empty($sProps['yourlogoId']) ? $sProps['yourlogoId'] : null; ?>
							<input type="hidden" name="yourlogoId" value="<?php echo !empty($sProps['yourlogoId']) ? $sProps['yourlogoId'] : '' ?>">
							<input type="hidden" name="yourlogo" value="<?php echo !empty($sProps['yourlogo']) ? $sProps['yourlogo'] : '' ?>">
							<div class="ls-image ls-upload ls-yourlogo-upload not-set">
								<div><img src="<?php echo apply_filters('ls_get_thumbnail', $sProps['yourlogoId'], $sProps['yourlogo']) ?>" alt=""></div>
								<a href="#" class="dashicons dashicons-dismiss"></a>
							</div>
						</td>
						<td class="desc"><?php echo $sDefs['yourLogoImage']['desc'] ?></td>
					</tr>
					<tr>
						<td><?php echo $sDefs['yourLogoStyle']['name'] ?></td>
						<td colspan="2">
							<textarea name="yourlogostyle" cols="30" rows="10"><?php echo !empty($sProps['yourlogostyle']) ? $sProps['yourlogostyle'] : $sDefs['yourLogoStyle']['value'] ?></textarea>
						</td>
					</tr>
					<?php
					lsOptionRow('input', $sDefs['yourLogoLink'], $sProps );
					lsOptionRow('select', $sDefs['yourLogoTarget'], $sProps );
					?>
				</tbody>

				<!-- Transition Defaults -->
				<tbody>
					<tr><th colspan="3"><?php _e('Slide background defaults', 'LayerSlider') ?></th></tr>
					<?php
					lsOptionRow('select', $sDefs['slideBGSize'], $sProps );
					lsOptionRow('select', $sDefs['slideBGPosition'], $sProps );
					?>
					<tr><th colspan="3"><?php _e('Parallax defaults', 'LayerSlider') ?></th></tr>
					<?php
					lsOptionRow('input', $sDefs['parallaxSensitivity'], $sProps );
					lsOptionRow('select', $sDefs['parallaxCenterLayers'], $sProps );
					lsOptionRow('input', $sDefs['parallaxCenterDegree'], $sProps );
					lsOptionRow('checkbox', $sDefs['parallaxScrollReverse'], $sProps );
					?>
					<tr class="ls-advanced ls-hidden"><th colspan="3"><?php _e('Misc', 'LayerSlider') ?></th></tr>
					<?php
					lsOptionRow('input', $sDefs['forceLayersOutDuration'], $sProps );
					?>
				</tbody>

				<!-- Misc -->
				<tbody>
					<?php
					lsOptionRow('checkbox', $sDefs['relativeURLs'], $sProps );
					lsOptionRow('checkbox', $sDefs['useSrcset'], $sProps );
					lsOptionRow('checkbox', $sDefs['allowRestartOnResize'], $sProps );
					?>
				</tbody>

			</table>
		</div>
		<div class="clear"></div>
	</div>
</div>
