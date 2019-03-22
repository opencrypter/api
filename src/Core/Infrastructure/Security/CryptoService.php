<?php
declare(strict_types=1);

namespace Core\Infrastructure\Security;

class CryptoService
{
    /**
     * @var string
     */
    private $pair;

    /**
     * CryptoService constructor.
     *
     * @param string $publicKey
     * @param string $secretKey
     */
    public function __construct(string $publicKey, string $secretKey)
    {
        $this->pair = \sodium_crypto_box_keypair_from_secretkey_and_publickey(
            \hex2bin($secretKey),
            \hex2bin($publicKey)
        );
    }

    /**
     * @param string $value
     * @return string
     */
    public function encrypt(string $value): string
    {
        $mac = \sodium_crypto_box_seal($value, \sodium_crypto_box_publickey($this->pair));

        return bin2hex($mac);
    }

    /**
     * @param string $value
     * @return string
     * @throws ErrorOnDecryptValue
     */
    public function decrypt(string $value): string
    {
        $decrypted = \sodium_crypto_box_seal_open(\hex2bin($value), $this->pair);

        if ($decrypted === false) {
            throw new ErrorOnDecryptValue($value);
        }

        return $decrypted;
    }
}
