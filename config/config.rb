###### PIXELS deploy script config    ######
###### Lukas Jakob Hafner - @saftsaak ######
###### 2016.12.01 – v1.3              ######

# basic
set :application, 'bedrock'
set :user, 'bedrock'
set :theme, fetch(:application)

# repository
set :repo_url, "git@github.com:pixelshelsinki/#{fetch(:application)}.git"
set :branch, :master
set :log_level, :info

# settings
set :wp_palvelu, true # this is hosted on wp-palvelu
set :deploy_custom_path, "/var/www/#{fetch(:application)}" # this will be used when not deploying to wp-palvelu
set :auto_update, false # project has been handed over to client
set :plugins_to_sync, %W{#{fetch(:application)}} # separate by spaces
set :muplugins_to_sync, %w{} # separate by spaces
set :linked_files, %w{.env}

# structure
set :uploads_path, "web/app/uploads"
set :translations_path, "web/app/languages"
set :plugins_path, "web/app/plugins"
set :muplugins_path, "web/app/mu-plugins"
