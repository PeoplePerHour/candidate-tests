<?php

namespace PeoplePerHour\Dbal\Exception;

class NoPendingTransactionException extends DatabaseException {
  public function __construct(string $message = "There is no pending transaction", $code = 0) {
    parent::__construct($message, $code);
  }
}