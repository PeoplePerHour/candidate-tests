Test for PPH

Stack: PHP 8.0 or PHP 7.4, Apache2 or Ngnix (Alpine).

Start with docker: docker-compose up or docker-compose up -d

Must be pre-installed: mbstring, xml, curl extentions.

Example of request: your_server_address/fcnextday?location=London,GB&tempUnit=cel&provider=openweathermap

For running tests: ./bin/phpunit