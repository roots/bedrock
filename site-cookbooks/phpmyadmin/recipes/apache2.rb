include_recipe "apache2"

link "#{node['apache']['dir']}/sites-available/phpmyadmin" do
    action :create
    to "#{node[:phpmyadmin][:apache2][:site_config]}"
end

apache_site "phpmyadmin"