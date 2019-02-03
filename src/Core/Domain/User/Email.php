<?php
declare(strict_types=1);

namespace Core\Domain\User;

use Core\Domain\ValueObject;

class Email implements ValueObject
{
    /**
     * @var string
     */
    private $value;

    /**
     * Email constructor.
     *
     * @param string $value
     * @throws InvalidEmail
     */
    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmail($value);
        }

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
