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
        string $userId,
        bool $withoutEvents = false
    ): Credentials {
        $credentials = new Credentials(
            new CredentialsId($id),
            new Name($name),
            new ExchangeId($exchangeId),
            new Key($key),
            new Secret($secret),
            new UserId($userId)
        );

        if ($withoutEvents) {
            $credentials->releaseEvents();
        }

        return $credentials;
    }

    public static function random(bool $withoutEvents = false): Credentials
    {
        $faker = Factory::create();

        return self::create(
            $faker->uuid,
            $faker->word,
            $faker->uuid,
            $faker->sha256,
            $faker->sha256,
            $faker->uuid,
            $withoutEvents
        );
    }
}
