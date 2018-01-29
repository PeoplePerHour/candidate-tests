<?php

	namespace App\Controllers;
	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;
    use App\Models\Model;
	use App\Traits\Helper;

	class Controller
	{
		protected $_ci;
		private $__model;

        public function __construct(\Slim\Container $ci)
		{
			try
            {
                $this->_ci = $ci;
				$this->__model = new Model($this->_ci->db);
				$_SERVER['HTTP_REFERER'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : DOMAIN;
            }
            catch(\Exception $e)
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
			catch(\Exception $e)
			{
				throw $e;
			}
		}

        protected function _setNavigation($module, $path)
		{
			try
			{
			    $_SESSION[$module]['nav']['limit']       		= isset($_GET['l']) 	? Helper::sanitizeInput($_GET['l'], 'INT') 		: 5;
				$_SESSION[$module]['nav']['q']        			= isset($_GET['q']) 	? Helper::sanitizeInput($_GET['q'], 'STRING') 	    : $_SESSION[$module]['nav']['q'];
				$_SESSION[$module]['nav']['page']        		= isset($_GET['p']) 	? Helper::sanitizeInput($_GET['p'], 'STRING')   	: 1;
				$_SESSION[$module]['nav']['sort']        		= isset($_GET['s']) 	? Helper::sanitizeInput($_GET['s'], 'STRING')   	: '';
				$_SESSION[$module]['nav']['order']        		= isset($_GET['o']) 	? Helper::sanitizeInput($_GET['o'], 'STRING')   	: $_SESSION[$module]['nav']['order'];
				$_SESSION[$module]['nav']['start']       		= $_SESSION[$module]['nav']['page'] ? ($_SESSION[$module]['nav']['page'] - 1) * $_SESSION[$module]['nav']['limit'] : 0;
				$_SESSION[$module]['nav']['targetpage']  		= '?';
				$_SESSION[$module]['nav']['icon_default'] 		= '<i class="fa fa-sort"></i>';

				if(isset($_GET['q']))
					$_SESSION[$module]['nav']['targetpage']  	.= 'q='.$_SESSION[$module]['nav']['q'].'&amp;';

				if(isset($_GET['o']))
				{
					$_SESSION[$module]['nav']['o']			  = ($_SESSION[$module]['nav']['order'] == 'asc') ? 'desc' : 'asc';
					$_SESSION[$module]['nav']['targetpage'] .= 'o='.trim($_SESSION[$module]['nav']['order']).'&amp;';

					if($_SESSION[$module]['nav']['o'] == 'asc')
						$_SESSION[$module]['nav']['icon']  =  '<i class="fa fa-sort-desc"></i>';
					else
						$_SESSION[$module]['nav']['icon']  =  '<i class="fa fa-sort-up"></i>';
				}

				if(isset($_GET['s']))
					$_SESSION[$module]['nav']['targetpage']  	.= 's='.$_SESSION[$module]['nav']['sort'].'&amp;';

				$_SESSION[$module]['nav']['navigation']   = $path."?p={$_SESSION[$module]['nav']['page']}&q={$_SESSION[$module]['nav']['q']}&o={$_SESSION[$module]['nav']['o']}";
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

				return $this->_ci->view->render($response, $view.'.php', $info);
			}
			catch (\Exception $e)
			{
				throw $e;
			}
		}
	}