<!-- components/components/blockquote.php -->

<p>Le texte doit être placé dans des balises "blockquote"</p>
<p>Dans le cas où l'auteur est cité, le placer à la suite dans les balises span class="cite-name" et class="cite-function"</p>

<?php

$blockquote = new \WonderWp\Theme\Child\Components\Citation\CitationComponent();

$blockquote
    ->setBlockquote('Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
    ->setAuthor('Michel Consectetur')
    ->setFunction('Dupic esse vienium in culpa nobis exerticatio')
;

echo $blockquote->getMarkup();
