<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/11/2016
 * Time: 14:35
 */
/* @var $jeux \WonderWp\Plugin\Jeux\JeuxEntity */
?>

<section class="module-jeux">

    <div class="jeux-<?php echo $jeux->getId(); ?>-lots">

        <?php
        $lots = $jeux->getLots();
        if(!empty($lots)){ foreach ($lots as $lot){
            /** @var $lot \WonderWp\Plugin\Jeux\JeuxLot */
            if($lot->getIsActive()) :?>
            <div class="jeux-lot">
                <?php if(!empty($lot->getVisuel())){ echo \WonderWp\Medias\Medias::mediaAtSize($lot->getVisuel(),'thumbnail'); } ?>
                <h3><?php echo $lot->getTitre(); ?></h3>
                <?php if(!empty($lot->getContenu())){ echo'<p>'.$lot->getContenu().'</p>'; } ?>
            </div>
            <?php
            endif;
        }}
        ?>

        <div class="jeux-links">
            <?php if(!empty($jeux->getPageJeux())){
                echo'<a href="'.get_permalink($jeux->getPageJeux()).'">'.__('je.tente.ma.chance',WWP_JEUX_TEXTDOMAIN).'</a>';
            } ?>
            <?php if(!empty($jeux->getPageReglement())){
                echo'<a href="'.get_permalink($jeux->getPageReglement()).'">'.__('reglement',WWP_JEUX_TEXTDOMAIN).'</a>';
            } ?>
        </div>

    </div>

</section>
