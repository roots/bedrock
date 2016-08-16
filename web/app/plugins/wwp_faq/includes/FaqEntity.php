<?php

namespace WonderWp\Plugin\Faq;
use WonderWp\APlugin\AbstractEntity;

/**
 * Class Faq
 * @package WonderWp\Plugin\Faq
 * @Entity @Table(name="wwp_faq")
 **/
class FaqEntity extends AbstractEntity{

    /**
     * @Id @Column(type="integer", nullable=true) @GeneratedValue
     * @var int
     */
    protected $id;
    /**
     * @Column(type="string")
     * @var string
     */
    private $title;
    /**
     * @Column(type="text")
     * @var string
     */
    private $content;
    /**
     * @Column(type="string")
     * @var string
     */
    private $lang;
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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
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