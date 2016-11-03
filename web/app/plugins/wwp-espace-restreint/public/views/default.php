<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 02/11/2016
 * Time: 18:10
 */
?>
<section class="module-er">

    <?php if (!empty($notifications)) {
        echo implode("\n", $notifications);
    } ?>

    <?php echo $formView; ?>

    <div class="links-wrap">
        <?php if(!empty($registerUrl)): ?><a href="<?php echo $registerUrl; ?>"><?php echo __('dont_have_an_account', WWP_ER_TEXTDOMAIN); ?></a><?php endif; ?>
        <?php if(!empty($forgotPwdUrl)): ?><a href="<?php echo $forgotPwdUrl; ?>"><?php echo __('forgot_pwd', WWP_ER_TEXTDOMAIN); ?></a><?php endif; ?>
        <?php if(!empty($loginUrl)): ?><a href="<?php echo $loginUrl; ?>"><?php echo __('login', WWP_ER_TEXTDOMAIN); ?></a><?php endif; ?>
    </div>


</section>