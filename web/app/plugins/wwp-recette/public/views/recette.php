<?php
/** @var $recette \WonderWp\Plugin\Recette\RecetteEntity */
$locale = get_locale();
?>
<div class="bg-fullimage bg-recipe-spicy"></div>

<section class="recipe-content">

    <div class="recipe-presentation container">
        <h1><?php echo $recette->getTitle(); ?></h1>
        <div class="recipe-infos-s">

            <span class="rating-small inline">
            <?php
            $ratings = $recette->getRatings();
            for ($i = 1; $i <= $ratings; $i++) {
                echo getSvgIcon('star_s', 'active');
            }
            for ($j = $i; $j <= 5; $j++) {
                echo getSvgIcon('star_s', 'inactive');
            }
            ?>
            </span><span class="dish"><?php echo $recette->getCategory(); ?></span>
        </div>

        <div class="recipe-image-block row">
            <div class="recipe-image col">
                <img src="<?php echo $recette->getMedia() ?>" alt="smoothie-bowl-pomme" width="667" height="384"
                     class="col size-full wp-image-150"/>
            </div>
            <div class="recipe-infos col">
                <?php
                $difficulteMeta = $recette->getMeta('difficulte');
                $difficulte = is_object($difficulteMeta) ? $difficulteMeta->getVal() : 0;
                ?>
                <div>
                    <div><span
                            class="value"><strong><?php echo $difficulte; ?></strong><br><?php _e('meta.difficulte.trad', WWP_RECETTE_TEXTDOMAIN); ?></span>
                    </div>
                </div>

                <?php
                $nbPersMeta = $recette->getMeta('nbPers');
                $nbPers = is_object($nbPersMeta) ? $nbPersMeta->getVal() : '';
                ?>
                <div>
                    <div><span
                            class="value"><strong><?php echo $nbPers; ?></strong><br><?php _e('meta.nbPers.trad', WWP_RECETTE_TEXTDOMAIN); ?></span>
                    </div>
                </div>

                <?php
                $tpsPrepaMeta = $recette->getMeta('tpsPrepa');
                $tpsPrepa = is_object($tpsPrepaMeta) ? explode(' ', $tpsPrepaMeta->getVal()) : '';
                ?>
                <div>
                    <div><span class="value"><strong><?php echo $tpsPrepa[0]; ?><span
                                    class="unit"><?php echo $tpsPrepa[1]; ?>
                                    .</span></strong><br><?php _e('meta.tpsPrepa.trad', WWP_RECETTE_TEXTDOMAIN); ?></span>
                    </div>
                </div>

                <?php
                $tpsCuissonMeta = $recette->getMeta('tpsCuisson');
                $tpsCuisson = is_object($tpsCuissonMeta) ? explode(' ', $tpsCuissonMeta->getVal()) : '';
                ?>
                <div>
                    <div><span class="value"><strong><?php echo $tpsCuisson[0]; ?><span
                                    class="unit"><?php echo $tpsCuisson[1]; ?>
                                    .</span></strong><br><?php _e('meta.tpsCuisson.trad', WWP_RECETTE_TEXTDOMAIN); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="recipe-introduction-text">
            <p class="chapo"><?php echo $recette->getDescription(); ?></p>
        </div>
    </div>

    <div class="recipe-preparation">
        <div class="container-l">
            <img class="recipe-preparation-image" src="<?php echo $recette->getMedia(); ?>" alt="smoothie-bowl-pomme"
                 width="667" height="384" class="col size-full wp-image-150"/>

            <?php
            $etapes = $recette->getEtapes();

            if (!empty($etapes)) {
                $tabsComponent = new \WonderWp\Theme\Components\TabsComponent();
                foreach ($etapes as $etape) {
                    /** @var $etape \WonderWp\Plugin\Recette\RecetteEtape */

                    $ingredients = $etape->getIngredients();
                    $instructions = explode("\n", $etape->getContent());

                    $colContent = '<div class="col w30">
                        <p class="title ingredient-title">' . getSvgIcon('ingredient') . ' ' . __('ingredients.trad', WWP_RECETTE_TEXTDOMAIN) . '</p>
                        <ul>';
                    if (!empty($ingredients)) {
                        foreach ($ingredients as $ingredient) {
                            /** @var $ingredient \WonderWp\Plugin\Recette\Ingredient */
                            $translations = $ingredient->getTranslations();
                            if(!empty($translations)) {
                                $trad = $translations->filter(function($item) use ($locale){
                                    return $item->getLocale() == $locale;
                                })->first();
                                if(!empty($trad)) {
                                    $colContent .= '<li>' . $trad->getTitle() . '</li>';
                                }
                            }
                        }
                    }
                    $colContent .= '                            
                        </ul>
                    </div>
                    <div class="col">
                        <p class="title preparation-title">' . getSvgIcon('preparation') . ' ' . __('preparation.trad', WWP_RECETTE_TEXTDOMAIN) . '</p>
                        <ol>
                            <li>' . implode('</li><li>', $instructions) . '</li>
                        </ol>
                    </div>                    ';
                    $tabsComponent->addBlock($etape->getTitle(), $colContent);
                }
                echo $tabsComponent->getMarkup(['class' => ['row']]);
            }

            ?>

        </div> <!--end for .container-->
    </div> <!--end for .recipe-preparation-->

    <div class="recipe-tips container">
        <div class="recipe-tips-intro">
            <div class="container-s">
                <?php
                $astuceMeta = $recette->getMeta('astuce');
                if (is_object($astuceMeta)): ?>
                    <h2><?php echo getSvgIcon("tips"); ?><br><?php _e('meta.astuce.trad', WWP_RECETTE_TEXTDOMAIN); ?>
                    </h2>
                    <p class="chapo"><?php echo $astuceMeta->getVal(); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="recipe-rate">
            <div class="add-rate">
                <?php echo getSvgIcon("arrow_down"); ?>
                <p class="title"><?php _e('give.note', WWP_RECETTE_TEXTDOMAIN); ?></p>
                [wwpmodule slug='wwp-vote' entityname='<?php echo \WonderWp\Plugin\Recette\RecetteEntity::class ?>' entityid='<?php echo $recette->getId() ; ?>'  ]
            </div>

            <?php $comments = $recette->getComments(); ?>
            <div class="add-comment">
                <p class="title"><?php _e('share.tips',WWP_RECETTE_TEXTDOMAIN); ?></p>
                <div class="link-large">
                    <a href="#"><?php _e('i.leave.review',WWP_RECETTE_TEXTDOMAIN); ?></a>
                    <a href="#"><?php _e('see.other.reviews',WWP_RECETTE_TEXTDOMAIN); ?></a>
                </div>
            </div>

            <ul class="recipe-comment-list container-s">
                <?php
                $commentArgs = [];
                wp_list_comments($commentArgs,$comments);
                ?>
            </ul>
        </div>

    </div> <!--end for .recipe-tips-->


</section> <!--end for .section-content-->


<section class="recipe-share">
    <h2><?php _e('share.with.close',WWP_RECETTE_TEXTDOMAIN); ?></h2>

</section>

<?php
if(!empty($otherRecipes)): ?>

<section class="recipe-more">
    <div class="recipe-more-wrapper container-l">
        <div class="recipe-more-container">
            <h2><?php _e('find.inspiration.other.recipes',WWP_RECETTE_TEXTDOMAIN); ?></h2>
            <ul class="recipe-list grid-4">
                <?php
                 foreach($otherRecipes as $recipe){
                    /** @var $recipe \WonderWp\Plugin\Recette\RecetteEntity*/
                    $card = new \WonderWp\Theme\Components\RecipeCardComponent();
                    $card
                        ->setImage($recipe->getMedia())
                        ->setTitle($recipe->getTitle())
                        ->setLink($card->formatLink())
                        ->setRating($recipe->getRatings())
                        ->setCategory($recipe->getCategory())
                    ;
                    echo $card->getMarkup();
                }
                ?>

            </ul>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="recipe-instant container">
    <h2>A ne pas rater : <br><span>L’INSTANT PINK LADY® ASSOCIÉ À CETTE RECETTE !</span></h2>
</section>