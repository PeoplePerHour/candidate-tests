<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Libraries\Weatherbit;
/** WeatherController
 * A simple endpoint, to serve a response for current weather conditions and temperature for a specified location.
 * Location can be a combination of lat and lon / or a city name.
 * 
 * User may pass any number of extra arguments, identical to the weatherbit service such as units and lang, 
 * in order to get a localized response.
 * 
 * Requests query combinations, are being cached for an hour to save service quotas and serve faster responses.
 */
class WeatherController extends Controller
{
    /**
     * Update the specified user.
     *
     * @param  Request  $request
     * @param  Weatherbit  $weatherbit
     * @return string
     */
    public function current(Request $request, Weatherbit $weatherbit)
    {
        // Build service parameters from get parameters input
        $service_parameters = [];
        // Lat/Lon combination?
        if ($request->has('lat') && $request->has('lon')) {
            $service_parameters['lat'] = $request->input('lat');
            $service_parameters['lon'] = $request->input('lon');
        // City option?
        } elseif ($request->has('city')) {
            $service_parameters['city'] = $request->input('city');
        // In any other case,
        } else {
            return response()->json([
                'status_message' => 'Please follow the parameters guide, to fetch a valid result.',
            ], 400);
        }
        // Catch additional service parameters and incorporate into our call.
        if ($request->has('lang')) {
            $service_parameters['lang'] = $request->input('lang');
        }
        if ($request->has('units')) {
            $service_parameters['units'] = $request->input('units');
        }
        // Keep our results in memory for at least an hour to save some service quotas
        // service parameters, are being built above with a custom order, 
        // considering our key valid in this case.
        $cache_key = implode('-',$service_parameters);
        // Check key exists
        if (!Cache::has($cache_key)) {
            // no key on store, call our service.
            $resp = $weatherbit->call('current', $service_parameters);
            // and then save for later usage for 1 hour
            if($resp['cache'] === true) {
                Cache::put($cache_key, $resp['data'], 3600);
            } else {
                return response()->json($resp['data']);
            }
        }
        // Return our stored data as a response
        return response()->json(Cache::get($cache_key));
    }
}
