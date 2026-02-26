<?php

declare(strict_types=1);

namespace Drupal\Tests\email_username\Functional;

use Drupal\Tests\BrowserTestBase;
use Drupal\user\Entity\User;
use Drupal\user\UserStorageInterface;

/**
 * Tests the email username functionality in the browser.
 */
class EmailUsernameBrowserTest extends BrowserTestBase {

  /**
   * The user storage.
   */
  protected UserStorageInterface $userStorage;

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'email_username',
    'user',
  ];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $this->userStorage = $this->container->get('entity_type.manager')->getStorage('user');
  }

  /**
   * Tests that an admin can create a user with an email address.
   */
  public function testAdminUserCreationSuccess(): void {
    // Create and log in as admin user.
    $admin = $this->drupalCreateUser(['administer users']);
    $this->drupalLogin($admin);

    // Access the user creation form.
    $this->drupalGet('admin/people/create');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->pageTextContains('Add user');

    // Fill in the email field and submit the form.
    $email = 'demo@drupal.org';
    $edit = [
      'mail' => $email,
      'pass[pass1]' => 'password123',
      'pass[pass2]' => 'password123',
    ];
    $this->submitForm($edit, 'Create new account');

    // Assert the user was created successfully.
    $this->assertSession()->pageTextContains('Created a new user account');

    // Verify the user exists and has the correct email and username.
    $result = $this->userStorage->loadByProperties(['mail' => $email]);
    /** @var \Drupal\user\UserInterface $user */
    $user = reset($result);
    $this->assertNotNull($user, 'User was created successfully');
    $this->assertEquals($email, $user->getAccountName(), 'Username matches email address');

    // Edit the user.
    $this->drupalGet('user/' . $user->id() . '/edit');

    $email = 'demo+2@drupal.org';
    $edit = [
      'mail' => $email,
    ];
    $this->submitForm($edit, 'Save');

    $this->assertSession()->pageTextContains('The changes have been saved.');

    // Make sure the username was updated to the new email address.
    $this->userStorage->resetCache([$user->id()]);
    $user = User::load($user->id());

    $this->assertEquals($email, $user->getAccountName(), 'Username matches email address');
  }

  /**
   * Tests that validation fails when the email address is not a valid DNS.
   */
  public function testAdminUserCreationDnsFailure(): void {
    // Create and log in as admin user.
    $admin = $this->drupalCreateUser(['administer users']);
    $this->drupalLogin($admin);

    // Access the user creation form.
    $this->drupalGet('admin/people/create');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->pageTextContains('Add user');

    // Fill in the email field and submit the form.
    $email = 'demo@example.com';
    $edit = [
      'mail' => $email,
      'pass[pass1]' => 'password123',
      'pass[pass2]' => 'password123',
    ];
    $this->submitForm($edit, 'Create new account');

    // Assert the user was created successfully.
    $this->assertSession()->pageTextContains('The email address seems to be unable to receive email messages.');
  }

}
