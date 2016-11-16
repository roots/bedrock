<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/11/2016
 * Time: 11:26
 */
/* @var $jeux \WonderWp\Plugin\Jeux\JeuxEntity */
?>
<section class="module-jeux">

    <div class="jeux-<?php echo $jeux->getId(); ?>-presentation">
        <div class="text-block">
            <h2><?php echo $jeux->getTitre(); ?></h2>

            <?php if(!empty($jeux->getStartsAt()) && !empty($jeux->getEndsAt())): ?>
                <strong><?php echo __('du',WWP_JEUX_TEXTDOMAIN).' '.$jeux->getStartsAt()->format('d/m/y').' '.__('au',WWP_JEUX_TEXTDOMAIN). ' '.$jeux->getEndsAt()->format('d/m/y'); ?></strong>
            <?php endif; ?>

            <?php if(!empty($jeux->getContenu())): ?>
                <p><?php echo $jeux->getContenu(); ?></p>
            <?php endif; ?>

            <?php if(!empty($jeux->getPageJeux())): ?>
                <a class="btn btn-secondary btn-icon" href="<?php echo get_permalink($jeux->getPageJeux()); ?>"><?php echo __('je.tente.ma.chance',WWP_JEUX_TEXTDOMAIN); ?></a>
            <?php endif; ?>
        </div>

        <?php if(!empty($jeux->getVisuel())): ?>
        <div class="image-block">
            <?php echo \WonderWp\Medias\Medias::mediaAtSize($jeux->getVisuel(),'thumbnail'); ?>
        </div>
        <?php endif; ?>
    </div>

</section