<?php

namespace WonderWp\Theme\Child\Components\VideoModale;

use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\Block;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\BlockAttributes;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\BlockOptions;
use WonderWp\Theme\Core\Component\AbstractComponent;

/**
 * @Block(title="Vidéo modale")
 *
 */
class VideoModaleComponent extends AbstractComponent
{

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Titre"})
     */
    protected $title;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Videp embed"})
     */
    protected $video; //Embed Youtube url (ex: https://www.youtube.com/embed/BQ8tw0D8SuU)

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Image"})
     */
    protected $image; //Complete image tag (ex: <img src="/app/uploads/2020/05/btn-video-modale.png" alt="">)

    /**
     * @var boolean
     * @BlockOptions(component="CheckboxControl",type="boolean",componentAttributes={"label":"Grande vignette"})
     */
    protected $sizeOption;

    /**
     * @param string $title
     *
     * @return VideoModaleComponent
     */
    public function setTitle(string $title): VideoModaleComponent
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $video
     *
     * @return VideoModaleComponent
     */
    public function setVideo(string $video): VideoModaleComponent
    {
        $this->video = $video;

        return $this;
    }

    /**
     * @param string $image
     *
     * @return VideoModaleComponent
     */
    public function setImage(string $image): VideoModaleComponent
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @param bool $sizeOption
     * @return VideoModaleComponent
     */
    public function setSizeOption(bool $sizeOption): VideoModaleComponent
    {
        $this->sizeOption = $sizeOption;
        return $this;
    }

    public function getMarkup(array $opts = [])
    {
        $markup = '<a class="modaal ';

        if ($this->sizeOption) {
            $markup .= 'video-large';
        }

        $markup .= '" data-modaal-type="video" data-modaal-close-text="Fermer" data-modaal-close-aria-label="Fermer (Cliquer sur escape pour fermer)" href="';
        if (!empty($this->video)) {
            $markup .= $this->video;
        }
        $markup .= '"' ;
        if (!empty($this->title)) {
            $markup .= 'title="'.$this->title.'"';
        }
        $markup .= '>';
        if (!empty($this->image)) {
            $markup .= $this->image;
        }
        $markup .= '</a>';

        return $markup;
    }
}
