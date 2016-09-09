<!--components/components/cookies.php-->
<?php
/** @var \WonderWp\Theme\ThemeViewService $viewService */
$viewService = \wwp_get_theme_service(\WonderWp\Services\AbstractService::$VIEWSERVICENAME);
if(is_object($viewService)){
    echo $viewService->getBandeauCookie(true);
}
?>