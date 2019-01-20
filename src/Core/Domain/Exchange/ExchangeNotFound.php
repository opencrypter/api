<?php
declare(strict_types=1);

namespace Core\Domain\Exchange;

use Core\Domain\DomainException;
use Throwable;

class ExchangeNotFound extends \Exception implements DomainException
{
    public function __construct(ExchangeId $exchangeId, int $code = 404, Throwable $previous = null)
    {
        parent::__construct("Exchange with id {$exchangeId->value()} not found", $code, $previous);
    }
}
