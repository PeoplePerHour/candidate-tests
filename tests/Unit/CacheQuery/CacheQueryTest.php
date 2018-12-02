<?php
declare(strict_types = 1);

namespace Tests\Unit\CacheQuery;

use Doctrine\DBAL\Cache\CacheException;
use Doctrine\DBAL\Cache\QueryCacheProfile;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\ResultStatement;
use Doctrine\DBAL\ParameterType;
use Exception;
use InvalidArgumentException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Models\CacheQuery\CacheQuery;

final class CacheQueryTest extends MockeryTestCase
{
    public function test()
    {
        $query = 'SELECT * FROM testTable WHERE id=?';
        $params = [5];
        $types = [ParameterType::INTEGER];
        $cacheProfile = Mockery::mock(
            QueryCacheProfile::class,
            [
                0,
                'testKey'
            ]
        );
        $expectedResult = [
            [
                'id' => 5,
                'name' => 'test'
            ],
        ];

        $returnResultMock = Mockery::mock(ResultStatement::class);
        $connectionMock = Mockery::mock(Connection::class);
        $connectionMock
            ->shouldReceive('executeCacheQuery')
            ->with($query, $params, $types, $cacheProfile)
            ->once()
            ->andReturn($returnResultMock);
        $returnResultMock
            ->shouldReceive('fetchAll')
            ->withNoArgs()
            ->once()
            ->andReturn($expectedResult);
        $returnResultMock
            ->shouldReceive('closeCursor')
            ->withNoArgs();


        $sut = new CacheQuery();
        $this->assertEquals(
            $expectedResult,
            $sut->executeCacheQuery(
                $connectionMock,
                $query,
                $cacheProfile,
                $params,
                $types
            )
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testEmptyQuery()
    {
        $connectionMock = Mockery::mock(Connection::class);
        $query = '';
        $params = [5];
        $types = [ParameterType::INTEGER];
        $cacheProfile = Mockery::mock(
            QueryCacheProfile::class,
            [
                0,
                'testKey'
            ]
        );
        $expectedResult = [
            [
                'id' => 5,
                'name' => 'test'
            ],
        ];

        $sut = new CacheQuery();
        $sut->executeCacheQuery(
            $connectionMock,
            $query,
            $cacheProfile,
            $params,
            $types
        );
    }

    /**
     * @expectedException Exception
     */
    public function testExecuteCacheQueryException()
    {
        $connectionMock = Mockery::mock(Connection::class);
        $query = '';
        $params = [5];
        $types = [ParameterType::INTEGER];
        $cacheProfile = Mockery::mock(
            QueryCacheProfile::class,
            [
                0,
                'testKey'
            ]
        );

        $connectionMock
            ->shouldReceive('executeCacheQuery')
            ->andThrow(CacheException::class);

        $sut = new CacheQuery();
        $sut->executeCacheQuery(
            $connectionMock,
            $query,
            $cacheProfile,
            $params,
            $types
        );
    }
}
