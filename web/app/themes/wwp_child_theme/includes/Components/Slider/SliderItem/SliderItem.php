<?php
/**
 * Created by PhpStorm.
 * User: mathieudelafosse
 * Date: 05/01/2018
 * Time: 17:44
 */

namespace WonderWp\Theme\Child\Components\Slider\SliderItem;


use WonderWp\Theme\Core\Component\TwigComponent;

class SliderItem extends TwigComponent

{
    /** @var string */
    protected $img;
    /** @var string */
    protected $title;
    /** @var string */
    protected $link;
    /** @var string */
    protected $label;
    /** @var string */
    protected $buttonLabel;
    /** @var string */
    protected $content;

    /**
     * @param string $img
     *
     * @return static
     */
    public function setImg(string $img)
    {
        $this->__set('img',stripslashes($img));

        return $this;
    }

    /**
     * @param string $title
     *
     * @return static
     */
    public function setTitle(string $title)
    {
        $this->__set('title',stripslashes($title));

        return $this;
    }

    /**
     * @param string $link
     *
     * @return static
     */
    public function setLink(string $link)
    {
        $this->__set('link',stripslashes($link));

        return $this;
    }

    /**
     * @param string $label
     *
     * @return static
     */
    public function setLabel(string $label)
    {
        $this->__set('label',stripslashes($label));

        return $this;
    }

    /**
     * @param string $buttonLabel
     *
     * @return static
     */
    public function setButtonLabel(string $buttonLabel)
    {
        $this->__set('buttonLabel',stripslashes($buttonLabel));

        return $this;
    }

    /**
     * @param string $content
     *
     * @return static
     */
    public function setContent(string $content)
    {
        $this->__set('content',stripslashes($content));

        return $this;
    }



    public function __construct()
    {
        parent::__construct(__DIR__, 'slider-item');

    }

}
