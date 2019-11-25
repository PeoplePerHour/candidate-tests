<?php

namespace app\Components\Files\Sources;

use App\Components\Files\Sources\Source;
use Config;

class Source_Weatherbit extends Source
{
    const API_KEY = "apiKey";
    const MAIN_URL = "mainUrl";
    const MAIN_URL = "daysToForecast";
    protected $cityId;
    protected $forecastDaysToDo;

    public function __construct($data)
    {
        $this->setApiKey();
        $this->setSourceApiCall();
        $this->cityId = $data['cityId'];
    }
    public function setApiKey()
    {
        $this->apiKey = Config::get($this->configBasePath)[__CLASS__][self::API_KEY];
    }
    public function setSource()
    {
        $this->source = __CLASS__;
    }
    public function setSourceApiCall()
    {
        $this->sourceApiCall = Config::get($this->configBasePath)[__CLASS__][self::MAIN_URL] . "?key=" . $this->apiKey . "&city_id=" . $this->cityId . "&days=" . $this->forecastDaysToDo;
    }
    public function getSource()
    {
        return $this->source;
    }

    public function getSourceApiCall()
    {
        return $this->sourceApiCall;
    }

    public function setForecastDaysToDo()
    {
        $this->forecastDaysToDo = Config::get($this->configBasePath)[__CLASS__][self::API_KEY];
    }
}
