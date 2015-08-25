# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/trusty64"

  #WordPress port
  config.vm.network "forwarded_port", guest: 8080, host: 8080

  #MariaDB/MySQL port
  config.vm.network "forwarded_port", guest: 8081, host: 8081

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  #
  # config.vm.provider "virtualbox" do |vb|
  #   # Display the VirtualBox GUI when booting the machine
  #   vb.gui = true
  #
  #   # Customize the amount of memory on the VM:
  #   vb.memory = "1024"
  # end
  #

  #Setup Docker and Run Images
  config.vm.provision "docker" do |d|
      d.pull_images "mariadb"
      d.pull_images "wordpress"
      d.run "mariadb",
            image: "mariadb",
            args: "-p 8081:3306 -e MYSQL_ROOT_PASSWORD=mysecretpassword"
      d.run "wordpress",
            args: "-p 8080:80 --link mariadb:mysql -v /vagrant:/var/www/html"
  end

  # Define a Vagrant Push strategy for pushing to Atlas. Other push strategies
  # such as FTP and Heroku are also available. See the documentation at
  # https://docs.vagrantup.com/v2/push/atlas.html for more information.
  # config.push.define "atlas" do |push|
  #   push.app = "YOUR_ATLAS_USERNAME/YOUR_APPLICATION_NAME"
  # end
end
