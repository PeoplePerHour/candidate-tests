#!/bin/bash

KATHARSIS_DOMAINNAME=http://localhost:8080
KATHARSIS_PATHPREFIX=/jsonapi
OPENWEATHER_APIKEY=6119e5f329f49fae3648b81ef474c631
OPENWEATHER_HOST=https://api.openweathermap.org/
WEATHERBIT_APIKEY=19f1ea1f1953494ebf88e18d4c3c385e
WEATHERBIT_HOST=https://api.weatherbit.io/
CACHE_EVICTION_DELAY=30000

imageName=tangit86/pph
containerName=pph
printf "################ \t Building package...";
./mvnw package

printf "################ \t Building Docker image...";
docker build -t $imageName .

printf "################ \t Checking for running container...\n";
id=$(docker ps --filter name=$containerName --format="{{.ID}}");

if [ $id  ]; then
  printf "################ \t Stopping existing container...";
  docker rm -f $id;
  printf "################ \t Container stopped and removed...\n";
fi

printf "################ \t Running new container...\n";
docker run -e KATHARSIS_DOMAINNAME=$KATHARSIS_DOMAINNAME \
-e KATHARSIS_PATHPREFIX=$KATHARSIS_PATHPREFIX \
-e OPENWEATHER_APIKEY=$OPENWEATHER_APIKEY \
-e OPENWEATHER_HOST=$OPENWEATHER_HOST \
-e WEATHERBIT_APIKEY=$WEATHERBIT_APIKEY \
-e WEATHERBIT_HOST=$WEATHERBIT_HOST \
-e CACHE_EVICTION_DELAY=$CACHE_EVICTION_DELAY \
-d -it --rm  --name $containerName -p 8080:8080 $imageName \
/