<?php
declare(strict_types=1);

namespace Core\Application\Credentials;

use Core\Application\ApplicationException;
use Core\Domain\Credentials\CredentialsId;
use PHPUnit\Runner\Exception;
use Throwable;

class CredentialsNotFound extends Exception implements ApplicationException
{
    public function __construct(CredentialsId $id, int $code = 404, Throwable $previous = null)
    {
        $message = sprintf("Credentials with id %s not found", $id->value());

        parent::__construct($message, $code, $previous);
    }
}
