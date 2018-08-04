<?php

namespace Roots\Bedrock;

/**
 * Class Config
 * @package Roots\Bedrock
 */
class Config
{
    /**
     * @var array
     */
    private static $configMap = [];

    /**
     * @param string $key
     * @param $value
     */
    public static function define($key, $value)
    {
        self::$configMap[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public static function get($key)
    {
        return self::$configMap[$key];
    }

    /**
     * @param string $key
     */
    public static function remove($key)
    {
        unset(self::$configMap[$key]);
    }

    /**
     * define() all values in $configMap and throw an exception if we are attempting to redefine a constant.
     *
     * We throw the exception because a silent rejection of a configuration value is unacceptable. This method fails
     * fast before undefined behavior propagates due to unexpected configuration sneaking through.
     *
     * ```
     * define('BEDROCK', 'no');
     * define('BEDROCK', 'yes');
     * echo BEDROCK;
     * // output: 'no'
     * ```
     *
     * vs.
     *
     * ```
     * define('BEDROCK', 'no');
     * Config::define('BEDROCK', 'yes');
     * Config::apply();
     * // output: Fatal error: Uncaught Roots\Bedrock\ConstantAlreadyDefinedException ...
     * ```
     *
     * @throws ConstantAlreadyDefinedException
     */
    public static function apply()
    {
        foreach (self::$configMap as $key => $value) {
            if (defined($key)) {
                $previous = constant($key);
                $message = "Bedrock is trying to define '$key' as '$value' but it is already set to '$previous'.";
                throw new ConstantAlreadyDefinedException($message);
            }
            define($key, $value);
        }
    }
}
