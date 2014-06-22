class nginx($webRoot) {
  exec {
    'add-nginx-repo':
    command => 'sudo add-apt-repository ppa:nginx/stable',
    unless => 'ls /etc/apt/sources.list.d/nginx-stable-precise.list',
    notify => Exec['update-for-repo'],
    require => Package['python-software-properties'],
  }

  package {
    'nginx':
    ensure => present,
    require => Exec['add-nginx-repo', 'update-for-repo'],
  }

  service {
    'nginx':
    ensure => running,
    require => Package['nginx'],
  }

  # Create the default virtual host file from the module.
  file {
    '/etc/nginx/sites-available/default':
    ensure => present,
    source => 'puppet:///modules/nginx/default',
    notify => Service['nginx'],
    require => Package['nginx'],
  }
}