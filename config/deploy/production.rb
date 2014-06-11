set :stage, :production

# Extended Server Syntax
# ======================
server 'web02.theantichris.com:25000', user: 'christopher', roles: %w{web app db}

set :ssh_options, {
    keys: %w(/home/vagrant/.ssh/id_rsa),
    forward_agent: false
}

fetch(:default_env).merge!(wp_env: :production)

