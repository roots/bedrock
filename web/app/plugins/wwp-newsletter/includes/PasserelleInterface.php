<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 19/09/2016
 * Time: 16:24
 */

namespace WonderWp\Plugin\Newsletter;

interface PasserelleInterface
{
    public function getOptions();
    public function syncListes();
    public function getSignupForm(NewsletterEntity $list);
}