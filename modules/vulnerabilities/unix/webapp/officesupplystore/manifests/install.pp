class officesupplystore::install {
  $secgen_parameters = secgen_functions::get_parameters($::base64_inputs_file)

  # Parse out parameters
  $admin_flag = $secgen_parameters['strings_to_leak'][0]
  $root_file_flag = $secgen_parameters['strings_to_leak'][1]
  $db_token_flag = $secgen_parameters['strings_to_leak'][2]
  $accounts = $secgen_parameters['accounts']
  $domain = $secgen_parameters['domain'][0]
  $db_password = $secgen_parameters['db_password'][0]

  $docroot = '/var/www/officesupplystore'
  $db_username = 'officesupply'

  Exec { path => ['/bin', '/usr/bin', '/usr/local/bin', '/sbin', '/usr/sbin'], }

  file { "$docroot/index.html":
    ensure => absent,
    notify => File[$docroot],
  }

  # Copy www-data to server
  file { $docroot:
    ensure => directory,
    recurse => true,
    mode   => '0600',
    owner => 'www-data',
    group => 'www-data',
    source => 'puppet:///modules/officesupplystore/www-data',
    notify => File["$docroot/mysql.php"],
  }

  # Apply templates
  file { "$docroot/mysql.php":
    mode   => '0600',
    owner => 'www-data',
    group => 'www-data',
    content => template('officesupplystore/mysql.php.erb'),
    notify => File["/tmp/officesupply.sql"],
  }

  # Database Setup
  file { "/tmp/officesupply.sql":
    owner  => root,
    group  => root,
    mode   => '0600',
    ensure => file,
    content => template('officesupplystore/officesupply.sql.erb'),
    notify => File["/tmp/mysql_setup.sh"],
  }

  file { "/tmp/mysql_setup.sh":
    owner  => root,
    group  => root,
    mode   => '0700',
    ensure => file,
    source => 'puppet:///modules/officesupplystore/mysql_setup.sh',
    notify => Exec['setup_mysql'],
  }

  exec { 'setup_mysql':
    cwd     => "/tmp",
    command => "sudo ./mysql_setup.sh $db_username $db_password $db_token_flag",
    path    => [ '/bin/', '/sbin/' , '/usr/bin/', '/usr/sbin/' ],
    notify => Exec['create_root_flag'],
  }

  # Add flags
  exec { 'create_root_flag':
    cwd     => "/home/vagrant",
    command => "echo '$root_file_flag' > /webroot && chown -f root:root /webroot && chmod -f 0600 /webroot",
    notify => Exec['create_admin_flag'],
  }

  exec { 'create_admin_flag':
    cwd     => "$docroot",
    command => "echo '$admin_flag' > ./.admin && chown -f www-data:www-data ./.admin && chmod -f 0600 ./.admin",
  }
}