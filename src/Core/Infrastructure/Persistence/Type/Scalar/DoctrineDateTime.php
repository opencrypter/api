<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Type\Scalar;

use Core\Domain\DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeImmutableType;

abstract class DoctrineDateTime extends DateTimeImmutableType
{
    /**
     * Doctrine type name.
     *
     * @return string
     */
    abstract protected function name(): string;

    /**
     * Creates a new instance of a datetime implementation.
     *
     * @param \DateTimeImmutable $value
     * @return DateTime
     */
    abstract protected function newInstance(\DateTimeImmutable $value): DateTime;

    public function getName()
    {
        return $this->name();
    }

    /**
     * @param                  $value
     * @param AbstractPlatform $platform
     * @return mixed|string
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $convertedValue = $value instanceof DateTime ? $value->value() : $value;

        return parent::convertToDatabaseValue($convertedValue, $platform);
    }

    /**
     * @param                  $value
     * @param AbstractPlatform $platform
     * @return DateTime|bool|\DateTime|\DateTimeImmutable|false|mixed
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $convertedValue = parent::convertToPHPValue($value, $platform)) {
            return null;
        }

        return $this->newInstance($convertedValue);
    }
}
