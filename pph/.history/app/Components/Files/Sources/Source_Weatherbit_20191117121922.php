<?php

namespace app\Components\Files\Sources;

use App\Components\Files\Sources\Source;
use Config;

class Source_Weatherbit extends Source
{
    const API_KEY = "apiKey";
    protected $cityId;
    protected $forecastDaysToDo = 1;

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
        $this->sourceApiCall = Config::get($this->configBasePath)[__CLASS__][self::API_KEY]"?key=" . $this->apiKey . "&city_id=" . $this->cityId . "&days=" . $this->forecastDaysToDo;
    }
    public function getSource()
    {
        return $this->source;
    }

    public function getSourceApiCall()
    {
        return $this->sourceApiCall;
    }
}
