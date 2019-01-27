<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Type;

use Core\Domain\Order\Step\Value;
use Core\Domain\ValueObject;
use Core\Infrastructure\Persistence\Type\Scalar\DoctrineFloat;

class DoctrineValue extends DoctrineFloat
{
    public const NAME = 'value';

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
        return new Value($value);
    }
}
