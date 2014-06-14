class mysql($databaseName, $rootUsername, $rootPassword) {
  package {
    ['mysql-server']:
    ensure => present,
    require => Exec['update-package-list'],
  }

  service {
    'mysql':
    ensure => running,
    require => Package['mysql-server']
  }

  exec {
    'set-mysql-root-password':
    unless  => "mysqladmin -u${rootUsername} -p${rootPassword} status",
    command => "mysqladmin -u ${rootUsername} password ${rootPassword}",
    require => Service['mysql']
  }

  # Create a new database.
  exec {
    'create-database':
    unless => "mysql -u${rootUsername} -p${rootPassword} ${databaseName}",
    command => "mysql -u${rootUsername} -p${rootPassword} -e \"create database ${databaseName};\"",
    require => Exec['set-mysql-root-password']
  }
}