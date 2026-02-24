<?php
$databases['default']['default'] = array (
  'database' => 'mon_db',
  'username' => 'root',
  'password' => 'root',
  'prefix' => '',
  'host' => '192.168.215.3',
  'port' => 3306,
  'isolation_level' => 'READ COMMITTED',
  'driver' => 'mysql',
  'namespace' => 'Drupal\\mysql\\Driver\\Database\\mysql',
  'autoload' => 'core/modules/mysql/src/Driver/Database/mysql/',
);
$settings['hash_salt'] = 'lgjBDIalCbuW-af-MrQNevNzXWvNS4WKNVOgl4CCweCoH61NwSfX6ZSDnKgaf6S-IziQyfgOOA';
$settings['config_sync_directory'] = 'sites/default/files/config_uT6SPUkeFxn23HCGNP4MH-IiX63ILZj6StlKbkgHfzQPGaBPRQ2C3mpVAAmvzJVyD2179bx2Rg/sync';

$settings['trusted_host_patterns'] = [
  '^localhost$',
];