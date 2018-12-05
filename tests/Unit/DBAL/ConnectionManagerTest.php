<?php

declare(strict_types=1);


namespace Tests\Unit\DBAL;

use Exception;
use InvalidArgumentException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Models\DBAL\CacheQuery\Cache;
use Models\DBAL\ConnectionManager\ConnectionManager;
use Models\DBAL\DriverConnection\Connection;
use Models\DBAL\DriverConnection\DriverConnection;
use Models\DBAL\DriverConnection\Statement;
use Models\DBAL\Exceptions\ConnectionException;
use Models\DBAL\ParameterType\ParameterType;

final class ConnectionManagerTest extends MockeryTestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testInsert(array $connectionParams)
    {
        $tableName = 'testTable';
        $values = [
            'testField1'    => 'testValue1',
            'testField2'    => 2
        ];
        $types = [
            ParameterType::STRING,
            ParameterType::INTEGER
        ];

        $statementMock = Mockery::mock(Statement::class);
        $statementMock->shouldReceive('execute')
            ->withNoArgs()
            ->once()
            ->andReturn($statementMock);

        $connectionMock = Mockery::mock(Connection::class);

        $connectionMock
            ->shouldReceive('insert')
            ->with($tableName, $values)
            ->andReturn($statementMock);

        $driverConnectionMock = Mockery::mock(DriverConnection::class);
        $driverConnectionMock
            ->shouldReceive('connect')
            ->with($connectionParams)
            ->once()
            ->andReturn($connectionMock);

        $counter = 0;
        foreach ($values as $value) {
            $connectionMock
                ->shouldReceive('secureValue')
                ->with($value, $types[$counter])
                ->andReturn($value);
            $counter++;
        }

        $cacheMock = Mockery::mock(Cache::class);

        $sut = new ConnectionManager($driverConnectionMock, $connectionParams, $cacheMock);

        $this->assertTrue($sut->insert($tableName, $values, $types));
    }

    /**
     * @dataProvider dataProvider
     * @expectedException InvalidArgumentException
     */
    public function testInsertEmptyTableName(array $connectionParams)
    {
        $tableName = '';
        $values = [
            'testField1'    => 'testValue1',
            'testField2'    => 2
        ];
        $types = [
            ParameterType::STRING,
            ParameterType::INTEGER
        ];

        $driverConnectionMock = Mockery::mock(DriverConnection::class);

        $connectionMock = Mockery::mock(Connection::class);
        $statementMock = Mockery::mock(Statement::class);

        $connectionMock
            ->shouldReceive('insert')
            ->with($tableName, $values)
            ->andReturn($statementMock);

        $driverConnectionMock = Mockery::mock(DriverConnection::class);
        $driverConnectionMock
            ->shouldReceive('connect')
            ->with($connectionParams)
            ->once()
            ->andReturn($connectionMock);

        $cacheMock = Mockery::mock(Cache::class);

        $sut = new ConnectionManager($driverConnectionMock, $connectionParams, $cacheMock);

        $sut->insert($tableName, $values, $types);
    }

    /**
     * @dataProvider dataProvider
     * @expectedException Exception
     */
    public function testInsertException(array $connectionParams)
    {
        $tableName = '';
        $values = [
            'testField1'    => 'testValue1',
            'testField2'    => 2
        ];
        $types = [
            ParameterType::STRING,
            ParameterType::INTEGER
        ];

        $driverConnectionMock = Mockery::mock(DriverConnection::class);

        $connectionMock = Mockery::mock(Connection::class);
        $statementMock = Mockery::mock(Statement::class);

        $connectionMock
            ->shouldReceive('insert')
            ->andThrow(ConnectionException::class);

        $driverConnectionMock = Mockery::mock(DriverConnection::class);
        $driverConnectionMock
            ->shouldReceive('connect')
            ->with($connectionParams)
            ->once()
            ->andReturn($connectionMock);

        $cacheMock = Mockery::mock(Cache::class);

        $sut = new ConnectionManager($driverConnectionMock, $connectionParams, $cacheMock);

        $sut->insert($tableName, $values, $types);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testSelect(array $connectionParams)
    {
        $tableName = 'testTable';
        $values = [
            'testField1'    => 'testValue1',
            'testField2'    => 2
        ];
        $selectFields = [
            'testField1',
            'testField2'
        ];
        $enableCaching = true;
        $cacheLifetime = 3600;

        $statementMock = Mockery::mock(Statement::class);
        $statementMock->shouldReceive('execute')
            ->withNoArgs()
            ->atMost()
            ->times(1)
            ->andReturn($statementMock);

        $connectionMock = Mockery::mock(Connection::class);

        $connectionMock
            ->shouldReceive('select')
            ->with($tableName, $selectFields)
            ->atMost()
            ->times(1)
            ->andReturn($statementMock);

        $driverConnectionMock = Mockery::mock(DriverConnection::class);
        $driverConnectionMock
            ->shouldReceive('connect')
            ->with($connectionParams)
            ->once()
            ->andReturn($connectionMock);

        $cacheKey = 'key';
        $connectionMock->shouldReceive('getOrGenerateCacheKey')
            ->withNoArgs()
            ->andReturn($cacheKey);
        $cacheMock = Mockery::mock(Cache::class);
        $cacheMock->shouldReceive('contains')
            ->with($cacheKey)
            ->once()
            ->andReturnTrue();
        $cacheMock->shouldReceive('fetch')
            ->with($cacheKey)
            ->once()
            ->andReturn($values);

        $sut = new ConnectionManager($driverConnectionMock, $connectionParams, $cacheMock);

        $this->assertEquals($values, $sut->select(
            $tableName,
            $selectFields,
            $enableCaching,
            $cacheLifetime,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        ));
    }

    public function dataProvider(): array
    {
        return [
            [
                'connectionParams' => [
                    'dbuser'    => 'localhost',
                    'dbname'    => 'test',
                    'username'  => 'tester',
                    'password'  => 'pass',
                    'driver'    => 'mysql'
                ]
            ]
        ];
    }
}
