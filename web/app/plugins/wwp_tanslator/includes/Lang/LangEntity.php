<?php

namespace WonderWp\Plugin\Translator;
use WonderWp\APlugin\AbstractEntity;

/**
 * Class Faq
 * @package WonderWp\Plugin\Translator
 * @Entity @Table(name="wwp_lang")
 **/
class LangEntity extends AbstractEntity{

    /**
     * @Id @Column(type="integer", nullable=true) @GeneratedValue
     * @var int
     */
    private $id;
    /**
     * @Column(type="string")
     * @var string
     */
    private $title;
    /**
     * @Column(type="string")
     * @var string
     */
    private $locale;
    /**
     * @Column(type="integer")
     * @var int
     */
    private $arbo;
    /**
     * @Column(type="boolean", nullable=true)
     * @var bool
     */
    private $isActive;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return int
     */
    public function getArbo()
    {
        return $this->arbo;
    }

    /**
     * @param int $arbo
     */
    public function setArbo($arbo)
    {
        $this->arbo = $arbo;
    }

    /**
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

}