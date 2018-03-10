<?php

namespace PeoplePerHour\Dbal\Expression;

interface Expression {
  public function getType(): string;
  public function getOperands(): array;
  public static function getAvailableOperationTypes(): array;
}