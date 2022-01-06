<!-- components/components/forms.php -->
<p class="subTitle">Formulaire de base. Par les afficher, IL FAUT IMPERATIVEMENT UN FORMULAIRE AVEC l'ID 6</p>
<?php echo do_shortcode("[wwpmodule slug='wwp-contact' form='7']"); ?>
<br>
<br>

<p class="subTitle">Formulaire avec groupes de champs</p>
<span class="help">Pour générer des groupes de champs, il faut ajouter l'intitulé des groupes dans les clés de traduction.</span>
<div class="">
    <?php echo do_shortcode("[wwpmodule slug='wwp-contact' form='7']"); ?>
</div>

<p class="subTitle">Formulaire labels masqués</p>
<div class="form-nolabel">
    <?php echo do_shortcode("[wwpmodule slug='wwp-contact' form='7']"); ?>
</div>
<br>

<p class="subTitle">Formulaire horizontal (inline)</p>
<div class="form-inline">
    <?php echo do_shortcode("[wwpmodule slug='wwp-contact' form='7']"); ?>
</div>
<br>

<p class="subTitle">Formulaire inline avec labels masqués</p>
<div class="form-nolabel form-inline">
    <?php echo do_shortcode("[wwpmodule slug='wwp-contact' form='7']"); ?>
</div>

