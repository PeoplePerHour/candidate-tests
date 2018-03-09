<?php

namespace PeoplPerHour\Dbal\Expression;

use PeoplePerHour\Dbal\Expression\Expression;

/**
 * Class LogicalExpression
 *
 * Represents a logical (AND/OR) SQL expression
 *
 * @package PeoplPerHour\Dbal\PeoplePerHour\Dbal\Expression
 */
class LogicalExpression implements Expression {
  const AND = 'AND';
  const OR = 'OR';

  /**
   * The expression type
   *
   * @var string
   */
  private $type;

  /**
   * First operand
   *
   * @var Expression
   */
  private $left;

  /**
   * Second operand
   *
   * @var Expression
   */
  private $right;

  /**
   * LogicalExpression constructor.
   *
   * @param string $type
   * @param Expression $left
   * @param Expression $right
   */
  public function __construct(string $type, Expression $left, Expression $right) {
    $this->type = $type;
    $this->left = $left;
    $this->right = $right;
  }

  public function getType(): string {
    return $this->type;
  }

  public function getOperands(): array {
    return [$this->left, $this->right];
  }

}