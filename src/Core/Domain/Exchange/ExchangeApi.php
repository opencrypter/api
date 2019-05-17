<?php
declare(strict_types=1);

namespace Core\Domain\Exchange;

use Core\Application\Ticker\TickerDto;

interface ExchangeApi
{
    /**
     * @return TickerDto[]
     */
    public function allTickers(): array;
}
