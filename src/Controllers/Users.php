<?php

    namespace App\Controllers;

    use \App\Models\Users as UsersModel;
	use Psr\Http\Message\RequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    class Users extends Controller
    {
        private $__model;

        public function __construct(\Slim\Container $ci)
        {
            try
            {
                parent::__construct($ci);
                $this->__model = new UsersModel();
                $this->_setNavigation($this->__model->table, DOMAIN);
            }
            catch (\Exception $e)
            {
                throw $e;
            }
        }

        public function showUsersList(Request $request, Response $response) :Response
        {
            try
            {
                $data = $this->__model->usersList($request->getUri());

                return $this->_renderView($request, $response, 'list.view.php', $data);
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
				$id = isset($_GET['id']) ? $_GET['id'] : 0;

				$data = $this->__model->getUser($id);

				return $this->_renderView($request, $response, 'edit.view.php', $data);
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
				return $this->_renderView($request, $response, 'add.view.php', $data = array());
			}
			catch (\Exception $e)
			{
				throw $e;
			}
		}

		public function clearCache(Request $request, Response $response) :Response
		{
			try
			{
				$clearCache = $this->__model->flushCache();

				$this->_ci->flash->addMessage($clearCache['type'], $clearCache['message']);

				return $response->withRedirect($_SERVER['HTTP_REFERER']);

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

				$dataToSend = array(
					'id' => $data['id'],
					'user_name' => $data['user_name'],
					'name' => $data['name'],
					'last_name' => $data['last_name'],
					'is_enabled' => isset($data['is_enabled']) ? 1 : 0
				);

				$validateData = $this->__validateData($dataToSend);

				if($validateData['success'] === false)
					return $response->withRedirect($_SERVER['HTTP_REFERER']);

				$update = $this->__model->updateUser($dataToSend);

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

				$dataToSend = array(
					'user_name' => $data['user_name'],
					'name' => $data['name'],
					'last_name' => $data['last_name'],
					'is_enabled' => isset($data['is_enabled']) ? 1 : 0
				);

				$validateData = $this->__validateData($dataToSend);

				if($validateData['success'] === false)
					return $response->withRedirect($_SERVER['HTTP_REFERER']);

				$insert = $this->__model->insertUser($dataToSend);

				$this->_ci->flash->addMessage($insert['type'], $insert['message']);

				return $response->withRedirect(DOMAIN);
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
				$delete = array(
					'type' => 'danger',
					'message' => 'No users deleted'
				);

				$data = (array) $request->getParsedBody();

				if(isset($data['delete']))
					foreach ($data['delete'] as $user)
						$delete = $this->__model->deleteUser($user);

				$this->_ci->flash->addMessage($delete['type'], $delete['message']);

				return $response->withRedirect($_SERVER['HTTP_REFERER']);
			}
			catch (\Exception $e)
			{
				throw $e;
			}
		}

		private function __validateData(array $data)
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

				if(empty($data['name']))
				{
					$response['success'] = false;
					$this->_ci->flash->addMessage('danger', 'Name cannot be empty!');
				}

				if(empty($data['last_name']))
				{
					$response['success'] = false;
					$this->_ci->flash->addMessage('danger', 'Last Name cannot be empty!');
				}

				return $response;
			}
			catch (\Exception $e)
			{
				throw $e;
			}
		}
    }