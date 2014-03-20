#
# Cookbook Name:: default
# Recipe:: nginx
#

template "#{node['nginx']['dir']}/sites-available/wordpress" do
  source "wordpress-site.erb"
  owner "root"
  group "root"
  mode 00644
end

nginx_site 'default' do
  enable false
end

nginx_site 'wordpress' do
  enable true
end
