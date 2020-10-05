<?php
/**
 * Created by PhpStorm.
 * User: mathieudelafosse
 * Date: 05/01/2018
 * Time: 17:44
 */

namespace WonderWp\Theme\Child\Components\Slider\SliderDefault\SliderItem;

use WonderWp\Theme\Child\Components\Slider\Interfaces\SlideInterface;
use WonderWp\Theme\Core\Component\TwigComponent;

class SliderItem extends TwigComponent implements SlideInterface
{
    /** @var string */
    protected $img;
    /** @var string */
    protected $imgAlt;
    /** @var string */
    protected $title;
    /** @var string */
    protected $link;
    /** @var string */
    protected $linkLabel;
    /** @var string */
    protected $content;

    /** @inheritDoc */
    public function setImg(string $img)
    {
        $this->__set('img', stripslashes($img));

        return $this;
    }

    /** @inheritDoc */
    public function setImgAlt(string $imgAlt)
    {
        $this->__set('imgAlt', stripslashes($imgAlt));

        return $this;
    }

    /** @inheritDoc */
    public function setTitle(string $title)
    {
        $this->__set('title', stripslashes($title));

        return $this;
    }

    /** @inheritDoc */
    public function setLink(string $link)
    {
        $this->__set('link', stripslashes($link));

        return $this;
    }

    /** @inheritDoc */
    public function setLinkLabel(string $label)
    {
        $this->__set('linkLabel', stripslashes($label));

        return $this;
    }

    /** @inheritDoc */
    public function setContent(string $content)
    {
        $this->__set('content', stripslashes($content));

        return $this;
    }

    public function __construct($templatesDir = null, $templateName = null)
    {
        if(empty($templatesDir)){
            $templatesDir = __DIR__;
        }
        if(empty($templateName)){
            $templateName = 'slider-item';
        }
        parent::__construct($templatesDir, $templateName);
    }

}
