<?php
$module_info = array(
	'base'         => 'albumsListMasonry',
	'name'         => 'albumsListMasonry',
	'title'        => 'AlbumsList Masonry',
	'version'      => '1.4.1',
	'author'       => 'GalleryCreator',
	'description'  => 'Show your albums, categories and tags as grid. When you click on the collection it will be expanded to show all contained images. Responsive and mobile friendly • Working in all major browsers • Photo EXIF information • Easy sorting system • Simple to Use.
 Ajax based, no dependecies from other JS libraries. Fast, customizible and flexible.',
	'type'         => 'gallery',
	'branch'       => '1',
	'status'       => 'premium',
	'price'        => '$20',
	'demo'         => 'https://codeasily.com/portfolio/gmedia-gallery-modules/albumslist-masonry/',
	'download'     => 'https://codeasily.com/download/albumslist-masonry/',
	'dependencies' => ''
);
if (preg_match('#' . basename(dirname(__FILE__)) . '/' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
	if (isset($_GET['info'])) {
		echo '<pre>' . print_r($module_info, true) . '</pre>';
	} else {
		header("Location: {$module_info['demo']}");
		die();
	}
}