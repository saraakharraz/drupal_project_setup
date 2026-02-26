<?php

namespace Drupal\Tests\login_security\Kernel\d7;

use Drupal\Tests\migrate_drupal\Kernel\d7\MigrateDrupal7TestBase;

/**
 * Tests migrating login security track data.
 *
 * @group login_security
 */
class MigrateDrupal7LoginSecurityTrack extends MigrateDrupal7TestBase {

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

    // Install the login_security_track table on the destination site.
    $this->installSchema('login_security', ['login_security_track']);
  }

  /**
   * Tests migrating login security track data.
   */
  public function testMigration() {
    // Run the migration.
    $this->executeMigrations(['d7_login_security_track']);

    // Verify the fixtures data is now present in the destination site.
    $migratedSecurityTrackEntry = $this->getMigratedSecurityTrackEntry(123);
    $this->assertNotFalse($migratedSecurityTrackEntry, 'Could not find security track entry with ID.');
    $this->assertSame('asdf', $migratedSecurityTrackEntry->host);
    $this->assertSame('Odo', $migratedSecurityTrackEntry->name);
    $this->assertSame('1444945097', $migratedSecurityTrackEntry->timestamp);
  }

  /**
   * Load a migrated security track entry from the destination database.
   *
   * @param int $id
   *   The ID of the login event to load.
   *
   * @return object|boolean
   *   FALSE if a login event could not be found, or an object with the
   *   following properties keys:
   *   - id: (int) The ID of the login event.
   *   - host: (string) The IP address of the request.
   *   - name: (string) The clean username, submitted using the login form.
   *   - timestamp: (int) The timestamp of the event.
   */
  protected function getMigratedSecurityTrackEntry($id) {
     return \Drupal::database()
      ->select('login_security_track', 'lst')
      ->fields('lst', [
        'id',
        'host',
        'name',
        'timestamp',
      ])
      ->condition('lst.id', $id)
      ->execute()
      ->fetchObject();
  }

}
