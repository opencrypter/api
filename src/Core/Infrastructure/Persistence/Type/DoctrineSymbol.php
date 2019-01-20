<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Type;

use Core\Domain\Symbol;
use Core\Domain\ValueObject;
use Core\Infrastructure\Persistence\Type\Scalar\DoctrineString;

class DoctrineSymbol extends DoctrineString
{
    public const NAME = 'symbol';

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
     */
    protected function newInstance(string $value): ValueObject
    {
        return new Symbol($value);
    }
}
