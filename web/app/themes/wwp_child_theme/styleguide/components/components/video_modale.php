<!-- components/components/video_modale.php -->
<?php

$video = new \WonderWp\Theme\Child\Components\VideoModale\VideoModaleComponent();

$video
    ->setTitle('Titre de la video')
    ->setVideo('https://www.youtube.com/embed/BQ8tw0D8SuU')
    ->setImage('<img src="http://via.placeholder.com/920x700" alt="">')
;

echo $video->getMarkup();
