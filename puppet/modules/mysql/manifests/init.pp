class mysql {
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
    unless  => 'mysqladmin -uroot -p123 status',
    command => 'mysqladmin -u root password 123',
    require => Service['mysql']
  }

  # Create a new database.
  exec {
    'create-database':
    unless => 'mysql -uroot -p123 theantichris_dev',
    command => 'mysql -uroot -p123 -e "create database theantichris_dev;"',
    require => Exec['set-mysql-root-password']
  }

  exec {
    'restore-mysql-database':
    unless => 'mysql -uroot -p123 -e "select * from theantichris_dev.wp_posts;"',
    command => "mysql -uroot -p123 theantichris_dev < /vagrant/puppet/modules/mysql/files/theantichris_dev.sql",
    require => Exec['create-database']
  }
}