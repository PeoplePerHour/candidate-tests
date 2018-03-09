<?php

namespace PeoplePerHour\Dbal\Exception;

class TransactionsNotSupportedException extends DatabaseException {
  public function __construct(string $message = "Transactions are not supported by this connection", int $code = 0) {
    parent::__construct($message, $code);
  }
}