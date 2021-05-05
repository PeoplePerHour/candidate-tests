# PeoplePerHour Backend API Test Assignment

**Working Class Code (Nikos Moustroufas) workingclasscode@gmail.com**

Assignment: [Reference](https://github.com/PeoplePerHour/candidate-tests/blob/master/README-BE-WEATHER.md)


**Setup**

Clone/Download repository and run `composer` to install the dependencies and build the autoload files.

Open the `app/config.php` to inspect the settings of the project.

Project assumes the base url `127.0.0.1:8000`. You can change that.

The project can run for test purposes via `PHP`'s built-in web server (see `start.bat`). Alternatively you can setup a virtual Apache host and run it there.

Run `start.bat` and navigate to the app's base url (`127.0.0.1:8000`) it automaticaly redirects to `127.0.0.1:8000/api` endpoint.

![screenshot1](/screenshot1.png)

The **JSON API** is under the `/api` route (route prefix is configurable).

The API query parameters are as follows:

1. `provider`: Identifier of 3rd-party provider (ie `weatherbit`, `openweathermap`). **Optional**, default is `weatherbit`.
2. `lon/lat`: Longitude and Latitude of location to get forecast for. **Required** (if no `location` is provided, see point 3).
3. `location`: Name of location (eg `london`) to get forecast for, instead of `lon/lat`. **Required** (if no `lon/lat` are provided, see point 2). Not all providers support this.
4. `country`: Country shortcut to narrow down the location (see point 3) (eg `uk`). **Optional**.
5. `units`: Temperature units (ie `C`, `F`). **Required**.


**Design / Implementation**

The project is as simple as possible yet remaining highly modular and flexible.

I have made use of some of my own libraries and frameworks (my [Tico](https://github.com/foo123/tico) MVC framework and my [Unicache](https://github.com/foo123/Unicache) flexible caching framework). These are autoloaded as classmaps via `/lib` folder. **Note:** These frameworks do not follow strict `PSR` guidelines intentionally (for example, for optimisation purposes, support legacy applications, preferred coding style, etc..).

I could also use or implement additional code, but I opted to include two frameworks, I consider great, as dependencies. These are: [Guzzle](https://github.com/guzzle/guzzle) Http Client for remote HTTP requests and [Monolog](https://github.com/Seldaek/monolog) logger framework for versatile logging.

The project **supports two Weather providers** (`WeatherBit` and `OpenWeatherMap`). This is done by having adapters for each provider managed via a central `Provider` acting also as factory.
To **support an additional provider** simply write the adapter subclass that makes the remote request and update the central `Provider` class to take account of the new implementation. Also make sure to update the `config` file with the necessary `API` key and any other relevant information about that provider. Simple as that!

`OpenWeatherMap`'s free API does not support getting prediction via `location` name alone, it requires `lon/lat` coordinates (appropriate error message is generated if done so). On the other hand `WeatherBit`'s API supports prediction via both `lon/lat` coordinates **and** `location` name.

**Caching** is managed via my `Unicache` framework and is lazily used. In `config` one can define the needed cache configuration (many cache types supported, but I include examples of local File-based cache and `Redis`). if cache configuration is given and is supported, then caching happens automaticaly.

**Input Validation** is performed by a flexible custom class (a part of another framework of mine [Formal](https://github.com/foo123/Formal), which at the time undergoes major update).

**Unit tests**, of the REST API implemented, are under the `/test` folder (using `PHPUnit`) and can be run via `composer test` command.

Additionaly, **PSR-12 compliance tests** are included (via [`psr12`](https://github.com/opsway/psr12-strict-modern-standart) test suite). These can be run via `composer cs-check` command. **Note** some minor discrepancies are there on purpose (mostly explained in comments).


**Examples**

`GET http://127.0.0.1:8000/api`

![screenshot1](/screenshot1.png)

`GET http://127.0.0.1:8000/api?provider=weatherbit&lon=-93.25296&lat=35.32897&units=F`

![screenshot2](/screenshot2.png)

`GET http://127.0.0.1:8000/api?provider=weatherbit&location=london&units=F`

![screenshot3](/screenshot3.png)
