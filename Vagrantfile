# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|

  config.vm.box = "iPaya/php-7.0"
  config.vm.hostname = "ipaya.cn"

  config.vm.provider "virtualbox" do |v|
    v.memory = 1024
  end

  config.vm.provision :shell do |shell|
    shell.path = './vagrant/provision/once-as-vagrant.sh'
	shell.privileged = false
	shell.args = [
	  ENV["GITHUB_TOKEN"] || "",
	]
  end
end