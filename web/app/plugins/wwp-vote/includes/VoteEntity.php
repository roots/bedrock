<?php

namespace WonderWp\Plugin\Vote;



/**
 * VoteEntity
 *
 * @Table(name="vote")
 * @Entity
 */
class VoteEntity extends \WonderWp\Entity\AbstractEntity
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
  * @Column(name="score", type="integer", nullable=false)
  */
 private $score;

 /**
  * @var string
  *
  * @Column(name="entityName", type="string", length=45, nullable=false)
  */
 private $entityname;

 /**
  * @var string
  *
  * @Column(name="entityId", type="string", length=45, nullable=false)
  */
 private $entityid;

 /**
  * @var \DateTime
  *
  * @Column(name="datetime", type="datetime", nullable=false)
  */
 private $datetime;

 /**
  * @var string
  *
  * @Column(name="ip", type="string", length=45, nullable=true)
  */
 private $ip;


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
  * Set score
  *
  * @param integer $score
  * @return VoteEntity
  */
 public function setScore($score)
 {
  $this->score = $score;

  return $this;
 }

 /**
  * Get score
  *
  * @return integer 
  */
 public function getScore()
 {
  return $this->score;
 }

 /**
  * Set entityname
  *
  * @param string $entityname
  * @return VoteEntity
  */
 public function setEntityname($entityname)
 {
  $this->entityname = $entityname;

  return $this;
 }

 /**
  * Get entityname
  *
  * @return string 
  */
 public function getEntityname()
 {
  return $this->entityname;
 }

 /**
  * Set entityid
  *
  * @param string $entityid
  * @return VoteEntity
  */
 public function setEntityid($entityid)
 {
  $this->entityid = $entityid;

  return $this;
 }

 /**
  * Get entityid
  *
  * @return string 
  */
 public function getEntityid()
 {
  return $this->entityid;
 }

 /**
  * Set datetime
  *
  * @param \DateTime $datetime
  * @return VoteEntity
  */
 public function setDatetime($datetime)
 {
  $this->datetime = $datetime;

  return $this;
 }

 /**
  * Get datetime
  *
  * @return \DateTime 
  */
 public function getDatetime()
 {
  return $this->datetime;
 }

 /**
  * Set ip
  *
  * @param string $ip
  * @return VoteEntity
  */
 public function setIp($ip)
 {
  $this->ip = $ip;

  return $this;
 }

 /**
  * Get ip
  *
  * @return string 
  */
 public function getIp()
 {
  return $this->ip;
 }
}
