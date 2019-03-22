<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Type\Scalar;

use Core\Domain\ValueObject;
use Core\Infrastructure\Security\CryptoService;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;

abstract class EncryptedString extends StringType
{
    /**
     * @var CryptoService
     */
    private $crypto;

    /**
     * EncryptedString constructor.
     *
     * @param CryptoService $crypto
     */
    public function setCryptoService(CryptoService $crypto)
    {
        $this->crypto = $crypto;
    }

    /**
     * @param CryptoService $cryptoService
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function load(CryptoService $cryptoService): void
    {
        if (! Type::hasType(static::name())) {
            Type::addType(static::name(), static::class);
        }

        /** @var self $type */
        $type = Type::getType(static::name());
        $type->setCryptoService($cryptoService);
    }

    /**
     * Name to be used by Doctrine.
     *
     * @return string
     */
    abstract protected static function name(): string;

    /**
     * Returns a new value object.
     *
     * @param string $value
     * @return ValueObject
     */
    abstract protected function newInstance(string $value): ValueObject;

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::name();
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $plainValue = $value instanceof ValueObject ? $value->value() : $value;
        $encrypted = $this->crypto->encrypt($plainValue);

        return parent::convertToDatabaseValue($encrypted, $platform);
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     * @return ValueObject|mixed|null
     * @throws \Core\Infrastructure\Security\ErrorOnDecryptValue
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        $decrypted = $this->crypto->decrypt($value);

        return $this->newInstance($decrypted);
    }
}
