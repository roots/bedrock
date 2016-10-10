<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 02/09/2016
 * Time: 10:08
 */

namespace WonderWp\Plugin\Recette;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use WonderWp\APlugin\AbstractPluginFrontendController;
use WonderWp\HttpFoundation\Request;
use WonderWp\Theme\ThemeQueryService;

class RecettePublicController extends AbstractPluginFrontendController
{

    public function handleShortcode($atts)
    {
        if (empty($atts['locale'])) {
            $atts['locale'] = get_locale();
        }
        if (empty($atts['vue'])) {
            $atts['vue'] = 'grid';
        }
        return parent::handleShortcode($atts);
    }

    public function defaultAction($atts)
    {
        return $this->listAction($atts); // TODO: Change the autogenerated stub
    }

    public function listAction($atts)
    {

        /** @var EntityRepository $repository */
        $repository = $this->_entityManager->getRepository(RecetteEntity::class);
        $filters = array();//'lang'=>$atts['locale']
        $recettes = $repository->findBy($filters);

        $viewContent = $this->renderView($atts['vue'], ['recettes' => $recettes]);
        return $viewContent;
    }

    public function recetteAction($recetteSlug)
    {
        /** @var EntityRepository $repository */
        $repository = $this->_entityManager->getRepository(RecetteEntity::class);
        $recetteQuery = $repository->findBy(['slug' => $recetteSlug]);
        if (empty($recetteQuery[0])) {
            return false;
        }
        /** @var RecetteEntity $recette */
        $recette = $recetteQuery[0];

        /** @var QueryBuilder $qb */
        $qb = $this->_entityManager->createQueryBuilder();

        $otherRecipes = $qb->select('r')
            ->from(RecetteEntity::class, 'r')
            ->where('r.id <> ?1')
            ->addSelect('RAND() as HIDDEN rand')
            ->orderBy('rand')
            ->setMaxResults(4)
            ->setParameters(array(1 => $recette->getId()))
            ->getQuery()
            ->getResult();

        $title = $recette->getTitle();
        $post = new \stdClass();
        $post->ID = 0;
        $post->post_title = $title;
        $post->post_name = sanitize_title($title);
        $post->post_content = $this->renderView('recette', ['recette' => $recette, 'otherRecipes' => $otherRecipes]);
        $metas = new \stdClass();
        $metas->seopanel = [
            0 => [
                'desc' => $recette->getDescription(),
                'classes' => 'recipe'
            ]
        ];
        $post->metas = $metas;

        /** @var ThemeQueryService $qs */
        $qs = wwp_get_theme_service('query');
        $qs->resetPost($post);
    }

}