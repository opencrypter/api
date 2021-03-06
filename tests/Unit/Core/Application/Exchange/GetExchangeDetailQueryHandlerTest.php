<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Application\Exchange;

use Core\Application\Exchange\ExchangeDtoAssembler;
use Core\Application\Exchange\ExchangeNotFound;
use Core\Application\Exchange\GetExchangeDetail;
use Core\Application\Exchange\GetExchangeDetailQueryHandler;
use Core\Domain\Exchange\ExchangeRepository;
use Tests\Unit\Core\TestCase;
use Tests\Util\Factory\ExchangeFactory;
use Tests\Util\Mock\ExchangeRepositoryMock;

class GetExchangeDetailQueryHandlerTest extends TestCase
{
    private $mockedRepository;
    private $assembler;
    private $handler;

    protected function setUp()
    {
        $this->mockedRepository = new ExchangeRepositoryMock($this->prophesize(ExchangeRepository::class));
        $this->assembler = new ExchangeDtoAssembler();
        $this->handler = new GetExchangeDetailQueryHandler($this->mockedRepository->reveal(), $this->assembler);
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
        $this->expectExceptionCode(404);

        $exchange = ExchangeFactory::random();
        $this->mockedRepository->shouldFindExchangeOfId($exchange->id(), null);

        $this->handler->__invoke(new GetExchangeDetail($exchange->id()->value()));
    }
}
