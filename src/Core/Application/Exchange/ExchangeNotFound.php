<?php
declare(strict_types=1);

namespace Core\Application\Exchange;

use Core\Application\ApplicationException;
use Core\Domain\Exchange\ExchangeId;
use Throwable;

class ExchangeNotFound extends \Exception implements ApplicationException
{
    public function __construct(string $exchangeId, int $code = 404, Throwable $previous = null)
    {
        parent::__construct("Exchange with id {$exchangeId} not found", $code, $previous);
    }

    public static function create(ExchangeId $exchangeId): self
    {
        return new self($exchangeId->value());
    }
}
