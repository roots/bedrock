<?php

namespace WonderWp\Plugin\Newsletter;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nllist
 *
 * @ORM\Table(name="nllist")
 * @ORM\Entity
 */
class Nllist extends \WonderWp\APlugin\AbstractEntity
{
 /**
  * @var integer
  *
  * @ORM\Column(name="id", type="integer", nullable=false)
  * @ORM\Id
  * @ORM\GeneratedValue(strategy="AUTO")
  */
 private $id;

 /**
  * @var integer
  *
  * @ORM\Column(name="title", type="integer", nullable=false)
  */
 private $title;

 /**
  * @var integer
  *
  * @ORM\Column(name="subscribers", type="integer", nullable=true)
  */
 private $subscribers;


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
  * Set title
  *
  * @param integer $title
  * @return Nllist
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
  * @return Nllist
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
}
