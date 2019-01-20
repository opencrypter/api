<?php
declare(strict_types=1);

namespace Core\Domain;

abstract class Id
{
    /**
     * @var string
     */
    private $value;

    /**
     * Id constructor.
     *
     * @param string $value Id in uuid format.
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * Specific exception thrown on receive an invalid id.
     *
     * @param string $invalidValue
     * @return InvalidId
     */
    abstract protected function exception(string $invalidValue): InvalidId;

    /**
     * Id as plain string.
     *
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
