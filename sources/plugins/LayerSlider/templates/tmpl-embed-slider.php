<?php if(!defined('LS_ROOT_FILE')) { header('HTTP/1.0 403 Forbidden'); exit; } ?>
<script type="text/html" id="tmpl-embed-slider">
	<div id="ls-embed-modal-window">
		<header>
			<h1><?php _e('Embed Slider', 'LayerSlider') ?></h1>
			<b class="dashicons dashicons-no"></b>
		</header>
		<div class="km-ui-modal-scrollable">
			<div class="columns clearfix">
				<div class="third">
					<div>
						<h3><?php _e('Easiest Method: Shortcode', 'LayerSlider') ?></h3>
						<p>
							<input type="text" class="shortcode" value="[layerslider id=&quot;134&quot;]" onclick="this.focus(); this.select();">
						</p>
						<p><?php _e("This is the most commonly used method. Just copy the shortcode above and paste it into the WordPress post/page editor, then it will automatically be replaced on your front-end sites with the actual slider. Most page builder solutions like Visual Composer or theme integrated ones usual also have support to insert custom shortcodes.", 'LayerSlider') ?></p>
						<footer>
							<a class="button" href="https://support.kreaturamedia.com/docs/layersliderwp/documentation.html#publish-shortcode" target="_blank">
								<i class="dashicons dashicons-external"></i>
								<?php _e('Learn more', 'LayerSlider') ?>
							</a>
						</footer>
					</div>
				</div>
				<div class="third">
					<div>
						<h3><?php _e('Alternate Method: Widget', 'LayerSlider') ?></h3>
						<p><?php _e("Widgets can provide a super easy drag and drop way of sharing your sliders when it comes to embed content to a commonly used part on your site like the header area, sidebar of the footer. However, the available widget areas are controlled by your theme and it might not offer the perfect spot that you're looking for. Just head to Appearance -> Widgets to see the options your theme offers.", 'LayerSlider') ?></p>
						<footer>
							<a class="button" href="https://support.kreaturamedia.com/docs/layersliderwp/documentation.html#publish-widgets" target="_blank">
								<i class="dashicons dashicons-external"></i>
								<?php _e('Learn more', 'LayerSlider') ?>
							</a>
						</footer>
					</div>
				</div>
				<div class="third">
					<div>
						<h3><?php _e('Advanced Method: PHP', 'LayerSlider') ?></h3>
						<p><?php _e("You can use the layerslider() PHP function to insert sliders by editing your theme's template files. Since you can implement custom logic in code, this option gives you unlimited control on how your sliders are embedded.", 'LayerSlider') ?></p>
						<p><?php _e('However, this approach require programming skills, thus we cannot recommend to user without having the necessary experience in web development.', 'LayerSlider') ?></p>
						<footer>
							<a class="button" href="https://support.kreaturamedia.com/docs/layersliderwp/documentation.html#publish-php" target="_blank">
								<i class="dashicons dashicons-external"></i>
								<?php _e('Learn more', 'LayerSlider') ?>
							</a>
						</footer>
					</div>
				</div>
			</div>
			<div class="ls-separator">
				<div>
					<?php _e('To find more details about how you can embed sliders on your site please refer to our', 'LayerSlider') ?>
					<a href="https://support.kreaturamedia.com/docs/layersliderwp/documentation.html" target="_blank"><?php _e('online documetation') ?></a>.
				</div>
			</div>
		</div>
	</div>
</script>