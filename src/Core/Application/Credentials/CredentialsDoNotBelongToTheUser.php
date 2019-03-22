<?php
declare(strict_types=1);

namespace Core\Application\Credentials;

use Core\Application\ApplicationException;
use Core\Domain\Credentials\CredentialsId;
use Core\Domain\User\UserId;
use PHPUnit\Runner\Exception;
use Throwable;

class CredentialsDoNotBelongToTheUser extends Exception implements ApplicationException
{
    public function __construct(CredentialsId $id, UserId $userId, int $code = 409, Throwable $previous = null)
    {
        $message = sprintf("The credentials %s do not belong to the user %s", $id->value(), $userId->value());

        parent::__construct($message, $code, $previous);
    }
}
