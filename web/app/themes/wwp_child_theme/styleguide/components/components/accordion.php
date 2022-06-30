<!-- components/components/accordion.php -->
<?php

use WonderWp\Theme\Child\Components\Accordion\AccordionComponent;
use WonderWp\Plugin\GutenbergUtils\Bloc\AccordionBlock\AccordionRow;

$accordionComponent = new AccordionComponent();
for ($i = 1; $i <= 5; $i++) {
    $accordionComponent->addBlock(new AccordionRow('tab ' . $i, 'Content of tab ' . $i));
}
echo $accordionComponent->getMarkup();
?>
