<?php

namespace WonderWp\Theme\Child\Components\ChiffreCle;

use WonderWp\Theme\Core\Component\AbstractComponent;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\Block;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\BlockAttributes;

/**
 * @Block(title="Chiffre clé")
 *
 */
class ChiffreCleComponent extends AbstractComponent
{
    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Chiffre"})
     */
    protected $chiffre;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Texte"})
     */
    protected $text;

    /**
     * @var string
     * @BlockAttributes(component="MediaUpload",type="string",componentAttributes={"placeholder":"Image"})
     */
    protected $image;

    /**
     * @param string $chiffre
     * @return ChiffreCleComponent
     */
    public function setChiffre(string $chiffre): ChiffreCleComponent
    {
        $this->chiffre = $chiffre;
        return $this;
    }

    /**
     * @param string $text
     * @return ChiffreCleComponent
     */
    public function setText(string $text): ChiffreCleComponent
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @param string $image
     * @return ChiffreCleComponent
     */
    public function setImage(string $image): ChiffreCleComponent
    {
        $this->image = $image;
        return $this;
    }

    public function getMarkup(array $opts = [])
    {
        $markup = '<div itemscope="" itemtype="http://schema.org/ListItem" class="item-chiffre-cle">';

        if (!empty($this->image)) {
            $markup .= '<div class="img-wrap">'.$this->image.'</div>';
        }

        if (!empty($this->chiffre)) {
            $markup .= '<span class="chiffre">' . $this->chiffre . '</span>';
        }

        if (!empty($this->text)) {
            $markup .= '<span class="text">' . $this->text . '</span>';
        }

        $markup .= '</div>';

        return $markup;
    }
}
