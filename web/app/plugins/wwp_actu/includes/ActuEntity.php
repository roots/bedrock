<?php

namespace WonderWp\Plugin\Actu;
use WonderWp\Entity\AbstractEntity;

/**
 * Class Actu
 * @package WonderWp\Plugin\Actu
 * @Entity @Table(name="wwp_actu")
 **/
class ActuEntity extends AbstractEntity{

    /**
     * @Id @Column(type="integer") @GeneratedValue
     * @var int
     */
    private $id;
    /**
     * @Column(type="string")
     * @var string
     */
    private $title;

    /**
     * @Column(type="integer", nullable=true)
     * @var int
     */
    private $category;
    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    private $visual;

    /**
     * @Column(type="text")
     * @var string
     */
    private $content;
    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    private $date;
    /**
     * @Column(type="string")
     * @var string
     */
    private $lang;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param int $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getVisual()
    {
        return $this->visual;
    }

    /**
     * @param string $visual
     */
    public function setVisual($visual)
    {
        $this->visual = $visual;
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
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
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

}