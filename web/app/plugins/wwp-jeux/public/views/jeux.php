<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/11/2016
 * Time: 11:47
 */
/* @var $jeux \WonderWp\Plugin\Jeux\JeuxEntity */
?>

<section class="module-jeux">

    <div class="jeux-<?php echo $jeux->getId(); ?>-jeux">
        <?php

        if (!empty($notifications)) {
            echo implode("\n", $notifications);
        }


        if (!empty($jeux->getStartsAt()) && (date('U') < $jeux->getStartsAt()->format('U'))) {
            //Jeux pas encore commence
            echo '<p>' . __('jeux.pas.encore.commence', WWP_JEUX_TEXTDOMAIN) . '</p>';
            echo '<p>' . __('revenez.le ', WWP_JEUX_TEXTDOMAIN) . $jeux->getStartsAt()->format('d/m') . '</p>';
        } elseif (!empty($jeux->getEndsAt()) && date('U') > $jeux->getEndsAt()->format('U')) {
            //Jeux termine
            $gagnants = null;
            if (empty($gagnants)) {
                echo '<p>' . __('jeux.maintenant.termine', WWP_JEUX_TEXTDOMAIN) . '</p>';
                echo '<p>' . __('gagnants.affiche.bientot', WWP_JEUX_TEXTDOMAIN) . '</p>';
            } else {
                //affichage des gagnants
            }
        }
        elseif ($dejaJoue){
            echo '<p>' . __('participation.prise.en.compte', WWP_JEUX_TEXTDOMAIN) . '</p>';
            echo '<p>' . __('gagnants.annonce.par.mail', WWP_JEUX_TEXTDOMAIN) . '</p>';
        }
        else {

            $formView = \WonderWp\DI\Container::getInstance()->offsetGet('wwp.forms.formView');
            $formView->setFormInstance($jeuxForm);

            /** @var \WonderWp\Forms\FormView $formView */
            /*$markup = '';
            $markup .= $formView->formStart([]);
            $markup .= $formView->formErrors();

            $markup .=$formView->formEnd([]);

            echo $markup;*/
            echo $formView->render([]);
        }
        ?>
        <div class="jeux-links">
            <?php if (!empty($jeux->getPageReglement())) {
                echo '<a href="' . get_permalink($jeux->getPageReglement()) . '">' . __('reglement', WWP_JEUX_TEXTDOMAIN) . '</a>';
            } ?>
            <?php if (!empty($jeux->getPageDotation())) {
                echo '<a href="' . get_permalink($jeux->getPageDotation()) . '">' . __('dotations', WWP_JEUX_TEXTDOMAIN) . '</a>';
            } ?>
        </div>
    </div>

</section>
