<?php
declare(strict_types=1);

namespace Tests\Util\Factory;

use Core\Domain\Exchange\Exchange;
use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Exchange\Name;
use Core\Domain\Exchange\Symbols;
use Faker\Factory;

class ExchangeFactory
{
    public static function create(string $id, string $name, array $symbols): Exchange
    {
        return new Exchange(new ExchangeId($id), new Name($name), new Symbols($symbols));
    }

    public static function random(): Exchange
    {
        $faker = Factory::create();

        $symbols = $faker->randomElements(
            ['BTCUSD', 'ETHUSD', 'XRPUSD', 'XEMUSD'],
            $faker->numberBetween(1, 4)
        );

        return self::create($faker->uuid, $faker->name, $symbols);
    }
}
