# PPH Weather Forecast Test
The test app was developed in Lumen Framework v6.0, using PHP 7.2.
Lumen framework was chosen because it is small (micro) framework and close 
to Laravel that your Company is moving into. 

## Design Overview
Two design patterns were used ([Strategy](https://en.wikipedia.org/wiki/Strategy_pattern) 
and [Registry](https://martinfowler.com/eaaCatalog/registry.html)) in order
to manage the dynamic selection of provider during the request. 
Implementation wise an Interface has been introduced in order support both the dynamic provider change
and to allow more providers to be implemented inf the future. 

Important Files Introduced:
 - **Controllers**  => Holding The controller to validate the request and call the service
 - **Providers** => Register the Provider being used
 - **Service** => The Weather Service implementation holding the interface and the providers implementation
 - **Config** => Holds the config keys for the available providers call
 - **tests** => Hold the units tests of the app.
 
 `
 - app/Http/Controllers/WeatherController.php
 - app/Providers/WeatherProvider.php
 - app/Services/WeatherService/*
 - config/provider.php
 - routes/web.php
 - tests
 `

## Completed Tasks
- Provide Interface to add more provider if needed
- Input Validation
- Dockerized
- Unit Tests (Controller coverage only due to lack of time - Showcase Mocking though)
- API Responses follow JSON API specification.
- Coding Standards PSR-1 & PSR12 were followed
- Postman Collection provided

## Things to Note
[Issue](https://github.com/guzzle/guzzle/issues/1432) with Guzzle 6.* when the response from the provider 
comes back with status code 204. Documented on the code as well.

## How to Run
 - git clone https://github.com/St-Gk/candidate-tests.git
 - cd candidate-tests
 - docker build -f Dockerfile -t pph-weather .
 - docker run -p 8000:8000 pph-weather
 - Import Postman Collection found in: _./postman/PPH-Weather.postman_collection.json_
  to call the API on [http://localhost:8000/weather](http://localhost:8000/weather)
  
###Available Params for the request:
  1. **location** -> Required. Name of the city to forecast the weather
  2. **unit** -> Required. Accepts Only: [**Celsius** or **Fahrenheit**]
  3. **provider**  -> Optional. Accepts Only: [**OpenWeatherProvider** or **WeatherBitProvider**]



