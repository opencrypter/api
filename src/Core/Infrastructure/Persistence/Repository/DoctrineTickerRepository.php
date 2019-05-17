<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Repository;

use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Symbol;
use Core\Domain\Ticker\Ticker;
use Core\Domain\Ticker\TickerId;
use Core\Domain\Ticker\TickerRepository;
use Ramsey\Uuid\Uuid;

class DoctrineTickerRepository extends DoctrineRepository implements TickerRepository
{
    /**
     * @return string
     */
    protected function entityClassName(): string
    {
        return Ticker::class;
    }

    public function newId(): TickerId
    {
        return new TickerId(Uuid::uuid4()->toString());
    }

    public function save(Ticker $ticker)
    {
        $this->persistAndFlush($ticker);
    }

    public function tickerOfId(TickerId $id): ?Ticker
    {
        return $this
            ->repository()
            ->find($id);
    }

    public function tickerOfSymbolAndExchangeId(Symbol $symbol, ExchangeId $exchangeId): ?Ticker
    {
        return $this
            ->repository()
            ->findOneBy([
                'symbol'     => $symbol,
                'exchangeId' => $exchangeId,
            ]);
    }
}
