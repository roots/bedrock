<!-- Place any footer info you would like shared between the styleguide and the root of your project. Eg. Links to js scripts etc.. -->

<script>window.wonderwp = window.wonderwp || {};</script>

<?php
// TODO : check how to load appXXXX.js on ES5 versions
$final_path_dir = get_stylesheet_directory().'/assets/final';
$final_path_uri = get_stylesheet_directory_uri().'/assets/final';

$version = include($final_path_dir.'/version.php');
?>

<script src="<?= $final_path_uri . '/js/vendor'. $version; ?>.js"></script>
<script src="<?= $final_path_uri . "/js/core". $version; ?>.js"></script>
<script src="<?= $final_path_uri . "/js/styleguide". $version; ?>.js"></script>
<script src="<?= $final_path_uri . "/js/plugins". $version; ?>.js"></script>
<script src="<?= $final_path_uri . "/js/bootstrap". $version; ?>.js"></script>

