<?php

namespace CT\DBConnectionManager\Tests\Cache;

use CT\DBConnectionManager\Cache\RedisCache;
use PHPUnit\Framework\TestCase;

/**
 * Class RedisCacheTest
 * @package CT\DBConnectionManager\Tests\Cache
 */
class RedisCacheTest extends TestCase {

    protected $cache;
    protected $host;
    protected $port;

    protected function setUp() {
        $this->host = "localhost";
        $this->port = 6379;

        $this->cache = new RedisCache();
        $this->cache->connect($this->host, $this->port);
    }

    protected function tearDown() {
        unset($this->cache);
    }

    public function testConnect(){
        $this->assertObjectHasAttribute('cacheObj', $this->cache->connect($this->host, $this->port));
    }

    public function testSet(){
        $this->assertTrue($this->cache->set('key', 'value', 30));
    }

    public function testUpdate(){
        $this->cache->update('key', 'value_updated', 30);
        $this->assertEquals('value_updated', $this->cache->get('key'));
    }

    public function testGet(){
        $this->assertEquals('value_updated', $this->cache->get('key'));
    }

    public function testDelete(){
        $this->assertTrue($this->cache->delete('key'));
        $this->assertFalse($this->cache->delete('key'));
    }

    public function testClearCache(){
        $this->cache->set('key', 'another_value', 30);
        $this->assertTrue($this->cache->clearCache());
    }
}