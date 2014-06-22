class php($webRoot) {
  exec {
   'add-php5-repo':
   command => 'sudo add-apt-repository ppa:ondrej/php5',
   unless => 'ls /etc/apt/sources.list.d/ondrej-php5-precise.list',
   notify => Exec['update-for-repo'],
   require => Package['python-software-properties'],
  }

  package {
    ['php5-fpm', 'php5-cli', 'php5-mysql']:
    ensure => present,
    require => Exec['add-php5-repo', 'update-for-repo'],
  }

  service {
    'php5-fpm':
    ensure => running,
    require => Package['php5-fpm'],
  }
}