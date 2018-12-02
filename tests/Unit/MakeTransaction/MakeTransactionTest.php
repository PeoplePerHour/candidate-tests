<?php
declare(strict_types = 1);

namespace Tests\Unit\MakeTransaction;

use Doctrine\DBAL\Connection;
use Exception;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Models\MakeTransaction\MakeTransaction;

final class MakeTransactionTest extends MockeryTestCase
{
    public function testBeginTransaction()
    {
        $connectionMock = Mockery::mock(Connection::class);
        $connectionMock
            ->shouldReceive('beginTransaction')
            ->withNoArgs()
            ->once();

        $sut = new MakeTransaction();

        $this->assertTrue($sut->beginTransaction($connectionMock));
    }

    public function testCommit()
    {
        $connectionMock = Mockery::mock(Connection::class);
        $connectionMock
            ->shouldReceive('commit')
            ->withNoArgs()
            ->once();

        $sut = new MakeTransaction();

        $this->assertTrue($sut->commit($connectionMock));
    }

    /**
     * @expectedException Exception
     */
    public function testExceptionCommit()
    {
        $connectionMock = Mockery::mock(Connection::class);
        $connectionMock
            ->shouldReceive('commit')
            ->andThrow(Exception::class);

        $sut = new MakeTransaction();
        $sut->commit($connectionMock);
    }

    /**
     * @expectedException Exception
     */
    public function testExceptionBeginTransaction()
    {
        $connectionMock = Mockery::mock(Connection::class);
        $connectionMock
            ->shouldReceive('beginTransaction')
            ->andThrow(Exception::class);

        $sut = new MakeTransaction();
        $sut->beginTransaction($connectionMock);
    }
}
