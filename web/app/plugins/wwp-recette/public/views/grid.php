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
        $gridComponent = new \WonderWp\Theme\Components\GridComponent();
        foreach ($recettes as $recette) {
            /** @var $recette \WonderWp\Plugin\Recette\RecetteEntity*/
            echo'<br />'.$recette->getTitle();
            $card = new \WonderWp\Theme\Components\CardComponent();
            $card
                ->setImage($recette->getMedia())
                ->setTitle($recette->getTitle())
                ;
            $gridComponent->addCard($card);
        }
        echo $gridComponent->getMarkup();
    }
    ?>
</section>