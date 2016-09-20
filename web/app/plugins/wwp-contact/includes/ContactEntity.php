<?php

namespace WonderWp\Plugin\Contact;


/**
 * ContactEntity
 *
 * @Table(name="contact")
 * @Entity
 */
class ContactEntity extends \WonderWp\Entity\AbstractEntity
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
     * @var string
     *
     * @Column(name="nom", type="string", length=45, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @Column(name="prenom", type="string", length=45, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @Column(name="mail", type="string", length=45, nullable=true)
     */
    private $mail;

    /**
     * @var string
     *
     * @Column(name="sujet", type="string", length=45, nullable=true)
     */
    private $sujet;

    /**
     * @var string
     *
     * @Column(name="message", type="text", length=65535, nullable=false)
     */
    private $message;

    /**
     * @var integer
     *
     * @Column(name="post", type="integer", nullable=false)
     */
    private $post;

    /**
     * @var \DateTime
     *
     * @Column(name="datetime", type="datetime", nullable=false)
     */
    private $datetime;

    /**
     * @var string
     *
     * @Column(name="locale", type="string", length=6, nullable=false)
     */
    private $locale;

    /**
     * @var string
     *
     * @Column(name="sentTo", type="string", length=45, nullable=true)
     */
    private $sentto;

    /**
     * @var ContactFormEntity
     *
     * @ManyToOne(targetEntity="ContactFormEntity")
     * @JoinColumns({
     *   @JoinColumn(name="form_id", referencedColumnName="id")
     * })
     */
    private $form;

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
     * Set nom
     *
     * @param string $nom
     * @return ContactEntity
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return ContactEntity
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return ContactEntity
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set sujet
     *
     * @param string $sujet
     * @return ContactEntity
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * Get sujet
     *
     * @return string
     */
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return ContactEntity
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set post
     *
     * @param integer $post
     * @return ContactEntity
     */
    public function setPost($post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return integer
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     * @return ContactEntity
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
     * Set locale
     *
     * @param string $locale
     * @return ContactEntity
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
     * Set sentto
     *
     * @param string $sentto
     * @return ContactEntity
     */
    public function setSentto($sentto)
    {
        $this->sentto = $sentto;

        return $this;
    }

    /**
     * Get sentto
     *
     * @return string
     */
    public function getSentto()
    {
        return $this->sentto;
    }

    /**
     * @return ContactFormEntity
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param ContactFormEntity $form
     */
    public function setForm($form)
    {
        $this->form = $form;
        return $this;
    }
}
