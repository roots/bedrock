<?php

namespace WonderWp\Plugin\Jeux;
use Symfony\Component\HttpFoundation\Cookie;
use WonderWp\APlugin\AbstractPluginFrontendController;
use WonderWp\APlugin\ManagerInterface;
use WonderWp\HttpFoundation\Request;

/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/11/2016
 * Time: 10:53
 */
class JeuxPublicController extends AbstractPluginFrontendController
{

    public function handleShortcode($atts){
        if(!empty($atts['presentation'])){
            $pres = $atts['presentation'];
            return $this->$pres($atts);
        }
    }

    private function presentation($atts){
        $repository = $this->_entityManager->getRepository(JeuxEntity::class);
        $jeux = $repository->find($atts['jeux']);
        return $this->renderView('presentation', ['jeux' => $jeux]);
    }

    private function jeux($atts){
        $repository = $this->_entityManager->getRepository(JeuxEntity::class);
        /** @var JeuxEntity $jeux */
        $jeux = $repository->find($atts['jeux']);

        /* @var $jeuxFormService \WonderWp\Plugin\Jeux\JeuxFormService */
        $jeuxFormService = $this->_manager->getService('jeuxForm');
        $jeuxForm = $jeuxFormService->getJeuxFrontForm($jeux);

        $request = Request::getInstance();

        $cookieName = md5('wwp-jeux-'.$jeux->getId());
        $cookies = $request->cookies;
        $dejaJoue = $cookies->has($cookieName);

        if($request->getMethod()=='POST'){
            $result = $jeuxFormService->handleRequest($jeux,$request->request->all());
            if($request->isXmlHttpRequest()){
                header('Content-Type: application/json');
                echo $result;
                die();
            } else {
                $success = ($result->getCode()==200);
                $request->getSession()->getFlashbag()->add('jeux', [($success ? 'success' : 'error'), $result->getData('msg')]);
                if($success){
                    $expires = !empty($jeux->getEndsAt()) ? $jeux->getEndsAt()->format('U') : time()+(60*60*24*7*30*6); //or in 6 month
                        $dejaJoueSession = $request->getSession()->get('wwp-jeux-deja-joue');
                    if(empty($dejaJoueSession)){
                        $dejaJoueSession = array();
                    }
                    $dejaJoueSession[$jeux->getId()] = [$cookieName,$expires];
                    $request->getSession()->set('wwp-jeux-deja-joue',$dejaJoueSession);
                    $dejaJoue=true;
                }
            }
        }

        /** @var ThemeViewService $viewService */
        $viewService = wwp_get_theme_service('view');
        $notifications = $viewService->flashesToNotifications('jeux');

        return $this->renderView('jeux', ['jeux' => $jeux, 'jeuxForm'=>$jeuxForm,'notifications'=>$notifications,'dejaJoue'=>$dejaJoue]);
    }

    private function lots($atts){
        $repository = $this->_entityManager->getRepository(JeuxEntity::class);
        $jeux = $repository->find($atts['jeux']);

        return $this->renderView('lots', ['jeux' => $jeux]);
    }

}