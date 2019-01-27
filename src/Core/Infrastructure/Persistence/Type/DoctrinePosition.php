<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Type;

use Core\Domain\Order\Step\Position;
use Core\Domain\ValueObject;
use Core\Infrastructure\Persistence\Type\Scalar\DoctrineInteger;

class DoctrinePosition extends DoctrineInteger
{
    public const NAME = 'position';

    /**
     * @return string
     */
    public function name(): string
    {
        return self::NAME;
    }

    /**
     * @param int $value
     * @return ValueObject
     * @throws \Core\Domain\Order\Step\InvalidPosition
     */
    protected function newInstance(int $value): ValueObject
    {
        return new Position($value);
    }
}
