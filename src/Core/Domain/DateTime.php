<?php
declare(strict_types=1);

namespace Core\Domain;

abstract class DateTime implements ValueObject
{
    /**
     * @var \DateTimeImmutable
     */
    private $value;

    /**
     * DateTime constructor.
     *
     * @param \DateTimeImmutable $value Value
     */
    public function __construct(\DateTimeImmutable $value)
    {
        $this->value = $value;
    }

    /**
     * New instance with the current time as value.
     *
     * @return static
     */
    public static function now(): self
    {
        return new static(\DateTimeImmutable::createFromFormat('U', (string) time()));
    }

    /**
     * @return \DateTimeImmutable
     */
    public function value(): \DateTimeImmutable
    {
        return $this->value;
    }

    /**
     * @param string $format
     * @return string
     */
    public function format(string $format = \DateTime::ATOM): string
    {
        return $this->value->format($format);
    }
}
