<?php
declare(strict_types=1);

namespace Tests\Util\Factory;

use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Order\Order;
use Core\Domain\Order\OrderId;
use Core\Domain\Order\Step\Position;
use Core\Domain\Order\Step\Type;
use Core\Domain\Order\Step\Value;
use Core\Domain\Symbol;
use Faker\Factory;

class OrderFactory
{
    public static function create(string $id, array $steps = []): Order
    {
        $order = new Order(new OrderId($id));

        foreach ($steps as $step) {
            $order->addStep(
                new Position($step['position']),
                new Type($step['type']),
                new ExchangeId($step['exchangeId']),
                new Symbol($step['symbol']),
                new Value($step['value']),
                $step['dependsOf'] !== null ? new Position($step['dependsOf']) : null
            );
        }

        return $order;
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
