require 'vagrant'
require 'yaml'

params_path = __dir__ + '/devops/parameters.yml'
params_path = params_path + '.dist' unless File.exist?(params_path)
params = YAML.load_file params_path
app_name = params['app_name']

ansible_dir = 'devops/ansible'

def require_plugin(name)
  unless Vagrant.has_plugin?(name)
    exec("vagrant plugin install #{name} && vagrant #{ARGV.join(' ')}") & exit
  end
end

is_windows = Vagrant::Util::Platform::windows?

require_plugin 'vagrant-hostmanager'

Vagrant.require_version '>= 1.8.1'

$prepare = <<SCRIPT
chown vagrant:vagrant /srv
DEBIAN_FRONTEND=noninteractive apt-get install python-pip sshpass -y
pip install --upgrade ansible
ansible-galaxy install -r /vagrant/#{ansible_dir}/requirements.yml
SCRIPT

Vagrant.configure(2) do |config|
  config.vm.box = 'ubuntu/wily64'

  # A private dhcp network is required for NFS and hostmanager to work
  config.vm.network :private_network, type: 'dhcp'

  config.vm.provider :virtualbox do |vb|
    vb.memory = 512
    vb.customize [:modifyvm, :id, '--natdnshostresolver1', :on]
    vb.customize ['setextradata', :id, 'VBoxInternal2/SharedFoldersEnableSymlinksCreate/v-root', '1']
    vb.check_guest_additions = false
  end

  config.vm.provision :shell, inline: $prepare

  config.vm.define 'dev', primary: true do |dev|
    dev.vm.hostname = "#{app_name}.dev"

    unless is_windows
      dev.vm.synced_folder '.', '/srv', type: 'nfs', mount_options: %w(rw vers=3 tcp fsc actimeo=2)
    end

    dev.vm.provision :ansible_local do |ansible|
      ansible.playbook = "#{ansible_dir}/playbook.yml"
      ansible.limit = :dev
      ansible.groups = {:vagrant => %w(dev)}
    end
  end

  config.hostmanager.enabled = true
  config.hostmanager.manage_host = true
  config.hostmanager.ignore_private_ip = false
  config.hostmanager.include_offline = true

  config.hostmanager.ip_resolver = proc do |vm|
    if vm.id
      vbox_cli_args = "guestproperty enumerate #{vm.id} -pattern '*/Net*/IP'"

      if is_windows
        if Vagrant::Util::Platform::cygwin?
          vbox_install_dir = Vagrant::Util::Platform::cygwin_path ENV[:VBOX_MSI_INSTALL_PATH]
        else
          vbox_install_dir = '/c/Program\ Files/Oracle/VirtualBox'
        end
        vbox_cmd = File.join vbox_install_dir, 'VBoxManage'

        result = `sh -c '#{vbox_cmd} #{vbox_cli_args}'`
      else
        result = `VBoxManage #{vbox_cli_args}`
      end

      result.match(/((172|168)\.\d+\.\d+\.\d+)/)
    end
  end

end