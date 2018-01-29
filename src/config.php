<?php

	ini_set('session.cookie_httponly', true);
	ini_set('session.cookie_httponly', true);
    ini_set('error_reporting', E_ALL);
	ini_set('display_errors',0);

	defined('DIR') || define('DIR', dirname(__DIR__));

	date_default_timezone_set('Europe/Athens');

	setlocale(LC_MONETARY, 'el_GR.UTF-8');
	mb_internal_encoding('UTF-8');
	mb_regex_encoding('UTF-8');
	mb_http_output('UTF-8');

	defined('DBHOST_slim') || define('DBHOST_slim', 'localhost');
	defined('DBUSER_slim') || define('DBUSER_slim', '');
	defined('DBPASS_slim') || define('DBPASS_slim', '');
	defined('DBNAME_slim') || define('DBNAME_slim', 'PPHDemo');
	defined('CHARSET')     || define('CHARSET',     'utf8mb4');


    defined('ENABLE_CACHE')     || define('ENABLE_CACHE', 	    false);
	defined('MEMCACHE_SERVER')  || define('MEMCACHE_SERVER', 	    'localhost');
	defined('MEMCACHE_PORT')    || define('MEMCACHE_PORT',	    11211);
	defined('MEMCACHE_EXPIRE')  || define('MEMCACHE_EXPIRE',	    0);
	defined('SITENAME')         || define('SITENAME', 	 	    'PPH Demo');
	defined('DOMAIN')           || define('DOMAIN',      		    'http://192.168.1.14/development/PPHDemo/public_html/');
