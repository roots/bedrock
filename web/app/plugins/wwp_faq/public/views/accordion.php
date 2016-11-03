<section class="module-faq">
    <?php
    if (!empty($questions)) {
        $accordion = new \WonderWp\Theme\Components\AccordionComponent();
        $cpt = 1;
        foreach ($questions as $q) {
            /** @var $q \WonderWp\Plugin\Faq\FaqEntity */
            $title = '<span class="counter">'.$cpt.' •</span>'.$q->getTitle();
            $accordion->addBlock($title,$q->getContent());
            $cpt++;
        }
        echo $accordion->getMarkup();
    }
    ?>
</section>
