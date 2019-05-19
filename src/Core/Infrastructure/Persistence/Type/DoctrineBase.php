<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Type;

use Core\Domain\Ticker\Base;
use Core\Domain\ValueObject;
use Core\Infrastructure\Persistence\Type\Scalar\DoctrineString;

class DoctrineBase extends DoctrineString
{
    public const NAME = 'base';

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
        return new Base($value);
    }
}
