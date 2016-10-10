<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 12:19
 */
?>
<section class="module-recette">
    <?php
    if (!empty($recettes)) {
        echo'<ul class="recipe-list grid-4">';
        foreach ($recettes as $recette) {
            /** @var $recette \WonderWp\Plugin\Recette\RecetteEntity*/
            $card = new \WonderWp\Theme\Components\RecipeCardComponent();
            $card
                ->setImage($recette->getMedia())
                ->setTitle($recette->getTitle())
                ->setLink($card->formatLink())
                ->setRating($recette->getRatings())
                ->setCategory($recette->getCategory())
                ;
            echo $card->getMarkup();

        }
        echo '</ul>';
    }
    ?>
</section>