<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Application\Exchange;

use Core\Application\Exchange\ExchangeDto;
use Core\Application\Exchange\ExchangeDtoAssembler;
use Tests\Util\Factory\ExchangeFactory;
use PHPUnit\Framework\TestCase;

class ExchangeDtoAssemblerTest extends TestCase
{
    public function testAssembler(): void
    {
        $exchange = ExchangeFactory::random();

        $expected = new ExchangeDto(
            $exchange->id()->value(),
            $exchange->name()->value(),
            $exchange->symbols()->toArray()
        );

        self::assertEquals($expected, (new ExchangeDtoAssembler)->writeDto($exchange));
    }
}
