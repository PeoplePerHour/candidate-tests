<?php

	namespace App\Middleware;
    use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;

	class Authorization
	{
		public function __invoke(Request $request, Response $response, callable $next) :Response
		{
			try
            {
                if(isset($_SESSION['panel']['user']))
                    return $next($request, $response);
                else
                    return $response->withRedirect(DOMAIN.'/panel');
            }
            catch(\Exception $e)
            {
                throw $e;
            }
		}
	}