<?php

namespace PeoplePerHour\Dbal\Expression;

class Order {
  const ASC = "asc";
  const DESC = "desc";

  /** @var string */
  private $column;

  /** @var string */
  private $direction;

  /**
   * Order constructor.
   *
   * @param string $column
   * @param string $direction
   */
  public function __construct(string $column, string $direction) {
    $this->setColumn($column);
    $this->setDirection($direction);
  }

  /**
   * @return string
   */
  public function getColumn(): string {
    return $this->column;
  }

  /**
   * @param string $column
   * @return Order
   */
  public function setColumn(string $column): Order {
    $this->column = $column;
    return $this;
  }

  /**
   * @return string
   */
  public function getDirection(): string {
    return $this->direction;
  }

  /**
   * @param string $direction
   * @return Order
   */
  public function setDirection(string $direction): Order {
    if (!in_array($direction, [self::ASC, self::DESC])) {
      throw new \InvalidArgumentException("Parameter `direction` must be one of ASC, DESC");
    }
    $this->direction = $direction;
    return $this;
  }
}