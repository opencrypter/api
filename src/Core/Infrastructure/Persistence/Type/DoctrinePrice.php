<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Type;

use Core\Domain\Ticker\Price;
use Core\Domain\ValueObject;
use Core\Infrastructure\Persistence\Type\Scalar\DoctrineFloat;

class DoctrinePrice extends DoctrineFloat
{
    public const NAME = 'price';

    /**
     * @return string
     */
    public function name(): string
    {
        return self::NAME;
    }

    /**
     * @param float $value
     * @return ValueObject
     */
    protected function newInstance(float $value): ValueObject
    {
        return new Price($value);
    }
}
