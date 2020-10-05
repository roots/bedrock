<?php

namespace WonderWp\Theme\Child\Components\GutenbergCardComponent;

use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\Block;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\BlockAttributes;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\BlockOptions;
use WonderWp\Theme\Core\Component\AbstractComponent;

/**
 * @Block(title="Card")
 *
 */
class CardGutenbergComponent extends AbstractComponent
{
    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Titre du bloc"})
     */
    protected $title;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Contenu du bloc"})
     */
    protected $content;

    /**
     * @var string
     * @BlockAttributes(component="MediaUpload",type="string",componentAttributes={"size":"large"})
     */
    protected $image;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Lien du bloc"})
     */
    protected $link;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Date du bloc"})
     */
    protected $date;

    /**
     * @var boolean
     * @BlockOptions(component="CheckboxControl",type="boolean",componentAttributes={"label":"Reverse"})
     */
    protected $reverse;

    /**
     * @var boolean
     * @BlockOptions(component="CheckboxControl",type="boolean",componentAttributes={"label":"2 colonnes"})
     */
    protected $colonnes;

    /**
     * @param bool $reverse
     * @return CardComponent
     */
    public function setReverse(bool $reverse): CardComponent
    {
        $this->reverse = $reverse;
        return $this;
    }

    /**
     * @param bool $colonnes
     * @return CardComponent
     */
    public function setColonnes(bool $colonnes): CardComponent
    {
        $this->colonnes = $colonnes;
        return $this;
    }

    public function getMarkup(array $opts = [])
    {
        $markup = '<div itemscope="" itemtype="http://schema.org/ListItem" class="item';
        if ($this->reverse == true) {
            $markup .= ' reverse ';
        }
        if ($this->colonnes == true) {
            $markup .= ' landscape ';
        }
        $markup .= '">
            <div class="img-wrap" itemprop="image" itemscope="" itemtype="http://schema.org/ImageObject">
                <a itemprop="url" href="' . $this->link . '" class="card-link card-img-link">
                    <img width="600" height="360" src="' . $this->image . '" class="attachment-large size-large" alt="" src="' . $this->image . '">
                </a>
            </div>
            <div class="card-block">
                <a itemprop="url" href="' . $this->link . '" class="card-link card-title-link">
                    <span class="card-title" itemprop="name">' . $this->title . '</span>
                </a>
                <div class="card-date"><meta itemprop="datePublished" content="' . $this->date . '">' . $this->date . '</div>
                <div class="card-text" itemprop="description">' . $this->content . '</div>
                <a class="card-link card-readmore-link card-link" itemprop="url" href="' . $this->link . '">En savoir plus </a>
            </div>
        </div>';

        return $markup;
    }
}
