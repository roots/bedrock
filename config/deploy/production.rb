set :stage, :production
set :branch, :master
set :deploy_to, "/var/www/vhosts/changethisherelinetosuityourneeds.com/httpdocs/production"
set :tmp_dir, "/var/www/vhosts/changethisherelinetosuityourneeds.com/tmp"


# Extended Server Syntax
# ======================
server 'yo.ur.ip.add.ress', user: 'yourwebuser', roles: %w{web app db}

# you can set custom ssh options
# it's possible to pass any option but you need to keep in mind that net/ssh understand limited list of options
# you can see them in [net/ssh documentation](http://net-ssh.github.io/net-ssh/classes/Net/SSH.html#method-c-start)
# set it globally
#  set :ssh_options, {
#    user: fetch(:user)
#  }

fetch(:default_env).merge!(wp_env: :staging)
