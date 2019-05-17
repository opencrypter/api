<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Application\Ticker;

use Core\Application\Exchange\ExchangeNotFound;
use Core\Application\Ticker\SynchronizeTickers;
use Core\Application\Ticker\SynchronizeTickersCommandHandler;
use Core\Application\Ticker\TickerApi;
use Core\Application\Ticker\TickerApiNotFound;
use Core\Application\Ticker\TickerDto;
use Core\Domain\CreatedAt;
use Core\Domain\Exchange\ExchangeRepository;
use Core\Domain\Ticker\Price;
use Core\Domain\Ticker\TickerRepository;
use Core\Infrastructure\Factory\TickerApiFactory;
use Symfony\Bridge\PhpUnit\ClockMock;
use Tests\Unit\Core\TestCase;
use Tests\Util\Factory\ExchangeFactory;
use Tests\Util\Factory\TickerFactory;
use Tests\Util\Mock\ExchangeRepositoryMock;
use Tests\Util\Mock\TickerApiMock;
use Tests\Util\Mock\TickerRepositoryMock;

class SynchronizeTickersCommandHandlerTest extends TestCase
{
    private $apiTickerMock;

    private $tickerRepositoryMock;

    private $exchangeRepositoryMock;

    private $handler;

    public static function setUpBeforeClass()
    {
        ClockMock::register(CreatedAt::class);
    }

    protected function setUp()
    {
        $this->apiTickerMock          = new TickerApiMock($this->prophesize(TickerApi::class));
        $this->tickerRepositoryMock   = new TickerRepositoryMock($this->prophesize(TickerRepository::class));
        $this->exchangeRepositoryMock = new ExchangeRepositoryMock($this->prophesize(ExchangeRepository::class));

        $this->handler = new SynchronizeTickersCommandHandler(
            new TickerApiFactory([
                'test' => $this->apiTickerMock->reveal()
            ]),
            $this->tickerRepositoryMock->reveal(),
            $this->exchangeRepositoryMock->reveal()
        );

        ClockMock::withClockMock(strtotime('2009-01-03 00:00:00'));
    }

    /**
     * @throws \Throwable
     */
    public function testHandler(): void
    {
        $exchange       = ExchangeFactory::withName('test');
        $newTicker      = TickerFactory::withExchangeId($exchange->id()->value());
        $existingTicker = TickerFactory::withExchangeId($exchange->id()->value());
        $updatedTicker  = (clone $existingTicker)->updatePrice(new Price(10000));

        $this->exchangeRepositoryMock
            ->shouldFindExchangeOfName($exchange->name(), $exchange);

        $this->apiTickerMock
            ->shouldFindAllTickers([
                new TickerDto($existingTicker->symbol()->value(), $updatedTicker->price()->value()),
                new TickerDto($newTicker->symbol()->value(), $newTicker->price()->value()),
            ]);

        $this->tickerRepositoryMock
            ->shouldFindTickerOfSymbolAndExchangeId($existingTicker->symbol(), $exchange->id(), $existingTicker)
            ->shouldSave($updatedTicker)
            ->shouldFindTickerOfSymbolAndExchangeId($newTicker->symbol(), $exchange->id(), null)
            ->shouldNewId($newTicker->id())
            ->shouldSave($newTicker);

        $this->handler->__invoke(new SynchronizeTickers($exchange->name()->value()));
    }

    /**
     * @throws \Throwable
     */
    public function testExceptionWhenExchangeNotFound(): void
    {
        $this->expectException(ExchangeNotFound::class);

        $exchange = ExchangeFactory::withName('test');

        $this->exchangeRepositoryMock
            ->shouldFindExchangeOfName($exchange->name(), null);

        $this->handler->__invoke(new SynchronizeTickers($exchange->name()->value()));
    }

    /**
     * @throws \Throwable
     */
    public function testExceptionWhenApiNotFound(): void
    {
        $this->expectException(TickerApiNotFound::class);

        $this->handler->__invoke(new SynchronizeTickers('invalid'));
    }
}
