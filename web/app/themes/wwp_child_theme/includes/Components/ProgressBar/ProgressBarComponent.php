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
        $markup = '';

        $markup .= '<div class="progress-bar-component">

                <progress id="progress" value="' . $this->value . '" max="100">
                   <span id="progress-bar"></span>
                </progress>

                <div class="numbers">
                   <span class="start">0%</span>
                   <span class="cursor" style="left:calc(' . $this->value . '% - 10px);">' . $this->value . '%</span>
                   <span class="end">100%</span>
                </div>

            </div>';

        return $markup;
    }
}
