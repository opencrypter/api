<?php
declare(strict_types=1);

namespace Tests\Unit\Core;

use Faker\Factory;
use Faker\Generator;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Generator
     */
    private $faker;

    protected function faker(): Generator
    {
        if ($this->faker === null) {
            $this->faker = Factory::create();
        }

        return $this->faker;
    }
}
