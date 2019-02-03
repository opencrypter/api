<?php
declare(strict_types=1);

namespace Core\Domain\User;

use Core\Domain\Id;
use Core\Domain\InvalidId;

class UserId extends Id
{
    /**
     * Specific exception thrown on receive an invalid id.
     *
     * @param string $invalidValue
     * @return InvalidId
     */
    protected function exception(string $invalidValue): InvalidId
    {
        return new InvalidUserId($invalidValue);
    }
}
