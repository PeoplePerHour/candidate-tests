<?php

namespace PeoplePerHour\Dbal\Connection;

interface Query {
  /**
   * Executes this query
   *
   * @return mixed The query result(s)
   */
  public function execute(): mixed;

  /**
   * @return string The hash for this query that can be used as a cache key
   */
  public function getQueryHash(): string;

  /**
   * @return string The runnable SQL string
   */
  public function getSql(): string;
}