# Weather Forecast API

### Guides

---

#### Build & Run

To follow these steps, you will need to have [Maven](https://maven.apache.org/) and
[Java](https://openjdk.java.net/install/)

- Run `mvn package -DskipTests` to build and create a `.jar` package.
- Run `java -jar ./target/pph-0.0.1-SNAPSHOT.jar` or you can just type `mvn spring-boot:run`

#### Build & Run a Docker container

You need to have [Docker](https://docs.docker.com/machine/install-machine/) installed.

###### Run

- Run `docker build -t tangit86/pph .` to create a new docker image.
- In order to get a new container named `pph` running, based on the image `tangit86/pph` created in the previous step, run:

`docker run -d -it --rm --name pph -p 8080:8080 tangit86/pph` , or even better
if you can use a bash terminal, you can just use the deploy script provided, by running:

`chmod +x deploy-local-docker.sh && ./deploy-local-docker.sh`

You can also edit the environment variables values, inside the deploy script.

The service listens to port `8080`.

###### Endpoints

The service exposes the following endpoints:

- `/swagger-ui.html` , a swagger view of the endpoint exposed by the `WeatherController`

####### Simple Endpoint

- `[GET] /weather?location={location}&units={units}&provider={provider}`
  **(required) **location\***\* : `STRING1,STRING2`, STRING1 less than 30 chars long , STRING2 2 to 3 chars long \
  **(required) **units\*\*** : [`Celsius`,`Fahrenheit`]\
  **(optional) **provider\*\*\*\* : [`OpenWeather`, `WeatherBit`] , default: `OpenWeather`

example:

- `[GET] /weather?location=Athens,GR&units=Celsius&provider=OpenWeather`

####### `JsonAPI` style endpoints are served under `/jsonapi/`

- `[GET] /jsonapi/forecast`

example:

`/jsonapi/forecast?include=unitType&include=providerType&filter[forecast][location][eq]=Athens,GR&filter[forecast][unitType][name]=Celsius&filter[forecast][providerType][name]=OpenWeather`

Check also this Postman collection found in the file: `pph-proj.postman_collection.json`

###### Environment Variables

- `KATHARSIS_DOMAINNAME`: the host, required by Katharsis package, used for JsonApi
- `KATHARSIS_PATHPREFIX`:
  required by Katharsis package, defines where the JsonApi endpoints can be served from
- `OPENWEATHER_APIKEY`: OpenWeather Api key
- `OPENWEATHER_HOST`: OpenWeatherApi host
- `WEATHERBIT_APIKEY`: WeatherBit Api key
- `WEATHERBIT_HOST`: WeatherBit Host
- `CACHE_EVICTION_DELAY`: Define how often the cache should be emptied

### Architecture

---

```
...
├── deploy-local-docker.sh
├── Dockerfile
├── src
...
│  └── pph
│  │    ├── caches
│  │    │   └── CustomKeyGenerator.java
│  │    ├── config
│  │    │   ├── CacheConfig.java
│  │    │   ├── RestTemplateConfig.java
│  │    │   └── SwaggerConfig.java
│  │    ├── controllers
│  │    │   └── WeatherController.java
│  │    ├── domain
│  │    │   ├── LocationDto.java
│  │    │   ├── ProviderEnum.java
│  │    │   ├── UnitEnum.java
│  │    │   └── WeatherForecastDto.java
│  │    ├── jsonapi
│  │    │   ├── Forecast.java
│  │    │   ├── ForecastRepo.java
│  │    │   ├── ProviderType.java
│  │    │   ├── ProviderTypeRepo.java
│  │    │   ├── UnitType.java
│  │    │   └── UnitTypeRepo.java
│  │    ├── PphApplication.java
│  │    ├── providers
│  │    │   ├── OpenWeatherApi.java
│  │    │   ├── ProviderResponseDto.java
│  │    │   ├── WeatherBitApi.java
│  │    │   └── WeatherProvider.java
│  │    └── services
│  │        ├── exceptions
│  │        │   └── ProviderNotSupported.java
│  │        └── WeatherForecastService.java
│  └── resources
│  ....
```

Quick information:

- `providers` contains API http clients for different weather forecast providers, implementing the `WeatherProvider` Interface
- `caches` contains a key generator for the cache used. A springboot default in-memory,simple cache implementation is used. The cache key generation is based in different `location/unitType/providerType` tripplets. By default eviction time is 30sec, for ALL elements (not per record)
- `controllers` exposes the weather forecast endpoint
- `jsonapi` exposes the weather forecast endpoint, according to `JsonAPI` guidelines
- `services` contains the core business logic of the service. Orchestrates the calls to providers and uses the caching mechanism

For Exception handling, default web exceptions' handler for springboot REST APIs has been used.
For JsonAPI aspect, Katharsis' exception handler has been used.

`SpringBoot 2.2.1.RELEASE` has been used.

Third parties used:

- [Katharsis](https://github.com/katharsis-project/katharsis-framework) , a framework to help handle endpoints under the JsonAPI standard
- [Swagger](https://swagger.io/), a tool to simplify API development

Other observations:

The JsonApi aspect I implemented is not ideal. It pretty much sits on top of a more of an RPC style implementation I had in mind.
I am only providing and endpoint to showcase a JsonApi implementation under SpringBoot.
