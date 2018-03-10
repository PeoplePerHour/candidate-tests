<?php

namespace PeoplePerHour\Dbal\Exception;

class JoinNotSupportedOnUpdateException extends DatabaseException {
  public function __construct(string $message = "This database does not support joins on update operations", $code = 0) {
    parent::__construct($message, $code);
  }
}