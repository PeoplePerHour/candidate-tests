<?php

namespace PeoplePerHour\Dbal\Expression;

use PeoplPerHour\Dbal\Expression\ComparisonExpression;
use PHPUnit\Framework\TestCase;

class JoinTest extends TestCase {
  public function testSetOnException(): void {
    $this->expectException(\InvalidArgumentException::class);
    $join = new Join('test', 'wrong', Join::JOIN_TYPE_LEFT);
  }

  public function testSetTypeException(): void {
    $this->expectException(\InvalidArgumentException::class);
    $join = new Join('test', new ComparisonExpression('', ComparisonExpression::EQ, ''), 4);
  }
}