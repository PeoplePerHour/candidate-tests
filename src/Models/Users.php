<?php


    namespace App\Models;

    use App\Repos\MariaDBRepo;
    use App\Repos\SQLiteRepo;
    use App\Traits\Helper;

    class Users
    {
        private $__repo;
        public $table = 'users';
        public $cache;
        public $memCacheStatus;

        public function __construct()
        {
            try
            {
                $this->__repo = new MariaDBRepo();

                if(ENABLE_CACHE === true && extension_loaded('memcache'))
                {
					$this->cache = new \Memcache();
					$this->memCacheStatus = $this->cache->connect(MEMCACHE_SERVER, MEMCACHE_PORT) == false ? false : true;
                }
            }
            catch (\Exception $e)
            {
                throw $e;
            }
        }

        public function usersList(string $key) :array
        {
            try
            {
                $data = $this->memCacheStatus != false ? $this->_getCachedResults($this->cache, $key) : array();

                if(empty($data))
                {
					$isList = true;
					$columns = array('id', 'user_name', 'name', 'last_name', 'is_enabled');

					// demo join - table does not exist in demo.sql
					$joins = array(
						//array('clause' => 'LEFT JOIN',  'table' => 'users_fields',  'columns' => 'ON users_fields.user_id = user.id'),
					);

                    $conditions = array(
                        array('clause' => 'WHERE',  'column' => 'id', 'operator' => '<>', 'value' => Helper::sanitizeInput(1, 'INT')),
                    );

					// demo filters
					if(isset($_GET['filter_username']))
						$conditions[] =  array('clause' => 'AND', 'column' => 'user_name', 'operator' => 'LIKE', 'value' => '%'.Helper::sanitizeInput($_GET['filter_username'], 'STRING').'%');

                    $orderBy    = ' ORDER BY id DESC';
                    $limitStart = ' LIMIT :nav_start';
                    $limitEnd   = ' ,:nav_limit';

                    $data = $this->__repo->select($isList, $columns, $this->table, $joins,  $conditions, $orderBy, $limitStart, $limitEnd);

                    if($this->memCacheStatus != false)
                        $this->cache->set($key, serialize($data), MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE);
                }

                return $data;
            }
            catch (\Exception $e)
            {
                throw $e;
            }
        }

        public function getUser(int $id) : array
		{
			try
			{
				$columns = array('id', 'user_name', 'name', 'last_name', 'is_enabled');

				$conditions = array(
					array('clause' => 'WHERE',  'column' => 'id',  'operator' => '=', 'value' => Helper::sanitizeInput($id, 'INT'))
				);

				$data = $this->__repo->select($isList = false, $columns, $this->table, $joins = array(),  $conditions, $orderBy = '', $limitStart = '', $limitEnd = '');

				return $data;
			}
			catch (\Exception $e)
			{
				throw $e;
			}
		}

		public function updateUser(array $data) : array
		{
			try
			{
				$updateData = array(
					'id' => Helper::sanitizeInput($data['id'], 'INT'),
					'user_name' => Helper::sanitizeInput($data['user_name'], 'STRING'),
					'name' => Helper::sanitizeInput($data['name'], 'STRING'),
					'last_name' => Helper::sanitizeInput($data['last_name'], 'STRING'),
					'is_enabled' =>  Helper::sanitizeInput($data['is_enabled'], 'INT'),
				);

				$values = array();
				$values[] = array('column' => 'user_name', 	'value' => $updateData['user_name']);
				$values[] = array('column' => 'name', 		'value' => $updateData['name']);
				$values[] = array('column' => 'last_name', 	'value' => $updateData['last_name']);
				$values[] = array('column' => 'is_enabled', 'value' => $updateData['is_enabled']);

				$conditions = array(
					array('clause' => 'WHERE',  'column' => 'id',  'operator' => '=', 'value' => $updateData['id'])
				);

				return $this->__repo->update($this->table, $values, $conditions);
			}
			catch (\Exception $e)
			{
				throw $e;
			}
		}

		public function insertUser(array $data) : array
		{
			try
			{
				$insertData = array(
					'user_name' => Helper::sanitizeInput($data['user_name'], 'STRING'),
					'name' => Helper::sanitizeInput($data['name'], 'STRING'),
					'last_name' => Helper::sanitizeInput($data['last_name'], 'STRING'),
					'is_enabled' =>  Helper::sanitizeInput($data['is_enabled'], 'INT'),
				);

				$values = array();
				$values[] = array('column' => 'user_name', 	'value' => $insertData['user_name']);
				$values[] = array('column' => 'name', 		'value' => $insertData['name']);
				$values[] = array('column' => 'last_name', 	'value' => $insertData['last_name']);
				$values[] = array('column' => 'is_enabled', 'value' => $insertData['is_enabled']);

				return $this->__repo->insert($this->table, $values);
			}
			catch (\Exception $e)
			{
				throw $e;
			}
		}

		public function deleteUser(int $id) :array
		{
			try
			{
				$conditions = array();
				$conditions[] =  array('clause' => 'WHERE', 'column' => 'id', 'operator' => '=', 'value'  => Helper::sanitizeInput($id, 'INT'));

				return $this->__repo->delete($this->table, $conditions);
			}
			catch (\Exception $e)
			{
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

		public function flushCache() :array
		{
			try
			{
				$response = array(
					'type' => 'success',
					'message' => 'Cache cleared!'
				);

				if(empty($this->cache) || !$this->cache->flush())
				{
					$response['type'] = 'danger';
					$response['message'] = 'Cache not cleared! Check config.php if cache is enabled or the error logs for more info!';
				}

				return $response;
			}
			catch (\Exception $e)
			{
				throw $e;
			}
		}
    }