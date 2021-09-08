<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RickMortyController extends Controller
{

    /**
     * @var Collection Collection of records 
     */
    private $collection = null;

    /**
     * @var int Dictates how many records to show per page
     */
    const PerPage = 20;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        try {
            // Read JSON file
            $raw = file_get_contents(
                storage_path('ricknmorty.json')
            );;

            // Decode the JSON
            $records = json_decode($raw);

            // Create Laravel collection with the records
            $this->collection = collect($records);
        } catch (\Exception $e) {
            abort(500, "Failed to initialize collection - {$e->getMessage()}");
        }
    }

    /**
     * Endpoint for listing Rick and Morty characters
     * 
     * @param Request $request
     * 
     * @return LengthAwarePaginator
     */
    public function index(Request $request)
    {
        $items = $this->collection;
        $page = intval($request->query('page')) ?? 1;

        // Handle filtering records based on name
        if ($request->has('name')) {
            $items = $items->filter(function ($item) use ($request) {
                return strpos(strtolower($item->name), strtolower($request->query('name'))) !== false;
            })->values();
        }

        // Handle filtering records based on name
        if ($request->has('gender')) {
            if ($request->query('gender') === 'male' || $request->query('gender') === 'female') {
                $items = $items->filter(function ($item) use ($request) {
                    return strtolower($item->gender) === strtolower($request->query('gender'));
                })->values();
            }
        }

        return new LengthAwarePaginator($items->forPage($page, self::PerPage), $items->count(), self::PerPage, $page, []);
    }
}
