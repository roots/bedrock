set :application, 'theantichris.com'
set :repo_url, 'git@github.com:theantichris/theantichris.com.git'

set :branch, :master

set :deploy_to, "/usr/share/nginx/html/#{fetch(:application)}"

set :log_level, :debug
set :pty, true

set :linked_files, %w{.env}
set :linked_dirs, %w{web/app/uploads}

namespace :deploy do
  desc 'Restart application'
  task :restart do
    on roles(:app), in: :sequence, wait: 5 do
      sudo :service, :nginx, :reload
    end
  end
end

namespace :composer do
    task :install do
        on roles(:app) do
            within release_path do
               execute :composer, :install, '--no-dev'
            end
        end
    end
end

before 'deploy:updated', 'composer:install'
after 'deploy:publishing', 'deploy:restart'