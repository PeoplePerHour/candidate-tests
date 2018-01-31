<?php

	ini_set('session.cookie_httponly', true);
	ini_set('session.cookie_httponly', true);
    ini_set('error_reporting', E_ALL);
	ini_set('display_errors',0);

	defined('DIR') || define('DIR', dirname(__DIR__));

	date_default_timezone_set('Europe/Athens');

	mb_internal_encoding('UTF-8');
	mb_regex_encoding('UTF-8');
	mb_http_output('UTF-8');

    defined('ENABLE_CACHE')     || define('ENABLE_CACHE', 	    false);
	defined('MEMCACHE_SERVER')  || define('MEMCACHE_SERVER', 	    'localhost');
	defined('MEMCACHE_PORT')    || define('MEMCACHE_PORT',	    11211);
	defined('MEMCACHE_EXPIRE')  || define('MEMCACHE_EXPIRE',	    0);
	defined('SITENAME')         || define('SITENAME', 	 	    'PPH Demo');
	defined('DOMAIN')           || define('DOMAIN',      		    '');
