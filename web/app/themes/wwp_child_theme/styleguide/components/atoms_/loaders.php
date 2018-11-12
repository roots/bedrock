<!-- components/atoms_/loaders.php -->


<span class="subTitle">Simple spinner</span>

<?php
$loaderComp = new \WonderWp\Theme\Child\Components\Loader\Loadercomponent();

//way to render one tpl:
//echo $loaderComp->getMarkup(['tpl' => "loader"]);

$loadersTemplates = $loaderComp->getTemplates();
if(!empty($loadersTemplates)){ foreach($loadersTemplates as $tplName=>$loaderTemplate){
    echo $loaderTemplate;
} }

?>

<hr>
<span class="subTitle">Bouton + spinner</span>

<button class="btn button-loader" type="button">
    Bouton
</button>

<hr>
<p>Ajoute un spinner sur le bouton du formulaire quand la slasse "loading" "loading" est ajoutée sur la balise "form"</p>
<form action="" class="loading">
    <button class="btn" type="button">
        Bouton avec loader
    </button>
</form>
