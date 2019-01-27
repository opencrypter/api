<?php
declare(strict_types=1);

namespace Tests\Util\Factory;

use Core\Domain\Order\Step\Type;
use Faker\Factory;

class StepFactory
{
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
