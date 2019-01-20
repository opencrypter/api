<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Type;

use Core\Domain\Exchange\Name;
use Core\Domain\ValueObject;
use Core\Infrastructure\Persistence\Type\Scalar\DoctrineString;

class DoctrineName extends DoctrineString
{
    public const NAME = 'name';

    /**
     * @return string
     */
    public function name(): string
    {
        return self::NAME;
    }

    /**
     * @param string $value
     * @return ValueObject
     * @throws \Core\Domain\Exchange\InvalidName
     */
    protected function newInstance(string $value): ValueObject
    {
        return new Name($value);
    }
}
