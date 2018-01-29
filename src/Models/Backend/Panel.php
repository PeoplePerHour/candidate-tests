<?php

    namespace App\Models\Backend;
    use App\Models\Model;
    use App\Entities\UserEntity;

    class Panel extends Model
    {
        public function authenticateUser($username, $password) :bool
        {
            try
            {
                $sql  = "SELECT
						    a.id,
                            a.password,
                            a.user_name
                        FROM
                            users AS a
                        WHERE
                            a.user_name =:user_name
                        AND a.is_enabled = 1
                        AND a.in_backend = 1
                        LIMIT 1
                ";

                $stmt  = $this->_db->prepare($sql);
                $stmt->bindParam(':user_name', $username, \PDO::PARAM_STR);
                $stmt->execute();

                if($res  = $stmt->fetch(\PDO::FETCH_ASSOC))
                {
                    if (password_verify($password, $res['password']))
                    {
                        $user = new UserEntity($res);
                        $_SESSION['panel']['user']  	    = $user->id();
                        $_SESSION['panel']['username']      = $user->username();

                        return true;
                    }
                }

                return false;
            }
            catch (\PDOException $e)
            {
                throw $e;
            }
        }
    }