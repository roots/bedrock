<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 12:19
 */
?>
<section class="module-recetteList">


    <?php if (!empty($arome)): ?>

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

    <div class="recipes-filter">
        <div class="hideWhenFiltersOpened">
            <div class="category-dish">
                <?php
                $recap = [];
                if (!empty($arome)) {
                    $recap[] = '<span class="category">' . __('term_' . $arome->slug, WWP_RECETTE_TEXTDOMAIN) . '</span>';
                }
                if (!empty($typePlat)) {
                    $recap[] = '<span class="dish">' . __('term_' . $typePlat->slug, WWP_RECETTE_TEXTDOMAIN) . '</span>';
                }
                if (!empty($instant)) {
                    $recap[] = '<span class="instant">' . __('term_' . $instant->slug, WWP_RECETTE_TEXTDOMAIN) . '</span>';
                }
                if (!empty($recap)) {
                    echo implode(' - ', $recap);
                }
                ?>
            </div>
            <div class="result"><span
                    class="value"><?php echo $count; ?></span> <?php _e('result', WWP_RECETTE_TEXTDOMAIN) ?> </div>
            <button class="btn btn-white filters-toggler"><?php _e('refine_search', WWP_RECETTE_TEXTDOMAIN); ?></button>
            <div class="container">
                <a href="/recette/resetfilters/<?php echo get_the_ID(); ?>"
                   class="reset-filter no-barba"><?php _e('reset_filters', WWP_RECETTE_TEXTDOMAIN); ?></a>
            </div>
        </div>

        <div class="recipes-filter-open">
            <?php echo $filtres; ?>
            <button class="modaal-close filters-toggler"><?php _e('close_filters', WWP_RECETTE_TEXTDOMAIN); ?></button>
            <a href="/recette/resetfilters/<?php echo get_the_ID(); ?>"
               class="reset-filter no-barba"><?php _e('reset_filters', WWP_RECETTE_TEXTDOMAIN); ?></a>
        </div>
    </div>
    <div class="container">
        <?php
        if (!empty($recettes)) {
            echo '<ul class="recipe-list grid-3 has-gutter-xl">';
            foreach ($recettes as $recette) {
                /** @var $recette \WonderWp\Plugin\Recette\RecetteEntity */
                $card = new \WonderWp\Theme\Components\RecipeCardComponent();
                $ratings = $recette->getRatings();
                $card
                    ->setImage($recette->getMedia())
                    ->setTitle($recette->getTitle())
                    ->setLink($card->formatLink())
                    ->setRating($ratings['average'])
                    ->setCategory($recette->getCategory());
                echo $card->getMarkup();

            }
            echo '</ul>';
            if(!empty($paginationMarkup)){
                echo $paginationMarkup;
            }
        }
        ?>
    </div>
</section>