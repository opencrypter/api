<?php
declare(strict_types=1);

namespace Core\Domain\Exchange;

use Core\Domain\Name;

interface ExchangeRepository
{
    /**
     * @param Exchange $exchange
     */
    public function save(Exchange $exchange): void;

    /**
     * @param ExchangeId $id
     * @return bool
     */
    public function exists(ExchangeId $id): bool;

    /**
     * @param ExchangeId $id
     * @return Exchange|null
     */
    public function exchangeOfId(ExchangeId $id): ?Exchange;

    /**
     * @param Name $name
     * @return Exchange|null
     */
    public function exchangeOfName(Name $name): ?Exchange;

    /**
     * @return Exchange[]
     */
    public function all(): array;
}
