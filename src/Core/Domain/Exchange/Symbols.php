<?php
declare(strict_types=1);

namespace Core\Domain\Exchange;

use Core\Domain\ValueObject;

class Symbols implements ValueObject
{
    /**
     * @var bool[]
     */
    private $value;

    /**
     * Symbol constructor.
     *
     * @param string[] $values
     */
    public function __construct(array $values)
    {
        $this->value = [];
        foreach ($values as $value) {
            $this->value[$value] = true;
        }
    }

    /**
     * @return bool[]
     */
    public function value(): array
    {
        return $this->value;
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return array_keys($this->value);
    }
}
