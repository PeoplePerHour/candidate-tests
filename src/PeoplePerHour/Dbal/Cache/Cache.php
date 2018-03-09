<?php

namespace PeoplePerHour\Dbal\Cache;

interface Cache {
  /**
   * @param mixed $id The id of the entry
   *
   * @return mixed The cached data
   */
  public function get(mixed $id): mixed;

  /**
   * @param mixed $id The id of the entry to set
   * @param mixed $value The data to cache
   *
   * @return bool TRUE on successful caching, FALSE otherwise
   */
  public function set(mixed $id, mixed $value): bool;

  /**
   * @param mixed $id The id of the entry
   *
   * @return bool TRUE if entry with given id exists, FALSE otherwise
   */
  public function has(mixed $id): bool;

  /**
   * @param mixed $id The id of the entry to remove
   *
   * @return bool TRUE on successful removal, FALSE otherwise
   */
  public function remove(mixed $id): bool;

  /**
   * Clears all items from the cache
   */
  public function clear(): void;
}