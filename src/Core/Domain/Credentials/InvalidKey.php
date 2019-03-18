<?php
declare(strict_types=1);

namespace Core\Domain\Credentials;

use Core\Domain\DomainException;
use Throwable;

class InvalidKey extends \Exception implements DomainException
{
    public function __construct(string $key, int $code = 400, Throwable $previous = null)
    {
        parent::__construct("The key '{$key}' is invalid", $code, $previous);
    }
}
