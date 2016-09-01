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
  * @var integer
  *
  * @Column(name="id", type="integer", nullable=false)
  * @Id
  * @GeneratedValue(strategy="AUTO")
  */
 private $id;

 /**
  * @var integer
  *
  * @Column(name="title", type="integer", nullable=false)
  */
 private $title;

 /**
  * @var integer
  *
  * @Column(name="subscribers", type="integer", nullable=true)
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
}
