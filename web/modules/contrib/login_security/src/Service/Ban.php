<?php

declare(strict_types=1);

namespace Drupal\login_security\Service;

use Drupal\advban\AdvbanIpManagerInterface;
use Drupal\ban\BanIpManagerInterface;
use Drupal\Component\DependencyInjection\ContainerInterface;

/**
 * Provides the CrowdSec ban service.
 */
class Ban {

  /**
   * Constructs the ban service.
   */
  public function __construct(
    protected ContainerInterface $container,
  ) {}

  /**
   * Get an instance of a ban manager.
   *
   * @return mixed
   *   Either the BanIpManagerInterface or AdvbanIpManagerInterface. If none of
   *   them is available, returns NULL.
   */
  protected function getBanIpManager(): mixed {
    // @phpstan-ignore if.alwaysTrue
    if ($this->container->has('advban.ip_manager')) {
      return $this->container->get('advban.ip_manager');
    }
    // @phpstan-ignore deadCode.unreachable
    if ($this->container->has('ban.ip_manager')) {
      return $this->container->get('ban.ip_manager');
    }
    throw new \Exception('Could not get a ban manager instance. Either the Ban or Advban module is required for the Login Security module.');
  }

  /**
   * Bans an IP address.
   *
   * @param string $ip
   *   The IP address to ban.
   */
  public function banIp(string $ip): bool {
    try {
      $manager = $this->getBanIpManager();
      if ($manager instanceof AdvbanIpManagerInterface) {
        if (!$manager->isProtected($ip)) {
          $manager->banIp($ip, NULL, NULL, NULL);
          return TRUE;
        }
      }
      elseif ($manager instanceof BanIpManagerInterface) {
        $manager->banIp($ip);
        return TRUE;
      }
    }
    catch (\Exception) {
      return FALSE;
    }
    return FALSE;
  }

  /**
   * Removes the ban of an IP address.
   *
   * @param string $ip
   *   The IP address to unban.
   */
  public function unbanIp(string $ip): void {
    try {
      $this->getBanIpManager()->unbanIp($ip);
    }
    catch (\Exception) {
    }
  }

}
