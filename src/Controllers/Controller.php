<?php

    namespace App\Controllers;

    use Psr\Http\Message\RequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;
    use App\Traits\Helper;

    class Controller
    {
        protected $_ci;

        public function __construct(\Slim\Container $ci)
        {
            try
            {
                $this->_ci = $ci;
            }
            catch(\Exception $e)
            {
                throw $e;
            }
        }

        protected function _setNavigation($module, $path)
        {
            try
            {
                $_SESSION[$module]['nav']['limit']        = isset($_GET['l']) 	? Helper::sanitizeInput($_GET['l'], 'INT') 		: 5;
                $_SESSION[$module]['nav']['page']         = isset($_GET['p']) 	? Helper::sanitizeInput($_GET['p'], 'STRING')   	: 1;
                $_SESSION[$module]['nav']['start']        = $_SESSION[$module]['nav']['page'] ? ($_SESSION[$module]['nav']['page'] - 1) * $_SESSION[$module]['nav']['limit'] : 0;
                $_SESSION[$module]['nav']['targetpage']   = '?';
                $_SESSION[$module]['nav']['navigation']   = $path."?p={$_SESSION[$module]['nav']['page']}";
            }
            catch (\Exception $e)
            {
                throw $e;
            }
        }

        protected function _renderView(Request $request, Response $response, string $view, $data = array()) :Response
        {
            try
            {
                $info = array(
                    'csrf_name' => $request->getAttribute('csrf_name'),
                    'csrf_value' => $request->getAttribute('csrf_value'),
                    'messages' =>  $this->_ci->flash->getMessages(),
                    'data' => $data
                );

                return $this->_ci->view->render($response, $view, $info);
            }
            catch (\Exception $e)
            {
                throw $e;
            }
        }
    }