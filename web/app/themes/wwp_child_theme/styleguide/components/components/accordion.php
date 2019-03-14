<!-- components/components/accordion.php -->
<?php
$accordionComponent = new \WonderWp\Theme\Child\Components\Accordion\AccordionComponent();
for ($i = 1; $i <= 5; $i++) {
    $accordionComponent->addBlock('tab ' . $i, 'Content of tab ' . $i);
}
echo $accordionComponent->getMarkup();
?>
