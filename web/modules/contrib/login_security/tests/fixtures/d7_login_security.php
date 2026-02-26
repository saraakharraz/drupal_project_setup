<?php
// phpcs:ignoreFile
/**
 * @file
 * A D7 database dump for testing purposes.
 */

use Drupal\Core\Database\Database;

$connection = Database::getConnection();

$connection->schema()->createTable('login_security_track', array(
  'fields' => array(
    'id' => array(
      'type' => 'serial',
      'not null' => TRUE,
      'description' => "ID of each login event.",
    ),
    'host' => array(
      'type' => 'varchar',
      'length' => 39,
      'not null' => TRUE,
      'default' => '',
      'description' => "The IP address of the request.",
    ),
    'name' => array(
      'type' => 'varchar',
      'length' => 64,
      'not null' => TRUE,
      'default' => '',
      'description' => "Clean username, submitted using the login form.",
    ),
    'timestamp' => array(
      'type' => 'int',
      'not null' => TRUE,
      'default' => 0,
      'description' => "Timestamp of the event.",
    ),
  ),
  'primary key' => array(
    'id',
  ),
  'mysql_character_set' => 'utf8',
));
$connection->insert('login_security_track')
  ->fields(array(
    'id',
    'host',
    'name',
    'timestamp',
  ))
  ->values(array(
    'id' => 123,
    'host' => 'asdf',
    'name' => 'Odo',
    'timestamp' => '1444945097',
  ))
  ->execute();
$connection->insert('users')
  ->fields(array(
    'name',
    'pass',
    'mail',
    'theme',
    'signature',
    'signature_format',
    'created',
    'access',
    'login',
    'status',
    'timezone',
    'language',
    'picture',
    'init',
    'data',
  ))
  ->values(array(
    'name' => 'Odo',
    'pass' => '$S$DGFZUE.FhrXbe4y52eC7p0ZVRGD/gOPtVctDlmC89qkujnBokAlJ',
    'mail' => 'odo@local.host',
    'theme' => '',
    'signature' => '',
    'signature_format' => 'filtered_html',
    'created' => '1440532218',
    'access' => '0',
    'login' => '0',
    'status' => '1',
    'timezone' => 'America/Chicago',
    'language' => 'is',
    'picture' => '0',
    'init' => 'odo@local.host',
    'data' => 'a:1:{s:7:"contact";i:1;}',
  ))
  ->values(array(
    'name' => 'Bob',
    'pass' => '$S$DGFZUE.FhrXbe4y52eC7p0ZVRGD/gOPtVctDlmC89qkujnBokAlJ',
    'mail' => 'bob@local.host',
    'theme' => '',
    'signature' => '',
    'signature_format' => 'filtered_html',
    'created' => '1440532218',
    'access' => '0',
    'login' => '0',
    'status' => '1',
    'timezone' => 'America/New_York',
    'language' => 'fr',
    'picture' => '0',
    'init' => 'bob@local.host',
    'data' => 'a:1:{s:7:"contact";i:1;}',
  ))
  ->execute();
$connection->insert('variable')
  ->fields(array(
    'name',
    'value',
  ))
  ->values(array(
    'name' => 'login_security_track_time',
    'value' => 'i:55;',
  ))
  ->values(array(
    'name' => 'login_security_user_wrong_count',
    'value' => 'i:37;',
  ))
  ->values(array(
    'name' => 'login_security_host_wrong_count',
    'value' => 'i:95;',
  ))
  ->values(array(
    'name' => 'login_security_host_wrong_count_hard',
    'value' => 'i:23;',
  ))
  ->values(array(
    'name' => 'login_security_activity_threshold',
    'value' => 'i:60;',
  ))
  ->values(array(
    'name' => 'login_security_disable_core_login_error',
    'value' => 'i:1;',
  ))
  ->values(array(
    'name' => 'login_security_notice_attempts_available',
    'value' => 'i:0;',
  ))
  ->values(array(
    'name' => 'login_security_last_login_timestamp',
    'value' => 'i:1;',
  ))
  ->values(array(
    'name' => 'login_security_last_access_timestamp',
    'value' => 'i:0;',
  ))
  ->values(array(
    'name' => 'login_security_notice_attempts_message',
    'value' => 's:4:"asdf";',
  ))
  ->values(array(
    'name' => 'login_security_host_soft_banned',
    'value' => 's:4:"dfgh";',
  ))
  ->values(array(
    'name' => 'login_security_host_hard_banned',
    'value' => 's:4:"fghj";',
  ))
  ->values(array(
    'name' => 'login_security_user_blocked',
    'value' => 's:4:"ghjk";',
  ))
  ->values(array(
    'name' => 'login_security_user_blocked_email_subject',
    'value' => 's:4:"hjkl";',
  ))
  ->values(array(
    'name' => 'login_security_user_blocked_email_body',
    'value' => 's:4:"qwer";',
  ))
  ->values(array(
    'name' => 'login_security_login_activity_email_subject',
    'value' => 's:4:"wert";',
  ))
  ->values(array(
    'name' => 'login_security_login_activity_email_body',
    'value' => 's:4:"eryt";',
  ))
  ->values(array(
    'name' => 'login_security_user_blocked_email_user',
    'value' => 's:3:"Odo";',
  ))
  ->values(array(
    'name' => 'login_security_login_activity_email_user',
    'value' => 's:3:"Bob";',
  ))
  ->execute();
