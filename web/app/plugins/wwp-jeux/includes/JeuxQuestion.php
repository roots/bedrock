<?php

namespace WonderWp\Plugin\Jeux;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use WonderWp\Entity\AbstractEntity;

/**
 * Jeuxquestion
 *
 * @ORM\Table(name="jeuxQuestion", indexes={@ORM\Index(name="fk_jeux_questions_jeux1_idx", columns={"jeux_id"})})
 * @ORM\Entity
 */
class JeuxQuestion extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=140, nullable=true)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="visuel", type="string", length=140, nullable=true)
     */
    private $visuel;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=true)
     */
    private $contenu;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @var \Jeux
     *
     * @ORM\ManyToOne(targetEntity="JeuxEntity")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="jeux_id", referencedColumnName="id")
     * })
     */
    private $jeux;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="JeuxReponse", mappedBy="question")
     */
    private $reponses;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return JeuxQuestion
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     * @return JeuxQuestion
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * @return string
     */
    public function getVisuel()
    {
        return $this->visuel;
    }

    /**
     * @param string $visuel
     * @return static
     */
    public function setVisuel($visuel)
    {
        $this->visuel = $visuel;
        return $this;
    }

    /**
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * @param string $contenu
     * @return static
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
        return $this;
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
     * @return JeuxQuestion
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return \Jeux
     */
    public function getJeux()
    {
        return $this->jeux;
    }

    /**
     * @param \Jeux $jeux
     * @return JeuxQuestion
     */
    public function setJeux($jeux)
    {
        $this->jeux = $jeux;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getReponses()
    {
        return $this->reponses;
    }

    /**
     * @param Collection $reponses
     * @return static
     */
    public function setReponses($reponses)
    {
        $this->reponses = $reponses;
        return $this;
    }

}
