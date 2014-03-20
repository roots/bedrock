package "phpmyadmin"

include_recipe "phpmyadmin::configuration"
include_recipe "phpmyadmin::mysql"

if node['phpmyadmin']['webserver'] == "nginx"  
  include_recipe "phpmyadmin::nginx"
end

if node['phpmyadmin']['webserver'] == "apache2"
  include_recipe "phpmyadmin::apache2"
end