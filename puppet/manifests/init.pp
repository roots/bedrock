Exec { path => [ "/bin/", "/usr/bin/", "/usr/local/bin/" ] }

$webRoot = '/vagrant/web'

# This update will run every vagrant up or provision.
exec {
  'update-package-list':
  command => 'sudo apt-get update',
}

# This update gets notified when a new repo is added to sources.list.d.
exec {
  'sudo apt-get update':
  refreshonly => true,
}

# Install basic packages.
package {
  ['git', 'curl', 'python-software-properties', 'python', 'g++', 'make']:
  ensure => present,
  require => Exec['update-package-list']
}

host {
  'theantichris.dev':
  ip => '127.0.1.1'
}

include composer, ruby

class {
  'mysql':
  databaseName => 'theantichris_dev',
  rootUsername => 'root',
  rootPassword => '123',
}

class {
  'nginx':
  webRoot => $webRoot,
}

class {
  'php':
  webRoot => $webRoot,
}