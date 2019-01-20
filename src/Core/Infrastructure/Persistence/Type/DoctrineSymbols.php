<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Type;

use Core\Domain\Exchange\Symbols;
use Core\Domain\ValueObject;
use Core\Infrastructure\Persistence\Type\Scalar\DoctrineJson;

class DoctrineSymbols extends DoctrineJson
{
    private const NAME = 'symbols';

    /**
     * Name to be used by Doctrine.
     *
     * @return string
     */
    protected function name(): string
    {
        return self::NAME;
    }

    /**
     * Returns a new value object.
     *
     * @param array $json
     * @return ValueObject
     */
    protected function newInstance(array $json): ValueObject
    {
        return new Symbols(\array_keys($json));
    }
}
