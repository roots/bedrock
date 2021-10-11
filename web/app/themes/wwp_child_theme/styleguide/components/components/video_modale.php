<!-- components/components/video_modale.php -->
<?php

$video = new \WonderWp\Theme\Child\Components\VideoModale\VideoModaleComponent();

$video
    ->setTitle('Titre de la video')
    ->setVideo('https://www.youtube.com/embed/BQ8tw0D8SuU')
    ->setImage('<img src="https://placeimg.com/340/250/nature" alt="">')
;

echo $video->getMarkup();
