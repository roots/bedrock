###### PIXELS env deploy script config ######
###### Lukas Jakob Hafner - @saftsaak  ######
###### 2016.12.01 – v1.3               ######

set :stage, :production
set :port, 00000

server "#{fetch(:user)}.wp.pixels.fi:#{fetch(:port)}", user: fetch(:user), roles: %w{web app db}

fetch(:default_env).merge!(wp_env: :production)
