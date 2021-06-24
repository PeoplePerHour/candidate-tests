<?php

namespace App\Providers;

/**
 * Class ProviderAbstractConfig
 *
 * Abstract class for Providers
 *
 * @package Providers
 */
abstract class ProviderAbstractConfig
{
    /**
     * @var array
     */
    private $config;

    function __construct()
    {
        $config = include($this->getConfigFilePath().'/config.php');
        $this->config = ! is_array($config) ? [] : $config;
    }

    public function getConfigValue(string $key)
    {
        return array_key_exists($key, $this->config) ? $this->config[$key] : null;
    }

    public function getHost(): string
    {
        return $this->getConfigValue('host') ?? '';
    }

    abstract protected function getConfigFilePath():string;
}