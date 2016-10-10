<!--components/base/grids.php-->


<span class="subTitle">Mobile First</span>
<span> Knacss est basé sur grillade.css (découvrez toutes les fonctionnalités sur http://knacss.com/grillade/). Par défaut, Grillade n'est activée que si la taille d'écran est supérieure à celle d'un smartphone. Ainsi les éléments demeurent dans leur état naturel (sur une colonne en général) sur un petit device. Il suffit d'ajouter la classe "grid-x" sur un conteneur, x étant le nombre de colonnes.</span>
<br>
<br>

<span class="subTitle">Grille simple</span>
<div class="grid-3">
    <div>...</div>
    <div>...</div>
    <div>...</div>
    <div>...</div>
    <div>...</div>
</div>
<br>

<span class="subTitle">Grille avec gouttière</span>
<div class="grid-3 has-gutter">
    <div class="one-fifth">.one-fifth</div>
    <div>...</div>
    <div class="one-fifth">.one-fifth</div>
</div>
<br>

<span class="subTitle">Grille avec enfants redimensionnés</span>
<div class="grid-3">
    <div class="one-half">.one-half</div>
    <div class="one-half">.one-half</div>
    <div class="one-third">.one-third</div>
    <div class="two-thirds">.two-thirds</div>
    <div class="one-quarter">.one-quarter</div>
</div>
<br>

<span class="subTitle">Mixins Sass</span>
<span>Le mixin suivant, appliqué à votre classe .grid-perso construira une grille de 4 colonnes sans gouttière :  <strong>.grid-perso { @include grid(4, 0); }</strong></span>
<div class="grid-perso">
    <div>...</div>
    <div>...</div>
    <div>...</div>
</div>

<span class="subTitle">Plus sur le site de <a href="http://knacss.com/grillade/">grillade.css</a> (offsets pull et push, réordonner les éléments, inverser la grille…)</span>