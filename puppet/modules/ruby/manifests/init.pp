class ruby {
  package {
    'ruby1.9.3':
    ensure => present,
    require => Exec['update-package-list'],
  }

  package {
    'bundler':
    ensure   => installed,
    provider => gem,
    require => Package['ruby1.9.3'],
  }
}