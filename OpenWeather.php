<?php
require_once('BaseWeatherForecast.php');

class OpenWeather extends BaseWeatherForecast
{
    private $baseUri = "http://api.openweathermap.org/";
    private $fullUri = "http://api.openweathermap.org/data/2.5/forecast";
    private $APIKEY = "21a6a37c2f9f49e154ccb789dac22adb";
    private $keyParamName = "APPID";
    private $next_day;
	
    public function __construct() 
    {
        $this->next_day = date('Y-m-d', strtotime($date ?? ''.' +1 day'));          
    }

	public function OpenWeatherAPI($params): string   
    {
            
        $json_data = "";
                      
        $params[$this->keyParamName] =  $this->APIKEY;
           
        $response = BaseWeatherForecast::ForecastRequest($this->baseUri, $this->fullUri, $params);
           
        $list =$response['list'];
                       
        foreach( $list as $list_item)
        {
              
    		if(strpos($list_item["dt_txt"], $this->next_day) !== false)
    		{
                $data = [ 'temperature' => $list_item["main"]["temp"], 
                          'description' => $list_item["weather"][0]["description"]];
                    
                $json_data.= json_encode( $data );
            }
        }
                
        return  $json_data;
    }
       
}
?>