<?php

    namespace App\Controllers\Backend;
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;
    use App\Controllers\Controller;
    use App\Models\Backend\Panel as PanelModel;
    use \App\Traits\Helper;

    class Panel extends Controller
    {
        private $__model;

        public function __construct($ci)
        {
            try
            {
                parent::__construct($ci);
				$_SESSION['current_page'] = 'dashboard';
                $this->__model = new PanelModel($this->_ci->db);
            }
            catch(\Exception $e)
            {
                throw $e;
            }
        }

        public function showPanel(Request $request, Response $response) :Response
		{
			try
			{
				if(isset($_SESSION['panel']['user']))
					return $this->__dashboardDetails($request, $response);
				else
					return $this->__loginPage($request, $response);
			}
			catch(\Exception $e)
			{
				throw $e;
			}
		}

		private function __loginPage(Request $request, Response $response) :Response
		{
			try
			{
                try
                {
                    return $this->_renderView($request, $response, 'Backend/login', array());
                }
                catch(\Exception $e)
                {
                    throw $e;
                }
			}
			catch(\Exception $e)
			{
				throw $e;
			}
		}

        private function __dashboardDetails(Request $request, Response $response) :Response
        {
            try
            {
                return $this->_renderView($request, $response, 'Backend/dashboard', array());
            }
            catch(\Exception $e)
            {
                throw $e;
            }
        }

        public function login(Request $request, Response $response) :Response
        {
            try
            {
                $data = (array)$request->getParsedBody();

                $username = isset($data['username']) ? Helper::sanitizeInput($data['username'], 'STRING') : '';
                $password = isset($data['password']) ? Helper::sanitizeInput($data['password'], 'STRING') : '';

                $login = $this->__model->authenticateUser($username, $password);

                if($login === false)
                    $this->_ci->flash->addMessage('danger', 'Wrong username or password');

                return $response->withRedirect($_SERVER['HTTP_REFERER']);
            }
            catch(\Exception $e)
            {
                throw $e;
            }
        }

        public function logout(Request $request, Response $response) :Response
        {
            try
            {
                if(isset($_SESSION['panel']['user']))
                    unset($_SESSION['panel']);

                return $response->withRedirect(DOMAIN.'/panel');
            }
            catch(\Exception $e)
            {
                throw $e;
            }
        }
    }