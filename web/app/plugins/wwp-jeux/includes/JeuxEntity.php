<?php

namespace WonderWp\Plugin\Jeux;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * JeuxEntity
 *
 * @ORM\Table(name="jeux")
 * @ORM\Entity
 */
class JeuxEntity extends \WonderWp\Entity\AbstractEntity
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
     * @var string
     *
     * @ORM\Column(name="visuel", type="string", length=140, nullable=true)
     */
    private $visuel;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=45, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=true)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="starts_at", type="datetime", nullable=true)
     */
    private $startsAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ends_at", type="datetime", nullable=true)
     */
    private $endsAt;

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=6, nullable=false)
     */
    private $locale;

    /**
     * @var integer
     *
     * @ORM\Column(name="page_dotation", type="integer", nullable=true)
     */
    private $pageDotation;

    /**
     * @var integer
     *
     * @ORM\Column(name="page_reglement", type="integer", nullable=true)
     */
    private $pageReglement;

    /**
     * @var integer
     *
     * @ORM\Column(name="page_gagnants", type="integer", nullable=true)
     */
    private $pageGagnants;

    /**
     * @var integer
     *
     * @ORM\Column(name="mecanique_gain", type="string", length=45, nullable=true)
     */
    private $mecaniqueGain;


    //-----------------------------------------------------------------------------//

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="JeuxQuestion", mappedBy="jeux")
     */
    private $questions;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="JeuxLot", mappedBy="jeux")
     */
    private $lots;

    public function __construct()
    {
        $this->lots = new ArrayCollection();
        $this->questions = new ArrayCollection();
    }

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
     * Set visuel
     *
     * @param string $visuel
     * @return JeuxEntity
     */
    public function setVisuel($visuel)
    {
        $this->visuel = $visuel;

        return $this;
    }

    /**
     * Get visuel
     *
     * @return string
     */
    public function getVisuel()
    {
        return $this->visuel;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return JeuxEntity
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return JeuxEntity
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set locale
     *
     * @param string $locale
     * @return JeuxEntity
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set startsAt
     *
     * @param \DateTime $startsAt
     * @return JeuxEntity
     */
    public function setStartsAt($startsAt)
    {
        $this->startsAt = $startsAt;

        return $this;
    }

    /**
     * Get startsAt
     *
     * @return \DateTime
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * Set endsAt
     *
     * @param \DateTime $endsAt
     * @return JeuxEntity
     */
    public function setEndsAt($endsAt)
    {
        $this->endsAt = $endsAt;

        return $this;
    }

    /**
     * Get endsAt
     *
     * @return \DateTime
     */
    public function getEndsAt()
    {
        return $this->endsAt;
    }

    /**
     * Set pageDotation
     *
     * @param integer $pageDotation
     * @return JeuxEntity
     */
    public function setPageDotation($pageDotation)
    {
        $this->pageDotation = $pageDotation;

        return $this;
    }

    /**
     * Get pageDotation
     *
     * @return integer
     */
    public function getPageDotation()
    {
        return $this->pageDotation;
    }

    /**
     * Set pageReglement
     *
     * @param integer $pageReglement
     * @return JeuxEntity
     */
    public function setPageReglement($pageReglement)
    {
        $this->pageReglement = $pageReglement;

        return $this;
    }

    /**
     * Get pageReglement
     *
     * @return integer
     */
    public function getPageReglement()
    {
        return $this->pageReglement;
    }

    /**
     * Set pageGagnants
     *
     * @param integer $pageGagnants
     * @return JeuxEntity
     */
    public function setPageGagnants($pageGagnants)
    {
        $this->pageGagnants = $pageGagnants;

        return $this;
    }

    /**
     * Get pageGagnants
     *
     * @return integer
     */
    public function getPageGagnants()
    {
        return $this->pageGagnants;
    }

    /**
     * Set mecaniqueGain
     *
     * @param integer $mecaniqueGain
     * @return JeuxEntity
     */
    public function setMecaniqueGain($mecaniqueGain)
    {
        $this->mecaniqueGain = $mecaniqueGain;

        return $this;
    }

    /**
     * Get mecaniqueGain
     *
     * @return integer
     */
    public function getMecaniqueGain()
    {
        return $this->mecaniqueGain;
    }

    /**
     * @return Collection
     */
    public function getLots()
    {
        return $this->lots;
    }

    /**
     * @param Collection $lots
     * @return JeuxEntity
     */
    public function setLots($lots)
    {
        $this->lots = $lots;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param Collection $questions
     * @return static
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;
        return $this;
    }

}
