<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\WeatherService\WeatherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

class WeatherController extends Controller
{
    /**
     * @var WeatherService $weatherService
     */
    private $weatherService;

    /**
     * Create a new controller instance.
     *
     * @param WeatherService $weatherService
     */
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * Show Weather Forecast controller
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function showWeather(Request $request) : JsonResponse
    {
        //validate request incoming data
        try {
            $this->validate($request, [
                'location' => 'required',
                'unit' => ['required', Rule::in(['Fahrenheit', 'Celsius'])],
                'provider' => ['nullable', Rule::in(['OpenWeatherProvider', 'WeatherBitProvider']) ]
            ]);
        } catch (ValidationException $e) {
            $contents = json_decode($e->getResponse()->getContent(), true);

            $res = ['errors' => []];
            foreach ($contents as $content) {
                $data = [
                    'source' => $e->getFile(),
                    'detail' => $content[0],
                ];
                array_push($res['errors'], $data);
            }

            return JsonResponse::create($res)->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        //fallback to default in case the passed provider in null
        $provider = empty($request->input('provider')) ? 'OpenWeatherProvider' : $request->input('provider');

        try {
            $res = $this->weatherService->get($provider)
                ->getWeatherByCity($request->input('location'), $request->input('unit'));
        } catch (\Exception $e) {
            return JsonResponse::create(json_decode($e->getMessage(), true))
                ->setStatusCode($e->getCode());
        }

        return JsonResponse::create($res);
    }
}
