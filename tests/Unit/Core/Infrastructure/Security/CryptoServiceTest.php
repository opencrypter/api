<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Infrastructure\Security;

use Core\Infrastructure\Security\CryptoService;
use Core\Infrastructure\Security\ErrorOnDecryptValue;
use Tests\Unit\Core\TestCase;

class CryptoServiceTest extends TestCase
{
    private $service;

    protected function setUp()
    {
        $pair          = sodium_crypto_box_keypair();
        $publicKey     = bin2hex(sodium_crypto_box_publickey($pair));
        $secretKey     = bin2hex(sodium_crypto_box_secretkey($pair));
        $this->service = new CryptoService($publicKey, $secretKey);
    }

    public function testEncryption(): void
    {
        $message   = "Hi, Bob";
        $encrypted = $this->service->encrypt($message);
        $decrypted = $this->service->decrypt($encrypted);

        self::assertNotEquals($message, $encrypted);
        self::assertEquals($message, $decrypted);
    }

    public function testExceptionWhenDecryptionFails(): void
    {
        $this->expectException(ErrorOnDecryptValue::class);
        $this->expectExceptionCode(500);

        $pair          = sodium_crypto_box_keypair();
        $publicKey     = bin2hex(sodium_crypto_box_publickey($pair));
        $secretKey     = bin2hex(sodium_crypto_box_secretkey($pair));
        $encrypted = $this->service->encrypt('Hi, Bob');

        (new CryptoService($publicKey, $secretKey))->decrypt($encrypted);
    }
}
