<?php
declare(strict_types=1);

namespace Core\Domain\Credentials;

use Core\Domain\ValueObject;

class Secret implements ValueObject
{
    /**
     * @var string
     */
    private $value;

    /**
     * Secret constructor.
     *
     * @param string $value
     * @throws InvalidSecret
     */
    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new InvalidSecret($value);
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
