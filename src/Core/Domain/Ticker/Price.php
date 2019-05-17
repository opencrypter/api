<?php
declare(strict_types=1);

namespace Core\Domain\Ticker;

use Core\Domain\ValueObject;

class Price implements ValueObject
{
    /**
     * @var float
     */
    private $value;

    /**
     * Price constructor.
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
     * @param Price $price
     * @return bool
     */
    public function equals(Price $price): bool
    {
        return $this->value === $price->value;
    }
}
