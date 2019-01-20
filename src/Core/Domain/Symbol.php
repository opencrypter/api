<?php
declare(strict_types=1);

namespace Core\Domain;

class Symbol implements ValueObject
{
    /**
     * @var string
     */
    private $value;

    /**
     * Symbol constructor.
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
