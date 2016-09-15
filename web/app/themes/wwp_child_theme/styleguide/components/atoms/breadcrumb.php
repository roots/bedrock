<!--components/atoms/breadcrumb.php-->
<!-- This markup is generated, do not write by hand. Open this file to check how it works -->
<?php
$breadCrumb = new \WonderWp\Theme\Components\BreadCrumbComponent();
echo $breadCrumb->setCrumbs([
        ['title' => 'Home', 'href' => '#'],
        ['title' => 'Category', 'href' => '#'],
        ['title' => 'Page', 'href' => '']
    ]
)->getMarkup();

?>