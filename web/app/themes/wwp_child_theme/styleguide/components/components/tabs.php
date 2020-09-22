<!-- components/components/tabs.php -->

<?php

$tabComponent = new \WonderWp\Theme\Child\Components\Tabs\TabsComponent();

$tabComponent->addTab('Premier onglet', 'Contenu du premier onglet : Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ','testida','testclassa');
$tabComponent->addTab('Deuxième onglet', 'Contenu du deuxième onglet : Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ','testidb','testclassb');

echo $tabComponent->getMarkup();
