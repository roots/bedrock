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
     * @throws ConstantAlreadyDefinedException
     */
    public static function define($key, $value)
    {
        self::defined($key) or self::$configMap[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws UndefinedConfigKeyException
     */
    public static function get($key)
    {
        if (!array_key_exists($key, self::$configMap)) {
            $class = self::class;
            throw new UndefinedConfigKeyException("'$key' has not been set by $class::define('$key', ...)");
        }
        
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
        // Scan configMap to see if user is trying to redefine any constants.
        // We do this because we don't want to 'half apply' the configMap. The user should be able to catch the
        // exception, repair their config, and run apply() again
        foreach (self::$configMap as $key => $value) {
            try {
                self::defined($key);
            } catch (ConstantAlreadyDefinedException $e) {
                if (constant($key) !== $value) {
                    throw $e;
                }
            }
        }

        // If all is well, apply the configMap ignoring entries that have already been applied
        foreach (self::$configMap as $key => $value) {
            defined($key) or define($key, $value);
        }
    }
    
    /**
     * @param string $key
     * @return bool
     * @throws ConstantAlreadyDefinedException
     */
    private static function defined($key)
    {
        if (defined($key)) {
            $message = "Bedrock aborted trying to redefine constant '$key'";
            throw new ConstantAlreadyDefinedException($message);
        }
        
        return false;
    }
}
