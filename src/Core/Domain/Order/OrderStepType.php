<?php
declare(strict_types=1);

namespace Core\Domain\Order;

use Core\Domain\ValueObject;

class OrderStepType implements ValueObject
{
    /**
     * @var string
     */
    private $value;

    /**
     * OrderStepType constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }
}
