mysql_connection_info = {
  :host     => 'localhost',
  :username => 'root',
  :password => node['mysql']['server_root_password']
}

mysql_database node['default']['database']['name'] do
  connection mysql_connection_info
  action :create
end
