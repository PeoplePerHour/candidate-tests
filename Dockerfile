# Quick docker setup for my PPH test. 
# Using base php image on a latest version, running on local php server for demo purposes.
FROM php:7.4

# Install Composer | Please run composer localy - this is for my own intuition since i don't want to use composer on my local machine.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# some dev packages useful for php extensions - purge afterwards some that are not useful any longer.
RUN apt-get update \
	&& apt-get install -y \
		libzip-dev curl libcurl3-dev libxml2-dev \
	&& docker-php-ext-install -j$(nproc) \
		zip \
	&& apt-get purge -y \
		libzip-dev

# Install some php extensions probably useful for my demo app
RUN docker-php-ext-install curl dom fileinfo intl json session

# copy project files into a location within the docker container instance
COPY ./code /app
# set my working directory within the docker container instance
WORKDIR /app

# expose a local container port
EXPOSE 80
# finally, run the local php server to serve the demo api app (lumen -> public folder)
CMD php -S 0.0.0.0:8001 -t public