<?php
declare(strict_types=1);

namespace Tests\Util\Factory;

use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Order\Step\Position;
use Core\Domain\Order\Step\Step;
use Core\Domain\Order\Step\Type;
use Core\Domain\Order\Step\Value;
use Core\Domain\Symbol;
use Faker\Factory;

class StepFactory
{
    public static function create(
        int $position,
        string $type,
        string $exchangeId,
        string $symbol,
        float $value,
        ?int $dependsOf = null
    ): Step {
        return new Step(
            new Position($position),
            new Type($type),
            new ExchangeId($exchangeId),
            new Symbol($symbol),
            new Value($value),
            $dependsOf !== null ? new Position($dependsOf) : null
        );
    }

    public static function random(): Step
    {
        $faker = Factory::create();

        return static::create(
            $faker->numberBetween(1, 10),
            $faker->randomElement(Type::VALID_VALUES),
            $faker->uuid,
            $faker->currencyCode . $faker->currencyCode,
            $faker->numberBetween(0.0001, 3),
            $faker->randomElement([$faker->numberBetween(1, 10), null])
        );
    }

    public static function createArray(
        int $position,
        string $type,
        string $exchangeId,
        string $symbol,
        float $value,
        ?int $dependsOf = null
    ): array {
        return [
            'position'   => $position,
            'type'       => $type,
            'exchangeId' => $exchangeId,
            'symbol'     => $symbol,
            'value'      => $value,
            'dependsOf'  => $dependsOf,
        ];
    }

    public static function randomArray(): array
    {
        $faker = Factory::create();

        return self::createArray(
            $faker->numberBetween(1, 5),
            $faker->randomElement(Type::VALID_VALUES),
            $faker->uuid,
            $faker->currencyCode . $faker->currencyCode,
            $faker->randomFloat(8, 0.0001, 10)
        );
    }
}
