<?php

namespace PPH;

/**
 * Class DbConnector
 *
 * @package PPH
 * @author  Kostas Rentzikas <kostas.rentzikas@gmail.com>
 */
class DbConnector
{
    /** @var \PDO */
    private $pdoConnection;

    /** @var array */
    private $settings;

    /**
     * DbConnector constructor.
     */
    public function __construct()
    {
        $settingFile = __DIR__ . '/../config.php';
        try {
            if ( ! \file_exists($settingFile)) {
                throw new \Error('Could not find the config.php file at the entry point level.');
            }
            /** @noinspection PhpIncludeInspection */
            $this->settings = include $settingFile;
            if ( ! \array_key_exists('database', $this->settings)) {
                throw new \Error("Could not find 'database' settings key.");
            }
            $this->isSupportedDriver();
            $this->establishConnection();
        } catch (\Throwable $exception) {
            die($exception->getMessage());
        }
    }

    /**
     * @return \PDO
     */
    public function getPdoConnection(): \PDO
    {
        return $this->pdoConnection;
    }

    /**
     * @throws \PDOException
     */
    private function isSupportedDriver(): void
    {
        if ( ! \in_array($this->settings['database']['driver'], \PDO::getAvailableDrivers())) {
            throw new \PDOException('The selected driver it\'s not supported by the pdo');
        }
    }

    private function establishConnection(): void
    {
        $dsnSettings         = sprintf('%s:host=%s;dbname=%s;port=%s;charset=%s',
            $this->settings['database']['driver'],
            $this->settings['database']['host'],
            $this->settings['database']['database'],
            $this->settings['database']['port'],
            $this->settings['database']['charset']
        );
        $this->pdoConnection = new \PDO(
            $dsnSettings,
            $this->settings['database']['username'],
            $this->settings['database']['password'],
            ! empty($this->settings['database']['extraOptions']) ? $this->settings['database']['extraOptions'] : null
        );

    }
}