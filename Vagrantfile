# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = "efeqdev/wp-ubuntu-14.04"
  
  config.vm.synced_folder ".", "/var/www", id: "vagrant-root",
    owner: "vagrant",
    group: "vagrant",
    mount_options: ["dmode=777,fmode=777"]
  
  config.vm.network "private_network", ip: "192.168.33.10"
  
  config.vm.provider "virtualbox" do |vb|
     # Use VBoxManage to customize the VM. For example to change memory:
     vb.customize ["modifyvm", :id, "--memory", "1024"]
  end

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
