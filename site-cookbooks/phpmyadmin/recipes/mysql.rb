include_recipe "mysql::server"

sql_path = '/tmp/phpmyadmin_create_tables.sql'

template sql_path do
  source "mysql/create_tables.sql.erb"
  owner "root"
  group node['mysql']['root_group']
  mode "0644"
  action :create
end

execute "phpmyadmin-create-tables" do
  if node['mysql']['server_root_password'].empty?
    command "\"#{node['mysql']['mysql_bin']}\" -u root < \"#{sql_path}\""
  else
    command "\"#{node['mysql']['mysql_bin']}\" -u root '-p' \"#{node['mysql']['server_root_password']}\"} < \"#{sql_path}\""
  end
end

file sql_path do
  action :delete
  only_if { File.exists?(sql_path) }
end
