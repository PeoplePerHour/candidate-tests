<?php

declare(strict_types = 1);

namespace Tests\Unit\DatabaseCrud;

use Doctrine\DBAL\Query\QueryBuilder;
use InvalidArgumentException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Models\DatabaseConnection\DatabaseConnection;
use Models\DatabaseCrud\CrudInsert;
use Models\DatabaseCrud\CrudUpdate;

final class CrudUpdateTest extends MockeryTestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function test(string $tableName, array $parameters, array $where)
    {
        $queryBuilderMock = Mockery::mock(QueryBuilder::class);
        $queryBuilderMock
            ->shouldReceive('update')
            ->with($tableName)
            ->once()
            ->andReturn($queryBuilderMock);
        $queryBuilderMock
            ->shouldReceive('set')
            ->with(0, '?')
            ->andReturn($queryBuilderMock);
        $queryBuilderMock
            ->shouldReceive('set')
            ->with(1, '?')
            ->andReturn($queryBuilderMock);



        $queryBuilderMock
            ->shouldReceive('setParameter')
            ->with(0, $parameters['name'])
            ->andReturn($queryBuilderMock);
        $queryBuilderMock
            ->shouldReceive('setParameter')
            ->with(1, $parameters['description'])
            ->andReturn($queryBuilderMock);
        $queryBuilderMock
            ->shouldReceive('where')
            ->with('id = ?')
            ->andReturn($queryBuilderMock);
        $queryBuilderMock
            ->shouldReceive('setParameter')
            ->with(2, 1)
            ->andReturn($queryBuilderMock);
        $queryBuilderMock
            ->shouldReceive('execute')
            ->withNoArgs()
            ->andReturn(1);

        $sut = new CrudUpdate();

        $this->assertTrue($sut->update($queryBuilderMock, $tableName, $parameters, $where));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidTableName()
    {
        $queryBuilderMock = Mockery::mock(QueryBuilder::class);
        $sut = new CrudUpdate();
        $sut->update(
            $queryBuilderMock,
            '',
            ['name' => 'test'],
            ['id = 5']
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidValues()
    {
        $queryBuilderMock = Mockery::mock(QueryBuilder::class);
        $sut = new CrudUpdate();
        $sut->update(
            $queryBuilderMock,
            'test',
            [],
            []
        );
    }

    public function dataProvider(): array
    {
        return [
            [
                'tableName'     => 'test',
                'parameters'    => [
                    'name'          => 'testName',
                    'description'   => 'testDescription',
                ],
                'where'         => [
                    'id' => 1
                ]
            ],
            [
                'tableName'     => 'test',
                'parameters'    => [
                    'name'          => 'testName',
                    'description'  => 10,
                ],
                'where'         => [
                    'id' => 1
                ]
            ]
        ];
    }
}
