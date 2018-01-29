<?php

    namespace App\Models\Backend;
    use App\Entities\UserEntity;
    use App\Models\Model;
    use App\Traits\Helper;

    class Users extends Model
    {
		public function usersList() :array
        {
            try
            {
                $users = $this->__getUsersList();

                $data = array(
                    'list' => isset($users['list']) ? $users['list'] : '',
                    'paginate' => $users['paginate'],
                    'total_rows' => $users['total_rows']
                );

                return $data;
            }
            catch (\Exception $e)
            {
                throw $e;
            }
        }

        public function editUserEntity(int $id) :array
		{
			try
			{
				$response = array();
				$user = $this->__getUserEntity($id);

				if(empty($user->id()))
				{
					$response['success'] = false;
					$response['type'] = 'danger';
					$response['message'] = 'User does not exist!';

					return $response;
				}

				$data = array(
					'user' => $user,
				);

				return $data;
			}
			catch (\Exception $e)
			{
				throw $e;
			}
		}

        public function deleteUserEntity(array $data) :array
        {
            try
            {
                $delete = false;
                $response['success'] = false;
                $response['type'] = 'danger';
                $response['message'] = 'User(s) does not exist';

                foreach ($data['user_checkbox'] as $user)
                    if($user == 1)
                    {
                        $response['success'] = false;
                        $response['type'] = 'warning';
                        $response['message'] = 'You cannot delete user admin!';

                        return $response;
                    }
                    else
                        $delete = $this->__delete(Helper::sanitizeInput($user, 'INT'));

                if($delete)
                {
                    $response['success'] = false;
                    $response['type'] = 'success';
                    $response['message'] = 'User(s) Deleted';
                }

                return $response;
            }
            catch (\Exception $e)
            {
                throw $e;
            }
        }

        private function __delete(int $id) :bool
        {
            try
            {
                $sql  = "DELETE FROM users WHERE id = :id AND id <> 1";

                $stmt  = $this->_db->prepare($sql);
                $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
                $stmt->execute();

                return true;
            }
            catch (\PDOException $e)
            {
                throw $e;
            }
        }

		public function update(UserEntity $user) :array
		{
			try
			{
				$response = array(
					'success' => true,
					'message' => 'User updated',
					'type' 	  => 'success'
				);
				
				$this->_db->beginTransaction();

				$sql = "UPDATE
							users
						SET
							name = :name,
							last_name = :last_name,
							user_name = :user_name,
							email = :email,
							in_backend = :in_backend,
							is_enabled = :is_enabled
				";

				if(!empty($user->password()))
				{
					$password = password_hash($user->password(), PASSWORD_BCRYPT);
					$sql .= ', password = :password';
				}

				$sql .= ' WHERE id = :id';
				
				$stmt  = $this->_db->prepare($sql);
				$stmt->bindValue(':name', $user->name(), \PDO::PARAM_STR);
				$stmt->bindValue(':last_name', $user->last_name(), \PDO::PARAM_STR);
				$stmt->bindValue(':user_name', $user->username(), \PDO::PARAM_STR);
				$stmt->bindValue(':email', $user->email(), \PDO::PARAM_STR);
				$stmt->bindValue(':in_backend', $user->in_backend(), \PDO::PARAM_INT);
				$stmt->bindValue(':is_enabled', $user->is_enabled(), \PDO::PARAM_INT);
				if(!empty($password)) {$stmt->bindValue(':password', $password,  \PDO::PARAM_STR);}
				$stmt->bindValue(':id', $user->id(), \PDO::PARAM_INT);
				$stmt->execute();

				$this->_db->commit();
			}
			catch (\PDOException $e)
			{
				$this->_db->rollBack();

				$response = array(
					'success' => false,
					'message' => $e->getMessage(),
					'type' 	  => 'danger'
				);
			}

			return $response;
		}

		public function insert(UserEntity $user) :array
		{
			try
			{
				$response = array(
					'success' => true,
					'message' => 'User added',
					'type' 	  => 'success'
				);

				$this->_db->beginTransaction();

				$sql = "INSERT INTO
							users
							(
								user_name,
								name,
								last_name,
								password,
								email,
								in_backend,
								is_enabled
							)
						VALUES
						(
							:user_name,
							:name,
							:last_name,
							:password,
							:email,
							:in_backend,
							:is_enabled
						)
				";

				$stmt  = $this->_db->prepare($sql);
				$stmt->bindValue(':user_name', $user->username(), \PDO::PARAM_STR);
				$stmt->bindValue(':name', $user->name(), \PDO::PARAM_STR);
				$stmt->bindValue(':last_name', $user->last_name(), \PDO::PARAM_STR);
				$stmt->bindValue(':password', password_hash($user->password(), PASSWORD_BCRYPT),  \PDO::PARAM_STR);
				$stmt->bindValue(':email', $user->email(), \PDO::PARAM_STR);
				$stmt->bindValue(':in_backend', $user->in_backend(), \PDO::PARAM_INT);
				$stmt->bindValue(':is_enabled', $user->is_enabled(), \PDO::PARAM_INT);
				$stmt->execute();

				$id = (int) $this->_db->lastInsertId();
				$response['id'] = $id;

				$this->_db->commit();
			}
			catch (\PDOException $e)
			{
				$this->_db->rollBack();

				$response = array(
					'success' => false,
					'message' => $e->getMessage(),
					'type' 	  => 'danger'
				);
			}

			return $response;
		}

		private function __getUserEntity(int $id) :UserEntity
		{
			try
			{
				$sql = "SELECT
							a.id,
							a.name,
							a.last_name,
							a.user_name,
							a.email,
							a.is_enabled,
							a.in_backend
						FROM
							users AS a
                        WHERE
                          a.id = :id
				";

				$stmt  = $this->_db->prepare($sql);
				$stmt->bindValue(':id', $id, \PDO::PARAM_INT);
				$stmt->execute();

				if($row = $stmt->fetch())
					$user = new UserEntity($row);
				else
					$user = new UserEntity(array('id' => 0));

				return $user;
			}
			catch (\PDOException $e)
			{
				throw $e;
			}
		}

        private function __getUsersList(): array
        {
            try
            {

                $search  = '';
                $order   = '';
                $results = array();

                $allowed_db = array(
                    'users_id' => 'a.id',
                    'users_name' => 'a.name',
                    'users_username' => 'a.user_name',
                    'users_role' => 'b.title',
                    'users_active' => 'a.is_enabled',
                    'users_backend' => 'a.in_backend'
                );

                $search .= parent::_setFilter('filter_user', 'STR', 'Users', ' AND a.user_name LIKE :filter_user');
                $search .= parent::_setFilter('filter_active', 'INT', 'Users', ' AND a.is_enabled = :filter_active');

                if (isset($_SESSION['Users']['nav']['sort']))
                {
                    if (isset($allowed_db[$_SESSION['Users']['nav']['sort']]) && !empty($allowed_db[$_SESSION['Users']['nav']['sort']]))
                        $sort = $allowed_db[$_SESSION['Users']['nav']['sort']];
                    else
                        $sort = 'a.id';

                    $order = " GROUP BY a.id 
                        ORDER BY
                        " . $sort . " " . (($_SESSION['Users']['nav']['order'] == 'asc') ? 'ASC' : 'DESC');
                }

                $sql  = "SELECT SQL_CALC_FOUND_ROWS
                            a.id,
                            a.name,
                            a.last_name,
                            a.user_name,
                            a.is_enabled,
                            a.in_backend
                        FROM users AS a
                        WHERE a.id <> 1
                        {$search}
                ";

                $sql .= "
                        ". $order ."
                        LIMIT
                        :nav_start, :nav_limit
                ";

                $stmt  = $this->_db->prepare($sql);

                if (isset($_SESSION['Users']['nav']['filter_user']))
                    $stmt->bindValue(':filter_user', '%'.$_SESSION['Users']['nav']['filter_user'].'%', \PDO::PARAM_STR);

                if (isset($_SESSION['Users']['nav']['filter_active']))
                    $stmt->bindValue(':filter_active', $_SESSION['Users']['nav']['filter_active'], \PDO::PARAM_INT);

                $stmt->bindValue(':nav_start', $_SESSION['Users']['nav']['start'], \PDO::PARAM_INT);
                $stmt->bindValue(':nav_limit', $_SESSION['Users']['nav']['limit'], \PDO::PARAM_INT);

                $stmt->execute();

                while ($row = $stmt->fetch())
                    $results['list'][] = new UserEntity($row);

                $query = $this->_db->query("SELECT FOUND_ROWS()");
                $results['total_rows'] = (int)$query->fetchColumn();
                $results['paginate'] = Helper::paginate($_SESSION['Users']['nav']['targetpage'], $_SESSION['Users']['nav']['page'], $_SESSION['Users']['nav']['limit'], $results['total_rows']);

				return $results;
            }
            catch (\PDOException $e)
            {
                throw $e;
            }
        }
    }