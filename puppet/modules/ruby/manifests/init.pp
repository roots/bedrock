class ruby {
  package {
    'ruby':
    ensure => present,
    require => Exec['update-package-list'],
  }

  package {
    'bundler':
    ensure   => installed,
    provider => gem,
    require => Package['ruby'],
  }
}