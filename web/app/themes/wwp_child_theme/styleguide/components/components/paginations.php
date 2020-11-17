<!-- components/components/paginations.php -->
<?php
$container = \WonderWp\Component\DependencyInjection\Container::getInstance();
$paginationComponent = $container['wwp.theme.component.pagination'];
echo $paginationComponent->getMarkup([
    'nbObjects'      => 100,
    'perPage'        => 5,
    'paginationUrl'  => '/',
    'currentPage'    => 8,
    'paginationSize' => 3,
]);
?>
