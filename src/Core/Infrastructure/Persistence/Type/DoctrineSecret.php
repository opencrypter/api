<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Type;

use Core\Domain\Credentials\Secret;
use Core\Domain\ValueObject;
use Core\Infrastructure\Persistence\Type\Scalar\DoctrineString;

class DoctrineSecret extends DoctrineString
{
    /**
     * Name to be used by Doctrine.
     *
     * @return string
     */
    protected function name(): string
    {
        return 'secret';
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
