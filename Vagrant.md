# Virtual machine

## Configuration

Set up domain names in `config/environments/hostnames.dev` and other environments as needed.

## Install dependencies

Vagrant requires berkshelf to be installed.

Either run `bundle install` to install all project gems (recommended)
or install `gem install berkshelf` only. 

## Vagrant

### Install Vagrant plugins

```
vagrant plugin install vagrant-berkshelf
vagrant plugin install vagrant-omnibus
vagrant plugin install vagrant-vbguest
vagrant plugin install vagrant-hostsupdater
```

### Using Vagrant

* Start/ Continue/ Setup machine: `vagrant up`
* Restart: `vagrant reload`
* Update provisioning: `vagrant provision`
* Pause machine: `vagrant suspend`
* Stop machine: `vagrant halt`
* Destroy machine (and all data): `vagrant destroy`

## Remote

### Provisioning

**todo** explain in more detail

```
# create node config and prepare remote host 
knife prepare [USER@]HOSTNAME
# adjust node config (see below)
$EDITOR nodes/HOSTNAME.json
# execute node config on remote host
knife cook [USER@]HOSTNAME
# cleanup secure passwords and temporary files
knife clean [USER@]HOSTNAME
```

This is what our example staging config looks like:

```json
{
  "override_attributes": {
    "default": {
      "nginx": {
        "wordpress": {
          "server_name": "staging.example.com" 
        },
        "protect": true
      }
    }
  },
  "run_list":[
    "role[staging]"
  ]
}
```

Subsequent changes can easily be applied using the `knife cook` command.
