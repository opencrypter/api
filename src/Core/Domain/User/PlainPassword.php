<?php
declare(strict_types=1);

namespace Core\Domain\User;

use Core\Domain\ValueObject;

class PlainPassword implements ValueObject
{
    /**
     * @var string
     */
    private $value;

    /**
     * PlainPassword constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (strlen($value) < 6) {
            throw new InvalidPassword($value);
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
