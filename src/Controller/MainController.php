<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ForecastService;
use Symfony\Component\HttpFoundation\Request;

/**
 * MainController
 *
 * @author Ilya Panovskiy <panovskiy1980@gmail.com>
 */
class MainController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->json(['message' => 'It works!']);
    }
    
    /**
     * Forecast for next day
     * 
     * Query required: location, tempUnit
     * Query optional: provider
     * @example /fcnextday?location=London,GB&tempUnit=cel
     * 
     * @Route("/fcnextday", methods={"GET"})
     */
    public function fcnextday(ForecastService $httpClient, Request $request): Response
    {
        $httpClient->prepareCall($request->query->all());
        
        return $this->json(['data' => $httpClient->call()]);
    }
}
