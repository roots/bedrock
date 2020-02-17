<!-- components/components/video_embed.php -->
<?php

$video = new WonderWp\Theme\Child\Components\VideoEmbed\VideoEmbedComponent();

$video
    ->setTitle('Titre de la video')
    ->setVideo('8b8qTPzfrOE')
    ->setImage('<img width="920" height="700" src="http://via.placeholder.com/920x700" alt="">')
;

echo $video->getMarkup();
