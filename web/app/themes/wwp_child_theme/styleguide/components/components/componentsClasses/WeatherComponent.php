<?php
/**
 * Created by PhpStorm.
 * User: Erick
 * Date: 08/03/2017
 * Time: 17:46
 */

namespace WonderWp\Theme\Components;

class WeatherComponent extends AbstractComponent
{

    private $day;
    private $icon;
    private $temperature;

    /**
     * @return mixed
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param mixed $day
     * @return static
     */
    public function setDay($day)
    {
        $this->day = $day;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     * @return static
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * @param mixed $temperature
     * @return static
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;
        return $this;
    }

    public function getMarkup($opts = array())
    {
        $markup = '<div class="block-weather-item">
            <div class="block-weather-day" > ' . $this->getDay() . '</div >
            
            <div class="block-weather-ico" >' . getSvgIcon($this->getIcon()) . '</div >
            
            <div class="block-weather-temperature">' . round($this->getTemperature()) . '&deg;</div>
          </div >';

        return $markup;
    }
}
