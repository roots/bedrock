<!--components/atoms/icons.php-->

<span class="subTitle">Utilisation</span>
<p>En tant que shortcode dans un template php</p>
<code>[getSvgIcon icon="arrow_down"]</code>
<br>

<p>En tant que fonction dans un template php</p>
<code>echo getSvgIcon('arrow_down');</code>
<br>

<p>Dans le css en utilisant le mixin "SvgIcon"</p>
<code>html : class="arrow_down" | css : @include svgIcon(arrow_down)}</code>

<div class="icon-item mrl"><?php echo getSvgIcon('arrow_right') ?><span class="u-small">arrow_right</span></div>
<div class="icon-item mrl"><?php echo getSvgIcon('arrow_down') ?><span class="u-small">arrow_down</span></div>
<div class="icon-item mrl"><?php echo getSvgIcon('arrow_left') ?><span class="u-small">arrow_left</span></div>
