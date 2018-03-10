<?php

namespace PeoplePerHour\Dbal\Expression;

use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase {
  public function testNonExistingDirectionThrowsException(): void {
    $this->expectException(\InvalidArgumentException::class);
    $order = new Order('test', 'wrong');
  }
}