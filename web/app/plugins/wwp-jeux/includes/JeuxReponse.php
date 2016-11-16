<?php

namespace WonderWp\Plugin\Jeux;

use Doctrine\ORM\Mapping as ORM;
use WonderWp\Entity\AbstractEntity;

/**
 * Jeuxreponse
 *
 * @ORM\Table(name="jeuxReponse", indexes={@ORM\Index(name="fk_jeux_reponse_jeux_questions1_idx", columns={"jeux_questions_id"})})
 * @ORM\Entity
 */
class JeuxReponse extends AbstractEntity
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
     * @var boolean
     *
     * @ORM\Column(name="is_correct", type="boolean", nullable=true)
     */
    private $isCorrect;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @var integer
     *
     * @ORM\Column(name="score", type="integer", nullable=true)
     */
    private $score;

    /**
     * @var JeuxQuestion
     *
     * @ORM\ManyToOne(targetEntity="JeuxQuestion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="jeux_questions_id", referencedColumnName="id")
     * })
     */
    private $question;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return JeuxReponse
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
     * @return JeuxReponse
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsCorrect()
    {
        return $this->isCorrect;
    }

    /**
     * @param boolean $isCorrect
     * @return JeuxReponse
     */
    public function setIsCorrect($isCorrect)
    {
        $this->isCorrect = $isCorrect;
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
     * @return JeuxReponse
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param int $score
     * @return JeuxReponse
     */
    public function setScore($score)
    {
        $this->score = $score;
        return $this;
    }

    /**
     * @return JeuxQuestion
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param JeuxQuestion $question
     * @return static
     */
    public function setQuestion($question)
    {
        $this->question = $question;
        return $this;
    }

}
