<?php
declare(strict_types=1);

namespace Core\Domain\User;

use Core\Domain\DomainException;
use PHPUnit\Runner\Exception;
use Throwable;

class InvalidEmail extends Exception implements DomainException
{
    public function __construct(string $value, int $code = 400, Throwable $previous = null)
    {
        parent::__construct("{$value} is an invalid email", $code, $previous);
    }
}
