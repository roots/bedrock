<!--components/components/cookies.php-->
<?php
/** @var \WonderWp\Theme\ThemeViewService $viewService */
$viewService = \wwp_get_theme_service(\WonderWp\APlugin\AbstractManager::$VIEWSERVICENAME);
if(is_object($viewService)){
    echo $viewService->getBandeauCookie(true);
}
?>


<script src="js/components/cookies.js"></script>