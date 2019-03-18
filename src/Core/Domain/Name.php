<?php
declare(strict_types=1);

namespace Core\Domain;

use Core\Domain\Exchange\InvalidName;

final class Name implements ValueObject
{
    /**
     * @var string
     */
    private $value;

    /**
     * Name constructor.
     *
     * @param string $value Name value
     * @throws InvalidName
     */
    public function __construct(string $value)
    {
        $this->assertValue($value);
        $this->value = $value;
    }

    /**
     * Asserts if the value is valid.
     *
     * @param string $value
     * @throws InvalidName
     */
    private function assertValue(string $value): void
    {
        if (empty($value)) {
            throw new InvalidName($value);
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
