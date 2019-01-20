<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Type\Scalar;

use Core\Domain\ValueObject;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\FloatType;

abstract class DoctrineFloat extends FloatType
{
    /**
     * Name to be used by Doctrine.
     *
     * @return string
     */
    abstract protected function name(): string;

    /**
     * Returns a new value object.
     *
     * @param float $value
     * @return ValueObject
     */
    abstract protected function newInstance(float $value): ValueObject;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name();
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $plainValue = $value instanceof ValueObject ? $value->value() : $value;

        return parent::convertToDatabaseValue($plainValue, $platform);
    }


    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return $this->newInstance($value);
    }
}
