<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 19/09/2016
 * Time: 16:15
 */

namespace WonderWp\Plugin\Newsletter;


use WonderWp\Plugin\Newsletter\MailChimp\MailChimpPasserelle;
use WonderWp\Services\AbstractService;

class NewsletterPasserelleService extends AbstractService
{
    public function getPasserelles(){
        $passerelles = array(
            MailChimpPasserelle::class
        );
        return $passerelles;
    }
}