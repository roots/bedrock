<?php
/** @var $recette \WonderWp\Plugin\Recette\RecetteEntity */
$locale = get_locale();

$aromeMeta = $recette->getMeta('metas_saveur');
$arome = is_object($aromeMeta) ? get_category($aromeMeta->getVal()) : null;
?>

<?php if (!empty($arome) && !is_wp_error($arome)): ?>

    <?php if ($arome->slug == 'epice'): ?>
        <div class="recettes-animations recettes-epice container-l">
            <div class='sprite-aromes arome-poudre-det'></div>
            <div class='sprite-aromes arome-feuilles'></div>
            <div class='sprite-aromes arome-poivron'></div>
            <div class='sprite-aromes arome-cannelle'></div>
            <div class='sprite-aromes arome-anis'></div>
            <div class='sprite-aromes arome-baies-1'></div>
            <div class='sprite-aromes arome-baies-2'></div>
            <div class='sprite-aromes arome-poivre'></div>
        </div>
    <?php endif; ?>

    <?php if ($arome->slug == 'floral'): ?>
        <div class="recettes-animations recettes-floral container-l">
            <div class='sprite-aromes arome-branche-fleurs'></div>
            <div class='sprite-aromes arome-fleur'></div>
            <div class='sprite-aromes arome-litchis'></div>
            <div class='sprite-aromes arome-tomates'></div>
            <div class='sprite-aromes arome-choco-1'></div>
            <div class='sprite-aromes arome-choco-2'></div>
        </div>
    <?php endif; ?>

    <?php if ($arome->slug == 'fruite'): ?>
        <div class="recettes-animations recettes-fruite container-l">
            <div class='sprite-aromes arome-physalis'></div>
            <div class='sprite-aromes arome-passion'></div>
            <div class='sprite-aromes arome-ananas'></div>
            <div class='sprite-aromes arome-framboise'></div>
            <div class='sprite-aromes arome-raisin'></div>
        </div>
    <?php endif; ?>

    <?php if ($arome->slug == 'vert'): ?>
        <div class="recettes-animations recettes-vert container-l">
            <div class='sprite-aromes arome-persil'></div>
            <div class='sprite-aromes arome-concombre'></div>
            <div class='sprite-aromes arome-langouste'></div>
            <div class='sprite-aromes arome-concombre arome-concombre2'></div>
            <div class='sprite-aromes arome-haricots'></div>
            <div class='sprite-aromes arome-amande'></div>
            <div class='sprite-aromes arome-amande arome-amande2'></div>
        </div>
    <?php endif; ?>

<?php else: ?>

    <div class="recettes-animations recettes-toutes container-l">
        <div class='sprite-aromes arome-persil'></div>
        <div class='sprite-aromes arome-concombre'></div>
        <div class='sprite-aromes arome-amande'></div>
        <div class='sprite-aromes arome-framboise'></div>
        <div class='sprite-aromes arome-anis'></div>
        <div class='sprite-aromes arome-choco-1'></div>
        <div class='sprite-aromes arome-choco-2'></div>
        <div class='sprite-aromes arome-fleur'></div>
        <div class='sprite-aromes arome-poivre'></div>
        <div class='sprite-aromes arome-poivron'></div>
        <div class='sprite-aromes arome-baies-2'></div>
    </div>

<?php endif; ?>

<meta property="og:title" content="Titre de la recette" />
<meta property="og:type" content="website" />
<meta property="og:url" content="url de la page de la recette" />
<meta property="og:image" content="url de l'image de la recette" />
<meta property="og:site_name" content="pomme-pinklady.com" />
<meta property="og:description" content="Tous nos conseils et astuces pour arriver enfin à faire manger des légumes aux enfants  à travers une recette faite pour eux." />
<!--TODO : déplacer les Opengraph dans <head>-->

