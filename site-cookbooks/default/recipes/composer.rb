include_recipe "composer"

composer_project "/var/www/" do
  dev true
  action :install
end
