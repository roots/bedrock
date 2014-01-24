<?php

namespace Bedrock;

use Composer\Script\Event;

class Installer {
  public static $env_vars = array();

  public static $salt_keys = array(
    'AUTH_KEY',
    'SECURE_AUTH_KEY',
    'LOGGED_IN_KEY',
    'NONCE_KEY',
    'AUTH_SALT',
    'SECURE_AUTH_SALT',
    'LOGGED_IN_SALT',
    'NONCE_SALT'
  );

  public static function createEnv(Event $event) {
    $root = dirname(dirname(__DIR__));
    $composer = $event->getComposer();
    $io = $event->getIO();

    $domain = basename($root);
    $env = array(
      'WP_ENV' => array(
        'default'  => 'development',
        'question' => 'Environment',
      ),
      'DOMAIN_CURRENT_SITE' => array(
        'default'  => $domain,
        'question' => '(Main site) Domain Name',
      ),
      'DB_NAME' => array(
        'default'  => $domain,
        'question' => 'Database Name',
      ),
      'DB_USER' => array(
        'default'  => 'wp',
        'question' => 'Database User',
      ),
      'DB_PASSWORD' => array(
        'default'  => 'wp',
        'question' => 'Database Password',
      ),
      'DB_HOST' => array(
        'default'  => 'localhost',
        'question' => 'Database Host',
      ),
    );

    if (!$io->isInteractive()) {
      array_walk(
        $env,
        function(&$props, $key) {
          $props = $props['default'];
          if ('DB_NAME' === $key || 'DB_USER' === $key) {
            $props = self::stripNonAlphaNumerics($props);
          }
        }
      );
      self::$env_vars = $env;

      $generate_salts = $composer->getConfig()->get('generate-salts');
    }
    else {
      foreach ($env as $key => $props) {
        $value = $io->ask(sprintf('<info>%s</info> [<comment>%s</comment>] ', $props['question'], $props['default']), $props['default']);
        if ('DB_NAME' === $key || 'DB_USER' === $key) {
          $value = self::stripNonAlphaNumerics($value);
          if (empty($value)) {
      $value = $props['default'];
          }
        }

        self::$env_vars[$key] = $value;
      }

      $generate_salts = $io->askConfirmation('<info>Generate salts?</info> [<comment>Y,n</comment>]? ', true);
    }

    self::$env_vars['WP_HOME']    = sprintf('http://%s', self::$env_vars['DOMAIN_CURRENT_SITE']);
    self::$env_vars['WP_SITEURL'] = sprintf('%s/wp', self::$env_vars['WP_HOME']);

    if ($generate_salts) {
      foreach (self::$salt_keys as $key) {
        self::$env_vars[$key] = self::generate_salt();
      }
    }

    $env_file = $root . '/.env';
    $env_vars = array();
    foreach (self::$env_vars as $key => $value) {
      $env_vars[] = sprintf("%s='%s'", $key, $value);
    }
    $env_vars = implode("\n", $env_vars) . "\n";

    try {
      file_put_contents($env_file, $env_vars, LOCK_EX);
      $io->write("<info>.env file successfully created.</info>");
    } catch (\Exception $e) {
      $io->write('<error>An error occured while creating your .env file. Error message:</error>');
      $io->write(sprintf('<error>%s</error>%s', $e->getMessage(), "\n"));
      $io->write('<info>Below is the environment variables generated:</info>');
      $io->write($env_vars);
    }
  }

  /**
   * Slightly modified/simpler version of wp_generate_password
   * https://github.com/WordPress/WordPress/blob/cd8cedc40d768e9e1d5a5f5a08f1bd677c804cb9/wp-includes/pluggable.php#L1575
   */
  public static function generate_salt($length = 64) {
    $chars  = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $chars .= '!@#$%^&*()';
    $chars .= '-_ []{}<>~`+=,.;:/?|';

    $salt = '';
    for ($i = 0; $i < $length; $i++) {
      $salt .= substr($chars, rand(0, strlen($chars) - 1), 1);
    }

    return $salt;
  }

  public static function stripNonAlphaNumerics($string) {
    return preg_replace('/[^a-zA-Z0-9_]+/', '_', $string);
  }
}
