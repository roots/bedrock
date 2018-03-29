<!--components/components/slider.php-->

<p class="subTitle">Attibuts disponibles : "title", "img", "link", "label", "content". <br>L'attribut "class" sert à cibler le slider afin de définir des options spécifiques (développement).</p>

<code>[slider class="wdf-slider"][slider-item title="Titre de la première slide" img="https://placeimg.com/950/600/nature" link="/" label="En savoir plus" content="rem ipsum dolor sit amet (...)"][/slider]</code>
<br>

<?php echo do_shortcode('[slider class="wdf-slider"][slider-item title="Titre de la première slide" img="https://placeimg.com/950/600/nature" link="/" label="En savoir plus" content="<p>Prem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>"][slider-item title="Titre de la deuxième slide" img="https://placeimg.com/950/600/animals" link="/" label="En savoir plus" content="<p>Prem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>"][/slider]'); ?>