<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Type;

use Core\Domain\Ticker\Quote;
use Core\Domain\ValueObject;
use Core\Infrastructure\Persistence\Type\Scalar\DoctrineString;

class DoctrineQuote extends DoctrineString
{
    public const NAME = 'quote';

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
        return new Quote($value);
    }
}
