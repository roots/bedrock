<!-- components/atoms/icons.php -->

<span class="subTitle">Utilisation</span>

<p>En tant que fonction dans un template php</p>
<code>echo getSvgIcon('arrow_right')</code>
<br>

<div>
<p>Dans le css en utilisant le mixin "SvgIcon()"</p>
<code>html : class="arrow_down" | css : @include svgIcon(arrow_down)}</code>
</div>

<?php echo getSvgIcon('arrow_right') ?>
<?php echo getSvgIcon('arrow_down') ?>
<?php echo getSvgIcon('arrow_left') ?>
