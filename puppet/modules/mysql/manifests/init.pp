class mysql($databaseName, $root, $rootPw) {
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
    unless  => "mysqladmin -u${root} -p${rootPw} status",
    command => "mysqladmin -u ${root} password ${rootPw}",
    require => Service['mysql']
  }

  # Create a new database.
  exec {
    'create-database':
    unless => "mysql -u${root} -p${rootPw} ${databaseName}",
    command => "mysql -u${root} -p${rootPw} -e \"create database ${databaseName};\"",
    require => Exec['set-mysql-root-password']
  }

  exec {
    'restore-mysql-database':
    unless => "mysql -u${root} -p123 -e \"select * from ${databaseName}.wp_posts;\"",
    command => "mysql -u${root} -p123 ${databaseName} < /vagrant/puppet/modules/mysql/files/${databaseName}.sql",
    require => Exec['create-database']
  }
}