<!-- components/components/slider.php -->

<p class="subTitle">Slider de base : le contenu est positionné au-dessus de l'image</p>
<br>

<?php echo do_shortcode('[wwpmodule slug="wwp-slider" slider="1" ]'); ?>
<br>

<p class="subTitle">Variante slider 2 cols : le contenu est positionné à côté de l'image. Ajouter la classe ".slider-2cols" avant le slider.</p>

<div class="slider-2cols">
    <?php echo do_shortcode('[wwpmodule slug="wwp-slider" slider="1" ]'); ?>
</div>
