<?php

namespace PeoplePerHour\Dbal\Expression;

use PeoplPerHour\Dbal\PeoplePerHour\Dbal\Expression\ComparisonExpression;
use PeoplPerHour\Dbal\PeoplePerHour\Dbal\Expression\LogicalExpression;

class Join {
  const JOIN_TYPE_INNER = 1;
  const JOIN_TYPE_LEFT = 2;

  /** @var int */
  private $type;

  /** @var string */
  private $joinWith;

  /** @var LogicalExpression|ComparisonExpression */
  private $on;

  /**
   * Join constructor.
   * @param int $type
   * @param string $joinWith
   * @param LogicalExpression|ComparisonExpression $on
   */
  public function __construct(string $joinWith, $on, int $type = self::JOIN_TYPE_INNER) {
    if (!in_array($type, [self::JOIN_TYPE_INNER, self::JOIN_TYPE_LEFT])) {
      throw new \InvalidArgumentException('Join type should be one of JOIN_TYPE_INNER/JOIN_TYPE_LEFT');
    }
    if (!($on instanceof ComparisonExpression) && !($on instanceof LogicalExpression)) {
      throw new \InvalidArgumentException('On parameter should be of type ' . LogicalExpression::class . ' or ' . ComparisonExpression::class);
    }
    $this->setType($type);
    $this->setJoinWith($joinWith);
    $this->setOn($on);
  }

  /**
   * @return int
   */
  public function getType(): int {
    return $this->type;
  }

  /**
   * @param int $type
   * @return Join
   */
  public function setType(int $type): Join {
    $this->type = $type;
    return $this;
  }

  /**
   * @return string
   */
  public function getJoinWith(): string {
    return $this->joinWith;
  }

  /**
   * @param string $joinWith
   * @return Join
   */
  public function setJoinWith(string $joinWith): Join {
    $this->joinWith = $joinWith;
    return $this;
  }

  /**
   * @return LogicalExpression|ComparisonExpression
   */
  public function getOn() {
    return $this->on;
  }

  /**
   * @param LogicalExpression|ComparisonExpression $on
   *
   * @return Join
   */
  public function setOn($on): Join {
    foreach ($on as $expression) { // @TODO
      if (!($expression instanceof Expression)) {
        throw new \InvalidArgumentException("The `on` parameter must be an Expression object");
      }
    }
    $this->on = $on;
    return $this;
  }
}