# Weather Forecast Endpoint

**Description**

Create a REST API endpoint that gives the weather forecast for next day.<br/>
The forecast should be retrieved from any free third party provider (API) such as:
- [OpenWeather](https://openweathermap.org/api)
- [Weatherbit](https://www.weatherbit.io/api)

## Required Features

Your endpoint would receive as request parameters:
- the location (required).
- temperature unit with available values Fahrenheit or Celsius (required).
- a weather forecast provider identifier (optional).

And the response of this endpoint should include the following:
- the temperature.
- the weather description (e.g. "Overcast clouds").

## Optional Features

- Unit testing.
- Option to retrieve weather forecast from more providers.
- Caching to reduce the requests to third party providers.
- Use Docker.
- Input validation.

## Coding Standards

Please keep in mind these coding standards:
- The [JSON API specification](https://jsonapi.org/).
- The [PSR-1](https://www.php-fig.org/psr/psr-1/) and [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards.

## What you should submit

- A program written in `PHP 7.0+` using any Framework you like.
- A brief document with an overview of your design.

## Do your magic!
