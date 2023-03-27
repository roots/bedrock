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
<br>
<?php echo do_shortcode('[wwpmodule slug="wwp-slider" slider="5" ]'); ?>

<p class="subTitle">Slider carousel</p>
<br>
<?php echo do_shortcode('[slider class="wdf-slider-carousel"]
[slider-item title="Titre du slide numéro 1" content="Lorem ipsum dolor sit amet consectetur adipisicing elit." img="/app/uploads/2020/07/truebsee-5337646_1280.jpg"]
[slider-item title="Titre du slide numéro 2" content="Lorem ipsum dolor sit amet." img="/app/uploads/2020/10/Car-repair-shop.jpg"]
[/slider]'); ?>

<p class="subTitle">Slider Gutenberg gallery</p>
<br>
<?php echo do_shortcode('[slider class="wwp-galerie-slider"]
[slider-item title="Titre du slide numéro 1" content="Lorem ipsum dolor sit amet consectetur adipisicing elit." img="/app/uploads/2020/07/truebsee-5337646_1280.jpg"]
[slider-item title="Titre du slide numéro 2" content="Lorem ipsum dolor sit amet." img="/app/uploads/2020/10/Car-repair-shop.jpg"]
[/slider]'); ?>
