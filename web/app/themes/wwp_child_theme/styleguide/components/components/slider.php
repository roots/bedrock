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

<p class="subTitle">Slider de base</p>
<span class="help">Le contenu est positionné par-dessus l'image.</span>
<br>

<?php echo do_shortcode('[wwpmodule slug="wwp-slider" slider="1" ]'); ?>
<br>

<p class="subTitle">Variante slider 2 cols</p>
<span class="help">Le contenu est positionné à côté de l'image. Ajouter la classe ".slider-2cols" avant le slider.</span>
<div class="slider-2cols">
    <?php echo do_shortcode('[wwpmodule slug="wwp-slider" slider="1" ]'); ?>
</div>
