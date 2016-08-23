<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 17/08/2016
 * Time: 17:50
 */

namespace WonderWp\Plugin\Translator;

use Doctrine\ORM\EntityRepository;
use WonderWp\HttpFoundation\Request;

class LangRepository extends EntityRepository{

    public function getCurrentLang(){
        $res = null;
        $request = Request::getInstance();
        $session = $request->getSession();
        $storedLocale = $session->get('locale');

        if($storedLocale) {
            $res = $this->findOneBy(array(
                'locale' => $storedLocale
            ));
        }

        return $res;
    }

}