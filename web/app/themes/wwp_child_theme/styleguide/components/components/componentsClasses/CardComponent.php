<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 12:23
 */

namespace WonderWp\Theme\Components;


class CardComponent extends AbstractComponent
{

    private $_image;
    private $_title;
    private $_content;
    private $_link;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->_image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->_image = $image;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->_title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->_content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->_link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->_link = $link;
        return $this;
    }

    public function getMarkup($opts=array())
    {
        $markup = '<div class="card">';

        if (!empty($this->_image)) {
            $markup .= '<img class="card-img-top" src="'.$this->_image.'" alt="Card image cap">';
        }

        if (!empty($this->_title) || !empty($this->_content)) {
            $markup .= '<div class="card-block">';
            if (!empty($this->_title)) {
                $markup .= '<h2 class="card-title">' . $this->_title . '</h2>';
            }
            if (!empty($this->_content)) {
                $markup .= '<div class="card-text">' . $this->_content . '</div>';
            }
            $markup .= '</div>';
        }

        $markup .= '</div>';

        return $markup;
    }


}