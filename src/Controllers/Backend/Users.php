<?php

    namespace App\Controllers\Backend;
    use App\Controllers\Controller;
	use App\Entities\UserEntity;
	use App\Models\Backend\Users as UsersModel;
    use App\Traits\Helper;
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    class Users extends Controller
    {
        private $__model;

        public function __construct(\Slim\Container $ci)
        {
            try
            {
                parent::__construct($ci);
				$_SESSION['current_page'] = 'users';
                $this->__model = new UsersModel($this->_ci->db);
            }
            catch(\Exception $e)
            {
                throw $e;
            }
        }

		public function showUsersList(Request $request, Response $response) :Response
        {
            try
            {
				$this->_setNavigation('Users', DOMAIN.'/panel/users');
				$data = $this->__model->usersList();

				return $this->_renderView($request, $response, 'Backend/Users/users.list', $data);
            }
            catch (\Exception $e)
            {
                throw $e;
            }
        }

        public function editUser(Request $request, Response $response) :Response
		{
			try
			{
				$id = isset($_GET['id']) ? Helper::sanitizeInput($_GET['id'], 'INT') : 0;

				$data = $this->__model->editUserEntity($id);

				if(isset($data['success']) && $data['success'] === false)
				{
					$this->_ci->flash->addMessage($data['type'], $data['message']);
					return $response->withRedirect($_SERVER['HTTP_REFERER']);
				}

				return $this->_renderView($request, $response, 'Backend/Users/users.view', $data);
			}
			catch (\Exception $e)
			{
				throw $e;
			}
		}

		public function addUser(Request $request, Response $response) :Response
		{
			try
			{
				return $this->_renderView($request, $response, 'Backend/Users/users.add', array());
			}
			catch (\Exception $e)
			{
				throw $e;
			}
		}

		public function updateUser(Request $request, Response $response) :Response
		{
			try
			{
				$data = (array) $request->getParsedBody();

				if(!empty($data['birthdate']))
				{
					$birthdate = \DateTime::createFromFormat('d-m-Y', $data['birthdate']);
					$data['birthdate'] = $birthdate->format('Y-m-d');
				}

				$sanitizedData = array(
					'id' => Helper::sanitizeInput($data['id'], 'INT'),
					'user_name' => Helper::sanitizeInput($data['user_name'], 'STRING'),
					'name' => Helper::sanitizeInput($data['name'], 'STRING'),
					'last_name' => Helper::sanitizeInput($data['last_name'], 'STRING'),
					'email' => Helper::sanitizeInput($data['email'], 'EMAIL'),
					'password' => Helper::sanitizeInput($data['password'], 'STRING'),
					'repeat_password' => Helper::sanitizeInput($data['repeat_password'], 'STRING'),
					'in_backend' => isset($data['in_backend']) ? 1 : 0,
					'is_enabled' => isset($data['is_enabled']) ? 1 : 0,
					'gender' => Helper::sanitizeInput($data['gender'], 'INT'),
					'location' => Helper::sanitizeInput($data['location'], 'STRING'),
					'birthdate' => Helper::sanitizeInput($data['birthdate'], 'STRING'),
					'description' => Helper::sanitizeInput($data['description'], 'STRING'),
					'updated_by' => Helper::sanitizeInput($_SESSION['panel']['user'], 'INT')
				);

				$validateData = $this->__validateData($sanitizedData);

				if($validateData['success'] === false)
					return $response->withRedirect($_SERVER['HTTP_REFERER']);

				$userEntity  = new UserEntity($sanitizedData);
				$update = $this->__model->update($userEntity);

				$this->_ci->flash->addMessage($update['type'], $update['message']);

				return $response->withRedirect($_SERVER['HTTP_REFERER']);
			}
			catch (\Exception $e)
			{
				throw $e;
			}
		}

		public function insertUser(Request $request, Response $response) :Response
		{
			try
			{
				$data = (array) $request->getParsedBody();

				if(isset($data['birthdate']) && !empty($data['birthdate']))
				{
					$birthdate = \DateTime::createFromFormat('d-m-Y', $data['birthdate']);
					$data['birthdate'] = $birthdate->format('Y-m-d');
				}

				$sanitizedData = array(
					'user_name' => Helper::sanitizeInput($data['user_name'], 'STRING'),
					'name' => Helper::sanitizeInput($data['name'], 'STRING'),
					'last_name' => Helper::sanitizeInput($data['last_name'], 'STRING'),
					'email' => Helper::sanitizeInput($data['email'], 'EMAIL'),
					'password' => Helper::sanitizeInput($data['password'], 'STRING'),
					'repeat_password' => Helper::sanitizeInput($data['repeat_password'], 'STRING'),
					'in_backend' => isset($data['in_backend']) ? 1 : 0,
					'is_enabled' => isset($data['is_enabled']) ? 1 : 0,
                    'gender' => Helper::sanitizeInput($data['gender'], 'INT'),
					'location' => Helper::sanitizeInput($data['location'], 'STRING'),
					'birthdate' => Helper::sanitizeInput($data['birthdate'], 'STRING'),
					'description' => Helper::sanitizeInput($data['description'], 'STRING'),
					'updated_by' => Helper::sanitizeInput($_SESSION['panel']['user'], 'INT'),
					'created_by' => Helper::sanitizeInput($_SESSION['panel']['user'], 'INT')
				);

				foreach ($sanitizedData as $field => $value)
					$_SESSION['Users']['insert_user'][$field] = $value;

				$validateData = $this->__validateData($sanitizedData);

				if($validateData['success'] === false)
					return $response->withRedirect($_SERVER['HTTP_REFERER']);

				$userEntity  = new UserEntity($sanitizedData);
				$insert =  $this->__model->insert($userEntity);

				$this->_ci->flash->addMessage($insert['type'], $insert['message']);

				if($insert['success'] === true)
					unset($_SESSION['Users']['insert_user']);
				else
					return $response->withRedirect($_SERVER['HTTP_REFERER']);

				return $response->withRedirect(DOMAIN.'/panel/users/edit-user?id='.$insert['id']);
			}
			catch (\Exception $e)
			{
				throw $e;
			}
		}

        public function deleteUser(Request $request, Response $response) :Response
        {
            try
            {
                $data = (array) $request->getParsedBody();

                if(!isset($data['user_checkbox']))
                {
                    $this->_ci->flash->addMessage('info', 'Please select users to delete.');
                    return $response->withRedirect($_SERVER['HTTP_REFERER']);
                }

                $delete = $this->__model->deleteUserEntity($data);
                $this->_ci->flash->addMessage($delete['type'], $delete['message']);

                return $response->withRedirect($_SERVER['HTTP_REFERER']);
            }
            catch (\Exception $e)
            {
                throw $e;
            }
        }

		private function __validateData(array $data): array
		{
			try
			{
				$response = array(
					'success' => true
				);

				if(empty($data['user_name']))
				{
					$response['success'] = false;
					$this->_ci->flash->addMessage('danger', 'Username cannot be empty!');
				}

				if(empty($data['email']))
				{
					$response['success'] = false;
					$this->_ci->flash->addMessage('danger', 'Email cannot be empty!');
				}

				if($data['password'] != $data['repeat_password'])
				{
					$response['success'] = false;
					$this->_ci->flash->addMessage('danger', 'Passwords do not match!');
				}

				return $response;
			}
			catch (\Exception $e)
			{
				throw $e;
			}
		}
    }