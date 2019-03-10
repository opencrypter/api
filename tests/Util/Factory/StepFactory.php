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
        return self::withValueObjects(
            new Position($position),
            new Type($type),
            new ExchangeId($exchangeId),
            new Symbol($symbol),
            new Value($value),
            $dependsOf !== null ? new Position($dependsOf) : null
        );
    }

    public static function withValueObjects(
        Position $position,
        Type $type,
        ExchangeId $exchangeId,
        Symbol $symbol,
        Value $value,
        ?Position $dependsOf
    ): Step {
        return new Step($position, $type, $exchangeId, $symbol, $value, $dependsOf);
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

    public static function arrayFromEntity(Step $step): array
    {
        return [
            'position'   => $step->position()->value(),
            'type'       => $step->type()->value(),
            'exchangeId' => $step->exchangeId()->value(),
            'symbol'     => $step->symbol()->value(),
            'value'      => $step->value()->value(),
            'dependsOf'  => $step->dependsOf() ? $step->dependsOf()->value() : null,
        ];
    }

    public static function randomArray(): array
    {
        return self::arrayFromEntity(self::random());
    }

    public static function withPosition(int $position): Step
    {
        $faker = Factory::create();

        return self::create(
            $position,
            $faker->randomElement(Type::VALID_VALUES),
            $faker->uuid,
            $faker->currencyCode . $faker->currencyCode,
            $faker->numberBetween(0.0001, 3),
            $faker->randomElement([$faker->numberBetween(1, 10), null])
        );
    }
}
