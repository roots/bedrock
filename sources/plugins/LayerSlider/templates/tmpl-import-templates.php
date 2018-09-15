<?php if(!defined('LS_ROOT_FILE')) {  header('HTTP/1.0 403 Forbidden'); exit; }
$demoSliders = LS_Sources::getDemoSliders(); ?>
<script>
	window.lsImportNonce = '<?php echo wp_create_nonce('ls-import-demos'); ?>';
	window.lsImportWarningTitle = "<?php _e('Activate your site to access premium templates.', 'LayerSlider') ?>";
	window.lsImportWarningContent = "<?php _e('This template is only available for activated sites. Please review the PRODUCT ACTIVATION section on the main LayerSlider screen or <a href=\"https://support.kreaturamedia.com/docs/layersliderwp/documentation.html#activation\" target=\"_blank\">click here</a> for more information.', 'LayerSlider') ?>";
</script>
<script type="text/html" id="tmpl-import-sliders">
	<div id="ls-import-modal-window" class="ls-modal fullpage ls-box">
		<header class="header">
			<div class="layerslider-logo"></div>
			<h1>
				<?php _e('LayerSlider', 'LayerSlider') ?>
				<span><?php _e('Templates', 'LayerSlider') ?></span>
			</h1>
<!-- 			<nav>
				<ul>
					<li class="active"><span><?php _e('Sliders', 'LayerSlider') ?></span></li>
					<li><span><?php _e('Plugins', 'LayerSlider') ?></span></li>
					<li><span><?php _e('Skins', 'LayerSlider') ?></span></li>
				</ul>
			</nav>
 -->
			<div class="last-update">
				<strong><?php _e('Last updated: ', 'LayerSlider') ?></strong>
				<span>
					<?php
						if( $lsStoreUpdate ) {
							echo human_time_diff($lsStoreUpdate), __(' ago', 'LayerSlider');
						} else {
							_e('Just now', 'LayerSlider');
						}
					?>
				</span>
				<a href="<?php echo wp_nonce_url('?page=layerslider&action=update_store', 'update_store') ?>" class="button"><?php _e('Force Library Update', 'LayerSlider') ?></a>
			</div>
 			<b class="dashicons dashicons-no"></b>
		</header>
		<div class="inner">
			<nav>
				<ul>
					<li class="uppercase active" data-group="all"><?php _e('All', 'LayerSlider') ?></li>
					<li class="uppercase" data-group="free"><?php _e('All free', 'LayerSlider') ?></li>
					<li class="uppercase" data-group="premium"><?php _e('All Premium', 'LayerSlider') ?></li>
					<?php if( count($demoSliders) ) : ?>
					<li class="uppercase" data-group="bundled"><?php _e('Bundled', 'LayerSlider') ?></li>
					<?php endif; ?>
					<li class="uppercase separator" data-group="new"><?php _e('New', 'LayerSlider') ?></li>

					<li data-group="fullwidth"><?php _e('Full-width', 'LayerSlider') ?></li>
					<li data-group="fullsize"><?php _e('Full-size', 'LayerSlider') ?></li>

					<li data-group="landing"><?php _e('Landing Page', 'LayerSlider') ?></li>
					<li data-group="parallax"><?php _e('Parallax', 'LayerSlider') ?></li>
					<li data-group="loop"><?php _e('Loop', 'LayerSlider') ?></li>
					<li data-group="text"><?php _e('Text Transition', 'LayerSlider') ?></li>
					<li data-group="kenburns"><?php _e('Ken Burns', 'LayerSlider') ?></li>
					<li data-group="playbyscroll"><?php _e('Play By Scroll', 'LayerSlider') ?></li>
					<li data-group="filter"><?php _e('Filter Transition', 'LayerSlider') ?></li>
					<li data-group="carousel"><?php _e('Carousel', 'LayerSlider') ?></li>
					<li data-group="media"><?php _e('Media', 'LayerSlider') ?></li>

					<li data-group="experiments"><?php _e('Experiments', 'LayerSlider') ?></li>
					<li data-group="specialeffects"><?php _e('Special Effects', 'LayerSlider') ?></li>

					<li data-group="3dtransition"><?php _e('3D Transition', 'LayerSlider') ?></li>
					<li data-group="api"><?php _e('API', 'LayerSlider') ?></li>
				</ul>
			</nav>

			<div class="items">
				<?php
					if( ! empty($lsStoreData) && ! empty($lsStoreData['sliders']) ) {
						$demoSliders = array_merge($demoSliders, $lsStoreData['sliders']);
					}
					foreach($demoSliders as $handle => $item) :
				?>
				<figure class="item" data-groups="<?php echo $item['groups'] ?>" data-handle="<?php echo $handle; ?>" data-bundled="<?php echo ! empty($item['bundled']) ? 'true' : 'false' ?>" data-premium-warning="<?php echo ( ! $validity && ! empty($item['premium']) ) ? 'true' : 'false' ?>">
					<div class="aspect">
						<div class="item-picture" style="background: url(<?php echo $item['preview'] ?>);">
						</div>
						<figcaption>
							<span><?php echo $item['name'] ?></span>
						</figcaption>
						<a class="item-preview" target="_blank" href="<?php echo ! empty($item['url']) ? $item['url'] : '#' ?>" ><b class="dashicons dashicons-format-image"></b><?php _e('preview', 'LayerSlider') ?></a>
						<a class="item-import" href="#"><?php _e('import', 'LayerSlider') ?><b class="dashicons dashicons-download"></b></a>
					</div>
				</figure>
				<?php endforeach ?>
				<figure class="coming-soon">
					<div class="aspect">
						<table class="absolute-wrapper">
							<tr>
								<td>
									<span><?php _e('Coming soon,<br>stay tuned!', 'LayerSlider') ?></span>
								</td>
							</tr>
						</table>
					</div>
				</figure>
			</div>
		</div>
	</div>
</script>