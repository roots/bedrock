<?php

namespace WonderWp\Theme\Child\Components\Dropdown;

use WonderWp\Theme\Core\Component\AbstractComponent;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\Block;
use WonderWp\Plugin\GutenbergUtils\Bloc\Annotation\BlockAttributes;

/**
 * @Block(title="Dropdown")
 *
 */
class DropdownComponent extends AbstractComponent
{
    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Classe custom"})
     */
    protected $class;

    /**
     * @var string
     * @BlockAttributes(component="PlainText",type="string",componentAttributes={"placeholder":"Contenu du dropdown"})
     */
    protected $label;

    /**
     * @var string
     * @BlockAttributes(component="InnerBlocks",type="string",componentAttributes={"placeholder":"Contenu du dropdown"})
     */
    protected $subComponents;

    /**
     * @param string $class
     * @return DropdownComponent
     */
    public function setClass(string $class): DropdownComponent
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @param string $label
     * @return DropdownComponent
     */
    public function setLabel(string $label): DropdownComponent
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @param string $subComponents
     * @return DropdownComponent
     */
    public function setSubComponents(string $subComponents): DropdownComponent
    {
        $this->subComponents = $subComponents;
        return $this;
    }

    public function getMarkup(array $opts = [])
    {
        $markup = '<div class="wdf-dropdown dropdown is-hoverable ';
        if (!empty($this->class)) {
            $markup .= 'dropdown-' . $this->class;
        }
        $markup .= '">

            <div class="dropdown-trigger dropdown-hover-trigger">
                <button class="button" aria-haspopup="true" aria-controls="dropdown-content">';
                    if (!empty($this->label)) {
                        $markup .= '<span>' . $this->label . '</span>';
                    }
                    $markup .= '<i class="dropdown-icon" aria-hidden="true"></i>
                </button>
            </div>

            <div class="dropdown-content">';
                if (!empty($this->subComponents)) {
                    $markup .= '<span>' . $this->subComponents . '</span>';
                }
            $markup .= '</div>

        </div>';

        return $markup;
    }
}
