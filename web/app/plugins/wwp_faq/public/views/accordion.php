<section class="module-faq">
    <?php
    if (!empty($questions)) {
        $accordion = new \WonderWp\Theme\Components\AccordionComponent();
        foreach ($questions as $q) {
            /** @var $q \WonderWp\Plugin\Faq\FaqEntity */
            $accordion->addBlock($q->getTitle(),$q->getContent());
        }
        echo $accordion->getMarkup();
    }
    ?>
</section>
