<!--components/components/Modal.php-->

<p class="subTitle">Le contenu ajouté dans les balises du shortcode sera affiché dans la modale. <br>L'attribut "class" sert à cibler la modale afin de définir des options spécifiques (développement).</p>

<code>[modal class="wdf-modal-example"]Some content over here[/modal]</code>
<br>

<?php echo do_shortcode('[modal class="wdf-modal" label="Cliquer ici pour ouvrir"]    Some content over here    [/modal]');
echo do_shortcode('[modal class="wdf-modal-home" label="Modale fond primary"]    Some content over here    [/modal]');
