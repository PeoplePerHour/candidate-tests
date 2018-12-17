<?php

namespace CT\DBConnectionManager\Config;

/**
 * Class DBConfiguration
 * @package CT\DBConnectionManager\Config
 */
class DBConfiguration {

    private $dsn;
    private $username;
    private $password;
    private $charset;
    private $persistent;

    public function __construct(string $dsn, string $username, string $password,
                                string $charset = 'urf8', bool $persistent = false) {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->charset = $charset;
        $this->persistent = $persistent;
    }

    /**
     * @return string
     */
    public function getDsn(): string {
        return $this->dsn;
    }

    /**
     * @param string $dsn
     */
    public function setDsn(string $dsn): void {
        $this->dsn = $dsn;
    }

    /**
     * @return string
     */
    public function getUsername(): string {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getCharset(): string {
        return $this->charset;
    }

    /**
     * @param string $charset
     */
    public function setCharset(string $charset): void {
        $this->charset = $charset;
    }

    /**
     * @return bool
     */
    public function isPersistent(): bool {
        return $this->persistent;
    }

    /**
     * @param bool $persistent
     */
    public function setPersistent(bool $persistent): void {
        $this->persistent = $persistent;
    }

}