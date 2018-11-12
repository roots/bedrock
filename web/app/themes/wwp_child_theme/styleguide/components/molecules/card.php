<!-- components/Molecules/card.php -->

<p class="subTitle">Bloc de contenu polyvalent utilisé notamment pour créer des Call to Action.</p>
<p> Peut contenir des titre, texte, image, bouton et lien (attributs du shortcode disponibles : "title", "text", "img", "link", "button" et "class"). Les classes fonctionnelles suivantes permettent de modifier son apparence : "negative", "reverse", "two-cols", "inline" (ex : class="negative"). On peut intervenir sur la couleur dominante des textes ou du fond avec les attributs du shortcode : "color" et "background"</p>

<code>[card title="Lorem ipsum dolor sit amet" content="Lorem ipsum dolor(…)" image="https://placeimg.com/350/150/nature" link="/une-page" button="Découvrir" color="blue" background="blue" class="reverse negative "]</code>


<div class="grid-3-small-2 has-gutter-xl">
    <?php echo do_shortcode ('[card title="Lorem ipsum dolor sit amet" content="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam." image="https://placeimg.com/350/150/animals" link="/une-page" button="Découvrir"]'); ?>
    <?php echo do_shortcode ('[card title="Lorem ipsum" content="Lorem ipsum dolor sit amet, consectetur adipisicing elit." image="https://placeimg.com/350/150/nature" link="/une-page" button="Découvrir" class="negative"]'); ?>
    <?php echo do_shortcode ('[card title="Lorem ipsum dolor sit amet" content="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam." image="https://placeimg.com/350/150/architecture" link="/une-page" button="Découvrir" class="reverse"]'); ?>
</div>


