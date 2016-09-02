<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 02/09/2016
 * Time: 10:08
 */

namespace WonderWp\Plugin\Faq;

use Doctrine\ORM\EntityRepository;
use WonderWp\APlugin\AbstractPluginFrontendController;

class FaqPublicController extends AbstractPluginFrontendController{

    public function handleShortcode($atts)
    {
        if(empty($atts['locale'])){
            $atts['locale'] = get_locale();
        }
        return $this->listAction($atts);
    }

    public function listAction($atts){

        /** @var EntityRepository $repository */
        $repository = $this->_entityManager->getRepository(FaqEntity::class);
        $filters = array('lang'=>$atts['locale']);
        $questions = $repository->findBy($filters);

        return $this->renderView('list',['questions'=>$questions]);
    }

}