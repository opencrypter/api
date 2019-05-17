<?php
declare(strict_types=1);

namespace Core\Application\Ticker;

use Core\Domain\Name;

interface TickerApiFactory
{
    /**
     * @param Name $name
     * @return TickerApi
     *
     * @throws TickerApiNotFound
     */
    public function create(Name $name): TickerApi;
}
