<?php if(!defined('LS_ROOT_FILE')) {  header('HTTP/1.0 403 Forbidden'); exit; }

	$time = time();
	$installed = get_option('ls-date-installed', 0);
	$level = get_option('ls-share-displayed', 1);

	switch($level){
		case 1:
			$time = $time-60*60*24*14;
			$odds = 100;
			break;

		case 2:
			$time = $time-60*60*24*30*2;
			$odds = 200;
			break;

		case 3:
			$time = $time-60*60*24*30*6;
			$odds = 300;
			break;

		default:
			$time = $time-60*60*24*30*6;
			$odds = 1000;
			break;
	}

	if($installed && $time > $installed) {
		if(mt_rand(1, $odds) == 3) {
			update_option('ls-share-displayed', ++$level);
?>
<div class="ls-overlay" data-manualclose="true"></div>
<div id="ls-share-template" class="ls-modal ls-box">
	<h3>
		<?php _e('Enjoy using LayerSlider?', 'LayerSlider') ?>
		<a href="#" class="dashicons dashicons-no-alt"></a>
	</h3>
	<div class="inner desc">
		<?php _e("If so, please consider recommending it to your friends on your favorite social network!", "LayerSlider"); ?>
	</div>
	<div class="inner">
		<a href="https://www.facebook.com/sharer/sharer.php?u=https://layerslider.kreaturamedia.com" target="_blank">
			<i class="dashicons dashicons-facebook-alt"></i> <?php _e('Share', 'LayerSlider') ?>
		</a>

		<a href="http://www.twitter.com/share?url=https%3A%2F%2Flayerslider.kreaturamedia.com&amp;text=Check%20out%20LayerSlider%20WP%2C%20an%20awesome%20%23slider%20%23plugin%20for%20%23WordPress&amp;via=kreaturamedia" target="_blank">
			<i class="dashicons dashicons-twitter"></i> <?php _e('Tweet', 'LayerSlider') ?>
		</a>

		<a href="https://plus.google.com/share?url=https://layerslider.kreaturamedia.com" target="_blank">
			<i class="dashicons dashicons-googleplus"></i> +1
		</a>
	</div>
</div>
<?php } } ?>