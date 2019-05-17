<?php
declare(strict_types=1);

namespace Core\Domain\Ticker;

use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Symbol;

interface TickerRepository
{
    public function newId(): TickerId;

    public function save(Ticker $ticker);

    public function tickerOfId(TickerId $id): ?Ticker;

    public function tickerOfSymbolAndExchangeId(Symbol $symbol, ExchangeId $exchangeId): ?Ticker;
}
