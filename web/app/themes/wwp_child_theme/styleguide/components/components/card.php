<!-- components/components/card.php -->
<p class="subTitle">Bloc de contenu polyvalent</p>

<div class="encadre">
    <div class="grid-2 has-gutter-xl">
        <div>
            <p>ATTRIBUTS :</p>
            <ul>
                <li>title</li>
                <li>text</li>
                <li>img</li>
                <li>link</li>
                <li>button</li>
                <li>color</li>
                <li>background</li>
                <li>class</li>
            </ul>
        </div>
        <div>
            <p>OPTIONS :</p>
            <ul>
                <li>reverse</li>
                <li>landscape</li>
            </ul>
        </div>
    </div>
</div>

<div class="grid-2 has-gutter-l">

    <?php

    echo '<div>
        <p class="subTitle">Sans option</p>';
        $card1 = new \WonderWp\Theme\Child\Components\Card\CardComponent();
        $card1
            ->setTitle('Lorem ipsum dolor consectetur')
            ->setContent('Lorem ipsum dolor, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.')
            ->setImage('<img src="https://via.placeholder.com/150" alt="">')
            ->setLink('/vers-une-page')
            ->setDate('12 septembre 2020')
            /*->setCategories('')*/
        ;
        echo $card1->getMarkup();
    echo '</div>';
    echo '<div class="reverse-inside">
        <p class="subTitle">Avec option "reverse"</p>';
        $card2 = new \WonderWp\Theme\Child\Components\Card\CardComponent();
        $card2
            ->setTitle('Lorem ipsum dolor consectetur')
            ->setContent('Lorem ipsum dolor, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.')
            ->setImage('<img src="https://via.placeholder.com/150" alt="">')
            ->setLink('/vers-une-page')
            ->setDate('12 septembre 2020')
            /*->setCategories('')*/
        ;
        echo $card2->getMarkup();
    echo '</div>';
    echo '<div class="col-2 landscape-inside">
        <p class="subTitle">Avec option "landscape"</p>';
        $card3 = new \WonderWp\Theme\Child\Components\Card\CardComponent();
        $card3
            ->setTitle('Lorem ipsum dolor consectetur')
            ->setContent('Lorem ipsum dolor, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.')
            ->setImage('<img src="https://via.placeholder.com/150" alt="">')
            ->setLink('/vers-une-page')
            ->setDate('12 septembre 2020')
            /*->setCategories('')*/
        ;
        echo $card3->getMarkup();
    echo '</div>';
    echo '<div class="col-2 landscape-inside reverse-inside">
        <p class="subTitle">Avec options "landscape" et "reverse"</p>';
        $card4 = new \WonderWp\Theme\Child\Components\Card\CardComponent();
        $card4
            ->setTitle('Lorem ipsum dolor consectetur')
            ->setContent('Lorem ipsum dolor, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.')
            ->setImage('<img src="https://via.placeholder.com/150" alt="">')
            ->setLink('/vers-une-page')
            ->setDate('12 septembre 2020')
            /*->setCategories('')*/
        ;
        echo $card4->getMarkup();
    echo '</div>';
    ?>
</div>
