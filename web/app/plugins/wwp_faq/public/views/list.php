<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 02/09/2016
 * Time: 11:55
 */
?>
<section class="module-faq">
    <?php
    if (!empty($questions)):?>
        <ul>
            <?php
            /** @var \WonderWp\Plugin\Faq\FaqEntity $q */
            foreach ($questions as $q) { ?>
                <li id="<?php echo sanitize_title($q->getTitle()); ?>">
                    <h3><?php echo $q->getTitle() ;?></h3>
                    <p><?php echo $q->getContent(); ?></p>
                </li>
            <?php } ?>
        </ul>
    <?php endif; ?>
</section>
