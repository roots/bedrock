<?php

namespace Bedrock;

use Composer\Script\Event;

class Installer {
  public static $KEYS = array(
    'AUTH_KEY',
    'SECURE_AUTH_KEY',
    'LOGGED_IN_KEY',
    'NONCE_KEY',
    'AUTH_SALT',
    'SECURE_AUTH_SALT',
    'LOGGED_IN_SALT',
    'NONCE_SALT'
  );

  public static function addSalts(Event $event) {
    $root = dirname(dirname(__DIR__));
    $composer = $event->getComposer();
    $io = $event->getIO();

    if (!$io->isInteractive()) {
      $generate_salts = $composer->getConfig()->get('generate-salts');
    } else {
      $generate_salts = $io->askConfirmation('<info>Generate salts and append to .env file?</info> [<comment>Y,n</comment>]? ', true);
    }

    if (!$generate_salts) {
      return 1;
    }

    $salts = array_map(function ($key) {
      return sprintf("%s='%s'", $key, Installer::generate_salt());
    }, self::$KEYS);

    $env_file = "{$root}/.env";

    if (copy("{$root}/.env.example", $env_file)) {
      file_put_contents($env_file, implode($salts, "\n"), FILE_APPEND | LOCK_EX);
    } else {
      $io->write("<error>An error occured while copying your .env file</error>");
      return 1;
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

  public static function setupFolderStructure(Event $event) {
    $io = $event->getIO();
    $extra = $event->getComposer()->getPackage()->getExtra();
    $root = dirname(dirname(__DIR__));
    $wp_root = "{$root}/{$extra['webroot-dir']}";
    $wp_languages_folder = "{$root}/{$extra['wordpress-languages-dir']}";


    // Bedrock: Create a symlink for languages for support with plugins that uses
    // wp-content/languages instead of app/languages (WPML uses wp-content hard-coded).
    $target = $wp_languages_folder;
    $link = "{$wp_root}/wp-content/languages";
    if (!is_link($link) || !@readlink($link)) {
      if (!symlink($target, $link)) {
        $io->write("Could not create symlink from $target to $link.");
        exit(1);
      } else {
        $io->write("Created symlink $link => $target.");
      }
    }


    // Bedrock: Deal with plugins and themes, to allow installing languages when WPLANG is set.
    $mvs = array(
      "{$wp_root}/wp-content/plugins/*" => "{$root}/web/app/plugins/",
      "{$wp_root}/wp-content/themes/*" => "{$root}/web/app/themes/"
    );
    foreach ($mvs as $from => $targetDir) {
      $files = glob($from);
      if (count($files) !== 0) {
        foreach ($files as $file) {
          $from = $file;
          $filename = basename($file);
          $bits = explode(DIRECTORY_SEPARATOR, $file);
          $to = $targetDir . end($bits);

          if (file_exists($to) && !is_link($to)) {
            $io->write("Skip linking $from , already a folder / file.");
          } else {
            if (is_link($to)) {
              $io->write("Removing symlink from $to");
              exec("rm $to");
            }
            $cmd = "ln -s $from $to";
            $io->write("Creating symlink from $from => $to");
            exec($cmd);
          }

        }
      }
    }

  }
}
