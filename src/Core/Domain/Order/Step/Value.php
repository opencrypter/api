<?php
declare(strict_types=1);

namespace Core\Domain\Order\Step;

use Core\Domain\ValueObject;

class Value implements ValueObject
{
    /**
     * @var float
     */
    private $value;

    /**
     * Value constructor.
     *
     * @param float $value
     */
    public function __construct(float $value)
    {
        $this->value = $value;
    }

    /**
     * @return float
     */
    public function value(): float
    {
        return $this->value;
    }

    /**
     * @param Value $value
     * @return bool
     */
    public function equals(Value $value): bool
    {
        return $this->value === $value->value;
    }
}
