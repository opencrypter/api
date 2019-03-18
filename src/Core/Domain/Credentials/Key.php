<?php
declare(strict_types=1);

namespace Core\Domain\Credentials;

use Core\Domain\ValueObject;

class Key implements ValueObject
{
    /**
     * @var string
     */
    private $value;

    /**
     * Key constructor.
     *
     * @param string $value
     * @throws InvalidKey
     */
    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new InvalidKey($value);
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
