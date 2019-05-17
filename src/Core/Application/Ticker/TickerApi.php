<?php
declare(strict_types=1);

namespace Core\Application\Ticker;

interface TickerApi
{
    /**
     * @return TickerDto[]
     */
    public function allTickers(): array;
}
