<?php

namespace WonderWp\Theme\Child\Components\ProgressBar;

use WonderWp\Theme\Core\Component\AbstractComponent;

class ProgressBarComponent extends AbstractComponent
{
    /**
     * @var integer
     */
    private $value;

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     *
     * @return ProgressBarComponent
     */
    public function setValue(int $value): ProgressBarComponent
    {
        $this->value = $value;

        return $this;
    }

    public function getMarkup(array $opts = [])
    {
        $markup = '

                <progress class="progress-bar-component" id="progress" value="' . $this->value . '" max="100">
                   <span id="progress-bar"></span>
                </progress>

            ';

        return $markup;
    }
}
