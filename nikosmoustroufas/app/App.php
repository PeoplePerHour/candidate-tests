<?php

declare(strict_types=1);

namespace App;

use App\Validation\Validator;
use App\Weather\Provider as WeatherProvider;
use Exception;
use InvalidArgumentException;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use ParameterBag;
use Tico;
use UNICACHE_Factory as UnicacheFactory;

use function array_intersect_key;
use function array_map;
use function array_merge;
use function array_values;
use function dirname;
use function implode;
use function in_array;
use function is_numeric;

class App
{
    public const VERSION = '1.0.0';
    public const JSONAPI = 'application/vnd.api+json';
    public const API     = '/api';

    public $conf = [];

    private $inited = false;

    public function __construct()
    {
        $this->conf = new ParameterBag(require_once dirname(__FILE__) . '/config.php');
    }

    public function apiHandler(array $params = []) : void
    {
        $validator = new Validator(
            array_intersect_key(tico()->request()->query->all(), [
                'provider' => 1,
                'lon'      => 1,
                'lat'      => 1,
                'location' => 1,
                'country'  => 1,
                'units'    => 1,
            ]),
            [
                // defaults
                'provider' => WeatherProvider::getSupportedProviders()[0] ?? '',
            ],
            [
                // typecasters
                'provider' => 'strtolower',
                'lon'      => 'floatval',
                'lat'      => 'floatval',
                'location' => 'strtolower',
                'country'  => 'strtolower',
                'units'    => 'strtoupper',
            ],
            [
                // validators
                'provider' => function ($v) {
                    if (! in_array($v, WeatherProvider::getSupportedProviders())) {
                        throw new InvalidArgumentException('provider param must be one of {' . implode(',', WeatherProvider::getSupportedProviders()) . '}', 1);
                    }
                },
                '*'        => function ($validator) {
                    $loc = $validator->get(['location'], $validator);
                    $lon = $validator->get(['lon'], $validator);
                    $lat = $validator->get(['lat'], $validator);
                    if ($validator === $loc || empty($loc)) {
                        if (
                            $validator === $lon || $validator === $lat ||
                            ! is_numeric($lon) || ! is_numeric($lat)
                        ) {
                            throw new InvalidArgumentException('location or numeric lon/lat params shoud be given', 1);
                        }
                    }
                },
                'units'    => function ($v) {
                    if (! in_array($v, ['C', 'F'])) {
                        throw new InvalidArgumentException('units param must be one of {C, F}', 1);
                    }
                },
            ]
        );

        $err = $validator->run(true)->errors();

        if (! empty($err)) {
            tico()->output(
                [
                    'errors' => array_map(function ($msg) {
                        return ['title' => $msg];
                    }, array_values($err)),
                ],
                'json',
                ['Content-Type' => static::JSONAPI, 'StatusCode' => 400] /* Bad Request */
            );
            return;
        }

        $providerId = $validator->get(['provider']);

        try {
            $provider = WeatherProvider::getProvider($providerId, $this->conf->get('providers'));
        } catch (Exception $e) {
            $provider = null;
        }

        if (! $provider) {
            tico()->output(
                ['errors' => [['title' => $e->getMessage()]]],
                'json',
                ['Content-Type' => static::JSONAPI, 'StatusCode' => 400] /* Bad Request */
            );
        } else {
            $query = $validator->get([], []);

            try {
                $forecast = $provider->getPrediction($query);
            } catch (Exception $e) {
                $forecast = null;
            }

            if (null === $forecast) {
                tico()->output(
                    ['errors' => [['title' => $e->getMessage()]]],
                    'json',
                    ['Content-Type' => static::JSONAPI, 'StatusCode' => 500] /* Server Error */
                );
            } else {
                tico()->output(
                    $this->toJson($provider, $forecast),
                    'json',
                    ['Content-Type' => static::JSONAPI]
                );
            }
        }
    }

    public function init() : self
    {
        if ($this->inited) {
            return $this;
        }

        $this->inited = true;

        $app  = $this;
        $tico = new Tico($this->conf->get('baseurl'), $this->conf->get('basepath'));

        tico($tico)

            ->option('webroot', $this->conf->get('webroot'))

            ->option('views', [])

            ->set('logger', function () {
                $logger = new Logger('app');
                $logger->pushHandler(new StreamHandler(tico()->path('/var/log/app.log'), Logger::DEBUG)); /*'php://stderr'*/
                return $logger;
            })

            ->set('cache', function () use ($app) {
                try {
                    $cache = ! empty($app->conf->get('cache')) ? UnicacheFactory::getCache($app->conf->get('cache')) : null;
                } catch (Exception $e) {
                    $cache = null;
                }
                return $cache;
            })

            ->on('*', '/{index.php:?}', function () {
                tico()->redirect(tico()->uri(static::API), 302);
            })

            ->on('get', static::API, [$this, 'apiHandler'])

            ->on(false, function () {
                tico()->output(
                    ['errors' => [['title' => 'Invalid Route']]],
                    'json',
                    ['Content-Type' => static::JSONAPI, 'StatusCode' => 404] /* Not Found */
                );
            });

        return $this;
    }

    public function run() : void
    {
        $this->init();
        tico()->serve();
    }

    public function toJson(WeatherProvider $provider, array $data) : array
    {
        $json = [
            'data' => [
                'type'       => $provider->getProviderName(),
                'attributes' => [],
            ],
        ];

        if (isset($data['id'])) {
            $json['data']['id'] = $data['id'];
            unset($data['id']);
        }

        $json['data']['attributes'] = array_merge($json['data']['attributes'], $data);

        return $json;
    }
}
