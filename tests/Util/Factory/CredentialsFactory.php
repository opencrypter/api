<?php
declare(strict_types=1);

namespace Tests\Util\Factory;

use Core\Domain\Credentials\Credentials;
use Core\Domain\Credentials\CredentialsId;
use Core\Domain\Credentials\Key;
use Core\Domain\Credentials\Secret;
use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Name;
use Core\Domain\User\UserId;
use Faker\Factory;

class CredentialsFactory
{
    public static function create(
        string $id,
        string $name,
        string $exchangeId,
        string $key,
        string $secret,
        string $userId
    ): Credentials {
        return new Credentials(
            new CredentialsId($id),
            new Name($name),
            new ExchangeId($exchangeId),
            new Key($key),
            new Secret($secret),
            new UserId($userId)
        );
    }

    public static function random(): Credentials
    {
        $faker = Factory::create();

        return new Credentials(
            new CredentialsId($faker->uuid),
            new Name($faker->word),
            new ExchangeId($faker->uuid),
            new Key($faker->sha256),
            new Secret($faker->sha256),
            new UserId($faker->uuid)
        );
    }
}
