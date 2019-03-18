<?php
declare(strict_types=1);

namespace Core\Application\Credentials;

use Core\Application\ApplicationException;
use Core\Domain\Exchange\ExchangeId;
use Throwable;

class InvalidExchangeForCredentials extends \Exception implements ApplicationException
{
    public function __construct(ExchangeId $exchangeId, int $code = 400, Throwable $previous = null)
    {
        $message = "Exchange {$exchangeId->value()} cannot be related with the given credentials";
        parent::__construct($message, $code, $previous);
    }
}
