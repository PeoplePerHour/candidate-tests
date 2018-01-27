<?php

	namespace App\Models;

	class Model
	{
		protected $_db;
		public $cache;
        public $memCacheStatus;

		public function __construct($db)
		{
			try
			{
				$this->_db = $db;
				$this->cache = new \Memcache();

                if(ENABLE_CACHE === true)
                    $this->memCacheStatus = $this->cache->connect(MEMCACHE_SERVER, MEMCACHE_PORT) == false ? false : true;

			}
			catch (\Exception $e)
			{
				throw $e;
			}
		}

		public function flushCache() :array
		{
			try
			{
				$response = array(
					'type' => 'success',
					'message' => 'Cache cleared!'
				);

				if(!$this->cache->flush())
				{
					$response['type'] = 'danger';
					$response['message'] = 'Cache not cleared! Check the error logs for more info!';
				}

				return $response;
			}
			catch (\Exception $e)
			{
				throw $e;
			}
		}

		protected static function _setFilter($filter, $type, $module, $sql)
		{
			try
			{
				if (isset($_GET[$filter]) && $_GET[$filter] != '')
				{
					$value = '';

					switch ($type) {
						case 'INT':
							$value = (int)$_GET[$filter];
							break;
						case 'STR':
							$value = trim($_GET[$filter]);
							break;
						default:
							break;
					}

					$_SESSION[$module]['nav'][$filter] = $value;
					$_SESSION[$module]['nav']['targetpage'] .= $filter . '=' . trim($_SESSION[$module]['nav'][$filter]) . '&amp;';
					$_SESSION[$module]['nav']['navigation'] .= "&{$filter}={$_SESSION[$module]['nav'][$filter]}";
				}
				elseif (isset($_GET[$filter]) && $_GET[$filter] == '')
					unset($_SESSION[$module]['nav'][$filter]);

				if (isset($_SESSION[$module]['nav'][$filter])) {
					$sql = ' ' . $sql;
					return $sql;
				}
			}
			catch (\Exception $e) {
				throw $e;
			}
		}


		protected function _getCachedResults(\Memcache $memCache, $key)
		{
			try
			{
				$results = $memCache->get($key);

				return unserialize($results);
			}
			catch (\Exception $e)
			{
				throw $e;
			}
		}
	}