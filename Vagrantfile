# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

wp_vm_hostnames = IO.readlines(File.join(File.dirname(__FILE__), 'config/environments/hostnames.dev'))

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "precise64"
  config.vm.box_url = "http://files.vagrantup.com/precise64.box"

  # networking
  config.vm.network :private_network, ip: "192.168.108.177"
  config.vm.hostname = "wordpress-vm.local"
  config.hostsupdater.aliases = wp_vm_hostnames
  config.ssh.forward_agent = true

  # set vagrant plugins
  config.omnibus.chef_version = :latest # latest chef
  config.vbguest.auto_update = false    # latest vbguest additions
  config.vbguest.no_remote = true
  config.berkshelf.enabled = true       # use berkshelf for chef dependencies

  # mount host directory, adjust group
  require 'rbconfig'
  ## enable NFS on non-windows platforms (increased disk performance for shared folder)
  case RbConfig::CONFIG['host_os']
    when /mswin|windows/i
      config.vm.synced_folder "./", "/var/www/",
        owner: "vagrant",
        group: "www-data",
        mount_options: ["dmode=775,fmode=764"]
    else
      config.vm.synced_folder "./", "/var/www/",
        nfs: true, nfs_version: 3, nfs_udp: false
  end

  config.vm.provider :virtualbox do |vb|
    vb.customize [
        "modifyvm", :id,
        "--name", config.vm.hostname,
        "--memory", "512"
    ]
  end

  # chef provisioning
  config.vm.provision :chef_solo do |chef|
    chef.json = {
        "default" => {
            "nginx" => {
                "wordpress" => {
                    "server_names" => wp_vm_hostnames
                }
            }
        }
    }
    chef.roles_path = "roles"
    chef.environments_path = "environments"
    chef.environment = "development"
    chef.data_bags_path = "data_bags"
    chef.add_role("development")
  end
end
