class php($webRoot) {
  exec {
   'add-php5-repo':
   command => 'sudo add-apt-repository ppa:ondrej/php5',
   unless => 'ls /etc/apt/sources.list.d/ondrej-php5-precise.list',
   notify => Exec['sudo apt-get update'],
   require => Package['python-software-properties'],
  }

  package {
    ['php5-fpm', 'php5-cli', 'php5-mysql']:
    ensure => present,
    require => Exec['add-php5-repo', 'update-package-list'],
  }

  service {
    'php5-fpm':
    ensure => running,
    require => Package['php5-fpm'],
  }

  file {
    '/etc/php5/fpm/pool.d/www.conf':
    ensure => present,
    source => 'puppet:///modules/php/www.conf',
    notify => Service['php5-fpm'],
    require => Package['php5-fpm'],
  }

  file {
    "${webRoot}/phpinfo.php":
    ensure => present,
    source => 'puppet:///modules/php/phpinfo.php',
    require => Service['php5-fpm'],
  }
}