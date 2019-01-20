<?php
declare(strict_types=1);

namespace Tests\Util\Factory;

use Core\Domain\Exchange\Exchange;
use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Exchange\Name;
use Faker\Factory;

class ExchangeFactory
{
    public static function create(string $id, string $name): Exchange
    {
        return new Exchange(new ExchangeId($id), new Name($name));
    }

    public static function random(): Exchange
    {
        $faker = Factory::create();

        return self::create($faker->uuid, $faker->name);
    }
}
