<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 19/09/2016
 * Time: 16:24
 */

namespace WonderWp\Plugin\Newsletter;

use WonderWp\API\Result;

interface PasserelleInterface
{
    public function getOptions();
    public function syncListes();
    public function getSignupForm(NewsletterEntity $list);

    /**
     * @param array $data
     * @return Result
     */
    public function handleFormSubmit(array $data);
}