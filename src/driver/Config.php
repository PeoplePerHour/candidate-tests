<?php

namespace Manager\Driver;

class Config {

    private $adapter;

    private $drivers = [
        'postgres' => [
            'dbuser' => 'design_user',
            'dbpass' => 'd123456u',
            'dbname' => 'design_db',
            'port' => '5432',
            'host' => 'db.design.test',
            'driver' => 'pgsql'
        ],
        'mysqli' => '',
        'sqlite' => ''
    ];

    /**
     * Config constructor.
     * @param $adapter
     */
    public function __construct($adapter)
    {
        $this->adapter = $this->drivers[$adapter];
    }

    /**
     * Return selected connection adapter.
     * @return mixed
     */
    public function getAdapter()
    {
       return $this->adapter;
    }


}