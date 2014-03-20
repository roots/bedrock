include_recipe "apt"

apt_repository "ondrej-systemd" do
  uri "http://ppa.launchpad.net/ondrej/systemd/ubuntu"
  distribution node["lsb"]["codename"]
  components ["main"]
  deb_src true
  keyserver "keyserver.ubuntu.com"
  key "E5267A6C"
end
apt_repository "ondrej-php55" do
  uri "http://ppa.launchpad.net/ondrej/php5/ubuntu"
  distribution node["lsb"]["codename"]
  components ["main"]
  deb_src true
  keyserver "keyserver.ubuntu.com"
  key "E5267A6C"
end
