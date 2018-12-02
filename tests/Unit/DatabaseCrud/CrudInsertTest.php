<?php

declare(strict_types = 1);

namespace Tests\Unit\DatabaseCrud;

use Doctrine\DBAL\Query\QueryBuilder;
use InvalidArgumentException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Models\DatabaseConnection\DatabaseConnection;
use Models\DatabaseCrud\CrudInsert;

final class CrudInsertTest extends MockeryTestCase
{

    /**
     * @dataProvider dataProvider
     */
    public function test(string $tableName, array $parameters, array $values)
    {
        $queryBuilderMock = Mockery::mock(QueryBuilder::class);
        $queryBuilderMock
            ->shouldReceive('insert')
            ->with($tableName)
            ->once()
            ->andReturn($queryBuilderMock);
        $queryBuilderMock
            ->shouldReceive('values')
            ->with($values)
            ->once()
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
            ->shouldReceive('execute')
            ->withNoArgs()
            ->andReturn(1);

        $sut = new CrudInsert();

        $this->assertTrue($sut->insert($queryBuilderMock, $tableName, $parameters));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidTableName()
    {
        $queryBuilderMock = Mockery::mock(QueryBuilder::class);
        $sut = new CrudInsert();
        $sut->insert(
            $queryBuilderMock,
            '',
            ['name' => 'test']
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidValues()
    {
        $queryBuilderMock = Mockery::mock(QueryBuilder::class);
        $sut = new CrudInsert();
        $sut->insert(
            $queryBuilderMock,
            'test',
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
                'values'        => [
                    'name'          => '?',
                    'description'   => '?'
                ]
            ],
            [
                'tableName'     => 'test',
                'parameters'    => [
                    'name'          => 'testName',
                    'description'  => 10,
                ],
                'values'        => [
                    'name'          => '?',
                    'description'   => '?'
                ]
            ]
        ];
    }
}
