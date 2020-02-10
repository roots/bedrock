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
    /** @var string */
    protected $title;

    /** @var string */
    protected $videoMp4;

    /** @var string */
    protected $videoOgg;

    /** @var string */
    protected $videoWebm;

    /** @var string */
    protected $image;

    /**
     * @param string $title
     *
     * @return VideoComponent
     */
    public function setTitle(string $title): VideoComponent
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $videoMp4
     *
     * @return static
     */
    public function setVideoMp4(string $videoMp4)
    {
        $this->videoMp4 = $videoMp4;

        return $this;
    }

    /**
     * @param string $videoOgg
     *
     * @return static
     */
    public function setVideoOgg(string $videoOgg)
    {
        $this->videoOgg = $videoOgg;

        return $this;
    }

    /**
     * @param string $videoWebm
     *
     * @return static
     */
    public function setVideoWebm(string $videoWebm)
    {
        $this->videoWebm = $videoWebm;

        return $this;
    }

    /**
     * @param string $image
     *
     * @return VideoComponent
     */
    public function setImage(string $image): VideoComponent
    {
        $this->image = $image;

        return $this;
    }

    public function getMarkup(array $opts = [])
    {

        $index = !empty($opts['index']) ? $opts['index'] : 0;
        $playerWrapId = 'video-player-wrap-' . $index;

        $markup = '
        <div class="video-wrapper" data-video-native-component>';

        if (!empty($this->image)) {
            $markup .= '<div class="video-image-wrapper">
                <img src="' . $this->image . '" alt="">
            </div>';
        }

        $markup .= '<button class="video-trigger"><span>' . trad('video.play.label', WWP_THEME_TEXTDOMAIN) . ' ' . $this->title . '</span></button>';

        $markup .= '
        <div class="video-player-wrap" id="' . $playerWrapId . '">
            <div class="video-player" id="' . $playerWrapId . '">

               <video class="video" width="780" height="440" ' . (!empty($this->image) ? 'poster="' . $this->image . '"' : '') . '>';
        if (!empty($this->videoMp4)) {
            $markup .= '<source src="' . $this->videoMp4 . '" type="video/mp4">';
        }
        if (!empty($this->videoOgg)) {
            $markup .= '<source src="' . $this->videoOgg . '" type="video/ogg">';
        }
        if (!empty($this->videoWebm)) {
            $markup .= '<source src="' . $this->videoWebm . '" type="video/webm">';
        }
        $markup .= '
                    ' . trad('no_video_support.trad', WWP_THEME_TEXTDOMAIN) . '
                </video>

                <div class="video-controls controls">
                   <div class="progress-wrap">
                      <progress class="progress" value="0" max="100">
                         <span class="progress-bar"></span>
                      </progress>
                   </div>
                   <div class="buttons">
                    <div class="left-buttons">
                         <button class="playpause" type="button" data-state="play">Play/Pause</button>
                         <button class="mute" type="button" data-state="unmute">Mute/Unmute</button>
                     </div>
                     <div class="right-buttons">
                        <button class="stop" type="button" data-state="stop">Stop</button>
                        <button class="volinc" type="button" data-state="volup">Vol+</button>
                        <button class="voldec" type="button" data-state="voldown">Vol-</button>
                        <button class="fs" type="button" data-state="go-fullscreen">Fullscreen</button>
                     </div>
                    </div>
                </div>

            </div>
        </div>';

        $markup .= '</div>';/*.video-wrapper*/

        return $markup;
    }

}
