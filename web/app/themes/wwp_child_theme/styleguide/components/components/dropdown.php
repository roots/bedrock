<!-- components/components/dropdown.php -->

<?php

$dropdown = new \WonderWp\Theme\Child\Components\Dropdown\DropdownComponent();

$dropdown
    ->setClass('custom-class')
    ->setLabel('Survolez ce texte pour faire apparaître le contenu')
    ->setSubComponents('<h3>Titre du contenu masqué</h3><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>')
    ;

echo $dropdown->getMarkup();
