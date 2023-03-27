<!-- components/components/blockquote.php -->

<p>Le texte doit être placé dans des balises "blockquote"</p>
<p>Dans le cas où l'auteur est cité, le placer à la suite dans les balises span class="cite-name" et class="cite-function"</p>
<div class="encadre">
    <div class="grid-2 has-gutter-xl">
        <div>
            <p>ATTRIBUTS :</p>
            <ul>
                <li>Citation</li>
                <li>Auteur</li>
                <li>Fonction</li>
            </ul>
        </div>
        <div>
            <p>OPTIONS :</p>
        </div>
    </div>
</div>

<p class="subTitle">Molécule socle "Citation"</p>

<?php

$blockquote = new \WonderWp\Theme\Child\Components\Citation\CitationComponent();

$blockquote
    ->setBlockquote('Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
    ->setAuthor('Michel Consectetur')
    ->setFunction('Dupic esse vienium in culpa nobis exerticatio')
;

echo $blockquote->getMarkup();
?>
<hr>

<p class="subTitle">Bloc Gutenberg "Citation"</p>
<blockquote class="wp-block-quote">
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
    <cite>Michel Consectetur</cite>
</blockquote>
<hr>

<p class="subTitle">Bloc Gutenberg "Citation en exergue"</p>
<figure class="wp-block-pullquote">
    <blockquote>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <cite>Michel Consectetur</cite>
    </blockquote>
</figure>
