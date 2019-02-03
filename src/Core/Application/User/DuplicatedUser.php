<?php
declare(strict_types=1);

namespace Core\Application\User;

use Core\Application\ApplicationException;
use Core\Domain\User\Email;
use Throwable;

class DuplicatedUser extends \Exception implements ApplicationException
{
    public function __construct(Email $email, int $code = 409, Throwable $previous = null)
    {
        parent::__construct("The email {$email->value()} already exists", $code, $previous);
    }
}
