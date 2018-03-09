<?php

namespace PeoplPerHour\Dbal\Expression;

use PeoplePerHour\Dbal\Expression\Expression;

class ComparisonExpression implements Expression {
  const EQ = 'EQUALS';
  const NEQ = 'NOT_EQUALS';
  const GT = 'GREATER_THAN';
  const GTE = 'GREATER_THAN_OR_EQUAL';
  const LT = 'LESS_THAN';
  const LTE = 'LESS_THAN_OR_EQUAL';
  const IS_NULL = 'IS_NULL';
  const IS_NOT_NULL = 'IS_NOT_NULL';
  const IN = 'IN';
  const NOT_IN = 'NOT_IN';
  const LIKE = 'LIKE';

  /**
   * @var string The field to compare to some value/expression
   */
  private $field;

  /**
   * @var string The operation type (EQ, GTE, etc)
   */
  private $type;

  /**
   * @var mixed The right operand of the comparison
   */
  private $value;

  /**
   * ComparisonExpression constructor.
   * @param string $field
   * @param string $type
   * @param mixed $value
   *
   * @throws \InvalidArgumentException
   */
  public function __construct(string $field, string $type, mixed $value) {
    $this->field = $field;
    if (!in_array($type, self::getAvailableOperationTypes())) {
      throw new \InvalidArgumentException('Comparison operation type must be one of: ' . implode(', ', self::getAvailableOperationTypes()));
    }
    $this->type = $type;
    $this->value = $value;
  }

  public function getType(): string {
    return $this->type;
  }

  public function getOperands(): array {
    return [$this->field, $this->value];
  }

  public static function getAvailableOperationTypes(): array {
    return [
      self::EQ,
      self::NEQ,
      self::GT,
      self::GTE,
      self::LT,
      self::LTE,
      self::IS_NULL,
      self::IS_NOT_NULL,
      self::IN,
      self::NOT_IN,
      self::LIKE
    ];
  }
}