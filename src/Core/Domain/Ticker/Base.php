<?php
declare(strict_types=1);

namespace Core\Domain\Ticker;

use Core\Domain\ValueObject;

class Base implements ValueObject
{
    /**
     * @var string
     */
    private $value;

    /**
     * Base constructor.
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
