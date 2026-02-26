<?php

declare(strict_types=1);

namespace Drupal\email_username\Hook;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Hook\Attribute\Hook;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * User form hooks.
 */
class UserFormHooks {

  /**
   * Alter the user form to require the mail field instead of username.
   *
   * Additionally disables the username field and sets it to the email
   * value on validate.
   *
   * @param array &$form
   *   The form array.
   */
  #[Hook('form_user_form_alter')]
  public function userFormAlter(array &$form): void {
    // Mail must be required.
    $form['account']['mail']['#required'] = TRUE;

    // Username must be disabled and not required.
    $form['account']['name']['#disabled'] = TRUE;
    $form['account']['name']['#required'] = FALSE;
    $form['account']['name']['#validated'] = TRUE;
    $form['account']['name']['#description'] = new TranslatableMarkup('Username is synchronized with e-mail address.');

    // Make sure the custom validation function is executed first.
    $form['#validate'] = array_merge([self::class . '::userFormValidate'], $form['#validate']);
  }

  /**
   * Custom user form validation to set 'name' to 'mail'.
   *
   * @param array &$form
   *   The form array.
   * @param \Drupal\Core\Form\FormStateInterface $formState
   *   The form state.
   */
  public static function userFormValidate(array &$form, FormStateInterface $formState): void {
    $formState->setValue('name', $formState->getValue('mail'));
  }

}
