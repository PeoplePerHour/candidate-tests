<?php

namespace app\Components\Files\Sources;

use App\Components\Files\Sources\Source;
use Config;
use Carbon\Carbon;

class Source_Weatherbit extends Source
{
    const API_KEY = "apiKey";
    const MAIN_URL = "mainUrl";
    const DAYS_TO_FORECAST = "daysToForecast";
    const API_EXIST_CALL = "apiExistCall";
    protected $cityId;
    protected $forecastDaysToDo;

    public function __construct($data)
    {
        $this->units = $data['metric'];
        $this->setForecastDaysToDo();
        $this->setApiKey();
        $this->cityId = $data['cityId'];
        $this->setSourceApiCall();
    }
    public function setApiKey()
    {
        $this->apiKey = Config::get($this->configBasePath)[substr(strrchr(__CLASS__, "\\"), 1)][self::API_KEY];
    }
    public function setSource()
    {
        $this->source =  substr(strrchr(__CLASS__, "\\"), 1);
    }
    public function setSourceApiCall()
    {
        $key = self::API_EXIST_CALL . $this->cityId.$this->units.date('Y-m-d');
        $cacheKey = $this->getCachedKey($key);
        return 
        $this->sourceApiCall = Config::get($this->configBasePath)[substr(strrchr(__CLASS__, "\\"), 1)][self::MAIN_URL] . "?key=" . $this->apiKey . "&city_id=" . $this->cityId . "&days=" . $this->forecastDaysToDo . "&units=" . $this->units;
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
        $this->forecastDaysToDo = Config::get($this->configBasePath)[substr(strrchr(__CLASS__, "\\"), 1)][self::DAYS_TO_FORECAST];
    }
}
