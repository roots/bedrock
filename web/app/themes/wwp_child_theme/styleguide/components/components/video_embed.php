<!-- components/components/video_embed.php -->
<?php

use WonderWp\Theme\Child\Components\VideoEmbed\VideoEmbedComponent;

$video = new WonderWp\Theme\Child\Components\VideoEmbed\VideoEmbedComponent();

$video->setTitle('Titre de la video');
$video->setVideo('8b8qTPzfrOE');
$video->setImage('<img width="1920" height="700" src="http://via.placeholder.com/1920x700" alt="">');

echo $video->getMarkup();
