<?php

declare(strict_types=1);

namespace App\Services\WeatherService;

use App\Services\WeatherService\WeatherInterface;

class WeatherService
{
    /**
     * Registry Implementation holding the available providers
     * that can be choosen during runtime.
     *
     * https://martinfowler.com/eaaCatalog/registry.html
     *
     */

    private $providers = [];


    /**
     * Register the service to registry
     *
     * @param $name
     * @param \App\Services\WeatherService\WeatherInterface $instance
     * @return $this
     */
    public function register($name, WeatherInterface $instance)
    {
        $this->providers[$name] = $instance;
        return $this;
    }

    /**
     * Retrieve the service from the registry object
     *
     * @param string $provider
     * @return mixed
     * @throws \Exception
     */
    public function get(string $provider)
    {
        if (!empty($this->providers[$provider])) {
            return $this->providers[$provider];
        } else {
            throw new \Exception("Invalid gateway");
        }
    }

}
