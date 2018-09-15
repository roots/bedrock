<?php if(!defined('LS_ROOT_FILE')) {  header('HTTP/1.0 403 Forbidden'); exit; } ?>
<script type="text/html" id="tmpl-ls-transition-modal">
	<div id="ls-transition-window" class="ls-modal ls-box">
		<header>
			<h2>Select slide transitions</h2>
			<div class="filters">
				<span>Show:</span>
				<ul>
					<li class="active">2D</li>
					<li>3D</li>
					<li>Custom</li>
				</ul>
			</div>
			<b class="dashicons dashicons-no"></b>
			<i>Apply to others</i>
			<i class="off">Select all</i>
		</header>
		<div class="inner">
			<table></table>
		</div>
	</div>
</script>