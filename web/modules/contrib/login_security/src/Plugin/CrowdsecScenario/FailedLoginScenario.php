<?php

declare(strict_types=1);

namespace Drupal\login_security\Plugin\CrowdsecScenario;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\crowdsec\Attribute\Scenario;
use Drupal\crowdsec\ScenarioPluginBase;

/**
 * Plugin implementation of the failed login scenario.
 */
#[Scenario(
  id: 'login_security:failed_login',
  scenario: 'drupal/login_security_failed_login',
  label: new TranslatableMarkup('Failed login attempts'),
  description: new TranslatableMarkup('Login attempts from users with invalid credentials.'),
)]
final class FailedLoginScenario extends ScenarioPluginBase {}
