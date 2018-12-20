class secretagent::apache {
  $secgen_parameters = secgen_functions::get_parameters($::base64_inputs_file)
  $port = $secgen_parameters['port'][0]
  $docroot = '/var/www/secretagent'

  class { '::apache':
    default_vhost => false,
    default_mods => 'php',
    overwrite_ports => false,
  }

  ::apache::vhost { 'secretagent':
    port    => $port,
    docroot => $docroot,
  }
}