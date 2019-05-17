<?php
declare(strict_types=1);

namespace Core\Infrastructure\Factory;

use Core\Application\Ticker\TickerApi;
use Core\Application\Ticker\TickerApiNotFound;
use Core\Domain\Name;

class TickerApiFactory implements \Core\Application\Ticker\TickerApiFactory
{
    /**
     * @var array
     */
    private $apis;

    public function __construct(array $apis)
    {
        $this->apis = $apis;
    }

    /**
     * @param Name $name
     * @return TickerApi
     *
     * @throws TickerApiNotFound
     */
    public function create(Name $name): TickerApi
    {
        $api = $this->apis[$name->value()] ?? null;

        if ($api === null) {
            throw new TickerApiNotFound($name->value());
        }

        return $api;
    }
}
