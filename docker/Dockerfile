FROM php:apache
WORKDIR /var/www/html
COPY ./apache/apache2.conf /etc/apache2/apache2.conf
RUN apachectl configtest
RUN a2enmod rewrite && \
    a2enmod actions && \
    service apache2 restart
