<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Type\Scalar;

use Core\Domain\ValueObject;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

abstract class DoctrineJson extends JsonType
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
     * @param array $json
     * @return ValueObject
     */
    abstract protected function newInstance(array $json): ValueObject;

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

        return $this->newInstance(json_decode($value, true));
    }
}
