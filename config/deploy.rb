###### PIXELS deploy script           ######
###### Lukas Jakob Hafner - @saftsaak ######
###### 2016.12.01 – v1.3              ######

require_relative 'config.rb'

# by default we deploy to the same directory within wp-palvelu
if fetch(:wp_palvelu)
  set :deploy_to, "/data/wordpress"
else
  set :deploy_to, fetch(:deploy_custom_path) # change this to something else if using different host
end

# while developing plugins etc are installed on deploy through composer.json
if !fetch(:auto_update)
  puts "Deploying (Dev): WordPress and plugins are installed through Composer."
  set :linked_dirs, %w{web/app/uploads} # separate by spaces
else
  # only matters after handing over project
  puts "Deploying (Prod): WordPress and plugins are linked on server."
  set :linked_dirs, %w{web/app/uploads web/app/languages web/wp web/app/plugins web/app/mu-plugins} # separate by spaces
end

namespace :db do
  desc "Pull the remote database"
  task :pull do
    on roles(:web) do
      within release_path do
        with path: "#{fetch(:release_path)}vendor/wp-cli/wp-cli/bin:$PATH" do
          execute :wp, "db export #{fetch(:application)}.sql --path=web/wp"
          download! "#{release_path}/#{fetch(:application)}.sql", "#{fetch(:application)}.sql"
          execute :rm, "#{release_path}/#{fetch(:application)}.sql"
        end
      end
      run_locally do
        execute :wp, "db import #{fetch(:application)}.sql --path=web/wp"
        execute :rm, "#{fetch(:application)}.sql"
      end
    end
  end
  desc "Push the local database to remote"
  task :push do
    on roles(:web) do
      puts <<-EOF

      ************************** WARNING ***************************
      If you type [yes], this will push your local database to #{fetch(:stage)}.
      Any other input will cancel the operation.
      **************************************************************

      EOF
      ask :answer, "Are you sure you want overwrite the database on #{fetch(:stage)}?"

      if fetch(:answer) == 'yes'
        run_locally do
          execute :wp, "db export #{fetch(:application)}.sql --path=web/wp"
        end
        within release_path do
          with path: "#{fetch(:release_path)}vendor/wp-cli/wp-cli/bin:$PATH" do
            upload! "#{File.expand_path File.dirname(__FILE__)}/../#{fetch(:application)}.sql", "#{release_path}/#{fetch(:application)}.sql"
            execute :wp, "db import #{fetch(:application)}.sql --path=web/wp"
            execute :rm, "#{release_path}/#{fetch(:application)}.sql"
          end
        end
        run_locally do
          execute :rm, "#{fetch(:application)}.sql"
        end
      else
        puts "Cancelled."
      end
    end
  end
end

namespace :uploads do
  desc "Pull the remote uploaded files"
  task :pull do
    on roles(:all) do |host|
      puts "Fetching the uploads from #{fetch(:stage)}"
      system("rsync -avzh -e 'ssh -p#{fetch(:port)}' #{fetch(:user)}@#{host}:#{shared_path}/#{fetch(:uploads_path)} #{File.expand_path File.dirname(__FILE__)}/../web/app/")
    end
  end
  desc "Push uploaded files to remote"
  task :push do
    on roles(:all) do |host|
      puts "Pushing the uploads to #{fetch(:stage)}"

      puts <<-EOF

      ************************** WARNING ***************************
      If you type [yes], this will push your local uploads to #{fetch(:stage)}.
      Any other input will cancel the operation.
      **************************************************************

      EOF
      ask :answer, "Are you sure you want overwrite the uploads on #{fetch(:stage)}?"

      if fetch(:answer) == 'yes'
        system("rsync -avzh -e 'ssh -p#{fetch(:port)}' #{File.expand_path File.dirname(__FILE__)}/../#{fetch(:uploads_path)}/* #{fetch(:user)}@#{host}:#{shared_path}/#{fetch(:uploads_path)}")
      else
        puts "Cancelled."
      end
    end
  end
