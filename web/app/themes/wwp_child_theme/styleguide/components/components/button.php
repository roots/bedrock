<!-- components/components/button.php -->
<p class="subTitle">Bouton Gutenberg</p>

<div class="encadre">
    <div class="grid-2 has-gutter-xl">
        <div>
            <p>ATTRIBUTS :</p>
            <ul>
                <li>Label</li>
                <li>Lien</li>
                <li>Couleur (nom de variable)</li>
            </ul>
        </div>
        <div>
            <p>OPTIONS :</p>
            <ul>
                <li>Flèche droite</li>
                <li>Target blank</li>
            </ul>
        </div>
    </div>
</div>

<p class="subTitle">Bouton de base</p>
<?php
$button = new \WonderWp\Theme\Child\Components\Button\ButtonComponent();
$button
    ->setLink('/')
    ->setLabel('Valider')
;
echo $button->getMarkup();
?>
<br><hr>

<p class="subTitle">Bouton avec lien sortant</p>
<?php
$button = new \WonderWp\Theme\Child\Components\Button\ButtonComponent();
$button
    ->setLink('/')
    ->setLabel('Lien externe')
    ->setTargetBlank('true')
;
echo $button->getMarkup();
?>
<br><hr>

<p class="subTitle">Bouton couleur "brand"</p>
<?php
$button = new \WonderWp\Theme\Child\Components\Button\ButtonComponent();
$button
    ->setLink('/')
    ->setLabel('Valider')
    ->setColor('brand')
;
echo $button->getMarkup();
?>
<br><hr>

<p class="subTitle">Bouton avec flèche</p>
<?php
$button = new \WonderWp\Theme\Child\Components\Button\ButtonComponent();
$button
    ->setLink('/')
    ->setLabel('En savoir plus')
    ->setArrow('true')
;
echo $button->getMarkup();
?>
<br><hr>

<p class="subTitle">Bouton couleur avec flèche</p>
<?php
$button = new \WonderWp\Theme\Child\Components\Button\ButtonComponent();
$button
    ->setLink('/')
    ->setLabel('Valider')
    ->setColor('brand')
    ->setArrow('true')
;
echo $button->getMarkup();
?>
<br><hr>

<p class="subTitle">Bouton modale : ouvre du contenu (lien vers ancre)</p>
<?php
$button = new \WonderWp\Theme\Child\Components\Button\ButtonComponent();
$button
    ->setLink('#wdf-modal')
    ->setLabel('Ouvrir contenu dans modale')
    ->setArrow('false')
    ->setModale(true)
;
echo $button->getMarkup();
?>

<br><hr>

<p class="subTitle">Bouton modale : ouvre le contenu d'une autre page</p>
<?php
$button = new \WonderWp\Theme\Child\Components\Button\ButtonComponent();
$button
    ->setLink('/fr/exemples-de-page/page-exemple/')
    ->setLabel('Ouvrir page dans modale')
    ->setArrow('false')
    ->setModale(true)
;
echo $button->getMarkup();
?>

