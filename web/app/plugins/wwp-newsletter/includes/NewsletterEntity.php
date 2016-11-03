<?php

namespace WonderWp\Plugin\Newsletter;
use Doctrine\ORM\Mapping as ORM;
use WonderWp\Entity\AbstractEntity;

/**
 * NewsletterEntity
 *
 * @ORM\Table(name="wwp_nllist")
 * @ORM\Entity
 */
class NewsletterEntity extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=45, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45, nullable=false)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="subscribers", type="integer", nullable=true)
     */
    private $subscribers;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="string", length=255, nullable=true)
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
