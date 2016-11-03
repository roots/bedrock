<?php

namespace WonderWp\Plugin\EspaceRestreint;

use Doctrine\ORM\Mapping as ORM;

/**
 * MembreEntity
 *
 * @ORM\Table(name="er_membre")
 * @ORM\Entity
 */
class MembreEntity extends \WonderWp\Entity\AbstractEntity
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
  * @ORM\Column(name="civilite", type="integer", nullable=false)
  */
 private $civilite;

 /**
  * @var string
  *
  * @ORM\Column(name="first_name", type="string", length=45, nullable=false)
  */
 private $firstName;

 /**
  * @var string
  *
  * @ORM\Column(name="last_name", type="string", length=45, nullable=false)
  */
 private $lastName;

 /**
  * @var \DateTime
  *
  * @ORM\Column(name="dob", type="date", nullable=false)
  */
 private $dob;

 /**
  * @var string
  *
  * @ORM\Column(name="adress", type="string", length=45, nullable=false)
  */
 private $adress;

 /**
  * @var string
  *
  * @ORM\Column(name="cp", type="string", length=10, nullable=false)
  */
 private $cp;

 /**
  * @var string
  *
  * @ORM\Column(name="city", type="string", length=45, nullable=false)
  */
 private $city;

 /**
  * @var integer
  *
  * @ORM\Column(name="country", type="integer", nullable=false)
  */
 private $country;

 /**
  * @var integer
  *
  * @ORM\Column(name="children", type="integer", nullable=true)
  */
 private $children;

 /**
  * @var string
  *
  * @ORM\Column(name="pseudo", type="string", length=45, nullable=false)
  */
 private $pseudo;

 /**
  * @var string
  *
  * @ORM\Column(name="email", type="string", length=45, nullable=false)
  */
 private $email;

 /**
  * @var string
  *
  * @ORM\Column(name="password", type="string", length=45, nullable=false)
  */
 private $password;

 /**
  * @var string
  *
  * @ORM\Column(name="code_parrain", type="string", length=45, nullable=true)
  */
 private $codeParrain;

 /**
  * @var integer
  *
  * @ORM\Column(name="conso_pommes", type="integer", nullable=true)
  */
 private $consoPommes;

 /**
  * @var boolean
  *
  * @ORM\Column(name="register_nl", type="boolean", nullable=true)
  */
 private $registerNl;


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
  * Set civilite
  *
  * @param integer $civilite
  * @return MembreEntity
  */
 public function setCivilite($civilite)
 {
  $this->civilite = $civilite;

  return $this;
 }

 /**
  * Get civilite
  *
  * @return integer 
  */
 public function getCivilite()
 {
  return $this->civilite;
 }

 /**
  * Set firstName
  *
  * @param string $firstName
  * @return MembreEntity
  */
 public function setFirstName($firstName)
 {
  $this->firstName = $firstName;

  return $this;
 }

 /**
  * Get firstName
  *
  * @return string 
  */
 public function getFirstName()
 {
  return $this->firstName;
 }

 /**
  * Set lastName
  *
  * @param string $lastName
  * @return MembreEntity
  */
 public function setLastName($lastName)
 {
  $this->lastName = $lastName;

  return $this;
 }

 /**
  * Get lastName
  *
  * @return string 
  */
 public function getLastName()
 {
  return $this->lastName;
 }

 /**
  * Set dob
  *
  * @param \DateTime $dob
  * @return MembreEntity
  */
 public function setDob($dob)
 {
  $this->dob = $dob;

  return $this;
 }

 /**
  * Get dob
  *
  * @return \DateTime 
  */
 public function getDob()
 {
  return $this->dob;
 }

 /**
  * Set adress
  *
  * @param string $adress
  * @return MembreEntity
  */
 public function setAdress($adress)
 {
  $this->adress = $adress;

  return $this;
 }

 /**
  * Get adress
  *
  * @return string 
  */
 public function getAdress()
 {
  return $this->adress;
 }

 /**
  * Set cp
  *
  * @param string $cp
  * @return MembreEntity
  */
 public function setCp($cp)
 {
  $this->cp = $cp;

  return $this;
 }

 /**
  * Get cp
  *
  * @return string 
  */
 public function getCp()
 {
  return $this->cp;
 }

 /**
  * Set city
  *
  * @param string $city
  * @return MembreEntity
  */
 public function setCity($city)
 {
  $this->city = $city;

  return $this;
 }

 /**
  * Get city
  *
  * @return string 
  */
 public function getCity()
 {
  return $this->city;
 }

 /**
  * Set country
  *
  * @param integer $country
  * @return MembreEntity
  */
 public function setCountry($country)
 {
  $this->country = $country;

  return $this;
 }

 /**
  * Get country
  *
  * @return integer 
  */
 public function getCountry()
 {
  return $this->country;
 }

 /**
  * Set children
  *
  * @param integer $children
  * @return MembreEntity
  */
 public function setChildren($children)
 {
  $this->children = $children;

  return $this;
 }

 /**
  * Get children
  *
  * @return integer 
  */
 public function getChildren()
 {
  return $this->children;
 }

 /**
  * Set pseudo
  *
  * @param string $pseudo
  * @return MembreEntity
  */
 public function setPseudo($pseudo)
 {
  $this->pseudo = $pseudo;

  return $this;
 }

 /**
  * Get pseudo
  *
  * @return string 
  */
 public function getPseudo()
 {
  return $this->pseudo;
 }

 /**
  * Set email
  *
  * @param string $email
  * @return MembreEntity
  */
 public function setEmail($email)
 {
  $this->email = $email;

  return $this;
 }

 /**
  * Get email
  *
  * @return string 
  */
 public function getEmail()
 {
  return $this->email;
 }

 /**
  * Set password
  *
  * @param string $password
  * @return MembreEntity
  */
 public function setPassword($password)
 {
  $this->password = $password;

  return $this;
 }

 /**
  * Get password
  *
  * @return string 
  */
 public function getPassword()
 {
  return $this->password;
 }

 /**
  * Set codeParrain
  *
  * @param string $codeParrain
  * @return MembreEntity
  */
 public function setCodeParrain($codeParrain)
 {
  $this->codeParrain = $codeParrain;

  return $this;
 }

 /**
  * Get codeParrain
  *
  * @return string 
  */
 public function getCodeParrain()
 {
  return $this->codeParrain;
 }

 /**
  * Set consoPommes
  *
  * @param integer $consoPommes
  * @return MembreEntity
  */
 public function setConsoPommes($consoPommes)
 {
  $this->consoPommes = $consoPommes;

  return $this;
 }

 /**
  * Get consoPommes
  *
  * @return integer 
  */
 public function getConsoPommes()
 {
  return $this->consoPommes;
 }

 /**
  * Set registerNl
  *
  * @param boolean $registerNl
  * @return MembreEntity
  */
 public function setRegisterNl($registerNl)
 {
  $this->registerNl = $registerNl;

  return $this;
 }

 /**
  * Get registerNl
  *
  * @return boolean 
  */
 public function getRegisterNl()
 {
  return $this->registerNl;
 }
}
