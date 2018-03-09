<?php

namespace PeoplePerHour\Dbal\Connection;

interface PreparedStatement {
  public function bindParams(array $params): void;
}