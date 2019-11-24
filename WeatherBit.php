<?php
require_once('BaseWeatherForecast.php');
class WeatherBit extends BaseWeatherForecast
{
	private $baseUri = "https://api.weatherbit.io/";
	private $fullUri = "https://api.weatherbit.io/v2.0/forecast/hourly";
	private $APIKEY = "1249f4d9a84947f1b13f7d80c66f1ee8";
	private $keyParamName = "key";
	private $next_day;

	public function __construct() 
    {
    	$this->next_day = date('Y-m-d', strtotime($date ?? ''.' +1 day')); 
           
    }


	public function WeatherBitAPI($params): string   
	{
	   	try
	   	{
	   		$json_data = "";
					
				
		    $params[$this->keyParamName] =  $this->APIKEY;
            $response = BaseWeatherForecast::ForecastRequest($this->baseUri, $this->fullUri, $params);
						   		   
	        foreach($response as $items)
			{
		
				foreach($items as $temp_item)
				{
					if(strpos($temp_item["datetime"], $this->next_day) !== false)
					{
							
						$data = [ 'temperature' => $temp_item["temp"], 
								  'description' => $temp_item["weather"]["description"]];
								
						$json_data .= json_encode( $data );
																   
					}
				}
					 
				return  $json_data;
			}
	   	}		  
		catch(Exception $e) 
		{
			echo 'Message: ' .$e->getMessage();

			return array();

		}
	}
	   
	
}
?>