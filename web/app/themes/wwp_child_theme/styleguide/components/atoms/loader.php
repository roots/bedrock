<!--components/atoms/loader.php-->

<span class="subTitle">Simple spinner</span>

<?php
$loaderComp = new \WonderWp\Theme\Components\Loadercomponent();

//way to render one tpl:
//echo $loaderComp->getMarkup(['tpl' => "loader"]);

$loadersTemplates = $loaderComp->getTemplates();
if(!empty($loadersTemplates)){ foreach($loadersTemplates as $tplName=>$loaderTemplate){
    echo $loaderTemplate;
} }

?>

<hr>
<span class="subTitle">Button + spinner</span>

<button class="btn btn-secondary button-loader" type="button">
    Bouton
</button>

<hr>
<span class="subTitle">Add spinner on button form, when class "loading" is added to form tag</span>
<form action="" class="loading">
    <button class="btn btn-secondary" type="button">
        Bouton avec loader
    </button>
</form>
