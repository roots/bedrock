<?php
/**
 * Plugin Name: Multisite URL Fixer
 * Plugin URI: https://github.com/roots/bedrock/
 * Description: Fixes WordPress issues with home and site URL on multisite.
 * Version: 1.0.0
 * Author: Roots
 * Author URI: https://roots.io/
 * License: MIT License
 */

namespace Roots\Bedrock;

if (!is_multisite()) {
    return;
}

/**
 * Class URLFixer
 * @package Roots\Bedrock
 * @author Roots
 * @link https://roots.io/
 */
class URLFixer
{
    /** @var Roots\Bedrock\URLFixer Singleton instance */
    private static $instance = null;

    /**
     * Singleton.
     *
     * @return Roots\Bedrock\URLFixer
     */
    public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Add filters to verify / fix URLs.
     */
    public function addFilters()
    {
        add_filter('option_home', array($this, 'fixHomeUrl'));
        add_filter('option_siteurl', array($this, 'fixSiteUrl'));
        add_filter('network_site_url', array($this, 'fixNetworkSiteUrl'), 10, 3);
    }

    /**
     * Ensure that home URL does not contain the /wp subdirectory.
     *
     * @param string $value the unchecked home URL
     * @return string the verified home URL
     */
    public function fixHomeUrl($value)
    {
        if ('/wp' === substr($value, -3)) {
            $value = substr($value, 0, -3);
        }
        return $value;
    }

    /**
     * Ensure that site URL contains the /wp subdirectory.
     *
     * @param string $value the unchecked site URL
     * @return string the verified site URL
     */
    public function fixSiteUrl($value)
    {
        if ('/wp' !== substr($value, -3)) {
            $value .= '/wp';
        }
        return $value;
    }

    /**
     * Ensure that the network site URL contains the /wp subdirectory.
     *
     * @param string $url    the unchecked network site URL with path appended
     * @param string $path   the path for the URL
     * @param string $scheme the URL scheme
     * @return string the verified network site URL
     */
    public function fixNetworkSiteUrl($url, $path, $scheme)
    {
        $path = ltrim($path, '/');
        $url = substr($url, 0, strlen($url) - strlen($path));

        if ('wp/' !== substr($url, -3)) {
            $url .= 'wp/';
        }

        return $url . $path;
    }
}

URLFixer::instance()->addFilters();
