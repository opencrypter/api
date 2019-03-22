<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Type;

use Core\Domain\Credentials\Secret;
use Core\Domain\ValueObject;
use Core\Infrastructure\Persistence\Type\Scalar\EncryptedString;

class DoctrineSecret extends EncryptedString
{
    public const NAME = 'secret';

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
     * @throws \Core\Domain\Credentials\InvalidSecret
     */
    protected function newInstance(string $value): ValueObject
    {
        return new Secret($value);
    }
}