<div class="module-recette">

    <section class="recipe-content" itemscope itemtype="http://schema.org/Recipe">

        <div class="recipe-presentation container">
            <h1 itemprop="name"><?php echo str_replace('Pink Lady', 'Pink Lady<sup>®</sup>', $recette->getTitle()); ?></h1>
            <div class="recipe-infos-s">

                <div class="rating-small inline" itemprop="aggregateRating" itemscope=""
                     itemtype="http://schema.org/AggregateRating">
                    <?php
                    $ratings = $recette->getRatings();
                    for ($i = 1; $i <= $ratings['average']; $i++) {
                        echo getSvgIcon('star_s', 'active');
                    }
                    for ($j = $i; $j <= 5; $j++) {
                        echo getSvgIcon('star_s', 'inactive');
                    }
                    ?>
                    <meta itemprop="ratingValue" content="<?php echo $ratings['average']; ?>">
                    <meta itemprop="worstRating" content="1">
                    <meta itemprop="bestRating" content="5">
                    <meta itemprop="ratingCount" content="<?php echo $ratings['count']; ?>">
                </div>
                <span class="dish" itemprop="recipeCategory"><?php echo $recette->getCategory(); ?></span>
            </div>

            <div class="recipe-image-block">
                <div class="recipe-image">
                    <?php echo \WonderWp\Medias\Medias::mediaAtSize($recette->getMedia(), 'recette-detail', false, ['itemprop' => 'image']); ?>
                </div>
                <div class="recipe-infos">
                    <?php
                    $difficulteMeta = $recette->getMeta('difficulte');
                    $difficulte = is_object($difficulteMeta) ? $difficulteMeta->getVal() : 0;
                    ?>
                    <div class="difficulty difficulty-<?php echo $difficulte; ?>">
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
                        <div>
                            <span class="value">
                                <strong>
                                    <meta itemprop="prepTime"
                                          content="PT<?php echo $tpsPrepa[0]; ?>M"><?php echo $tpsPrepa[0]; ?>
                                    <?php if (!empty($tpsPrepa[1])): ?><span class="unit"><?php echo $tpsPrepa[1]; ?>
                                        .</span><?php endif; ?>
                                </strong>
                                <br><?php _e('meta.tpsPrepa.trad', WWP_RECETTE_TEXTDOMAIN); ?>
                            </span>
                        </div>
                    </div>

                    <?php
                    $tpsCuissonMeta = $recette->getMeta('tpsCuisson');
                    $tpsCuisson = is_object($tpsCuissonMeta) ? explode(' ', $tpsCuissonMeta->getVal()) : '';
                    ?>
                    <div>
                        <div><span class="value"><strong><meta itemprop="cookTime"
                                                               content="PT<?php echo $tpsCuisson[0]; ?>M"><?php echo $tpsCuisson[0]; ?>
                                    <?php if (!empty($tpsCuisson[1])): ?><span
                                        class="unit"><?php echo $tpsCuisson[1]; ?>.</span><?php endif; ?>
                                </strong><br><?php _e('meta.tpsCuisson.trad', WWP_RECETTE_TEXTDOMAIN); ?></span>
                        </div>
                    </div>


                    <?php //Auteur
                    $auteurMeta = $recette->getMeta('auteur');
                    $auteur = is_object($auteurMeta) ? $auteurMeta->getVal() : '';
                    if (empty($auteur)) {
                        $auteur = 'Pink Lady®';
                    }
                    ?>
                    <meta itemprop="author" content="<?php echo $auteur; ?>">
                </div>
            </div>

            <?php
            $desc = $recette->getDescription();
            if (!empty($desc)): ?>
                <div class="recipe-introduction-text">
                    <p class="chapo" itemprop="description">
                        <?php
                        $limit = 100;
                        $visibleDescPart = strlen($desc) > $limit ?
                            '<span>' . substr($desc, 0, $limit) . '</span><span class="readmore-content">' . substr($desc, $limit, strlen($desc)) . '</span><a class="readmore" data-readless="' . __('read.less', WWP_THEME_TEXTDOMAIN) . '" href="#">' . __('read.more', WWP_THEME_TEXTDOMAIN) . '</a>' :
                            $desc;
                        echo $visibleDescPart;
                        ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <div class="recipe-preparation">

            <?php echo \WonderWp\Medias\Medias::mediaAtSize($recette->getMedia(), 'recette-detail', false, ['class' => 'recipe-preparation-image']); ?>

            <?php
            $etapes = $recette->getEtapes();

            if (!empty($etapes)) {
                $tabsComponent = new \WonderWp\Theme\Components\TabsComponent();
                foreach ($etapes as $etape) {
                    /** @var $etape \WonderWp\Plugin\Recette\RecetteEtape */

                    $thisEtapeIngredients = $etape->getEtapeIngredients();
                    $instructions = explode("\n", $etape->getContent());

                    $colContent = '
                    <div class="etape-inner">
                        <div class="ingredients">
                            <p class="title ingredient-title">' . getSvgIcon('ingredient') . ' ' . __('ingredients.trad', WWP_RECETTE_TEXTDOMAIN) . '</p>
                            <ul>';
                    if (!empty($thisEtapeIngredients)) {
                        foreach ($thisEtapeIngredients as $etapeIngredient) {
                            /** @var $etapeIngredient \WonderWp\Plugin\Recette\EtapeIngredient */
                            /** @var $ingredient \WonderWp\Plugin\Recette\Ingredient */
                            $ingredient = $etapeIngredient->getIngredient();
                            if (!empty($ingredient)) {
                                try {
                                    $trad = $ingredient->getTranslation($locale);
                                    $qty = $etapeIngredient->getQty();
                                    $unitCat = get_category($etapeIngredient->getUnit());
                                    $unitTrad = !is_wp_error($unitCat) ? __('term_' . $unitCat->slug, WWP_RECETTE_TEXTDOMAIN) : null;
                                    if (!empty($trad)) {
                                        $colContent .= '<li><span itemprop="recipeIngredient">' . ($qty > 0 ? $qty : '') . ' ' . $unitTrad . ' ' . $trad->getTitle() . '</span></li>';
                                    }
                                } catch (\Doctrine\ORM\EntityNotFoundException $nf) {

                                }
                            }
                        }
                    }
                    $colContent .= '                            
                        </ul>
                    </div>
                    <div class="preparation">
                        <p class="title preparation-title">' . getSvgIcon('preparation') . ' ' . __('preparation.trad', WWP_RECETTE_TEXTDOMAIN) . '</p>
                        <ol itemprop="recipeInstructions">
                            <li>' . implode('</li><li>', $instructions) . '</li>
                        </ol>
                    </div>  
                  </div>';
                    $tabsComponent->addBlock($etape->getTitle(), $colContent);
                }
                echo $tabsComponent->getMarkup(['class' => ['recipes-tabs container-l']]);
            }

            ?>

        </div> <!--end for .recipe-preparation-->

        <div class="recipe-tips container">

            <?php
            $astuceMeta = $recette->getMeta('astuce');
            if (is_object($astuceMeta) && !empty($astuceMeta->getVal())): ?>
                <div class="recipe-tips-intro">
                    <div class="container-s">
                        <h2><?php echo getSvgIcon("tips"); ?>
                            <br><?php _e('meta.astuce.trad', WWP_RECETTE_TEXTDOMAIN); ?>
                        </h2>
                        <p class="chapo"><?php echo $astuceMeta->getVal(); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="recipe-rate">
                <div class="add-rate">
                    <?php echo getSvgIcon("arrow_down"); ?>
                    <p class="title"><?php _e('give.note', WWP_RECETTE_TEXTDOMAIN); ?></p>
                    [wwpmodule slug='wwp-vote' entityname='<?php echo \WonderWp\Plugin\Recette\RecetteEntity::class ?>'
                    entityid='<?php echo $recette->getId(); ?>' ]
                </div>

                <?php $comments = $recette->getComments(); ?>
                <div class="add-comment">
                    <p class="title"><?php _e('share.tips', WWP_RECETTE_TEXTDOMAIN); ?></p>
                    <div class="link-large">
                        <a href="#"><?php _e('i.leave.review', WWP_RECETTE_TEXTDOMAIN); ?></a>
                        <a href="#"><?php _e('see.other.reviews', WWP_RECETTE_TEXTDOMAIN); ?></a>
                    </div>
                </div>

                <ul class="recipe-comment-list container-s">
                    <?php
                    $commentArgs = [];
                    wp_list_comments($commentArgs, $comments);
                    ?>
                </ul>
            </div>

        </div> <!--end for .recipe-tips-->


    </section> <!--end for .section-content-->


    <section class="block-share-and-news">

        <div class="container">
            <div class="grid-2">
                <div class="social-share">
                    <p class="title"><?php _e('recipe.share.with.trad', WWP_RECETTE_TEXTDOMAIN); ?></p>

                    <?php
                    $socialShareComponent = new \WonderWp\Theme\Components\SocialShareComponent();
                    echo $socialShareComponent->getMarkup([
                        'title' => $recette->getTitle()
                    ]);
                    ?>
                    <a class="share-social-networks" href="#">
                        <svg class="shape-svg shape-sharesocial ">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                 xlink:href="/app/themes/pinklady2016/assets/final/svg/symbol/svg/sprite.symbol.svg#sharesocial"></use>
                        </svg>
                        <span>Partager sur les réseaux sociaux</span></a>
                </div>
                <div class="block-newsletter">
                    <p class="title">Une idée recette chaque mois <br> <strong>en vous inscrivant à la
                            newsletter</strong>
                    </p>
                    [wwpmodule slug='wwp-newsletter' list="ba3cc1db0b"]
                </div>
            </div>
        </div>

    </section>

    <?php
    if (!empty($otherRecipes)): ?>

        <section class="recipe-more">
            <div class="recipe-more-wrapper container">
                <div class="recipe-more-container">
                    <h2><?php _e('find.inspiration.other.recipes', WWP_RECETTE_TEXTDOMAIN); ?></h2>
                    <ul class="recipe-list grid-3 has-gutter-xl">
                        <?php
                        foreach ($otherRecipes as $recipe) {
                            /** @var $recipe \WonderWp\Plugin\Recette\RecetteEntity */
                            $card = new \WonderWp\Theme\Components\RecipeCardComponent();
                            $cardRatings = $recipe->getRatings();
                            $card
                                ->setImage($recipe->getMedia())
                                ->setTitle($recipe->getTitle())
                                ->setLink($card->formatLink())
                                ->setRating($cardRatings['average'])
                                ->setCategory($recipe->getCategory());
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

</div>