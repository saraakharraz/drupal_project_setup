<?php

namespace Drupal\login_security\Plugin\migrate\source;

use Drupal\migrate_drupal\Plugin\migrate\source\DrupalSqlBase;

/**
 * Get login_security events from D7.
 *
 * @MigrateSource(
 *   id = "d7_login_security_track",
 *   source_module = "login_security"
 * )
 */
class D7LoginSecurityTrack extends DrupalSqlBase {

  /**
   * {@inheritdoc}
   */
  public function fields() {
    return [
      'id' => $this->t('ID of each login event'),
      'host' => $this->t('The IP address of the request'),
      'name' => $this->t('Clean username, submitted using the login form'),
      'timestamp' => $this->t('Timestamp of the event'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    $ids['id']['type'] = 'integer';
    return $ids;
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    return $this->select('login_security_track', 'lst')
      ->fields('lst', [
        'id',
        'host',
        'name',
        'timestamp',
      ]);
  }

}
