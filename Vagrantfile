# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = "ubuntu/trusty64"
  
  config.vm.synced_folder ".", "/var/www", id: "vagrant-root",
    owner: "vagrant",
    group: "www-data"
  
  # Here set a local ip address that doesn't conflict with one in your /etc/hosts file - 192.168.33.## 
  config.vm.network "private_network", ip: "change me"
  # Since others may be working on this repo as well, there may be conflicts with what other devs have setup locally so this may need to change once others are involved.
  
  config.vm.provider "virtualbox" do |vb|
     # Use VBoxManage to customize the VM. For example to change memory:
     vb.customize ["modifyvm", :id, "--memory", "2048"]
  end

  # Need to set encoding so vars_prompt works in ansible playbook
  # see https://github.com/mitchellh/vagrant/issues/2924
  ENV['PYTHONIOENCODING'] = "utf-8"

  config.vm.provision "ansible" do |ansible|
    ansible.limit = 'all'
    ansible.sudo = true
    ansible.inventory_path = "provisioning/hosts"
    # ansible.verbose = "vvvv"
    ansible.playbook = "provisioning/playbooks/wp-lamp-setup.yml"
  end

  config.vm.provision "shell", inline: "sudo service apache2 restart", run: "always"

  # Remove provision check files on vagrant destroy
  config.trigger.before :destroy do
    run_remote 'rm -rf /var/www/web/provision-checks/*txt'
  end
end
