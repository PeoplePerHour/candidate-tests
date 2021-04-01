<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\InvalidMetadataException;

/**
 * ForecastService
 *
 * @author Ilya Panovskiy <panovskiy1980@gmail.com>
 */
class ForecastService
{
    /** Internal parameters */
    const LOCATION_REQUEST_PARAM = 'location';
    const TEMP_UNIT_REQUEST_PARAM = 'tempUnit';
    const PROVIDER_REQUEST_PARAM = 'provider';
    
    const REQUIRED_REQUEST_PARAMS = [
        self::LOCATION_REQUEST_PARAM, 
        self::TEMP_UNIT_REQUEST_PARAM,
    ];
    
    /** Configuration parameters */
    const PROVIDERS = 'providers';
    const LAT_LON_PRECALL = 'latLonPrecall';
    const URI = 'uri';
    const QUERY = 'query';
    const LOCATION_NAME = 'locationName';
    const TEMP_UNIT_NAME = 'tempUnitName';
    const ALL_TEMP_UNITS = 'allTempUnits';
    const DEFAULT_PROVIDER = 'defaultProvider';
    const DATA_TO_EXTRACT = 'extractData';

    const CONFIG_PARAMS_CHECK_MAIN = [
        self::PROVIDERS,
        self::LAT_LON_PRECALL,
        self::URI,
        self::QUERY,
        self::LOCATION_NAME,
        self::TEMP_UNIT_NAME,
        self::ALL_TEMP_UNITS,
    ];
    const CONFIG_PARAMS_EXTRACT_MAIN = [
        self::PROVIDERS,
        self::DATA_TO_EXTRACT,
    ];
    //If precall for latitude and longitude
    const CONFIG_PARAMS_CHECK_LATLON = [
        self::PROVIDERS,
        self::LAT_LON_PRECALL,
        self::URI,
        self::QUERY,
        self::LOCATION_NAME,
    ];
    const CONFIG_PARAMS_EXTRACT_LATLON = [
        self::PROVIDERS,
        self::LAT_LON_PRECALL,
        self::DATA_TO_EXTRACT,
    ];
    
    /** Special parameters */
    const LATITUDE = 'lat';
    const LONGITUDE = 'lon';
    const PRECALL_MADE = 1;
    const PRECALL_FREE = 0;
    const EXTRACT_DELIMITER = '::'; //Should be the same in Config
    

    /** @var array $params Parameters from Config */
    private array $params;
    
    /** @var HttpClientInterface $httpClient */
    private HttpClientInterface $httpClient;
    
    /** @var string $provider Weather Provider */
    private string $provider;
    
    /** @var string $location City, Town, Place */
    private string $location;
    
    /** @var string $tempUnit Requested or Provider's temperature unit */
    private string $tempUnit;
    
    /** @var string $uri */
    private string $uri;
    
    /** @var array $query */
    private array $query;
    
    /** @var string $url */
    private string $url;
    
    /** @var array $latLon Latitude & Longitude */
    private array $latLon = [];
    
    /** @var int $preCall If precall condition */
    private int $preCall = self::PRECALL_FREE;


    /**
     * @param array $params
     * @param HttpClientInterface $httpClient
     */
    public function __construct(array $params, HttpClientInterface $httpClient)
    {
        $this->params = $params;
        $this->httpClient = $httpClient;
    }
    
    /**
     * Make request
     * 
     * @return array
     * @throws HttpException
     */
    public function call(): array
    {
        $response = $this->httpClient->request('GET', $this->url);
        
        if ($response->getStatusCode() !== 200) {
            throw new HttpException($response->getStatusCode());
        }
        
        return $this->formResponse($response->toArray());
    }

    /**
     * Prepare request for call
     * 
     * @param array $requestParams
     * @return void
     */
    public function prepareCall(array $requestParams): void
    {
        $this->validateRequestParams($requestParams);
        $this->setInternalParams($requestParams);
        
        [$p1, $p2, $p3, $p4, $p5, $p6, $p7] = self::CONFIG_PARAMS_CHECK_MAIN;
        
        $this->checkIfBeenSet([
            $p3 => $this->params[$p1][$this->provider][$p3], 
            $p4 => $this->params[$p1][$this->provider][$p4], 
            $p5 => $this->params[$p1][$this->provider][$p5], 
            $p6 => $this->params[$p1][$this->provider][$p6],
            $this->tempUnit => 
                $this->params[$p1][$this->provider][$p7][$this->tempUnit],
        ]);
        
        //forming provider's temperature unit for external request
        $this->tempUnit = 
            $this->params[$p1][$this->provider][$p7][$this->tempUnit];
        
        //fetch latitude and longitude by location (city, town, etc.)
        if (isset($this->params[$p1][$this->provider][$p2])) {
            $this->getLatLonDataByCity();
        }
        
        $this->uri = $this->params[$p1][$this->provider][$p3];
        $this->query = $this->params[$p1][$this->provider][$p4];
        
        if (!empty($this->latLon)) {
            $this->query = $this->query + $this->latLon;
        } else {
            $this->query[$this->params[$p1][$this->provider][$p5]] = 
                $this->location;
        }
        
        $this->query[$this->params[$p1][$this->provider][$p6]] = 
            $this->tempUnit;

        $this->url = $this->uri . '?' . http_build_query($this->query);
    }
    
