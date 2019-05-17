<?php
declare(strict_types=1);

namespace Tests\Util\Mock;

use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Symbol;
use Core\Domain\Ticker\Ticker;
use Core\Domain\Ticker\TickerId;
use Core\Domain\Ticker\TickerRepository;

/**
 * @method TickerRepository reveal
 */
final class TickerRepositoryMock extends Mock
{
    public function shouldSave(Ticker $ticker): self
    {
        $this
            ->prophecy()
            ->save($ticker)
            ->shouldBeCalledOnce();

        return $this;
    }

    public function shouldNewId(TickerId $id, int $times = 1): self
    {
        $this
            ->prophecy()
            ->newId()
            ->willReturn($id)
            ->shouldBeCalledTimes($times);

        return $this;
    }

    public function shouldFindTickerOfSymbolAndExchangeId(Symbol $symbol, ExchangeId $exchangeId, ?Ticker $ticker): self
    {
        $this
            ->prophecy()
            ->tickerOfSymbolAndExchangeId($symbol, $exchangeId)
            ->willReturn($ticker)
            ->shouldBeCalledOnce();

        return $this;
    }
}
