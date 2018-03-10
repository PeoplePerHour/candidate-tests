<?php

namespace PeoplePerHour\Dbal\Expression;

use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase {
  public function testSetDirectionException(): void {
    var_dump("TEST");
    $this->expectException(\InvalidArgumentException::class);
    $order = new Order('test', 'wrong');
  }
}