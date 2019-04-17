<?php
/**
 * Created by PhpStorm.
 * User: marclafay
 * Date: 20/03/2019
 * Time: 16:16
 */

namespace WonderWp\Theme\Child\Components\Video;

use WonderWp\Theme\Core\Component\AbstractComponent;

class VideoComponent extends AbstractComponent
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $video; // Youtube ID

    /**
     * @var string
     */
    protected $image;

    /**
     * @param string $title
     * @return VideoComponent
     */
    public function setTitle(string $title): VideoComponent
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $video
     * @return VideoComponent
     */
    public function setVideo(string $video): VideoComponent
    {
        $this->video = $video;
        return $this;
    }

    /**
     * @param string $image
     * @return VideoComponent
     */
    public function setImage(string $image): VideoComponent
    {
        $this->image = $image;
        return $this;
    } // <img width="1920" height="700" src="/app/uploads/2019/03/teresa-1920x700.jpg" alt="">



    public function getMarkup(array $opts = [])
    {

        $markup = '';

        $markup .= '<div class="video-wrapper" data-video-component>';

            $markup .= '<div class="video-image-wrapper">
               ' . $this->image . '
            </div>';

            $markup .= '<button class="video-trigger"><span>Regarder la vidéo ' . $this->title . '</span></button>
            <div class="video-player" data-video="' . $this->video . '">
 
            </div>';

        $markup .= '</div>';


        return $markup;
    }

}
