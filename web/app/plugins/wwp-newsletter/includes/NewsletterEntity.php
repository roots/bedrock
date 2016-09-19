<?php

namespace WonderWp\Plugin\Newsletter;


/**
 * NewsletterEntity
 *
 * @Table(name="wwp_nllist")
 * @Entity
 */
class NewsletterEntity extends \WonderWp\Entity\AbstractEntity
{
    /**
     * @var string
     *
     * @Column(name="id", type="string", length=45, nullable=false)
     * @Id
     * @GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="title", type="string", length=45, nullable=false)
     */
    private $title;

    /**
     * @var integer
     *
     * @Column(name="subscribers", type="integer", nullable=true)
     */
    private $subscribers;

    /**
     * @var string
     *
     * @Column(name="data", type="string", length=255, nullable=true)
     */
    private $data;

    /**
     * Get id
     *
     * @return integer
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
        return $this;
    }

    /**
     * Set title
     *
     * @param integer $title
     * @return NewsletterEntity
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return integer
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set subscribers
     *
     * @param integer $subscribers
     * @return NewsletterEntity
     */
    public function setSubscribers($subscribers)
    {
        $this->subscribers = $subscribers;

        return $this;
    }

    /**
     * Get subscribers
     *
     * @return integer
     */
    public function getSubscribers()
    {
        return $this->subscribers;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return json_decode($this->data);
    }

    /**
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = json_encode($data);
        return $this;
    }


}
