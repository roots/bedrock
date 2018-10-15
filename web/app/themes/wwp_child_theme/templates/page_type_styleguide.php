<?php
/* Template Name: Page type styleguide */
get_header ();
?>
<div class="container">

  <h1>Ceci est un titre de niveau 1</h1>
  <img src="https://placeimg.com/1200/340/nature" alt="" width="1200" height="340">

  <p class="chapo">Chapo. Lorem ipsum Fusce ut consequat elit. Nibh tortor urna id tempus rutrum, ullamcorper. Torquent massa
    sit erat. Tortor per pharetra per lobortis neque lacinia odio. Nunc commodo faucibus metus lobortis at tempor
    ultrices ipsum quam. In. Auctor taciti vel id Sed eu a Quisque Mauris fringilla pharetra vitae sollicitudin
    tincidunt ultrices. Ornare in elit. Placerat.</p>

  <h2>Ceci est un titre de niveau 2</h2>
  <p>Paragraphe de texte ipsum Fusce ut consequat elit. <a href="http://google.fr">Texte avec lien. Nibh tortor urna id tempus rutrum</a>, ullamcorper.
    Torquent massa sit erat. Tortor per pharetra per lobortis neque lacinia odio. Nunc commodo faucibus metus lobortis
    at tempor ultrices ipsum quam. In. Auctor taciti vel id Sed.<br>
    Lorem ipsum Fusce ut consequat elit. Nibh tortor urna id tempus rutrum, ullamcorper. Torquent massa sit erat. Tortor
    per pharetra per lobortis neque lacinia odio. Nunc commodo faucibus metus lobortis at tempor ultrices ipsum quam.
    In. Auctor taciti vel id Sed eu a Quisque Mauris fringilla pharetra vitae sollicitudin tincidunt ultrices. Ornare in
    elit. Placerat.ltrices. <strong>Texte en gras Ornare in elit placerat.</strong></p>

  <hr>

  <h3>Liste non ordonnée</h3>
  <ul>
    <li>Nibh tortor urna id tempus rutrum, ullamcorper. Torquent massa sit erat</li>
    <li>Nibh tortor urna id tempus rutrum, ullamcorper. Torquent massa sit erat</li>
    <li>Nibh tortor urna id tempus rutrum, ullamcorper. Torquent massa sit erat</li>
  </ul>
  <h3>Liste ordonnée</h3>
  <ol>
    <li>Nibh tortor urna id tempus rutrum, ullamcorper. Torquent massa sit erat</li>
    <li>Nibh tortor urna id tempus rutrum, ullamcorper. Torquent massa sit erat</li>
    <li>Nibh tortor urna id tempus rutrum, ullamcorper. Torquent massa sit erat</li>
  </ol>

  <hr>

  <h3>Citation</h3>
  <div class="blockquote-wrapper">
    <blockquote>Lorem ipsum a felis donec porta vel ultrices metus morbi porta vel.</blockquote>
    <span class="cite-name">Prénom Nom</span>
    <span class="cite-function">Fonction</span>
  </div>

  <hr>

  <h3>Utilisation des images</h3>

  <strong>Image pleine largeur</strong>
  <img src="https://placeimg.com/1200/340/nature" alt="" width="1200" height="340">
  <br>

  <strong>Image demi-largeur avec habillage à gauche ou à droite<br> (ajouter les classes "fl" ou "fr" sur l'img + classe ".clearfix" sur son parent pour contenir les flottants)</strong>
  <div class="clearfix">
    <p><img class="fl" src="https://placeimg.com/350/350/nature" alt="" width="350" height="350">Lorem ipsum Fusce ut
      consequat elit. <a href="http://google.fr">Nibh tortor urna id tempus rutrum</a>, ullamcorper. Torquent massa sit
      erat. Tortor per pharetra per lobortis neque lacinia odio. Nunc commodo faucibus metus lobortis at tempor ultrices
      ipsum quam. In. Auctor taciti vel id Sed. Lorem ipsum Fusce ut consequat elit. Nibh tortor urna id tempus rutrum,
      ullamcorper. Torquent massa sit erat. Tortor per pharetra per lobortis neque lacinia odio. Nunc commodo faucibus
      metus lobortis at tempor ultrices ipsum quam. In. Auctor taciti vel id Sed.</p>
    <p>Lorem ipsum Fusce ut consequat elit. Nibh tortor urna id tempus rutrum, ullamcorper. Torquent massa sit erat.
      Tortor per pharetra per lobortis neque lacinia odio. Nunc commodo faucibus metus lobortis at tempor ultrices ipsum
      quam. In. Auctor taciti vel id Sed.</p>
  </div>

  <hr>

  <h3>Encadré</h3>
  <p class="encadre">Lorem ipsum Fusce ut consequat elit. Nibh tortor urna id tempus rutrum, ullamcorper. Torquent massa
    sit erat. Tortor per pharetra per lobortis neque lacinia odio. Nunc commodo faucibus metus lobortis at tempor
    ultrices ipsum quam. In. Auctor taciti vel id Sed.
  </p>

</div>
<?php
get_footer ();
