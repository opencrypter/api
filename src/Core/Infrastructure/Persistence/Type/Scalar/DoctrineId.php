<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Type\Scalar;

use Core\Domain\Id;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

abstract class DoctrineId extends GuidType
{
    /**
     * Name to be used by Doctrine.
     *
     * @return string
     */
    abstract protected function name(): string;

    /**
     * Returns a new Id.
     *
     * @param string $value
     * @return Id
     */
    abstract protected function newInstance(string $value): Id;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name();
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $plainValue = $value instanceof Id ? $value->value() : $value;

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
