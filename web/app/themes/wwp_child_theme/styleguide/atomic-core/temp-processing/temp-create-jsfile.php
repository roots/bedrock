<?php
require '../temp-functions/functions.php';



include '../db-inc/dbinc.php';


$compName = $_POST["jsName"];
$catName = $_POST["catVal"];

$key = "has_js";



$jsDir = $settingsArr[0]['js_directory'];
$jsExt = $settingsArr[0]['js_extension'];

$hasJs = "true";


createJsFile($compName, $jsDir, $jsExt);
createJsComment($compName, $settingsArr);







dbUpdateCompJs($compdb, $compName, $hasJs);


header('Location: ../?cat='.$catName.'');




