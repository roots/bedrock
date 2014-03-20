::Chef::Recipe.send(:include, Opscode::OpenSSL::Password)

# generate all passwords
node.set_unless[:phpmyadmin][:cfg][:blowfish_secret]          =   secure_password()
node.set_unless[:phpmyadmin][:cfg][:control_user_password]    =   secure_password()

template "#{node[:phpmyadmin][:cfg][:cfg_path]}/config-db.php" do
  source "phpmyadmin/config-db.php.erb"
  owner "root"
  group "root"
  mode 0644
end

template "#{node[:phpmyadmin][:cfg][:path]}/config.inc.php" do
  source "phpmyadmin/config.inc.php.erb"
  owner "root"
  group "root"
  mode 0644
end