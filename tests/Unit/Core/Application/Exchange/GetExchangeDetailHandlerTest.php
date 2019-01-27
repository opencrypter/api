<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Application\Exchange;

use Core\Application\Exchange\ExchangeDtoAssembler;
use Core\Application\Exchange\GetExchangeDetail;
use Core\Application\Exchange\GetExchangeDetailHandler;
use Core\Domain\Exchange\ExchangeNotFound;
use Core\Domain\Exchange\ExchangeRepository;
use Tests\Unit\TestCase;
use Tests\Util\Factory\ExchangeFactory;
use Tests\Util\Mock\ExchangeRepositoryMock;

class GetExchangeDetailHandlerTest extends TestCase
{
    private $mockedRepository;
    private $assembler;
    private $handler;

    protected function setUp()
    {
        $this->mockedRepository = new ExchangeRepositoryMock($this->prophesize(ExchangeRepository::class));
        $this->assembler = new ExchangeDtoAssembler();
        $this->handler = new GetExchangeDetailHandler($this->mockedRepository->reveal(), $this->assembler);
    }

    /**
     * @throws \Exception
     */
    public function testHandler(): void
    {
        $exchange = ExchangeFactory::random();

        $this->mockedRepository->shouldFindExchangeOfId($exchange->id(), $exchange);

        self::assertEquals(
            $this->assembler->writeDto($exchange),
            $this->handler->__invoke(new GetExchangeDetail($exchange->id()->value()))
        );
    }

    /**
     * @throws \Exception
     */
    public function testExceptionWhenExchangeDoesNotExist(): void
    {
        $this->expectException(ExchangeNotFound::class);

        $exchange = ExchangeFactory::random();
        $this->mockedRepository->shouldFindExchangeOfId($exchange->id(), null);

        $this->handler->__invoke(new GetExchangeDetail($exchange->id()->value()));
    }
}
