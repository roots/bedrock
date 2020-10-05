<?php

namespace WonderWp\Theme\Child\Components\Slider\Interfaces;

use WonderWp\Theme\Core\Component\ComponentInterface;

interface SlideInterface extends ComponentInterface
{
    /**
     * @param string $img
     *
     * @return static
     */
    public function setImg(string $img);

    /**
     * @param string $imgAlt
     *
     * @return static
     */
    public function setImgAlt(string $imgAlt);

    /**
     * @param string $title
     *
     * @return static
     */
    public function setTitle(string $title);

    /**
     * @param string $link
     *
     * @return static
     */
    public function setLink(string $link);

    /**
     * @param string $label
     *
     * @return static
     */
    public function setLinkLabel(string $label);

    /**
     * @param string $content
     *
     * @return static
     */
    public function setContent(string $content);
}