end

namespace :translations do
  desc "Pull the remote translations"
  task :pull do
    on roles(:all) do |host|
      puts "Fetching the translations from #{fetch(:stage)}"
      system("rsync -avzh -e 'ssh -p#{fetch(:port)}' #{fetch(:user)}@#{host}:#{shared_path}/#{fetch(:translations_path)} #{File.expand_path File.dirname(__FILE__)}/../web/app/")
    end
  end
end

namespace :plugins do
  desc "Pull the remote plugins"
  task :pull do
    on roles(:all) do |host|
      puts "Fetching the plugins from #{fetch(:stage)}"
      system("rsync -avzh -e 'ssh -p#{fetch(:port)}' #{fetch(:user)}@#{host}:#{shared_path}/#{fetch(:plugins_path)} #{File.expand_path File.dirname(__FILE__)}/../web/app/")
      puts "Fetching the must-use plugins from #{fetch(:stage)}"
      system("rsync -avzh -e 'ssh -p#{fetch(:port)}' #{fetch(:user)}@#{host}:#{shared_path}/#{fetch(:muplugins_path)} #{File.expand_path File.dirname(__FILE__)}/../web/app/")
    end
  end
  desc "Copy defined plugins from git to shared plugin folder"
  task :sync_into_shared do
    on roles(:web) do
      within release_path do
        puts "Copying defined plugins from repository to shared folder:"
        fetch(:plugins_to_sync).each do |plugin_name|
          if test "[ -d #{release_path}/#{fetch(:plugins_path)}/#{plugin_name} ]"
            puts "Copying #{plugin_name}"
            execute :rm, "-rf #{shared_path}/#{fetch(:plugins_path)}/#{plugin_name}"
            execute :cp, "-R #{release_path}/#{fetch(:plugins_path)}/#{plugin_name} #{shared_path}/#{fetch(:plugins_path)}/#{plugin_name}"
          end
        end
        puts "Copying defined must-use plugins from repository to shared folder:"
        fetch(:muplugins_to_sync).each do |plugin_name|
          if test "[ -d #{release_path}/#{fetch(:muplugins_path)}/#{plugin_name} ]"
            puts "Copying #{plugin_name}"
            execute :rm, "-rf #{shared_path}/#{fetch(:muplugins_path)}/#{plugin_name}"
            execute :cp, "-R #{release_path}/#{fetch(:muplugins_path)}/#{plugin_name} #{shared_path}/#{fetch(:muplugins_path)}/#{plugin_name}"
          end
        end
      end
    end
  end
  desc "Push a plugin to remote"
  task :push do

    plugin_name_question = "Please enter the slug of the plugin to push to #{fetch(:stage)}. (Empty to cancel)"

    ask :plugin_name, "#{plugin_name_question}"

    if fetch(:plugin_name) != "#{plugin_name_question}"
      ask :plugin_type, "Is this plugin normal (1) or must-use (2)"

      if fetch(:plugin_type) == '2'
        plugin_local_path = "#{File.expand_path File.dirname(__FILE__)}/../#{fetch(:muplugins_path)}/#{fetch(:plugin_name)}";
        plugin_remote_path = "#{shared_path}/#{fetch(:muplugins_path)}"
      else
        plugin_local_path = "#{File.expand_path File.dirname(__FILE__)}/../#{fetch(:plugins_path)}/#{fetch(:plugin_name)}";
        plugin_remote_path = "#{shared_path}/#{fetch(:plugins_path)}"
      end
      run_locally do
        if test "[ -d #{plugin_local_path} ]"
          on roles (:web) do
            system("rsync -avzh -e 'ssh -p#{fetch(:port)}' #{plugin_local_path} #{fetch(:user)}@#{host}:#{plugin_remote_path}")
          end
        else
          puts "Local plugin #{fetch(:plugin_name)} not found, please check spelling."
        end
      end
    else
      puts "Cancelled."
    end
  end
