<?php

declare(strict_types=1);

namespace Drupal\Tests\email_username\Kernel;

use Drupal\KernelTests\Core\Entity\EntityKernelTestBase;
use Drupal\email_username\Plugin\Validation\Constraint\UserMailConstraint;
use Drupal\user\Entity\User;

/**
 * Test email as username.
 */
class EmailUsernameTest extends EntityKernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'user',
    'email_username',
  ];

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();

    $this->installEntitySchema('user');
    $this->installConfig(['user']);
    $this->installSchema('user', ['users_data']);
  }

  /**
   * Test that email is used as username.
   */
  public function testUseEmailAsUsername(): void {
    $mail = 'max@gmail.com';

    $user = User::create([
      'mail' => $mail,
    ]);

    $validationResult = $user->validate();
    $this->assertEquals(0, $validationResult->count());

    $user->save();

    $this->assertEquals($mail, $user->getAccountName());
  }

  /**
   * Test that username is overwritten by email.
   */
  public function testOverrideUsernameWithEmail(): void {
    $mail = 'max@gmail.com';

    $user = User::create([
      'name' => 'username',
      'mail' => $mail,
    ]);
    $user->save();

    $this->assertEquals($mail, $user->getAccountName());
  }

  /**
   * Test that name is only overwritten if email is set.
   */
  public function testNoNameOverrideIfNoEmail(): void {
    $name = 'username';
    $user = User::create([
      'name' => $name,
    ]);
    $user->save();

    $this->assertEquals($name, $user->getAccountName());
    $this->assertNull($user->getEmail());
  }

  /**
   * Make sure that email is still validated for uniqueness.
   */
  public function testMailUnique(): void {
    $mail = 'max@gmail.com';

    $userOne = User::create(['mail' => $mail]);
    $userOne->save();

    // No validation errors now.
    $this->assertEquals(0, $userOne->validate()->count());

    $userTwo = User::create(['mail' => $mail]);
    $valResult = $userTwo->validate();

    $this->assertEquals(1, $valResult->count());

    $error = $valResult->get(0);
    $this->assertStringContainsString('Unique', $error->getConstraint()->validatedBy());
  }

  /**
   * Make sure that email is required.
   */
  public function testMailRequired(): void {
    $user = User::create([
      'name' => 'username',
    ]);

    $validationResult = $user->validate();
    $error = $validationResult->get(0);
    $this->assertStringContainsString('Required', $error->getConstraint()->validatedBy());
  }

  /**
   * Test email validation.
   */
  public function testMailValidation(): void {
    $constraint = new UserMailConstraint();

    $user = User::create(['mail' => ' ']);
    $this->assertEquals($constraint->invalidCharactersMessage, $user->validate()->get(0)->getMessage());

    $user = User::create(['mail' => 'max@gm,l.com']);
    $this->assertEquals($constraint->invalidCharactersMessage, $user->validate()->get(0)->getMessage());

    $user = User::create(['mail' => 'max@@gml.com']);
    $this->assertEquals($constraint->multipleAtMessage, $user->validate()->get(0)->getMessage());

    $user = User::create(['mail' => 'max@gmail..com']);
    $this->assertEquals($constraint->consecutiveDotsMessage, $user->validate()->get(0)->getMessage());

    $user = User::create(['mail' => 'max@somenonexistantdomainforsure87878745656445654.com']);
    $this->assertEquals($constraint->invalidDnsMessage, $user->validate()->get(0)->getMessage());

    $user = User::create(['mail' => 'max@local']);
    $this->assertEquals($constraint->localDomainMessage, $user->validate()->get(0)->getMessage());
  }

  /**
   * Test email validation with disabled validations.
   */
  public function testMailValidationWithDisabledValidations(): void {
    $constraint = new UserMailConstraint();

    $this->setSetting('email_username', [
      'validate_dns' => FALSE,
      'validate_spoof' => FALSE,
    ]);

    // This should now pass since DNS check is disabled.
    $user = User::create(['mail' => 'max@somenonexistantdomainforsure87878745656445654.com']);
    $this->assertEquals(0, $user->validate()->count());

    // Basic RFC validation should still work.
    $user = User::create(['mail' => 'max@@gml.com']);
    $this->assertEquals($constraint->multipleAtMessage, $user->validate()->get(0)->getMessage());
  }

}
