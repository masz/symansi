Vagrant.configure("2") do |config|
    config.ssh.forward_agent = true
    config.hostmanager.enabled = true
    config.hostmanager.manage_host = true

    config.vm.define "symfony-dev-box" do |node|
        node.vm.box = "bento/ubuntu-18.04"
        node.vm.hostname = "symfony-dev-box"
        node.vm.network "private_network", ip: "192.168.100.100"
        node.hostmanager.aliases = [
            "symfony.localhost"
        ]
        node.vm.synced_folder ".", "/vagrant", disabled: true
        node.vm.synced_folder "ansible/", "/var/ansible"
        node.vm.synced_folder "symfony/", "/var/www/symfony"
        node.vm.provision "ansible_local" do |ansible|
            ansible.playbook = "/var/ansible/dev.yml"
            ansible.provisioning_path =  "/var/ansible"
            ansible.inventory_path = "/var/ansible/hosts"
            ansible.limit = "dev"
            ansible.compatibility_mode = "2.0"
        end
    end
end
