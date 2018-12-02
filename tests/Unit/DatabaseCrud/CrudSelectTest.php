<?php

declare(strict_types = 1);

namespace Tests\Unit\DatabaseCrud;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Statement;
use Exception;
use InvalidArgumentException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Models\DatabaseCrud\CrudSelect;

final class CrudSelectTest extends MockeryTestCase
{
    public function test()
    {
        $connectionMock = Mockery::mock(Connection::class);
        $statementMock = Mockery::mock(Statement::class);
        $id = 1;

        $selectFields = ['name', 'description'];
        $tableName = 'user';
        $joins = '';
        $whereValues=['id' => $id];
        $orderBy = 'id DESC';
        $groupBy = 'id';
        $having = '';
        $offset = 0;
        $limit = 10;
        $responseArray = [
            'id'    => 1,
            'name'  => 'test',
        ];

        $query = "SELECT name,description FROM user WHERE id = ? GROUP BY ? ORDER BY ? LIMIT ?";

        $connectionMock
            ->shouldReceive('prepare')
            ->with($query)
            ->once()
            ->andReturn($statementMock);

        $statementMock
            ->shouldReceive('bindValue')
            ->with(1, $id, ParameterType::INTEGER)
            ->andReturn($statementMock);
        $statementMock
            ->shouldReceive('bindValue')
            ->with(2, $groupBy)
            ->andReturn($statementMock);
        $statementMock
            ->shouldReceive('bindValue')
            ->with(3, $orderBy)
            ->andReturn($statementMock);
        $statementMock
            ->shouldReceive('bindValue')
            ->with(4, $limit, ParameterType::INTEGER)
            ->andReturn($statementMock);
        $statementMock
            ->shouldReceive('execute')
            ->withNoArgs()
            ->once()
            ->andReturn(true);
        $statementMock
            ->shouldReceive('fetchAll')
            ->withNoArgs()
            ->once()
            ->andReturn($responseArray);

        $sut = CrudSelect::fromParams(
            $connectionMock,
            $tableName,
            $selectFields,
            $joins,
            $whereValues,
            $orderBy,
            $groupBy,
            $having,
            $offset,
            $limit
        );

        $this->assertEquals($responseArray, $sut->select());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testEmptyTableName()
    {
        $connectionMock = Mockery::mock(Connection::class);
        $id = 1;

        $selectFields = ['name', 'description'];
        $tableName = '';
        $joins = '';
        $whereValues=['id' => $id];
        $orderBy = 'id DESC';
        $groupBy = 'id';
        $having = '';
        $offset = 0;
        $limit = 10;

        $sut = CrudSelect::fromParams(
            $connectionMock,
            $tableName,
            $selectFields,
            $joins,
            $whereValues,
            $orderBy,
            $groupBy,
            $having,
            $offset,
            $limit
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testEmptySelectFields()
    {
        $connectionMock = Mockery::mock(Connection::class);
        $id = 1;

        $selectFields = [];
        $tableName = '';
        $joins = '';
        $whereValues=['id' => $id];
        $orderBy = 'id DESC';
        $groupBy = 'id';
        $having = '';
        $offset = 0;
        $limit = 10;

        $sut = CrudSelect::fromParams(
            $connectionMock,
            $tableName,
            $selectFields,
            $joins,
            $whereValues,
            $orderBy,
            $groupBy,
            $having,
            $offset,
            $limit
        );
    }


    /**
     * @expectedException Exception
     */
    public function testQueryPreparationException()
    {
        $connectionMock = Mockery::mock(Connection::class);
        $exceptionMock = Mockery::mock(DBALException::class);

        $id = 1;

        $selectFields = ['name', 'description'];
        $tableName = 'user';
        $joins = '';
        $whereValues=['id' => $id];
        $orderBy = 'id DESC';
        $groupBy = 'id';
        $having = '';
        $offset = 0;
        $limit = 10;

        $query = "SELECT name,description FROM user WHERE id = ? GROUP BY ? ORDER BY ? LIMIT ?";

        $connectionMock
            ->shouldReceive('prepare')
            ->andThrow($exceptionMock, 'Query failed!');

        $sut = CrudSelect::fromParams(
            $connectionMock,
            $tableName,
            $selectFields,
            $joins,
            $whereValues,
            $orderBy,
            $groupBy,
            $having,
            $offset,
            $limit
        );

        $sut->select();
    }
}
