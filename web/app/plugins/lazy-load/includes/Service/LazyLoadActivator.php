<?php

namespace WonderWp\Plugin\LazyLoad\Service;


use WonderWp\Plugin\Core\Framework\AbstractPlugin\AbstractDoctrinePluginActivator;
use WonderWp\Framework\API\Result;

class LazyLoadActivator extends AbstractDoctrinePluginActivator
{

    /**
     * Create table for entity
     */
    public function activate()
    {
        $packageJson                                = json_decode(file_get_contents(ROOT_DIR . '/package.json'), true);
        $packageJson['dependencies']['jquery-lazy'] = "^1.7.7";
        $charWritten                                = file_put_contents(ROOT_DIR . '/package.json', json_encode($packageJson));


        if ($charWritten > 0) {
            return new Result(200);
        } else {
            return new Result(500, ['msg' => 'Unable to add psr entry to composer.json']);
        }
    }

}
