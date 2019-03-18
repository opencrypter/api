<?php
declare(strict_types=1);

namespace Core\Domain\Credentials;

use Core\Domain\Id;
use Core\Domain\InvalidId;

class CredentialsId extends Id
{
    /**
     * Specific exception thrown on receive an invalid id.
     *
     * @param string $invalidValue
     * @return InvalidId
     */
    protected function exception(string $invalidValue): InvalidId
    {
        return new InvalidCredentialsId($invalidValue);
    }
}
