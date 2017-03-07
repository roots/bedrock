<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 21/09/2016
 * Time: 16:57
 */
?>
<section class="module-vote">

    <?php if (!empty($notifications)) {
        echo implode("\n", $notifications);
    } ?>

    <?php echo $formView; ?>

    <?php if (!empty($nbVotes)): ?>
        <span class="nbVotes"><?php echo $nbVotes . ' ' . __('nbVotes', WWP_VOTE_TEXTDOMAIN); ?></span>
    <?php endif; ?>

</section>