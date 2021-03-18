<?php
/**
 * Created by PhpStorm.
 * User: marclafay
 * Date: 20/03/2019
 * Time: 16:16
 */

namespace WonderWp\Theme\Child\Components\VideoEmbed;

use WonderWp\Theme\Core\Component\AbstractComponent;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\Block;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\BlockAttributes;

/**
 * @Block(title="Video embed")
 *
 */
class VideoEmbedComponent extends AbstractComponent
{
    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Titre"})
     */
    protected $title;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Video ID"})
     */
    protected $video; // Youtube ID

    /**
     * @var string
     * @BlockAttributes(component="MediaUpload",type="string",componentAttributes={"placeholder":"Image"})
     */
    protected $image;

    /**
     * @param string $title
     * @return VideoEmbedComponent
     */
    public function setTitle(string $title): VideoEmbedComponent
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $video
     * @return VideoEmbedComponent
     */
    public function setVideo(string $video): VideoEmbedComponent
    {
        $this->video = $video;
        return $this;
    }

    /**
     * @param string $image
     * @return VideoEmbedComponent
     */
    public function setImage(string $image): VideoEmbedComponent
    {
        $this->image = $image;
        return $this;
    } // <img width="1920" height="700" src="/app/uploads/2019/03/teresa-1920x700.jpg" alt="">



    public function getMarkup(array $opts = [])
    {

        $markup = '<div class="video-wrapper" data-video-embed-component>';

            if (!empty($this->image)) {
                $markup .= '<div class="video-image-wrapper">
                   ' . $this->image . '
                </div>';
            }

            $markup .= '<button class="video-trigger" aria-label="' . trad('video.play.label', WWP_THEME_TEXTDOMAIN) . '" ><span> ' . $this->title . '</span></button>

            <div class="video-player" data-video="' . $this->video . '">

            </div>';

        $markup .= '</div>'; /*.video-embed-wrapper*/

        return $markup;
    }

}

