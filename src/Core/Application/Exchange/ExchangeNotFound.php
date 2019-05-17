<?php
declare(strict_types=1);

namespace Core\Application\Exchange;

use Core\Application\ApplicationException;
use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Name;
use Exception;
use Throwable;

class ExchangeNotFound extends Exception implements ApplicationException
{
    public function __construct(string $exchangeId, int $code = 404, Throwable $previous = null)
    {
        parent::__construct("Exchange {$exchangeId} not found", $code, $previous);
    }

    public static function createWithId(ExchangeId $exchangeId): self
    {
        return new static("with id '{$exchangeId->value()}'");
    }

    public static function createWithName(Name $name): self
    {
        return new self("with name '{$name->value()}'");
    }
}
