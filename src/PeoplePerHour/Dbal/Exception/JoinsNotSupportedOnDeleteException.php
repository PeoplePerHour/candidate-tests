<?php

namespace PeoplePerHour\Dbal\Exception;

class JoinsNotSupportedOnDeleteException extends DatabaseException {
  public function __construct(string $message = "This database does not support joins on delete operations", $code = 0) {
    parent::__construct($message, $code);
  }
}