<?php

namespace Drupal\login_security\Plugin\migrate\process;

use Drupal\Component\Utility\EmailValidatorInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Convert a username string to an email.
 *
 * @MigrateProcessPlugin(
 *   id = "login_security_username_to_email",
 *   handle_multiples = TRUE
 * )
 */
class UsernameToEmailAddress extends ProcessPluginBase implements ContainerFactoryPluginInterface {

  /**
   * A service to validate email addresses.
   *
   * @var \Drupal\Component\Utility\EmailValidatorInterface
   */
  protected $emailValidator;

  /**
   * An entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * UsernameToEmailAddress constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Component\Utility\EmailValidatorInterface $emailValidator
   *   A service to validate email addresses.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   An entity type manager.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EmailValidatorInterface $emailValidator, EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->emailValidator = $emailValidator;
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($configuration, $plugin_id, $plugin_definition, $container->get('email.validator'), $container->get('entity_type.manager'));
  }

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $userStorage = $this->entityTypeManager->getStorage('user');

    // Search for users with the given username.
    $results = $userStorage->getQuery()
      ->condition('name', $value)
      ->accessCheck(FALSE)
      ->execute();

    // If we don't get any results, return NULL.
    if (empty($results)) {
      return NULL;
    }

    // Otherwise get the first user, load it, and return its email.
    $uid = reset($results);
    /** @var \Drupal\user\UserInterface $account */
    $account = $userStorage->load($uid);
    return $account->getEmail();
  }

}
