<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Application\Exchange;

use Core\Application\Exchange\ExchangeDtoAssembler;
use Core\Application\Exchange\GetAllAvailableExchanges;
use Core\Application\Exchange\GetAllAvailableExchangesHandler;
use Core\Domain\Exchange\ExchangeRepository;
use Tests\Util\Factory\ExchangeFactory;
use Tests\Util\Mock\ExchangeRepositoryMock;
use PHPUnit\Framework\TestCase;

class GetAllAvailableExchangesHandlerTest extends TestCase
{
    private $mockedRepository;
    private $assembler;
    private $handler;

    protected function setUp()
    {
        $this->mockedRepository = new ExchangeRepositoryMock($this->prophesize(ExchangeRepository::class));
        $this->assembler = new ExchangeDtoAssembler();
        $this->handler = new GetAllAvailableExchangesHandler($this->mockedRepository->reveal(), $this->assembler);
    }

    /**
     * @throws \Exception
     */
    public function testHandler(): void
    {
        $exchange = ExchangeFactory::random();

        $this->mockedRepository->shouldAll([$exchange]);

        self::assertEquals(
            [$this->assembler->writeDto($exchange)],
            $this->handler->handle(new GetAllAvailableExchanges())
        );
    }
}
