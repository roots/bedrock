<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// Set common headers, to prevent warnings from plugins
$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.0';
$_SERVER['HTTP_USER_AGENT'] = '';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

// replace with file to your own project bootstrap
if(!defined('WP_USE_THEMES')){ define('WP_USE_THEMES', false); }
require_once( __DIR__.'/../web/wp/wp-blog-header.php' );
require_once( __DIR__.'/../vendor/wonderwp/wonderwp/src/Loader.php' );

// replace with mechanism to retrieve EntityManager in your app
$loader = \WonderWp\Bundle\Loader::getInstance();
$container = \WonderWp\Component\DependencyInjection\Container::getInstance();
$entityManager = $container->offsetGet('entityManager');

return ConsoleRunner::createHelperSet($entityManager);
