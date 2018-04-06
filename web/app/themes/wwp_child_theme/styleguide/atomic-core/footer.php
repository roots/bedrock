<?php
$final_path_dir = get_stylesheet_directory().'/assets/final';
$final_path_uri = get_stylesheet_directory_uri().'/assets/final';

$version = include($final_path_dir.'/version.php');

?>

<script src="<?= $final_path_uri . "/js/vendor". $version; ?>.js"></script>
<script src="<?= $final_path_uri . "/js/core". $version; ?>.js"></script>
<script src="<?= $final_path_uri . "/js/atomic". $version; ?>.js"></script>
<script src="<?= $final_path_uri . "/js/bootstrap". $version; ?>.js"></script>

<?php
$filename = '../atomic-foot.php';
if (file_exists($filename)) {
    include ("../atomic-foot.php");
}
?>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>-->
<script src="atomic-core/zero/ZeroClipboard.js"></script>



</body>
</html>
