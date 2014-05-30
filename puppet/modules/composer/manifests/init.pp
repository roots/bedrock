class composer {
  exec {
    'download-composer':
    command => 'curl -sS https://getcomposer.org/installer | php',
    unless => 'ls /usr/local/bin/composer',
    require => Package['curl', 'php5-cli']
  }

  # Move Composer to be accessed globally.
  exec {
    'move-composer':
    command => 'mv composer.phar /usr/local/bin/composer',
    unless => 'ls /usr/local/bin/composer',
    require => Exec['download-composer']
  }
}