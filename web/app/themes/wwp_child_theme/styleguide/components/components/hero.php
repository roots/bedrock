<!-- components/components/hero.php -->
<div class="encadre">
    <div class="grid-2 has-gutter-xl">
        <div>
            <p>ATTRIBUTS :</p>
            <ul>
                <li>Titre</li>
                <li>Texte</li>
                <li>Image de fond</li>
                <li>Opacité de l'image</li>
                <li>Lien bouton</li>
                <li>Label bouton</li>
                <li>Bloc de contenu libre</li>
            </ul>
        </div>
        <div>
            <p>OPTIONS :</p>
            <ul>
                <li>Contenu aligné à gauche</li>
                <li>Petite zone de contenu</li>
            </ul>
        </div>
    </div>
</div>

<?php

$hero = new \WonderWp\Theme\Child\Components\Hero\HeroComponent();

$hero
    ->setTitle('Lorem ipsum dolor sit amet, consectetur adipiscing eli')
    ->setImage('<img src="https://placeimg.com/340/250/nature" alt="">')
    ->setText('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.')
    ->setLink('/')
    ->setlabel('En savoir plus')
    ->setSubComponents('<p>Bloc de contenu libre</p>')
;

echo $hero->getMarkup();
