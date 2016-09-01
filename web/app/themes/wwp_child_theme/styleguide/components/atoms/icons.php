<!--components/atoms/icons.php-->

<span class="subTitle">Use:</span>
<p>Use 1 - shortcode in template:</p>
For image_name.svg: <code>[getSvgIcon icon="image_name"]</code>
<br>

<p>Use 2 - function in styleguide:</p>
<code><?php echo getSvgIcon('image_name') ?></code>
<br>

<p>Use 3 - css background image:</p>
<code><i class="icon svg-arrow_down"></i></code>

<hr>
<div class="icon-set">
	<span class="subTitle">Icon set:</span>
	<div class="icon-item"><?php echo getSvgIcon('arrow_down') ?><span>arrow_down</span></div>
	<div class="icon-item"><?php echo getSvgIcon('video') ?><span>video</span></div>
	<div class="icon-item"><?php echo getSvgIcon('logo_flat') ?><span>logo_flat</span></div>
</div>
