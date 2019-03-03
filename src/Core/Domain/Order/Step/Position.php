<?php
declare(strict_types=1);

namespace Core\Domain\Order\Step;

use Core\Domain\ValueObject;

class Position implements ValueObject
{
    /**
     * @var int
     */
    private $value;

    /**
     * Position constructor.
     *
     * @param int $value
     * @throws InvalidPosition
     */
    public function __construct(int $value)
    {
        if ($value < 1) {
            throw new InvalidPosition($value);
        }
        $this->value = $value;
    }

    /**
     * Scalar value.
     *
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * @param Position $position
     * @return bool
     */
    public function equals(Position $position): bool
    {
        return $this->value === $position->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
