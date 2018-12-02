<?php

declare(strict_types = 1);

namespace Tests\Unit\DatabaseCrud;

use Doctrine\DBAL\Query\QueryBuilder;
use InvalidArgumentException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Models\DatabaseCrud\CrudDelete;

final class CrudDeleteTest extends MockeryTestCase
{
    public function test()
    {
        $tableName = 'test';
        $id = 5;

        $queryBuilderMock = Mockery::mock(QueryBuilder::class);
        $queryBuilderMock
            ->shouldReceive('delete')
            ->with($tableName)
            ->once()
            ->andReturn($queryBuilderMock);
        $queryBuilderMock
            ->shouldReceive('where')
            ->with('id = ?')
            ->andReturn($queryBuilderMock);

        $queryBuilderMock
            ->shouldReceive('setParameter')
            ->with(0, $id)
            ->andReturn($queryBuilderMock);
        $queryBuilderMock
            ->shouldReceive('execute')
            ->withNoArgs()
            ->andReturn(1);

        $sut = new CrudDelete();

        $this->assertEquals(
            1,
            $sut->delete($queryBuilderMock, $tableName, $id)
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidTableName()
    {
        $queryBuilderMock = Mockery::mock(QueryBuilder::class);
        $sut = new CrudDelete();
        $sut->delete($queryBuilderMock, '', 5);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidValues()
    {
        $queryBuilderMock = Mockery::mock(QueryBuilder::class);
        $sut = new CrudDelete();
        $sut->delete($queryBuilderMock, 'test', 0);
    }
}
