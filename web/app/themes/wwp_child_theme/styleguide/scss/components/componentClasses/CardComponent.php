<?php
/**
 * Created by PhpStorm.
 * User: marclafay
 * Date: 01/12/2017
 * Time: 09:39
 */

namespace WonderWp\Theme\Components;


use WonderWp\Theme\Core\Component\AbstractComponent;

class CtaImageComponent extends AbstractComponent
{
    /** @var  string */
    protected $title;

    /** @var  string */
    protected $text;

    /** @var  string */
    protected $image;

    /** @var  string */
    protected $link;

    /** @var  string */
    protected $label;

    /** @var  string */
    protected $color = '';

    /** @var  string */
    protected $class = '';

    /** @var  string */
    protected $background = '';

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return CtaImageComponent
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return CtaImageComponent
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return CtaImageComponent
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return CtaImageComponent
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return CtaImageComponent
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return CtaImageComponent
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     * @return CtaImageComponent
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return string
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * @param string $background
     * @return CtaImageComponent
     */
    public function setBackground($background)
    {
        $this->background = $background;
        return $this;
    }


    public function getMarkup(array $opts = [])
    {
        $markup = '<div class="cta-image ' . $this->color . ' ' . $this->class . ' ' . $this->background . '">'.
            '<a href="' . $this->link . '">';
                if (!empty($this->image)) {
                    $markup .= '<div class="image-wrapper"><img src="' . $this->image . '" alt=""></div>';
                }
                $markup .='<div class="content">';
                if (!empty($this->title)) {
                    $markup .= '<h3>' . $this->title . '</h3>';
                }
                if (!empty($this->text)) {
                    $markup .= '<p>' . $this->text . '</p>';
                }
                $markup .='</div>';
                if (!empty($this->label)) {
                    $markup .= '<button class="btn">' . $this->label . '</button>';
                }
                $markup .= '</a>' .
        '</div>';

        return $markup;
    }

}

