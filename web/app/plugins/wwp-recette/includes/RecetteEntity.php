<?php

namespace WonderWp\Plugin\Recette;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use WonderWp\DI\Container;
use WonderWp\Entity\AbstractEntity;
use WonderWp\Entity\WP\Comment;
use WonderWp\Entity\WP\CommentMeta;
use WonderWp\Plugin\Vote\VoteEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * RecetteEntity
 *
 * @ORM\Table(name="recette")
 * @ORM\Entity(repositoryClass="WonderWp\Plugin\Recette\RecetteRepository")
 */
class RecetteEntity extends AbstractEntity
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
     * @ORM\Column(name="media", type="string", length=140, nullable=true)
     */
    private $media;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=140, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=6, nullable=false)
     */
    private $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    //-----------------------------------------------------------------------------//

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="RecetteMeta", mappedBy="recette")
     */
    private $metas;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ingredient", inversedBy="recettes")
     * @ORM\JoinTable(name="recette_has_ingredient",
     *   joinColumns={
     *     @ORM\JoinColumn(name="recette_id", referencedColumnName="id")
     *
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ingredient_id", referencedColumnName="id")
     *   }
     * )
     */
    private $ingredients;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="RecetteEtape", mappedBy="recette")
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
        if (!$this->etapes->contains($etape)) {
            $this->etapes->add($etape);
            $etape->setRecette($this);
        }

        return $this;
    }

    /**
     * @param RecetteEtape $etape
     * @return bool
     */
    public function removeEtape(RecetteEtape $etape)
    {
        if ($this->etapes->contains($etape)) {
            $this->etapes->removeElement($etape);
            $etape->setRecette(null);
        }
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
                $max=0;
                $min=10000;
                if (!empty($votes)) {
                    foreach ($votes as $v) {
                        /** @var $v VoteEntity */
                        $thisScore = $v->getScore();
                        $score += $thisScore;
                        if($thisScore<$min){ $min = $thisScore; }
                        if($thisScore>$max){ $max = $thisScore; }
                    }
                }
                $nbVotes = count($votes);
                if ($nbVotes > 0) {
                    $average = round($score / $nbVotes);
                }
            }
            $this->ratings = array(
                'average'=>$average,
                'count'=>$nbVotes,
                'min'=>$min,
                'max'=>$max
            );
        }
        return $this->ratings;
    }

    public function getComments(){
        if(empty($this->comments)){
            $metaKey = 'entity';
            $metaVal = RecetteEntity::class.'#'.$this->id;

            $this->comments = get_comments([
                'meta_key' => $metaKey,
                'meta_value' => $metaVal,
            ]);

        }
        return $this->comments;
    }

    public function getCategory(){
        $catMeta = $this->getMeta('metas_type_plat');
        $catId = is_object($catMeta) ? $catMeta->getVal() : '';
        if(!empty($catId)) {
            $cat = get_category($catId);
            return __('term_'.$cat->slug,'WWP_THEME_TEXTDOMAIN');
        }
        return null;
    }
}
