set :stage, :staging
set :branch, :dev
set :deploy_to, "/home/www-data/staging.academy.unitedworldwrestling.org"
set :shared_path, "/home/www-data/efs_share/staging.academy.unitedworldwrestling.org/shared"

server "uww-staging-web-3.nine.ch", user: "www-data", roles: %w{app db web}
server "uww-staging-web-4.nine.ch", user: "www-data", roles: %w{app db web}

# you can set custom ssh options
# it's possible to pass any option but you need to keep in mind that net/ssh understand limited list of options
# you can see them in [net/ssh documentation](http://net-ssh.github.io/net-ssh/classes/Net/SSH.html#method-c-start)
# set it globally
#  set :ssh_options, {
#    keys: %w(~/.ssh/id_rsa),
#    forward_agent: false,
#    auth_methods: %w(password)
#  }

fetch(:default_env).merge!(wp_env: :staging)

SSHKit.config.command_map[:composer] = "/home/www-data/bin/composer"