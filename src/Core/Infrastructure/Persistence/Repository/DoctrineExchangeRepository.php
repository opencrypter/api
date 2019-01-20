<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Repository;

use Core\Domain\Exchange\Exchange;
use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Exchange\ExchangeRepository;
use Core\Infrastructure\Persistence\Repository\DoctrineRepository;

class DoctrineExchangeRepository extends DoctrineRepository implements ExchangeRepository
{
    protected function entityClassName(): string
    {
        return Exchange::class;
    }

    public function save(Exchange $exchange): void
    {
        $this->persistAndFlush($exchange);
    }

    /**
     * @param ExchangeId $id
     * @return Exchange|null|object
     */
    public function exchangeOfId(ExchangeId $id): ?Exchange
    {
        return $this->repository()->find($id);
    }

    /**
     * @return Exchange[]
     */
    public function all(): array
    {
        return $this->repository()->findAll();
    }
}
