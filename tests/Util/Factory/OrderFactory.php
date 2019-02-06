<?php
declare(strict_types=1);

namespace Tests\Util\Factory;

use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Order\Order;
use Core\Domain\Order\OrderId;
use Core\Domain\Order\Step\Position;
use Core\Domain\Order\Step\Step;
use Core\Domain\Order\Step\Type;
use Core\Domain\Order\Step\Value;
use Core\Domain\Symbol;
use Faker\Factory;

class OrderFactory
{
    public static function create(string $id, array $steps = []): Order
    {
        $steps = array_map(function (array $step) {
            return new Step(
                new Position($step['position']),
                new Type($step['type']),
                new ExchangeId($step['exchangeId']),
                new Symbol($step['symbol']),
                new Value($step['value']),
                $step['dependsOf'] !== null ? new Position($step['dependsOf']) : null
            );
        }, $steps);

        return new Order(new OrderId($id), $steps);
    }

    public static function random(): Order
    {
        $faker = Factory::create();

        $steps = [];
        for ($i = 1; $i <= $faker->numberBetween(1, 5); $i++) {
            $steps[] = StepFactory::randomArray();
        }

        return self::create($faker->uuid, $steps);
    }
}
