<!--components/molecules/card.php-->
<p class="subTitle">Bloc de contenu polyvalent utilisé notamment pour créer des Call to Action.</p>
<p> Peut contenir des titre, texte, image, bouton et lien (attributs du shortcode disponibles : "title", "text", "img", "link", "button" et "class"). Les classes fonctionnelles suivantes permettent de modifier son apparence : "negative", "reverse", "two-cols", "inline" (ex : class="negative"). On peut intervenir sur la couleur dominante des textes ou du fond avec les attributs du shortcode : "color" et "background"</p>

<code>[card title="Lorem ipsum dolor sit amet" text="Lorem ipsum dolor(…)" image="http://via.placeholder.com/350x150" link="/une-page" button="Découvrir" color="blue" background="blue" class="reverse negative "]</code>


<div class="grid-3-small-2 has-gutter-xl">
    <?php echo do_shortcode ('[card title="Lorem ipsum dolor sit amet" text="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam." img="http://via.placeholder.com/350x220" link="/une-page" button="Découvrir"]'); ?>
    <?php echo do_shortcode ('[card title="Lorem ipsum" text="Lorem ipsum dolor sit amet, consectetur adipisicing elit." img="http://via.placeholder.com/350x220" link="/une-page" button="Découvrir" class="negative"]'); ?>
    <?php echo do_shortcode ('[card title="Lorem ipsum dolor sit amet" text="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam." img="http://via.placeholder.com/350x220" link="/une-page" button="Découvrir" class="reverse"]'); ?>
</div>