<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 05/09/2016
 * Time: 16:00
 */
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// Set common headers, to prevent warnings from plugins
$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.0';
$_SERVER['HTTP_USER_AGENT'] = '';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

// replace with file to your own project bootstrap
if(!defined('WP_USE_THEMES')){ define('WP_USE_THEMES', false); }
require_once( __DIR__.'/../web/wp/wp-blog-header.php' );
require_once( __DIR__.'/../vendor/wonderwp/framework/src/WonderWp/Framework/Loader.php' );

// replace with mechanism to retrieve EntityManager in your app
$loader = \WonderWp\Framework\Loader::getInstance();
$container = \WonderWp\Framework\DependencyInjection\Container::getInstance();
$entityManager = $container->offsetGet('entityManager');

return ConsoleRunner::createHelperSet($entityManager);
