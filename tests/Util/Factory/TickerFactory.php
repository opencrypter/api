<?php
declare(strict_types=1);

namespace Tests\Util\Factory;

use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Symbol;
use Core\Domain\Ticker\Price;
use Core\Domain\Ticker\Ticker;
use Core\Domain\Ticker\TickerId;
use Faker\Factory;

class TickerFactory
{
    private static function randomNullable(?string $id, ?string $symbol, ?string $exchangeId, ?float $price): Ticker
    {
        $faker = Factory::create();

        return new Ticker(
            new TickerId($id ?? $faker->uuid),
            new Symbol($symbol ?? $faker->currencyCode),
            new ExchangeId($exchangeId ?? $faker->uuid),
            new Price($price ?? $faker->randomFloat(8, 0, 100))
        );
    }

    public static function create(string $id, string $symbol, string $exchangeId, float $price): Ticker
    {
        return self::randomNullable($id, $symbol, $exchangeId, $price);
    }

    public static function random(): Ticker
    {
        return self::randomNullable(null, null, null, null);
    }

    public static function withExchangeId(string $exchangeId): Ticker
    {
        return self::randomNullable(null, null, $exchangeId, null);
    }

    public static function withIdAndExchangeId(string $tickerId, string $exchangeId): Ticker
    {
        return self::randomNullable($tickerId, null, $exchangeId, null);
    }
}
