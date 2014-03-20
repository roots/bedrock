include_recipe "nginx"

config_path = "#{node[:nginx][:dir]}/sites-available/phpmyadmin.conf"

template config_path do
  source "nginx/phpmyadmin.conf.erb"
  owner "root"
  group "root"
  mode 0644
  if File.exists?(config_path)
    notifies :reload, resources(:service => "nginx"), :delayed
  end
end

nginx_site "phpmyadmin.conf" do
  enable enable_setting
end