<?php
/**
 * Created by PhpStorm.
 * User: marclafay
 * Date: 20/03/2019
 * Time: 16:16
 */

namespace WonderWp\Theme\Child\Components\Video;

use WonderWp\Theme\Core\Component\AbstractComponent;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\Block;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\BlockAttributes;

/**
 * @Block(title="Video native")
 *
 */
class VideoComponent extends AbstractComponent
{
    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Titre"})
     */
    protected $title;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Video mp4"})
     */
    protected $videoMp4;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Video ogg"})
     */
    protected $videoOgg;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Video webm"})
     */
    protected $videoWebm;

    /**
     * @var string
     * @BlockAttributes(component="MediaUpload",type="string",componentAttributes={"placeholder":"Image"})
     */
    protected $image;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Lazy"})
     */
    protected $lazy;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Autoplay"})
     */
    protected $autoplay;

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

    /**
     * @param string $lazy
     *
     * @return VideoComponent
     */
    public function setLazy(string $lazy): VideoComponent
    {
        $this->lazy = $lazy;

        return $this;
    }

    /**
     * @param string $autoplay
     *
     * @return VideoComponent
     */
    public function setAutoplay(string $autoplay): VideoComponent
    {
        $this->autoplay = $autoplay;

        return $this;
    }

    public static $template = <<<EOD

    {image}
    <button class="video-trigger"><span>{label}</span></button>
    <div class="video-player-wrap" id="{id}">
        <div class="video-player">
            <video class="video" {poster} {autoplay} {muted} {playsinline}>
                {videoMp4}
                {videoOgg}
                {videoWebm}
                {videoAlt}
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
    </div>

EOD;

    public function getMarkup(array $opts = [])
    {
        if (strpos($this->image, '<img') !== false) {
            preg_match("/\<img.+src\=(?:\"|\')(.+?)(?:\"|\')(?:.+?)\>/", $this->image, $matches);
            $this->image = $matches[1];
        }
        $index        = !empty($opts['index']) ? $opts['index'] : 0;
        $playerWrapId = 'video-player-wrap-' . $index;
        $lazy         = (int)$this->lazy === 1;
        $autoplay     = (int)$this->autoplay === 1;
        $data         = [
            '{image}'       => !empty($this->image) ? '<div class="video-image-wrapper"><img src="' . $this->image . '" alt=""></div>' : '',
            '{label}'       => trad('video.play.label', WWP_THEME_TEXTDOMAIN) . ' ' . $this->title,
            '{id}'          => $playerWrapId,
            '{poster}'      => !empty($this->image) ? ' poster="' . $this->image . '" ' : '',
            '{videoMp4}'    => !empty($this->videoMp4) ? '<source src="' . $this->videoMp4 . '" type="video/mp4">' : '',
            '{videoOgg}'    => !empty($this->videoOgg) ? '<source src="' . $this->videoOgg . '" type="video/ogg">' : '',
            '{videoWebm}'   => !empty($this->videoWebm) ? '<source src="' . $this->videoWebm . '" type="video/webm">' : '',
            '{videoAlt}'    => trad('no_video_support.trad', WWP_THEME_TEXTDOMAIN),
            '{lazy}'        => $lazy ? 'true' : 'false',
            '{autoplay}'    => $autoplay ? ' autoplay ' : ' ',
            '{muted}'       => ' muted="true" ',
            '{playsinline}' => 'playsinline',
        ];

        if ($lazy) {
            $varJs           = 'videoPlayer' . $index;
            $data['{muted}'] = 'muted="false"';
            $markup          = '<div class="video-wrapper" data-video-native-component data-video-lazy="true" data-var-name="' . $varJs . '"><script>window.' . $varJs . ' = ' . json_encode([
                    'template' => static::$template,
                    'data'     => $data,
                ]) . '</script></div>';
        } else {
            $markup = '<div class="video-wrapper" data-video-native-component>' . str_replace(array_keys($data), array_values($data), self::$template) . '</div>';
        }

        return $markup;
    }

}
