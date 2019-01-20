<?php
declare(strict_types=1);

namespace Core\Domain\Exchange;

use Core\Domain\Id;
use Core\Domain\InvalidId;

final class ExchangeId extends Id
{
    /**
     * Specific exception thrown on receive an invalid id.
     *
     * @param string $invalidValue
     * @return InvalidId
     */
    protected function exception(string $invalidValue): InvalidId
    {
        return new InvalidExchangeId($invalidValue);
    }
}
