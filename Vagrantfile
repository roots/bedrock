# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = "digitalquery/wpvagrant"
  #config.vm.box = "ubuntu/trusty64"

  config.vm.provider :virtualbox do |vb|

    # Set VM memory size
    vb.customize ["modifyvm", :id, "--memory", "512"]

    # these 2 commands massively speed up DNS resolution, which means outbound
    # connections don't take forever (eg the WP admin dashboard and update page)
    vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    vb.customize ["modifyvm", :id, "--natdnsproxy1", "on"]

  end

  config.vm.network "private_network", ip: "192.168.50.2"
  config.vm.hostname = "wpvagrant.dev"
  config.hostsupdater.remove_on_suspend = true

  # Vagrant triggers
  config.trigger.before :destroy, :stdout => true do
    info "Dumping the database before destroying the VM..."
    run  "vagrant ssh -c 'sh /vagrant/wp-vagrant/mysql/db_dump.sh'"
  end

  # provisioning script
  provisioning_file = 'wp-vagrant/bootstrap.sh'
  if ( File.file?(provisioning_file) )
    config.vm.provision "shell" do |s|
      s.path = provisioning_file
    end
  end

end
