<?php

    namespace App\Models\Frontend;

    use App\Entities\UserEntity;
    use App\Models\Model;

    class Home extends Model
    {
        public function usersList(): array
        {
            try
            {
                $key = md5('Users');

                $results = $this->memCacheStatus != false ? $this->_getCachedResults($this->cache, $key) : array();

                if (empty($results))
                {
                    $sql = "SELECT
								a.id,
								a.name,
								a.last_name,
								a.user_name,
								a.is_enabled,
								a.in_backend
							FROM 
							  users AS a
							WHERE 
							  a.id <> 1
							ORDER BY 
							  a.id DESC
					";

                    $stmt = $this->_db->prepare($sql);
                    $stmt->execute();

                    while ($row = $stmt->fetch())
                        $results['list'][] = new UserEntity($row);

                    if($this->memCacheStatus != false)
                        $this->cache->set($key, serialize($results), MEMCACHE_COMPRESSED, MEMCACHE_EXPIRE);
                }

                return $results;
            }
            catch (\PDOException $e)
            {
                throw $e;
            }
        }
    }