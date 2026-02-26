<?php

declare(strict_types=1);

namespace Drupal\email_username\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Checks validity of the user's email address.
 *
 * @Constraint(
 *   id = "UserMail",
 *   label = @Translation("User e-mail", context = "Validation"),
 * )
 */
class UserMailConstraint extends Constraint {

  /**
   * Constraint message for empty message.
   */
  public string $emptyMessage = 'You must enter a email address.';

  /**
   * Constraint message for invalid email message.
   */
  public string $invalidEmailMessage = 'The email address is not valid.';

  /**
   * Constraint message for invalid characters message.
   */
  public string $invalidCharactersMessage = 'The email address contains invalid characters.';

  /**
   * Constraint message for multiple at message.
   */
  public string $multipleAtMessage = 'The email address cannot contain multiple @ symbols.';

  /**
   * Constraint message for consecutive dots message.
   */
  public string $consecutiveDotsMessage = 'The email address cannot contain consecutive dots.';

  /**
   * Constraint message for invalid dns message.
   */
  public string $invalidDnsMessage = 'The email address seems to be unable to receive email messages.';

  /**
   * Constraint message for local domain message.
   */
  public string $localDomainMessage = 'The email address cannot contain local or reserved domain.';

}
