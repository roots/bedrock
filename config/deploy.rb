set :application, 'yourprojectnamehere'
set :repo_url, 'git@github.com:gianthat/yourprojectnamehere.git'

# Branch options
# Prompts for the branch name (defaults to current branch)
#ask :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }

# Sets branch to current one
#set :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }

# Hardcodes branch to always be master
# This could be overridden in a stage config file

set :log_level, :info

set :linked_files, %w{.env web/.htaccess web/robots.txt}
set :linked_dirs, %w{web/app/uploads}

