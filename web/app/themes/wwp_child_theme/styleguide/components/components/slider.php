<!-- components/components/slider.php -->
<div class="encadre">
    <div class="grid-2 has-gutter-xl">
        <div>
            <p>PLUGIN</p>
        </div>
        <div>
            <p>CLASSES DE VARIANTES</p>
            <ul>
                <li>.slider-2cols</li>
            </ul>
        </div>
    </div>
</div>

<p class="subTitle">Slider de base : le contenu est positionné au-dessus de l'image</p>
<br>

<?php echo do_shortcode('[wwpmodule slug="wwp-slider" slider="1" ]'); ?>
<br>

<p class="subTitle">Variante slider 2 cols : le contenu est positionné à côté de l'image. Ajouter la classe ".slider-2cols" avant le slider.</p>

<div class="slider-2cols">
    <?php echo do_shortcode('[wwpmodule slug="wwp-slider" slider="1" ]'); ?>
</div>
