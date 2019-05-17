<?php
declare(strict_types=1);

namespace Tests\Util\Factory;

use Core\Domain\Exchange\Exchange;
use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Exchange\Symbols;
use Core\Domain\Name;
use Faker\Factory;

class ExchangeFactory
{
    private static function randomNullable(?string $id, ?string $name, ?array $symbols): Exchange
    {
        $faker = Factory::create();

        $symbols = $symbols
            ?? $faker->randomElements(
                ['BTCUSD', 'ETHUSD', 'XRPUSD', 'XEMUSD'],
                $faker->numberBetween(1, 4)
            );

        return new Exchange(
            new ExchangeId($id ?? $faker->uuid),
            new Name($name ?? $faker->name),
            new Symbols($symbols)
        );
    }

    public static function create(string $id, string $name, array $symbols): Exchange
    {
        return self::randomNullable($id, $name, $symbols);
    }

    public static function random(): Exchange
    {
        return self::randomNullable(null, null, null);
    }

    public static function withName(string $name): Exchange
    {
        return self::randomNullable(null, $name, null);
    }
}