end

namespace :wp_palvelu do
  desc "Symlink necessary folders to rebuild wp-palvelu structure"
  task :symlinks do
    on roles (:web) do
      execute :ln, "-sfn #{release_path}/web #{deploy_to}/htdocs"
      execute :ln, "-sfn #{deploy_to}/htdocs/wp #{deploy_to}/htdocs/wordpress"
      execute :ln, "-sfn #{deploy_to}/htdocs/app #{deploy_to}/htdocs/wp-content"
      # for when not using composer to install plugins anymore
      if fetch(:auto_update)
        execute :ln, "-sfn #{release_path}/web/wp-config.php #{shared_path}/web/wp-config.php"
        execute :ln, "-sfn #{release_path}/config #{shared_path}/config"
        execute :ln, "-sfn #{release_path}/vendor #{shared_path}/vendor"
      end
    end
  end
  desc "Restart the server"
  task :restart do
    on roles (:web) do
      within release_path do
        execute "wp-purge-cache", raise_on_non_zero_exit: false
        execute "wp-restart-nginx", raise_on_non_zero_exit: false
        execute "wp-restart-php5-fpm", raise_on_non_zero_exit: false
        execute "wp-restart-php7-fpm", raise_on_non_zero_exit: false
      end
    end
  end
end

namespace :build_assets do
  desc "Create and push the build assets"
  task :push do
    set :server_theme_path, "#{release_path}/web/app/themes/#{fetch(:theme)}"
    set :local_theme_path, "#{File.expand_path File.dirname(__FILE__)}/../web/app/themes/#{fetch(:theme)}"
    run_locally do
      within "#{fetch(:local_theme_path)}" do
        if test "[ -f #{fetch(:local_theme_path)}/package.json ]"
          # Get dependencies with Hacher
          if test "which hacher > /dev/null 2>&1"
            execute :hacher, "get -k node_modules_theme_#{fetch(:application)} -f package.json"
            if test "[ -f #{fetch(:local_theme_path)}/bower.json ]"
              execute :hacher, "get -k bower_modules_theme_#{fetch(:application)} -f bower.json"
            end
          end
          execute :npm, 'install'
          execute :npm, 'run build:production'
          # Cache dependencies with Hacher
          if test "which hacher > /dev/null 2>&1"
            execute :hacher, "set -k node_modules_theme_#{fetch(:application)} -f package.json ./node_modules"
            if test "[ -f #{fetch(:local_theme_path)}/bower.json ]"
              execute :hacher, "set -k bower_modules_theme_#{fetch(:application)} -f bower.json ./bower_components"
            end
          end
        end
      end
    end
    on roles(:web) do
      within "#{fetch(:server_theme_path)}" do
        puts "Removing current production assets"
        execute :rm, "dist -rf"
        puts "Uploading new production assets to #{fetch(:server_theme_path)}/dist"
        upload! "#{fetch(:local_theme_path)}/dist/", "#{fetch(:server_theme_path)}", :recursive => true
        if test "[ -f #{fetch(:server_theme_path)}/composer.json ]"
          puts "Creating composer auto-load files"
          execute :composer, "dumpautoload -o"
        end
      end
    end
    run_locally do
      within "#{fetch(:local_theme_path)}" do
        if test "[ -f #{fetch(:local_theme_path)}/package.json ]"
          puts "Re-creating the local assets"
          execute :npm, "run build"
        end
      end
    end
  end
end

if fetch(:auto_update)
  before 'deploy:symlink:shared', 'plugins:sync_into_shared'
end

after 'deploy:updated', 'build_assets:push'

if fetch(:wp_palvelu)
  after 'deploy:publishing', 'wp_palvelu:symlinks'
  after 'deploy:finishing', 'wp_palvelu:restart'
end
