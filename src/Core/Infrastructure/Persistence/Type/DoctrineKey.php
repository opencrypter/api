<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Type;

use Core\Domain\Credentials\Key;
use Core\Domain\ValueObject;
use Core\Infrastructure\Persistence\Type\Scalar\EncryptedString;

class DoctrineKey extends EncryptedString
{
    public const NAME = 'key';

    /**
     * Name to be used by Doctrine.
     *
     * @return string
     */
    protected static function name(): string
    {
        return self::NAME;
    }

    /**
     * Returns a new value object.
     *
     * @param string $value
     * @return ValueObject
     * @throws \Core\Domain\Credentials\InvalidKey
     */
    protected function newInstance(string $value): ValueObject
    {
        return new Key($value);
    }
}
