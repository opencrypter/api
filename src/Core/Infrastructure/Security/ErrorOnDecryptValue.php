<?php
declare(strict_types=1);

namespace Core\Infrastructure\Security;

use Core\Infrastructure\InfrastructureException;
use Throwable;

class ErrorOnDecryptValue extends \Exception implements InfrastructureException
{
    public function __construct(string $value, int $code = 500, Throwable $previous = null)
    {
        $message = "The value {$value} cannot be decrypted";

        parent::__construct($message, $code, $previous);
    }
}
