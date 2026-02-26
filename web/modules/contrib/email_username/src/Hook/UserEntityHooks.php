<?php

declare(strict_types=1);

namespace Drupal\email_username\Hook;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Hook\Attribute\Hook;
use Drupal\user\UserInterface;

/**
 * User entity hooks.
 */
class UserEntityHooks {

  /**
   * Handle user presave.
   *
   * Syncs email to username.
   * This is needed when the user is updated outside of the user form.
   *
   * @param \Drupal\user\UserInterface $user
   *   The user entity.
   */
  #[Hook('user_presave')]
  public function userPresave(UserInterface $user): void {
    $email = $user->getEmail();

    if (!is_null($email) && !empty($email)) {
      $user->setUsername($email);
    }
  }

  /**
   * Handle user base field info alter.
   *
   * Updates constraints of name and mail fields on the user entity
   * to make sure the name field is not required and validated, but
   * the mail field is.
   *
   * @param mixed &$fields
   *   The fields array.
   * @param \Drupal\Core\Entity\EntityTypeInterface $entityType
   *   The entity type.
   */
  #[Hook('entity_base_field_info_alter')]
  public function userBaseFieldConstraintAlter(&$fields, EntityTypeInterface $entityType): void {
    if ($entityType->id() === 'user') {
      $fields['name']->setRequired(FALSE);
      $fields['name']->setConstraints([]);

      $fields['mail']->setRequired(TRUE);
      $fields['mail']->addConstraint('UserMail');
    }
  }

}
