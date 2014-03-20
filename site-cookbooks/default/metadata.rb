license          "Apache 2.0"
description      "Installs and configures development environment."
long_description IO.read(File.join(File.dirname(__FILE__), 'README.md'))
version          "1.0.0"

recipe            "default", "Common installation and configuration"
recipe            "default::nginx", "Installation and configuration for Nginx"
recipe            "default::php", "Installation and configuration for PHP"
recipe            "default::php_modules", "Installation and configuration for PHP Modules"

%w{ ubuntu debian }.each do |os|
  supports os
end
