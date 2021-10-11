<!-- components/components/video_embed.php -->
<?php

$video = new WonderWp\Theme\Child\Components\VideoEmbed\VideoEmbedComponent();

$video
    ->setTitle('Titre de la video')
    ->setVideo('8b8qTPzfrOE')
    ->setImage('<img src="https://placeimg.com/340/250/nature" alt="">')
;

echo $video->getMarkup();
