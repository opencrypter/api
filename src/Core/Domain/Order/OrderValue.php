<?php
declare(strict_types=1);

namespace Core\Domain\Order;

use Core\Domain\ValueObject;

class OrderValue implements ValueObject
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
}
