set :stage, :staging

# Extended Server Syntax
# ======================
server '192.168.56.108', user: 'vagrant', password: 'vagrant', roles: %w{web app db}

set :ssh_options, {
  forward_agent: false,
  auth_methods: %w(password)
}

fetch(:default_env).merge!(wp_env: :staging)