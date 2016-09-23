<section class="module-newsletter">

    <?php if(!empty($formTitle)): ?>
    <h3><?php echo $formTitle; ?></h3>
    <?php endif; ?>

    <?php if(!empty($notifications)){ echo implode("\n",$notifications); } ?>

    <?php echo $formView; ?>


</section>