<?php

namespace Drupal\Tests\login_security\Kernel\d7;

use Drupal\Tests\migrate_drupal\Kernel\d7\MigrateDrupal7TestBase;

/**
 * Tests migrating login_security settings from D7.
 *
 * @group login_security
 */
class MigrateDrupal7SettingsTest extends MigrateDrupal7TestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['login_security'];

  /**
   * {@inheritdoc}
   */
  public function setUp() : void {
    parent::setUp();

    // Install fixtures on the source site.
    $this->loadFixture(__DIR__ . '/../../../fixtures/d7_login_security.php');

    // Run the migration.
    $this->migrateUsers();
    $this->executeMigration('d7_login_security_settings');
  }

  /**
   * Tests migrating login security settings.
   */
  public function testMigration() {
    // Verify the fixtures data is now present in the destination site.
    $destinationConfig = $this->config('login_security.settings');
    $this->assertSame(55, $destinationConfig->get('track_time'));
    $this->assertSame(37, $destinationConfig->get('user_wrong_count'));
    $this->assertSame(95, $destinationConfig->get('host_wrong_count'));
    $this->assertSame(23, $destinationConfig->get('host_wrong_count_hard'));
    $this->assertSame(60, $destinationConfig->get('activity_threshold'));
    $this->assertSame(1, $destinationConfig->get('disable_core_login_error'));
    $this->assertSame(0, $destinationConfig->get('notice_attempts_available'));
    $this->assertSame(1, $destinationConfig->get('last_login_timestamp'));
    $this->assertSame(0, $destinationConfig->get('last_access_timestamp'));
    $this->assertSame('asdf', $destinationConfig->get('notice_attempts_message'));
    $this->assertSame('dfgh', $destinationConfig->get('host_soft_banned'));
    $this->assertSame('fghj', $destinationConfig->get('host_hard_banned'));
    $this->assertSame('ghjk', $destinationConfig->get('user_blocked'));
    $this->assertSame('hjkl', $destinationConfig->get('user_blocked_email_subject'));
    $this->assertSame('qwer', $destinationConfig->get('user_blocked_email_body'));
    $this->assertSame('wert', $destinationConfig->get('login_activity_email_subject'));
    $this->assertSame('eryt', $destinationConfig->get('login_activity_email_body'));
    $this->assertSame('odo@local.host', $destinationConfig->get('user_blocked_notification_emails'));
    $this->assertSame('bob@local.host', $destinationConfig->get('login_activity_notification_emails'));
  }

}
