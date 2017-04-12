<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 09:55
 */

namespace WonderWp\Theme\Components;


use Symfony\Component\HttpFoundation\Cookie;
use WonderWp\Framework\DependencyInjection\Container;
use WonderWp\Framework\HttpFoundation\Request;

class CookieComponent extends AbstractComponent
{

    public function getMarkup($opts=array())
    {
        $bandeau = null;

        $cookieName = 'AcceptsCookie';

        /*if(isset($_COOKIE[$cookieName])) {
            unset($_COOKIE[$cookieName]);
            setcookie($cookieName, '', time() - 3600); // empty value and old timestamp
        }*/

        $cookies = Request::getInstance()->cookies;
        $cookieSet = $cookies->has($cookieName);

        if (!empty($opts['force']) || !$cookieSet) {
            $bandeau = '
        <div class="cookies-wrap active">
            <p>' . __('cookies.txt.trad', WWP_THEME_TEXTDOMAIN) . '</p>
            <a href="' . __('cookies.link.trad', WWP_THEME_TEXTDOMAIN) . '">' . __('cookies.link.title.trad', WWP_THEME_TEXTDOMAIN) . '</a>
            <button class="btn btn-secondary">' . __('cookies.btn.trad', WWP_THEME_TEXTDOMAIN) . '</button>
        </div>';
        }

        if(empty($opts['force']) && !empty($bandeau) && !$cookieSet){
            $cookie = new Cookie($cookieName,true,time()+(60*60*24*7*30*6)); //Expires in 6 months
            setcookie($cookie->getName(),$cookie->getValue(),$cookie->getExpiresTime());
        }

        return $bandeau;
    }

}
