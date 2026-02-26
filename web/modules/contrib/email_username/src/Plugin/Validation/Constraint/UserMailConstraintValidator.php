<?php

declare(strict_types=1);

namespace Drupal\email_username\Plugin\Validation\Constraint;

use Drupal\Core\Site\Settings;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\Extra\SpoofCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the UserMail constraint.
 */
class UserMailConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($items, Constraint $constraint) {
    /** @var UserMailConstraint $constraint */
    if (!isset($items) || !$items->value) {
      $this->context->addViolation($constraint->emptyMessage);
      return;
    }

    $email = $items->first()->value;

    if (str_contains($email, " ")) {
      $this->context->addViolation($constraint->invalidCharactersMessage);
      return;
    }

    // RFC validation is always run.
    $validators = [new RFCValidation()];

    // Add further validations if enabled and supported.
    if ($this->shouldRunValidation(DNSCheckValidation::class)) {
      $validators[] = new DNSCheckValidation();
    }
    if ($this->shouldRunValidation(SpoofCheckValidation::class)) {
      $validators[] = new SpoofCheckValidation();
    }

    $validator = new EmailValidator();
    $validations = new MultipleValidationWithAnd($validators);

    $valid = $validator->isValid($email, $validations);
    $error = $validator->getError();
    if ($valid || !$error) {
      return;
    }

    switch ($error->reason()->code()) {
      case 1:
      case 129:
      case 133:
      case 137:
      case 139:
      case 144:
      case 148:
      case 149:
      case 150:
      case 200:
      case 298:
      case 400:
        $this->context->addViolation($constraint->invalidCharactersMessage);
        return;

      case 128:
        $this->context->addViolation($constraint->multipleAtMessage);
        return;

      case 132:
        $this->context->addViolation($constraint->consecutiveDotsMessage);
        return;

      case 3:
      case 5:
      case 154:
        $this->context->addViolation($constraint->invalidDnsMessage);
        return;

      case 153:
        $this->context->addViolation($constraint->localDomainMessage);
        return;

      default:
        $this->context->addViolation($constraint->invalidEmailMessage);
        return;
    }
  }

  /**
   * Determines if a validation should/can be run.
   *
   * @param string $class
   *   The validation class to check.
   */
  protected function shouldRunValidation(string $class): bool {
    $settings = Settings::get('email_username', [
      'validate_dns' => TRUE,
      'validate_spoof' => TRUE,
    ]);

    return match($class) {
      DNSCheckValidation::class => $settings['validate_dns'] && function_exists('idn_to_ascii'),
      SpoofCheckValidation::class => $settings['validate_spoof'] && extension_loaded('intl'),
    };
  }

}
