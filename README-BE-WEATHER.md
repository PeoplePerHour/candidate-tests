# Weather Forecast Microservice

**Description**

Create a simple microservice that gives the weather forecast for next day.<br/>
The forecast should be retrieved from any free third party provider (API) such as:
- [OpenWeather](https://openweathermap.org/api)
- [Weatherbit](https://www.weatherbit.io/api)

## Required Features

Your microservice should include an endpoint that will receive as request parameters:
- the location (required).
- temperature unit with available values Fahrenheit or Celsius (required).
- a weather forecast provider identifier (optional).

And the response of this endpoint should include no less than the following:
- the temperature.
- the weather description (e.g. "Overcast clouds").

Your code must be at least unit tested.

## Optional Features
- Option to retrieve weather forecast from more providers.
- Caching to reduce the requests to third party providers.
- Dockerize your microservice.
- Input validation.
- Add more types of tests.

## Coding Standards

Please keep in mind these coding standards:
- The [JSON API specification](https://jsonapi.org/)
- The [PSR-1](https://www.php-fig.org/psr/psr-1/) and [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards

## What you should submit
- A microservice written in `PHP 7.0+` using any Framework you like.
- A brief document with an overview of your design.
- A PHPUnit test suite for your code.

## Do your magic!
