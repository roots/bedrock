name              "phpmyadmin"
maintainer        "Sebastian Johnsson"
maintainer_email  "sebastian@agiley.se"
license           "Apache 2.0"
description       "Installs and configures phpmyadmin"
version           "0.1.0"

recipe "phpmyadmin", "Installs phpmyadmin-package and initalizes configuration and mysql-setup."
recipe "phpmyadmin::configuration", "Configures phpmyadmin"
recipe "phpmyadmin::mysql", "Creates the phpmyadmin-database and sets database permissions"
recipe "phpmyadmin::apache2", "Configures phpmyadmin to be used with apache2"
recipe "phpmyadmin::nginx", "Configures phpmyadmin to be used with nginx"

%w{ ubuntu debian centos redhat amazon scientific oracle fedora }.each do |os|
  supports os
end

%w{ php }.each do |cb|
  depends cb
end

# Add attributes later.