<!--components/base/grids.php-->


<span class="subTitle">Système de grille</span>
<span> Knacss est basé sur grillade.css (découvrez toutes les fonctionnalités sur http://knacss.com/grillade/). Par défaut, Grillade n'est activée que si la taille d'écran est supérieure à celle d'un smartphone. Il suffit d'ajouter la classe "grid-x" sur un conteneur, x étant le nombre de colonnes.</span>
<br>
<br>

<span class="subTitle">Grille sur 3 colonnes : ajouter la classe ".grid-3" sur le bloc parent</span>
<div class="grid-3">
    <div>...</div>
    <div>...</div>
    <div>...</div>
    <div>...</div>
    <div>...</div>
</div>
<br>

<span class="subTitle">Grille avec gouttière : ajouter une des classes "has-gutter", "has-gutter-l" ou "has-gutter-xl"</span>
<div class="grid-3 has-gutter">
    <div class="one-fifth">.one-fifth</div>
    <div>...</div>
    <div class="one-fifth">.one-fifth</div>
</div>
<br>

<span class="subTitle">Grille de 4 colonnes avec enfants redimensionnés sur plusieurs colonnes et plusieurs rangées : ajouter la classe directement sur l'élément enfant (ex : ".col-2" ou ".row-2")</span>
<div class="grid-4">
    <div>1</div>
    <div class="col-2">.col-2</div>
    <div class="row-2">.row-2</div>
    <div>4</div>
    <div>5</div>
    <div>6</div>
</div>
<br>

<span class="subTitle">Grille de 6 colonnes sur grand écran ET 3 colonnes sur écran moyen (iPad) : ajouter la classe "grid-6-small-3"</span>
<div class="grid-6-small-3">
    <div>1</div>
    <div>2</div>
    <div>3</div>
    <div>4</div>
    <div>5</div>
    <div>6</div>
    <div>7</div>
    <div>8</div>
</div>