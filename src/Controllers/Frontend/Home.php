<?php

    namespace App\Controllers\Frontend;

    use App\Controllers\Controller;
    use App\Models\Frontend\Home as HomeModel;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    class Home extends Controller
    {
        private $__model;

        public function __construct(\Slim\Container $ci)
        {
            try
            {
                parent::__construct($ci);
                $this->__model = new HomeModel($this->_ci->db);
            }
            catch (\Exception $e)
            {
                throw $e;
            }
        }

        public function showFrontPage(Request $request, Response $response)
        {
            try
            {
                $data = $this->__model->usersList();

                if(ENABLE_CACHE == false)
                {
                    $data['cache_message_type'] = 'warning';
                    $data['cache_message'] = 'Cache is disabled. Please check config.php';
                }
                else if(ENABLE_CACHE === true && $this->__model->memCacheStatus == false)
                {
                    $data['cache_message_type'] = 'danger';
                    $data['cache_message'] = 'Memcache is not enabled on your server! Check the error logs for more info!';
                }

                return $this->_renderView($request, $response, 'Frontend/Users/users.list', $data);
            }
            catch (\Exception $e)
            {
                throw $e;
            }
        }
    }