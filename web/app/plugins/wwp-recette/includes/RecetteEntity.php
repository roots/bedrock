<?php

namespace WonderWp\Plugin\Recette;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use WonderWp\DI\Container;
use WonderWp\Entity\WP\Comment;
use WonderWp\Entity\WP\CommentMeta;
use WonderWp\Plugin\Vote\VoteEntity;

/**
 * RecetteEntity
 *
 * @Table(name="recette")
 * @Entity
 */
class RecetteEntity extends \WonderWp\Entity\AbstractEntity
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
     * @Column(name="media", type="string", length=140, nullable=true)
     */
    private $media;

    /**
     * @var string
     *
     * @Column(name="title", type="string", length=140, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @Column(name="locale", type="string", length=6, nullable=false)
     */
    private $locale;

    /**
     * @var string
     *
     * @Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    //-----------------------------------------------------------------------------//

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     * @var Collection
     *
     * @OneToMany(targetEntity="RecetteMeta", mappedBy="recette")
     */
    private $metas;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ManyToMany(targetEntity="Ingredient", inversedBy="recettes")
     * @JoinTable(name="recette_has_ingredient",
     *   joinColumns={
     *     @JoinColumn(name="recette_id", referencedColumnName="id")
     *
     *   },
     *   inverseJoinColumns={
     *     @JoinColumn(name="ingredient_id", referencedColumnName="id")
     *   }
     * )
     */
    private $ingredients;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     * @var Collection
     *
     * @OneToMany(targetEntity="RecetteEtape", mappedBy="recette")
     */
    private $etapes;

    private $ratings;
    private $comments;


    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }


    /**
     * - Getters and setters ------------------------------------------------------
     */


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
     * Set media
     *
     * @param string $media
     * @return RecetteEntity
     */
    public function setMedia($media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return string
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return RecetteEntity
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return RecetteEntity
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getMetas()
    {
        return $this->metas;
    }

    /**
     * @param mixed $metas
     */
    public function setMetas($metas)
    {
        $this->metas = $metas;
    }

    /**
     * @param $metaKey
     * @return RecetteMeta|null
     */
    public function getMeta($metaKey)
    {
        $newCol = $this->metas->filter(function($item) use($metaKey) {
            /** @var $item RecetteMeta */
            return $item->getName() == $metaKey;
        });

        return $newCol->first();
    }

    /**
     * @return mixed
     */
    public function getEtapes()
    {
        if (is_null($this->etapes)) {
            $this->etapes = new ArrayCollection();
        }
        return $this->etapes;
    }

    /**
     * @param mixed $etapes
     */
    public function setEtapes($etapes)
    {
        $this->etapes = $etapes;
    }

    /**
     * @return Collection
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * @param Collection $ingredients
     */
    public function setIngredient($ingredients)
    {
        $this->ingredients = $ingredients;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * - Relation management ------------------------------------------------------
     */

    /**
     * RecetteMeta $meta
     */
    public function addMeta(RecetteMeta $meta)
    {
        if (is_null($this->metas)) {
            $this->metas = new ArrayCollection();
        }
        if ($this->metas->contains($meta)) {
            return false;
        }
        $this->metas->add($meta);
        return true;
    }

    public function removeMeta(RecetteMeta $meta)
    {
        if (is_null($this->metas)) {
            $this->metas = new ArrayCollection();
        }
        if (!$this->metas->contains($meta)) {
            return false;
        }
        $this->metas->removeElement($meta);
        return true;
    }

    /**
     * @param Ingredient $ingredient
     * @return bool,
     */
    public function addIngredient(Ingredient $ingredient)
    {
        if (is_null($this->ingredients)) {
            $this->ingredients = new ArrayCollection();
        }

        $colIngredienIds = $this->ingredients->map(function ($entity) {
            return $entity->getId();
        })->toArray();

        if (in_array($ingredient->getId(), $colIngredienIds)) {
            return false;
        }

        $this->ingredients->add($ingredient);
        $ingredient->addRecette($this);
        return true;
    }

    /**
     * @param Ingredient $ingredient
     * @return bool
     */
    public function removeIngredient(Ingredient $ingredient)
    {
        if (is_null($this->ingredients)) {
            $this->ingredients = new ArrayCollection();
        }

        $colIngredientIds = $this->ingredients->map(function ($entity) {
            return $entity->getId();
        })->toArray();

        if (!in_array($ingredient->getId(), $colIngredientIds)) {
            return false;
        }

        $this->ingredients->removeElement($ingredient);
        $ingredient->removeRecette($this);
        return true;
    }

    /**
     * @param RecetteEtape $etape
     * @return bool
     */
    public function addEtape(RecetteEtape $etape)
    {
        if (is_null($this->etapes)) {
            $this->etapes = new ArrayCollection();
        }

        $colIngredienIds = $this->etapes->map(function ($entity) {
            return $entity->getId();
        })->toArray();

        if (in_array($etape->getId(), $colIngredienIds)) {
            return false;
        }

        $this->etapes->add($etape);
        return true;
    }

    /**
     * @param RecetteEtape $etape
     * @return bool
     */
    public function removeEtape(RecetteEtape $etape)
    {
        if (is_null($this->etapes)) {
            $this->etapes = new ArrayCollection();
        }

        $colIngredientIds = $this->etapes->map(function ($entity) {
            return $entity->getId();
        })->toArray();

        if (!in_array($etape->getId(), $colIngredientIds)) {
            return false;
        }

        $this->etapes->removeElement($etape);
        return true;
    }

    public function getRatings()
    {
        if(empty($this->ratings)) {
            $average = 0;
            if ($this->id > 0) {
                /** @var EntityRepository $repository */
                $em = Container::getInstance()->offsetGet('entityManager');
                $repository = $em->getRepository(VoteEntity::class);
                $votes = $repository->findBy([
                    "entityname" => str_replace('\\', '', RecetteEntity::class),
                    "entityid" => $this->id
                ]);
                $score = 0;
                if (!empty($votes)) {
                    foreach ($votes as $v) {
                        /** @var $v VoteEntity */
                        $score += $v->getScore();
                    }
                }
                $nbVotes = count($votes);
                if ($nbVotes > 0) {
                    $average = round($score / $nbVotes);
                }
            }
            $this->ratings = $average;
        }
        return $this->ratings;
    }

    public function getComments(){
        if(empty($this->comments)){
            $metaKey = 'entity';
            $metaVal = RecetteEntity::class.'#'.$this->id;
            /** @var EntityManager $em */
            //$em = Container::getInstance()->offsetGet('entityManager');
            /** @var Query $qb */
            /*$qb = $em->createQueryBuilder();

            $this->comments = $qb->select('c')
                ->from(Comment::class, 'c')
                ->leftJoin('c.metas', 'm')
                ->where('m.key = :keyName')
                ->andWhere('m.value = :value')
                ->setParameters(array(
                    'keyName' => $metaKey,
                    'value' => $metaVal,
                ))
                ->getQuery()
                ->getResult()
            ;*/
            $this->comments = get_comments([
                'meta_key' => $metaKey,
                'meta_value' => $metaVal,
            ]);

        }
        return $this->comments;
    }

    public function getCategory(){
        return 'Smoothie';
    }
}
