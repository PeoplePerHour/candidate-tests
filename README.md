####################################################################################################

Author : Kondylis Andreas

Date: 2021-06-21

####################################################################################################

##Requirement
1. Docker v19
2. docker-compose v 1.25<br/>* see info [here](https://docs.docker.com/compose/install/)
3. Linux OS

##Installation
1. on root folder, run: <br/> `docker run --rm -v $(pwd)/app:/app composer/composer:latest require slim/slim "^4.8" slim/http slim/psr7 php-di/php-di`
2. on `docker` folder run: <br/> `docker-compose up`

##Test execution
1. using a browser open the location<br/>`http://localhost:8000/location/{location:string}/unit/{unit:strin}` <br/>
example:<br/>
    1. `http://localhost:8000/location/Athens/unit/c`
    1. `http://localhost:8000/location/Athens/unit/kelvin4`

##Service Document
The test application was build using the `php:apache` image as environment.<br/>
The framework which used is the Slim php framework see [here](https://www.slimframework.com/)<br/>
The application apply the S.O.L.I.D principles.<br/>
The application has 5 sections : <br/>
1. Controllers / Handlers<br/>
   Contains application handlers
2. Services<br/>
   The application use the service as orchestrator
3. Providers<br/>
   Contains all the providers which the application is able to communicate.<br/>
   All providers should apply the follow the ProviderInterface
4. Models<br/>
   Contains all the structures either are related with provider either with the BL.
5. HttpClients<br/>
   Contains all the implemented clients which are available to use them on communication with the provider
   All providers should apply the follow the HttpClientInterface
   
##Features
1. JSON-API adapter
   1.We can use the middleware layer in order to transform the return using json-api protocol,
   proposal about packages [here](https://jsonapi.org/implementations/#client-libraries-php) 

1. Caching
   1. We can use framework tools in order to achieve a better caching, over than the basic cache that we have on GET requests

1. Increase security.
    1. protect application public urls
    2. use .env to store provider sensitive data
    
1. Validation
    1. add validation on incoming requests
    
1.Structure
    1. use predefined structure for provider request and for provider responses

1. Tests
   


### Comments
Through the current app, I would like to show how I analyze and how I build an app like that.
I spent all my time, which I have for the test, to create a "full" and extendable structure,
which I believe, that is the point of that exercise.
Due to limited time, I didn't fully verify the execution, and I didn't write any test for unit

Thank you in advance.