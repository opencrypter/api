<?php
declare(strict_types=1);

namespace Core\Domain\Exchange;

interface ExchangeRepository
{
    /**
     * @param Exchange $exchange
     */
    public function save(Exchange $exchange): void;

    /**
     * @param ExchangeId $id
     * @return Exchange|null
     */
    public function exchangeOfId(ExchangeId $id): ?Exchange;

    /**
     * @return Exchange[]
     */
    public function all(): array;
}
