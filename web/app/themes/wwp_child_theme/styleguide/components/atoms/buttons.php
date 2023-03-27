<!-- components/components/button.php -->
<p class="subTitle">Bouton Gutenberg</p>

<div class="encadre">
    <div class="grid-2 has-gutter-xl">
        <div>
            <p>ATTRIBUTS :</p>
            <ul>
                <li>Label</li>
                <li>Lien</li>
                <li>Couleur (variable)</li>
            </ul>
        </div>
        <div>
            <p>OPTIONS :</p>
            <ul>
                <li>Flèche droite</li>
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

<p class="subTitle">Bouton de avec lien sortant</p>
<?php
$button = new \WonderWp\Theme\Child\Components\Button\ButtonComponent();
$button
    ->setLink('/')
    ->setLabel('Consulter')
    ->setTargetBlank(true)
;
echo $button->getMarkup();
?>
<br><hr>

<p class="subTitle">Bouton couleur "white"</p>
<?php
$button = new \WonderWp\Theme\Child\Components\Button\ButtonComponent();
$button
    ->setLink('/')
    ->setLabel('Valider')
    ->setColor('white')
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

<p class="subTitle">Bouton couleur "white" avec flèche</p>
<?php
$button = new \WonderWp\Theme\Child\Components\Button\ButtonComponent();
$button
    ->setLink('/')
    ->setLabel('En savoir plus')
    ->setColor('white')
    ->setArrow('true')
;
echo $button->getMarkup();
?>
<br><hr>

<p class="subTitle">Bouton modale</p>
<?php
$button = new \WonderWp\Theme\Child\Components\Button\ButtonComponent();
$button
    ->setLink('/')
    ->setLabel('En savoir plus')
    ->setColor('white')
    ->setModale(true)
;
echo $button->getMarkup();
?>
<br><hr>

<p class="subTitle">Boutons Gutenberg natifs (Button)</p>
<div class="is-layout-flex wp-block-buttons">
    <div class="wp-block-button aligncenter">
        <a class="wp-block-button__link wp-element-button" href="https://www.wonderful.fr" target="_blank" rel="noreferrer noopener">Bouton Gutenberg</a>
    </div>
</div>
