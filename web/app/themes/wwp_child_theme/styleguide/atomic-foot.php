<!-- Place any footer info you would like shared between the styleguide and the root of your project. Eg. Links to js scripts etc.. -->


<script src="js/min/main.js"></script>
<!-- Place any footer info you would like shared between the styleguide and the root of your project. Eg. Links to js scripts etc.. -->

<script>window.wonderwp = window.wonderwp || {};</script>

<?php
$final_path_dir = get_stylesheet_directory().'/assets/final';
$final_path_uri = get_stylesheet_directory_uri().'/assets/final';

$version = include($final_path_dir.'/version.php');

if(defined('FRONT_ENV') && FRONT_ENV==='webpack') {
    ?>
    <script src="<?= $final_path_uri . "/js/vendor". $version; ?>.js"></script>
    <script src="<?= $final_path_uri . "/js/core". $version; ?>.js"></script>
    <script src="<?= $final_path_uri . "/js/styleguide". $version; ?>.js"></script>
    <script src="<?= $final_path_uri . "/js/bootstrap". $version; ?>.js"></script>
    <?php
} else {
    ?>
    <script src="<?= $final_path_uri . "/js/app". $version; ?>.js"></script>
    <?php
}
?>
