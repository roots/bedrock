<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 12:22
 */

namespace WonderWp\Theme\Child\Components\Modal;

use WonderWp\Theme\Core\Component\AbstractComponent;
use WonderWp\Theme\Core\Component\TwigComponent;

class ModalComponent extends AbstractComponent
{
    /*** @var string */
    protected $class; // corresponds to the domSelector from PewJS

    /*** @var string */
    protected $label;

    /*** @var string */
    protected $content;

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     * @return ModalComponent
     */
    public function setClass(string $class): ModalComponent
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return ModalComponent
     */
    public function setLabel(string $label): ModalComponent
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return ModalComponent
     */
    public function setContent(string $content): ModalComponent
    {
        $this->content = $content;
        return $this;
    }

    public function getMarkup(array $opts = [])
    {
        $markup = '';

        if(!empty($this->class) || !empty($this->label)) {
            $markup .= '<a href="#' . $this->class . '" class="btn ' . $this->class . '">' . $this->label . '</a>';
        }

        if(!empty($this->content) || !empty($this->class)) {
            $markup .= '<div id="' . $this->class . '" style="display:none;">
                ' . $this->content . '
            </div>';
        }

        return $markup;
    }
}
