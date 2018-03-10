<?php

namespace PeoplePerHour\Dbal\Cache;

/**
 * Class AbstractCache
 *
 * Base class implementation that all CacheProviders must extend
 *
 * @package PeoplePerHour\Dbal\Cache
 */
abstract class AbstractCache implements Cache {
  /**
   * @var int The max time to keep cache entries
   */
  private $expires;

  /**
   * AbstractCache constructor.
   *
   * @param int $expires
   */
  public function __construct(int $expires) {
    $this->expires = $expires;
  }

  /**
   * @param mixed $id The id hash of the cache entry
   *
   * @return bool TRUE if expired, FALSE otherwise
   */
  public abstract function hasExpired(mixed $id): bool;

  /**
   * @return int
   */
  public function getExpires(): int {
    return $this->expires;
  }

  /**
   * @param int $expires
   * @return AbstractCache
   */
  public function setExpires(int $expires): AbstractCache {
    $this->expires = $expires;
    return $this;
  }
}