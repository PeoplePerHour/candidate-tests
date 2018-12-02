<?php
declare(strict_types = 1);

namespace Tests\Unit\DatabaseCrud;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Statement;
use Exception;
use InvalidArgumentException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Models\DatabaseConnection\DatabaseConnection;
use Models\DatabaseCrud\CrudQuery;

final class CrudQueryTest extends MockeryTestCase
{
    public function test()
    {
        $query = "SELECT * FROM test WHERE id=?";
        $id = 5;
        $responseArray = [
            'id' => '5',
            'name' => 'test'
        ];

        $connectionMock = Mockery::mock(Connection::class);
        $statementMock = Mockery::mock(Statement::class);

        $connectionMock
            ->shouldReceive('prepare')
            ->with($query)
            ->once()
            ->andReturn($statementMock);

        $statementMock
            ->shouldReceive('bindValue')
            ->with(1, $id)
            ->andReturn($statementMock);

        $statementMock
            ->shouldReceive('execute')
            ->withNoArgs()
            ->andReturn(true);

        $statementMock
            ->shouldReceive('fetchAll')
            ->withNoArgs()
            ->once()
            ->andReturn($responseArray);

        $sut = new CrudQuery();
        $this->assertEquals(
            $responseArray,
            $sut->query($connectionMock, $query, [$id])
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testEmptyQuery()
    {
        $connectionMock = Mockery::mock(Connection::class);
        $sut = new CrudQuery();
        $sut->query($connectionMock, '', [5]);
    }

    /**
     * @expectedException Exception
     */
    public function testQueryPreparationException()
    {
        $query = "SELECT * FROM test WHERE id=?";
        $id = 5;

        $connectionMock = Mockery::mock(Connection::class);

        $connectionMock
            ->shouldReceive('prepare')
            ->andThrow(DBALException::class);

        $sut = new CrudQuery();
        $sut->query($connectionMock, $query, [$id]);
    }
}
