<!-- components/components/tabs.php -->

<?php

$tabComponent = new \WonderWp\Theme\Child\Components\Tabs\TabsComponent();
//$tabs->addBlock('test', 'content');

/*

$tabs[] = $tab;

$tabComponent->tabItems = $tabComponent->;*/

$tabComponent->addTab('Tab avec dropdown 1', '[dropdown class="dropdown"]', 'dropdown');
$tabComponent->addTab('Tab avec dropdown 2', 'Some regular content');

echo $tabComponent->getMarkup();
