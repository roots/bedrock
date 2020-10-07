<?php

namespace WonderWp\Theme\Child\Components\Button;

use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\Block;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\BlockAttributes;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\BlockOptions;
use WonderWp\Theme\Core\Component\AbstractComponent;

/**
 * @Block(title="Bouton")
 *
 */
class ButtonComponent extends AbstractComponent
{
    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Label"})
     */
    protected $label;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Lien"})
     */
    protected $link;

    /**
     * @var string
     * @BlockAttributes(component="MediaUpload",type="string",componentAttributes={"size":"small"})
     */
    protected $icon;

    /**
     * @param string $label
     * @return ButtonComponent
     */
    public function setLabel(string $label): ButtonComponent
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @param string $link
     * @return ButtonComponent
     */
    public function setLink(string $link): ButtonComponent
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @param string $icon
     * @return ButtonComponent
     */
    public function setIcon(string $icon): ButtonComponent
    {
        $this->icon = $icon;
        return $this;
    }

    public function getMarkup(array $opts = [])
    {
        $markup = '<a href="">';

        $markup .= '</a>';

        return $markup;
    }
}