    /**
     * Form response with only extract data parameters from configuration
     * 
     * @param array $data
     * @return array
     * @throws InvalidMetadataException
     */
    protected function formResponse(array $data): array
    {
        $dataToExtract = $this->fetchDataToExtract();
        
        foreach ($dataToExtract as $key => $path) {
            $pathArray = explode(self::EXTRACT_DELIMITER, $path);
            
            if (!is_array($pathArray)) {
                throw 
                    new InvalidMetadataException("Check config extract data.");
            }
            
            $extract = function () use ($data, $pathArray) {
                while (!empty($pathArray)) {
                    $data = $data[array_shift($pathArray)];
                }
                return $data;
            };
            
            $response[$key] = $extract();
        }
        
        return $response;
    }
    
    /**
     * Fetch parameters for data extraction from configuration
     * 
     * @return array
     */
    private function fetchDataToExtract(): array
    {
        if ($this->preCall == self::PRECALL_MADE) {
            $this->preCall = self::PRECALL_FREE; //release precall condition
            [$p1, $p2, $p3] = self::CONFIG_PARAMS_EXTRACT_LATLON;
            
            $this->checkIfBeenSet([
                $p3 => $this->params[$p1][$this->provider][$p2][$p3]
            ]);
            
            return $this->params[$p1][$this->provider][$p2][$p3];
        }
        
        [$p1, $p2] = self::CONFIG_PARAMS_EXTRACT_MAIN;
        
        $this->checkIfBeenSet([
            $p2 => $this->params[$p1][$this->provider][$p2]
        ]);
        
        return $this->params[$p1][$this->provider][$p2];
    }
    
    /**
     * Validate request parameters
     * 
     * @param array $requestParams
     * @return void
     * @throws BadRequestHttpException
     */
    private function validateRequestParams(array $requestParams): void
    {
        $checkedParams = array_intersect(
            array_keys($requestParams), 
            self::REQUIRED_REQUEST_PARAMS
        );
        
        if ($checkedParams != self::REQUIRED_REQUEST_PARAMS) {
            throw new BadRequestHttpException(
                "One or more required request params are missing."
            );
        }
    }
    
    /**
     * Set internal parameters
     * 
     * @param array $requestParams
     * @return void
     */
    private function setInternalParams(array $requestParams): void
    {
        $this->location = $requestParams[self::LOCATION_REQUEST_PARAM];
        $this->tempUnit = $requestParams[self::TEMP_UNIT_REQUEST_PARAM];
        $this->provider = 
            $requestParams[self::PROVIDER_REQUEST_PARAM] 
            ?? $this->params[self::DEFAULT_PROVIDER]
            ?? null;
    }
    
    /**
     * Get latitude and longitude by location (city, town, etc.)
     * 
     * @return void
     * @throws BadRequestHttpException
     */
    private function getLatLonDataByCity(): void
    {
        $this->preCall = self::PRECALL_MADE;
        $this->prepareLatLonPrecall();
        $data = $this->call();
        
        if (!isset($data[self::LATITUDE], $data[self::LONGITUDE])) {
            throw new BadRequestHttpException("Location not found.");
        }
        
        $this->latLon[self::LATITUDE] = $data[self::LATITUDE];
        $this->latLon[self::LONGITUDE] = $data[self::LONGITUDE];
        
        $this->latLon = array_filter($this->latLon);
    }

    /**
     * Prepare request for fetching latitude and longitude
     * 
     * @return void
     */
    private function prepareLatLonPrecall(): void
    {
        [$p1, $p2, $p3, $p4, $p5] = self::CONFIG_PARAMS_CHECK_LATLON;
        
        $this->checkIfBeenSet([
            $p3 => $this->params[$p1][$this->provider][$p2][$p3], 
            $p4 => $this->params[$p1][$this->provider][$p2][$p4], 
            $p5 => $this->params[$p1][$this->provider][$p2][$p5]
        ]);
        
        $this->uri = $this->params[$p1][$this->provider][$p2][$p3];
        $this->query = $this->params[$p1][$this->provider][$p2][$p4];

        $this->query[$this->params[$p1][$this->provider][$p2][$p5]] = 
            $this->location;
        
        $this->url = $this->uri . '?' . http_build_query($this->query);
    }
    
    /**
     * Check if all parameters that needed have been set
     * 
     * @param array $params
     * @return void
     * @throws InvalidMetadataException
     */
    private function checkIfBeenSet(array $params): void
    {
        foreach ($params as $key => $param) {
            if (!isset($param)) {
                throw new InvalidMetadataException(
                    "Parameter " . $key . " required in config."
                );
            }
        }
    }
}
