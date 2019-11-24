<?php
require_once('OpenWeather.php');
require_once('WeatherBit.php');

class ForecastHandler
{
	public static function Initialize($provider, $params): string
	{
	    $forecast ="";
	     
		if(strtolower($provider) == "openweather")
		{
			$OpenWeather = new OpenWeather();
			$forecast = $OpenWeather->OpenWeatherAPI($params);
				 
		}
		else if(strtolower($provider) == "weatherbit")
		{
			$WeatherBit = new WeatherBit();
			$forecast = $WeatherBit->WeatherBitAPI($params);
		}
		else
		{
			$error = 'No provider added';
	   		throw new Exception($error);

	     
		}
		return $forecast;
	}
		
}
?>
      