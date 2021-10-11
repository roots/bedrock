<!-- components/components/video_native.php -->
<?php

$video = new \WonderWp\Theme\Child\Components\Video\VideoComponent();

$video
    ->setTitle('Titre de la video')
    ->setImage('https://placeimg.com/340/250/nature')
    ->setVideoMp4('/app/themes/wwp_child_theme/assets/raw/videos/clown.mp4')
    ->setVideoOgg('/app/themes/wwp_child_theme/assets/raw/videos/clown.ogv')
    ->setVideoWebm('/app/themes/wwp_child_theme/assets/raw/videos/clown.webm')
    ;

echo $video->getMarkup();
