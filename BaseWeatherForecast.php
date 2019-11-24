<?php

require 'C:/Users/vaggelis/vendor/autoload.php';

class BaseWeatherForecast
{
	
		
	public static function ForecastRequest(string $baseEndpointURI, string $endpointURI, array $params): array  
	{
		try
		{
				   				
			return BaseWeatherForecast::ForecastGetRequest($baseEndpointURI, $endpointURI, $params);
				
		}
		catch(Exception $e) 
		{
			echo 'Message: ' .$e->getMessage();
		}
	}
	   
	private static function ForecastGetRequest(string $baseEndpointURI, string $fullEndpointURI, array $params): array  
    {
		try
		{
			$json_data="";

			if(empty($params))
			{
				return $json_data;
			}

			$client = new GuzzleHttp\Client(['base_uri' => "{$baseEndpointURI}"]);
			
			
			$response = $client->request('GET',"{$fullEndpointURI}",["query" => $params]);
			
			$response = \GuzzleHttp\json_decode($response->getBody(), true);
			  
			return  $response;
		}
		catch(Exception $e) 
		{
			echo 'Message: ' .$e->getMessage();

			return array();

		}
	}
	   
}
?>