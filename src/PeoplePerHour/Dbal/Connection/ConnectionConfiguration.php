<?php

namespace PeoplePerHour\Dbal\Connection;

class ConnectionConfiguration {

  /** @var string */
  private $host;

  /** @var string */
  private $database;

  /** @var string */
  private $username;

  /** @var string */
  private $password;

  /** @var array */
  private $otherOptions;

  /**
   * ConnectionConfiguration constructor.
   *
   * @param string $host The database host
   * @param string $database The database name
   * @param string $username
   * @param string $password
   * @param array $otherOptions Platform specific extra options
   */
  public function __construct(string $host = 'localhost', string $database, string $username, string $password, array $otherOptions = null) {
    $this->host = $host;
    $this->database = $database;
    $this->username = $username;
    $this->password = $password;
    $this->otherOptions = $otherOptions;
  }

  /**
   * @return string
   */
  public function getHost(): string {
    return $this->host;
  }

  /**
   * @param string $host
   * @return ConnectionConfiguration
   */
  public function setHost(string $host): ConnectionConfiguration {
    $this->host = $host;
    return $this;
  }

  /**
   * @return string
   */
  public function getDatabase(): string {
    return $this->database;
  }

  /**
   * @param string $database
   * @return ConnectionConfiguration
   */
  public function setDatabase(string $database): ConnectionConfiguration {
    $this->database = $database;
    return $this;
  }

  /**
   * @return string
   */
  public function getUsername(): string {
    return $this->username;
  }

  /**
   * @param string $username
   * @return ConnectionConfiguration
   */
  public function setUsername(string $username): ConnectionConfiguration {
    $this->username = $username;
    return $this;
  }

  /**
   * @return string
   */
  public function getPassword(): string {
    return $this->password;
  }

  /**
   * @param string $password
   * @return ConnectionConfiguration
   */
  public function setPassword(string $password): ConnectionConfiguration {
    $this->password = $password;
    return $this;
  }

  /**
   * @return array
   */
  public function getOtherOptions(): array {
    return $this->otherOptions;
  }

  /**
   * @param array $otherOptions
   * @return ConnectionConfiguration
   */
  public function setOtherOptions(array $otherOptions): ConnectionConfiguration {
    $this->otherOptions = $otherOptions;
    return $this;
  }
}