<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Type;

use Core\Domain\Order\Step\Type;
use Core\Domain\ValueObject;
use Core\Infrastructure\Persistence\Type\Scalar\DoctrineString;

class DoctrineStepType extends DoctrineString
{
    public const NAME = 'order_step_type';

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
        return new Type($value);
    }
}
