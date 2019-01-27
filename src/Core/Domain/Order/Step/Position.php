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

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
