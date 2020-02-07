<!-- components/molecules/card.php -->
<p class="subTitle">Bloc de contenu polyvalent.</p>
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
            <li>two-cols</li>
            <li>inline</li>
        </ul>
    </div>
</div>

<div class="grid-3-small-2 has-gutter-xl">
    <?php echo do_shortcode ('[card title="Lorem ipsum dolor sit amet" content="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam." image="https://via.placeholder.com/150" link="/une-page" button="Découvrir"]'); ?>
    <?php echo do_shortcode ('[card title="Lorem ipsum" content="Lorem ipsum dolor sit amet, consectetur adipisicing elit." image="https://via.placeholder.com/150" link="/une-page" button="Découvrir" class="negative"]'); ?>
    <?php echo do_shortcode ('[card title="Lorem ipsum dolor sit amet" content="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam." image="https://via.placeholder.com/150" link="/une-page" button="Découvrir" class="reverse"]'); ?>
</div>
