<!-- components/components/hero.php -->
<p class="subTitle">Déprécié - utiliser en priorité le bloc Gutenberg "Cover"</p>

<div class="encadre">
    <div class="grid-2 has-gutter-xl">
        <div>
            <p>ATTRIBUTS :</p>
            <ul>
                <li>Titre</li>
                <li>Surtitre</li>
                <li>Chapo</li>
                <li>Texte</li>
                <li>Logo</li>
                <li>Icône</li>
                <li>Image de fond</li>
                <li>Opacité de l'image</li>
                <li>Fond de couleur (#00000)</li>
                <li>Filtre css mixblendmode</li>
                <li>Lien bouton</li>
                <li>Label bouton</li>
                <li>Bloc de contenu libre</li>
            </ul>
        </div>
        <div>
            <p>OPTIONS :</p>
            <ul>
                <li>Titre de petite taille</li>
                <li>Contenu aligné à gauche</li>
                <li>Contenu aligné en bas</li>
                <li>Petite zone de contenu</li>
                <li>Petite taille pour mobile</li>
                <li>Lien externe</li>
            </ul>
        </div>
    </div>
</div>

<?php

$hero = new \WonderWp\Theme\Child\Components\Hero\HeroComponent();

$hero
    ->setTitle('Lorem ipsum dolor sit amet, consectetur adipiscing eli')
    ->setImage('<img width="340" height="340" src="https://via.placeholder.com/340x240" alt="">')
    ->setText('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.')
    ->setLink('/')
    ->setlabel('En savoir plus')
    ->setSubComponents('<p>Bloc de contenu libre</p>')
;

echo $hero->getMarkup();
echo '<br>';

$hero
    ->setTitle('Lorem ipsum dolor sit amet, consectetur adipiscing eli')
    ->setImage('<img width="340" height="340" src="https://via.placeholder.com/340x240" alt="">')
    ->setText('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.')
    ->setLink('/')
    ->setlabel('En savoir plus')
    ->setSubComponents('<p>Bloc de contenu libre</p>')
    ->setColor('#C81F3B')
    ->setMixblendmode('luminosity')
;

echo $hero->getMarkup();
