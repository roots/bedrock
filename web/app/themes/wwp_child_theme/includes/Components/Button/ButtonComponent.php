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
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Couleur"})
     */
    protected $color;

    /**
     * @var boolean
     * @BlockOptions(component="CheckboxControl",type="boolean",componentAttributes={"label":"Flèche droite"})
     */
    protected $arrow;

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
     * @param string $color
     * @return ButtonComponent
     */
    public function setColor(string $color): ButtonComponent
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @param bool $arrow
     * @return ButtonComponent
     */
    public function setArrow(bool $arrow): ButtonComponent
    {
        $this->arrow = $arrow;
        return $this;
    }

    public function getMarkup(array $opts = [])
    {
        if (!empty($this->label) || !empty($this->link)) {

            $markup = '<a class="btn ';

            if ($this->color) {
                $markup .= ' btn--'.$this->color;
            }

            if ($this->arrow == true) {
                $markup .= ' btn-cta';
            }

            $markup .= '"';

            $markup .= 'href="'.$this->link.'">';

            $markup .= $this->label.'</a>';

            return $markup;

        }
    }
}
