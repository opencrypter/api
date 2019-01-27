<?php
declare(strict_types=1);

namespace Core\Domain\Order\Step;

use Core\Domain\ValueObject;

class Type implements ValueObject
{
    public const VALID_VALUES = [
        self::WAIT_PRICE,
        self::BUY,
        self::SELL,
    ];

    public const WAIT_PRICE = 'wait_price';

    public const BUY = 'buy';

    public const SELL = 'sell';

    /**
     * @var string
     */
    private $value;

    /**
     * OrderStepType constructor.
     *
     * @param string $value
     * @throws InvalidType
     */
    public function __construct(string $value)
    {
        $this->assertValue($value);
        $this->value = $value;
    }

    /**
     * @param string $value
     * @throws InvalidType
     */
    private function assertValue(string $value): void
    {
        if (!in_array($value, self::VALID_VALUES)) {
            throw new InvalidType($value);
        }
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }
}
